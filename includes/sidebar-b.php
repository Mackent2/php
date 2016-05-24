<?php
	if (isset($_SESSION['cart'])) {
		foreach ($_SESSION['cart'] as $uid => $so_luong) {
			if (isset($uid)) {
				$a = $uid;
			}
		}
		if (!isset($a)) {
			echo "Ban chưa có sản phẩm nào trong giỏ hàng !";
		}else{
			$tong = count($_SESSION['cart']);
			echo "Bạn đang có :".$tong." sản phẩm";
		}
	}else{echo "Ban chưa có sản phẩm nào trong giỏ hàng !";}
?>

<aside class='gio_hang'>
	<!-- hien thi co bao nhieu cuon sach mua -->
	<table border="2">
		<tr>
			<th>STT</th>
			<th>Tên sách</th>
			<th>Tác giả</th>
			<th>Giá</th>
			<th>Mua</th>
		</tr>
		<?php
			$q ="SELECT * FROM books";
			$r = mysqli_query($conn, $q) or die("error $q");
			if (mysqli_num_rows($r) > 0) {
				while($row = mysqli_fetch_array($r, MYSQLI_ASSOC)){
					echo "<tr>";
					echo "<td>$row[book_id]</td>";
					echo "<td>$row[title]</td>";
					echo "<td>$row[author]</td>";
					echo "<td>".number_format($row['price'], 3)." VNĐ</td>";
					echo "<td><a href='gio_hang.php?bid=$row[book_id]'>Mua sach nay</a></td>";
					echo "</tr>";
				}
			}
		?>
	</table>
	</p>
</aside>
