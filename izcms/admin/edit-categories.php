	
<?php include ('../includes/header.php');?>
<?php include ('../includes/mysqli_connect.php');?>
<?php include ('../includes/functions.php');?>
<?php include ('../includes/sidebar-admin.php');?>
<?php admin_access();	 ?>
	<?php
		if(isset($_GET['edit']) && filter_var($_GET['edit'], FILTER_VALIDATE_INT, array('min_range' => 1))){
			$edit = $_GET['edit'];
		}else{
			redirect_to('admin/admin.php');
		}
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
				$q = "UPDATE categories SET cat_name = '{$cat_name}', position = {$position} WHERE cat_id = {$edit} LIMIT 1";
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
	?>
	<?php
		$q = "SELECT cat_name, position FROM categories WHERE cat_id = {$edit} LIMIT 1";
		$r = mysqli_query($conn, $q);
		confirm_query($r, $q);
		if(mysqli_num_rows($r) == 1){
			list($cat_name, $position) = mysqli_fetch_array($r, MYSQLI_NUM);
		}else{
			$messages = "Khong co truong categaries ban chon !";	
		}
	?>
	<section>
	<h3>Update category: <?php if(isset($cat_name)) echo $cat_name;?></h3>
	<?php
		if (!empty($messages)) {
			echo $messages;
		}
	?>
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
				<label for="">Bạn chọn update categories:</label><br/>
				<input type="text" name="category" id="category" value="<?php if (isset($_GET['edit'])) {
					$edit = $_GET['edit'];
					$q3 = "SELECT cat_name FROM categories WHERE cat_id = {$edit} ORDER BY cat_name ASC";
					$r3 = mysqli_query($conn, $q3);
					confirm_query($r3, $q3);
					while($catN = mysqli_fetch_array($r3, MYSQLI_ASSOC)){
						echo $catN['cat_name'];
					}
				}?>" size="20" maxlength="150" tabindex="1" disabled = disabled/>
			</div>
			<div>
				<label for="category">Update tên mới: <span class="required">*</span>
				<?php 
					if(isset($err) && in_array('Ban chua nhap truong categories', $err)){
						echo "moi ban nhap truong nay";
					}
				?>
				</label><br/>
				<input type="text" name="category" id="category" value="<?php if(isset($cat_name)) echo $cat_name;?>" size="20" maxlength="150" tabindex="1"/>
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
									if (isset($position) && $position == $i) {
										echo "selected = 'selected'";
									}
								echo ">".$i."</option>";
							}
						}
					?>
				</select>
			</div>
		</fieldset>
		<input type="submit" name="submit" value="Update category"/>
	</form>
</section>
<?php include ('../includes/sidebar-b.php');?>
<?php include ('../includes/footer.php');?>

