<?php 
	include('includes/header.php');
	include('includes/mysql_connect.php');
?>
<?php
// Người dùng nhấp và nút thanh toán
	if (isset($_POST['pay'])) {
		if (isset($_POST['sl'])) {
			foreach ($_POST['sl'] as $key => $value) {
				
				if ($value == 0) {
					unset($_SESSION['cart'][$key]);
				}elseif($value > 0 && preg_match('/^[0-9]{0,10}$/', $value)){
					$q = "SELECT hang_kho, title, author, price FROM books WHERE book_id = $key";
					$r = mysqli_query($conn, $q) or die ("error $q");
					if (mysqli_num_rows($r) == 1) {
						list($hang_kho, $title, $author, $price) = mysqli_fetch_array($r, MYSQLI_NUM);
						//kiểm tra ng mua nhập số lượng có lớn hơn số hàng trong kho không?
						if ($hang_kho - $value > 0) {
							$_SESSION['cart'][$key] = $value;
							$con_lai= ($hang_kho-$_SESSION['cart'][$key]);
							$bid = $key;
							$q = "UPDATE books SET hang_con = {$con_lai} WHERE book_id = $bid";
							$r = mysqli_query($conn, $q) or die("$q \n<br/> Mysql error ".mysqli_error($conn));
							if (mysqli_affected_rows($conn) == 1) {
								// echo "<script>alert('Tới đây là thanh toán thành công nhé !);
								// 	location.href=index.php;
								// </script>";
								$messages = "Thanh toán thành công";
							}else{
								echo "lỗi không thể thanh toán";
							}
						}else{
							echo "<table border='2'>";
							echo "<tr>";
							echo "<td class='error'> Tên sách: <span class='success'>".$title."</span> - Tác giả: <span class='success'>".$author."</span> - có giá: <span class='success'>".number_format($price, 3)."VNĐ</span> - Bạn mua với số lượng: <span class='success'>".$value."</span> - vượt quá giới hạn <= <span class='success'>".$hang_kho."</span></td>";
							echo "</table>";
							
						}
						echo "<hr/>";
					}else{
						echo "lỗi không có mặt hàng này !";
					}
				}else{
					echo "Số lượng k phải là kí tự số nguyên dương. !";
				}
			}
			if (isset($messages)) {
				echo "<script>alert('Tới đây là thanh toán thành công nhé ! Số tiền bạn phải thanh toán:".$_SESSION['total']."VNĐ');
					location.href=index.php;
					</script>";
			}
		}else{
			echo "Kí tự nhập vào số lượng k đúng !";
		}
	}// kết thúc nút thanh toán
// Người dùng nhấp và nút cập nhật
	if (isset($_POST['update'])) {
		if (isset($_POST['sl'])) {
			foreach ($_POST['sl'] as $key => $value) {
				
				if ($value == 0) {
					unset($_SESSION['cart'][$key]);
				}elseif($value > 0 && preg_match('/^[0-9]{0,10}$/', $value)){
					$q = "SELECT hang_kho, title, author, price FROM books WHERE book_id = $key";
					$r = mysqli_query($conn, $q) or die ("error $q");
					if (mysqli_num_rows($r) == 1) {
						list($hang_kho, $title, $author, $price) = mysqli_fetch_array($r, MYSQLI_NUM);
						//kiểm tra ng mua nhập số lượng có lớn hơn số hàng trong kho không?
						if ($hang_kho - $value > 0) {
							$_SESSION['cart'][$key] = $value;
						}else{
							echo "<table border='2'>";
							echo "<tr>";
							echo "<td class='error'> Tên sách: <span class='success'>".$title."</span> - Tác giả: <span class='success'>".$author."</span> - có giá: <span class='success'>".number_format($price, 3)."VNĐ</span> - Bạn mua với số lượng: <span class='success'>".$value."</span> - vượt quá giới hạn <= <span class='success'>".$hang_kho."</span></td>";
							echo "</table>";
							
						}
						echo "<hr/>";
					}else{
						echo "lỗi không có mặt hàng này !";
					}
				}else{
					echo "Số lượng k phải là kí tự số nguyên dương. !";
				}
			}
		}else{
			echo "Kí tự nhập vào số lượng k đúng !";
		}
	}// kết thúc nút cập nhật
	//Nhấp vào nút xóa sản phẩm
	if (isset($_GET['uid'])) {
		$uid = $_GET['uid'];
		if ($uid == 0) {
			unset($_SESSION['cart']);
			header("location:index.php");
		}else{
			unset($_SESSION['cart'][$uid]);			
		}
	}
	// Người dùng nhấp và nút thanh toán
	if (isset($_POST['pay'])) {
		
	}
?>
<aside class='gio_hang'>
	<form action="" method="POST">
		<?php
			if (isset($_SESSION['cart'])) {
				foreach ($_SESSION['cart'] as $key => $value) {
					$list[] = $key;
				}
				if (isset($list)) {
					$str = implode(',', $list);
				}else{
					header("location:index.php");
				}
				$total = 0;
				$q = "SELECT * FROM books WHERE book_id in ($str)";
				$r = mysqli_query($conn, $q) or die ("$q \n<br/>");
				if (mysqli_num_rows($r) > 0) {
					while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
						echo "<p>Tên sách - <span>$row[title]</span></p>";
						echo "<p>Tác giả - <span>$row[author]</span></p>";
						echo "<p>Số lượng:<input type='text' name='sl[$row[book_id]]' size='1' value='".trim($_SESSION['cart'][$row['book_id']])."'/>";
						echo "<p>Giá tiền - <span>".number_format($row['price'], 3)." VNĐ</span></p>";
						echo "<p>Giá tổng tiền sách này: <span>".number_format($row['price']*$_SESSION['cart'][$row['book_id']], 3)." VNĐ</span>-

							<span><a href='cart.php?uid={$row['book_id']}'>Xóa sản phẩm này</a></span>
						</p>";
						$total += $row['price']*$_SESSION['cart'][$row['book_id']];
						echo "<hr/>";
					}
					$_SESSION['total'] = number_format($total, 3);
					echo "<p>Tổng tiền phải trả: ".$_SESSION['total']."VNĐ
						- <span><a href='index.php'>Mua thêm</a></span>
						- <span><a href='cart.php?uid=0'>Xóa giỏ hàng</a></span>
					</p>";

				}
			}
		?>
		<input type="submit" name = "update" value="Cập nhật">
		<input type="submit" name = "pay" value="Thanh toán">
	</form>	
</aside>
<?php include('includes/footer.php');?>