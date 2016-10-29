<?php
include('db.php');
include('menu.php');
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
		
		
		
		<!-- Auto insert Building Fund account number -->
        <script type="text/javascript">			
            function buildingFund(){
                if (document.getElementById('bf').checked) {
                    $("#account").val(9090000292);
				}
            }
		</script>
		
		<!-- Help button -->
		<script type="text/javascript">
			function helpWindow() {
				var myWindow = window.open("help.php", "myWindow", "width=500,height=500");
			}
		</script>
		
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>    
		<script type="text/javascript">
			$(function() {
				function split( val ) {
					return val.split( /,\s*/ );
				}
				function extractLast( term ) {
					return split( term ).pop();
				}
				
				// autocomplete for account number
				$(".auto").autocomplete({
					source: "auto_account.php",
					minLength: 1
				});
				
				// autocomplete for department, with multiple selections
				$( "#dept" )
					// don't navigate away from the field on tab when selecting an item
					.bind( "keydown", function( event ) {
						if ( event.keyCode === $.ui.keyCode.TAB &&
							$( this ).autocomplete( "instance" ).menu.active ) {
							event.preventDefault();
						}
					})
					.autocomplete({
						minLength: 0,
						source: function( request, response ) {		
							$.getJSON( "auto_dept.php", {
								term: extractLast( request.term )
							}, response );
						},
						search: function() {
							// custom minLength
							var term = extractLast( this.value );
						},
						focus: function() {
							// prevent value inserted on focus
							return false;
						},
						select: function( event, ui ) {
							var terms = split( this.value );
							// remove the current input
							terms.pop();
							// add the selected item
							terms.push( ui.item.value );
							// add placeholder to get the comma-and-space at the end
							terms.push( "" );
							this.value = terms.join( ", " );
							return false;
						}
					});	
				
				// autocomplete for manufacturer
				$("#man").autocomplete({
					source: "auto_manufac.php",
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
					}
				});
			});
		</script>
		
		
		
		
		
		<h2> Search Database </h2>
		
		<div class="mid">
            <p id="search_p">Select any of the following fields to search the database for matches. </p>
			<form action="result.php">
				<div class="left">
					<p> Serial Number: <br>
					   <input type="text" name="serial"> <br>
					   <br>
						
                        Manufacturer: <br>
						<input id='man' name='manufacturer'>
						<br><br>
						
                        Warranty End Date:
						(range) <input type="radio" onclick="javascript:oneTwoCheck();" name="ran" id="twoCheck"><br>
						
                        <select name="end_month">
                            <option value="">Month</option>
                            <option value="01">1</option>
                            <option value="02">2</option>
                            <option value="03">3</option>
                            <option value="04">4</option>
                            <option value="05">5</option>
                            <option value="06">6</option>
                            <option value="07">7</option>
                            <option value="08">8</option>
                            <option value="09">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
						<select name="end_year" class="yearpicker">
                            <option value="">Year</option>
                        </select>
                        
						<div id="ifTwo" style="display:none"> to: <br>
						<select name="ran_month">
                            <option value="">Month</option>
                            <option value="01">1</option>
                            <option value="02">2</option>
                            <option value="03">3</option>
                            <option value="04">4</option>
                            <option value="05">5</option>
                            <option value="06">6</option>
                            <option value="07">7</option>
                            <option value="08">8</option>
                            <option value="09">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>	
						<select name="ran_year" class="yearpicker">
                            <option value="">Year</option>
							</select><br><br></div>
						
						
						
						
						<!-- hidden account 2 box scripts -->
						<script type="text/javascript">			
							function oneTwoCheck(){
								if (document.getElementById('twoCheck').checked) {
									document.getElementById('ifTwo').style.display = 'inline-block';
									
								}
							}
						</script>
						
						
						<script type="text/javascript">
							for (i = new Date().getFullYear()+10; i > 2005; i--) {
								$('.yearpicker').append($('<option />').val(i).html(i));
							}
						</script>
						
						
                        <br>
					
                        Department: <br>
						<input type="text" name="Department" id="dept">
                        <br><br>
                        
                        Custom Query:  
						<a href="#" onclick="helpWindow()"><img src="img/Help.png" alt="Help" height="20"></a>
						<br>
                        <textarea rows="5" name="custQuery" placeholder="Enter SQL query here... Place table names and field names inside the backward single quote on the Tilde button (~)"></textarea>
					</p>
				</div>
				<div class="right">
					<p>
                        Assigned User: <br>
						<input type='text' id='user' placeholder='User directory'> <br>
                        <input type="text" id="user-first" name="first_name" placeholder="First name">
                        <br>
                        <input type="text" id="user-last" name="last_name" placeholder="Last name"> <br>
                        <br>
                        Account Number:   
						(BF) <input type="radio" onclick="javascript:buildingFund();" name="bf" id="bf">
						<br>
                        <input type="text" class="auto" id="account" name="account">
                        <br>
                        <br>
                        
					</p>
				</div>
				
				<div id="bottom"> <input type="submit" value="Search" > </div>
			</form>
		</div>
	</body>
</html>