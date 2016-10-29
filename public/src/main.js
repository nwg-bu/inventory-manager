/***************************************************/

$(document).ready(function() {
	var helpTable = $('#help').DataTable({ dom: 'rt', "paging": false });
    var table = $('#tbl').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'print',
                customize: function( win ) {
                    $(win.document.body).find('table')
                        .addClass('compact');
                }
            },
            'excel'
        ],
        "paging": false
    });
	
	var table2 = $('#tbl2').DataTable({
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'print',
                customize: function( win ) {
                    $(win.document.body).find('table')
                        .addClass('compact');
                }
            },
            'excel'
        ],
        "paging": false
    });
    
    var $s1, $s2, $u1, $ser = "";
 
    $('tbody').on('click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
			table2.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            $u1 = $(this).find(".ASSIGNED_TO").html();
            if (window.location.hash.substr(1) == "full") {
                $s1 = $(this).find(".BIOS_SERIAL_NUMBER").html();
                $s2 = $(this).find(".Serial_Number").html();
                if (!$s1.trim()){
                    $s1 = $s2;
                }
            } else if (window.location.hash.substr(1) == "complete"){
                $s1 = $(this).find(".Serial").html();
                $u1 = $(this).find(".New_User").html();
            } else {
                $s1 = $(this).find(".SERIAL").html();
            }
        }
    });
 
    $('#edit').click(function() {
        window.location = "edit.php?serial=" + $s1;
    });
    
    $('#edit2').click(function() {
        window.location = "edit.php?serial=" + $s1;
    });
    
    $('#history').click(function() {
        window.location = "history.php?serial=" + $s1;
    });
    
    $('#user').click(function() {
        window.location = "user.php?user=" + $u1;
    });
	
	$('#result').click(function() {
		window.location = "result.php?serial=" + $s1;
	});
	
});

