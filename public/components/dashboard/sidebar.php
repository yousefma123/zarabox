<?php if(isset($_SESSION['admin']) && isset($dash)): ?>
    <div class="customer-sidebar pt-3 pb-3" id="customer-sidebar">
        <span class="fa fa-arrow-right closeSidebar rounded-3" onclick="_toggle_customer_sidebar()"></span>
        <ul class="navbar-nav p-0">
            <li class="nav-item mb-1">
                <a href="<?= $_ENV['WEB_URL'] ?>/admin/home" class="p-2 pe-3 w-100 rounded-pill <?= $page_name == 'home' ?  'active' : '' ?>">
                    <span class="fa fa-home ms-3"></span>
                    الرئيسية
                </a>
            </li>
            <!-- <li class="nav-item mb-1">
                <a href="<?= $_ENV['WEB_URL'] ?>/admin/profile" class="p-2 pe-3 w-100 rounded-pill <?= $page_name == 'profile' ?  'active' : '' ?>">
                    <span class="fa fa-user ms-3"></span>
                    الملف الشخصي
                </a>
            </li> -->
            <hr class="line-breek">
            <span class="side-hint text-muted fs-7 p-2 pt-0 fw-bold">الطلبات والفواتير</span>
            <li class="nav-item mb-1">
                <a href="<?= $_ENV['WEB_URL'] ?>/admin/orders/show" class="p-2 pe-3 w-100 rounded-pill <?= $page_name == 'orders.show' ?  'active' : '' ?>">
                    <span class="fa fa-receipt ms-3"></span>
                    الطلبات
                </a>
            </li>
            <hr class="line-breek">
            <span class="side-hint text-muted fs-7 p-2 pt-0 fw-bold">الأقسام</span>
            <li class="nav-item mb-1">
                <a href="<?= $_ENV['WEB_URL'] ?>/admin/categories/show" class="p-2 pe-3 w-100 rounded-pill <?= $page_name == 'categories.show' ?  'active' : '' ?>">
                    <span class="fa fa-bars ms-3"></span>
                    عرض
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="<?= $_ENV['WEB_URL'] ?>/admin/categories/create" class="p-2 pe-3 w-100 rounded-pill <?= $page_name == 'categories.create' ?  'active' : '' ?>">
                    <span class="fa fa-bars ms-3"></span>
                    إضافة
                </a>
            </li>
            <hr class="line-breek">
            <span class="side-hint text-muted fs-7 p-2 pt-0 fw-bold">المنتجات</span>
            <li class="nav-item mb-1">
                <a href="<?= $_ENV['WEB_URL'] ?>/admin/products/show" class="p-2 pe-3 w-100 rounded-pill <?= $page_name == 'products.show' ?  'active' : '' ?>">
                    <span class="fa fa-bars ms-3"></span>
                    عرض
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="<?= $_ENV['WEB_URL'] ?>/admin/products/create" class="p-2 pe-3 w-100 rounded-pill <?= $page_name == 'products.create' ?  'active' : '' ?>">
                    <span class="fa fa-bars ms-3"></span>
                    إضافة
                </a>
            </li>
        </ul>
    </div>
<?php endif; ?>