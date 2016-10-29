<?php
include('db.php');
include('menu.php');

$serial = $_GET['serial'];
$sql = "SELECT * FROM `Q_Master` WHERE `BIOS_SERIAL_NUMBER` = '" .$serial."' OR `Serial Number` = '" .$serial."'"; 
$result = mysqli_query($connection, $sql);
$fields_num = mysqli_num_fields($result);
$fields_arr = mysqli_fetch_fields($result);
$row = mysqli_fetch_row($result);

$man = "none";
$mod = "none";
$dep = "none";
$prod = "none";

$fname = "";
$lname = "";
$uid = "";
?>

<!DOCTYPE html>
<html>
	<head>
		<link type="text/css" rel="stylesheet" href="stylesheet.css"/>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
        <script type="text/javascript" src="src/jquery.date-dropdowns.js"></script>
		<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css" />
        
		<title> Inventory Manager </title>
	</head>
	<body>
		
		<!-- hidden account 2 box scripts -->
        <script type="text/javascript">
            function oneTwoCheck(){
                if (document.getElementById('twoCheck').checked) {
                    document.getElementById('ifTwo').style.display = 'block';
                }
                else document.getElementById('ifTwo').style.display = 'none';
            }
        </script>
		
		<!-- autocomplete scripts -->
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>    
		<script type="text/javascript">
			$(function() {
				function split( val ) {
				  return val.split( /,\s*/ );
				}
    		
				//autocomplete for account number
				$(".auto").autocomplete({
					source: "auto_account.php",
					minLength: 1
				});
				
				// autocomplete for dept
				$("#dept").autocomplete({
					source: "auto_dept.php",
					minLength: 0
				});
				
				// autocomplete for manufacturer
				$("#man").autocomplete({
					source: "auto_manufac.php",
					minLength: 0
				});
				
				// autocomplete for usage type
				$("#usage").autocomplete({
					source: "auto_usage.php",
					minLength: 0
				});
				
				// autocomplete for user
				$("#user").autocomplete({
					source: "auto_user.php",
					minLength: 1,
					focus: function(event, ui) {
						var data = split(ui.item.value);
						$("#user").val(data[0]);
						return false;
					},
					select: function(event, ui){
						var names = split(ui.item.value);
						$("#user").val(names[0]);
						$("#user-last").val(names[0]);
						$("#user-first").val(names[1]);
						$("#user-uid").val(names[2]);
						$("#user-room").val(names[3]);
						$(".user-dept").val(names[4]);
					}
				});
				
				// autocomplete for product number
				$("#prod").autocomplete({
					source: "auto_model.php",
					minLength: 1,
					focus: function(event, ui) {
						var data = split(ui.item.value);
						$("#prod").val(data[0]);
						return false;
					},
					select: function(event, ui){
						var names = split(ui.item.value);
						$("#prod").val(names[0]);
						$("#prod-num").val(names[0]);
						$(".prod-make").val(names[1]);
						$("#prod-model").val(names[2]);
					}
				});
				
				// drop prefixes off front of product numbers
				$("#prod").focusout(function(){
					var $pr = $("#prod").val();
					if ($pr.substr(0,3) == "31P") {
						$("#prod").val($pr.substr(3));
					}
					if ($pr.substr(0,2) == "1P") {
						$("#prod").val($pr.substr(2));
					}
				});
			});
		</script>
		
		<h2> Edit Item </h2>
		
		<div class="mid" id="new">
			<form action="confirm.php">
				<div class="left">
					<p> Serial Number: <br>
                        <?php
                        echo "<input type='text' name='serial' value='".$serial."' readonly> <br>";
                        ?>
                        <br>
                        
                        Assigned User: <br>
                        <?php
						echo "<input type='text' id='user' placeholder='Search for user'>";
                        for ($i = 0; $i < $fields_num; $i++){
                            if ($fields_arr[$i]->name == 'UserFirst') {
                                echo "<input type='text' id='user-first' name='first_name' placeholder='First name' value='".$row[$i]."'>";
                            }
                        }
                        echo "<br>";
                        for ($i = 0; $i < $fields_num; $i++){
                            if ($fields_arr[$i]->name == 'UserLast') {
                                echo "<input type='text' id='user-last' name='last_name' placeholder='Last name' value='".$row[$i]."'>";
                            }
                        }
						echo "<input type='text' id='user-uid' name='uid' hidden>";
                        echo "<br><br>";
                        
                        echo "Assigned Location: <br>";
                        for ($i = 0; $i < $fields_num; $i++){
                            if ($fields_arr[$i]->name == 'Location') {
                                echo "<input type='text' id='user-room' name='location' placeholder='Room number' value='".$row[$i]."'>";
                            }
                        }               
                        echo "<br><br>";
                        echo "Make/Model: <br>";
						for ($i = 0; $i < $fields_num; $i++){
                            if ($fields_arr[$i]->name == 'Product Number') {
                                echo "<input type='text' id='prod' name='prod_number' placeholder='Product number' value='".$row[$i]."'><br>";
                            }
                        }  
                        for ($i = 0; $i < $fields_num; $i++){
                            if ($fields_arr[$i]->name == 'CS_MANUFACTURER' and strlen($row[$i]) > 0) {
                                $man = $row[$i];
                            } else if ($fields_arr[$i]->name == 'Make' and strlen($row[$i]) > 0) {
                                $man = $row[$i];
                            }
                        }
						
						echo "<input id='man' class='prod-make' name='manufacturer' value='".$man."'>";
                       
                        for ($i = 0; $i < $fields_num; $i++){
                            if ($fields_arr[$i]->name == 'CS_Model' and strlen($row[$i]) > 0) {
                                $mod = $row[$i];
                            } else if ($fields_arr[$i]->name == 'Model' and strlen($row[$i]) > 0) {
                                $mod = $row[$i];
                            }
                        }
                        echo "<input type='text' id='prod-model' name='model' value='".$mod."'>";
                        ?>
                        <br><br>
                        
                        Department: <br>
                        <?php
                        for ($i = 0; $i < $fields_num; $i++){
                            if ($fields_arr[$i]->name == 'Department') {
                                $dep = $row[$i];
                            }
                        }
						echo "<input id='dept' class='user-dept' name='department' value='".$dep."'>";
                        ?>
						
						<br><br>
                        
                        Notes: <br>
                        <?php
                        for ($i = 0; $i < $fields_num; $i++){
                            if ($fields_arr[$i]->name == 'Computer Notes') {
                                echo "<textarea rows='5' name='notes' placeholder='Enter notes here...'>".$row[$i]."</textarea>";
                            }
                        }
                        ?>
					</p>
				</div>
				<div class="right">
					<p>
                        <?php
                        echo "Warranty Start Date: <br>";
                        for ($i = 0; $i < $fields_num; $i++){
                            if ($fields_arr[$i]->name == 'WARRANTY_START') {
                                echo "<input type='text' name='wStart' placeholder='YYYY-MM-DD' value='".$row[$i]."'>";
                            }
                        }
                        echo "<br><br>";
                        
                        echo "Warranty End Date: <br>";
                        for ($i = 0; $i < $fields_num; $i++){
                            if ($fields_arr[$i]->name == 'WARRANTY_END') {
                                echo "<input type='text' name='wEnd' placeholder='YYYY-MM-DD' value='".$row[$i]."'>";
                            }
                        }

                        echo "<br><br>";
                        
                        echo "Usage Type: <br>";
                        for ($i = 0; $i < $fields_num; $i++){
                            if ($fields_arr[$i]->name == 'Usage Type') {
                                echo "<input type='text' id='usage' name='usage' placeholder='ex. loander, single-user' value='".$row[$i]."'>";
                            }
                        }
                        echo "<br><br>";
                        
                        echo "Requisition Number: <br>";
                        for ($i = 0; $i < $fields_num; $i++){
                            if ($fields_arr[$i]->name == 'Requisition Number') {
                                echo "<input type='text' name='requisition' value='".$row[$i]."'>";
                            }
                        }
                        echo "<br><br>";
                        
                        echo "Account Number:  ";
                        echo "1 <input type='radio' onclick='javascript:oneTwoCheck();' name='oneTwo' id='oneCheck' checked>";
                        $c2 = "2 <input type='radio' onclick='javascript:oneTwoCheck();' name='oneTwo' id='twoCheck'";
                        for ($i = 0; $i < $fields_num; $i++){
                            if ($fields_arr[$i]->name == 'Account Number 2' and strlen($row[$i] > 0)) {
                                $c2 .= "checked";
                            }
                        }
                        $c2 .= ">";
                        echo $c2;
                        echo "<br>";
                        for ($i = 0; $i < $fields_num; $i++){
                            if ($fields_arr[$i]->name == 'Account Number 1') {
                                echo "<input type='text' class='auto name='account1' value='".$row[$i]."'>";
                            }
                        }
                        for ($i = 0; $i < $fields_num; $i++){
                            if ($fields_arr[$i]->name == 'Account Number 2') {
                                echo "<input type='text' class='auto' id='ifTwo' style='display:none' name='account2' value='".$row[$i]."'>";
                            }
                        }
                        ?>
                        <br><br>
                        
					</p>
				</div>
				
				<div id="bottom"> <input type="submit" value="Apply"> </div>
			</form>
		</div>
	</body>
</html>