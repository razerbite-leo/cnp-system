<?php include('themes/templates/firm_admin.php'); ?>

<ul id="filter-search">
	<li>Filter Search by:</li>
	<li>
		<select name="filter" class="select">
			<option value="option 1">User Name</option>
			<option value="option 2">Name</option>
			<option value="option 3">Firm</option>
			<option value="option 4">Account Type</option>							
			<option value="option 5">Status</option>
		</select>
	</li>
</ul>
<ul id="text-search">
	<li><input type="text" name="Name" class="textbox" value="Search"><button>Search</button></li>
</ul>
<table>
	<th valign= "none">User Name</th>
	<th>Last Name,<br>First Name</th>
	<th>Email Address</th>
	<th>Firm</th>
	<th>Account Type</th>
	<th>Status</th>
		
	<tr>
		<td>oaknorton</td>
		<td>Norton, Oak</td>
		<td>oak@oaknorton.com</td>
		<td>Living Tree Software</td>
		<td>Super Administrator</td>
		<td>Active</td>
	</tr>
	<tr>
		<td>pattonlucas</td>
		<td>Lucas, Patton</td>
		<td>patton@razerbite.com</td>
		<td>Razerbite Solutions</td>
		<td>Tech Administrator</td>
		<td>Active</td>
	</tr>
	<tr>
		<td>John316</td>
		<td>Stark, Jonathan</td>
		<td>stark_316@yahoo.com</td>
		<td>Westeros Imports</td>
		<td>Firm Administrator</td>
		<td>Active</td>
	</tr>
	<tr>
		<td>KhaleeseeFan904</td>
		<td>Ramsey, Danni</td>
		<td>D.Ramsey84@gmail.com</td>
		<td>Twins Staffing Services</td>
		<td>Firm Administrator</td>
		<td>Active</td>
	</tr>
	<tr>
		<td>blindmansees446</td>
		<td>Murdoch, Mathew</td>
		<td>Murdoch_M@aol.com</td>
		<td>Nelson and Murdoch Law Offices</td>
		<td>Tech Administrator</td>
		<td>Inactive</td>
	</tr>
	<tr>
		<td>SandSurfer</td>
		<td>Atreides, Paul Leto</td>
		<td>PLAtreides316@yahoo.com</td>
		<td>Atreides & Sons Imports, Ltd</td>
		<td>Firm Administrator</td>
		<td>Active</td>
	</tr>
	<tr>
		<td>NolanGreer</td>
		<td>Greer, Nolan</td>
		<td>ng1965@decimasoftware.com</td>
		<td>Decima Software</td>
		<td>Tech Administrator</td>
		<td>Inactive</td>
	</tr>
	<tr>
		<td>root_</td>
		<td>Grooves, Samantha</td>
		<td>s.grooves@themachinewatchesus.com</td>
		<td>Northern Lights Research, inc</td>
		<td>Super Administrator</td>
		<td>Active</td>
	</tr>
	<tr>
		<td>2piR</td>
		<td>Finch, Harold Wren</td>
		<td>finch_harold@ift-global.net</td>
		<td>IFT Global</td>
		<td>Super Administrator</td>
		<td>Active</td>
	</tr>
	<tr>
		<td>green_arrow85</td>
		<td>Queen, Oliver</td>
		<td>o-queen1985@gmail.com</td>
		<td>Queen Consolidated</td>
		<td>Firm Administrator</td>
		<td>Inactive</td>
	</tr>
</table>
	
<ul id="pagination">
	<li> << Prev </li>
	<li class="active">1</li>
	<li>2</li>
	<li>3</li>
	<li>4</li>
	<li>5</li>
	<li>6</li>
	<li> Next >> </li>
</ul>



















































<?php include('themes/templates/footer/firm_admin.php'); ?>
