<?php
    $page_title = "لوحة التحكم | المنتجات";
    require("../init.php");
    use App\Controllers\Admin\Product\Product;
    $page_name = "products.create";
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
                                    <h5 class="fw-bold card-title-header">أضف منتج الآن</h5>
                                    <p class="text-small text-muted">يرجى مراعاة إدخال الحقول الإجبارية كاملة </p>
                                </div>
                                <?php
                                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) $product->create();
                                ?>
                                <div class="card-body p-1 mt-3 add-new-service">
                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="token" class="form-control" value="<?= $_SESSION['token'] ?>">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class="fs-7 fw-bold" for="">اسم المنتج *</label>
                                                        <input type="text" name="name" class="form-control mt-3 rounded-4 bg-ddd" placeholder="اسم المنتج" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="fs-7 fw-bold" for="">القسم *</label>
                                                        <select name="category" class="form-control bg-ddd">
                                                            <option value="">اختر القسم</option>
                                                            <?php 
                                                                $cats = $statement->select("id, name_ar", "categories", "fetchAll");
                                                                foreach($cats['fetchAll'] as $cat):
                                                            ?>
                                                            <option value="<?= $cat['id'] ?>"><?= $cat['name_ar'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="fs-7 fw-bold" for="">نوع المقاس *</label>
                                                        <select name="size_type" class="form-control bg-ddd" onchange="fetchSizes(this.value)">
                                                            <option value="">اختر النوع</option>
                                                            <?php 
                                                                $types = $statement->select("id, name", "size_types", "fetchAll");
                                                                foreach($types['fetchAll'] as $type):
                                                            ?>
                                                            <option value="<?= $type['id'] ?>"><?= $type['name'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="fs-7 fw-bold" for="sizes"> الأحجام *</label>
                                                        <select name="sizes[]" class="rounded-4 mt-3" id="sizes" multiple required>
                                                            <option data-placeholder="true" value="">اختر الأحجام المتوفرة للمنتج</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="fs-7 fw-bold" for="">سعر المنتج *</label>
                                                        <input type="number" name="price" class="form-control mt-3 rounded-4 bg-ddd" placeholder="السعر" required>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="fs-7 fw-bold" for=""> وصف المنتج *</label>
                                                        <textarea name="description" class="form-control bg-ddd" rows="7" placeholder="وصف المنتج"></textarea>
                                                    </div>
                                                    <div class="col-md-12 mt-3">
                                                        <label for="images" id="images_label" class="uploadFileND p-5 text-center w-100 rounded-4">
                                                            <span class="fa fa-cloud-arrow-up mb-3"></span>
                                                            <div class="fw-bold">صور المنتج بحد أقصى 8</div>
                                                        </label>
                                                        <input type="file" id="images" name="images[]" onchange="_upload_files(this, '', '[png, jpg, jpeg, webp]', '#images_label')" accept="image/png, image/jpg, image/jpeg, image/webp" class="mt-1 form-control d-none" multiple required>
                                                        <div class="alert alert-warning rounded-4 shadow-sm mt-3 fs-7"> الملفات المسموح برفعها هي: <br>  (jpeg - webp - png - jpg) <br> علما أن حجم الملف يجب أن لا يتجاوز <span class="fw-bold me-1"> 2MB </span></div>
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


    <script>
        const SIZES_URL = `<?= $_ENV['WEB_URL'] ?>/App/Controllers/Size/Size.php?fetchSizes=1&type=`
    </script>


<?php 
    include( PUBLIC_PATH . '/components/dashboard/footer.php' );
?>