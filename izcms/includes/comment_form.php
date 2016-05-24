<?php
	if(isset($_GET['pid']) && filter_var($_GET['pid'], FILTER_VALIDATE_INT, array('min_array' => 1))){
		$pid = $_GET['pid'];
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){ // Kiem tra nut gui cua form co ton tai hay khong?
			// Kiem tra cac truong co rong khong?
			$err = array();
			if(!empty($_POST['name'])){
				$name = mysqli_real_escape_string($conn, strip_tags($_POST['name']));
			}else{
				$err[] = "name";
			}
			if (!empty($_POST['url'])) {
				redirect_to('admin/thanks.html');
			}
			if (!empty($_POST['web'])) {
				redirect_to('admin/thanks.html');
			}
			if(!empty($_POST['email'])){
				$email = mysqli_real_escape_string($conn, strip_tags($_POST['email']));
			}else{
				$err[] = "email";
			}
			if(!empty($_POST['comment'])){
				$comment = mysqli_real_escape_string($conn, strip_tags($_POST['comment']));
			}else{
				$err[] = "comment";
			}
			if (isset($_POST['capcha']) && $_POST['capcha'] != 7) {
				$err[] = "capcha";
			}
			// Xac nhan ma catcha
			// $privatekey = "6Ldmox8TAAAAAFCbUKCKvItOYefMcPFbyWxGuO0e";
			//   $resp = recaptcha_check_answer ($privatekey,
			//                                 $_SERVER["REMOTE_ADDR"],
			//                                 $_POST["recaptcha_challenge_field"],
			//                                 $_POST["recaptcha_response_field"]);

			//   if (!$resp->is_valid) {
			//     // What happens when the CAPTCHA was entered incorrectly
			//     $err[] = "sai captcha";
			//   }
			// End xac nhan ma 

			// Khong rong tiep tuc thuc thi cau lenh chen data
			if(empty($err)){
				$q = "INSERT INTO ";
				$q .=" comments(page_id, author, email, comment, comment_date) ";
				$q .=" VALUES('$pid','{$name}', '{$email}', '{$comment}', NOW())";
				$r = mysqli_query($conn, $q);
				confirm_query($r, $q);
				if (mysqli_affected_rows($conn) == 1) {
					$messages = "comment success";
					$_POST= array();
				}else{
					$messages = "Error system database";
				}
			}else{
				$messages = "Khong the them data cho table comment";
			}
		}
	}
 ?>
 	<p class = "binhluan">Comments :
	<?php
	?>
 	</p>
<?php
	if(isset($pid)){
		$q4 = "SELECT comment_id, comment, author, comment_date FROM comments WHERE page_id = $pid ORDER BY comment_id DESC";
		$r4 = mysqli_query($conn, $q4);
		confirm_query($r4, $q4);
		if(mysqli_num_rows($r4) > 0){
			while(list($cmt_id, $comment, $author, $date) = mysqli_fetch_array($r4, MYSQLI_NUM)){
				echo "<p class ='comment'>".$comment;
				// xac nhan co dang nhap hay chua, co thi hien thi delete
				if (isset($_SESSION['user_level']) && $_SESSION['user_level'] == 2) {
					echo "<br/><a id=".$cmt_id." class='remove'>Delete</a>";
				}
				echo "<br/>Author :".$author;
				echo "<br/>".$date."</p>";
			}
		}
	}
?>
<form action="" method="POST">
	<?php
		if(isset($messages)){
			echo "<p style = 'color:red;'>".$messages."</p>";
		}
	?>
	<fieldset>
		<legend>Input comment</legend>
		<label for="name">Name<span>*</span>
		<?php 
			if (isset($err) && in_array("name", $err)) {
				echo "Moi ban nhap truong nay !";
			}
		?>
		</label>
		<!-- Kiem tra tinh bao mat chong spam -->
		<div class = "url"> <!-- Dung css an cau lenh nay -->
			<input type="text" name="url" />
		</div>
		<div>
			<input type="hidden" name="web"/> <!-- Dung the input voi thuoc tinh hidden an cau lenh nay -->
		</div>
		<!-- End chong spam -->
		<div>
			<input type="text" name="name" id="name" placeholder="Nhap ten" value="<?php if (isset($_POST['name'])) {
					echo strip_tags($_POST['name']);
				}?>">
		</div>
		<label for="email">Email<span>*</span>
		<?php 
			if (isset($err) && in_array("email", $err)) {
				echo "Moi ban nhap truong nay !";
			}
		?>	
		</label>
		<div>
			<input type="email" name="email" id="email" placeholder="Nhap email" value="<?php if (isset($_POST['email'])) {
					echo strip_tags($_POST['email']);
				}?>">
		</div>
		<label for="comment">Comment<span>*</span>
		<?php
			if(isset($err) && in_array('comment', $err)){
				echo "Moi ban comment";
			}
		?>
		</label>
		 <div id="comment">
		 	<textarea name="comment" rows="10" cols="50" tabindex="3"><?php if(isset($_POST['comment'])) {echo htmlentities($_POST['comment'], ENT_COMPAT, 'UTF-8');} ?>
		 	</textarea>
		 </div>
		<div>
			<label for="capcha">Nhap gia tri dung: Five plus tow ??<span>*</span>
			<?php
				if(isset($err) && in_array('capcha', $err)){
					echo "Gia tri nhap vao sai !";
				}
			?>
			</label>
		</div>
		<div>
			<input type="text" name="capcha" id="capcha" palceholder="Nhap dung phep toan">		
		</div>
<!-- 		<div class="g-recaptcha" data-sitekey="6Ldmox8TAAAAAFCbUKCKvItOYefMcPFbyWxGuO0e"></div> -->
		<div><input type="submit" name="gui" value="Comment" onclick = "return confirm('Are you sure ?')"><input type="reset" name="huy" value="Cancel" onclick = "return confirm('Are you sure ?')"></div>
	</fieldset>
</form>