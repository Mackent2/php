<?php 
	include('includes/header.php');
	include('includes/mysql_connect.php');
	include('includes/sidebar-a.php');
?>
<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$err = array();
		if (!empty($_POST['e']) && filter_var($_POST['e'], FILTER_VALIDATE_EMAIL)) {
			$e = $_POST['e'];
			$a = md5(uniqid(rand(), true));
			$q ="UPDATE users SET fotgot = '{$a}' WHERE email = '{$e}' && fotgot is null";
			$r= mysqli_query($conn, $q) or die ("Query : {$q} \n</br> Mysqli error:".mysqli_error($conn));
			if (mysqli_affected_rows($conn) == 1) {
				include ('gmail_retrieve.php');
				$messages = "<p class='success'>Kiểm tra email để kích hoạt lại mật khẩu !</p>";
			}else{
				$messages = "Email không tồn tại !";
			}
		}else{
			$err[] = "e";
		}
	}
?>
<section>
	<form action="" method="POST" class ="form">
		<fieldset>
			<legend>Fotgot password</legend>
				<?php
					if (isset($messages)) {
						echo "<p>".$messages."</p>";
					}
				?>
			<div class="register">
				<label for="e">Nhập email: <span>*</span>
					<?php
					if (isset($err) && in_array('e', $err)) {
						echo "<span>Ban chua nhap email</span>";
					}
					?>
				</label>
				<div>
					<input type="email" name="e" id="e" size="25" placeholder ="Nhap email.." value="<?php if(isset($_POST['e'])) echo $_POST['e'];?>"/>
				</div>
			</div>
		</fieldset>
		<p><input type="submit" name="xacnhan" value="Xác nhận" onclick="return confirm('Xác nhận lấy lại pass không?')">
		<input type="reset" name="huy" value="Cancel"></p>
	</form>
</section>
<?php include('includes/footer.php');?>
