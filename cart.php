<?php
    $settings = true;
    $page_title = "ZaraBox";
    require('init.php');
    require("public/components/header.php");
    include('public/components/navbar.php');
?>

    <section class="cart py-5 px-2">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <h1 class="h2">السلة الخاصة بك</h1>
                <a class="underline text-muted" href="index">متابعة التسوق</a>
            </div>
            <div class="cart-items mt-5">
                <div class="item d-flex justify-content-between align-items-center gap-md-3 gap-4 flex-wrap mt-4">
                    <div class="main-details d-flex gap-3 flex-row">
                        <img class="border" width="100" height="100" src="https://www.stanleybiggs.co.uk/cdn/shop/files/Stanley_Biggs_Clothiers_016.jpg?v=1740475063&width=300" alt="">
                        <div class="d-flex flex-column gap-1">
                            <a href="#" class="h6 fw400">تيشرت رجالي من زارا</a>
                            <div class="fw300 fs-14">LE 8,167.56 EGP</div>
                            <div class="fw300 fs-14">المقاس: M</div>
                        </div>
                    </div>
                    <div class="d-flex gap-4 align-items-center">
                        <div class="qty-input">
                            <button class="qty-count qty-count--minus" data-action="minus" type="button" disabled>-</button>
                            <input class="product-qty" type="number" name="quantity" min="1" max="10" value="1" required>
                            <button class="qty-count qty-count--add" data-action="add" type="button">+</button>
                        </div>
                        <span class="pe pe-7s-trash fw500 pointer h5 m-0"></span>
                    </div>
                    <div class="position-relative">
                        <div class="price active">LE <span price="8167.56">8,167.56</span> EGP</div>
                        <span class="fa fa-spinner h5 m-0"></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script>
        const PRODUCTID = 1
        function _getImage(elem)
        {
            const imageSRC  = elem.querySelector('img').getAttribute('src');
            const box       = document.querySelector('.show_images_clicked');
            box.querySelector('img').setAttribute('src', imageSRC);
            box.style.display = 'flex';
            console.log(imageSRC);
        }
        function _displayBox()
        {
            const box   = document.querySelector('.show_images_clicked');  
            box.style.display = 'none';
        }
    </script>

<?php include('public/components/footer.php'); ?>
