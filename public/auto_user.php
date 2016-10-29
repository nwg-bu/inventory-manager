<?php
include('db.php');

$term = $_GET['term'];

$sql="SELECT `lastName`, `firstName`, `buemail`, `buroom`, `deptLong` FROM `fac_staff` WHERE `lastName` LIKE '".$term."%' ORDER BY `lastName`";
$result = mysqli_query($connection, $sql);
$arr = array();

if ($result) {
	while($row = mysqli_fetch_array($result)) {
		$uid = substr($row['buemail'], 0, -7);
		$arr[] = $row['lastName'].", ".$row['firstName'].", ".$uid.", ".$row['buroom'].", ".$row['deptLong'];
	}
}

echo json_encode($arr);
?>
