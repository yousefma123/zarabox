<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="ow-carousel.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/pe-icons.css">
    <link rel="stylesheet" href="style.css">
</head>

<body dir="rtl">


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





    <footer class="p-5 px-2">
        <div class="container d-flex justify-content-between align-items-center gap-3 flex-wrap">
            <div class="footer-links d-flex gap-3 flex-wrap">
                <a href="#">الرئيسية</a>
                <a href="#">تواصل معنا</a>
                <a href="#">عن المتجر</a>
            </div>
            <div class="fs-14">© 2025, Stanley Biggs Clothiers Powered by USS</div>
            <div class="media-links d-flex gap-4 flex-wrap">
                <a href="#" class="fa fa-facebook"></a>
                <a href="#" class="fa fa-x"></a>
                <a href="#" class="fa fa-instagram"></a>
                <a href="#" class="fa fa-whatsapp"></a>
                <a href="#" class="fab fa-tiktok"></a>
            </div>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js"
        integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK"
        crossorigin="anonymous"></script>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="owl.carousel.js"></script>
    <script src="owl.autoplay.js"></script>
    <script src="owl.navigation.js"></script>
    <script src="font.js"></script>
    <script src="scripts.js"></script>

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
</body>

</html>