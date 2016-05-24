	
<?php include ('../includes/header.php');?>
<?php include ('../includes/mysqli_connect.php');?>
<?php include ('../includes/functions.php');?>
<?php include ('../includes/sidebar-admin.php');?>

	<?php
		admin_access();
		if($_SERVER['REQUEST_METHOD'] == 'POST'){ // cau lenh xem gia tri ton tai, xu ly form
			$err = array();
			if (empty($_POST['category'])){
				$err[] = "Ban chua nhap truong categories";
			}else{
				$cat_name = mysqli_real_escape_string($conn, strip_tags($_POST['category']));
			}
			if (isset($_POST['position']) && filter_var($_POST['position'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
				$position = $_POST['position'];
			}else{
				$err[] = "Ban chua chon position";
			}
			if(empty($err)){
				$q = "insert into categories (user_id, cat_name, position) values (1, '{$cat_name}', $position)";
				$r = mysqli_query($conn, $q) or die ("Error");
				if(mysqli_affected_rows($conn) == 1){
					$messages= "<p>Them data thanh cong</p>";
				}else{
					$messages= "<p>Them data khong thanh cong</p>";
				}
			}else{
				$messages= "Loi khong the them du lieu";
			}
		}
	?>
	<section>
	<h3>Create category</h3>
	<?php
		if (!empty($messages)) {
			echo $messages;
		}
	?>
	<form action="" id = "add_cat" method="post">
		<fieldset>
			<legend>Add category</legend>
			<div>
				<label for="category">Category name: <span class="required">*</span>
				<?php 
					if(isset($err) && in_array('Ban chua nhap truong categories', $err)){
						echo "moi ban nhap truong nay";
					}
				?>
				</label><br/>
				<input type="text" name="category" id="category" value="<?php if (isset($_POST['category'])) {
					echo strip_tags($_POST['category']);
				}?>" size="20" maxlength="150" tabindex="1"/>
			</div>
			<div>
				<label for="position">Position: <span class="required">*</span>
				<?php 
					if(isset($err) && in_array('Ban chua chon position', $err)){
						echo "moi ban nhap truong nay";
					}
				?>
				</label><br/>
				<select name="position" id="position" tabindex="2">
					<?php
						$q = "select count(cat_id) as count from categories";
						$r = mysqli_query($conn, $q) or die ("err");
						if (mysqli_num_rows($r) == 1) {
							list($num) = mysqli_fetch_array($r, MYSQLI_NUM);
							for ($i=1; $i <= $num +1; $i++) { // tao vong lap cho option
								echo "<option value='{$i}'";
									if (isset($_POST['position']) && $_POST['position'] == $i) {
										echo "selected = 'selected'";
									}
								echo ">".$i."</option>";
							}
						}
					?>
				</select>
			</div>
		</fieldset>
		<input type="submit" name="submit" value="Add category"/>
	</form>
</section>
<?php include ('../includes/sidebar-b.php');?>
<?php include ('../includes/footer.php');?>

