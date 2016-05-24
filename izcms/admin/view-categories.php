	
<?php include ('../includes/header.php');?>
<?php include ('../includes/mysqli_connect.php');?>
<?php include ('../includes/functions.php');?>
<?php include ('../includes/sidebar-admin.php');?>
<?php admin_access();	 ?>
<section>
	<h3>Manage Categories </h3>
	<table border="1">
		<tr>
			<th><a href='view-categories.php?sort=cat'>Categories</a></th>
			<th><a href='view-categories.php?sort=pos'>Position</a></th>
			<th><a href='view-categories.php?sort=by'>Posted ID</a></th>
			<th>Edit</th>
			<th>Delete</th>
		</tr>
		<?php
			if(isset($_GET['sort'])){
				switch($_GET['sort']){
					case 'cat':
						$order_by = 'cat_name';
						break;
					case 'pos':
						$order_by = 'position';
						break;
					case 'by':
						$order_by = 'name';
						break;
					default :
					$order_by = 'position';
					break;
				}
			}else{
				$order_by = 'position';
			}
		?>
		<?php
			$q3 = "SELECT cat_id, cat_name, position, CONCAT_WS(' ',first_name, last_name) as name, user_id FROM categories inner join users using(user_id) ORDER BY {$order_by} ASC";
			$r3 = mysqli_query($conn, $q3);
			confirm_query($r3, $q3);
			while ($view_cat = mysqli_fetch_array($r3, MYSQLI_ASSOC)) {
				echo"<tr>";
				echo "<td>".$view_cat['cat_name']."</td>";
				echo "<td>".$view_cat['position']."</td>";
				echo "<td>".$view_cat['name']."</td>";
				echo "<td><a href='edit-categories.php?edit={$view_cat['cat_id']}'>Edit</a></td>";
				echo "<td><a href='del-categories.php?del={$view_cat['cat_id']}&cat_name={$view_cat['cat_name']}'>Del</a></td>";
				echo "</tr>";
			}
		?>
	</table>
</section>
<?php include ('../includes/sidebar-b.php');?>
<?php include ('../includes/footer.php');?>

