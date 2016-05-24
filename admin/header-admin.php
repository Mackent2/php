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
	<nav>
		<div><a href="<?php echo url."index.php"?>"><h1>Lập trình php</h1></a></div>
		<div class="hello">
			<span>
			<?php
				include ('../includes/mysql_connect.php');
				$q = "SELECT images FROM users WHERE email = '{$_SESSION['e']}'";
				$r = mysqli_query($conn, $q) or die ("Query : {$q} \n<br/> Mysqli error".mysqli_error($conn));
				if (mysqli_num_rows($r) == 1) {
					list($img) = mysqli_fetch_array($r, MYSQLI_NUM);
					if ($img == NULL) {
						echo "
						<a href='login.php'><img src='../img/upload/hotgril.jpg' width='50' height='40' alt='hinh dai dien' title='hinh dai dien'/></a>
						";
					}else{
						echo "
						<a href='login.php'><img src='../img/upload/{$img}' width='50' height='40' alt='hinh dai dien' title='hinh dai dien'/></a>
						";
					}		
				}
			?></span>
		Email: <?php echo $_SESSION['e'];?></div>
	</nav>