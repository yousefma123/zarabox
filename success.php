<?php
    session_start();
    $settings = true;
    $page_title = "ZaraBox | Success page";
    require('init.php');
    use App\Controllers\Order\Order;
    if (isset($_SESSION['completed_order'])):
        echo 
        "
            <script>
                localStorage.removeItem('cart');
                console.log(localStorage.getItem('cart'))
            </script>
        ";
        unset($_SESSION['completed_order']);
    else:
        header('Location: index');
        exit;
    endif;
?>

    
    <div class="d-flex justify-content-center my-5 align-items-center" style="">
        <div class="col-md-6">
            <div class="border border-3 border-success"></div>
            <div class="card bg-white shadow p-5">
                <div class="mb-4 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-success" width="75" height="75"
                        fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path
                            d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                    </svg>
                </div>
                <div class="text-center">
                    <h2 class="mb-3">تم إرسال طلبك بنجاح للمتجر</h2>
                    <p>سيتم التواصل معك في أقرب وقت ممكن، يرجى الحرص على الرد على الرسائل أول المكالمات</p>
                    <a href="<?= $_ENV['WEB_URL'] ?>" class="btn btn-outline-success rounded-0  p-2 px-3 mt-2">الرجوع إلى المتجر</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

   
<?php include('public/components/footer.php'); ?>
