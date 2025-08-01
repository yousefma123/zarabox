<?php
    $settings = true;
    $page_title = "ZaraBox";
    require('init.php');
?>
    <section id="carouselExampleFade" class="heroSlider carousel slide carousel-fade position-relative">
        <div class="carousel-inner  overflow-hidden">
            <?php foreach($home->categories()['fetchAll'] as $cat): ?>
            <div class="carousel-item active position-relative">
                <div class="category-name" style="z-index: 9999;">
                    <a class="btn btn-default rounded-0 text-white" href="<?= $_ENV['WEB_URL'] ?>/category?n=<?= str_replace([' ',',','.', '@','،'], '-', $cat['name_ar']) ?>&id=<?= $cat['id'] ?>"><?= $cat['name_ar'] ?></a>
                </div>
                <img src="<?= public_url('uploads/categories/' . $cat['cover']) ?>" class="d-block w-100" alt="<?= $cat['name_ar'] ?>">
            </div>
            <?php endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </section>

    <section class="categories py-5">
        <div class="container">
            <?php foreach($home->categoryWithProducts() as $category): ?>
            <div class="category my-5">
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
                    <a href="<?= $_ENV['WEB_URL'] ?>/category?n=<?= str_replace([' ',',','.', '@','،'], '-', $cat['name_ar']) ?>&id=<?= $cat['id'] ?>" class="btn btn-default show-more rounded-0">عرض المزيد</a>
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
