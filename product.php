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


    <section class="details">
        <div class="show_images_clicked w-100 h-100 position-fixed justify-content-center align-items-center">
            <button class="btn btn-default fa fa-times" onclick="_displayBox()"></button>
            <img src="" alt="بوابة الكفاءة">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="product_slider row">
                        <div class="right_images wow fadeInDown" data-wow-duration="1s" data-wow-delay="0s">
                            <div class="one_image w-100 text-center mb-2 active" onclick="_getImage(this)">
                                <img class="w-100 h-100" src="https://www.stanleybiggs.co.uk/cdn/shop/files/Stanley_Biggs_Clothiers_016.jpg?v=1740475063&width=360" alt="">
                            </div>
                            <div class="one_image w-100 text-center mb-2" onclick="_getImage(this)">
                                <img class="w-100 h-100" src="https://www.stanleybiggs.co.uk/cdn/shop/files/Stanley_Biggs_Clothiers_016.jpg?v=1740475063&width=360" alt="">
                            </div>
                        </div>
                        <div class="left_images d-flex justify-content-center mx-auto text-center wow fadeInDown" data-wow-duration="1s" data-wow-delay=".2s">
                            <img id="images_slider" src="https://www.stanleybiggs.co.uk/cdn/shop/files/Stanley_Biggs_Clothiers_016.jpg?v=1740475063&width=360" alt="">
                        </div>
                        <!-- <div class="col-12 text-left order_now wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s">
                            <a href="#" class="btn btn-primary p-3 mt-4 shadow-sm" target="_blank">طلب المنتج</a>
                        </div> -->
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="item-details d-flex gap-1 flex-column position-relative">
                        <h1 class="h2">تيشرت رجالي من زارا</h1>
                        <div class="price fw500">LE <span id="$price" price="8167.56">8,167.56</span> EGP</div>
                        <div class="fs-14 text-muted fw400"><u>خدمة الشحن</u> يتم احتسابها بعد تأكيد الطلب</div>
                        <form method="POST" onsubmit="_add_to_cart(event, this)">
                            <div class="fs-14 fw-400 my-3">اختر المقاس</div>
                            <div class="tem-size d-flex gap-3 flex-row flex-wrap">
                                <div>
                                    <input type="radio" onchange="_clicked(this, 'radio', 'sizeType')" class="d-none sizeType" checked name="size" id="s-1" value="XS">
                                    <label class="w-100 block-select rounded-5 select-services justify-content-center align-items-center flex-column active" for="s-1">
                                        <span class="fw400">XS</span>
                                    </label>
                                </div>
                                <div>
                                    <input type="radio" onchange="_clicked(this, 'radio', 'sizeType')" class="d-none sizeType" name="size" id="s-2" value="S">
                                    <label class="w-100 block-select rounded-5 select-services justify-content-center align-items-center flex-column" for="s-2">
                                        <span class="fw400">S</span>
                                    </label>
                                </div>
                                <div>
                                    <input type="radio" onchange="_clicked(this, 'radio', 'sizeType')" class="d-none sizeType" name="size" id="s-3" value="M">
                                    <label class="w-100 block-select rounded-5 select-services justify-content-center align-items-center flex-column" for="s-3">
                                        <span class="fw400">M</span>
                                    </label>
                                </div>
                                <div>
                                    <input type="radio" onchange="_clicked(this, 'radio', 'sizeType')" class="d-none sizeType" name="size" id="s-4" value="L">
                                    <label class="w-100 block-select rounded-5 select-services justify-content-center align-items-center flex-column" for="s-4">
                                        <span class="fw400">L</span>
                                    </label>
                                </div>
                                <div>
                                    <input type="radio" onchange="_clicked(this, 'radio', 'sizeType')" class="d-none sizeType" name="size" id="s-5" value="XL">
                                    <label class="w-100 block-select rounded-5 select-services justify-content-center align-items-center flex-column" for="s-5">
                                        <span class="fw400">XL</span>
                                    </label>
                                </div>
                                <div>
                                    <input type="radio" onchange="_clicked(this, 'radio', 'sizeType')" class="d-none sizeType" name="size" id="s-6" value="XXL">
                                    <label class="w-100 block-select rounded-5 select-services justify-content-center align-items-center flex-column" for="s-6">
                                        <span class="fw400">XXL</span>
                                    </label>
                                </div>
                            </div>
                            <div class="fs-14 fw-400 mt-4 mb-3">الكمية</div>
                            <div class="d-flex">
                                <div class="qty-input">
                                    <button class="qty-count qty-count--minus" data-action="minus" type="button" disabled>-</button>
                                    <input class="product-qty" type="number" name="quantity" min="1" max="10" value="1" required>
                                    <button class="qty-count qty-count--add" data-action="add" type="button">+</button>
                                </div>
                            </div>
                            <div class="col-12 addToCart mt-4" data-wow-duration="1s" data-wow-delay=".2s">
                                <button type="submit" class="btn btn-default rounded-0 p-3 w-100">إضافة إلى السلة</button>
                            </div>
                        </form>
                        <div class="added p-5 shadow-sm w-100">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <div class="d-flex gap-3 align-items-center fs-14 flex-row"><span class="pe pe-7s-check fw500 h5 m-0"></span> تمت إضافة المنتج للسلة</div>
                                <!-- <span class="pe pe-7s-close fw500 h1 m-0" onclick="_closeCartTap()"></span> -->
                            </div>
                            <div class="d-flex gap-3 flex-row mt-4">
                                <div>
                                    <img class="border" width="100" height="100" src="https://www.stanleybiggs.co.uk/cdn/shop/files/Stanley_Biggs_Clothiers_016.jpg?v=1740475063&width=360" alt="img1">
                                </div>
                                <div class="d-flex gap-2 flex-column">
                                    <h6 style="font-weight: 400;">تيشرت رجالي من زارا</h6>
                                    <div class="fs-14">المقاس: <span id="$finalSize"></span></div>
                                    <div class="fs-14">الكمية: <span id="$finalQuantity"></span></div>
                                </div>
                            </div>
                            <div class="buttons mt-4 d-flex gap-3 flex-column align-items-center">
                                <a href="#" class="show-cart btn btn-default rounded-0 w-100 d-flex gap-2 align-items-center justify-content-center"><span class="pe pe-7s-cart h6 fw-bold m-0"></span> المواصلة إلى السلة</a>
                                <div class="fs-14 pointer" onclick="_closeCartTap()"><u>متابعة التسوق</u></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item-description mt-5 text-muted">
                مجموعتنا الجديدة من القمصان مستوحاة مباشرةً من أنماط تعود إلى ثلاثينيات القرن الماضي. لقد بحثنا عن أجود أنواع القطن لنقدم لكم خيارًا فريدًا لخزانة ملابسكم. صُنعت هذه القمصان في إنجلترا.
                يتميز قميص كيلهام، المصنوع من قطن الكتان الليموني، بخصائص رئيسية. فهو ذو أكمام واحدة، وواجهة أمامية كاملة، وياقة متوسطة مدببة، مثالية للارتداء مع ربطة عنق أو بدونها.
                تماشيًا مع أنماط أوائل القرن العشرين، تتميز القمصان بقصات واسعة عند الجسم والذراعين، مما يوفر ملاءمة أكثر مرونة وطولًا أطول.
            </div>
        </div>
    </section>


    <section class="categories py-5 mt-3">
        <div class="container">
            <div class="category">
                <h3 class="main-title mb-5">منتجات ذات صلة</h3>
                <div class="owl-carousel owl-items owl-theme">
                    <div class="item">
                        <a href="#" class="category-item">
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
                        <a href="#" class="category-item">
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
                        <a href="#" class="category-item">
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
                        <a href="#" class="category-item">
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



    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script> -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="owl.carousel.js"></script>
    <script src="owl.autoplay.js"></script>
    <script src="owl.navigation.js"></script>
    <script src="font.js"></script>
    <script src="scripts.js"></script>

    <script>
        $(".owl-items").owlCarousel({
                loop: false,
                margin: 15,
                nav: true,
                dots: false,
                autoplay: true,
                autoplayHoverPause: false, 
                autoplayTimeout: 8000,
                rtl: true,
                responsive: {
                    0: {
                        items: 1,
                        stagePadding: 70
                    },
                    500: {
                        items:2,
                        stagePadding: 50
                    },
                    900: {
                        items: 4,
                        stagePadding: 0
                    }
                    
                }
                // onTranslated: function(event){
                //     _animate(event); 
                // }   
            });
    </script>
    <script>
        // window.onload = function(){
        //     let slider = document.getElementById('images_slider'),
        //         images = "<?= $getProduct['fetch']['images'] ?>".split(','),
        //         rights = document.querySelectorAll('.one_image'),
        //         _count = 1;
        //     setInterval(() => {
        //         if(_count == images.length){
        //             _count = 0;
        //         }
        //         slider.setAttribute('src', "<?= $url ?>/includes/uploads/products/images/"+images[_count]);
        //         rights.forEach( (item) => {
        //             item.classList.remove('active');
        //         });
        //         rights[_count].classList.add('active');
        //         _count ++;
        //     }, 5000);
        // }
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

