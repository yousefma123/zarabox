<?php
    $page_title = "لوحة التحكم | المنتجات";
    require("../init.php");
    use App\Controllers\Admin\Product\Product;
    use App\Helpers\Paginator;
    $page_name = "products.show";
    $product = new Product();
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
                                    <h5 class="fw-bold card-title-header">المنتجات</h5>
                                </div>
                                
                                <div class="card-body p-1 mt-3 add-new-service overflow-auto">
                                    <?php
                                        if(isset($_GET['action']) && isset($_GET['id']) && is_numeric($_GET['id'])):
                                            if (isset($_GET['action']) && isset($_GET['id'])) {
                                                if ($_GET['action'] == 'delete') {
                                                    $product->delete($_SESSION['token']);
                                                }
                                            }
                                        endif;
                                        $paginator = new Paginator("products", 10);
                                        $data = $statement->getJoinData(
                                            "`products`.*, `categories`.name_ar AS category_name",
                                            "`products`",
                                            "INNER JOIN `categories` ON `categories`.id = `products`.category",
                                            "fetchAll",
                                            "",
                                            "LIMIT ".$paginator->start.", ".$paginator->limit.""
                                        );
                                        if($data['rowCount'] > 0):
                                    ?>
                                            <table class="table table-striped text-center tb-show">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">اسم المنتج</th>
                                                        <th scope="col">القسم</th>
                                                        <th scope="col">السعر</th>
                                                        <th scope="col">تاريخ الإضافة</th>
                                                        <th scope="col">التحكم</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    <?php foreach($data['fetchAll'] as $data): ?>
                                                        <tr>
                                                            <td><?= $data['name'] ?></td>
                                                            <td><?= $data['category_name'] ?></td>
                                                            <td><?= $data['price'] ?></td>
                                                            <td><?= $data['created_at'] ?></td>
                                                            <td>
                                                                <a href="<?= $_ENV['WEB_URL'] ?>/product?n=<?= str_replace([' ',',','.', '@','،'], '-', $data['name']) ?>&id=<?= $data['id'] ?>" target="_blank" class="category-item">   
                                                                    <button class="btn btn-default bg-primary p-1 ps-2 pe-2 ms-2 rounded-3 border-0"><span class="fa fa-eye"></span></button>
                                                                </a>
                                                                <a href="update?id=<?= $data['id'] ?>">
                                                                    <button class="btn btn-default bg-primary p-1 ps-2 pe-2 ms-2 rounded-3 border-0"><span class="fa fa-edit"></span></button>
                                                                </a>
                                                                <a href="?action=delete&id=<?= $data['id'] ?>" onclick="_confirm(event, 'هل أنت متأكد من حذف المنتج ؟')">
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
                                            echo '<div class="alert alert-warning rounded-4 shadow-sm">لا يوجد منتجات تمت إضافتها مسبقا</div>';
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