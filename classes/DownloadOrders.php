<?php
ini_set('display_errors', 1);  // Show errors for debugging
ob_clean();  // Clear any prior output
flush();     // Flush the buffer

require dirname(__DIR__)."/vendor/autoload.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

@session_start();

class DownloadOrders {
    public $conn, $Functions;

    public function __construct()
    {
        require_once ('Connection.php');
        require_once ('Functions.php');
        $connection = new Connection(); 
        $this->conn = $connection->DB;
        $this->Functions = new Functions();
    }

    public function _index($token, $branch = null)
    {
        if((!isset($token) || $token != @$_SESSION['token'])) return;

        $errors = [];

        if (!isset($_GET['from']) || empty($_GET['from'])) {
            $errors[] .= "برجاء إدخال تاريخ بداية البحث";
        }

        if (!isset($_GET['to']) || empty($_GET['to'])) {
            $errors[] .= "برجاء إدخال تاريخ نهاية البحث";
        }

        if (empty($errors)) {
            // Format the date parameters
            $from = date('Y-m-d', strtotime($_GET['from']));
            $to = date('Y-m-d', strtotime($_GET['to']));

            // Prepare the SQL query
            if (is_null($branch)) {
                $stmt = $this->conn->prepare("SELECT
                                                    `orders`.*,
                                                    `branches`.name AS branch_name,
                                                    `customers`.name AS client_name,
                                                    `employees`.name AS driver_name
                                                FROM
                                                    `orders`
                                                INNER JOIN `branches` ON `branches`.id = `orders`.branch
                                                INNER JOIN `customers` ON `customers`.id = `orders`.customer
                                                LEFT JOIN `employees` ON `employees`.id = `orders`.driver
                                                WHERE (`orders`.created_date BETWEEN ? AND ?)");
                $stmt->execute([$from, $to]);
            } else {
                $stmt = $this->conn->prepare("SELECT
                                                    `orders`.*,
                                                    `branches`.name AS branch_name,
                                                    `customers`.name AS client_name,
                                                    `employees`.name AS driver_name
                                                FROM
                                                    `orders`
                                                INNER JOIN `branches` ON `branches`.id = `orders`.branch
                                                INNER JOIN `customers` ON `customers`.id = `orders`.customer
                                                LEFT JOIN `employees` ON `employees`.id = `orders`.driver
                                                WHERE (`orders`.created_date BETWEEN ? AND ?) AND `orders`.branch = ?");
                $stmt->execute([$from, $to, $branch]);
            }

            // Check if any data was returned
            if ($stmt->rowCount() > 0) {
                // Set the headers to force a download
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="orders_' . $from . '_to_' . $to . '.xlsx"');
                header('Cache-Control: max-age=0');

                // Create the spreadsheet
                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();
                $sheet->setCellValue('A1', 'رقم الطلب');
                $sheet->setCellValue('B1', 'الفرع');
                $sheet->setCellValue('C1', 'العميل');
                $sheet->setCellValue('D1', 'السائق');
                $sheet->setCellValue('E1', 'حالة الطلب');
                $sheet->setCellValue('F1', 'تاريخ الإضافة');
                $sheet->setCellValue('G1', 'تاريخ التوصيل');
                $sheet->setCellValue('H1', 'ملاحظات قبل التوصيل');
                $sheet->setCellValue('I1', 'ملاحظات بعد التوصيل');

                // Loop through the data and populate the Excel sheet
                foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row => $order) {
                    $iteration = $row + 2;
                    $status = $this->mapStatus($order['status']);
                    $sheet->setCellValue('A' . ($iteration), $order['id']);
                    $sheet->setCellValue('B' . ($iteration), $order['branch_name']);
                    $sheet->setCellValue('C' . ($iteration), $order['client_name']);
                    $sheet->setCellValue('D' . ($iteration), $order['driver_name'] ?? '-');
                    $sheet->setCellValue('E' . ($iteration), $status ?? '-');
                    $sheet->setCellValue('F' . ($iteration), $order['created_date']);
                    $sheet->setCellValue('G' . ($iteration), $order['delivery_date']);
                    $sheet->setCellValue('H' . ($iteration), $order['notes_before']);
                    $sheet->setCellValue('I' . ($iteration), $order['notes_after']);
                }

                // Save to output
                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
                exit();  // Ensure no further output is sent
            } else {
                echo "<div class='alert alert-warning rounded-3 shadow-sm'>لا يوجد نتائج وفقا للبيانات المدخلة</div>";
            }
        } else {
            echo "<div class='alert alert-warning rounded-3 shadow-sm'>" . implode("<br>", $errors) . "</div>";
        }
    }

    private function mapStatus($status)
    {
        switch ($status) {
            case "0": return "بانتظار موافقة المندوب";
            case "1": return "جاري التوصيل";
            case "2": return "تم التوصيل";
            default: return "-";
        }
    }
}
