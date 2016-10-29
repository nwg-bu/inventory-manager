<?php
include('db.php');
include('menu.php');

$serial = $_GET['serial'];

$war = "SELECT `WARRANTY_START` FROM `Q_Master` WHERE `BIOS_SERIAL_NUMBER` = '".$serial."' OR `Serial Number` = '".$serial."'";
$sql = "SELECT * FROM `history` WHERE `Serial` = '".$serial."'";
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
		<h2> Assignment History </h2>
	
		<div class="mid" id="updated">
            <?php
			$war_res = mysqli_query($connection, $war);
			$war_date = mysqli_fetch_row($war_res);
			
            $result = mysqli_query($connection, $sql);
            $fields_num = mysqli_num_fields($result);
            $fields_arr = mysqli_fetch_fields($result);
            echo "<table id='tbl' border='1'><caption> Warranty Start Date: ".$war_date[0]."</caption><thead><tr>";
		
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
                    echo "<td class='" .$fields_arr[$i]->name."'>$row[$i]</td>";
                }
                echo "</tr>\n";
            }
            echo "</table>";
            ?>
		</div>
	</body>
</html>