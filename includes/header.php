<?php 
	session_start();
	define('url', 'http://localhost/hocphp/');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="UTF-8">
	<title>Text trang</title>
	<link rel="stylesheet" href="<?php echo url.'css/style.css';?>">
	<link rel="stylesheet" href="<?php echo url.'css/normalize.css';?>">
</head>
<body>
		<?php		
		// if(isset($_POST['login'])){
		// }
			if (isset($_POST['login'])) {
				include('mysql_connect.php');
				$err = array();
				if (!empty($_POST['e'])) {
					$e = mysqli_real_escape_string($conn, $_POST['e']);
				}else{
					$err[] = "e";
				}
				if (!empty($_POST['pass'])) {
					$p = mysqli_real_escape_string($conn, $_POST['pass']);
				}else{
					$err[] = "pass";
				}
				if (empty($err)) {
					$q = "SELECT user_id, first_name, last_name, email FROM users WHERE email = '{$e}' && pass = SHA1('{$p}') && active is null ";
					$r = mysqli_query($conn, $q) or die ("Query: {$q} \n<br/> MSQLI :".mysqli_error($conn));
					if (mysqli_num_rows($r) == 1) {
						list($uid, $fn, $ln, $e) = mysqli_fetch_array($r, MYSQLI_NUM);
						$_SESSION['uid'] = $uid;
						$_SESSION['fn'] = $fn;
						$_SESSION['ln'] = $ln;
						$_SESSION['e'] = $e;
						header("location:".url."admin/login.php");
					}else{
						echo'<script>alert("Email chưa được kích hoạt or password error !")</script>';
					}
				}
			}
		?>
		<nav>
			<div><a href="<?php echo url."index.php"?>"><h1>Lập trình php</h1></a></div>
		<?php
		// ton tai nguoi dung thi hien thi ra email + hhinh dai dien
		if (isset($_SESSION['e'])) {
			$conn = mysqli_connect('localhost', 'root', '', 'hocphp');
				if (!$conn) {
					trigger_error("Ket noi hong thanh cong".mysqli_connect_error());
				}else{
					mysqli_set_charset($conn, 'utf-8');
				}
			$q = "SELECT images FROM users WHERE email = '{$_SESSION['e']}'";
			$r = mysqli_query($conn, $q) or die ("Query : {$q} \n<br/> Mysqli error".mysqli_error($conn));
			if (mysqli_num_rows($r) == 1) {
				list($img) = mysqli_fetch_array($r, MYSQLI_NUM);
				if ($img == NULL) {
					echo "<div class='hello'>
						<span>
						<a href='admin/login.php'><img src='img/upload/hotgril.jpg' width='50' height='40' alt='hinh dai dien' title='hinh dai dien'/></a>
						</span>
						Email: ".$_SESSION['e']."</div>
					";
				}else{
					echo "<div class='hello'>
						<span>
						<a href='admin/login.php'><img src='img/upload/{$img}' width='50' height='40' alt='hinh dai dien' title='hinh dai dien'/></a>
						</span>
						Email: ".$_SESSION['e']."</div>
					";
				}		
			}
		}// end
		// tao form dang nhap neu chua co nguoi dung
		else{
			?>
			
			<form action="" method="post">
				<label for="email">Nhập email:<span> *</span>
				</label>
				<input type="email" name= "e" id="email" value="" size="25" placeholder="Nhập email.."/>
				<label for="pass">Password:<span> *</span></label>
				<input type="password" name="pass" id="pass" value="" size="25" placeholder="Nhập password.."/>
				<input type="submit" name="login" value="Login">
			</form>
		<?php
		}
		?>
		</nav>
