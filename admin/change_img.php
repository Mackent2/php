<?php 
	include('header-admin.php');
	include('../includes/mysql_connect.php');
	include('sidebar-admin.php');
?>
<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$err = array();
			$dinhdang = array('jpeg', 'jpg', 'png', 'x-png');
		if (!empty($_FILES['img'])) {
			$images = $_FILES['img'];
			$name = (end(explode('/', $images['type'])));
		}else{
			$err[] = "img";
		}
		if (!in_array((end(explode('/', $images['type']))), $dinhdang)) {
			$err[] = 'dinh dang';
		}
		if ($images['error'] != 0) {
			$err[] = "Loi tai file len";
		}
		if ($images['size'] > 524288) {
			$err[] = 'size lon qua';
		}
		if (empty($err)) {
			$change_name = md5(uniqid(rand(), true)).".".$name;
			move_uploaded_file($images['tmp_name'], "../img/upload/".$change_name);
			$q = "UPDATE users SET images = '{$change_name}' WHERE email = '{$_SESSION['e']}'";
			$r = mysqli_query($conn, $q) or die ("Query : {$q} \n<br/> Mysqli error".mysqli_error($conn));
			if (mysqli_affected_rows($conn) == 1) {
				$messages =  "<span class='success'>Tải ảnh đại diện thành công</span>";
			}else{
				$messages = "Loi he thong !";
			}
		}else{
			$messages = "<span class='error'>Chưa chọn file !</span>";
		}
	}
?>
<div class="container">
	<form action="" method="POST" enctype="multipart/form-data">
	<!-- Truy vấn csdl lấy hình ảnh ra ngoài web -->
		<?php
			$q = "SELECT images FROM users WHERE email = '{$_SESSION['e']}'";
			$r = mysqli_query($conn, $q) or die ("Query : {$q} \n<br/> Mysqli error".mysqli_error($conn));
			if (mysqli_num_rows($r) == 1) {
				list($img) = mysqli_fetch_array($r, MYSQLI_NUM);
				if ($img == NULL) {
					echo "
					<img src='../img/upload/hotgril.jpg' width='150' height='130' alt='hinh dai dien' title='hinh dai dien'/>
					";
				}else{
					echo "
					<img src='../img/upload/{$img}' width='150' height='130' alt='hinh dai dien' title='hinh dai dien'/>
					";
				}		
			}
		?>
	<!-- End lấy hình ra -->
		<div class="change_img">
			<label for="">Chọn hình đại diện
				<?php
					if (isset($messages)) {
						echo $messages;
					}
				?>
			</label>
			<div>
				<input type="file" name="img" >
				<input type="hidden" name="MAX_FILE_SIZE">
				<p>
					<?php
						 if(isset($err) && in_array('img', $err)) echo 'File anh chua duoc chon';
						 if(isset($err) && in_array('dinh dang', $err)) echo 'File images phải có định dạng jpg or png';
						 if(isset($err) && in_array('loi tai file len', $err)) echo 'Lỗi system !';
						 if(isset($err) && in_array('size lon qua', $err)) echo 'File ảnh không được lơn hơn 512kb';
					?>
				</p>
			</div>
			
		</div>
		<p><input type="submit" name="upload" value="Tải Lên"></p>
	</form>
</div>
<?php include('../includes/footer.php');?>
