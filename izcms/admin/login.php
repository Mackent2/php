	
<?php include ('../includes/header.php');?>
<?php include ('../includes/mysqli_connect.php');?>
<?php include ('../includes/functions.php');?>
<?php include ('../includes/sidebar-a.php');?>
<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$err = array();
		if(empty($_POST['email'])){
			$err[] = "email";
		}else{
			$email = mysqli_real_escape_string($conn, $_POST['email']);
		}
		if (empty($_POST['pass'])) {
			$err[] = "pass";
		}else{
			$pass = mysqli_real_escape_string($conn, $_POST['pass']);
		}
		if (empty($err)) {
			$q = "SELECT user_id, first_name, user_level FROM users WHERE email = '{$email}' && pass = SHA1('{$pass}') && active is NULL";
			$r = mysqli_query($conn, $q); confirm_query($r, $q);
			if (mysqli_num_rows($r) == 1) {
				list($user_id, $first_name, $user_level) = mysqli_fetch_array($r, MYSQLI_NUM);
				$_SESSION['user_id'] = $user_id;
				$_SESSION['first_name'] = $first_name;
				$_SESSION['user_level'] = $user_level;
				redirect_to('admin/admin.php');
			}else{
				$messages = "Loi password hoac email không đúng! Or bạn chưa kích hoạt email!";
			}
		}else{
			$messages = "SYSTEM ERROR !";
		}
	}
?>
<section>
	<form action="" method="POST">
		<?php
			if (isset($messages)) {
				echo $messages;
			}
		?>
		<fieldset>
			<legend>Login</legend>
			<label for="email">Nhập Email <span>*</span>
				<?php
					if (isset($err) && in_array("email", $err)) {
						echo "Email error";
					}
				?>
			</label>
			<div>
				<input type="email" name="email" id="email" placeholder ="Nhập email" value="<?php if(isset($_POST['email'])) echo $_POST['email'];?>" size = "30">
			</div>
			<label for="pass">Password <span>*</span>
				<?php
					if (isset($err) && in_array("pass", $err)) {
						echo "Pass error";
					}
				?>
			</label>
			<div>
				<input type="password" name="pass" id="pass" size = "30"/>
			</div>
		</fieldset>
		<p><input type="submit" name="login" value="Login"><input type="reset" name="reset" value="cancel"></p>
		<p><a href="../retrieve.php">Fotgot password ?</a></p>
	</form>
</section>
<?php include ('../includes/sidebar-b.php');?>
<?php include ('../includes/footer.php');?>