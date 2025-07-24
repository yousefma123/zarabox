<?php
    if(isset($settings)){
?>  
        <!-- <div id="show_siri_results" class="position-fixed p-3 rounded-3 shadow-sm d-none">
            <div class="fs-7 fw-bold mb-2 d-flex justify-content-between align-items-center flex-wrap gap-3">
                <span class="fw-bold">البحث بواسطة الرقم: <strong></strong></span>
                <span class="fa fa-times h6 m-0" onclick="_hideSiriResults()"></span>
            </div>
            <div class="triangle"></div>
            <ul class="list-unstyled p-0 m-0 h-100"></ul>
        </div> -->

        <script src="<?= $url ?>/includes/layouts/js/bootstrap.bundle.js"></script>
        <script src="<?= $url ?>/includes/layouts/js/bootstrap.popper.js"></script>
        <script src="<?= $url ?>/includes/layouts/js/font.js"></script>

        <script>
            function toggleSide(){
                const sidebar = document.querySelector('aside');
                const content = document.querySelector('.content');
                sidebar.classList.toggle('sidebar-toggle');
                content.classList.toggle('content-toggle');
            }
            if (window.history.replaceState){
                window.history.replaceState( null, null, window.location.href );
            }
            const _set_date_filter = (elem) => {
                 elem.parentElement.submit();
             }
        </script>
        
        
        <script src="<?= $url ?>/includes/layouts/js/scripts.js"></script>
        
        
    </body>
    </html>

<?php } ?>