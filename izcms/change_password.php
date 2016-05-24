<?php include ('includes/header.php');?>
<?php include ('includes/mysqli_connect.php');?>
<?php include ('includes/functions.php');?>
<?php include ('includes/sidebar-a.php');?>
<section>
	<!-- Xac nhan email chinh chu se hien thi form nay -->
	<?php
		is_logined_in(); // kiem tra ng dung dang nhap hay chua?
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$err = array();
			if(empty($_POST['current_pass'])){
				$err[] = "current pass";
			}else{
				$current_pass = mysqli_real_escape_string($conn, trim($_POST['current_pass']));
			}
			if (empty($_POST['pass'])) {
				$err[] = "pass new";
			}
			if (empty($_POST['pass1'])) {
				$err[] = "confirm pass";
			}
			if (isset($_POST['pass'], $_POST['pass1']) && $_POST['pass1'] == $_POST['pass']) {
				$newpass = mysqli_real_escape_string($conn, trim($_POST['pass']));
			}else{
				$err[] = "Pass khong trung nhau";
			}
			$user_id = $_SESSION['user_id'];
			if (empty($err)) {
				// Truy vấn so sánh pass cũ có trùng với người dùng nhập vào không ?
				$q = "SELECT user_id FROM users WHERE user_id = {$user_id} && pass = SHA1('{$current_pass}')";
				$r = mysqli_query($conn, $q); confirm_query($r, $q);
				// Trùng thì kiểm tra xem table tồn tại không ?
				if (mysqli_num_rows($r) == 1) {
					// So sánh id user trùng nhau thì bắt đầu update pass mới
					$q1 = "UPDATE users SET pass = SHA1('{$newpass}') WHERE user_id = {$user_id} && pass = SHA1('{$current_pass}')";
					$r1 = mysqli_query($conn, $q1); confirm_query($r1, $q1);
					if (mysqli_affected_rows($conn) == 1) {
						$messages = "Thay đổi password thành công ! <br/> Trở lại trang <a href='admin/login.php'>login";
					}else{
						$messages = "Lỗi ! SYSTEM";
					}
				}else{
					$messages = "Pass cũ sai mời nhập lại !";
				}
			}
		}

	?>
		<form action="" method ="post">
		<h3>Xin chào : <?php echo $_SESSION['first_name']; ?></h3>
		<p><?php
			if(isset($messages)){ echo $messages; }
		?></p>
			<fieldset>
				<legend>New password !</legend>
				<label for="current_pass">Current password 
					<?php
						if(isset($err) && in_array("current pass", $err)){
							echo "- Pass chua nhap !";
						}
					?>
				</label>
				<div>
					<input type='password' name = 'current_pass' id="current_pass" tabindex="1" placeholder="Nhập pass hiện tại" />
				</div>
				<label for="pass">New pass
					<?php
						if(isset($err) && in_array("pass new", $err)){
							echo "- Pass moi chua nhap !";
						}
					?>
				</label>
				<div>
					<input type='password' name = 'pass' id="pass" tabindex="2" placeholder="Nhập pass mới" />
				</div>
				<label for="pass1">Confirm pass
					<?php
						if(isset($err) && in_array("Pass khong trung nhau", $err)){
							echo "- Pass khong trung pass moi !";
						}
					?>
				</label>
				<div>
					<input type='password' name = 'pass1' id="pass1" tabindex="3" placeholder="Nhập lại pass mới" />
				</div>
			</fieldset>
			<p><input type="submit" name="submit" value="Update" onclick="return confirm('Are you sure ???') "/></p>
		</form>
	<!-- end xac nhan email -->
	<!-- Kiem tra xem da submit email lay lai mat khau khong? -->
</section>
<?php include ('includes/sidebar-b.php');?>
<?php include ('includes/footer.php');?>


