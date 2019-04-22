<?php

namespace App\Http\Controllers;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/PHPMailer/src/Exception.php';
require 'PHPMailer/PHPMailer/src/PHPMailer.php';
require 'PHPMailer/PHPMailer/src/SMTP.php';
use Illuminate\Http\Request;

class MailController extends Controller
{
    public function index($subjects,$msg,$usermail){
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
            $mail->addAddress($usermail,'');
            $mail->Username = $ead;
            $mail->Password = $epass;
            $mail->setFrom($ead, '');
            $mail->addReplyTo($ead, '');
            $mail->isHTML(true);
            $mail->Subject = $subjects;

            $template="
            <html>
<body style='margin: 0; padding: 0;'>
<table style='border: 2px solid #cccccc;' align='center' border='0' cellpadding='0' cellspacing='0' width='600'>
 <tr>
 <td     bgcolor= '#02a8ff' align='center' bgcolor='#70bbd9' style='padding: 20px 0 30px 0;'>
 <img src='https://cdn1.iconfinder.com/data/icons/icons-for-a-site-1/64/advantage_teamwork-256.png' alt='Öğrenciysen.com' width='300' height='230' style='display: block; ' />
 <p style='color:#ffffff;font-size:20px;  text-indent: 50px;  text-align: center;  letter-spacing: 3px;'><b>ÖĞRENCİYSEN.COM</b></p>
</td>
 </tr>
 <tr>
 <td style='padding: 40px 30px 40px 30px;' bgcolor='#ffffff'>
<table border='1' cellpadding='0' cellspacing='0' width='100%'>
<tr>
<td style='color: #153643; font-family: Arial, sans-serif; font-size: 18px;'>
<b>Öğrenciysen.com'a Kayıt Olduğun İçin Teşekkürler</b>
</td>
</tr>
<tr>
  <td style='padding: 20px 0 30px 0;'>
    Aşşağıdaki Bağlantıya Tıklayarak Hesabını Aktif Edebilirsin.".
    "<p>  </p>".
  'http://localhost:8080/AccountVerify/'.$msg.
  "</td>
 </tr>
</table>
  </td>
 </tr>
 <tr>
 <td style='padding: 30px 30px 30px 30px;' bgcolor='#ee4c50'>

<table border='0' cellpadding='0' cellspacing='0' width='100%'>
<tr>
<td width='75%' style='color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;'>
<a href='http://localhost:8080/' target='_blank' style='color: #ffffff;'><font color='#ffffff'> Öğrenciysen.com</font></a>
<br/>
Bizi Sosyal Medya Hesaplarımızdan Takip Et 😄
</td>
<td align='right'>
 <table border='0' cellpadding='0' cellspacing='0'>
  <tr>
 <td style='padding:3px;'>
    <a href='http://www.twitter.com/yasindlklcc' target='_blank'>
     <img src='https://cdn1.iconfinder.com/data/icons/iconza-circle-social/64/697029-twitter-32.png' alt='Twitter' width='38' height='38' style='display: block;' border='0' />
    </a>
   </td>
    <td style='font-size: 0; line-height: 0;' width='20'>&nbsp;</td>
 <td style='padding:3px;'>
    <a href='http://www.facebook.com/ysndlklc' target='_blank'>
     <img src='https://cdn3.iconfinder.com/data/icons/free-social-icons/67/facebook_circle_color-32.png' alt='Facebook' width='32' height='33' style='display: block;' border='0' />
    </a>
   </td>
   <td style='padding:3px;'>
    <a href='https://www.instagram.com/yasindlklc/' target='_blank'>
     <img src='https://cdn3.iconfinder.com/data/icons/flat-icons-web/40/Instagram-32.png' alt='Facebook' width='32' height='32' style='display: block;' border='0' />
    </a>
   </td>
 <td style='padding:3px;'>
    <a href='https://www.linkedin.com/in/yasin-dalk%C4%B1l%C4%B1%C3%A7-251b7b151/' target='_blank'>
     <img src='https://cdn4.iconfinder.com/data/icons/miu-flat-social/60/linkedin-32.png' alt='Facebook' width='32' height='32' style='display: block;' border='0' />
    </a>
   </td>
  </tr>
 </table>
</td>
 </tr>
</table>
<br/>
<hr/>
Veri koruma düzenlemelerine uygun olarak, kişisel bilgilerinizin veri tabanından kaldırılmasını istiyorsanız, lütfen web sitesi  ile irtibata geçiniz.
</body>


</html>
       ";

            $mail->Body =$template;
            $mail->AltBody = "";
            $mail->send();
            return "success";
        } catch (Exception $e) {
            return "Fail: {$mail->ErrorInfo}";
        }
    }
}
