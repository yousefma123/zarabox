<?php
    $settings = true;
    $page_title = "ZaraBox | Order tracker";
    require('init.php');
    use App\Controllers\Order\Order;
    $order = (new order())->tracking();
    $total = 0;
?>

    <style>
        .card {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: transparent;
        }
        .card-header:first-child {
            border-radius: calc(0.37rem - 1px) calc(0.37rem - 1px) 0 0;
        }
        .card-header {
            padding: 0.75rem 1.25rem;
            margin-bottom: 0;
            background-color: transparent;
            font-weight:bold;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }
        .track {
            position: relative;
            background-color: #ddd;
            height: 7px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            margin-bottom: 70px;
            margin-top: 65px;
        }
        .track .step {
            -webkit-box-flex: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
            width: 25%;
            margin-top: -18px;
            text-align: center;
            position: relative;
        }
        .track .step.active:before {
            background: #ff5722;
        }
        .track .step::before {
            height: 7px;
            position: absolute;
            content: "";
            width: 100%;
            left: 0;
            top: 18px;
        }
        .track .step.active .icon {
            background: #ee5435;
            color: #fff;
        }
        .track .icon {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            position: relative;
            border-radius: 100%;
            background: #ddd;
        }
        .track .step.active .text {
            font-weight: 400;
            color: #000;
        }
        .track .text {
            display: block;
            margin-top: 15px;
            font-size:14px;
        }
        .itemside {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            width: 100%;
        }
        .itemside .aside {
            position: relative;
            -ms-flex-negative: 0;
            flex-shrink: 0;
        }
        .img-sm {
            width: 80px;
            height: 80px;
            padding: 7px;
        }
        ul.row,
        ul.row-sm {
            list-style: none;
            padding: 0;
        }
        .itemside .info {
            padding-left: 15px;
            padding-right: 7px;
        }
        .itemside .title {
            display: block;
            margin-bottom: 5px;
            color: #212529;
        }
        p {
            margin-top: 0;
            margin-bottom: 1rem;
        }
        .btn-warning {
            color: #ffffff;
            background-color: #ee5435;
            border-color: #ee5435;
            border-radius: 1px;
        }
        .btn-warning:hover {
            color: #ffffff;
            background-color: #ff2b00;
            border-color: #ff2b00;
            border-radius: 1px;
        }

    </style>

    <div class="container py-5" style="min-height: calc(100vh - 130px);">
        <article class="card rounded-4 border-0  px-3">
            <header class="card-header">تتبع الطلب</header>
            <div class="card-body">
                <h6>رقم الطلب: <?= $order['code'] ?></h6>
                <article class="card mt-3">
                    <div class="card-body row text-center">
                        <div class="col d-flex flex-column gap-2"> <strong>وقت التوصيل المتوقع:</strong> <span> 20-10-2025 </span> </div>
                        <div class="col d-flex flex-column gap-2"> <strong>حالة الطلب:</strong> <span> خرجت الشحنة للتسليم </span> </div>
                        <div class="col d-flex flex-column gap-2"> <strong>رقم التتبع #:</strong> <span> <?= $order['code'] ?> </span> </div>
                    </div>
                </article>
                <div class="track">
                    <div class="step active"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">تم إرسال الطلب</span> </div>
                    <div class="step"> <span class="icon"> <i class="fa fa-check"></i> </span> <span class="text">تم تأكيد الطلب</span> </div>
                    <div class="step"> <span class="icon"> <i class="fa fa-truck"></i> </span> <span class="text"> في الطريق للتسليم </span> </div>
                    <div class="step"> <span class="icon"> <i class="fa fa-box"></i> </span> <span class="text">تم التوصيل</span> </div>
                </div>
                <hr>
                <div class="cart py-4" style="min-height:auto !important;">
                    <div class="container">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <h5 class="">المنتجات</h5>
                        </div>
                        <div id="content">
                        <?php foreach ($order['items'] as $item): $total += $item['total']; ?>
                            <div class="item d-flex justify-content-between align-items-center gap-md-3 gap-4 flex-wrap mt-4">
                                <div class="main-details d-flex gap-3 flex-row">
                                    <img class="border" width="100" height="100"
                                        src="<?= public_url('uploads/products/' . $item['image']) ?>" 
                                        alt="<?= htmlspecialchars($item['product_name']) ?>">
                                    <div class="d-flex flex-column gap-1">
                                        <a href="#" class="h6 fw400"><?= htmlspecialchars($item['product_name']) ?></a>
                                        <div class="fw300 fs-14 pricePerOne" price="<?= (float) $item['total'] / (int) $item['quantity'] ?>">
                                            <?= number_format((float) $item['total'] / (int) $item['quantity']) ?> EGP
                                        </div>
                                        <div class="fw300 fs-14">المقاس: <?= htmlspecialchars($item['size']) ?></div>
                                    </div>
                                </div>
                                <div class="d-flex gap-4 align-items-center">
                                    الكمية: <?= (int) $item['quantity'] ?>
                                </div>
                                <div class="position-relative">
                                    <div class="price active finalPrice">
                                        <span><?= number_format($item['total']) ?></span> EGP
                                    </div>
                                    <span class="fa fa-spinner h5 m-0"></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="details me-auto d-flex gap-3 flex-column">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <span>رسوم الشحن</span>
                        <span class="fw-bold">100 EGP</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <span>المبلغ الإجمالي</span>
                        <span class="fw-bold"><span id="$totalOrder"><?= number_format($total) ?></span> EGP</span>
                    </div>
                </div>
            </div>
        </article>
    </div>

<?php include('public/components/footer.php'); ?>
