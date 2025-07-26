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
              $mail->Host       = $_ENV['MAIL_HOST'];                     
              $mail->SMTPAuth   = true;                          
              $mail->Username   = $_ENV['MAIL_USER'];                
              $mail->Password   = $_ENV['MAIL_PASS'];                              
              $mail->SMTPSecure = 'PHPMailer::ENCRYPTION_SMTPS';            
              $mail->Port       = $_ENV['MAIL_PORT'];                                   
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