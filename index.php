<?php
    $settings = true;
    $page_title = "ZaraBox";
    require('init.php');
    require("public/components/header.php");
    include('public/components/navbar.php');
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
            <div class="category mt-5">
                <h3 class="main-title mb-5">أفضل الملابس الحديثة</h3>
                <div class="owl-carousel owl-items owl-theme">
                    <div class="item">
                        <a href="<?= $_ENV['WEB_URL'] ?>/product" class="category-item">
                            <div class="overflow-hidden text-center">
                                <img class="w-auto mx-auto" height="270" src="https://www.stanleybiggs.co.uk/cdn/shop/files/Stanley_Biggs_Clothiers_045.jpg?v=1740393878&width=360" alt="img1">
                            </div>
                            <div class="item-name mt-2 position-relative">
                                <span>سترة إيفرت جامبر العادية</span>
                            </div>
                            <div class="item-prices mt-2 d-flex justify-content-start gap-3 align-items-center">
                                <div class="before-price position-relative">
                                    18,000 EGP
                                </div>
                                <div class="after-price fw-bold">
                                    18,000 EGP
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="item">
                        <a href="<?= $_ENV['WEB_URL'] ?>/product" class="category-item">
                            <div class="overflow-hidden text-center">
                                <img class="w-auto mx-auto" height="270" src="https://www.stanleybiggs.co.uk/cdn/shop/files/Stanley_Biggs_Clothiers_016.jpg?v=1740475063&width=360" alt="img1">
                            </div>
                            <div class="item-name mt-2 position-relative">
                                <span>سترة إيفرت جامبر العادية</span>
                            </div>
                            <div class="item-prices mt-2 d-flex justify-content-start gap-3 align-items-center">
                                <div class="before-price position-relative">
                                    18,000 EGP
                                </div>
                                <div class="after-price fw-bold">
                                    18,000 EGP
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="item">
                        <a href="<?= $_ENV['WEB_URL'] ?>/product" class="category-item">
                            <div class="overflow-hidden text-center">
                                <img class="w-auto mx-auto" height="270" src="https://www.stanleybiggs.co.uk/cdn/shop/files/Stanley_Biggs_Clothiers_062.jpg?v=1738503166&width=360" alt="img1">
                            </div>
                            <div class="item-name mt-2 position-relative">
                                <span>سترة إيفرت جامبر العادية</span>
                            </div>
                            <div class="item-prices mt-2 d-flex justify-content-start gap-3 align-items-center">
                                <div class="before-price position-relative">
                                    18,000 EGP
                                </div>
                                <div class="after-price fw-bold">
                                    18,000 EGP
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="item">
                        <a href="<?= $_ENV['WEB_URL'] ?>/product" class="category-item">
                            <div class="overflow-hidden text-center">
                                <img class="w-auto mx-auto" height="270" src="https://www.stanleybiggs.co.uk/cdn/shop/files/Stanley_Biggs_Clothiers_029.jpg?v=1738503611&width=360" alt="img1">
                            </div>
                            <div class="item-name mt-2 position-relative">
                                <span>سترة إيفرت جامبر العادية</span>
                            </div>
                            <div class="item-prices mt-2 d-flex justify-content-start gap-3 align-items-center">
                                <div class="before-price position-relative">
                                    18,000 EGP
                                </div>
                                <div class="after-price fw-bold">
                                    18,000 EGP
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="mt-4 mt-md-5 d-flex justify-content-center align-items-center">
                    <a href="#" class="btn btn-default show-more rounded-0">عرض المزيد</a>
                </div>
            </div>
            <div class="category mt-5">
                <h3 class="main-title mb-5">أفضل الملابس الحديثة</h3>
                <div class="owl-carousel owl-items owl-theme">
                    <div class="item">
                        <a href="<?= $_ENV['WEB_URL'] ?>/product" class="category-item">
                            <div class="overflow-hidden text-center">
                                <img class="w-auto mx-auto" height="270" src="https://www.stanleybiggs.co.uk/cdn/shop/files/ChatGPT_Image_Jun_6_2025_01_41_31_PM.png?v=1749214060&width=360" alt="img1">
                            </div>
                            <div class="item-name mt-2 position-relative">
                                <span>سترة إيفرت جامبر العادية</span>
                            </div>
                            <div class="item-prices mt-2 d-flex justify-content-start gap-3 align-items-center">
                                <div class="before-price position-relative">
                                    18,000 EGP
                                </div>
                                <div class="after-price fw-bold">
                                    18,000 EGP
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="item">
                        <a href="<?= $_ENV['WEB_URL'] ?>/product" class="category-item">
                            <div class="overflow-hidden text-center">
                                <img class="w-auto mx-auto" height="270" src="https://www.stanleybiggs.co.uk/cdn/shop/files/ChatGPT_Image_Jun_6_2025_01_41_32_PM.png?v=1749214051&width=360" alt="img1">
                            </div>
                            <div class="item-name mt-2 position-relative">
                                <span>سترة إيفرت جامبر العادية</span>
                            </div>
                            <div class="item-prices mt-2 d-flex justify-content-start gap-3 align-items-center">
                                <div class="before-price position-relative">
                                    18,000 EGP
                                </div>
                                <div class="after-price fw-bold">
                                    18,000 EGP
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="item">
                        <a href="<?= $_ENV['WEB_URL'] ?>/product" class="category-item">
                            <div class="overflow-hidden text-center">
                                <img class="w-auto mx-auto" height="270" src="https://www.stanleybiggs.co.uk/cdn/shop/files/Sophie_Bainbridge001.jpg?v=1739725978&width=360" alt="img1">
                            </div>
                            <div class="item-name mt-2 position-relative">
                                <span>سترة إيفرت جامبر العادية</span>
                            </div>
                            <div class="item-prices mt-2 d-flex justify-content-start gap-3 align-items-center">
                                <div class="before-price position-relative">
                                    18,000 EGP
                                </div>
                                <div class="after-price fw-bold">
                                    18,000 EGP
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="item">
                        <a href="<?= $_ENV['WEB_URL'] ?>/product" class="category-item">
                            <div class="overflow-hidden text-center">
                                <img class="w-auto mx-auto" height="270" src="https://www.stanleybiggs.co.uk/cdn/shop/files/Sophie_Bainbridge009.jpg?v=1739726018&width=360" alt="img1">
                            </div>
                            <div class="item-name mt-2 position-relative">
                                <span>سترة إيفرت جامبر العادية</span>
                            </div>
                            <div class="item-prices mt-2 d-flex justify-content-start gap-3 align-items-center">
                                <div class="before-price position-relative">
                                    18,000 EGP
                                </div>
                                <div class="after-price fw-bold">
                                    18,000 EGP
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
               <div class="mt-4 mt-md-5 d-flex justify-content-center align-items-center">
                    <a href="#" class="btn btn-default show-more rounded-0">عرض المزيد</a>
               </div>
            </div>
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
