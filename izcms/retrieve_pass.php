<?php include ('includes/header.php');?>
<?php include ('includes/mysqli_connect.php');?>
<?php include ('includes/functions.php');?>
<?php include ('includes/sidebar-a.php');?>
<section>
	<!-- Xac nhan email chinh chu se hien thi form nay -->
	<?php
		if(isset($_GET['x'], $_GET['y'], $_GET['z']) && filter_var($_GET['x'], FILTER_VALIDATE_EMAIL) && filter_var($_GET['y'], FILTER_VALIDATE_INT, array('min_range' => 1)) && strlen($_GET['z']) == 32) {
			$q = "SELECT user_id FROM users WHERE user_id = {$_GET['y']} && email = '{$_GET['x']}' && forgot = '{$_GET['z']}'";
			$r = mysqli_query($conn, $q); confirm_query($r, $q);
			if(mysqli_num_rows($r) == 1){
				// Kiem tra co ton tai trong csdl khong ? == 1 la co
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$email = mysqli_real_escape_string($conn, $_GET['x']);
					$uid = $_GET['y'];
					$err = array();
					if(empty($_POST['pass'])){
						$err[] = "pass";
					}
					if(empty($_POST['pass1'])){
						$err[] = "pass";
					}
					if ($_POST['pass'] == $_POST['pass1']) {
						$pass = $_POST['pass'];
					}
					if (empty($err)) {
						$q = "UPDATE users SET pass = SHA1('{$pass}'), forgot = NULL WHERE email = '{$email}' && user_id = '{$uid}'";
						$r = mysqli_query($conn, $q); confirm_query($r, $q);
						if (mysqli_affected_rows($conn) == 1) {
							echo'<script>alert("Đổi password thành công !")</script>';
							echo "<p>Chuyển tới trang <a href = "URL.'login.php'">login</p>";
						}else{
							echo "Khong the cap nhat pass";
						}
					}
				}
			}else{
				redirect_to();
			}
		}else{
			redirect_to();
		}
	?>
		<form action="" method ="post">
		<h3>Xin chào email: <?php echo $_GET['x']; ?></h3>
		<p>Mời bạn nhập mật khẩu mới !</p>
			<fieldset>
				<legend>New password !</legend>
				<label for="pass">New pass</label>
				<div>
					<input type='password' name = 'pass' id="pass" tabindex="1" placeholder="Nhập pass" />
				</div>
				<label for="pass">Confirm pass</label>
				<div>
					<input type='password' name = 'pass1' id="pass1" tabindex="2" placeholder="Nhập lại pass" />
				</div>
			</fieldset>
			<p><input type="submit" name="submit" value="Update" onclick="return confirm('Are you sure ???') "/></p>
		</form>
	<!-- end xac nhan email -->
	<!-- Kiem tra xem da submit email lay lai mat khau khong? -->
</section>
<?php include ('includes/sidebar-b.php');?>
<?php include ('includes/footer.php');?>