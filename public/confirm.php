<?php
include('db.php');
include('menu.php');

$serial = $_GET['serial'];
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
$uid = $_GET['uid'];



$sql = "UPDATE `Q_Master` SET `UserFirst` = '".$first_name."', `UserLast` = '".$last_name."', `ASSIGNED_TO` = '".$uid."', `Location` = '".$location."', `CS_MANUFACTURER` = '".$man."', `Make` = '".$man."', `CS_MODEL` = '".$mod."', `Model` = '".$mod."', `Department` = '".$dept."', `WARRANTY_START` = '".$wStart."', `WARRANTY_END` = '".$wEnd."', `Warranty Exp Date` = '".$wEnd."', `Usage Type` = '".$usage."', `Computer Notes` = '".$notes."',  `Requisition Number` = '".$req."', `Account Number 1` = '".$account1."', `Account Number 2` = '".$account2."' WHERE `BIOS_SERIAL_NUMBER` = '".$serial."' OR `Serial Number` = '".$serial."'";
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
                echo "Item updated successfully";
            } else {
                echo "Error recording item: " .mysqli_error($connection);
            }
            ?>
            </p>
		</div>
	</body>
</html>