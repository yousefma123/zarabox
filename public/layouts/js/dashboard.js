function _toggle_customer_sidebar()
{
    const customer_sidebar  = document.getElementById('customer-sidebar');
    const body              = document.getElementsByTagName('body')[0];
    const overlay           = document.getElementById('overlay');
    customer_sidebar.classList.toggle('customer_sidebar_toggled');
    overlay.classList.toggle('overlay-toggled');
    body.classList.toggle('overflow-hidden');
}