<?php 
session_start();
include ('../includes/mysqli_connect.php');?>
<?php include ('../includes/functions.php');?>
<?php 
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset($_FILES['images'])) { // kiem tra hinh co load chua
			$err = array();
			$dinhdang = array('image/jpeg', 'image/jpg', 'image/png', 'image/x-png');
			// tim kiem trong chuỗi array co chuỗi nào giống hay không?
			if (in_array(strtolower($_FILES['images']['type']), $dinhdang)) {
				// tách lấy chuỗi cuối cùng ! ví dụ ở đây lấy chuỗi jpg
				$cut = end(explode('.', $_FILES['images']['name']));
				// Đổi tên ngẫu nhiên với định dạng ng dùng đưa lên
				$rename = uniqid(rand(), true).'.'.$cut;
				// lưu lại file với thư mục mới
				if(!move_uploaded_file($_FILES['images']['tmp_name'], "../img/upload/".$rename)){
					$err = "file khong duoc luu";
				}
			}else{
				$err[] = "file vuot qua dung luong";
			}
			if (isset($_FILES['image']['error']) > 0) {
				switch ($_FILES['images']['error']) {
					case 1:
						$err[] = "Loi 1";
						break;
					case 2:
						$err[] = "Loi vuot qua dung luong cho phep";
						break;
					case 3:
						$err[] = "Loi upload mot phan ";
						break;
					case 4:
						$err[] = "Loi khong tim thay file up load";
						break;
					case 6:
						$err[] ="Khong tim thay foldel";
						break;
					case 8:
						$err[] = "Upload stop";
					default:
						$err[] = "Loi system";
						break;
				}
			}

		}
	}
	if (isset($_FILES['images']['tmp_name']) && is_file($_FILES['images']['tmp_name']) && file_exists($_FILES['images']['tmp_name'])) {
		unlink($_FILES['images']['tmp_name']);
	}
	if (empty($err)) {
		$q = "UPDATE users SET avatar = '{$rename}' WHERE user_id = {$_SESSION['user_id']}";
		$r = mysqli_query($conn, $q); confirm_query($r, $q);
		if (mysqli_affected_rows($conn) > 0) {
			redirect_to('edit_profile.php');
		}
	}
	print_r($err);
?>