<?php
    $settings = true;
    $page_title = "ZaraBox";
    require('init.php');
    use App\Controllers\Product\Product;
    $product = new Product();
    $product->single();
?>

    <section class="details">
        <div class="show_images_clicked w-100 h-100 position-fixed justify-content-center align-items-center">
            <button class="btn btn-default fa fa-times" onclick="_displayBox()"></button>
            <img src="" alt="">
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="product_slider row">
                        <div class="right_images wow fadeInDown" data-wow-duration="1s" data-wow-delay="0s">
                            <?php foreach($product->data['images'] as $image): ?>
                            <div class="one_image w-100 text-center mb-2 active" onclick="_getImage(this)">
                                <img class="w-100 h-100" src="<?= public_url("uploads/products/$image") ?>" alt="<?= $product->data['name'] ?>">
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="left_images d-flex justify-content-center mx-auto text-center wow fadeInDown" data-wow-duration="1s" data-wow-delay=".2s">
                            <img id="images_slider" src="<?= public_url("uploads/products/").$product->data['images'][0] ?>" alt="<?= $product->data['name'] ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="item-details d-flex gap-1 flex-column position-relative">
                        <h1 class="h2"><?= $product->data['name'] ?></h1>
                        <div class="price fw500">LE <span id="$price" price="<?= $product->data['price'] ?>"><?= number_format($product->data['price'], 0) ?></span> EGP</div>
                        <div class="fs-14 text-muted fw400"><u>خدمة الشحن</u> يتم احتسابها بعد تأكيد الطلب</div>
                        <form method="POST" onsubmit="_add_to_cart(event, this)">
                            <div class="fs-14 fw-400 my-3">اختر المقاس</div>
                            <div class="tem-size d-flex gap-3 flex-row flex-wrap">
                                <?php foreach($product->data['sizes'] as $size): ?>
                                <div>
                                    <input type="radio" onchange="_clicked(this, 'radio', 'sizeType')" class="d-none sizeType" name="size" id="s-<?= $size['id'] ?>" value="<?= $size['id'] ?>">
                                    <label class="w-100 block-select rounded-5 select-services justify-content-center align-items-center flex-column" for="s-<?= $size['id'] ?>">
                                        <span class="fw400" id="size-text-<?= $size['id'] ?>"><?= $size['name'] ?></span>
                                    </label>
                                </div>
                                <?php endforeach; ?>
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
                                    <img class="border" width="100" height="100" src="<?= public_url("uploads/products/") . $product->data['images'][0] ?>" alt="<?= $product->data['name'] ?>">
                                </div>
                                <div class="d-flex gap-2 flex-column">
                                    <h6 style="font-weight: 400;"><?= $product->data['name'] ?></h6>
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
                <?= $product->data['description'] ?>
            </div>
        </div>
    </section>

    <?php 
        $related = $product->related();
        if ($related['rowCount'] > 0):
    ?>
    <section class="categories py-5 mt-3">
        <div class="container">
            <div class="category">
                <h3 class="main-title mb-4">منتجات ذات صلة</h3>
                <div class="owl-carousel owl-items owl-theme">
                    <?php foreach($related['fetchAll'] as $item): ?>
                    <div class="item">
                        <a href="<?= $_ENV['WEB_URL'] ?>/product?n=<?= str_replace([' ',',','.', '@','،'], '-', $item['name']) ?>&id=<?= $item['id'] ?>" class="category-item">
                            <div class="overflow-hidden text-center">
                                <img class="w-auto mx-auto" height="270" src="<?= public_url('uploads/products/'.$item['image']) ?>" alt="<?= $item['name'] ?>">
                            </div>
                            <div class="item-name mt-2 position-relative">
                                <span><?= strlen($item['name']) > 40 ? mb_substr($item['name'], 0, 40).'...' : $item['name']; ?></span>
                            </div>
                            <div class="item-prices mt-2 d-flex justify-content-start gap-3 align-items-center">
                                <div class="before-price position-relative">
                                    <?= number_format((110/100 * $item['price']), 2) ?> EGP
                                </div>
                                <div class="after-price fw-bold">
                                    <?= number_format($item['price'], 2) ?> EGP
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
        </div>
    </section>
    <?php endif; ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
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
        function _clicked(elem, type = null, clss = null)
        {
            if(type == 'radio'){
                const divs = document.querySelectorAll('.'+clss);
                divs.forEach( (item) => {
                    item.nextElementSibling.classList.remove('active');
                });
            }
            elem.nextElementSibling.classList.toggle('active')
        }
    </script>
    <script>
        window.onload = function(){
            let slider = document.getElementById('images_slider'),
                images = "<?= implode(',', $product->data['images']) ?>".split(','),
                rights = document.querySelectorAll('.one_image'),
                _count = 1;
                // console.log(images)
            setInterval(() => {
                if(_count == images.length){
                    _count = 0;
                }
                slider.setAttribute('src', "<?= public_url('uploads/products/') ?>"+images[_count]);
                rights.forEach( (item) => {
                    item.classList.remove('active');
                });
                rights[_count].classList.add('active');
                _count ++;
            }, 10000);
        }
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
        // const PRODUCTID = 1;
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

<?php include('public/components/footer.php'); ?>
