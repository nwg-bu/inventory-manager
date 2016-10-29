<?php
include('db.php');

?>

<!DOCTYPE html>
<html>
	<head>
		<link type="text/css" rel="stylesheet" href="stylesheet.css"/>
		<link href="img/favicon.ico" rel="icon" type="image/x-icon"/>
		<title> Inventory Manager </title>
	</head>
	<body>
        <div id="header">
            <a href="index.php"><div><input type='button' class='button' id="ldiv" value='Search' onclick='#'/></div></a>
			<a href="user.php"><div><input type='button' class='button' value='Directory' onclick='#'/></div></a>
            <a href="new.php"><div><input type='button' class='button' value='New Inventory' onclick='#'/></div></a>
            <a href="update.php"><div><input type='button' class='button' id="rdiv" value='Update KACE' onclick='#'/></div></a>
        </div>
		<br><br><br><br><br>
		<h1> Questrom Inventory Manager </h1>
	</body>
</html>