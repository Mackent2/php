	
<?php include ('includes/header.php');?>
<?php include ('includes/mysqli_connect.php');?>
<?php include ('includes/functions.php');?>
<?php include ('includes/sidebar-a.php');?>
<section>
	<h3>Welcome to IzCMS</h3>
	<!-- Tao page cho post by -->
	<?php
	if (isset($_GET['post']) && filter_var($_GET['post'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
		$post_by = $_GET['post'];
		$q3 = "SELECT cat_id, user_id, page_name, page_id, content, post_on, concat_ws(' ', u.first_name, u.last_name) AS name FROM pages inner join users AS u using(user_id)";
		$r3 = mysqli_query($conn, $q3);
		confirm_query($r3, $q3);
		if (mysqli_num_rows($r3) > 0) { // Kiem tra co ton tai row > 0 
			while($pby = mysqli_fetch_array($r3, MYSQLI_ASSOC)){ // tao mang
				if (isset($post_by) && ($post_by == $pby['user_id'])) { // so sanh xem thong so GET vao co trung khong
					echo "<h3>".$pby['page_name']."</h3>";
					echo "<code>".$pby['post_on']."</code>";
					echo "<p class='text-over'>".the_excerpt($pby['content'])."... </p>";//Ham tim gioi han ky tu ra page
					echo "<p><a href='index.php?pid={$pby['page_id']}'>Xem tiếp ..</a></p>";
					// echo "<p><a href='index.php?pid={$pby['page_id']}'>".."coment</a></p>";
					echo "<p>Posted By:<a href='index.php?pid={$pby['page_id']}'>".$pby['name']."</a></p>";
					echo "<hr/>";
				}
			}
		}
		
	}
	?>
	<!-- end page cho post by -->
	<!-- Tao page cho categories -->
	<?php
		$q = "SELECT u.user_id, ";
		$q .= " concat_ws(' ', u.first_name, u.last_name) AS name, ";
		$q .= " c.cat_id, ";
		$q .= " c.cat_name, ";
		$q .= "p.page_id, ";
		$q .= " p.page_name, ";
		$q .= " content, ";
		$q .= " DATE_FORMAT(p.post_on, '%b %d %Y') AS ngay ";
		$q .= " FROM users as u inner join pages as p inner join categories as c USING(cat_id) ORDER BY page_name DESC";
		$r = mysqli_query($conn, $q);
		confirm_query($r, $q);
		if(mysqli_num_rows($r) > 0){
			while($cat = mysqli_fetch_array($r)){
				if(isset($cid) && $cid == $cat['cat_id']) {
					echo "<h3><a href='index.php?pid={$cat['page_id']}'>".$cat['page_name']."</a></h3>";
					echo "<code>On: ".$cat['ngay']."</code>";
					echo "<p class='text-over'>".the_excerpt($cat['content'])."...</p>";//Ham tim gioi han ky tu ra page
					echo "<p><a href='index.php?pid={$cat['page_id']}'>Xem tiếp ..</a></p>";
					echo "<p>Posted By:<a href='index.php?post={$cat['user_id']}'>".$cat['name']."</a></p>";
					echo "<hr/>";
				}
			}
		}
	?>
		<!-- End page cho categories -->
		<!-- Tao page cho pages -->
	<p>
		<?php
			$q2= "SELECT count(com.comment) as count, p.user_id, concat_ws(' ', u.first_name, u.last_name) AS name,p.page_id, p.page_name, p.content,DATE_FORMAT(p.post_on, '%b %d %Y') AS ngay FROM pages as p INNER JOIN users as u USING(user_id) inner join comments as com where com.page_id = $pid && p.page_id = $pid ORDER BY position ASC ";
			$r2 = mysqli_query($conn, $q2);
			confirm_query($q2, $r2);
			while($page = mysqli_fetch_array($r2, MYSQLI_ASSOC)){
				if ($page['page_id'] == $pid) {
					echo "<h3>".$page['page_name']."</h3>";
					echo "<code>On: ".$page['ngay']."</code>";
					echo "<p>".$page['content']."</p>";
					echo "<p>Posted By:<a href='index.php?post={$page['user_id']}'>".$page['name']."</a></p>";
					if($page['count'] == 0){
						echo "<p><a href='single.php?pid={$page['page_id']}'>Hãy là người đầu tiên</a> COMMENT</p>";
					}else{
					echo "<p><a href='single.php?pid={$page['page_id']}'>".$page['count']." COMMENT</a></p>";}
					include ('includes/comment_form.php');

				}
			}
		?>
	</p>
		<!-- end page cho pages -->
</section>
<?php include ('includes/sidebar-b.php');?>
<?php include ('includes/footer.php');?>

