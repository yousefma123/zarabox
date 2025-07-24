<?php
    if(isset($settings)){
?>  

        <script src="<?= $url ?>/includes/layouts/js/bootstrap.bundle.js"></script>
        <script src="<?= $url ?>/includes/layouts/js/bootstrap.popper.js"></script>
        <script src="<?= $url ?>/includes/layouts/js/font.js"></script>

        <script src="<?= $url ?>/includes/layouts/js/owl.carousel.js"></script>
        <script src="<?= $url ?>/includes/layouts/js/owl.autoplay.js"></script>
        <script src="<?= $url ?>/includes/layouts/js/owl.navigation.js"></script>

        <script>
            if (window.history.replaceState){
                window.history.replaceState( null, null, window.location.href );
            }
        </script>
        
        
        <script src="<?= $url ?>/includes/layouts/js/scripts.js"></script>
        
    </body>
    </html>

<?php } ?>