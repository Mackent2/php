	</div>
	<footer>
	<?php
		if (isset($_SESSION['e'])) {
			echo "
				<p><a href='".url."admin/logout.php' style='color:blue;float:right;margin:60px;'>Logout</a></p>
			";
		}
	?>
	</footer>
</body>
</html>