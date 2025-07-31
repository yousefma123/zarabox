<?php
    if(isset($settings)){
?>  
    <header class="text-center border-bottom d-flex align-items-center justify-content-between flex-lg-column flex-row gap-3 p-2 py-lg-4 py-0 h-auto position-relative">
        <div class="container d-flex justify-content-between align-items-center gap-3 d-lg-flex d-none w-100">
            <div class="navicons d-flex gap-3 align-items-center">
                <a href="<?= $_ENV['WEB_URL'] ?>/cart">
                    <span class="fa fa-box"></span>
                    <div class="rounded-4 cart_count d-none">0</div>
                </a>
                <a href="<?= $_ENV['WEB_URL'] ?>/admin/login"><span class="fa fa-user"></span></a>
            </div>
            <a class="navbar-brand" id="logo" href="<?= $_ENV['WEB_URL'] ?>">
                <img width="120px" height="" src="<?= public_url('uploads/logos/logo.png') ?>" alt="<?= $_ENV['WEB_NAME'] ?>">  
            </a>
            <div></div>
        </div>
        <nav class="navbar pb-0 navbar-expand-lg navbar-light bg-none w-lg-auto w-100 mx-lg-auto me-auto position-relative py-2">
            <div class="container-fluid">
                <a class="navbar-brand d-lg-none d-block" href="<?= $_ENV['WEB_URL'] ?>">
                    <img width="70px" height="" src="<?= public_url('uploads/logos/logo.png') ?>" alt="<?= $_ENV['WEB_NAME'] ?>">  
                </a>
                <div class="d-lg-none d-flex gap-4 align-items-center">
                    <div class="navicons d-flex gap-3 align-items-center">
                        <a href="<?= $_ENV['WEB_URL'] ?>/cart">
                            <span class="fa fa-box"></span>
                            <div class="rounded-4 cart_count d-none">0</div>
                        </a>
                        <a href="<?= $_ENV['WEB_URL'] ?>/admin/login"><span class="fa fa-user"></span></a>
                    </div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="fa fa-bars"></span>
                    </button>
                </div>
                
                <div class="collapse navbar-collapse d-lg-flex justify-content-center" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?= $_ENV['WEB_URL'] ?>">الرئيسية</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">عن المتجر</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">توصل معنا</a>
                        </li>
                        <?php foreach($home->categories()['fetchAll'] as $cat): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $_ENV['WEB_URL'] ?>/category?n=<?= str_replace([' ',',','.', '@','،'], '-', $cat['name_ar']) ?>&id=<?= $cat['id'] ?>"><?= $cat['name_ar'] ?></a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

<?php } ?>
