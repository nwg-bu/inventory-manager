<?php
include('db.php');

$term = $_GET['term'];

$sql="SELECT DISTINCT (CASE WHEN LENGTH(`CS_MANUFACTURER`) > 0 THEN `CS_MANUFACTURER` ELSE `Make` END) AS 'CS_MANUFACTURER' FROM `Q_Master` WHERE `CS_MANUFACTURER` LIKE '".$term."%' OR `Make` LIKE '".$term."%' ORDER BY `CS_MANUFACTURER`";
$result = mysqli_query($connection, $sql);
$arr = array();

if ($result) {
	while($row = mysqli_fetch_array($result)) {
		$arr[] = $row['CS_MANUFACTURER'];
	}
}

echo json_encode($arr);
?>
