<?php
    $settings = true;
    $page_title = "ZaraBox";
    require('init.php');
    use App\Controllers\Home\Home;
    $home = new Home();
?>

    <div id="carouselExampleFade" class="heroSlider carousel slide carousel-fade position-relative">
        <div class="carousel-inner">
            <div class="carousel-item active position-relative">
                <div class="category-name" style="z-index: 9999;">
                    <a href="#" class="btn btn-default rounded-0">رجالي</a>
                </div>
                <img src="<?= public_url('uploads/web/img1.jpg') ?>" class="d-block w-100" alt="img1">
            </div>
            <div class="carousel-item position-relative">
                <div class="category-name" style="z-index: 9999;">
                    <a href="#" class="btn btn-default rounded-0">حريمي</a>
                </div>
                <img src="<?= public_url('uploads/web/img2.jpg') ?>" class="d-block w-100" alt="img2">
            </div>
            <div class="carousel-item position-relative">
                <div class="category-name" style="z-index: 9999;">
                    <a href="#" class="btn btn-default rounded-0">أطفال</a>
                </div>
                <img src="<?= public_url('uploads/web/img3.jpg') ?>" class="d-block w-100" alt="img3">
            </div>
            <div class="carousel-item position-relative">
                <div class="category-name" style="z-index: 9999;">
                    <a href="#" class="btn btn-default rounded-0">أحذية</a>
                </div>
                <img src="<?= public_url('uploads/web/img4.jpg') ?>" class="d-block w-100" alt="img4">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <section class="categories py-5">
        <div class="container">
            <?php foreach($home->categorieWithProducts() as $category): ?>
            <div class="category mt-5">
                <h3 class="main-title mb-5"><?= $category['name_ar'] ?></h3>
                <div class="owl-carousel owl-items owl-theme">
                    <?php foreach($category['products'] as $product): ?>
                    <div class="item">
                        <a href="<?= $_ENV['WEB_URL'] ?>/product?n=<?= str_replace([' ',',','.', '@','،'], '-', $product['name']) ?>&id=<?= $product['id'] ?>" class="category-item">
                        <!-- <a href="#" class="category-item"> -->
                            <div class="overflow-hidden text-center">
                                <img class="w-auto mx-auto" height="270" src="<?= public_url('uploads/products/'.$home->productImages($product['id'])[0]) ?>" alt="<?= $product['name'] ?>">
                            </div>
                            <div class="item-name mt-2 position-relative">
                                <span><?= strlen($product['name']) > 40 ? mb_substr($product['name'], 0, 40).'...' : $product['name']; ?></span>
                            </div>
                            <div class="item-prices mt-2 d-flex justify-content-start gap-3 align-items-center">
                                <div class="before-price position-relative">
                                    <?= number_format((110/100 * $product['price']), 2) ?> EGP
                                </div>
                                <div class="after-price fw-bold">
                                    <?= number_format($product['price'], 2) ?> EGP
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="mt-4 mt-md-5 d-flex justify-content-center align-items-center">
                    <a href="#" class="btn btn-default show-more rounded-0">عرض المزيد</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>


    <section class="description text-white text-center bg-danger px-2 position-relative">
        <div class="container d-flex flex-column gap-4 zindex2">
            <h3 class="h2 m-0">نسعى دائما لتحقيق مطلبكم</h3>
            <p class="h6 m-0">المصداقية هي المعيار الأول والأساسي لبناء المشاريع الناجحة</p>
            <div>
                <a href="#" class="btn btn-default rounded-0 bg-white text-dark">تواصل معنا</a>
            </div>
        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<?php include('public/components/footer.php'); ?>
