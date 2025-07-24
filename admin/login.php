<?php
    ob_start();
    session_start();
    use App\Controllers\Auth\Admin\Login;
    use App\Helpers\TokenCreator;
    require('../init.php');
    $settings = true;
    $page_title = "ZaraBox | Login";
    $dash = true;
    require( PUBLIC_PATH . '/components/dashboard/header.php' );
    $Login = new Login(new TokenCreator());
?>

    <div class="sign_page w-100 h-100">
        <div class="rgba"></div>
        <form class="sign-tap rounded-5 position-relative" method="POST" enctype="multipart/form-data"> 
            <div class="first-tap w-100 h-100 d-flex justify-content-center align-items-center flex-column p-3 ps-5 pe-5" tap="1">
                <h1 class="h5 mb-2 fw-bold text-center">مرحبا بك</h1>
                <p class="w-75 text-muted text-center">الدخول للوحة التحكم</p>
                <?php
                    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) $Login->index();
                ?>
                <div class="w-100">
                    <input type="hidden" name="csrf" class="mt-2 form-control" value="<?= $Login->setToken() ?>" required>
                </div>
                <div class="w-100">
                    <input type="text" name="email" class="mt-2 form-control" placeholder="البريد الإلكتروني" required>
                </div>
                <div class="w-100">
                    <input type="text" name="password" class="mt-1 form-control" placeholder="كلمة المرور" required>
                </div>
                <div class="w-100">
                    <button type="submit" name="login" class="btn btn-primary w-100 rounded-4 mt-2 d-flex justify-content-between align-items-center gap-3 ps-3 pe-3">
                        <span>دخول</span> 
                        <span class="fa fa-arrow-left"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>

<?php include( PUBLIC_PATH . "/components/dashboard/footer.php" ); ob_end_flush(); ?>