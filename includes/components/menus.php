<?php 
    if(isset($settings)){
        if(isset($_POST['date_filter']) && !empty($_POST['date_filter'])):
            setcookie('date_filter', $_POST['date_filter'], time() + 86400, "/");
        endif;
        $current_date = $_POST['date_filter'] ?? $_COOKIE['date_filter'] ?? date('Y-m');
        if(isset($_SESSION['mainadmin'])){
?>
    <div id="overlay" onclick="_toggle_customer_sidebar()"></div>
    <nav class="navbar ps-3 pe-3 fixed-top">
        <div class="container h-auto">
            <div class="m-0 navbar-brand ms-2" style="position:relative;top:-2px;">
                <span class="fa fa-bars ms-2 position-relative customer-navbar-bars d-none" style="top:2px;" onclick="_toggle_customer_sidebar()"></span>
                <a href="<?= $url ?>/admin/home">
                    <img width="40" height="35" src="<?= $url ?>/includes/uploads/images/<?= $Functions->select("`value`", "`settings`", "fetch", "WHERE `name` = 'logo'")['fetch']['value']; ?>" alt="Technobond">
                </a>
            </div>
            <ul class="navbar-nav flex-row">
                <li>
                     <form method="POST">
                         <input type="month"  name="date_filter" class="form-control w-100 rounded-4" style="font-size:11px" value="<?= isset($current_date) ? $current_date : date('Y-m') ?>" onchange="_set_date_filter(this)">
                     </form>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-2 w-100" href="<?= $url ?>/logout">
                        <button class="btn btn-default rounded-pill btn-system ps-4 pe-4">خروج</button>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
<?php }else if(isset($_SESSION['employee'])){ ?>
    <div id="overlay" onclick="_toggle_customer_sidebar()"></div>
    <nav class="navbar ps-3 pe-3 fixed-top">
        <div class="container h-auto">
            <div class="m-0 navbar-brand ms-2" style="position:relative;top:-2px;">
                <span class="fa fa-bars ms-2 position-relative customer-navbar-bars d-none" style="top:2px;" onclick="_toggle_customer_sidebar()"></span>
                <a href="<?= $url ?>/employee/home">
                    <img width="40" height="40" class="rounded-circle" src="<?= $url ?>/includes/uploads/users_images/<?= $myData['image'] ?>" alt="Technobond">
                </a>
            </div>
            <ul class="navbar-nav flex-row">
                <li>
                     <form method="POST">
                         <input type="month"  name="date_filter" class="form-control w-100 rounded-4" style="font-size:11px" value="<?= isset($current_date) ? $current_date : date('Y-m') ?>" onchange="_set_date_filter(this)">
                     </form>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-2 w-100" href="<?= $url ?>/logout">
                        <button class="btn btn-default rounded-pill btn-system ps-4 pe-4">خروج</button>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
<?php } } ?>
