<?php
include('db.php');
include('menu.php');

$serial = $_GET['serial'];
if ($serial == 'undefined'){
	$serial = "";
}
$ran_month = $_GET['ran_month'];
$ran_year = $_GET['ran_year'];
$end_month = $_GET['end_month'];
$end_year = $_GET['end_year'];
$custQuery = $_GET['custQuery'];
$first_name = $_GET['first_name'];
$last_name = $_GET['last_name'];
$account = $_GET['account'];
$man = $_GET['manufacturer'];
$dept = $_GET['department'];
$sort = $_GET['sort'];
$dir = "ASC";
$dir = $_GET['dir'];
$full = FALSE;
$full = $_GET['full'];

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
        <!-- Secondary menu buttons -->
        <div id="header2">
            <div><input type="button" class='button' id="edit" onclick="#" value="Edit item"/></div>
            <div><input type="button" class='button' id="history" onclick="#" value="Item history"/></div>
            <div><input type="button" class='button' id="user" onclick="#" value="User info" /></div>
            
            <?php 
            // Full table button
            $dps = "";
            if (count($dept) > 0) {
                foreach ($dept as $selected) {
                    $dps .= "&department%5B%5D=" .$selected;
                }
            }
            $url = "<a href= 'result.php?full=TRUE&dir=$dir&sort=$sort&serial=$serial&end_month=$end_month&end_year=$end_year&custQuery=$custQuery&first_name=$first_name&last_name=$last_name&account=$account&manufacturer=$man";
            $url .= $dps;
            $url .="#full'>";
            echo $url."<div><input type='button' class='button' id='full' value='Full table' onclick='#'/></div></a>";
            ?>
        </div>
        
		
        <div id="center">
            <div class="mid" id="results">
                <?php                
                if (strlen($custQuery) > 0) {
                    $sql = $custQuery;

                } else {
                    
                    $add = "SELECT (CASE WHEN LENGTH(`BIOS_SERIAL_NUMBER`) > 0 THEN `BIOS_SERIAL_NUMBER` ELSE `Serial Number` END) AS 'SERIAL', (CASE WHEN LENGTH(`CS_MANUFACTURER`) > 0 THEN `CS_MANUFACTURER` ELSE `Make` END) AS 'CS_MANUFACTURER', (CASE WHEN LENGTH(`CS_MODEL`) > 0 THEN `CS_MODEL` ELSE `Model` END) AS 'CS_MODEL', `WARRANTY_START`, (CASE WHEN LENGTH(`WARRANTY_END`) > 0 AND `WARRANTY_END` != '0000-00-00' THEN `WARRANTY_END` ELSE `Warranty Exp Date` END) AS 'WARRANTY_END', `ASSIGNED_TO`,`Department`,`Account Number 1`,`Account Number 2` FROM `Q_Master`";
                    if ($full == TRUE) {
                        $add = "SELECT * FROM `Q_Master`";
                    }

                    // Nothing selected = Select All
                    if(strlen($serial) <= 0 and strlen($end_year) <= 0 and strlen($end_month) <= 0 and strlen($man) <= 0 and strlen($first_name) <= 0 and strlen($last_name) <= 0 and strlen($account) <= 0 and strlen($dept[0]) <= 0){
                        $sql ="";
                    } else {
                        $sql = " WHERE";
                    }

                    // Serial Number search
                    if (strlen($serial) > 0) {
                        $sql = $sql ." `BIOS_SERIAL_NUMBER` LIKE '%" .$serial."%' OR `Serial Number` LIKE '%" .$serial."%'";
                    }

                    // Warranty end search
						// date range search
					if (strlen($ran_year) > 0 or strlen($ran_month) > 0) {
						if (strlen($sql) > 6){
							$sql .= "AND";
						}
						if (strlen($ran_year) > 0 and strlen($end_year) > 0 and strlen($ran_month) <= 0 and strlen($end_month) <= 0){
							$sql .= " `WARRANTY_END` BETWEEN '".$ran_year."%' AND '".$end_year."%' OR `Warranty Exp Date` BETWEEN '".$ran_year."%' AND '".$end_year."%'";
						} else if (strlen($ran_year) > 0 and strlen($end_year) > 0 and strlen($ran_month) > 0 and strlen($end_month) > 0){
							$sql .= " `WARRANTY_END` BETWEEN '".$end_year."-".$end_month."%' AND '".$ran_year."-".$ran_month."%' OR `Warranty Exp Date` BETWEEN '".$end_year."-".$end_month."%' AND '".$ran_year."-".$ran_month."%'";
						} else if (substr($sql, -3) == "AND"){
							$sql = substr($sql, 0, -3);
						}
					} 
					
						// single date search
                     if (strlen($end_year) > 0 or strlen($end_month) > 0 and strlen($ran_year) <= 0 and strlen($ran_month) <= 0) {
                        if (strlen($sql) > 6){
                            $sql = $sql ." AND";
                        }
                        if (strlen($end_year) > 0 and strlen($end_month) <= 0) {
                            $sql = $sql ." `WARRANTY_END` LIKE '" .$end_year."%' OR `Warranty Exp Date` LIKE '".$end_year."%'";
                        }
                        else if (strlen($end_year) <= 0 and strlen($end_month) > 0) {
                            $sql = $sql ." `WARRANTY_END` LIKE '%-" .$end_month."-%' OR `Warranty Exp Date` LIKE '%-" .$end_month."-%'";
                        }
                        else {
                            $sql = $sql ." `WARRANTY_END` LIKE '".$end_year."-".$end_month."%' OR `Warranty Exp Date` LIKE '".$end_year."-".$end_month."%'";
                        }
                    }

                    // Manufacturer search
                    if (strlen($man) > 0) {
                        if (strlen($sql) > 6){
                            $sql = $sql ." AND";
                        }
                        $sql = $sql ." `Make` LIKE '%" .$man."%' OR `CS_MANUFACTURER` LIKE '%" .$man."%'";
                    }

                    // User First name search
                    if (strlen($first_name) > 0) {
                        if (strlen($sql) > 6){
                            $sql = $sql ." AND";
                        }
                        $sql = $sql ." `UserFirst` LIKE '%" .$first_name."%'";
                    }

                    // User Last name search
                    if (strlen($last_name) > 0) {
                        if (strlen($sql) > 6){
                            $sql .= " AND";
                        }
                        $sql = $sql ." `UserLast` LIKE '%" .$last_name."%'";
                    }

                    // Account number search
                    if (strlen($account) > 0) {
                        if (strlen($sql) > 6){
                            $sql = $sql ." AND";
                        }
                        $sql = $sql ." `Account Number 1` = '" .$account."' OR `Account Number 2` = '" .$account."'";
                    }

                    // Department search
                    $size = count($dept);
                    
                    if (strlen($dept[0]) > 0) {
                        if (strlen($sql) > 6){
                            $sql = $sql ." AND";
                        }
                        $sql = $sql ." `Department` LIKE '%" .$dept[0]."%'";

                        if ($size > 1) {
                            foreach($dept as $selectedDept){
                                $sql = $sql ." OR `Department` LIKE '%" .$selectedDept."%'";
                            }
                        }
                    }

                    // Sort search
                    if (strlen($sort) > 0) {
                        $sql .= " ORDER BY `" .$sort."` " .$dir;
                        if ($dir == "ASC") {
                            $dir = "DESC";
                        } else {
                            $dir = "ASC";
                        }
                    }
                }
                
                $sql = $add .$sql;
				
				// for debugging
				//echo $sql."<br>";
				
				
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
                        
                        if ($fields_arr[$i]->name == 'Serial Number'){
                            echo "<td class='Serial_Number'>$row[$i]</td>";
						} else {
                            echo "<td class='" .$fields_arr[$i]->name."'>$row[$i]</td>";
                        }
                    }
                    echo "</tr>\n";
                }
                echo "</table>";

                mysqli_free_result($result);
                ?>

            </div>
        </div>
	</body>
</html>