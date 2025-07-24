<?php
    if(isset($settings)){
?>  

        <footer class="p-5 px-2">
            <div class="container d-flex justify-content-between align-items-center gap-3 flex-wrap">
                <div class="footer-links d-flex gap-3 flex-wrap">
                    <a href="#">الرئيسية</a>
                    <a href="#">تواصل معنا</a>
                    <a href="#">عن المتجر</a>
                </div>
                <div class="fs-14">© 2025, Stanley Biggs Clothiers Powered by USS</div>
                <div class="media-links d-flex gap-4 flex-wrap">
                    <a href="#" class="fa fa-facebook"></a>
                    <a href="#" class="fa fa-x"></a>
                    <a href="#" class="fa fa-instagram"></a>
                    <a href="#" class="fa fa-whatsapp"></a>
                    <a href="#" class="fab fa-tiktok"></a>
                </div>
            </div>
        </footer>

        <script src="<?= public_url('layouts/js') ?>/bootstrap.bundle.js"></script>
        <script src="<?= public_url('layouts/js') ?>/bootstrap.popper.js"></script>
        <script src="<?= public_url('layouts/js') ?>/font.js"></script>

        <script src="<?= public_url('layouts/js') ?>/owl.carousel.js"></script>
        <script src="<?= public_url('layouts/js') ?>/owl.autoplay.js"></script>
        <script src="<?= public_url('layouts/js') ?>/owl.navigation.js"></script>
        <script src="<?= public_url('layouts/js') ?>/cart.js"></script>

        <script>
            if (window.history.replaceState){
                window.history.replaceState( null, null, window.location.href );
            }
        </script>
        
        <script src="<?= public_url('layouts/js') ?>/scripts.js"></script>

        <script>
        $(".owl-items").owlCarousel({
            loop: false,
            margin: 15,
            nav: true,
            dots: false,
            autoplay: true,
            autoplayHoverPause: false, 
            autoplayTimeout: 8000,
            rtl: true,
            responsive: {
                0: {
                    items: 1,
                    stagePadding: 70
                },
                500: {
                    items:2,
                    stagePadding: 50
                },
                900: {
                    items: 4,
                    stagePadding: 0
                }
                
            }
        });
    </script>
        
    </body>
</html>

<?php } ?>