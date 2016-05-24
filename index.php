<?php 
	include('includes/header.php');
	include('includes/mysql_connect.php');
	if (isset($_SESSION['e'])) {
		include('includes/sidebar-b.php');
		
	}else{
		//hien thi ra trang dang ki
	include('includes/sidebar-a.php');
	if (isset($_POST['dangki'])) {
		$err = array();
		if (!empty($_POST['fn'])) {
			$fn = $_POST['fn'];
		}else{
			$err[] = "fn";
		}
		if (!empty($_POST['ln'])) {
			$ln = $_POST['ln'];
		}else{
			$err[] = "ln";
		}
		if (!empty($_POST['e'])) {
			$e = $_POST['e'];
		}else{
			$err[] = "e";
		}
		if (empty($_POST['pass'])) {
			$err[] = "pass khong bo trong";
		}
		if (isset($_POST['pass'], $_POST['pass2'])&& ($_POST['pass'] == $_POST['pass2'])){
			$pass = $_POST['pass'];
		}else{
			$err[] = "loi pass khong trung";
		}
		if (!empty($_POST['address'])) {
			$address = $_POST['address'];
		}else{
			$err[] = "dia chi";
		}
		if (!empty($_POST['fone']) && preg_match('/^[0-9]{8,12}$/', $_POST['fone'])) {
			$fone = $_POST['fone'];
		}else{
			$err[] = "loi fone";
		}
		if (empty($err)) {
			//truy van vao csdl xem co email nao ton tai hay khong
			$q = "SELECT user_id FROM users WHERE email = '{$e}'";
			$r = mysqli_query($conn, $q) or die ("Query : $q \n</br> Mysql :".mysqli_error($conn));
			//Kiem tra co ton tai email trong csdl k?
			if (mysqli_num_rows($r) == 0) {
				$a = md5(uniqid(rand(), true)); // tao ma so 32 ki tu k trung nhau
				// chen csdl vao table
				$q1 = "INSERT INTO users(first_name, last_name, pass, email, diachi, fone, active) VALUES ('{$fn}', '{$ln}', SHA1('{$pass}'), '{$e}', '{$address}', '{$fone}', '{$a}')";
				$r1 = mysqli_query($conn, $q1) or die ("Query: {$q} \n<br> Mysql : ".mysqli_error($conn));
				if (mysqli_affected_rows($conn) == 1) {
					include ('gmail_activace.php');
					$messages = "Kiểm tra email, kich hoạt tài khoản !";
				}else{
					$messages = "Đăng kí không thành công ! ERROR";
				}
			}else{
				$messages = "Email ban nhap da ton tai, moi nhap lai email khac !";
			}		
		}else{
			$messages = "Không được bỏ trống các trường !";
			}
	}
?>
<section>
	<p><a href="fotgot_pass.php">Fotgot password</a></p>
	<form action="" method="POST" class ="form">
		<fieldset>
			<legend>Register</legend>
				<?php
					if (isset($messages)) {
						echo "<p>".$messages."</p>";
					}
				?>
			<div class="register">
				<label for="fn">First name: <span>*</span>
					<?php
					if (isset($err) && in_array('fn', $err)) {
						echo "<span>Ban chua nhap first name</span>";
					}
					?>
				</label>
				<div>
					<input type="text" name="fn" id="fn" size="25" placeholder="Nhap first name.." value="<?php if(isset($_POST['fn'])) echo $_POST['fn'];?>" />
				</div>
				<label for="ln">Last name: <span>*</span>
					<?php
						if (isset($err) && in_array('ln', $err)) {
							echo "<span>Ban chua nhap last name</span>";
						}
					?>
				</label>
				<div>
					<input type="text" name="ln" id="ln" size="25" placeholder ="Nhap last name.." value="<?php if(isset($_POST['ln'])) echo $_POST['ln'];?>"/>
				</div>
				<label for="e">Email: <span>*</span>
					<?php
					if (isset($err) && in_array('e', $err)) {
						echo "<span>Ban chua nhap email</span>";
					}
					?>
				</label>
				<div>
					<input type="email" name="e" id="e" size="25" placeholder ="Nhap email.." value="<?php if(isset($_POST['e'])) echo $_POST['e'];?>"/>
				</div>
				<label for="pass">Password: <span>*</span>
					<?php
					if (isset($err) && in_array('pass khong bo trong', $err)) {
						echo "<span>Ban chua nhap password</span>";
					}
					?>
				</label>
				<div>
					<input type="password" name="pass" id="pass" size="25" placeholder ="Nhap password.." value="<?php if(isset($_POST['pass'])) echo $_POST['pass'];?>"/>
				</div>
				<label for="pass2">Confirm password: <span>*</span>
					<?php
					if (isset($_POST['pass'], $_POST['pass2']) && $_POST['pass'] != $_POST['pass2'] ) {
						echo "<span>password confirm no pass</span>";
					}
				?>
				</label>
				<div>
					<input type="password" name="pass2" id="pass2" size="25" placeholder ="Nhap lai password.." />
				</div>
				<label for="address">Địa chỉ: <span>*</span>
					<?php
					if (isset($err) && in_array('dia chi', $err)) {
						echo "<span>Ban chua nhap dia chi</span>";
					}
					?>
				</label>
				<div>
					<input type="text" name="address" id="address" size="25" placeholder ="Nhap dia chi.." value="<?php if(isset($_POST['address'])) echo $_POST['address'];?>"/>
				</div>
				<label for="fone">Phone: <span>*</span>
					<?php
					if (isset($err) && in_array('loi fone', $err)) {
						echo "<span>Không được bỏ trống || phải là kí tự số</span>";
					}
					?>
				</label>
				<div>
					<input type="text" name="fone" id="fone" size="25" maxlength="15" placeholder ="Nhap so dt.." value="<?php if(isset($_POST['fone'])) echo $_POST['fone'];?>"/>
				</div>
			</div>
		</fieldset>
		<p><input type="submit" name="dangki" value="Register">
		<input type="reset" name="huy" value="Cancel"></p>
	</form>
</section>
<?php } include('includes/footer.php');?>
