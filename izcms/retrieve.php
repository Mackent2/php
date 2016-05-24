<?php include ('includes/header.php');?>
<?php include ('includes/mysqli_connect.php');?>
<?php include ('includes/functions.php');?>
<?php include ('includes/sidebar-a.php');?>
<section>
	<?php
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$err = array();
			if(empty($_POST['email'])){
				$err[] = "email";
			}else{
				$email = $_POST['email']; 
			}
			if (empty($err)) {
				$q = "SELECT user_id, first_name FROM users WHERE email = '{$email}'";
				$r = mysqli_query($conn, $q);
				confirm_query($r, $q);
				//Kiem tra email co ton tai trong table hay k?
				// Truong hop ton tai
				if(mysqli_num_rows($r) == 1){
						$a = md5(uniqid(rand(), true)); // tao ma md5 voi 1 ma so bat ky
						list($uid, $first_name) = mysqli_fetch_array($r, MYSQLI_NUM);
						$q1 = "UPDATE users SET forgot = '{$a}' WHERE email = '{$email}'";
						$r1 = mysqli_query($conn, $q1); confirm_query($r1, $q1);
						if(mysqli_affected_rows($conn) == 1){
							$messages = "Kiểm tra <a href ='http://gmail.com' target='_blank'>email lấy lại mật khẩu !</a>";
							include ('gmail_retrieve.php');
							$_POST= array();
						}
				}else{
					$messages = "Email khong ton tai !";
				}
			}else{
					// Truong hop ton tai
				$messages = "Loi email chua nhap !";
				}
			}
	?>
	<form action="" method="POST">
		<?php
			if (isset($messages)) {
				echo $messages;
			}
		?>
		<fieldset>
			<legend>Retrieve Password</legend>
			<label for="email">Email <span>*</span>
				<?php
					if(isset($err) && in_array('email', $err)){
						echo "moi ban nhap email";
					}
				?>
			</label>
			<div>
				<input type="email" name="email" id="email" tabindex="3" placeholder="Nhap email" value="<?php if (isset($_POST['email'])) {
					echo strip_tags($_POST['email']);}?>" />
			</div>
		</fieldset>
		<p><input type="submit"  name="forgot" value="Lay lai pass"><input type="reset"  name="huy" value="Cancel"></p>
	</form>
</section>
<?php include ('includes/sidebar-b.php');?>
<?php include ('includes/footer.php');?>


