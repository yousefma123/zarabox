<?php
    require("init.php");
    use App\Helpers\Statement;
    $page_title = "لوحة التحكم | الرئيسية";
    $page_name = "home";
    $dash = true;
    require( PUBLIC_PATH . '/components/dashboard/header.php' );
    include( PUBLIC_PATH . '/components/dashboard/navbar.php' );
    $statement = new Statement();
?>

    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-12 sidebar-container">
                <?php include( PUBLIC_PATH . '/components/dashboard/sidebar.php' ); ?>
            </div>
            <div class="col-lg-9 col-md-12">
                <div class="customer-content p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="fw-bold mb-4">الرئيسية</h4>
                    </div>
                    <div class="row">

                        <div class="col-md-12 mb-3">
                            <div class="card rounded-4 p-4 h-100">
                                <div class="card-body p-1 d-flex justify-content-between flex-column">
                                    <div class="card-user-info d-flex justify-content-between flex-wrap">
                                        <div class="d-flex gap-3 flex-wrap flex-grow-1 mb-3">
                                            <img class="rounded-circle" widht="65" height="65" src="<?= public_url('uploads/logos/') . $statement->select('value', 'settings', 'fetch', "WHERE `key` = 'logo'")['fetch']['value'] ?>" alt="ZaraBox">
                                            <div class="mt-2">
                                                <h5 class="fw-bold card-title-header mb-1">ZaraBox Store</h5>
                                                <a href="#" class="card-title-header fs-7">admin@zarabox.com</a>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <!-- <a href="profile" class="btn btn-default rounded-pill fs-7 fw-bold ms-2">تعديل الحساب</a>
                                            <a href="profile" class="btn btn-default rounded-circle fw-bold" style="padding:7px 10px;"><span class="fa fa-gear"></span></a> -->
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-4 col-4">
                                             <span class="fs-5 card-title-header fw-bold ms-1"><?= @number_format($statement->select("COUNT(`id`)", "`branches`", "fetch")['fetch']['COUNT(`id`)']) ?></span> 
                                             <span class="text-muted">منتجات</span>
                                        </div>
                                        <div class="col-md-4 col-4">
                                             <span class="fs-5 card-title-header fw-bold ms-1"><?= @number_format($statement->select("COUNT(`id`)", "`job_applications`", "fetch")['fetch']['COUNT(`id`)']) ?></span> 
                                             <span class="text-muted">طلبات</span>
                                        </div>
                                    </div>
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
?>