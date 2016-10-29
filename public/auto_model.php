<?php
include('db.php');
$term = ltrim($_GET['term'], "31P");
$term = ltrim($_GET['term'], "1P");
$term = $_GET['term'];

$sql="SELECT DISTINCT `Product Number`, (CASE WHEN LENGTH(`CS_MANUFACTURER`) > 0 THEN `CS_MANUFACTURER` ELSE `Make` END) AS 'Make', (CASE WHEN LENGTH(`Model`) > 0 THEN `Model` ELSE `CS_MODEL` END) AS 'Model' FROM `Q_Master` WHERE `Product Number` LIKE '".$term."%' ORDER BY `Product Number`";
$result = mysqli_query($connection, $sql);
$arr = array();

if ($result) {
	while($row = mysqli_fetch_array($result)) {
		$arr[] = $row['Product Number'].", ".$row['Make'].", ".$row['Model'];
	}
}

echo json_encode($arr);
?>
