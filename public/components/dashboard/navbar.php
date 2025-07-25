<?php if (isset($_SESSION['admin']) && isset($dash)): ?>

<div id="overlay" onclick="_toggle_customer_sidebar()"></div>
    <nav class="navbar ps-3 pe-3 fixed-top">
    <div class="container h-auto">
        <div class="m-0 navbar-brand ms-2" style="position:relative;top:-2px;">
            <span class="fa fa-bars ms-2 position-relative customer-navbar-bars d-none" style="top:2px;" onclick="_toggle_customer_sidebar()"></span>
            <a href="<?= $_ENV['WEB_URL'] ?>/admin/home">
                <img width="40" height="40" src="<?= public_url('uploads/logos/') . $statement->select('value', 'settings', 'fetch', "WHERE `key` = 'logo'")['fetch']['value'] ?>" alt="ZaraBox">
            </a>
        </div>
        <ul class="navbar-nav flex-row">
            <li class="nav-item">
                <a class="nav-link me-2 w-100" href="<?= $_ENV['WEB_URL'] ?>/logout">
                    <button class="btn btn-default rounded-pill btn-system ps-4 pe-4">خروج</button>
                </a>
            </li>
        </ul>
    </div>
</nav>

<?php endif; ?>