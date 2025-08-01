<?php
    $page_title = "لوحة التحكم | الطلبات";
    require("../init.php");
    use App\Controllers\Admin\Order\Order;
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
                                        if(isset($_GET['action']) && isset($_GET['id']) && is_numeric($_GET['id'])):
                                            if (isset($_GET['action']) && isset($_GET['id'])) {
                                                if ($_GET['action'] == 'delete') {
                                                    $order->delete($_SESSION['token']);
                                                }
                                            }
                                        endif;
                                        $paginator = new Paginator("orders", 10);
                                        $data = $statement->getJoinData(
                                            "o.id, o.customer_name, o.city, o.governorate, o.created_at,
                                            COUNT(oi.id) AS total_items,
                                            SUM(oi.total) AS order_total",
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
                                                            <td class="fw-bold"><?= number_format($data['order_total'] + 100) ?></td>
                                                            <td><?= $data['created_at'] ?></td>
                                                            <td>
                                                                <a href="view?id=<?= $data['id'] ?>">
                                                                    <button class="btn btn-default bg-primary p-1 ps-2 pe-2 ms-2 rounded-3 border-0"><span class="fa fa-eye"></span></button>
                                                                </a>
                                                                <button onclick="toggleOrderStatusSidebar(this, '<?= $data['id'] ?>')" class="btn btn-default bg-warning p-1 ps-2 pe-2 ms-2 rounded-3 border-0"><span class="fa fa-pen"></span></button>
                                                                <a href="?action=delete&id=<?= $data['id'] ?>" onclick="_confirm(event, 'هل أنت متأكد من حذف الطلب ؟')">
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
                                            echo '<div class="alert alert-warning rounded-4 shadow-sm">لا يوجد طلبات تمت إضافتها مسبقا</div>';
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

    <!--  -->
    <div class="overlay"></div>
    <div class="sidebar-order sign-tap rounded-4 p-4 position-fixed shadow-lg" id="statusChanger">
        <div class="text-left mb-4"><span onclick="toggleOrderStatusSidebar(this)" class="fa fa-times shadow-sm rounded-3"></span></div>
        <form method="POST">
            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
            <div class="text-muted mb-3 fw-bold text-center">هل تحتوي القضية على ملفات تود إرفاقها ؟</div>
            <input type="hidden" class="form-control bg-ddd border-0 shadow-sm order_id" readonly disabled>
            <select name="status" class="form-control" id="orderStatusInput">
                <option value="">اختر الحالة</option>
                <option value="2">قيد المراجعة</option>
                <option value="2">تم التأكيد</option>
                <option value="3">جاري التجهيز</option>
                <option value="3">جاهز للشحن</option>
                <option value="3">تم الشحن</option>
                <option value="3">جاري التوصيل</option>
                <option value="3">تم التسليم</option>
                <option value="3">مرتجع - العميل رفض الاستلام</option>
                <option value="3">مرتجع - العميل لم يرد على الاتصالات</option>
                <option value="3">تم الإلغاء من قبل العميل</option>
                <option value="3">تم الإلغاء لعدم توفر المنتج</option>
            </select>
        </form>
    </div>
    <!--  -->


    <script>
        const toggleOrderStatusSidebar = (elem, id = null) => {
            const sidebar = document.getElementById('statusChanger')
            sidebar.classList.toggle('sidebar-orders-toggle')
            document.querySelector('.overlay').classList.toggle('overlay-toggled');
            if (!id) return;
            sidebar.querySelector('.order_id').value = id
        }
    </script>

<?php 
    include( PUBLIC_PATH . '/components/dashboard/footer.php' );
    ob_end_flush();
?>