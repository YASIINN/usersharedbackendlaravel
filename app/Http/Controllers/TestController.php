<?php

namespace App\Http\Controllers;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/PHPMailer/src/Exception.php';
require 'PHPMailer/PHPMailer/src/PHPMailer.php';
require 'PHPMailer/PHPMailer/src/SMTP.php';

use Illuminate\Http\Request;
use Mail;
class TestController extends Controller
{
    public function index(){
        $mail = new PHPMailer();


        try {
            $ead = "";
            $epass = "";
            $mail->isSMTP();
            $mail->Host ='smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';
            $ead = "ysndlklc1234@gmail.com";
            $epass = "4d32adf5";
            $subject = "deneme";
            $messega ="Selam";
            $mail->addAddress("ysndlklc1234@gmail.com", '');
            $mail->Username = $ead;
            $mail->Password = $epass;
            $mail->setFrom($ead, '');
            $mail->addReplyTo($ead, '');
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $messega;
            $mail->AltBody = ' ';




            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }


    }
}
