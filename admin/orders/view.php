<?php
    $page_title = "لوحة التحكم | الطلبات";
    require("../init.php");
    use App\Controllers\Order\Order;
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
                    <?php
                        if(isset($_GET['id'])):
                            $id = $_GET['id'];
                            $data = $statement->getJoinData(
                                "o.id, 
                                 o.code, 
                                 o.customer_name, 
                                 o.postalcode, 
                                 o.address, 
                                 o.company, 
                                 o.phone, 
                                 o.email, 
                                 o.city, 
                                 o.governorate, 
                                 o.created_at,
                                 COUNT(oi.id) AS total_items,
                                 SUM(oi.quantity * oi.total) AS order_total,
                                 GROUP_CONCAT(DISTINCT p.name SEPARATOR ', ') AS products",
                                "orders o",
                                "INNER JOIN order_items oi ON o.id = oi.order_id
                                 INNER JOIN products p ON oi.product_id = p.id",
                                "fetch",
                                "WHERE o.id = $id",
                                "GROUP BY o.id, o.created_at",
                            );
                            if($data['rowCount'] == 1):

                    ?>
                                <div class="col-12 mb-4 d-flex flex-wrap justify-content-between gap-2 align-items-center">
                                    <div class="h4 fw-bold"> 
                                        طلب رقم: #<?= $data['fetch']['code'] ?>
                                    </div>
                                    <div class="text-muted fw-bold"><?= $data['fetch']['created_at'] ?></div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="card rounded-5 p-4 h-100 task-card">
                                        <div class="card-title mb-1 d-flex justify-content-between align-items-center flex-wrap gap-3">
                                            <h6 class="fw-bold card-title-header m-0">اسم العميل</h6>
                                            <?= $data['fetch']['customer_name'] ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card rounded-5 p-4 h-100 task-card">
                                        <div class="card-title mb-1 d-flex justify-content-between align-items-center flex-wrap gap-3">
                                            <h6 class="fw-bold card-title-header m-0">المحافظة</h6>
                                            <?= $data['fetch']['governorate'] ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card rounded-5 p-4 h-100 task-card">
                                        <div class="card-title mb-1 d-flex justify-content-between align-items-center flex-wrap gap-3">
                                            <h6 class="fw-bold card-title-header m-0">المدينة</h6>
                                            <?= $data['fetch']['city'] ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card rounded-5 p-4 h-100 task-card">
                                        <div class="card-title mb-1 d-flex justify-content-between align-items-center flex-wrap gap-3">
                                            <h6 class="fw-bold card-title-header m-0">البريد الإلكتروني</h6>
                                            <a href="emailto:<?= $data['fetch']['email'] ?>"><?= $data['fetch']['email'] ?></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card rounded-5 p-4 h-100 task-card">
                                        <div class="card-title mb-1 d-flex justify-content-between align-items-center flex-wrap gap-3">
                                            <h6 class="fw-bold card-title-header m-0">رقم الجوال</h6>
                                            <a href="tel:<?= $data['fetch']['phone'] ?>"><?= $data['fetch']['phone'] ?></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card rounded-5 p-4 h-100 task-card">
                                        <div class="card-title mb-1 d-flex justify-content-between align-items-center flex-wrap gap-3">
                                            <h6 class="fw-bold card-title-header m-0">الشركة</h6>
                                            <?= $data['fetch']['company'] ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card rounded-5 p-4 h-100 task-card">
                                        <div class="card-title mb-1 d-flex justify-content-between align-items-center flex-wrap gap-3">
                                            <h6 class="fw-bold card-title-header m-0">الرمز البريدي</h6>
                                            <?= $data['fetch']['postalcode'] ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="card rounded-5 p-4 h-100 task-card">
                                        <div class="card-title mb-1 d-flex justify-content-between align-items-center flex-wrap gap-3">
                                            <h6 class="fw-bold card-title-header m-0">العنوان</h6>
                                        </div>
                                        <div class="card-body">
                                            <?= $data['fetch']['address'] ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                                    
                    <?php 
                        endif;
                    endif;
                    ?>

                    </div>
                </div>
            </div>
        </div>
    </div>


<?php 
    include( PUBLIC_PATH . '/components/dashboard/footer.php' );
    ob_end_flush();
?>