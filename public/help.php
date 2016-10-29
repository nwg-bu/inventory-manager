<?php
include('db.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<link type="text/css" rel="stylesheet" media="all" href="stylesheet.css"/>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
        <script type="text/javascript" src="src/main.js"></script>
        
        
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/u/dt/jq-2.2.3,pdfmake-0.1.18,dt-1.10.12,af-2.1.2,b-1.2.0,b-colvis-1.2.0,b-flash-1.2.0,b-html5-1.2.0,b-print-1.2.0,cr-1.3.2,fc-3.2.2,fh-3.1.2,kt-2.1.2,r-2.1.0,rr-1.1.2,sc-1.4.2,se-1.2.0/datatables.min.css"/>
        <script type="text/javascript" src="https://cdn.datatables.net/u/dt/jq-2.2.3,pdfmake-0.1.18,dt-1.10.12,af-2.1.2,b-1.2.0,b-colvis-1.2.0,b-flash-1.2.0,b-html5-1.2.0,b-print-1.2.0,cr-1.3.2,fc-3.2.2,fh-3.1.2,kt-2.1.2,r-2.1.0,rr-1.1.2,sc-1.4.2,se-1.2.0/datatables.min.js"></script>
		
		<link href="img/favicon.ico" rel="icon" type="image/x-icon"/>
		<title> Inventory Manager </title>
	</head>
	<body>
		
		<h2> Database Relations </h2>
		<div id="center">
			<div class="mid" id="results">
				<table id="help" border="1">
					<caption>Q_Master</caption>
					<thead>
						<tr><th>Field</th><th>Description</th></tr>
					</thead>
					<tbody>
						<tr class='clickable'><td>BIOS_SERIAL_NUMBER</td><td>Serial number on file from KACE report</td></tr>
						<tr class='clickable'><td>USER</td><td>Username on file from KACE report</td></tr>
						<tr class='clickable'><td>NAME</td><td>Name of the item on file from KACE report (same as ID)</td></tr>
						<tr class='clickable'><td>OS_NAME</td><td>Name of the operating system in use on the computer, on file from KACE report</td></tr>
						<tr class='clickable'><td>ASSET_NOTES</td><td>Notes on this item from IT on file from KACE report</td></tr>
						<tr class='clickable'><td>LAST_INVENTORY</td><td>Most recent date on which IT has taken an inventory of the item</td></tr>
						<tr class='clickable'><td>CS_MANUFACTURER</td><td>Name of the manufacturer of the item, on file from KACE report</td></tr>
						<tr class='clickable'><td>CS_MODEL</td><td>Model name of the item on file from KACE report</td></tr>
						<tr class='clickable'><td>LAST_USER</td><td>Most recent user logged into the computer at the time of the KACE report</td></tr>
						<tr class='clickable'><td>WARRANTY_START</td><td>Start date of the warranty, on file from KACE report</td></tr>
						<tr class='clickable'><td>WARRANTY_END</td><td>Expiration date of the item's warranty, on file from KACE report</td></tr>
						<tr class='clickable'><td>ASSIGNED_TO</td><td>Username permanently assigned to the item, on file from KACE report</td></tr>
						<tr class='clickable'><td>FUNCTION</td><td>The role of the item (loaner, reserve, lab, single-user), on file from KACE report</td></tr>
						<tr class='clickable'><td>FLOOR</td><td>Floor number in which the item resides, on file from KACE report</td></tr>
						<tr class='clickable'><td>ROOM</td><td>Room number in which the item resides, on file from KACE report</td></tr>
						<tr class='clickable'><td>ID</td><td>Name of the item on file</td></tr>
						<tr class='clickable'><td>Make</td><td>Name of the manufacturer of the item on file</td></tr>
						<tr class='clickable'><td>Model</td><td>Name of the model of the item on file</td></tr>
						<tr class='clickable'><td>Product Number</td><td>Numerical product code, identifying the name of the model of the item</td></tr>
						<tr class='clickable'><td>Format</td><td>Style of workstation (desktop, laptop, tablet) of the item on file</td></tr>
						<tr class='clickable'><td>Serial Number</td><td>Serial number of the item on file</td></tr>
						<tr class='clickable'><td>Location</td><td>Room number in which the item on file can be found</td></tr>
						<tr class='clickable'><td>Department</td><td>Department name to which the item belongs</td></tr>
						<tr class='clickable'><td>Usage Type</td><td>The role of the item (loaner, reserve, lab, single-user)</td></tr>
						<tr class='clickable'><td>UserFirst</td><td>First name of the user assigned to the item on file</td></tr>
						<tr class='clickable'><td>UserLast</td><td>Last name of the user assigned to the item on file</td></tr>
						<tr class='clickable'><td>Faculty Staff</td><td>States whether the assigned user is faculty or staff</td></tr>
						<tr class='clickable'><td>Requisition Number</td><td>Requisition number associated with the purchase of the item</td></tr>
						<tr class='clickable'><td>Account Number 1</td><td>Account number associated with the purchase of the item</td></tr>
						<tr class='clickable'><td>Account Number 2</td><td>Account number associated with the purchase of the item</td></tr>
						<tr class='clickable'><td>System Date</td><td>Date the item on file was purchased</td></tr>
						<tr class='clickable'><td>Install Date</td><td>Date the item on file was received and input into the database</td></tr>
						<tr class='clickable'><td>Warranty Exp Date</td><td>Expiration date of the item's warranty</td></tr>
						<tr class='clickable'><td>Computer Notes</td><td>Notes about the item</td></tr>
					</tbody>
				</table>
				<br><br>
				<table id="help" border="1">
					<caption>fac_staff</caption>
					<thead>
						<tr><th>Field</th><th>Description</th></tr>
					</thead>
					<tbody>
						<tr class='clickable'><td>buroom</td><td>Romm the faculty/staff member is assigned to</td></tr>
						<tr class='clickable'><td>lastName</td><td>Last name of the faculty/staff member</td></tr>
						<tr class='clickable'><td>firstName</td><td>First name of the faculty/staff member</td></tr>
						<tr class='clickable'><td>buid</td><td>BU ID of the faculty/staff member</td></tr>
						<tr class='clickable'><td>buemail</td><td>BU email address of the faculty/staff member</td></tr>
						<tr class='clickable'><td>buphone</td><td>Phone number of the faculty/staff member</td></tr>
						<tr class='clickable'><td>deptLong</td><td>Department to which the faculty/staff member belongs</td></tr>
						<tr class='clickable'><td>title</td><td>Title of the faculty/staff member</td></tr>
					</tbody>
				</table>
				<br><br>
				<table id="help" border="1">
					<caption>costCenter</caption>
					<thead>
						<tr><th>Field</th><th>Description</th></tr>
					</thead>
					<tbody>
						<tr class='clickable'><td>Cost Center</td><td>Account number of the department</td></tr>
						<tr class='clickable'><td>Department</td><td>Name of the Department</td></tr>
					</tbody>
				</table>
				<br><br>
				<table id="help" border="1">
					<caption>history</caption>
					<thead>
						<tr><th>Field</th><th>Description</th></tr>
					</thead>
					<tbody>
						<tr class='clickable'><td>Serial</td><td>Serial number of the item</td></tr>
						<tr class='clickable'><td>Prev_User</td><td>Previous user of the item on file</td></tr>
						<tr class='clickable'><td>New_User</td><td>New user of the item on file</td></tr>
						<tr class='clickable'><td>Date_Assigned</td><td>Date on which the KACE file was updated and the change was logged into the database</td></tr>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>