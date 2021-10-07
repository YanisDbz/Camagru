<?php
require_once 'config/constants.php';

function sendVerificationEmail($userEmail, $token)
{
    $curdir = dirname($_SERVER['REQUEST_URI'])."/";
    $link = $_SERVER['HTTP_HOST'] . $curdir;
    $subject = 'Verify Email Address';
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'Reply-To: '.EMAIL."\n"; // Mail de reponse
    $headers .= 'To: '.$userEmail.' <'.$userEmail.'>' . "\r\n";
    $headers .= 'From: TakeYourShoot <'.EMAIL.'>' . "\r\n";
    $headers .= 'Delivered-to: '.$userEmail."\n"; // Destinataire
    $headers .='X-Mailer: PHP/' . phpversion();
    $message = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Verify Email</title>
    </head>
    <body>
        <div class="wrapper">
            <p>Thank you for signing up on Take Your Shoot, Please click on the link below
                to verify your email.
            </p>
            <a href="http://'. $link .'login.php?token='. $token .'">
                Verifiy Email Address
            </a>
        </div>
    </body>
    </html>';
    mail($userEmail,$subject,$message,$headers);
}

function sendPasswordResetLink($userEmail, $token)
{
    $curdir = dirname($_SERVER['REQUEST_URI'])."/";
    $link = $_SERVER['HTTP_HOST'] . $curdir;
    $subject = 'Change Password';
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'Reply-To: '.EMAIL."\n"; // Mail de reponse
    $headers .= 'To: '.$userEmail.' <'.$userEmail.'>' . "\r\n";
    $headers .= 'From: TakeYourShoot <'.EMAIL.'>' . "\r\n";
    $headers .= 'Delivered-to: '.$userEmail."\n"; // Destinataire
    $headers .='X-Mailer: PHP/' . phpversion();
    $message = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Verify Email</title>
    </head>
    <body>
        <div class="wrapper">
            <p>
                Please click on the link below to reset your password.
            </p>
            <a href="http://'. $link .'login.php?password-token='. $token .'">
                Reset Your Password.
            </a>
        </div>
    </body>
    </html>';

    mail($userEmail,$subject,$message,$headers);
}

function sendNotificationLike($userEmail, $username, $post_id)
{
    $curdir = dirname($_SERVER['REQUEST_URI'])."/";
    $link = $_SERVER['HTTP_HOST'] . $curdir;
    $subject = "$username liked your photos";
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'Reply-To: '.EMAIL."\n"; // Mail de reponse
    $headers .= 'To: '.$userEmail.' <'.$userEmail.'>' . "\r\n";
    $headers .= 'From: TakeYourShoot <'.EMAIL.'>' . "\r\n";
    $headers .= 'Delivered-to: '.$userEmail."\n"; // Destinataire
    $headers .='X-Mailer: PHP/' . phpversion();
    $message = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Verify Email</title>
    </head>
    <body>
        <div class="wrapper">
            <p>
                You can see your post here
            </p>
            <a href="http://'. $link .'post.php?post='. $post_id .'&display=all">
                See the post.
            </a>
        </div>
    </body>
    </html>';

    mail($userEmail,$subject,$message,$headers);
}

function sendNotificationComment($userEmail, $username, $post_id, $message)
{
    $curdir = dirname($_SERVER['REQUEST_URI'])."/";
    $link = $_SERVER['HTTP_HOST'] . $curdir;
    $subject = "$username add comment";
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'Reply-To: '.EMAIL."\n"; // Mail de reponse
    $headers .= 'To: '.$userEmail.' <'.$userEmail.'>' . "\r\n";
    $headers .= 'From: TakeYourShoot <'.EMAIL.'>' . "\r\n";
    $headers .= 'Delivered-to: '.$userEmail."\n"; // Destinataire
    $headers .='X-Mailer: PHP/' . phpversion();
    $message = '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Verify Email</title>
    </head>
    <body>
        <div class="wrapper">
            <p>
                The comment is '. $message .', you can see the post here 
            </p>
            <a href="http://'. $link .'post.php?post='. $post_id .'&display=all">
                See the post.
            </a>
        </div>
    </body>
    </html>';

    mail($userEmail,$subject,$message,$headers);
}
?>