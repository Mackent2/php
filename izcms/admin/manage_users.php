<?php include ('../includes/header.php');?>
<?php include ('../includes/mysqli_connect.php');?>
<?php include ('../includes/functions.php');?>
<?php include ('../includes/sidebar-admin.php');?>
<?php admin_access();	 
	is_admin();?>
<section>
	<h3>Manage Categories </h3>
	<table border="1">
		<tr>
			<th><a href='manage_users.php?sort=fn'>First name</a></th>
			<th><a href='manage_users.php?sort=ln'>Last name</a></th>
			<th><a href='manage_users.php?sort=e'>Email</a></th>
			<th><a href='manage_users.php?sort=level'>User level</a></th>
			<th>Edit</th>
			<th>Delete</th>
		</tr>
		<?php
			if(isset($_GET['sort'])){
				switch($_GET['sort']){
					case 'fn':
						$order_by = 'first_name';
						break;
					case 'ln':
						$order_by = 'last_name';
						break;
					case 'e':
						$order_by = 'email';
						break;
					case 'level':
						$order_by = 'user_level';
						break;
					default :
					$order_by = 'email';
					break;
				}
			}else{
				$order_by = 'email';
			}
		?>
		<?php
			$q3 = "SELECT user_id, first_name, last_name, email, user_level FROM users ORDER BY {$order_by} ASC";
			$r3 = mysqli_query($conn, $q3);
			confirm_query($r3, $q3);
			while ($view_uid = mysqli_fetch_array($r3, MYSQLI_ASSOC)) {
				echo"<tr>";
				echo "<td>".$view_uid['first_name']."</td>";
				echo "<td>".$view_uid['last_name']."</td>";
				echo "<td>".$view_uid['email']."</td>";
				echo "<td>".$view_uid['user_level']."</td>";
				echo "<td><a href='edit-user.php?edit={$view_uid['user_id']}'>Edit</a></td>";
				echo "<td><a href='del-user.php?del={$view_uid['user_id']}&e={$view_uid['email']}'>Del</a></td>";
				echo "</tr>";
			}
		?>
	</table>
</section>
<?php include ('../includes/sidebar-b.php');?>
<?php include ('../includes/footer.php');?>

