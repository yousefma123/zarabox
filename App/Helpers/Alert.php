<?php 

    namespace App\Helpers;

    class Alert {

        public function push($text = 'رسالة من النظام', $clss = '', $duration = 5000)
        {
            echo 
            "
                <script>
                    Toastify({
                        text: '$text',
                        className: '$clss',
                        duration: $duration,
                        newWindow: true,
                        close: false,
                        gravity: 'top',
                        position: 'left',
                        stopOnFocus: true,
                        style: {
                            background: 'linear-gradient(to right, #00b09b, #96c93d)',
                        },
                    }).showToast();
                </script>
            ";
        }

    }