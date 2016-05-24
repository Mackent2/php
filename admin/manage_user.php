<?php 
	include('header-admin.php');
	include('../includes/mysql_connect.php');
	include('sidebar-admin.php');
?>
<div class="container">
	<div class ='table'>
		<table border = '2px'>
			<tr>
				<th><a href="manage_user.php?sort=stt">STT</a></th>
				<th><a href="manage_user.php?sort=name">Họ và tên</a></th>
				<th><a href="manage_user.php?sort=email">Email</a></th>
				<th><a href="manage_user.php?sort=address">Địa chỉ</a></th>
				<th><a href="manage_user.php?sort=fone">Phone number</a></th>
				<th><a href="manage_user.php?sort=level">Level</a></th>
				<th>Edit user</th>
				<th>DELETE</th>
			</tr>
			<?php 
				if(isset($_GET['sort'])){
					switch($_GET['sort']) {
						case 'stt':
							$sort = 'user_id';
							break;
						case 'name':
							$sort = 'name';
							break;
						case 'email':
							$sort = 'email';
							break;
						case 'address':
							$sort = 'diachi';
							break;
						case 'fone':
							$sort = 'fone';
							break;
						case 'level':
							$sort= 'level';
							break;
						default:
							$sort = 'user_id';
							break;
					}
				}else{
					$sort = 'user_id';
				}
				if (isset($_SESSION['uid'])) {
					$q = "SELECT user_id, concat_ws(' ', first_name, last_name) as name, email, diachi, fone, level FROM users ORDER BY {$sort} ASC";
					$r = mysqli_query($conn, $q) or die ("Query: {$q} \n<br/> MSQLI :".mysqli_error($conn));
					if (mysqli_num_rows($r) > 0) {
						while(list($uid, $name, $e, $diachi, $fone, $level) = mysqli_fetch_array($r, MYSQLI_NUM)){
							echo "
								<tr>
									<td>{$uid}</td>
									<td>{$name}</td>
									<td>{$e}</td>
									<td>{$diachi}</td>
									<td>0{$fone}</td>
									<td>{$level}</td>
									<td><a href='edit_user.php?uid={$uid}&level={$level}'>Edit</a></td>
									<td><a href='del_user.php?uid={$uid}&e={$e}'>Del</a></td>
								</tr>
							";
						}
					}
				}else{
					header("location:".url."index.php");
				}
			?>
		</table>
	</div>
</div>
<?php include('../includes/footer.php');?>
