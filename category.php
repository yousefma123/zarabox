<?php
    $settings = true;
    $page_title = "ZaraBox";
    require('init.php');
    use App\Controllers\Category\Category;
    $data = new Category();
    $category = $data->category;
?>
 

    <section class="categories py-5">
        <div class="container">
            <h1 class="h2 mb-5"><?= $category['name_ar'] ?></h1>
            <div class="row mt-5">
                <?php foreach($category['products'] as $product): ?>
                <div class="col-md-3 my-3">
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
        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<?php include('public/components/footer.php'); ?>
