	
<?php include ('includes/header.php');?>
<?php include ('includes/mysqli_connect.php');?>
<?php include ('includes/functions.php');?>
<?php include ('includes/sidebar-a.php');?>
<section>
	<h3>Welcome to IzCMS</h3>
	<!-- Tao page cho post by author -->
<!-- 	<?php
		$display = 4;
		if(isset($_GET['s']) && filter_var($_GET['s'], FILTER_VALIDATE_INT, array('min_range' => 1))){
			$start = $_GET['s'];
		}else{
			$start = 0;
		}
		if(isset($_GET['p']) && filter_var($_GET['s'], FILTER_VALIDATE_INT, array('min_range' => 1))){
			$page = $_GET['p'];
		}else{
			$q5 = "SELECT count(page_id) as count FROM pages";
			$r5 = mysqli_query($conn, $q5);
			confirm_query($r5, $q5);
			list($record) = mysqli_fetch_array($r5, MYSQLI_NUM);
			//Tim so trang bang cach chia $display
			if($record > $display){
				$page = ceil($record/$display);
			}else{
				$page = 1;
			}
		}
		echo "<ul>";
			if ($page > 1) {
				$current_page = ($start/$display) +1;
				//Neu khong pai o trang dau thi hien thi trang truoc
				if ($current_page !=1) {
					echo "<li><a href='index.php?post=1&s=".($start - $display)."&p={$page}'>Previous</a></li>";
				}
				// Hiển thị những phần số còn lại của trang
				for ($i=1; $i <= $page ; $i++) { 
					if ($i != $current_page) {
						echo "<li><a href='index.php?post=1&s=".($display * ($i - 1))."&p={$page}'>{$i}</a></li>";			
					}else{
						echo "<li>{$i}</li>";
					}
				}// End for lood
				if ($current_page != $page) {
					echo "<li><a href='index.php?post=1&s=".($start + $display)."&p={$page}'>Next</a></li>";
				}
			}
		echo "</ul>";
	?> -->
	<?php
	//  Phân trang cho post by
		$display = 4;
		if(isset($_GET['s']) && filter_var($_GET['s'], FILTER_VALIDATE_INT, array('min_range' => 1))){
			$start = $_GET['s'];
		}else{
			$start = 0;
		}
		if(isset($_GET['p']) && filter_var($_GET['s'], FILTER_VALIDATE_INT, array('min_range' => 1))){
			$page = $_GET['p'];
		}else{
			$q5 = "SELECT count(page_id) as count FROM pages";
			$r5 = mysqli_query($conn, $q5);
			confirm_query($r5, $q5);
			list($record) = mysqli_fetch_array($r5, MYSQLI_NUM);
			//Tim so trang bang cach chia $display
			if($record > $display){
				$page = ceil($record/$display);
			}else{
				$page = 1;
			}
		}
	// Kết thúc phân trang
	if (isset($_GET['post']) && filter_var($_GET['post'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
		$post_by = $_GET['post'];
		$q3 = "SELECT cat_id, user_id, page_name, page_id, content, post_on, concat_ws(' ', u.first_name, u.last_name) AS name FROM pages inner join users AS u using(user_id) ORDER BY page_id DESC LIMIT $start, $display";
		$r3 = mysqli_query($conn, $q3);
		confirm_query($r3, $q3);
		if (mysqli_num_rows($r3) > 0) { // Kiem tra co ton tai row > 0 
			while($pby = mysqli_fetch_array($r3, MYSQLI_ASSOC)){ // tao mang
				if (isset($post_by) && ($post_by == $pby['user_id'])) { // so sanh xem thong so GET vao co trung khong
					echo "<h3>".$pby['page_name']."</h3>";
					echo "<code>".$pby['post_on']."</code>";
					echo "<p class='text-over'>".the_excerpt($pby['content'])."... </p>";//Ham tim gioi han ky tu ra page
					echo "<p><a href='".URL."index.php?pid={$pby['page_id']}'>Xem tiếp ..</a></p>";
					// echo "<p><a href='index.php?pid={$pby['page_id']}'>".."coment</a></p>";
					echo "<p>Posted By:<a href='".URL."index.php?pid={$pby['page_id']}'>".$pby['name']."</a></p>";
					echo "<hr/>";
				}
			}
		}
	// Hiển thị kết quả phân trang
		echo "<ul class='phantrang'>";
			if ($page > 1) {
				$current_page = ($start/$display) +1;
				//Neu khong pai o trang dau thi hien thi trang truoc
				if ($current_page !=1) {
					echo "<li><a href='".URL."index.php?post={$post_by}&s=".($start - $display)."&p={$page}'>Previous</a></li>";
				}
				// Hiển thị những phần số còn lại của trang
				for ($i=1; $i <= $page ; $i++){ 
					if ($i != $current_page) {
						echo "<li><a href='".URL."index.php?post={$post_by}&s=".($display * ($i - 1))."&p={$page}'>{$i}</a></li>";	
					}else{
						echo "<li>{$i}</li>";
					}
				}// End for lood
				if ($current_page != $page) {
					echo "<li><a href='".URL."index.php?post={$post_by}&s=".($start + $display)."&p={$page}'>Next</a></li>";
				}
			}
		echo "</ul>";
	}
	?>
	<!-- end page cho post by author-->
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
		$q .= " FROM users as u inner join pages as p inner join categories as c USING(cat_id) where u.user_id = p.user_id ORDER BY page_name DESC";
		$r = mysqli_query($conn, $q);
		confirm_query($r, $q);
		if(mysqli_num_rows($r) > 0){
			while($cat = mysqli_fetch_array($r)){
				if(isset($cid) && $cid == $cat['cat_id']) {
					echo "<h3><a href='".URL."index.php?pid={$cat['page_id']}'>".$cat['page_name']."</a></h3>";
					echo "<code>On: ".$cat['ngay']."</code>";
					echo "<p class='text-over'>".the_excerpt($cat['content'])."...</p>";//Ham tim gioi han ky tu ra page
					echo "<p><a href='".URL."index.php?pid={$cat['page_id']}'>Xem tiếp ..</a></p>";
					echo "<p>Posted By:<a href='".URL."index.php?post={$cat['user_id']}'>".$cat['name']."</a></p>";
					echo "<hr/>";
				}
			}
		}
	?>
		<!-- End page cho categories -->
		<!-- Tao page cho pages -->
	<p>
		<?php
			if(isset($_GET['pid']) && filter_var($_GET['pid'], FILTER_VALIDATE_INT, array('min_array' => 1))){
			$pid = $_GET['pid'];
			view_id($pid);
			$q2= "SELECT count(com.comment) as count, p.user_id, concat_ws(' ', u.first_name, u.last_name) AS name,p.page_id, p.page_name, p.content,DATE_FORMAT(p.post_on, '%b %d %Y') AS ngay FROM pages as p INNER JOIN users as u USING(user_id) inner join comments as com where com.page_id = $pid && p.page_id = $pid ORDER BY position ASC ";
			$r2 = mysqli_query($conn, $q2);
			confirm_query($q2, $r2);
			while($page = mysqli_fetch_array($r2, MYSQLI_ASSOC)){
				if ($page['page_id'] == $pid) {
					echo "<h3>".$page['page_name']."</h3>";
					echo "<code>On: ".$page['ngay']."</code>";
					echo "<p>".$page['content']."</p>";
					echo "<p>Posted By:<a href='".URL."index.php?post={$page['user_id']}'>".$page['name']."</a></p>";
					if($page['count'] == 0){
						echo "<p><a href='".URL."single.php?pid={$page['page_id']}'>Hãy là người đầu tiên</a> COMMENT</p>";
					}else{
					echo "<p><a href='".URL."single.php?pid={$page['page_id']}'>".$page['count']." COMMENT</a></p>";}
					$q = "SELECT num_views FROM page_views WHERE page_id = {$pid}";
					$r = mysqli_query($conn, $q); confirm_query($r, $q);
					if (mysqli_num_rows($r) == 1) {
						list($num_view) = mysqli_fetch_array($r, MYSQLI_NUM);
						echo "<p>Luot truy cap: ".$num_view."</p>";
					}

				}
			}
		}
		?>
	</p>
		<!-- end page cho pages -->
</section>
<?php include ('includes/sidebar-b.php');?>
<?php include ('includes/footer.php');?>

