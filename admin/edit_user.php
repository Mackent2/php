<?php 
	include('header-admin.php');
	include('../includes/mysql_connect.php');
	include('sidebar-admin.php');
?>
<?php
	if (isset($_GET['uid'])) {
		$uid = $_GET['uid'];
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$err = array();
			if (!empty($_POST['fn'])) {
				$fn = trim($_POST['fn']);
			}else{
				$err[] = "fn";
			}
			if (!empty($_POST['ln'])) {
				$ln = trim($_POST['ln']);
			}else{
				$err[] = "ln";
			}
			if (!empty($_POST['fone']) && preg_match('/^[0-9]{8,12}$/', trim($_POST['fone']))) {
				$fone = trim($_POST['fone']);
			}else{
				$err[] = "fone";
			}
				$address = trim($_POST['address']);
				$level = trim($_POST['level']);
			if (empty($err)) {
				$q = "UPDATE users SET first_name = '{$fn}', last_name = '{$ln}', diachi = '{$address}', fone = {$fone}, level = {$level} WHERE user_id = $uid";
				$r = mysqli_query($conn, $q) or die ("Query: {$q} \n<br/> MSQLI :".mysqli_error($conn));
				if (mysqli_affected_rows($conn) == 1) {
				 	$messages = "Sửa user thành công !";
				 }else{
						$messages = "User không có sự thay đổi nào !";
					}
			}
		}
	}
?>
<!--  Kiem tra su ton tai user truy van csdl ra  -->
<?php
	if (isset($uid)) {
		$q = "SELECT * FROM users WHERE user_id = $uid ";
		$r = mysqli_query($conn, $q) or die ("Query: {$q} \n<br/> MSQLI :".mysqli_error($conn));
		if (mysqli_num_rows($r) == 1) {
			$users = mysqli_fetch_array($r, MYSQLI_ASSOC);
?>
<div class="container">
		<form action="" method="POST" class ="form">
		<fieldset>
			<legend>Edit user email: <?php echo $users['email']?></legend>
				<?php
					if (isset($messages)) {
						echo "<p>".$messages."</p>";
					}
				?>
			<div class="edit">
				<div>
					<label for="fn">First name: <span>*</span>
						<?php
						if (isset($err) && in_array('fn', $err)) {
							echo "<span>Không được bỏ trống trường này</span>";
						}
						?>
					</label><br/>	
					<input type="text" name="fn" id="fn" size="25" value="<?php if(isset($users['first_name'])) echo $users['first_name'];?>" />
				</div>
				<div>
					<label for="ln">Last name: <span>*</span>
						<?php
							if (isset($err) && in_array('ln', $err)) {
								echo "<span>Không được bỏ trống trường này</span>";
							}
						?>
					</label><br/>
					<input type="text" name="ln" id="ln" size="25" value="<?php if(isset($users['last_name'])) echo $users['last_name'];?>"/>
				</div>
				<div>
					<label for="e">Email: <span>*</span>
					</label><br/>
				
					<input type="email" name="e" id="e" size="25"  value="<?php if(isset($users['email'])) echo $users['email'];?>" disabled = "disabled"/>
				</div>
				<div>
					<label for="address">Địa chỉ: <span>*</span>
						<?php
						if (isset($err) && in_array('dia chi', $err)) {
							echo "<span>Không được bỏ trống trường này</span>";
						}
						?>
					</label><br/>
				
					<input type="text" name="address" id="address" size="25" value="<?php if(isset($users['diachi'])) echo $users['diachi'];?>"/>
				</div>
				<div>
					<label for="fone">Phone: <span>*</span>
						<?php
						if (isset($err) && in_array('fone', $err)) {
							echo "<span>Định dạng kí tự số, pải > 10 kí tự</span>";
						}
						?>
					</label><br/>
				
					<input type="text" name="fone" id="fone" size="25" maxlength= '15' value="<?php if(isset($users['fone'])) echo $users['fone'];?>"/>
				</div>
				<div>
					<label for="level">Level: <span>*</span>
					</label><br/>
					<select name="level" id="">
						<?php
							$level = array(0 => 'user', 2 => 'admin');
							foreach($level as $key => $value){
								echo "<option value = '$key'";
									if ($key = $_GET['level']) {
										echo "selected = 'selected'";
									}
								echo ">".$value."</option>";
							}
						?>
					</select>
				</div>
			</div>
		</fieldset>
		<p><input type="submit" name="capnhat" value="EDIT USER"></p>
	</form>
</div>

<?php
		}else{
		header("location: login.php");
	}
	}else{
		header("location: login.php");
	}
?>
<?php include('../includes/footer.php');?>
