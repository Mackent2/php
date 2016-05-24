	
<?php include ('../includes/header.php');?>
<?php include ('../includes/mysqli_connect.php');?>
<?php include ('../includes/functions.php');?>
<?php include ('../includes/sidebar-admin.php');?>
<?php admin_access();	 ?>
<section>
	<h3>Manage Pages </h3>
	<table border="1">
		<tr>
			<th><a href='view-pages.php?sort=pag'>Pages</a></th>
			<th><a href='view-pages.php?sort=post'>Posted On</a></th>
			<th><a href='view-pages.php?sort=by'>Posted By</a></th>
			<th><a href='view-pages.php?sort=pos'>Position</a></th>
			<th>Content</th>
			<th>Edit</th>
			<th>Delete</th>
		</tr>
		<?php
			if(isset($_GET['sort'])){
				switch($_GET['sort']){
					case 'pag':
						$order_by = 'page_name';
						break;
					case 'post':
						$order_by = 'position';
						break;
					case 'pos':
						$order_by = 'ngay';
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
			$q3 = "SELECT page_id,cat_id, page_name, DATE_FORMAT(post_on, '%b %d %Y') as ngay, CONCAT_WS(' ',first_name, last_name) as name, content, position FROM Pages inner join users using(user_id) ORDER BY {$order_by} ASC";
			$r3 = mysqli_query($conn, $q3);
			confirm_query($r3, $q3);
			while ($view_page = mysqli_fetch_array($r3, MYSQLI_ASSOC)) {
				echo"<tr>";
				echo "<td>".$view_page['page_name']."</td>";				
				echo "<td>".$view_page['ngay']."</td>";
				echo "<td>".$view_page['name']."</td>";
				echo "<td>".$view_page['position']."</td>";
				echo "<td>".the_excerpt($view_page['content'])."...</td>";
				echo "<td><a href='edit-pages.php?pid={$view_page['page_id']}'>Edit</a></td>";
				echo "<td><a href='del-pages.php?pid={$view_page['page_id']}&page_name={$view_page['page_name']}'>Del</a></td>";
				echo "</tr>";
			}
		?>
	</table>
</section>
<?php include ('../includes/sidebar-b.php');?>
<?php include ('../includes/footer.php');?>

