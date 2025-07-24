<?php
    if(isset($settings)){
        if(isset($_SESSION['mainadmin']) && !isset($_SESSION['member'])){
?>
            <div class="customer-sidebar pt-3 pb-3" id="customer-sidebar">
                <span class="fa fa-arrow-right closeSidebar rounded-3" onclick="_toggle_customer_sidebar()"></span>
                <ul class="navbar-nav p-0">
                    <li class="nav-item mb-1">
                        <a href="<?= $url ?>/admin/home" class="p-2 pe-3 w-100 rounded-pill <?= $page_name == 'home' ?  'active' : '' ?>">
                            <span class="fa fa-home ms-3"></span>
                            الرئيسية
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a href="<?= $url ?>/admin/profile" class="p-2 pe-3 w-100 rounded-pill <?= $page_name == 'profile' ?  'active' : '' ?>">
                            <span class="fa fa-user ms-3"></span>
                            الملف الشخصي
                        </a>
                    </li>
                    <hr class="line-breek">
                    <span class="side-hint text-muted fs-7 p-2 pt-0 fw-bold">العملاء</span>
                    <li class="nav-item mb-1">
                        <a href="<?= $url ?>/admin/customers/create" class="p-2 pe-3 w-100 rounded-pill <?= $page_name == 'customers' ?  'active' : '' ?>">
                            <span class="fa fa-users ms-3"></span>
                            العملاء
                        </a>
                    </li>
                    <hr class="line-breek">
                    <span class="side-hint text-muted fs-7 p-2 pt-0 fw-bold">الطلبات والفواتير</span>
                    <li class="nav-item mb-1">
                        <a href="<?= $url ?>/admin/orders/create" class="p-2 pe-3 w-100 rounded-pill <?= $page_name == 'orders' ?  'active' : '' ?>">
                            <span class="fa fa-receipt ms-3"></span>
                            الطلبات
                        </a>
                    </li>
                    <hr class="line-breek">
                    <span class="side-hint text-muted fs-7 p-2 pt-0 fw-bold">الموارد البشرية</span>
                    <li class="nav-item mb-1">
                        <a href="<?= $url ?>/admin/employees/show" class="p-2 pe-3 w-100 rounded-pill <?= $page_name == 'show_employees' ?  'active' : '' ?>">
                            <span class="fa fa-user-tie ms-3"></span>
                            الموظفين
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a href="<?= $url ?>/admin/employees/create" class="p-2 pe-3 w-100 rounded-pill <?= $page_name == 'create_employee' ?  'active' : '' ?>">
                            <span class="fa fa-user ms-3"></span>
                            إضافة موظف
                        </a>
                    </li>
                    <li class="nav-item mb-1">
                        <a href="<?= $url ?>/admin/jobs/show" class="p-2 pe-3 w-100 rounded-pill <?= $page_name == 'show_job' ?  'active' : '' ?>">
                            <span class="fa fa-bars-progress ms-3"></span>
                            الوظائف
                        </a>
                    </li>
                    
                    <hr class="line-breek">
                    <span class="side-hint text-muted fs-7 p-2 pt-0 fw-bold">الإعدادات العامة</span>
                    <li class="nav-item mb-1">
                        <a href="<?= $url ?>/admin/settings/branches/create" class="p-2 pe-3 w-100 rounded-pill <?= $page_name == 'branches' ?  'active' : '' ?>">
                            <span class="fa fa-bars ms-3"></span>
                            إعدادات الفروع
                        </a>
                    </li>
                </ul>
            </div>

<?php }} ?>