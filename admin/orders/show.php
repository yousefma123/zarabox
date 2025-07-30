<?php
    $page_title = "لوحة التحكم | الطلبات";
    require("../init.php");
    use App\Controllers\Order\Order;
    use App\Helpers\Paginator;
    $page_name = "orders.show";
    $order = new Order();
?>

    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-12 sidebar-container">
                <?php include( PUBLIC_PATH . '/components/dashboard/sidebar.php' ); ?>
            </div>
            <div class="col-lg-9 col-md-12">
                <div class="customer-content p-4">
                    <div class="row">
                        
                        <div class="col-md-12 mb-3">
                            <div class="card rounded-4 p-4 h-100">
                                <div class="card-title mb-1 text-center mt-2">
                                    <h5 class="fw-bold card-title-header">الطلبات</h5>
                                </div>
                                
                                <div class="card-body p-1 mt-3 add-new-service overflow-auto">
                                    <?php
                                        // if(isset($_GET['action']) && isset($_GET['id']) && is_numeric($_GET['id'])):
                                        //     if (isset($_GET['action']) && isset($_GET['id'])) {
                                        //         if ($_GET['action'] == 'delete') {
                                        //             $category->delete($_SESSION['token']);
                                        //         }
                                        //     }
                                        // endif;
                                        $paginator = new Paginator("orders", 10);
                                        $data = $statement->getJoinData(
                                            "o.id, o.customer_name, o.city, o.governorate, o.created_at,
                                            COUNT(oi.id) AS total_items,
                                            SUM(oi.quantity * oi.total) AS order_total",
                                            "orders o",
                                            "INNER JOIN order_items oi ON o.id = oi.order_id",
                                            "fetchAll",
                                            "GROUP BY o.id, o.created_at",
                                            "LIMIT ".$paginator->start.", ".$paginator->limit.""
                                        );
                                        if($data['rowCount'] > 0):
                                    ?>
                                            <table class="table table-striped text-center tb-show">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">العميل</th>
                                                        <th scope="col">المحافظة - المدينة</th>
                                                        <th scope="col">عدد المنتجات</th>
                                                        <th scope="col">الإجمالي</th>
                                                        <th scope="col">وقت الطلب</th>
                                                        <th scope="col">التحكم</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach($data['fetchAll'] as $data): ?>
                                                        <tr>
                                                            <td><?= $data['customer_name'] ?></td>
                                                            <td><?= $data['governorate'].' - '.$data['city'] ?></td>
                                                            <td class="fw-bold"><?= $data['total_items'] ?></td>
                                                            <td class="fw-bold"><?= number_format($data['order_total']) ?></td>
                                                            <td><?= $data['created_at'] ?></td>
                                                            <td>
                                                                <a href="view?id=<?= $data['id'] ?>">
                                                                    <button class="btn btn-default bg-primary p-1 ps-2 pe-2 ms-2 rounded-3 border-0"><span class="fa fa-eye"></span></button>
                                                                </a>
                                                                <a href="update?id=<?= $data['id'] ?>">
                                                                    <button class="btn btn-default bg-primary p-1 ps-2 pe-2 ms-2 rounded-3 border-0"><span class="fa fa-edit"></span></button>
                                                                </a>
                                                                <a href="?action=delete&id=<?= $data['id'] ?>" onclick="_confirm(event, 'هل أنت متأكد من حذف القسم ؟')">
                                                                    <button class="btn btn-default bg-danger p-1 ps-2 pe-2 ms-2 rounded-3 border-0"><span class="fa fa-trash"></span></button>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>

                                            <?= $paginator->render() ?>

                                    <?php 
                                        else:
                                            echo '<div class="alert alert-warning rounded-4 shadow-sm">لا يوجد أقسام تمت إضافتها مسبقا</div>';
                                        endif; 
                                    ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

<?php 
    include( PUBLIC_PATH . '/components/dashboard/footer.php' );
    ob_end_flush();
?>