	
<?php include ('../includes/header.php');?>
<?php include ('../includes/mysqli_connect.php');?>
<?php include ('../includes/functions.php');?>
<?php include ('../includes/sidebar-admin.php');?>
<?php admin_access();

?>
	<?php
		is_admin();
		if (isset($_GET['edit']) && filter_var($_GET['edit'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
			$uid = $_GET['edit'];
		if($_SERVER['REQUEST_METHOD'] == 'POST'){ // cau lenh xem gia tri ton tai, xu ly form
			$err = array();
			if (empty($_POST['fn'])){
				$err[] = "fn";
			}else{
				$fn = mysqli_real_escape_string($conn, strip_tags($_POST['fn']));
			}
			if (empty($_POST['ln'])){
				$err[] = "ln";
			}else{
				$ln = mysqli_real_escape_string($conn, strip_tags($_POST['ln']));
			}
			// if (empty($_POST['e'])){
			// 	$err[] = "e";
			// }else{
			// 	$e = mysqli_real_escape_string($conn, strip_tags($_POST['e']));
			// }
			if (empty($_POST['web'])){
				$err[] = "web";
			}else{
				$web = mysqli_real_escape_string($conn, strip_tags($_POST['web']));
			}
			if (empty($_POST['yh'])){
				$err[] = "yh";
			}else{
				$yh = mysqli_real_escape_string($conn, strip_tags($_POST['yh']));
			}
			if (isset($_POST['level'])) {
				$level = $_POST['level'];
			}
			if(empty($err)){
				$q = "UPDATE users 
					SET user_level = '{$level}', 
					first_name = '{$fn}', 
					last_name = '{$ln}',
					website = '{$web}',
					yahoo = '{$yh}'
					WHERE user_id = {$uid} LIMIT 1";
				$r = mysqli_query($conn, $q);
				confirm_query($r, $q);
				if(mysqli_affected_rows($conn) == 1){
					$messages= "<p>Update data thanh cong</p>";
				}else{
					$messages= "<p>Update data khong thanh cong</p>";
				}
			}else{
				$messages= "Loi khong the Update du lieu";
			}
		}
	}else{
		redirect_to('admin/manage_users.php');
	}
	?>
	<?php
		$q = "SELECT user_id, first_name, last_name, email, website, yahoo, user_level FROM users WHERE user_id = {$uid} LIMIT 1";
		$r = mysqli_query($conn, $q);
		confirm_query($r, $q);
		if(mysqli_num_rows($r) == 1){
			list($uid, $fn, $ln, $e, $web, $yh, $level) = mysqli_fetch_array($r, MYSQLI_NUM);
		}
	?>
	<section>
	<h3>Edit users: <?php if(isset($e)) echo $e;?></h3>
	<?php
		if (!empty($messages)) {
			echo $messages;
		}
	?>

	<?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $uid) {?><!-- neu nguoi dung ton tai thi hien thi form ra -->
	<form action="" id = "add_cat" method="post">
		<fieldset>
			<legend>Update category</legend>
			<!-- <div>
				<label for="">Chọn categories cần update:</label><br/>
				<select>
					<?php 
						$q2 = "SELECT cat_name FROM categories ORDER BY cat_name ASC";
						$r2 = mysqli_query($conn, $q2);
						confirm_query($r2, $q2);
						while($catN = mysqli_fetch_array($r2, MYSQLI_ASSOC)){
							echo "<option>".$catN['cat_name']."</option>";
						}
					?>
				</select>
			</div> -->
			<div>
				<label for="fn">First name: <span class="required">*</span>
				<?php 
					if(isset($err) && in_array('fn', $err)){
						echo "moi ban nhap truong nay";
					}
				?>
				</label><br/>
				<input type="text" name="fn" id="fn" value="<?php if(isset($fn)) echo $fn;?>" size="30" maxlength="150" tabindex="1"/>
			</div>
			<div>
				<label for="ln">Last name: <span class="required">*</span>
				<?php 
					if(isset($err) && in_array('ln', $err)){
						echo "moi ban nhap truong nay";
					}
				?>
				</label><br/>
				<input type="text" name="ln" id="ln" value="<?php if(isset($ln)) echo $ln;?>" size="30" maxlength="150" tabindex="1"/>
			</div>
			<div>
				<label for="e">email: <span class="required">*</span>
				<?php 
					if(isset($err) && in_array('e', $err)){
						echo "moi ban nhap truong nay";
					}
				?>
				</label><br/>
				<input type="email" name="e" id="e" value="<?php if(isset($e)) echo $e;?>" size="30" maxlength="150" tabindex="1" disabled = "disabled"/>
			</div>
			<div>
				<label for="web">Website: <span class="required">*</span>
				<?php 
					if(isset($err) && in_array('web', $err)){
						echo "moi ban nhap truong nay";
					}
				?>
				</label><br/>
				<input type="text" name="web" id="web" value="<?php if(isset($web)) echo $web;?>" size="30" maxlength="150" tabindex="1"/>
			</div>
			<div>
				<label for="yh">yahoo: <span class="required">*</span>
				<?php 
					if(isset($err) && in_array('yh', $err)){
						echo "moi ban nhap truong nay";
					}
				?>
				</label><br/>
				<input type="text" name="yh" id="yh" value="<?php if(isset($yh)) echo $yh;?>" size="30" maxlength="150" tabindex="1"/>
			</div>
			<div>
				<label for="level">Level: <span class="required">*</span>
				<?php 
					if(isset($err) && in_array('Ban chua chon position', $err)){
						echo "moi ban nhap truong nay";
					}
				?>
				</label><br/>
				<select name="level" id="level" tabindex="2">
					<?php
						$roles = array(0 => 'user', 2 => 'admin');
						foreach($roles as $key => $role){
							echo "<option value={$key}";
							if ($key == $level) {
								echo "selected = selected";
							}
							echo ">".$role."</option>";
						}
					?>
					<!-- <option value ='0''>user</option>
					<option value ='2''>admin</option> -->
				</select>
			</div>
		</fieldset>
		<input type="submit" name="submit" value="Update category"/>
	</form>
	<?php }else{ echo "<p>khong tin thay trang !</p>";}?>
</section>
<?php include ('../includes/sidebar-b.php');?>
<?php include ('../includes/footer.php');?>

