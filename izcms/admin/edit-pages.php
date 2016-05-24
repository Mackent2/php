	
<?php include ('../includes/header.php');?>
<?php include ('../includes/mysqli_connect.php');?>
<?php include ('../includes/functions.php');?>
<?php include ('../includes/sidebar-admin.php');?>
<?php admin_access();	 ?>
<?php
	if (isset($_GET['pid']) &&filter_var($_GET['pid'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
		$pid = $_GET['pid'];
		if($_SERVER['REQUEST_METHOD'] == 'POST'){ // cau lenh xem gia tri ton tai, xu ly form
			$err = array();
			if (empty($_POST['page_name'])) {
				$err[] = "pagename";
			}else{
				$page_name = mysqli_real_escape_string($conn, strip_tags($_POST['page_name']));
			}
			if (isset($_POST['category']) && filter_var($_POST['category'], FILTER_VALIDATE_INT, array('min_array' => 1))) {
				 $cat_id = $_POST['category'];
			}else{
				$err[] = "category";
			}
			if (isset($_POST['position']) && filter_var($_POST['position'], FILTER_VALIDATE_INT, array('min_array' => 1))) {
				$position = $_POST['position'];
			}else{
				$err[] = "position";
			}
			if (empty($_POST['content'])) {
				$err[] = "content";
			}else{
				$content = mysqli_real_escape_string($conn, $_POST['content']);
			}
			if (empty($err)) {
				$q= "UPDATE pages SET page_name ='{$page_name}', cat_id = '{$cat_id}', content = '{$content}', position = {$position}, post_on = NOW() WHERE page_id ={$pid}";
				$r = mysqli_query($conn, $q) or die ("Query {$q} \n<br/> MySQL Error :".mysqli_error($conn));
				if (mysqli_affected_rows($conn) == 1) {
					$messages = "Them du lieu pages thanh cong";
				}else{
					$messages = "Them du lieu pages khong thanh cong";
				}

			}else{
				$messages = "Loi can nhap dung cac truong";
			}
		}
	}else{
		redirect_to('admin/view-pages.php');
		}
?>
<?php
	$q2 = "SELECT * FROM pages WHERE page_id ={$pid} ";
	$r2 = mysqli_query($conn, $q2);
	confirm_query($r2, $q2);
	if (mysqli_num_rows($r2) == 1) {
		$page = mysqli_fetch_array($r2, MYSQLI_ASSOC);
	}else{
		$messages = "Trang khong ton tai";
	}
?>
<section>
<h3>Update pages: <?php if(isset($page['page_name'])) echo $page['page_name'];?></h3>
<?php if (!empty($messages)) {
	echo $messages;
}?>
<form action="" method="post">
	<fieldset>
		<legend>Update a page</legend>
		<div>
			<label for="page">Page name:<span>*</span>
				<?php if (isset($err) && in_array('pagename', $err)) {
					echo "Moi ban nhap truong nay";
				}?>
			</label><br/>
			<input type="text" name="page_name" id="page" tabindex="1" value="<?php echo $page['page_name'];?>">
		</div>
		<div>
			<label for="category">All category:<span>*</span>
				<?php if (isset($err) && in_array('category', $err)) {
					echo "bạn chưa chọn category";
				}?>
			</label><br/>
			<select name="category" id="category">
				<?php 
					$q = "SELECT cat_id, cat_name FROM categories order by position ASC";
					$r = mysqli_query($conn, $q);
					confirm_query($r, $q);
					if (mysqli_num_rows($r) > 0) {
					 	while($cats = mysqli_fetch_array($r, MYSQLI_ASSOC)){
					 		echo "<option value='{$cats['cat_id']}'";
					 			if (isset($page['cat_id']) && ($page['cat_id'] == $cats['cat_id'])) {
					 				echo "selected = 'selected'";
					 			}
					 		echo ">".$cats['cat_name']."</option>";
					 	}
					 } 
				?>
			</select>
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
									if (isset($page['position']) && $page['position'] == $i) {
										echo "selected = 'selected'";
									}
								echo ">".$i."</option>";
							}
						}
					?>
				</select>
			</div>
		<div>
			<label for="content">Page content:<span>*</span></label><br/>
			<textarea name="content" id="content" cols="50" rows="20"><?php echo $page['content'];?></textarea>
		</div>
	</fieldset>
	<p><input type="submit" name="submit" value="Update Page" onclick= "return confirm('Are you sure ?')"/></p>
</form>
</section>
<?php include ('../includes/sidebar-b.php');?>
<?php include ('../includes/footer.php');?>

