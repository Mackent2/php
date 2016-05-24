<div class="container">
<aside>
<?php
	if (isset($_SESSION['uid'])) {
		$q = "SELECT level FROM users WHERE user_id = {$_SESSION['uid']}";
		$r = mysqli_query($conn, $q) or die ("Query : {$q} \n<br/> Mysqli error:".mysqli_error($conn));
		if (mysqli_num_rows($r) == 1) {
			list($level) = mysqli_fetch_array($r, MYSQLI_NUM);
		}else{
			header("location:".url."index.php");
		}
		if (isset($level)) {
			switch ($level) {
				case 2:
					echo "<ul>";
					echo "<li><a href='manage_user.php'";
						if (basename($_SERVER [ 'SCRIPT_NAME']) == 'manage_user.php'){
							echo "class = 'access'";
						}
					echo ">Manage User</a></li>";
					echo "<li><a href='change_img.php'";
						if (basename($_SERVER [ 'SCRIPT_NAME']) == 'change_img.php'){
							echo "class = 'access'";
						}
					echo ">Thay hình đại diện</a></li>
						<li><a href='#'>...</a></li>
						<li><a href='#'>...</a></li>";
					echo "<li><a href='change_pass.php'";
						if (basename($_SERVER [ 'SCRIPT_NAME']) == 'change_pass.php'){
							echo "class = 'access'";
						}
					echo ">Change pass</a></li>";
					echo "<li><a href='logout.php'>logout</a></li>
					</ul>";
					break;
				case 0:
					echo "<ul>";
					echo "<li><a href='change_img.php'";
						if (basename($_SERVER [ 'SCRIPT_NAME']) == 'change_img.php'){
							echo "class = 'access'";
						}
					echo ">Thay hình đại diện</a></li>
						<li><a href='#'>...</a></li>
						<li><a href='#'>...</a></li>";
					echo "<li><a href='change_pass.php'";
						if (basename($_SERVER [ 'SCRIPT_NAME']) == 'change_pass.php'){
							echo "class = 'access'";
						}
					echo ">Change pass</a></li>";
					echo "<li><a href='logout.php'>logout</a></li>
					</ul>";
					break;
				
				default:
					echo "<ul>";
					echo "<li><a href='#'>...</a></li>
						<li><a href='#'>...</a></li>
						<li><a href='#'>...</a></li>";
					echo "<li><a href='logout.php'>logout</a></li>
					</ul>";
					break;
			}
		}else{
			echo "
				<ul>
				<li><a href='change_pass.php'>Change pass</a></li>
				<li><a href='#'>Add user</a></li>
				<li><a href='#'>Add user</a></li>
				<li><a href='#'>Add user</a></li>
				<li><a href='logout.php'>logout</a></li>
			</ul>

			";
		}
	}
?>
</aside>