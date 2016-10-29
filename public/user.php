<?php
include('db.php');
include('menu.php');

$user = $_GET['user'];
$sql = "SELECT `buemail`, `lastName`, `firstName`, `buphone`, `buroom`, `deptLong`, `FacStaff` AS 'Eligibility' FROM `fac_staff` WHERE `buemail` LIKE '%" .$user."%'";
$find = "";

$result = mysqli_query($connection, $sql);
$fields_num = mysqli_num_fields($result);
$fields_arr = mysqli_fetch_fields($result);
$row = mysqli_fetch_row($result);

?>

<!DOCTYPE html>
<html>
	<head>
		<link type="text/css" rel="stylesheet" media="all" href="stylesheet.css"/>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
        <script type="text/javascript" src="src/main.js"></script>
        
        
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/u/dt/jq-2.2.3,pdfmake-0.1.18,dt-1.10.12,af-2.1.2,b-1.2.0,b-colvis-1.2.0,b-flash-1.2.0,b-html5-1.2.0,b-print-1.2.0,cr-1.3.2,fc-3.2.2,fh-3.1.2,kt-2.1.2,r-2.1.0,rr-1.1.2,sc-1.4.2,se-1.2.0/datatables.min.css"/>
        <script type="text/javascript" src="https://cdn.datatables.net/u/dt/jq-2.2.3,pdfmake-0.1.18,dt-1.10.12,af-2.1.2,b-1.2.0,b-colvis-1.2.0,b-flash-1.2.0,b-html5-1.2.0,b-print-1.2.0,cr-1.3.2,fc-3.2.2,fh-3.1.2,kt-2.1.2,r-2.1.0,rr-1.1.2,sc-1.4.2,se-1.2.0/datatables.min.js"></script>
        
		<title> Inventory Manager </title>
	</head>
	<body>
		<h2> User Directory </h2>
        
        <div id="center">
            <div class="mid" id="results">
                <?php
                $result = mysqli_query($connection, $sql);
                $fields_num = mysqli_num_fields($result);
                $fields_arr = mysqli_fetch_fields($result);
                echo "<table id='tbl' border='1'><thead><tr>";

                // create table headers
                for($i=0; $i<$fields_num; $i++) {
                    $field = mysqli_fetch_field($result);
                    $fieldURL = "<th>{$field->name}</th>";
                    echo $fieldURL;
                }

                echo "</tr></thead>\n";

                //create table rows
                while ($row = mysqli_fetch_row($result)) {
                    echo "<tr class='clickable'>";

                    // fill table cells, while also giving each cell a class named after the column name
                    for ($i = 0, $count = count($row); $i < $count; $i++){
						if($fields_arr[$i]->name == 'Eligibility'){
							$offset = 0;
							
							if ($row[$i] == 'Staff'){
								$offset = 4;
							} else {
								$offset = 3;
							}
							
							$find = "SELECT (`Q_Master`.`WARRANTY_START` + INTERVAL $offset YEAR) FROM `Q_Master` WHERE (`Q_Master`.`Account Number 1` = '9090000292' AND `Q_Master`.`ASSIGNED_TO` LIKE '".substr($row[0], 0, -7)."') OR (`Q_Master`.`Account Number 2` = '9090000292' AND `Q_Master`.`ASSIGNED_TO` LIKE '".substr($row[0], 0, -7)."') ORDER BY `WARRANTY_START` DESC LIMIT 1";
							$f_res = mysqli_query($connection, $find);
							$f_row = mysqli_fetch_row($f_res);
							$f_date = $f_row[0];
							
							echo "<td class='" .$fields_arr[$i]->name."'>$f_date</td>";
							
						} else {
							echo "<td class='" .$fields_arr[$i]->name."'>$row[$i]</td>";
						}
                    }
                    echo "</tr>";                    
                }
                echo "</table>";

                mysqli_free_result($result);
                ?>
            </div>
        </div>
    </body>
</html>