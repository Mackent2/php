<?php 
	include('header-admin.php');
	include('../includes/mysql_connect.php');
	include('sidebar-admin.php');
?>
<?php
	if (isset($_SESSION['uid'])) {
		$uid = $_SESSION['uid'];
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$err =array();
			if (empty($_POST['pass'])) {
				$err[] = "cu";
			}else{
				$passcu = $_POST['pass'];
			}
			if (empty($_POST['pass1'])) {
				$err[] = "moi";
			}
			if (isset($_POST['pass1'], $_POST['pass2']) && $_POST['pass1'] == $_POST['pass2']) {
				$passnew = $_POST['pass1'];
			}
			if (empty($err)) {
				$q = "UPDATE users SET pass = SHA1('{$passnew}') WHERE user_id = {$uid} && pass = SHA1('{$passcu}') ";
				$r = mysqli_query($conn, $q) or die ("Query: {$q} \n<br/> MSQLI :".mysqli_error($conn));
				if (mysqli_affected_rows($conn) == 1) {
					$messages = "Thay đổi password thành công";
				}else{
					$messages = "Password sai !";
				}
			}
			
		}
	}else{
		header("location:".url."index.php");
	}
?>
<div class="container">
		<form action="" method="POST" class ="form">
		<fieldset>
			<legend>Change password: <?php echo $_SESSION['e'];?></legend>
				<?php
					if (isset($messages)) {
						echo "<p>".$messages."</p>";
					}
				?>
			<div class="edit">
				<div>
					<label for="pass">Password cũ: <span>*</span>
						<?php
							if (isset($err) && in_array('cu', $err)) {
								echo "<span>Không được bỏ trống trường này</span>";
							}
						?>
					</label><br/>
					<input type="password" name="pass" id="pass" size="25" placeholder ="Nhap password cũ.." value=""/>
				</div>
				<div>
					<label for="pass1">New password: <span>*</span>
						<?php
							if (isset($err) && in_array('moi', $err)) {
								echo "<span>Không được bỏ trống trường này</span>";
							}
						?>
					</label><br/>
					<input type="password" name="pass1" id="pass1" size="25" placeholder ="Nhap password mới.." value=""/>
				</div>
				<div>
				<label for="pass2">Confirm new password: <span>*</span>
					<?php
					if (isset($_POST['pass1'], $_POST['pass2']) && $_POST['pass1'] != $_POST['pass2'] ) {
						echo "<span>New password confirm no pass</span>";
					}
				?>
				</label><br/>
					<input type="password" name="pass2" id="pass2" size="25" placeholder ="Nhap lai password.." />
				</div>
			</div>
		</fieldset>
		<p><input type="submit" name="capnhat" value="Confirm" click ="return confirm('Bạn có muốn thay đổi mật khẩu')"></p>
	</form>
</div>
<?php include('../includes/footer.php');?>
