<?php
$corona=true;

include 'inc.chksession.php';
include 'inc.common.php';

if($s_LVL!=0){
	header("Location:error.php?m=Unauthorized");
}

$title="Update Logs";
$icon="fa fa-check";
$menu="-";

include 'inc.head.php';

$where="";
$tname="tm_updatelogs";
$cols="dtm,uid,obj,typ,txt,suc,err,tot,rowid";
$colsrc="uid";

include 'inc.menu.php';
?>
                
        <div class="main-panel">
          <div class="content-wrapper">
                
					<div class="row">
						<div class="col-md-12">
                <div class="page-header">                    
                    <h3 class="page-title"><?php echo $title;?></h3>
					
				</div>                   
						</div>
					</div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-default">
                                <div class="card-body table-responsive">
                                    <table id="example" class="table table-dark">
                                        <thead>
                                            <tr>
                                                <th>Date/Time</th>
                                                <th>User</th>
                                                <th>Object</th>
												<th>Type</th>
												<th>Change</th>
												<th>Success</th>
												<th>Error</th>
												<th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
		
					
          </div>
          <!-- content-wrapper ends -->

<?php
include 'inc.logout.php';
?>
	
	<script>
	var mytbl;
	var jvalidate;
$(document).ready(function() {
	mytbl = $('#example').DataTable({
	//dom: 'T<"clear"><lrf<t>ip>',
	searching: true,
	serverSide: true,
	processing: true,
	ordering: true,
	order: [[ 0, "asc" ]],
		ajax: {
			type: 'POST',
			url: 'dataget.php',
			data: function (d) {
				d.cols= '<?php echo base64_encode($cols); ?>',
				d.tname= '<?php echo base64_encode($tname); ?>',
				d.csrc= '<?php echo $colsrc; ?>',
				d.where= '<?php echo base64_encode($where);?>',
				//d.sever= $("#sever").val(),
				d.x= '<?php echo $menu; ?>';
			}
		}
	});
	
	jvalidate = $("#myf").validate({
    rules :{
        "userid" : {
            required : true
        },
		"username" : {
            required : true
        },
		"userlevel" : {
            required : true
        },
		"usergrp" : {
            required : false
        },
		"usermail" : {
            required : false,
			email : true
        },
		"userpwd" : {
            required : function(element) {
						if ($("#id").val() > 0) {
							return false;
						}
						else {
							return true;
						}
			}
        }
    }});
});

function tblupdate(){
	mytbl.ajax.reload();
}

</script>
	
    </body>
</html>

