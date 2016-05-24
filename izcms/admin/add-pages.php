	
<?php include ('../includes/header.php');?>
<?php include ('../includes/mysqli_connect.php');?>
<?php include ('../includes/functions.php');?>
<?php include ('../includes/sidebar-admin.php');?>
<?php
	admin_access();
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
		if (isset($_POST['position']) && filter_var($_POST['category'], FILTER_VALIDATE_INT, array('min_array' => 1))) {
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
			$q= "INSERT INTO pages (user_id, cat_id, page_name, content, position, post_on) values (1, '{$cat_id}', '{$page_name}', '{$content}', $position, NOW())";
			$r = mysqli_query($conn, $q) or die ("Query {$q} \n<br/> MySQL Error :".mysqli_error($conn));
			if (mysqli_affected_rows($conn) == 1) {
				$messages = "Them du lieu thanh cong";
			}else{
				$messages = "Them du lieu khong thanh cong";
			}

		}else{
			$messages = "Loi can nhap dung cac truong";
		}
	}
?>
<section>
<h3>Create pages</h3>
<?php if (!empty($messages)) {
	echo $messages;
}?>
<form action="" method="post">
	<fieldset>
		<legend>Add a page</legend>
		<div>
			<label for="page">Page name:<span>*</span>
				<?php if (isset($err) && in_array('pagename', $err)) {
					echo "Moi ban nhap truong nay";
				}?>
			</label><br/>
			<input type="text" name="page_name" id="page" tabindex="1">
		</div>
		<div>
			<label for="category">All category:<span>*</span>
				<?php if (isset($err) && in_array('category', $err)) {
					echo "bạn chưa chọn category";
				}?>
			</label><br/>
			<select name="category" id="category">
			<option>All category</option>
				<?php 
					$q = "SELECT cat_id, cat_name FROM categories order by position ASC";
					$r = mysqli_query($conn, $q) or die ('loi khong the truy cap');
					if (mysqli_num_rows($r) > 0 ) {
					 	while($cats =  mysqli_fetch_array($r, MYSQLI_ASSOC)){
					 		echo "<option value='{$cats['cat_id']}'";
					 			if (isset($_POST['category']) && ($_POST['category'] == $cats['cat_id'])) {
					 				echo "selected = 'selected'";
					 			}
					 		echo ">".$cats['cat_name']."</option>";
					 	}
					 } 
				?>
			</select>
		</div>
		<div>
			<label for="position">Position<span>*</span>
				<?php if (isset($err) && in_array('position', $err)) {
					echo "Bạn chưa chọn position";
				}?>
			</label><br/>
			<select name="position" id="position">
				<?php
					$q = "SELECT count(page_id) as count from pages ORDER BY position ASC";
					$r = mysqli_query($conn, $q) or die ("Khong the ket noi");
					if(mysqli_num_rows($r) == 1){
						list($num) = mysqli_fetch_array($r, MYSQL_NUM);
						for ($i=1; $i <= $num+1 ; $i++) { 
							echo "<option value='{$i}'";
								if (isset($_POST['position']) && $_POST['position'] == $i) {
									echo "selected= 'selected'";
								}
							echo">".$i."</option>";
						}
					}

				?>
			</select>
		</div>
		<div>
			<label for="content">Page content:<span>*</span>
				<?php if (!empty($err) && in_array("content", $err)){
					echo "bạn chưa nhập content";
				}?>
			</label><br/>
			<textarea name="content" id="content" cols="50" rows="20"></textarea>
		</div>
	</fieldset>
	<p><input type="submit" name="submit" value="ADD Page"/></p>
</form>
</section>
<?php include ('../includes/sidebar-b.php');?>
<?php include ('../includes/footer.php');?>

