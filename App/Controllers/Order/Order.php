<?php

namespace App\Controllers\Order;
require_once __DIR__ . '/../../../shared/bootstrap.php';

use App\Database\Connection;
use App\Controllers\Telegram\Telegram;
use App\Helpers\Statement;
use App\Helpers\Alert;
use PDO;

class Order
{
    protected $conn;
    protected $statement;
    protected $alert;
    protected $telegram;

    public function __construct()
    {
        $this->conn     = (new Connection())->DB;
        $this->statement= new Statement();
        $this->alert    = new Alert();
        $this->telegram = new Telegram();
    }

    public function index()
    {
        //
    }

    public function create()
    {
        if (!isset($_SESSION['token']) || $_POST['token'] != $_SESSION['token']) return;
        $errors = [];

        $product_ids        = $_POST['ids'];
        $product_sizes      = $_POST['sizes'];
        $product_quantities = $_POST['quantities'];
        $product_prices = [];

        $stmt = $this->conn->prepare("SELECT `sizes`, `name`, `price` FROM `products` WHERE id = ?");

        if (!is_array($product_ids) || !is_array($product_sizes)) {
            $errors[] = "بيانات المنتجات غير صالحة.";
        } else {
            $count = count($product_ids);
            for ($i = 0; $i < $count; $i++) {
                $id   = trim(strip_tags($product_ids[$i] ?? ''));
                $size = trim(strip_tags($product_sizes[$i] ?? ''));

                if (empty($id) || empty($size)) {
                    $errors[] = "المنتج أو المقاس غير محدد للعنصر رقم " . ($i + 1);
                    break;
                }

                if (!isset($product_quantities[$i])) {
                    $errors[] = "بيانات المنتجات غير صالحة.";
                    break;
                }

                $stmt->execute([$id]);
                $product = $stmt->fetch();

                if (!$product) {
                    $errors[] = "المنتج برقم $id غير موجود.";
                    break;
                }

                $allowed_sizes = explode(',', $product['sizes']);
                $allowed_sizes = array_map('trim', $allowed_sizes);

                if (!in_array($size, $allowed_sizes)) {
                    $errors[] = "المقاس المختار غير متاح لمنتج (".$product['name'].")";
                } else {
                    $product_prices[$i] = $product['price'] * $product_quantities[$i];
                }
            }
        }

        $email = trim(strip_tags($_POST['email'] ?? ''));
        if (empty($email)) {
            $errors[] = "برجاء إدخال البريد الإلكتروني";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "البريد الإلكتروني غير صالح";
        }

        $phone = trim(strip_tags($_POST['phone'] ?? ''));
        if (empty($phone)) {
            $errors[] = "برجاء إدخال رقم الجوال";
        } elseif (!preg_match('/^[0-9]{9,15}$/', $phone)) {
            $errors[] = "رقم الجوال غير صحيح";
        }

        $firstname = trim(strip_tags($_POST['firstname'] ?? ''));
        if (empty($firstname)) {
            $errors[] = "برجاء إدخال الاسم الأول";
        }

        $lastname = trim(strip_tags($_POST['lastname'] ?? ''));
        if (empty($lastname)) {
            $errors[] = "برجاء إدخال الاسم الأخير";
        }

        $company = trim(strip_tags($_POST['company'] ?? ''));

        $address = trim(strip_tags($_POST['address'] ?? ''));
        if (empty($address)) {
            $errors[] = "برجاء إدخال العنوان";
        }

        $city = trim(strip_tags($_POST['city'] ?? ''));
        if (empty($city)) {
            $errors[] = "برجاء إدخال المدينة";
        }

        $governorate = trim(strip_tags($_POST['governorate'] ?? ''));
        if (empty($governorate)) {
            $errors[] = "برجاء اختيار المحافظة";
        }

        $postalcode = trim(strip_tags($_POST['postalcode'] ?? ''));
        if (!empty($postalcode) && !preg_match('/^[0-9]{4,10}$/', $postalcode)) {
            $errors[] = "الرمز البريدي غير صحيح";
        }

        if (empty($errors)) {
            try {
                $this->conn->beginTransaction();
                $total = 0;
            
                $stmtOrder = $this->conn->prepare("
                    INSERT INTO orders 
                    (code, company, customer_name, email, phone, address, city, governorate, postalcode, total, created_at)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
                ");
                
                $code = self::generateCode();
                $stmtOrder->execute([
                    $code, $company, $firstname.' '.$lastname, $email, $phone, $address, $city, $governorate, $postalcode, $total
                ]);
            
                $order_id = $this->conn->lastInsertId();
            
                $stmtItem = $this->conn->prepare("
                    INSERT INTO order_items
                    (order_id, product_id, size, quantity, total)
                    VALUES (?, ?, ?, ?, ?)
                ");
            
                foreach ($product_ids as $index => $product_id) {
                    $size     = $product_sizes[$index] ?? '';
                    $quantity = (int)($product_quantities[$index] ?? 0);
                    $price    = isset($product_prices[$index]) ? (float)$product_prices[$index] : 0;
                    $total   += $price * $quantity;

                    $item_total = $price;

                    $stmtItem->execute([
                        $order_id,
                        $product_id,
                        $size,
                        $quantity,
                        $item_total
                    ]);
                }
            
                $this->conn->commit();
            
                $_SESSION['completed_order'] = $order_id;

                $link = $_ENV['WEB_URL'] . '/admin/orders?id=' . $order_id;

                $message = "✅ <b>لديك طلب جديد مكتمل</b>\n"
                        . "<b>رقم الطلب:</b> #$code\n"
                        . "<b>اسم العميل:</b> $firstname $lastname\n"
                        . "<b>رقم الجوال:</b> <code>$phone</code>\n\n"
                        . "<a href=\"$link\">🛒 متابعة الطلب</a>";

                $this->telegram->newOrder($message);

                header('Location: success');
                exit;
            
            } catch (Exception $e) {
                $pdo->rollBack();
                echo "Failed to create order: " . $e->getMessage();
            }
        } else {
            $this->alert->push($errors[0], 'error');
        }
    }

    protected function generateCode(): String {
        return strtoupper(bin2hex(random_bytes(8)));
    }

    
    public function tracking()
    {
        if (!isset($_GET['code']) || empty($_GET['code'])) {
            header('Location: 404.html');
            exit;
        }
    
        $code = trim(strip_tags($_GET['code']));
    
        $order = $this->statement->select("*", "`orders`", "fetch", "WHERE `code` = '$code'", "LIMIT 1");
    
        if ($order['rowCount'] != 1) {
            header('Location: 404.html');
            exit;
        }

        $order = $order['fetch'];

        $items = $this->conn->prepare("
            SELECT 
                oi.product_id,
                p.name AS product_name,
                oi.size,
                oi.quantity,
                oi.total,
                img.image
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            LEFT JOIN (
                SELECT product, image
                    FROM product_images
                    GROUP BY product
            ) img ON img.product = p.id
            WHERE oi.order_id = ?
        ");

        $items->execute([$order['id']]);
        $items = $items->fetchAll(PDO::FETCH_ASSOC);
        if (!$items || empty($items)) {
            header('Location: 404.html');
            exit;
        }

        $order['items'] = $items;
        return $order;
    }
    

    public function delete($token)
        {
            if (!isset($token) || $token != $_SESSION['token']) return false;
        
            $delete = $this->conn->prepare("DELETE FROM `orders` WHERE `id` = ? LIMIT 1");
            $delete->execute([$_GET['id']]);
            if($delete->rowCount() == 1){
                $this->alert->push('تم حذف الطلب بنجاح');
            }
    }

    public function update()
    {
        //
    }
}