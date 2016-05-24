<?php 
	include('includes/header.php');
	include('includes/mysql_connect.php');
	include('includes/sidebar-a.php');
?>
<?php
	if (isset($_GET['x'], $_GET['z']) && filter_var($_GET['x'], FILTER_VALIDATE_EMAIL) && (strlen($_GET['z']) ==32)) {
		$e = mysqli_real_escape_string($conn, $_GET['x']);
		$a = mysqli_real_escape_string($conn, $_GET['z']);
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$err = array();
			if (empty($_POST['newpass'])) {
				$err[] = "pass";
			}
			if (isset($_POST['newpass'], $_POST['confirm']) && $_POST['newpass'] == $_POST['confirm']) {
				$pass = $_POST['newpass'];
			}else{
				$err[] = "pass khong trung";
			}
			if (empty($err)) {
				$q = "UPDATE users SET pass = SHA1('{$pass}'), fotgot = NULL WHERE email = '{$e}' && fotgot ='{$a}'";
				$r= mysqli_query($conn, $q) or die ("Query : {$q} \n</br> Mysqli error:".mysqli_error($conn));
				if (mysqli_affected_rows($conn) == 1) {
					$messages = "<p class='success'>Mật khẩu mới đã được thay đổi !</p>";
				}else{
					header("location:index.php");
				}
			}
		}
	}else{
		header("location:index.php");
	}
?>

<section>
	<form action="" method="POST">
		<fieldset>
			<legend>Fotgot password</legend>
				<p>Nhập lại mật khẩu mới cho tài khoản email: <?php echo $e;?></p>
				<?php
					if (isset($messages)) {
						echo "<p>".$messages."</p>";
					}
				?>
			<div class="register">
				<div>
					<label for="newpass">New password<span> * </span>
						<?php if (isset($err) && in_array('pass', $err)){
							echo "<span>New pass không được bỏ trống !</span>";
							}?>
					</label><br/>
					<input type="password" name="newpass"/>
				</div>
				<div>
					<label for="confirm">Confirm New password<span> * </span>
						<?php
							if (isset($_POST['newpass'], $_POST['confirm']) && $_POST['newpass'] != $_POST['confirm']) {
								echo "<span>Confirm new pass no pass</span>";
							}
						?>
					</label><br/>
					<input type="password" name="confirm"/>
				</div>
			</div>
		</fieldset>
		<p><input type="submit" name="ok" value="Confirm"></p>
	</form>
</section>
<?php include('includes/footer.php');?>
