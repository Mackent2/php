<?php include('../includes/header.php');
	include('sidebar-admin.php');?>
<section>
	<form action="" method="POST">
		<fieldset>
			<legend>Form register</legend>
			<label for="fn">First name: <span>*</span></label>
			<div>
				<input type="text" name="fn" id="fn" placehodel = "Nhap first name"/>
			</div>
			<label for="ln">Last name: <span>*</span></label>
			<div>
				<input type="text" name="ln" id="ln" placehodel = "Nhap last name"/>
			</div>
			<label for="e">Email: <span>*</span></label>
			<div>
				<input type="text" name="e" id="e" placehodel = "Nhap email"/>
			</div>
			<label for="fn">First name: <span>*</span></label>
			<div>
				<input type="text" name="fn" id="fn" placehodel = "Nhap first name"/>
			</div>
		</fieldset>

	</form>
</section>
<?php include('../includes/footer.php');?>
