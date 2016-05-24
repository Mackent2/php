<?php
// Ket noi CSDL
	$conn = mysqli_connect('localhost','root','','izcms');
// Kết nối không thành công sẽ báo lỗi
	if(!$conn){
		trigger_error("Kết nối không thành công ".mysqli_connect_error());
	}else{
		// đặt kết nối với phương thức utf-8
		mysqli_set_charset($conn,'utf-8');
	}
?>