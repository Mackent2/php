	
<?php include ('includes/header.php');?>
<?php include ('includes/mysqli_connect.php');?>
<?php include ('includes/functions.php');?>
<?php include ('includes/sidebar-a.php');?>
<section>
	<?php
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$err = array();
			if (empty($_POST['firstname'])) {
				$err[] = "firstname"; 
			}else{
				$first_name = $_POST['firstname']; 
			}
			if (empty($_POST['lastname'])) {
				$err[] = "lastname";
			}else{
				$last_name = $_POST['lastname']; 
			}
			if(empty($_POST['email'])){
				$err[] = "email";
			}else{
				$email = $_POST['email']; 
			}
			if (empty($_POST['pass'])) {
				$err[] = "pass loi";
			}
			if (empty($_POST['pass2'])) {
				$err[] = "pass khong bo trong";
			}
			if($_POST['pass'] == $_POST['pass2']){
				$pass = $_POST['pass'];
			}else{
				$err[] = "Confirm pass error";
			}
			if (empty($err)) {
				$q = "SELECT user_id FROM users WHERE email = '{$email}'";
				$r = mysqli_query($conn, $q);
				confirm_query($r, $q);
				//Kiem tra email co ton tai trong table hay k? == 0
				// Truong hop k ton tai
				if(mysqli_num_rows($r) == 0){
					$a = md5(uniqid(rand(), true));
					// Cho dang ky vao csdl
					$q1 = "INSERT INTO users(first_name, last_name, email, pass, active, registration_date) VALUES('{$first_name}', '{$last_name}', '{$email}', SHA1('{$pass}'),'{$a}', NOW())";
					$r1 = mysqli_query($conn, $q1);
					confirm_query($r, $q1);
					if(mysqli_affected_rows($conn) == 1){
						$messages = "Kiểm tra <a href ='http://gmail.com' target='_blank'>email kích hoạt tài khoản</a>";
						include ('gmail_activace.php');
						$_POST= array();
					}else{
						$messages = "Loi ! Dang ky khong thanh cong";
					}
				}else{
					// Truong hop ton tai
					$messages = "Email nay da duoc dang ky, moi nhap lai email khac !";
				}
			}else{
				$messages = "Bạn cần nhập đúng các định dạng !";
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
			<legend>Register</legend>
			<label for="fname">First Name <span>*</span>
				<?php
					if(isset($err) && in_array('firstname', $err)){
						echo "moi ban nhap first name";
					}
				?>
			</label>
			<div>
				<input type="text" name="firstname" id="fname" tabindex="1" placeholder="Nhap first name" value="<?php if (isset($_POST['firstname'])) {
					echo strip_tags($_POST['firstname']);}?>"/>
			</div>
			<label for="lname">Last Name <span>*</span>
				<?php
					if(isset($err) && in_array('lastname', $err)){
						echo "moi ban nhap last name";
					}
				?>
			</label>
			<div>
				<input type="text" name="lastname" id="lname" tabindex="2" placeholder="Nhap last name" value="<?php if (isset($_POST['lastname'])) {
					echo strip_tags($_POST['lastname']);}?>" />
			</div>
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
				<span id="available"></span>
			</div>
			<label for="pass">PassWord <span>*</span>
				<?php
					if(isset($err) && in_array('pass loi', $err)){
						echo "moi ban nhap pass";
					}
				?>
			</label>
			<div>
				<input type="password" name="pass" id="pass" tabindex="4" placeholder="Nhap pass" value="<?php if (isset($_POST['pass'])) {
					echo strip_tags($_POST['pass']);}?>"/>
			</div>
			<label for="pass2">Confirm PassWord <span>*</span>
				<?php
					if(isset($_POST['pass1']) != isset($_POST['pass'])){
						echo "Confirm pass not pass !";
					}
				?>
			</label>
			<div>
				<input type="password" name="pass2" id="pass2" tabindex="5" placeholder="Nhap lai pass" />
			</div>
		</fieldset>
		<p><input type="submit"  name="dangky" value="Register"><input type="reset"  name="huy" value="Cancel"></p>
	</form>
	<?php
	?>	
</section>
<?php include ('includes/sidebar-b.php');?>
<?php include ('includes/footer.php');?>


