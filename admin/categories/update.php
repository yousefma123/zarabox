<?php
    $page_title = "لوحة التحكم | الأقسام";
    require("../init.php");
    use App\Controllers\Admin\Category\Category;
    $page_name = "categories.show";
    $category = new Category();
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
                            if(isset($_GET['id']) && is_numeric($_GET['id'])):
                                $id = $_GET['id'];
                                if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])):
                                    $category->update();
                                endif;
                                $data = $statement->select("*", "`categories`", "fetch", "WHERE `id` = $id");
                                if($data['rowCount'] == 1):
                        ?>

                        <div class="col-md-12 mb-3">
                            <div class="card rounded-4 p-4 h-100">
                                <div class="card-title mb-1 text-center mt-2">
                                    <h5 class="fw-bold card-title-header">تعديل قسم (<?= $data['fetch']['name_ar'] ?>)</h5>
                                    <p class="text-small text-muted">يرجى مراعاة إدخال الحقول الإجبارية كاملة </p>
                                </div>
                                <div class="card-body p-1 mt-3 add-new-service">
                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="token" class="form-control" value="<?= $_SESSION['token'] ?>">
                                        <input type="hidden" name="oldCover" class="form-control mt-3 rounded-4 bg-ddd" value="<?= $data['fetch']['cover'] ?>">
                                        <div class="row">
                                            <div class="col-12 mt-2">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="fs-7 fw-bold" for="">اسم القسم عربي *</label>
                                                        <input type="text" name="name_ar" class="form-control mt-3 rounded-4 bg-ddd" placeholder="الاسم عربي" value="<?= $data['fetch']['name_ar'] ?>" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="fs-7 fw-bold" for="">اسم القسم إنجليزي</label>
                                                        <input type="text" name="name_en" class="form-control mt-3 rounded-4 bg-ddd" placeholder="الاسم إنجليزي" value="<?= $data['fetch']['name_en'] ?>" required>
                                                    </div>
                                                    <div class="col-md-12 mt-3">
                                                        <label for="cover" id="cover_label" class="uploadFileND p-5 text-center w-100 rounded-4">
                                                            <span class="fa fa-cloud-arrow-up mb-3"></span>
                                                            <img class="w-100" height="" id="view_img" src="<?= public_url('uploads/categories/'.$data['fetch']['cover']) ?>" alt="img">
                                                        </label>
                                                        <input type="file" id="cover" name="cover" onchange="_upload_files(this, '#view_img', '[png, jpg, jpeg, webp]', '#cover_label')" accept="image/png, image/jpg, image/jpeg, image/webp" class="mt-1 form-control d-none" >
                                                        <div class="alert alert-warning rounded-4 shadow-sm mt-3 fs-7"> الملفات المسموح برفعها هي: <br>  (jpeg - webp - png - jpg) <br> علما أن حجم الملف يجب أن لا يتجاوز <span class="fw-bold me-1"> 1MB </span></div>
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
    include PUBLIC_PATH . '/components/dashboard/footer.php';
?>