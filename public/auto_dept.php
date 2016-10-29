<?php
include('db.php');

$term = $_GET['term'];

$sql="SELECT DISTINCT `deptLong` FROM `fac_staff` WHERE `deptLong` LIKE '".$term."%' ORDER BY `deptLong`";
$result = mysqli_query($connection, $sql);
$arr = array();

if ($result) {
	while($row = mysqli_fetch_array($result)) {
		$arr[] = $row['deptLong'];
	}
}

echo json_encode($arr);
?>
