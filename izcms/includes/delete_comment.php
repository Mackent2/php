<?php include ('mysqli_connect.php');?>
<?php include ('functions.php');?>
<?php
	if (isset($_POST['cmt_id']) && FILTER_VAR($_POST['cmt_id'], FILTER_VALIDATE_INT)) {
		$cid = $_POST['cmt_id'];
		$q = "DELETE FROM comments WHERE comment_id = $cid LIMIT 1";
		$r = mysqli_query($conn, $q); confirm_query($r, $q);
	}
?>