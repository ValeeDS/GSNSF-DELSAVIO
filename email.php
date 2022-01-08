<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'mail.valeriadelsavio.com.ar';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'contacto@valeriadelsavio.com.ar';                     //SMTP username
    $mail->Password   = 'WKkAJ+duXgtP';                         //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 465;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('contacto@valeriadelsavio.com.ar', 'Valeria Del Savio'); // Hacer coincidir con el username. (preferentemente)
    $mail->addAddress($_POST['email'], $_POST['name']);
    $mail->addReplyTo($_POST['email'], $_POST['name']);
    //$mail->addCC('cc@example.com');
    $mail->addBCC('contacto@valeriadelsavio.com.ar', 'Valeria Del Savio');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Consulta de: '.$_POST['name'];
    $mail->Body    =
        'Hola '.$_POST['name'].','.
        '<br><br>Enviaste una consulta a la página GSNSF. Acá abajo te dejo tus respuestas al formulario:'.
        '<br><br>Nombre: '.$_POST['name'].
        '<br>Apellido: '.$_POST['last-name'].
        '<br>Email: '.$_POST['email'].
        '<br>Teléfono: '.$_POST['phone'].
        '<br>Mensaje: '.$_POST['message'];
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    header("location: gracias.html");
} catch (Exception $e) {
    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    header("location: error.html");
}

?>