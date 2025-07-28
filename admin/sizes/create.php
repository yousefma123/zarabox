<?php
    $page_title = "لوحة التحكم | المقاسات والأحجام";
    require("../init.php");
    use App\Controllers\Sizes\Sizes;
    $page_name = "sizes.create";
    $sizes = new Sizes();
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
                                    <h5 class="fw-bold card-title-header">أضف النوع الآن</h5>
                                    <p class="text-small text-muted">يرجى مراعاة إدخال الحقول الإجبارية كاملة </p>
                                </div>
                                <?php
                                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) $size->create();
                                ?>
                                <div class="card-body p-1 mt-3 add-new-service">
                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="token" class="form-control" value="<?= $_SESSION['token'] ?>">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="fs-7 fw-bold" for="">اسم النوع *</label>
                                                        <input type="text" name="name" class="form-control mt-3 rounded-4 bg-ddd" placeholder="الاسم" required>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="fs-7 fw-bold" for="">المقاسات *</label>
                                                        <div class="row align-items-center">
                                                            <div class="col-md-11">
                                                                <div class="row" id="addNewInput">
                                                                    <div class="col-md-12">
                                                                        <input type="text" name="sizes[]" class="form-control mt-3 rounded-4 bg-ddd" placeholder="المقاس - size">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1">
                                                                <button type="button" class="btn btn-primary rounded-4 w-100 repeated-inputs shadow-sm" onclick="_add_other_inputs()">+</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-4">
                                                <button type="submit" name="create" class="btn btn-default w-100 rounded-pill p-3 btn-bg-system fw-bold shadow-sm">أضف المنتج</button>
                                            </div>
                                        </div>
                                    </form>
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