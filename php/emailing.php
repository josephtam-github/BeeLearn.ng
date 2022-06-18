<?php

$autoload_url = "".$_SERVER["DOCUMENT_ROOT"]."/beelearn/vendor/autoload.php";
require_once $autoload_url;
require_once 'password.php';


function SendVerificationEmail($userEmail, $token){
    global $mailer;
    //message body
    $messageBody = "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Verify email </title>
        <link rel='preconnect' href='https://fonts.gstatic.com'>
        <link href='https://fonts.googleapis.com/css2?family=Montserrat:wght@200&display=swap' rel='stylesheet'>
        <style>
            body{
                background-color: rgb(255, 173, 1);
                font-family: 'Montserrat', sans-serif;
                display: flex;
                font-size: 1rem;
            }
        </style>
    </head>
    <body>
        <div style='margin-left: auto; margin-right: auto; width:50%; margin-top: 100px; border-radius: 30px; background-color: rgb(255, 173, 1); padding: 30px; text-align: center;'>
            <div>
                <img src='http://localhost/beelearn/images/logo.svg' alt='BeeLearn.ng' style='width: 150px; height: auto;'>
            </div>
            <p style='font-weight: bold; text-align: justify;'>Thank you for signing up on our website. Please click the button below to verify your email.</p>
            <div>
               <a href=\"http://localhost/beelearn/landing.php?token=$token\"><button style='font-size: 15px; margin: 25px; color: white; border-style: none; background-color: black; padding: 10px; border-radius: 10px;'> verify </button></a>
            </div>
            <div>
            <small style='color: white; text-align: center;'>If you did not sign up for this email, please kindly ignore</small>
            </div>
        </div>
    </body>
    </html>";

        // Create a message
        $message = (new Swift_Message('Account verification link | BeeLearn.ng'))
        ->setFrom(ENAME)
        ->setTo($userEmail)
        ->setBody($messageBody, 'text/html')
        ; 

        // Send the message
        $result = $mailer->send($message);

}

function notifyReply($userName, $userEmail, $userComment){
    global $mailer;
    //message body
    $messageBody = "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Verify email </title>
        <link rel='preconnect' href='https://fonts.gstatic.com'>
        <link href='https://fonts.googleapis.com/css2?family=Montserrat:wght@200&display=swap' rel='stylesheet'>
        <style>
            body{
                background-color: rgb(255, 173, 1);
                font-family: 'Montserrat', sans-serif;
                display: flex;
                font-size: 1rem;
            }
        </style>
    </head>
    <body>
        <div style='margin-left: auto; margin-right: auto; width:50%; margin-top: 100px; border-radius: 30px; background-color: rgb(255, 173, 1); padding: 30px; text-align: center;'>
            <div>
                <img src='http://localhost/beelearn/images/logo.svg' alt='BeeLearn.ng' style='width: 150px; height: auto;'>
            </div>
            <p style='font-weight: bold; text-align: left;'> Hello ".$userName.", a user just replied to your comment saying: </p>
			<blockquote  style='text-align: justify;'> \"".$userComment."\" </blockquote>
        </div>
    </body>
    </html>;
";

        // Create a message
        $message = (new Swift_Message("Hello ".$userName." someone has replied your comment| BeeLearn.ng"))
        ->setFrom(ENAME)
        ->setTo($userEmail)
        ->setBody($messageBody, 'text/html')
        ; 

        // Send the message
        $result = $mailer->send($message);

}



function sendResetMail($retrieveEmail, $userName, $resetToken, $userId){
    global $mailer;
    //message body
    $messageBody = "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Verify email </title>
        <link rel='preconnect' href='https://fonts.gstatic.com'>
        <link href='https://fonts.googleapis.com/css2?family=Montserrat:wght@200&display=swap' rel='stylesheet'>
        <style>
            body{
                background-color: rgb(255, 173, 1);
                font-family: 'Montserrat', sans-serif;
                display: flex;
                font-size: 1rem;
            }
        </style>
    </head>
    <body>
        <div style='margin-left: auto; margin-right: auto; width:50%; margin-top: 100px; border-radius: 30px; background-color: rgb(255, 173, 1); padding: 30px; text-align: center;'>
            <div>
                <img src='http://localhost/beelearn/images/logo.svg' alt='BeeLearn.ng' style='width: 150px; height: auto;'>
            </div>
            <p style='font-weight: bold; text-align: justify;'>Almost there ".$userName."! just click this link and you'll be redirected to where you can change your password</p>
            <div>
               <a href=\"http://localhost/beelearn/resetpassword.php?token=$resetToken&id=$userId\"><button style='font-size: 15px; margin: 25px; color: white; border-style: none; background-color: black; padding: 10px; border-radius: 10px;'> verify </button></a>
            </div>
            <div>
            <small style='color: white; text-align: center;'>If you did not enquire for this email, please kindly ignore</small>
            </div>
        </div>
    </body>
    </html>";

        // Create a message
        $message = (new Swift_Message('Password reset link | BeeLearn.ng'))
        ->setFrom(ENAME)
        ->setTo($retrieveEmail)
        ->setBody($messageBody, 'text/html')
        ; 

        // Send the message
        $result = $mailer->send($message);

}

function SendMail($userEmail, $messageSubject, $messageBody){
    global $mailer;

    // Create a message
    $message = (new Swift_Message($messageSubject))
    ->setFrom(ENAME)
    ->setTo($userEmail)
    ->setBody($messageBody, 'text/html')
    ; 
    // Send the message
    $result = $mailer->send($message);

}



?>