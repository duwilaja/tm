<?php
$corona=true;

include 'inc.chksession.php';
include 'inc.common.php';

$title="Log API Update Ticket";
$icon="fa fa-file-text";
$menu="-";

include 'inc.head.php';

$where="";
$tname="tm_apiupdate_log";
$cols="dt,rid,typ,s,i,h,ticketno,d,crtdby";
$colsrc="i,h,s,typ,ticketno,d,crtdby";

$opt1="";
/*
include "inc.db.php";
$conn=connect();
$rs=exec_qry($conn,"select locid,locname from tm_kanwils order by locname");
while($row=fetch_row($rs)){
	$opt1.='<option value="'.$row[0].'">'.$row[1].'</option>';
}
disconnect($conn);
*/

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
								<div class="card-body">
									<div class="form-group row">
										<div class="col-md-1 text-right">
											From
										</div>
										<div class="col-md-2">
											<div class="input-group">
												<input id="df" name="df" type="text" class="form-control form-control-sm datepicker" placeholder="">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-1 text-right">
											To
										</div>
										<div class="col-md-2">
											<div class="input-group">
												<input id="dt" name="dt" type="text" class="form-control form-control-sm datepicker" placeholder="">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-2">
											<button class="btn btn-info" onclick="tblupdate()"><i class="fa fa-search"></i> Filter</button>
										</div>
									</div>
								</div>
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
                                                <th>TrID</th>
												<th>Type</th>
												<th>Status</th>
												<th>Outlet ID</th>
                                                <th>Name</th>
												<th>Ticket#</th>
												<th>Detail</th>
												<th>By</th>
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
	var mytbl, jvalidate;
	var tude='<?php echo date('Y-m-d')?>';
	
$(document).ready(function() {
	mytbl = $('#example').DataTable({
	//dom: 'T<"clear"><lrfB<t>ip>',
	lengthMenu: [[10,25,50,100,-1],["10","25","50","100","All"]],
	layout: {
        top1End: {
            buttons: ['copy', 'csv', 'excel', 'pdf']
        }
    },
	searching: true,
	serverSide: true,
	processing: true,
	ordering: true,
	order: [[ 0, "desc" ]],
		ajax: {
			type: 'POST',
			url: 'dataget.php',
			data: function (d) {
				d.cols= '<?php echo base64_encode($cols); ?>',
				d.tname= getTname(),
				d.csrc= '<?php echo $colsrc; ?>',
				d.where= '<?php echo base64_encode($where);?>',
				//d.sever= $("#sever").val(),
				d.df= $("#df").val(),
				d.dt= $("#dt").val(),
				d.x= '<?php echo $menu; ?>';
			}
		}
	});
	
	jvalidate = $("#myf").validate({
    rules :{
        "oid" : {
            required : true
        },
		"oname" : {
            required : true
        },
		"kanwil" : {
            required : true
        }
    }});
});

function tblupdate(){
	mytbl.ajax.reload();
}

function getTname(){
	if($("#df").val()==tude||$("#df").val()==''){
		return '<?php echo base64_encode($tname); ?>';
	}else{
		return '<?php echo base64_encode("tm_apiupdate_log_h"); ?>';
	}
}
</script>
	
    </body>
</html>

