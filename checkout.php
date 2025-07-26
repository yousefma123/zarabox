<?php
    $settings = true;
    $page_title = "ZaraBox";
    require('init.php');
?>

    <style>
        body {
            background-color: #fff !important;
        }
    </style>

    <section class="checkout px-2">
        <div class="container">
            <div class="row">
                <div class="col-md-7 mx-auto py-5">
                    <form class="info w-100">
                        <div class="mt-4">
                            <div class="h6 m-0 fw-bold">التواصل</div>
                            <div class="input-wrapper">
                                <input type="text" name="email" class="form-control" required>
                                <span class="placeholder-text">البريد الإلكتروني</span>
                            </div>
                            <div class="input-wrapper input-group mb-3" dir="ltr">
                                <span class="input-group-text" id="basic-addon1">+20</span>
                                <input type="text" class="form-control" aria-label="Phone" aria-describedby="basic-addon1" required>
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
                            <div class="checkout-details mt-4 rounded-4 p-4">
                                <div class="">
                                    <div class="d-flex fw500 fs-14 justify-content-between align-items-center gap-2 flex-wrap">
                                        <span>سعر المنتجات</span>
                                        <span>73,847.24 EGP</span>
                                    </div>
                                    <div class="d-flex fw500 fs-14 justify-content-between align-items-center gap-2 flex-wrap mt-3">
                                        <span>رسوم الشحن</span>
                                        <span>100 EGP</span>
                                    </div>
                                    <div class="d-flex fs-14 total justify-content-between align-items-center fw-bold gap-2 flex-wrap mt-3">
                                        <span>الإجمالي</span>
                                        <span>73,947.24 EGP</span>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary w-100 p-3 mt-4 border-0">إرسال الطلب</button>
                            <div class="note fs-14 fw500 text-muted d-flex gap-2 mt-3 align-items-center"> 
                                <span class="pe pe-7s-box1 h5 m-0 fw500"></span>
                                 سيتم إرسال طلبك إلى المتجر والتواصل معك في أقرب وقت ممكن
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<?php include('public/components/footer.php'); ?>
  