
<?php
require_once("../phpmailer/class.phpmailer.php");

// Check for empty fields
if (
   empty($_POST['name'])      ||
   empty($_POST['email'])     ||
   empty($_POST['phone'])     ||
   empty($_POST['message'])   ||
   !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
) {
   echo "No arguments Provided!";
   return false;
}

$name = strip_tags(htmlspecialchars($_POST['name']));
$email_address = strip_tags(htmlspecialchars($_POST['email']));
$phone = strip_tags(htmlspecialchars($_POST['phone']));
$message = strip_tags(htmlspecialchars($_POST['message']));

// Create the email and send the message
$to = 'e2compjr@gmail.com'; // Add your email address in between the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
$email_subject = "Contato Abrace o HU:  $name";
$email_body = "Mensagem enviada pelo site.\n\n" . "Detalhes:\nNome: $name\nEmail: $email_address\nTelefone: $phone\nMensagem:\n$message";
$headers = "From: e2compjr@gmail.com\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
$headers .= "Reply-To: $email_address";

define('GUSER', 'enviador@gmail.com');   // <-- Insira aqui o seu GMail
define('GPWD', 'senha');      // <-- Insira aqui a senha do seu GMail

// ini_set("SMTP","ssl://smtp.gmail.com");
// ini_set("smtp_port","465");

function smtpmailer($para, $de, $de_nome, $assunto, $corpo)
{
   global $error;
   $mail = new PHPMailer();
   $mail->IsSMTP();      // Ativar SMTP
   $mail->SMTPDebug = 0;      // Debugar: 1 = erros e mensagens, 2 = mensagens apenas
   $mail->SMTPAuth = true;      // Autenticação ativada
   $mail->SMTPSecure = 'ssl';   // SSL REQUERIDO pelo GMail
   $mail->Host = 'smtp.gmail.com';   // SMTP utilizado
   $mail->Port = 465;        // A porta 587 deverá estar aberta em seu servidor
   $mail->Username = 'e2compjr@gmail.com';
   $mail->Password = 'e2compuepg2020';
   $mail->SetFrom($de, $de_nome);
   $mail->Subject = $assunto;
   $mail->Body = $corpo;
   $mail->AddAddress($para);
   if (!$mail->Send()) {
      $error = 'Mail error: ' . $mail->ErrorInfo;
      echo $error;
      return false;
   } else {
      $error = 'Mensagem enviada!';
      echo "";
      return true;
   }
}

// Insira abaixo o email que irá receber a mensagem, o email que irá enviar (o mesmo da variável GUSER), 
// o nome do email que envia a mensagem, o Assunto da mensagem e por último a variável com o corpo do email.

smtpmailer($to, $to, $name, $email_subject, $email_body);

?>