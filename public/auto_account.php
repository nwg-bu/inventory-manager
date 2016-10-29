<?php
include('db.php');

$term = $_GET['term'];

$sql="SELECT DISTINCT `Cost Center` FROM `costCenter` WHERE `Cost Center` LIKE '".$term."%' ORDER BY `Cost Center`";
$result = mysqli_query($connection, $sql);
$arr = array();

if ($result) {
	while($row = mysqli_fetch_array($result)) {
		$arr[] = $row['Cost Center'];
	}
}

echo json_encode($arr);
?>
