<?php
include('db.php');
include('menu.php');

?>

<!DOCTYPE html>
<html>
	<head>
		<link type="text/css" rel="stylesheet" href="stylesheet.css"/>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
        <script type="text/javascript" src="src/main.js"></script>
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
					autoSelect: true,
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
				
				
				
				// drop prefix "S" off front of serial numbers
				$("#serial").focusout(function(){
					var $ser = $("#serial").val();
					if ($ser.charAt(0) == "S") {
						$("#serial").val($ser.substr(1));
					}
				});
				
				// drop prefixes off front of product numbers
				$("#prod").focusout(function(){
					var $pr = $("#prod").val();
					if ($pr.substr(0,3) == "31P") {
						$("#prod").val($pr.substr(3));
						$("#prod").focus();
					}
					if ($pr.substr(0,2) == "1P") {
						$("#prod").val($pr.substr(2));
						$("#prod").focus();
					}
					
				});
			});
		</script>
		
        
		<h2> New Inventory </h2>
		
		<div class="mid" id="new">
			<form action="confirm_new.php">
				<div class="left">
					<p> Serial Number: <br>
					   	<input type="text" id="serial" name="serial" placeholder="(required)" required>
						<br><br>
                        
                        Assigned User: <br>
						<input type='text' id='user' placeholder='Search for user'><br>
                        <input type="text" id="user-first" name="first_name" placeholder="First name">
                        <br>
                        <input type="text" id="user-last" name="last_name" placeholder="Last name">
						<input type='text' id='user-uid' name='uid' hidden><br><br>
                        
                        Assigned Location: <br>
                        <input type="text" id="user-room" name="location" placeholder="Room number">
                        <br><br>
                        
                        Make/Model: <br>
						<input type="text" id="prod" placeholder="Product Number"><br>
						<input type="text" id='man' class="prod-make" name='manufacturer' placeholder="Manufacturer">
                        <input type="text" id="prod-model" name="model" placeholder="Model">
                        <br><br>
                        
                        Department: <br>
						<input type="text" name="Department" class="user-dept" id="dept">
						
						<br><br>
                        
                        Notes:
                        <textarea rows="5" name="notes" placeholder="Enter notes here..."></textarea>
					</p>
				</div>
				<div class="right">
					<p>
                        Warranty Start Date: <br>
                        <input type='text' name='wStart' placeholder='YYYY-MM-DD'> 
                        <br><br>
                        
                        Warranty End Date: <br>
                        <input type='text' name='wEnd' placeholder='YYYY-MM-DD'> 
                        <br><br>                    
                        
                        Usage Type: <br>
                        <input type="text" id="usage" name="usage" placeholder="ex. loaner, single-user">
                        <br><br>
                        
                        Requisition Number: <br>
                        <input type="text" name="requisition">
                        <br><br>
                        
                        Account Number:  
                        1 <input type="radio" onclick="javascript:oneTwoCheck();" name="oneTwo" id="oneCheck" checked>
                        2 <input type="radio" onclick="javascript:oneTwoCheck();" name="oneTwo" id="twoCheck">
                        <br>
                        <input type="text" id="auto" class="auto" name="account">
                        <input type="text" id="ifTwo" class="auto" name="account2" style="display:none">
                        
                        <br><br>
                        
					</p>
				</div>
				
				<div id="bottom"> <input type="submit" value="Submit"> </div>
			</form>
		</div>
	</body>
</html>