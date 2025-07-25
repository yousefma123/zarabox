<?php
    require("../init.php");
    use App\Helpers\Statement;
    $page_title = "لوحة التحكم | الأقسام";
    $page_name = "categories.show";
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
                    <div class="row">
                        
                        <div class="col-md-12 mb-3">
                            <div class="card rounded-4 p-4 h-100">
                                <div class="card-title mb-1 text-center mt-2">
                                    <h5 class="fw-bold card-title-header">الأقسام</h5>
                                </div>
                                
                                <div class="card-body p-1 mt-3 add-new-service overflow-auto">
                                    <?php
                                        if(isset($_GET['action']) && isset($_GET['id']) && is_numeric($_GET['id'])):
                                            if($_GET['action'] === 'restore'):
                                                require dirname(__DIR__).'/../classes/Employees.php';
                                                $Employees = new Employees();
                                                $Employees->_restoreAccount($_GET['id'], $url, $_SESSION['token']);
                                            elseif($_GET['action'] === 'disable'):
                                                require dirname(__DIR__).'/../classes/Employees.php';
                                                $Employees = new Employees();
                                                $Employees->_disableAccount($_GET['id'], $url, $_SESSION['token']);
                                            endif;
                                        endif;
                                        $getEmployees = $statement->getJoinData(
                                            "`employees`.*, `structures`.name AS structure_name, `branches`.name AS branch_name",
                                            "`employees`",
                                            "INNER JOIN `structures` ON `structures`.id = `employees`.structure
                                            INNER JOIN `branches` ON `branches`.id = `employees`.branch",
                                            "fetchAll",
                                            "WHERE `employees`.status != 2"
                                        );
                                        if($getEmployees['rowCount'] > 0):
                                    ?>
                                            <table class="table table-striped text-center tb-show">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">اسم الموظف</th>
                                                        <th scope="col">القسم</th>
                                                        <th scope="col">الفرع</th>
                                                        <th scope="col">كود التفعيل</th>
                                                        <th scope="col">تاريخ الإضافة</th>
                                                        <th scope="col">التحكم</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    <?php
                                                        foreach($getEmployees['fetchAll'] as $employee){
                                                    ?>
                                                        <tr>
                                                            <td><?= $employee['first_name'].' '.$employee['middel_name'].' '.$employee['last_name'] ?></td>
                                                            <td><?= $employee['structure_name'] ?></td>
                                                            <td><?= $employee['branch_name'] ?></td>
                                                            <td class="fw-bold"><?= $employee['verify_code'] ?></td>
                                                            <td><?= $employee['created_date'] ?></td>
                                                            <td>
                                                                <a href="show-employee?id=<?= $employee['id'] ?>">
                                                                    <button class="btn btn-default bg-primary p-1 ps-2 pe-2 ms-2 rounded-3 border-0"><span class="fa fa-eye"></span></button>
                                                                </a>
                                                                <a href="update?id=<?= $employee['id'] ?>">
                                                                    <button class="btn btn-default bg-primary p-1 ps-2 pe-2 ms-2 rounded-3 border-0"><span class="fa fa-edit"></span></button>
                                                                </a>
                                                                <button onclick="_restoreAccount(this)" data-id="<?= $employee['id'] ?>" class="btn btn-default bg-primary text-white p-1 ps-2 pe-2 ms-2 rounded-3 border-0">
                                                                    استعادة
                                                                    <span class="fa fa-spinner fa-spin me-2" style="display:none;"></span>
                                                                </button>
                                                                <a href="?action=disable&id=<?= $employee['id'] ?>" onclick="_confirm(event, 'هل أنت متأكد من حذف الموظف ؟')">
                                                                    <button class="btn btn-default bg-danger p-1 ps-2 pe-2 ms-2 rounded-3 border-0"><span class="fa fa-trash"></span></button>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                    <?php 
                                        else:
                                            echo '<div class="alert alert-warning rounded-4 shadow-sm">لا يوجد موظف تمت إضافته مسبقا</div>';
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