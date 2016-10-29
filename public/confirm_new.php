<?php
include('db.php');
include('menu.php');

$serial = ltrim($_GET['serial'], "S");
$first_name = $_GET['first_name'];
$last_name = $_GET['last_name'];
$location = $_GET['location'];
$man = $_GET['manufacturer'];
$mod = $_GET['model'];
$dept = $_GET['department'];
$wStart = $_GET['wStart'];
$wEnd = $_GET['wEnd'];
$usage = $_GET['usage'];
$req = $_GET['requisition'];
$account1 = $_GET['account1'];
$account2 = $_GET['account2'];
$notes = $_GET['notes'];

$q1 = "SELECT `buemail` FROM `fac_staff` WHERE `lastName` LIKE '".$last_name."' AND `firstName` LIKE '".$first_name."'";
$q2 = mysqli_query($connection, $q1);
$qr = mysqli_fetch_row($q2);
$email = $qr[0];
$uid = substr($email, 0, -7);


$sql = "INSERT INTO `Q_Master` (`BIOS_SERIAL_NUMBER`, `Serial Number`, `ASSIGNED_TO`, `UserFirst`, `UserLast`, `Location`, `CS_MANUFACTURER`, `Make`, `CS_MODEL`, `Model`, `Department`, `WARRANTY_START`, `WARRANTY_END`, `Warranty Exp Date`, `Usage Type`, `Computer Notes`, `Requisition Number`, `Account Number 1`, `Account Number 2`) VALUES ('".$serial."', '".$serial."', '".$uid."', '".$first_name."', '".$last_name."','".$location."', '".$man."', '".$man."', '".$mod."', '".$mod."', '".$dept."', '".$wStart."', '".$wEnd."', '".$wEnd."', '".$usage."', '".$notes."', '".$req."', '".$account1."', '".$account2."')";
?>



<!DOCTYPE html>
<html>
	<head>
		<link type="text/css" rel="stylesheet" href="stylesheet.css"/>
		<title> Inventory Manager </title>
	</head>
	<body>
		<div class="mid" id="complete">
            <p> 
            <?php
            if (mysqli_query($connection, $sql)) {
                echo "Item added successfully";
            } else {
                echo "Error recording item: " .mysqli_error($connection);
            }
            ?>
            </p>
		</div>
	</body>
</html>