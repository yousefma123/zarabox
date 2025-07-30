<?php
    ob_start();
    session_start();
    use App\Controllers\Cart\Cart;
    use App\Controllers\Order\Order;
    use App\Helpers\TokenCreator;
    $settings = true;
    $page_title = "ZaraBox | السلة";
    require('init.php');
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ids'])):
        $order = (new Order())->create();
    endif;
?>

    <div class="preloader w-100  active light" id="preloader">
        <svg class="cart" role="img" aria-label="Shopping cart line animation" viewBox="0 0 128 128" width="110px" height="110px" xmlns="http://www.w3.org/2000/svg">
            <g fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="8">
                <g class="cart__track" stroke="hsla(0,10%,10%,0.1)">
                    <polyline points="4,4 21,4 26,22 124,22 112,64 35,64 39,80 106,80" />
                    <circle cx="43" cy="111" r="13" />
                    <circle cx="102" cy="111" r="13" />
                </g>
                <g class="cart__lines" stroke="currentColor">
                    <polyline class="cart__top" points="4,4 21,4 26,22 124,22 112,64 35,64 39,80 106,80" stroke-dasharray="338 338" stroke-dashoffset="-338" />
                    <g class="cart__wheel1" transform="rotate(-90,43,111)">
                        <circle class="cart__wheel-stroke" cx="43" cy="111" r="13" stroke-dasharray="81.68 81.68" stroke-dashoffset="81.68" />
                    </g>
                    <g class="cart__wheel2" transform="rotate(90,102,111)">
                        <circle class="cart__wheel-stroke" cx="102" cy="111" r="13" stroke-dasharray="81.68 81.68" stroke-dashoffset="81.68" />
                    </g>
                </g>
            </g>
        </svg>
        <div class="preloader__text">
            <p class="preloader__msg">جاري التحميل...</p>
        </div>
    </div>

    <section class="cart py-5 px-2">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <h1 class="h2">السلة الخاصة بك</h1>
                <a class="underline text-muted" href="index">متابعة التسوق</a>
            </div>
            <div id="content">
                <div class="alert alert-warning rounded-3 p-3 mt-4">لا يوجد عناصر متاحة في السلة</div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade modal-lg" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center w-100">
                    <h1 class="modal-title fs-6 fw-bold" id="staticBackdropLabel">تفاصيل الشحن</h1>
                    <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5">
                    <div class="checkout px-3 w-100">
                        
                        <form class="info w-100" method="POST" id="checkout" novalidate onsubmit="submitForms(this, event)">
                            <input type="hidden" name="token" value="<?= (new Cart())->setToken() ?>">
                            <div class="mt-4">
                                <div class="h6 m-0 fw-bold">التواصل</div>
                                <div class="input-wrapper">
                                    <input type="text" name="email" class="form-control" required>
                                    <span class="placeholder-text">البريد الإلكتروني</span>
                                </div>
                                <div class="input-wrapper input-group mb-3" dir="ltr">
                                    <span class="input-group-text" id="basic-addon1">+20</span>
                                    <input type="tel" name="phone" class="form-control" aria-label="Phone" aria-describedby="basic-addon1" required>
                                    <span class="placeholder-text">رقم الجوال</span>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="h6 m-0 fw-bold">عنوان الشحن</div>
                                <div class="input-wrapper">
                                    <input type="text" name="country" class="form-control" value="مصر" disabled required>
                                    <span class="placeholder-text">الدولة</span>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-wrapper">
                                            <input type="text" name="firstname" class="form-control" required>
                                            <span class="placeholder-text">الاسم الأول</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-wrapper">
                                            <input type="text" name="lastname" class="form-control" required>
                                            <span class="placeholder-text">الاسم الأخير</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input-wrapper">
                                            <input type="text" name="company" class="form-control">
                                            <span class="placeholder-text">الشركة (اختياري)</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input-wrapper">
                                            <input type="text" name="address" class="form-control" required>
                                            <span class="placeholder-text">العنوان</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="input-wrapper">
                                            <input type="text" name="address" class="form-control" required>
                                            <span class="placeholder-text">رقم العمارة - الشقة</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-wrapper">
                                            <select name="governorate" class="form-control" required>
                                                <option value="القاهرة">القاهرة</option>
                                                <option value="الجيزة">الجيزة</option>
                                                <option value="الأسكندرية">الأسكندرية</option>
                                                <option value="الدقهلية">الدقهلية</option>
                                                <option value="البحر الأحمر">البحر الأحمر</option>
                                                <option value="البحيرة">البحيرة</option>
                                                <option value="الفيوم">الفيوم</option>
                                                <option value="الغربية">الغربية</option>
                                                <option value="الإسماعلية">الإسماعلية</option>
                                                <option value="المنوفية">المنوفية</option>
                                                <option value="المنيا">المنيا</option>
                                                <option value="القليوبية">القليوبية</option>
                                                <option value="الوادي الجديد">الوادي الجديد</option>
                                                <option value="السويس">السويس</option>
                                                <option value="اسوان">اسوان</option>
                                                <option value="اسيوط">اسيوط</option>
                                                <option value="بني سويف">بني سويف</option>
                                                <option value="بورسعيد">بورسعيد</option>
                                                <option value="دمياط">دمياط</option>
                                                <option value="الشرقية">الشرقية</option>
                                                <option value="جنوب سيناء">جنوب سيناء</option>
                                                <option value="كفر الشيخ">كفر الشيخ</option>
                                                <option value="مطروح">مطروح</option>
                                                <option value="الأقصر">الأقصر</option>
                                                <option value="قنا">قنا</option>
                                                <option value="شمال سيناء">شمال سيناء</option>
                                                <option value="سوهاج">سوهاج</option>
                                            </select>   
                                            <span class="placeholder-text">المحافظة</span>
                                        </div>                                   
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-wrapper">
                                            <input type="text" name="city" class="form-control" required>
                                            <span class="placeholder-text">المدينة</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-wrapper">
                                            <input type="text" name="postalcode" class="form-control">
                                            <span class="placeholder-text">الرمز البريدي (اختياري)</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="alert alert-primary d-flex justify-content-between align-items-center mt-3 gap-2" role="alert">
                                    <div class="fs-14 fw500 d-flex align-items-center gap-2">
                                        <span class="pe pe-7s-credit h5 m-0"></span>
                                        رسوم الشحن الافتراضية
                                    </div>
                                    <div>100 جنيه</div>
                                </div>
                                <!-- <div class="checkout-details mt-4 rounded-4 p-4">
                                    <div class="">
                                        <div class="d-flex fw500 fs-14 justify-content-between align-items-center gap-2 flex-wrap">
                                            <span>سعر المنتجات</span>
                                            <span></span>
                                        </div>
                                        <div class="d-flex fw500 fs-14 justify-content-between align-items-center gap-2 flex-wrap mt-3">
                                            <span>رسوم الشحن</span>
                                            <span></span>
                                        </div>
                                        <div class="d-flex fs-14 total justify-content-between align-items-center fw-bold gap-2 flex-wrap mt-3">
                                            <span>الإجمالي</span>
                                            <span></span>
                                        </div>
                                    </div>
                                </div> -->
                                <button class="btn btn-primary w-100 p-3 mt-4 border-0" type="submit">إرسال الطلب</button>
                                <div class="note fs-14 fw500 text-muted d-flex gap-2 mt-3 align-items-center"> 
                                    <span class="pe pe-7s-box1 h5 m-0 fw500"></span>
                                    سيتم إرسال طلبك إلى المتجر والتواصل معك في أقرب وقت ممكن
                                </div>
                            </div>
                        </form>
                                
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .cart .details{
            min-width:200px;
            width: 350px;
        }
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


    <script>
        const content = document.getElementById('content');
        const cart = ( async () => {
            const localItems = localStorage.getItem('cart')

            if (!localItems) {
                return disableOverlay(true);
            } 
             
            const data = await getProducts(localItems)
            if (!data || data.length == 0) {
                return disableOverlay(true);
            }
            console.log(localItems)
            return showProducts(data);
        })
        
        const disableOverlay = ( status ) => {
            const preloader = document.getElementById('preloader');
            if (status) {
                preloader.classList.remove('active')
            } else {
                preloader.classList.add('active')
            }
        }
        const getProducts = (async (products) => {
            const URL = `<?= $_ENV['WEB_URL'] ?>/App/Controllers/Cart/Cart?getProducts=1&products=${products}`;
            
            try {
                const response = await fetch(URL)
                if (!response.ok) throw new Error('Failed to send request');
                // console.log(await response.text())
                return await response.json();
            } catch (err) {
                console.log(err)
                return false;
            }
        })
        let total = 100;
        const showProducts = (products) => {
            content.innerHTML = '';
            const cartItemsDiv = document.createElement('form')
            cartItemsDiv.method = 'POST'
            cartItemsDiv.classList.add('cart-itesm', 'mt-5')
            cartItemsDiv.id = 'cart'
            products.forEach( (item, index) => {
                let price = (item.price * item.quantity).toLocaleString("en-US");
                total += Number(item.price * item.quantity);
                cartItemsDiv.innerHTML += 
                `
                <div class="item d-flex justify-content-between align-items-center gap-md-3 gap-4 flex-wrap mt-4">
                    <div class="main-details d-flex gap-3 flex-row">
                        <img class="border" width="100" height="100" src="<?= public_url('uploads/products/') ?>${item.image}" alt="${item.name}">
                        <div class="d-flex flex-column gap-1">
                            <a href="#" class="h6 fw400">${item.name}</a>
                            <div class="fw300 fs-14 pricePerOne" price="${Number(item.price)}">${(item.price * 1).toLocaleString("en-US")} EGP</div>
                            <div class="fw300 fs-14">المقاس: ${item.size}</div>
                        </div>
                    </div>
                    <div class="d-flex gap-4 align-items-center">
                        <input type="hidden" name="ids[]" value="${item.id}">
                        <input type="hidden" name="sizes[]" value="${item.sizeId}">
                        <div class="qty-input">
                            <button class="qty-count qty-count--minus" data-action="minus" type="button">-</button>
                            <input class="product-qty" type="number" name="quantities[]" min="1" max="10" value="${item.quantity}" required>
                            <button class="qty-count qty-count--add" data-action="add" type="button">+</button>
                        </div>
                        <span class="pe pe-7s-trash fw500 pointer h5 m-0" onclick="removeItemFromCart(this, ${item.id}, ${item.sizeId})"></span>
                    </div>
                    <div class="position-relative">
                        <div class="price active finalPrice"><span>${(item.price * item.quantity).toLocaleString("en-US")}</span> EGP</div>
                        <span class="fa fa-spinner h5 m-0"></span>
                    </div>
                </div>
                `;
            })
            content.appendChild(cartItemsDiv)
            content.innerHTML += 
            `
            <hr class="my-4">
            <div class="details me-auto d-flex gap-3 flex-column">
                 <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <span>رسوم الشحن</span>
                    <span class="fw-bold">100 EGP</span>
                </div>
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <span>المبلغ الإجمالي</span>
                    <span class="fw-bold"><span id="$totalOrder">${(total).toLocaleString("en-US")}</span> EGP</span>
                </div>
                <button class="btn btn-dark p-3 text-white rounded-0 fs-14 px-4"  data-bs-toggle="modal" data-bs-target="#staticBackdrop">إكمال الطلب</button>
            </div>
            `;
            inputSettings()
            disableOverlay(true)
        }

    </script>


    <script>
        const inputSettings = () => {
            const QtyInput = (() => {
                const $qtyInputs = $(".qty-input");
                console.log($qtyInputs)
                if (!$qtyInputs.length) return;

                const $inputs = $qtyInputs.find(".product-qty");
                const $countBtn = $qtyInputs.find(".qty-count");

                $inputs.each(function () {
                    const $this = $(this);
                    const qtyMin = parseInt($this.attr("min"));
                    const qtyMax = parseInt($this.attr("max"));
                    const $minusBtn = $this.siblings(".qty-count--minus");
                    const $addBtn = $this.siblings(".qty-count--add");

                    // On load: disable buttons if needed
                    const currentVal = parseInt($this.val());
                    if (currentVal <= qtyMin) $minusBtn.attr("disabled", true);
                    if (currentVal >= qtyMax) $addBtn.attr("disabled", true);
                });

                // Handle change
                $inputs.on("change", function () {
                    const $this = $(this);
                    const $minusBtn = $this.siblings(".qty-count--minus");
                    const $addBtn = $this.siblings(".qty-count--add");

                    const qtyMin = parseInt($this.attr("min"));
                    const qtyMax = parseInt($this.attr("max"));
                    let qty = parseInt($this.val());

                    if (isNaN(qty) || qty < qtyMin) {
                        qty = qtyMin;
                    } else if (qty > qtyMax) {
                        qty = qtyMax;
                    }

                    $this.val(qty);

                    $minusBtn.attr("disabled", qty <= qtyMin);
                    $addBtn.attr("disabled", qty >= qtyMax);

                    changePrice(this, qty);
                });

                // Handle keyup (enforces input bounds + triggers change logic)
                $inputs.on("keyup", function () {
                    $(this).trigger("change");
                });

                // Handle plus/minus button clicks
                $countBtn.on("click", function () {
                    const operator = this.dataset.action;
                    const $this = $(this);
                    const $input = $this.siblings(".product-qty");

                    const qtyMin = parseInt($input.attr("min"));
                    const qtyMax = parseInt($input.attr("max"));
                    let qty = parseInt($input.val());

                    if (operator === "add") {
                        qty = Math.min(qty + 1, qtyMax);
                    } else {
                        qty = Math.max(qty - 1, qtyMin);
                    }

                    $input.val(qty).trigger("change"); 
                });
            })();
        }

        const removeItemFromCart = (elem, id, size) => {
            removeFromCart(id, size)
            window.location.reload()
        }
      
        const changePrice = (elem, quantity) => {
            const parent        = elem.parentElement.parentElement.parentElement
            const pricePerOne   = parent.querySelector('.pricePerOne')
            const price         = Number(pricePerOne.getAttribute('price')) * quantity
            const productTotal  = parent.querySelector('.finalPrice span')
            productTotal.innerText = price.toLocaleString("en-US")

            const siblings = Array.from(parent.parentElement.children).filter(child => true);
            total = 100;
            siblings.forEach( (item) => {
                let price = item.querySelector('.finalPrice span').innerText.replace(/[.,]/g, '');
                total += Number(price);
            })
            $totalOrder.innerText = total.toLocaleString("en-US")
        }
        
        setTimeout( () => { cart() }, 1500)
    </script>

    <script>
        const submitForms = ((form, e) => {
            e.preventDefault();
            const form1 = document.getElementById('cart');
            const form2 = document.getElementById('checkout');

            form1.querySelectorAll('.cloned-input').forEach(el => el.remove());
             const inputs = form2.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                if (!input.name) return;
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = input.name;
                hidden.value = input.value;
                hidden.classList.add('cloned-input'); 

                form1.appendChild(hidden);
            });

            form1.submit();
        })

    </script>


<?php include('public/components/footer.php'); ob_end_flush(); ?>
