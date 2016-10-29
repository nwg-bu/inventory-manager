<?php
include('db.php');
include('menu.php');

$dir = "uploads/";
$target_file = $dir . basename($_FILES['newFile']['name']);
move_uploaded_file($_FILES['newFile']['tmp_name'], $target_file);


$clear ="TRUNCATE TABLE `new_kace`";
mysqli_query($connection, $clear);
$sql = "LOAD DATA LOCAL INFILE '".$target_file."' INTO TABLE `new_kace` FIELDS TERMINATED BY '\t'";

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
        
        <!-- Buttons -->
        <div id="header3">
            <div><input type="button" class="button" id="result" onclick="#" value="View item"/></div>
            <div><input type="button" class="button" id="user" onclick="#" value="User info" /></div>
        </div>
       
		<!-- Update fac/staff directory -->
		<?php
		$url = 'http://questromapps.bu.edu/profiles/api/index.cfm/facstaffdata';
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$contents = curl_exec($ch);
		
		
		
		$dir = json_decode($contents, true);
		$data = $dir["DATA"];
		
		mysqli_query($connection, "TRUNCATE TABLE `fac_staff`");
		
		foreach ($data as $row){
			mysqli_query($connection, "INSERT INTO `fac_staff` (`buroom`, `lastName`, `firstName`, `buid`, `buemail`, `buphone`, `deptLong`, `title`, `FacStaff`) VALUES ('".$row[BUROOM]."', '".$row[LASTNAME]."', '".$row[FIRSTNAME]."', '".$row[BUID]."', '".$row[EMAIL]."', '".$row[BUPHONE]."', '".$row[DEPTLONG]."', '".$row[TITLE]."', '".$row[FACSTAFF]."')");
		}
		?>
		
		<div class="mid">
            <p class="complete"> 
                <?php
                if (mysqli_query($connection, $sql)) {
                    echo "KACE file has successfully updated the following:";
                } else {
                    echo "Error recording item: " .mysqli_error($connection);
                }
                ?>
            </p> <br>
            <div id="updated">
                <?php				
				// append results to the assignment_history table
                $sql = "INSERT INTO `history` SELECT `new_kace`.`BIOS_SERIAL_NUMBER`, `Q_Master`.`ASSIGNED_TO`, `new_kace`.`ASSIGNED_TO`, (DATE_FORMAT(NOW(), '%m/%d/%Y')) FROM `new_kace` LEFT JOIN `Q_Master` ON `new_kace`.`BIOS_SERIAL_NUMBER` = (CASE WHEN LENGTH(`Q_Master`.`BIOS_SERIAL_NUMBER`) > 0 THEN `Q_Master`.`BIOS_SERIAL_NUMBER` ELSE `Q_Master`.`Serial Number` END) WHERE `new_kace`.`ASSIGNED_TO` != `Q_Master`.`ASSIGNED_TO`";
                mysqli_query($connection, $sql);
                
				// create table showing changes
                $sql = "SELECT `new_kace`.`BIOS_SERIAL_NUMBER` AS 'Serial', `Q_Master`.`ASSIGNED_TO` AS 'Prev_User', `new_kace`.`ASSIGNED_TO` AS 'New_User' FROM `new_kace` LEFT JOIN `Q_Master`ON `new_kace`.`BIOS_SERIAL_NUMBER` = (CASE WHEN LENGTH(`Q_Master`.`BIOS_SERIAL_NUMBER`) > 0 THEN `Q_Master`.`BIOS_SERIAL_NUMBER` ELSE `Q_Master`.`Serial Number` END) WHERE `new_kace`.`ASSIGNED_TO` != `Q_Master`.`ASSIGNED_TO`";

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

                        if ($fields_arr[$i]->name == 'New_User'){
                            $update = "UPDATE `Q_Master` SET `ASSIGNED_TO` = '".$row[$i]."' WHERE `Q_Master`.`BIOS_SERIAL_NUMBER` = '".$row[0]."' OR `Q_Master`.`Serial Number` = '".$row[0]."'";
                            mysqli_query($connection, $update);
                        } 
						
                        echo "<td class='" .$fields_arr[$i]->name."'>$row[$i]</td>";
                    }
                    echo "</tr>\n";
                }
                echo "</table> <br><br>";
                
                // update existing entries in table
				$sql = "UPDATE 	`Q_Master` INNER JOIN `new_kace` ON (`new_kace`.`BIOS_SERIAL_NUMBER` != `Q_Master`.`BIOS_SERIAL_NUMBER` AND `new_kace`.`BIOS_SERIAL_NUMBER` = `Q_Master`.`Serial Number` AND `new_kace`.`BIOS_SERIAL_NUMBER` != '') SET `Q_Master`.`BIOS_SERIAL_NUMBER` = `new_kace`.`BIOS_SERIAL_NUMBER`, `Q_Master`.`USER` = `new_kace`.`USER`, `Q_Master`.`NAME` = `new_kace`.`NAME`, `Q_Master`.`OS_NAME` = `new_kace`.`OS_NAME`, `Q_Master`.`ASSET_NOTES` = `new_kace`.`ASSET_NOTES`, `Q_Master`.`LAST_INVENTORY` = STR_TO_DATE(`new_kace`.`LAST_INVENTORY`, '%m/%d/%Y'), `Q_Master`.`CS_MANUFACTURER` = `new_kace`.`CS_MANUFACTURER`, `Q_Master`.`CS_MODEL` = `new_kace`.`CS_MODEL`, `Q_Master`.`LAST_USER` = `new_kace`.`LAST_USER`, `Q_Master`.`WARRANTY_START` = STR_TO_DATE(`new_kace`.`WARRANTY_START`, '%m/%d/%Y'), `Q_Master`.`WARRANTY_END` = STR_TO_DATE(`new_kace`.`WARRANTY_END`, '%m/%d/%Y'), `Q_Master`.`ASSIGNED_TO` = `new_kace`.`ASSIGNED_TO`, `Q_Master`.`FUNCTION` = `new_kace`.`FUNCTION`, `Q_Master`.`FLOOR` = `new_kace`.`FLOOR`, `Q_Master`.`ROOM` =  `new_kace`.`ROOM`";
				mysqli_query($connection, $sql);

					
				echo "<p class='complete'>New items added to database:</p>";
                // craete table of new entries
				$sql = "SELECT `new_kace`.`BIOS_SERIAL_NUMBER` AS Serial, `new_kace`.`CS_MANUFACTURER` AS Make, `new_kace`.`CS_MODEL` AS Model, `new_kace`.`ASSIGNED_TO` FROM `new_kace` WHERE `new_kace`.`BIOS_SERIAL_NUMBER` NOT IN (SELECT (CASE WHEN LENGTH(`BIOS_SERIAL_NUMBER`) > 0 THEN `BIOS_SERIAL_NUMBER` ELSE `Serial Number` END) as Serial from `Q_Master`)";
                
				$result = mysqli_query($connection, $sql);
                $fields_num = mysqli_num_fields($result);
                $fields_arr = mysqli_fetch_fields($result);
                echo "<table id='tbl2' border='1'><thead><tr>";

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
                echo "</table> <br><br>";
				
				// insert new entries into database
				$sql = "INSERT INTO `Q_Master` (`BIOS_SERIAL_NUMBER`, `USER`, `NAME`, `OS_NAME`, `ASSET_NOTES`, `LAST_INVENTORY`, `CS_MANUFACTURER`, `CS_MODEL`, `LAST_USER`, `WARRANTY_START`, `WARRANTY_END`, `ASSIGNED_TO`, `FUNCTION`, `FLOOR`, `ROOM`) SELECT * FROM `new_kace` WHERE `new_kace`.`BIOS_SERIAL_NUMBER` NOT IN (SELECT (CASE WHEN LENGTH(`BIOS_SERIAL_NUMBER`) > 0 THEN `BIOS_SERIAL_NUMBER` ELSE `Serial Number` END) as Serial from `Q_Master`)";
				mysqli_query($connection, $sql);
				
				
				/*
				// only used when Q_Master is initially set up to force all dates into the correct format
				// using after initial set-up will force all dates to NULL
				
				$sql = "UPDATE `Q_Master` SET `Q_Master`.`LAST_INVENTORY` = STR_TO_DATE(`Q_Master`.`LAST_INVENTORY`, '%m/%d/%Y');";
				mysqli_query($connection, $sql);
				
				$sql = "UPDATE `Q_Master` SET `Q_Master`.`WARRANTY_START` = STR_TO_DATE(`Q_Master`.`WARRANTY_START`, '%m/%d/%Y');";
				mysqli_query($connection, $sql);
				
				$sql = "UPDATE `Q_Master` SET `Q_Master`.`WARRANTY_END` = STR_TO_DATE(`Q_Master`.`WARRANTY_END`, '%m/%d/%Y');";
				mysqli_query($connection, $sql);
				
				$sql = "UPDATE `Q_Master` SET `Q_Master`.`System Date` = STR_TO_DATE(`Q_Master`.`System Date`, '%m/%d/%Y');";
				mysqli_query($connection, $sql);
				
				$sql = "UPDATE `Q_Master` SET `Q_Master`.`Install Date` = STR_TO_DATE(`Q_Master`.`Install Date`, '%m/%d/%Y');";
				mysqli_query($connection, $sql);
				
				$sql = "UPDATE `Q_Master` SET `Q_Master`.`Warranty Exp Date` = STR_TO_DATE(`Q_Master`.`Warranty Exp Date`, '%m/%d/%Y');";
				mysqli_query($connection, $sql);*/
				
				
				mysqli_free_result($result);
                ?>				
            </div>
		</div>
	</body>
</html>