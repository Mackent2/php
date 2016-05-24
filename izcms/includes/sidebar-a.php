<div id="container">
	<aside class="sidebar-a">
		<ul>
			<?php
				if (isset($_GET['cid']) && filter_var($_GET['cid'], FILTER_VALIDATE_INT, array('min_range' =>1))) {
					$cid= $_GET['cid'];
					$pid = NULL;
				}elseif(isset($_GET['pid']) && filter_var($_GET['pid'], FILTER_VALIDATE_INT, array('min_range' =>1))){
					$pid= $_GET['pid'];
					$cid = NULL;
				}
				else{
					$cid = NULL;
					$pid = NULL;
				}
				$q = "select cat_name, cat_id from categories ORDER BY position ASC";
				$r = mysqli_query($conn, $q);
					confirm_query($r, $q);
				while ($cat = mysqli_fetch_array($r, MYSQLI_ASSOC)){
					echo "<li><a href='".URL."index.php?cid={$cat['cat_id']}'";
						if ($cat['cat_id'] == $cid) {
							echo "class= selected";
						}
					echo ">".$cat['cat_name']."</a>";
					// cau lenh truy xuat pages
						$q1 = "SELECT page_name, page_id, content FROM pages WHERE cat_id = {$cat['cat_id']} ORDER BY position ASC";
						$r1 = mysqli_query($conn, $q1);
						confirm_query($r1, $q1);
						echo "<ul>";
						//lay pages tu csdl
						while($pages = mysqli_fetch_array($r1, MYSQLI_ASSOC)){
							echo "<li><a href ='".URL."index.php?pid={$pages['page_id']}'";
								if ($pages['page_id'] == $pid) {
									echo "class = 'selected'";
								}
							echo ">".$pages['page_name']."</a></li>";
						}
						echo "</ul>";
					echo "</li>";
				}
			?>
		</ul>
	</aside>