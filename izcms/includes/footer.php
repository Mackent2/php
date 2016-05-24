	<footer>
		<ul>
			<?php
				// Neu ton tai $_SESSION
				if (isset($_SESSION['user_level'])) {
					switch ($_SESSION['user_level']) {
						case 0:
							echo "
								<li><a href='".URL."edit_profile.php'>User Profile</a></li>
								<li><a href='".URL."change_password.php'>Change password</a></li>
								<li><a href='#'>Personal Messages</a></li>
								<li><a href='".URL."admin/logout.php'>Log Out</a></li>				
							";
							break;
						case 2:
							echo "
								<li><a href='".URL."edit_profile.php'>User Profile</a></li>
								<li><a href='".URL."change_password.php'>Change password</a></li>
								<li><a href='#'>Personal Messages</a></li>
								<li><a href='".URL."admin/admin.php'>Admin CP</a></li>
								<li><a href='".URL."admin/logout.php'>Log Out</a></li>				
							";

							break;
						
						default:
								echo "<li><a href='".URL."register.php'>Register</a></li>";
								echo "<li><a href='".URL."admin/login.php'>Login</a></li>";								
							break;
					}
				}else{
					// Neu khong co $_SESSION
					echo "<li><a href='".URL."register.php'>Register</a></li>";
					echo "<li><a href='".URL."admin/login.php'>Login</a></li>";
				}
			?>
		</ul>
	</footer>
</body>
</html>