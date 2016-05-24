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

$mail->addAddress($e, 'Khách Hàng');



/*End noi dung can chinh sua*/



/*Noi dung email*/

//Tieu de

$mail->Subject = 'Forgot  password!';



//Noi dung

$mail->Body    = "Chào bạn !
\nĐể bắt đầu quá trình đặt lại mật khẩu cho,
\nTài khoản email: ".$e." của bạn, hãy nhấp vào liên kết bên dưới:
\nhttp://localhost/hocphp/retrieve_pass.php?x=".urlencode($e)."&z=".$a."
\nNếu liên kết không hoạt động khi nhấp vào, hãy sao chép và dán URL
vào cửa sổ trình duyệt mới.
\n\nNếu bạn nhận được thư này do nhầm lẫn, có thể một người dùng khác
đã nhập nhầm địa chỉ email của bạn trong khi cố gắng
đặt lại mật khẩu. Nếu không yêu cầu, bạn không cần thực hiện thêm
bất kỳ tác vụ nào và có thể yên tâm bỏ qua email này.
\nTrân trọng,
\nTùng Văn
\nLưu ý: Địa chỉ email này không thể chấp nhận thư trả lời. Để khắc phục sự  
cố hoặc tìm hiểu thêm về tài khoản của bạn, hãy truy cập vào trung tâm trợ  
giúp của chúng tôi:http://tungit.cf/hocphp";


//Gui mail va tra ve thong bao

if (!$mail->send()) {
    echo'<script>alert("Gửi mail lỗi")</script>';

} else {

    echo'<script>alert("Yêu cầu của quý khách đã được thực hiện, check email: '.$_POST['e'].' để lấy lại mật khẩu. !")</script>';

}

    //echo'<script>window.location.assign("hoantat.php");</script>';

?>
