<?php 
	include('header-admin.php');
	include('../includes/mysql_connect.php');
	include('sidebar-admin.php');
?>
<?php
	if (isset($_GET['uid'], $_GET['e']) && filter_var($_GET['uid'], FILTER_VALIDATE_INT) && filter_var($_GET['e'], FILTER_VALIDATE_EMAIL)) {
		$uid = $_GET['uid']; $e = $_GET['e'];
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if (isset($_POST['chon']) && ($_POST['chon'] == 'YES')) {
				$q= "DELETE FROM users WHERE user_id = {$uid} && email = '{$e}'";
				$r = mysqli_query($conn, $q) or die ("Query : {$q} \n><br/> Mysqli error ".mysqli_error($conn));
				if (mysqli_affected_rows($conn) == 1) {
					$messages = "<p class ='success'>Xóa thành công !</p>";
				}else{
					$messages = "<p class='error'>Email không tồn tại, error !</p>";
				}
			}else{
				$messages = "<p class ='error'>Người dùng không được xóa !</p>";
			}
		}
	}else{
		header("location:login.php");
	}
?>
<form action="" method="POST">
	<fieldset>
		<legend>Del email: <?php echo $_GET['e']?></legend>
		<p>Bạn muốn loại bỏ user có tên email: <?php echo $_GET['e']?> không??</p></br>
		<?php
			if (isset($messages)) {
				echo $messages;
			}
		?>
		<label for="">YES</label>
		<input type="radio" name ="chon" value ="YES"/>
		<span> || </span>
		<label for="">NO</label>
		<input type="radio" name ="chon" value ="NO"/>

	</fieldset>
		<p><input type="submit" name="dongi" value="Xóa user" onclick="return confirm('Bạn có chắc không ?')"></p>
</form>
<?php include('../includes/footer.php');?>
