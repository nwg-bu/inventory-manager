<?php
include('db.php');
include('menu.php');
?>

<!DOCTYPE html>
<html>
	<head>
		<link type="text/css" rel="stylesheet" href="stylesheet.css"/>
		<title> Inventory Manager </title>
	</head>
	<body>
		<h2> Update Database </h2>
		
		<div class="mid" id="update">
            <p id="update_p"> Convert file to <span id="u">tab-delimited</span> text file before uploading! </p> <br>
			<form action="complete.php#complete" method="post" enctype="multipart/form-data">
				<input type="file" name="newFile"><br>
				<br>
				<div id="bottom"> <input type="submit" value="Update" name="submit"> </div>
			</form>
		</div>
	</body>
</html>