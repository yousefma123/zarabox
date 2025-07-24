<?php 

    namespace App\Helpers;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    class Mailer {

        public function __construct(PHPMailer $mail, 
            string $subject,
            string $text,
            string $sender_email,
            mixed $recipter_email,
            string $full_name)
        {
          $mail->SetLanguage("ar", 'includes/phpMailer/language/phpmailer.lang-ar');
          try {
              $mail->SMTPDebug = 0;                      
              $mail->isSMTP();                                            
              $mail->Host       = 'smtp.gmail.com';                     
              $mail->SMTPAuth   = true;                          
              $mail->Username   = 'testmailer525@gmail.com';                
              $mail->Password   = 'chxptuxvwmtomlpr';                              
              $mail->SMTPSecure = 'PHPMailer::ENCRYPTION_SMTPS';            
              $mail->Port       = 587;                                   
              $mail->CharSet = 'utf-8';
              $mail->setFrom($sender_email, $full_name);
              if(gettype($recipter_email) == 'array'){
                  foreach($recipter_email as $email){
                    $mail->addAddress($email); 
                  }
              }else{
                $mail->addAddress($recipter_email); 
              }
              $mail->isHTML(true);                          
              $mail->Subject = $subject;
              $mail->Body    = $text;
              $mail->send();
              return true;
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }

    }