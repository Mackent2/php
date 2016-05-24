<?php include ('includes/header.php');?>
<?php include ('includes/mysqli_connect.php');?>
<?php include ('includes/functions.php');?>
<?php include ('includes/sidebar-a.php');?>
<section>
<?php 
	is_logined_in();
	$user = fetch_user($_SESSION['user_id']);
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$err = array();
		$trimmed = array_map('trim', $_POST);
		if (preg_match('/^[\w]{2,10}$/i', $trimmed['fn_name'])) {
			$fn = $trimmed['fn_name'];
		}else{
			$err[] = "fn_name";
		}
		if (preg_match('/^[\w]{2,10}$/i', $trimmed['l_name'])) {
			$ln = $trimmed['l_name'];
		}else{
			$err[] = "l_name";
		}
		if (filter_var($trimmed['email'], FILTER_VALIDATE_EMAIL)) {
			$e = $trimmed['email'];
		}else{
			$err[] = "email";
		}
		$web = (!empty($trimmed['web'])) ? $trimmed['web'] : NULL;
		$yahoo = (!empty($trimmed['yahoo'])) ? $trimmed['yahoo'] : NULL;
		$bio = (!empty($trimmed['bio'])) ? $trimmed['bio'] : NULL;
		if (empty($err)) {
			$q = "UPDATE users SET first_name = ?, last_name = ?, email = ?, website = ?, yahoo = ?, bio = ? WHERE user_id = ? LIMIT 1";
			$stmt = mysqli_prepare($conn, $q);
			mysqli_stmt_bind_param($stmt, 'ssssssi', $fn, $ln, $e, $web, $yahoo, $bio, $_SESSION['user_id']);
			mysqli_stmt_execute($stmt) or die ("Mysqli query $q ".mysqli_stmt_error($stmt));
			if (mysqli_stmt_affected_rows($stmt) > 0) {
				$messages = "<p>upload file success</p>";
			}else{
				$messages = "<p>Loi khong the upload system</p>";
			}
		}
		// if (empty($err)) {
		// 	$q = "UPDATE users SET first_name = '{$fn}', last_name = '{$ln}' , email = '{$e}', website = '{$web}', yahoo = '{$yahoo}', bio = '{$bio}',";
		// 	$r = mysqli_query($conn, $q); confirm_query($r, $q);
		// }
		
	}
 ?>
 <?php if (isset($messages)) {
 	echo $messages;
 }?>
 <form enctype="multipart/form-data" action="processor/avatar.php" method= "POST">
	<fieldset>
		<legend>Upload images</legend>
		<div>
			<img src="img/upload/<?php echo (is_null($user['avatar']) ? "youtube.jpg" : $user['avatar']);?>" alt="" class="avatar" width="90px" height="90px;" />
			<p>Định dạng file img .jpg or png, và giới hạn file 1512kb</p>
			<input type="hidden" name="MAX_FILE_SIZE" value="1524288">
			<input type="file" name="images">
			<p><input type="submit" name="upload" value="Save changes" class="change"/></p>
		</div>
	</fieldset>
</form>
<form action="" method= "POST">
	<fieldset>
		<legend>User info</legend>
			<label for="fn_name">First name</label>
			<div>
				<input type="text" name="fn_name" id= "fn_name" value="<?php if(isset($user['first_name']))echo $user['first_name'];?>" />
			</div>
			<label for="l_name">Last name</label>
			<div>
				<input type="text" name="l_name" id="l_name" value="<?php if(isset($user['last_name'])) echo $user['last_name'];?>"/>
			</div>		
	</fieldset>
	<fieldset>
		<legend>Contact info</legend>
		<label for="email">Email</label>
		<div>
			<input type="email" name="email" value="<?php if(isset($user['email']))echo $user['email'];?>">
		</div>
		<label for="web">Website</label>
		<div>
			<input type="text" name="web" id="web" value="<?php if(isset($user['website'])) echo $user['website'];?>">
		</div>
		<label for="yahoo">Yahoo</label>
		<div>
			<input type="text" name="yahoo" value="<?php if(isset($user['yahoo'])) echo $user['yahoo'];?>">
		</div>
	</fieldset>
	<fieldset>
		<legend>About Youself</legend>
		<textarea name="bio" id="" cols="30" rows="10"><?php if(isset($user['bio'])) echo $user['bio'];?></textarea>
	</fieldset>
	<p><input type="submit" name="capnhat" value="Cập nhật"></p>
</form>
		<!-- end page cho pages -->
</section>
<?php include ('includes/sidebar-b.php');?>
<?php include ('includes/footer.php');?>