<script>
    const QtyInput = (() => {
        const $qtyInputs = $(".qty-input");

        if (!$qtyInputs.length) return;

        const $inputs = $qtyInputs.find(".product-qty");
        const $countBtn = $qtyInputs.find(".qty-count");
        const qtyMin = parseInt($inputs.attr("min"));
        const qtyMax = parseInt($inputs.attr("max"));

        $inputs.on("change", function () {
            const $this = $(this);
            const $minusBtn = $this.siblings(".qty-count--minus");
            const $addBtn = $this.siblings(".qty-count--add");
            let qty = parseInt($this.val());

            if (isNaN(qty) || qty <= qtyMin) {
                $this.val(qtyMin);
                $minusBtn.attr("disabled", true);
            } else {
                $minusBtn.attr("disabled", false);

                if (qty >= qtyMax) {
                    $this.val(qtyMax);
                    $addBtn.attr("disabled", true);
                } else {
                    $this.val(qty);
                    $addBtn.attr("disabled", false);
                }
            }
            
        });

        $inputs.on("keyup", function () {
            changePrice(this.value)
        })

        $countBtn.on("click", function () {
            const operator = this.dataset.action;
            const $this = $(this);
            const $input = $this.siblings(".product-qty");
            let qty = parseInt($input.val());

            if (operator === "add") {
                qty += 1;

                if (qty >= qtyMin + 1) {
                    $this.siblings(".qty-count--minus").attr("disabled", false);
                }

                if (qty >= qtyMax) {
                    $this.attr("disabled", true);
                }
            } else {
                qty = qty <= qtyMin ? qtyMin : qty - 1;

                if (qty === qtyMin) {
                    $this.attr("disabled", true);
                }

                if (qty < qtyMax) {
                    $this.siblings(".qty-count--add").attr("disabled", false);
                }
            }
            changePrice(qty)
            $input.val(qty);
        });
    })();

    const changePrice = (quantity) => {
        const price = Number($price.getAttribute('price')) * quantity
        $price.innerText = price.toLocaleString("en-US")
    }

    document.querySelectorAll('.product-qty').forEach(input => {
        const min = parseInt(input.min);
        const max = parseInt(input.max);
    
        input.addEventListener('input', () => {
        let value = parseInt(input.value);
    
        if (isNaN(value)) {
            input.value = min;
        } else if (value > max) {
            input.value = max;
        } else if (value < min) {
            input.value = min;
        }
        });
    });
  
    </script>

    <script>
        const _add_to_cart = async ( event, form ) => {
            event.preventDefault();
            document.querySelector('.addToCart button').setAttribute('disabled', '')
            const data = new FormData(form);
            let size        = data.get('size'),
                quantity    = data.get('quantity'),
                productID   = 1;

            if (size != null && quantity != null) {
                if (await addToCart(productID, size, quantity)) {
                    return _openCartTap()
                }
            }
        }
    </script>
</body>

</html>