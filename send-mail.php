<?php

$name       =   $_POST['name'];
$Email      =   $_POST['email'];
@$website    =   $_POST['url'];
$texto      =   $_POST['message'];

        $subject = 'Contato site - WK'. "\r\n";
        @$message .=  'Nome: ' . $name. "\r\n";
        @$message .=  'E-mail: ' . $email. "\r\n";
        $message .=  $texto . "\r\n";
        $headers = 'From: contato@consultoriawk.com' . "\r\n" .
            'Reply-To: cristian@consultoriawk.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail("contato@consultoriawk.com", $subject, $message, $headers);


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script>alert("Sua mensagem foi enviada com sucesso, logo lhe daremos um retorno.");</script>
<meta HTTP-EQUIV="REFRESH" content="0; url=index.php">

</head>