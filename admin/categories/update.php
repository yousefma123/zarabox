<?php
    require dirname(__DIR__)."/init.php";
    $page_title = "لوحة التحكم | الموظفين";
    $page_name = "employees";
    require dirname(__DIR__).'/../includes/components/header.php';
?>

<?php 
    include dirname(__DIR__).'/../includes/components/menus.php';
    include dirname(__DIR__).'/completeAccount.php';
?>

            
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-12 sidebar-container">
                <?php include dirname(__DIR__).'/../includes/components/admin-sidebar.php'; ?>
            </div>
            <div class="col-lg-9 col-md-12">
                <div class="customer-content p-4">
                    <div class="row"> 
                        <?php
                            if(isset($_GET['id']) && is_numeric($_GET['id'])):
                                $employeeid = $_GET['id'];
                                if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])):
                                    $data = [
                                        "id"            => $employeeid,
                                        "first_name"    => $_POST['first_name'],
                                        "middel_name"   => $_POST['middel_name'],
                                        "last_name"     => $_POST['last_name'],
                                        "phone"         => $_POST['phone']
                                    ];
                                    require dirname(__DIR__).'/../classes/Employees.php';
                                    $Employees = new Employees();
                                    $Employees->_updateEmployee($data, $_POST['token']);
                                endif;
                                $getEmployee = $Functions->_getJoinData(
                                    "`jobs`.*, `employees`.*",
                                    "`employees`",
                                    "INNER JOIN `jobs` ON `jobs`.id = `employees`.job",
                                    "fetch",
                                    "WHERE `employees`.id = $employeeid"
                                );
                                if($getEmployee['rowCount'] == 1):
                        ?>

                        <div class="col-md-12 mb-3">
                            <div class="card rounded-4 p-4 h-100">
                                <div class="card-title mb-1 text-center mt-2">
                                    <h5 class="fw-bold card-title-header">تعديل بيانات الموظف (<?= $getEmployee['fetch']['first_name'].' '.$getEmployee['fetch']['middel_name'].' '.$getEmployee['fetch']['last_name'] ?>)</h5>
                                    <p class="text-small text-muted">يرجى مراعاة إدخال الحقول الإجبارية كاملة </p>
                                </div>
                                <div class="card-body p-1 mt-3 add-new-service">
                                    <form method="POST">
                                        <input type="hidden" name="token" class="form-control" value="<?= $_SESSION['token'] ?>">
                                        <div class="row">
                                            <div class="col-12 mt-2">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label class="fs-7 fw-bold" for="">الاسم الأول *</label>
                                                        <input type="text" name="first_name" class="form-control mt-3 rounded-4 bg-ddd" value="<?= $getEmployee['fetch']['first_name'] ?>" placeholder="الاسم الأول" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="fs-7 fw-bold" for="">الاسم الأوسط *</label>
                                                        <input type="text" name="middel_name" class="form-control mt-3 rounded-4 bg-ddd" value="<?= $getEmployee['fetch']['middel_name'] ?>" placeholder="الاسم الأوسط" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="fs-7 fw-bold" for="">الاسم الأخير *</label>
                                                        <input type="text" name="last_name" class="form-control mt-3 rounded-4 bg-ddd" value="<?= $getEmployee['fetch']['last_name'] ?>" placeholder="الاسم الأخير" required>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="fs-7 fw-bold" for="">رقم الجوال *</label>
                                                        <input type="tel" name="phone" class="form-control mt-3 rounded-4 bg-ddd" value="<?= $getEmployee['fetch']['phone'] ?>" placeholder="رقم الجوال">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-4">
                                                <button type="submit" name="update" class="btn btn-default w-100 rounded-pill p-3 btn-bg-system fw-bold shadow-sm">تعديل بيانات الموظف</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <?php endif; endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php 
    include dirname(__DIR__).'/../includes/components/footer.php';
?>