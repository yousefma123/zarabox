<?php
    $page_title = "لوحة التحكم | الأقسام";
    require("../init.php");
    use App\Controllers\Category\Category;
    use App\Helpers\Paginator;
    $page_name = "categories.show";
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
                                            // if($_GET['action'] === 'restore'):
                                            //     require dirname(__DIR__).'/../classes/Employees.php';
                                            //     $datas = new Employees();
                                            //     $datas->_restoreAccount($_GET['id'], $url, $_SESSION['token']);
                                            // elseif($_GET['action'] === 'disable'):
                                            //     require dirname(__DIR__).'/../classes/Employees.php';
                                            //     $datas = new Employees();
                                            //     $datas->_disableAccount($_GET['id'], $url, $_SESSION['token']);
                                            // endif;
                                        endif;
                                        $paginator = new Paginator("categories", 10);
                                        $data = $statement->select("*", "`categories`", "fetchAll", "", "LIMIT ".$paginator->start.", ".$paginator->limit."");
                                        if($data['rowCount'] > 0):
                                    ?>
                                            <table class="table table-striped text-center tb-show">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">اسم القسم عربي</th>
                                                        <th scope="col">اسم القسم إنجليزي</th>
                                                        <th scope="col">تاريخ الإضافة</th>
                                                        <th scope="col">التحكم</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    <?php foreach($data['fetchAll'] as $data): ?>
                                                        <tr>
                                                            <td><?= $data['name_ar'] ?></td>
                                                            <td><?= $data['name_en'] ?></td>
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