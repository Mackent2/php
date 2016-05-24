<?php

date_default_timezone_set('Etc/UTC');

require 'mail/PHPMailerAutoload.php'; // Include c�c h�m cua thu vien phpmailer

//Khoi tao doi tuong

$mail = new PHPMailer();

//Dung SMTP

$mail->isSMTP();



/*Chu y phan cau hinh SMTP cua google*/

//Server SMTP

$mail->Host = "smtp.gmail.com";

//Port SMTP

$mail->Port = 587;

//Ma hoa - ssl (deprecated) or tls

$mail->SMTPSecure = 'tls';

//Chung thuc SMTP

$mail->SMTPAuth = true;



/*Noi dung can chinh sua, tai khoan gmail, password, nguoi gui, nguoi nhan*/

//Username - Email

// $mail->Username = "localhostbinh@gmail.com";
$mail->Username = "tungit0107@gmail.com";

//Password cua email

// $mail->Password = "bodeobiet";
$mail->Password = "tungvan11t2@";

/*Het phan cau hinh*/



/*Cau hinh header*/



//Nguoi gui

$mail->setFrom('localhost', 'TEST MAILER');

//Nguoi nhan

$mail->addAddress($_POST['e'], 'Khách Hàng');



/*End noi dung can chinh sua*/



/*Noi dung email*/

//Tieu de

$mail->Subject = 'Demo test mailer !';



//Noi dung

$mail->Body    = "Kính chào:".$_POST['fn']." ".$_POST['ln']."! \nQuý vị đã đăng ký thành viên tại tungit.cf. \nXin vui lòng nhấn vào đây để kích hoạt tài khoản !\n http://localhost/hocphp/admin/activate.php?x=".urlencode($_POST['e'])."&y={$a}";



//Gui mail va tra ve thong bao

if (!$mail->send()) {
    echo'<script>alert("Gửi mail lỗi")</script>';

} else {

    echo'<script>alert("Yêu cầu của quý khách đã được thực hiện, check email: '.$_POST['e'].' để kích hoạt tài khoản. !")</script>';

}

    //echo'<script>window.location.assign("hoantat.php");</script>';

?>