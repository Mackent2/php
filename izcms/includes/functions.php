<?php
	// Tai dinh huong
	define('BASE_URL', 'http://localhost/project/izcms/');
	//Kiem tra ket qua tra ve co dung hay khong
	function confirm_query($result, $query){
		global $conn;
		if(!$result){
			die ("Query {$query} \n<br/> Mysql Error: ".mysqli_error($conn));
		}
	}

	function is_logined_in(){
		if(!isset($_SESSION['user_id'])){
			redirect_to('admin/login.php');
		}
	}

	function  redirect_to($page = 'index.php'){
		$url = BASE_URL . $page;
		header ("location: $url");
		exit();
	}
	
	function the_excerpt($text){
		$sanitized = htmlentities($text, ENT_COMPAT, 'UTF-8');
		if(strlen($sanitized) > 400){
			$cutString = substr($sanitized, 0, 400);
			$words = substr($sanitized, 0, strrpos($cutString, ' '));
			return $words;
		}else{
			return $text;
		}
	}

	function the_content($text){
		$sanitized = htmlentities($text, ENT_COMPAT, 'UTF-8');
		return str_replace(array("\r\n", "\n"), array("<p>","</p>"), $sanitized);
	}

	function is_admin(){
		return isset($_SESSION['user_level']) && filter_var($_SESSION['user_level'], FILTER_VALIDATE_INT, array('min_range' => 1)) && $_SESSION['user_level'] == 2;
	}
	function admin_access(){
		if (!is_admin()) {
			redirect_to();
		}
	}

	function view_id($pg_id){
		$ip = $_SERVER['REMOTE_ADDR'];
		global $conn;
		$q = "SELECT page_id, num_views, user_ip FROM page_views WHERE page_id = {$pg_id} LIMIT 1 ";
		$r = mysqli_query($conn, $q); confirm_query($r, $q);
		list($page_id, $num_views, $user_ip) = mysqli_fetch_array($r, MYSQLI_NUM);
		if (mysqli_num_rows($r) > 0) {
			//kiem tra dia chi ip ng dung co trung k? khong thi update num_views
			if ($page_id == $pg_id && $ip != $user_ip) {
				$q = "UPDATE page_views SET num_views = (num_views+1) WHERE page_id = {$pg_id}";
				$r = mysqli_query($conn, $q); confirm_query($r, $q);
			}
			
		}else{
			$q = "INSERT INTO page_views(page_id, num_views, user_ip) VALUES ({$pg_id}, 1, '{$ip}')";
			$r = mysqli_query($conn, $q); confirm_query($r, $q);
		}
	}

	function fetch_user($user_id){
		global $conn;
		$q = "SELECT * FROM users WHERE user_id = {$user_id}";
		$r = mysqli_query($conn, $q); confirm_query($r, $q);
		if (mysqli_num_rows($r) > 0) {
			return $result_set = mysqli_fetch_array($r, MYSQLI_ASSOC);
		}else{
			return FALSE;
		}
	}

	function here_page($page){
		if (basename($_SERVER['SCRIPT_NAME']) == $page) {
			echo "class = 'here'";
		}
	}
?>