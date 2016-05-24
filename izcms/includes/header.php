<?php session_start();?>
<?php
	define('URL', 'http://localhost/project/izcms/');
?>
<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="UTF-8">
	<title><?php echo (isset($title)) ? $title : "izCMS";?></title>
	<link rel="stylesheet" href="<?php echo URL.'css/style.css';?>">
	<script type="text/javascript" src="<?php echo URL.'js/jquery-1.12.3.min.js';?>"></script>
	<script type="text/javascript" src="<?php echo URL.'js/check_ajax.js';?>"></script>
	<script type="text/javascript" src="<?php echo URL.'js/delete_comment.js';?>"></script>
	<script src="<?php echo URL.'js/tinymce/tinymce.min.js';?>"></script>
	<script>tinymce.init({selector:'textarea'});</script>
</head>
<body>

	<header>
		<p class="logo"><a href="<?php echo URL.'index.php';?>">izCMS</a></p>
		<p>Đây là web site tự tạo</p>
	</header>
	<nav>
		<ul>
			<li><a href="<?php echo URL.'index.php';?>">Home</a></li>
			<li><a href="#">About</a></li>
			<li><a href="#">Services</a></li>
			<li><a href="<?php echo URL.'contact.php';?>">Contact US</a></li>
			<li>Xin chào, <?php echo (isset($_SESSION['first_name'])) ? $_SESSION['first_name'] : "bạn hiền";?> !</li>
		</ul>
	</nav>