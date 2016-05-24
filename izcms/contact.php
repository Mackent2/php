<?php include ('includes/header.php');?>
<?php include ('includes/mysqli_connect.php');?>
<?php include ('includes/functions.php');?>
<?php include ('includes/sidebar-a.php');?>
<section>
<?php
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){ // Kiem tra nut gui cua form co ton tai hay khong?
			// Kiem tra cac truong co rong khong?
			$err = array();
			if(empty($_POST['name'])){
				$err[] = "name";
			}
			if (!empty($_POST['url'])) {
				redirect_to('admin/thanks.html');
			}
			if (!empty($_POST['web'])) {
				redirect_to('admin/thanks.html');
			}
			if(empty($_POST['email'])){
				$err[] = "email";
			}
			if(empty($_POST['comment'])){
				$err[] = "comment";
			}
			if (isset($_POST['capcha']) && $_POST['capcha'] != 7) {
				$err[] = "capcha";
			}
			if (empty($err)) {
				$body = "Name: {$_POST['name']} \n\n Comment: \n ".strip_tags($_POST['comment']);
				$body = wordwrap($body, 70);
				if(mail('hoanganhvt2@gmail.com', 'Contact form izCMS', $body, 'FROM: localhost@localhost')){
					echo "Contact success";
					$_POST = array();
				}else{
					echo "Sorry contact system !";
				}
			}else{
				echo "Moi ban nhap cac truong";
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
		<legend>Contact</legend>
		<label for="name">Your Name<span>*</span>
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
		<label for="comment">Your Message<span>*</span>
		<?php
			if(isset($err) && in_array('comment', $err)){
				echo "Moi ban comment";
			}
		?>
		</label>
		<div>
			<textarea name="comment" id="comment" cols="50%" rows="10" placeholder="Nhap comment">
				<?php if (isset($_POST['comment'])) {echo strip_tags($_POST['comment']);}?>
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
		<div><input type="submit" name="gui" value="Lien he" onclick = "return confirm('Are you sure ?')"><input type="reset" name="huy" value="Cancel" onclick = "return confirm('Are you sure ?')"></div>
	</fieldset>
</form>
</section>
<?php include ('includes/sidebar-b.php');?>
<?php include ('includes/footer.php');?>
