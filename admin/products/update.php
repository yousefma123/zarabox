<?php
    $page_title = "لوحة التحكم | المنتجات";
    require("../init.php");
    use App\Controllers\Admin\Product\Product;
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
                        <?php
                            if(isset($_GET['id']) && is_numeric($_GET['id'])):
                                $id = $_GET['id'];
                                if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])):
                                    $product->update();
                                endif;
                                $data = $statement->getJoinData(
                                    "`products`.*, `product_images`.id AS imageid, `product_images`.image",
                                    "`products`",
                                    "LEFT JOIN `product_images` ON `product_images`.product = `products`.id",
                                    "fetchAll",
                                    "WHERE `products`.id = $id",
                                );
                                if($data['rowCount'] > 0):
                                    $product = $data['fetchAll'][0];
                        ?>

                        <div class="col-md-12 mb-3">
                            <div class="card rounded-4 p-4 h-100">
                                <div class="card-title mb-1 text-center mt-2">
                                    <h5 class="fw-bold card-title-header">تعديل منتج (<?= $product['name'] ?>)</h5>
                                    <p class="text-small text-muted">يرجى مراعاة إدخال الحقول الإجبارية كاملة </p>
                                </div>
                                <div class="card-body p-1 mt-3 add-new-service">
                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="token" class="form-control" value="<?= $_SESSION['token'] ?>">
                                        <div class="row">
                                            <div class="col-12 mt-2">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="fs-7 fw-bold" for=""> اسم المنتج *</label>
                                                        <input type="text" name="name" class="form-control mt-3 rounded-4 bg-ddd" value="<?= $product['name'] ?>" placeholder="اسم المنتج" required>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="fs-7 fw-bold" for="">سعر المنتج *</label>
                                                        <input type="number" name="price" class="form-control mt-3 rounded-4 bg-ddd" placeholder="السعر" value="<?= (int) $product['price'] ?>" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="fs-7 fw-bold" for="">نوع المقاس *</label>
                                                        <select name="size_type" class="form-control bg-ddd" onchange="fetchSizes(this.value)">
                                                            <?php 
                                                                $types = $statement->select("id, name", "size_types", "fetchAll");
                                                                foreach($types['fetchAll'] as $type):
                                                            ?>
                                                            <option value="<?= $type['id'] ?>" <?= $type['id'] == $product['sizeType'] ? 'selected' : ''; ?>><?= $type['name'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="fs-7 fw-bold" for="sizes"> الأحجام *</label>
                                                        <select name="sizes[]" class="rounded-4 mt-3" id="sizes" multiple required>
                                                            <?php 
                                                                $sizes = $statement->select("id, name", "sizes", "fetchAll", "WHERE `type` = ".$product['sizeType']."");
                                                                foreach($sizes['fetchAll'] as $size):
                                                            ?>
                                                            <option value="<?= $size['id'] ?>" <?= in_array($size['id'], explode(',', $product['sizes'])) ? 'selected' : ''; ?>><?= $size['name'] ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="fs-7 fw-bold" for=""> وصف المنتج *</label>
                                                        <textarea name="description" class="form-control bg-ddd" rows="7" placeholder="وصف المنتج"><?= $product['description'] ?></textarea>
                                                    </div>
                                                    <?php for($x = 0; $x <= $data['rowCount'] - 1; $x++): ?>
                                                    <div class="col-md-4 mt-3">
                                                        <input type="hidden" name="image_ids[]" value="<?= $data['fetchAll'][$x]['imageid'] ?>">
                                                        <label for="images_<?= $x ?>" id="images_label_<?= $x ?>" class="uploadFileND p-5 text-center w-100 h-100 rounded-4">
                                                            <span class="fa fa-cloud-arrow-up mb-3"></span>
                                                            <div class="fw-bold"></div>
                                                            <img class="w-100" height="120" id="view_<?= $x ?>" src="<?= public_url('uploads/products/'.$data['fetchAll'][$x]['image']) ?>" alt="img">
                                                        </label>
                                                        <input type="file" id="images_<?= $x ?>" name="images[]" onchange="_upload_files(this, '#view_<?= $x ?>', '[png, jpg, jpeg, webp]', '#images_label_<?= $x ?>')" accept="image/png, image/jpg, image/jpeg, image/webp" class="mt-1 form-control d-none" show>
                                                    </div>
                                                    <?php endfor; ?>
                                                    <?php  for($x; $x <= 4; $x++): ?>
                                                    <div class="col-md-4 mt-3">
                                                        <label for="images_<?= $x ?>" id="images_label_<?= $x ?>" class="uploadFileND p-5 text-center w-100 h-100 rounded-4">
                                                            <span class="fa fa-cloud-arrow-up mb-3"></span>
                                                            <div class="fw-bold"></div>
                                                            <img class="w-100" height="120" src="" id="view_<?= $x ?>" alt="img">
                                                        </label>
                                                        <input type="file" id="images_<?= $x ?>" name="images[]" onchange="_upload_files(this, '#view_<?= $x ?>', '[png, jpg, jpeg, webp]', '#images_label_<?= $x ?>')" accept="image/png, image/jpg, image/jpeg, image/webp" class="mt-1 form-control d-none" show>
                                                    </div>
                                                    <?php endfor; ?>
                                                    <div class="alert alert-warning rounded-4 shadow-sm mt-3 fs-7"> الملفات المسموح برفعها هي: <br>  (jpeg - webp - png - jpg) <br> علما أن حجم الملف يجب أن لا يتجاوز <span class="fw-bold me-1"> 2MB </span></div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-4">
                                                <button type="submit" name="update" class="btn btn-default w-100 rounded-pill p-3 btn-bg-system fw-bold shadow-sm">تعديل بيانات المنتج</button>
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
    
    <script>
        const SIZES_URL = `<?= $_ENV['WEB_URL'] ?>/App/Controllers/Size/Size.php?fetchSizes=1&type=`
    </script>

<?php 
    include PUBLIC_PATH . '/components/dashboard/footer.php';
?>