<?php include('themes/templates/firm_admin.php'); ?>



<section class="data">
	<h4>Basic User Information</h4>
	<form id="form">
		<p>First Name</p>
		<input type="text" name="First Name" class="textbox" >
	</form>

	<form id="form">
		<p>Middle Name</p>
		<input type="text" name="Middle Name" class="textbox">
	</form>

	<form id="form">
		<p>Last Name</p>
		<input type="text" name="Last Name" class="textbox">
	</form>

	<form id="form">
		<p>Name of Firm</p>
		<input type="text" name="Name of Firm" class="textbox02"><button onClick="window.location.href='user-info.html';">+Add Firm</button>
	</form>

	<form id="form_address">
		<p>Current Address</p>
		<input type="text" name="Address" class="textbox">
		<br>
		<input type="text" name="Address" class="textbox02">
		<ul>
			<li><input type="text" name="Address" class="textbox03" value="Zip"></li>
			<li><input type="text" name="Address" class="textbox03" value="City"></li>
			<li>
				<select name="state" class="select">
					<option value="Option 1">State</option>
					<option value="Option 2">Option 1</option>
					<option value="Option 3">Option 2</option>
					<option value="Option 4">Option 3</option>
				</select>
			</li>
		</ul>
	</form>

	<form id="form_contact">
		<p>Contact Information</p>
		<ul>
			<li>
				<select name="number" class="select">
					<option value="Option 1">Mobile</option>
					<option value="Option 2">Work</option>
					<option value="Option 3">Home</option>
					<option value="Option 4">Fax</option>
				</select>
			</li>
			<li><input type="text" name="contact" class="textbox02"></li>
			<li><button>+Add Number</button></li>
		</ul>
	</form>

	<form id="form">
		<p>Email Address</p>
		<input type="text" name="" class="textbox">
	</form>

	<div class="line"></div>

	<h4>Account Information</h4>
	<form id="form">
		<p>Username</p>
		<input type="text" name="First Name" class="textbox" >
	</form>

	<form id="form">
		<p>Account Type</p>
		<select name="Party type" class="select" >
			<option value="Option 1">Choose Account Type</option>
			<option value="Option 2">Tech Administrator</option>
			<option value="Option 3">Firm Administrator</option>
			<option value="Option 4">Tech Staff</option>
		</select>
	</form>

	<form id="form">
		<p>New Password</p>
		<input type="password" name="" class="textbox">
	</form>

	<form id="form">
		<p>Confirm Password</p>
		<input type="password" name="" class="textbox">
	</form>

	<form id="form">
		<p>Account Status</p>
		<ul class="radio">
			<li><input type="radio" name="" value="">Active</li>
			<li><input type="radio" name="" value="">Inactive</li>
			<li style="margin: 0 0 0 20px;"><input type="checkbox" name="">Email Account Details</li>
		</ul>
	</form>
	</section>
	<br>
	<button id="big_save" onClick="">
	<ul>
		<li><img src="images/icon-save-white.png" width="17px" height="17px"></li>
		<li>Save User</li>
	</ul>
	</button>
</section>























<?php include('themes/templates/footer/firm_admin.php'); ?>
