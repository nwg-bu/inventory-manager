<?php
include('db.php');

$term = $_GET['term'];

$sql="SELECT DISTINCT (CASE WHEN LENGTH(`FUNCTION`) > 0 THEN `FUNCTION` ELSE `Usage Type` END) AS 'FUNCTION' FROM `Q_Master` WHERE `FUNCTION` LIKE '".$term."%' OR `Usage Type` LIKE '".$term."%' ORDER BY `FUNCTION`";
$result = mysqli_query($connection, $sql);
$arr = array();

if ($result) {
	while($row = mysqli_fetch_array($result)) {
		$arr[] = $row['FUNCTION'];
	}
}

echo json_encode($arr);
?>
