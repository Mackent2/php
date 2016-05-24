<?php
	$conn = mysqli_connect('localhost', 'root', '', 'hocphp');
	if (!$conn) {
		trigger_error("Ket noi hong thanh cong".mysqli_connect_error());
	}else{
		mysqli_set_charset($conn, 'utf-8');
	}
?>