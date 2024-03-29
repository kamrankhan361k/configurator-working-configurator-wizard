<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="CONFIGURATOR Multipurpose Working Configurator Wizard">
    <meta name="author" content="Ansonika">
    <title>CONFIGURATOR | Multipurpose Working Configurator Wizard</title>

    <!-- GOOGLE WEB FONT -->
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300,400,400i,700" rel="stylesheet">

    <!-- BASE CSS -->
    <link href="../css/style.css" rel="stylesheet">

    <!-- YOUR CUSTOM CSS -->
    <link href="../css/custom.css" rel="stylesheet">
    
    <script type="text/javascript">
    function delayedRedirect(){
        window.location = "../index.html"
    }
    </script>
</head>

<body onLoad="setTimeout('delayedRedirect()', 5000)">
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';

$mail = new PHPMailer(true);

try {

    //Recipients - main edits
    $mail->setFrom('info@configurator.com', 'Message from Configurator');                    // Email Address and Name FROM
    $mail->addAddress('jhon@configurator.com', 'Jhon Doe');                           // Email Address and Name TO - Name is optional
    $mail->addReplyTo('noreply@configurator.com', 'Message from Configurator');              // Email Address and Name NOREPLY
    $mail->isHTML(true);                                                       
    $mail->Subject = 'Message from Configurator';                                     // Email Subject

     //The email body message
    $message = "DETAILS<br />";
    $message .= "Product: " . $_POST['answer_group_1'] . "<br />";
    $message .= "Processor: " . $_POST['answer_group_2'] . "<br />";
    $message .= "Memory: " . $_POST['answer_group_3'] . "<br />";
    $message .= "Storage: " . $_POST['answer_group_4'] . "<br />";
    
    $message .= "<br />Optional Products:<br />" ;
    foreach($_POST['answers_5'] as $value) 
        { 
        $message .=   "- " .  trim(stripslashes($value)) . "<br />"; 
    };
    
    $message .= "<br />TOTAL: " . $_POST['hidden_total'] . "<br />";
    $message .= "<br /USER DETAILS" ;
    $message .= "Name and Lastname: " . $_POST['first_last_name'] . "<br />";
    $message .= "Email: " . $_POST['email'] . "<br />";
    $message .= "Telephone " . $_POST['telephone'] . "<br />";
    $message .= "Country: " . $_POST['country'] . "<br />";
    $message .= "Terms and conditions accepted: " . $_POST['terms'] . "<br />";

     // Get the email's html content
    $email_html = file_get_contents('template-email.html');

    // Setup html content
    $body = str_replace(array('message'),array($message),$email_html);
    $mail->MsgHTML($body);

    $mail->send();

    // Confirmation/autoreplay email send to who fill the form
    $mail->ClearAddresses();
    $mail->addAddress($_POST['email']); // Email address entered on form
    $mail->isHTML(true);
    $mail->Subject    = 'Confirmation'; // Custom subject

    // Get the email's html content
    $email_html_confirm = file_get_contents('confirmation.html');

    // Setup html content
    $body = str_replace(array('message'),array($message),$email_html_confirm);
    $mail->MsgHTML($body);

    $mail->Send();

    echo '<div id="success">
            <div class="icon icon--order-success svg">
                 <svg xmlns="http://www.w3.org/2000/svg" width="72px" height="72px">
                  <g fill="none" stroke="#8EC343" stroke-width="2">
                     <circle cx="36" cy="36" r="35" style="stroke-dasharray:240px, 240px; stroke-dashoffset: 480px;"></circle>
                     <path d="M17.417,37.778l9.93,9.909l25.444-25.393" style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;"></path>
                  </g>
                 </svg>
             </div>
            <h4><span>Order successfully sent!</span>Thank you for your time</h4>
            <small>You will be redirect back in 5 seconds.</small>
        </div>';
	} catch (Exception $e) {
	    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
	
?>
<!-- END SEND MAIL SCRIPT -->   

</body>
</html>