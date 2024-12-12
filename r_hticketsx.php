<?php
$corona=true;

include 'inc.chksession.php';
include 'inc.common.php';

$title="History Tickets Report";
$icon="fa fa-file-text";
$menu="-";

include 'inc.head.php';

$where="";
$tname="tm_tickets t left join tm_kanwils k on k.locid=t.k left join tm_ips i on i.oid=t.i and i.layanan=t.st left join tm_notes n on t.ticketno=n.ticketid";
$cols="ticketno,dt,i,h,d,locname,sid,st,grp,typ,blink,p,solving,t.s,solved,closed,t.lastupd,t.updby,n.notes,n.updby,n.lastupd,t.rowid";
$colsrc="h";

$optcus="";$optsla="";$optgrp="";$opttstatus="";$optsubj="";

include 'inc.db.php';
$conn=connect();
$rs=exec_qry($conn,"select locid,locname from tm_kanwils order by locname");
while($row=fetch_row($rs)){
	$optcus.='<option value="'.$row[0].'">'.$row[1].'</option>';
}
$rs=exec_qry($conn,"select distinct grp from tm_tickets");
while($row=fetch_row($rs)){
	$optgrp.='<option value="'.$row[0].'">'.$row[0].'</option>';
}
$rs=exec_qry($conn,"select distinct s from tm_tickets");
while($row=fetch_row($rs)){
	$opttstatus.='<option value="'.$row[0].'">'.$row[0].'</option>';
}
$rs=exec_qry($conn,"select distinct typ from tm_tickets");
while($row=fetch_row($rs)){
	$optsubj.='<option value="'.$row[0].'">'.$row[0].'</option>';
}

disconnect($conn);

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
										<div class="col-md-2">
											Created From
										<!--/div>
										<div class="col-md-2"-->
											<div class="input-group">
												<input id="df" name="df" type="text" class="form-control form-control-sm datepicker" placeholder="">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-2">
											To
										<!--/div>
										<div class="col-md-2"-->
											<div class="input-group">
												<input id="dt" name="dt" type="text" class="form-control form-control-sm datepicker" placeholder="">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-1"></div>
										<div class="col-md-2">
											Updated From
										<!--/div>
										<div class="col-md-2"-->
											<div class="input-group">
												<input id="uf" name="uf" type="text" class="form-control form-control-sm datepicker" placeholder="">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-2">
											To
										<!--/div>
										<div class="col-md-2"-->
											<div class="input-group">
												<input id="ut" name="ut" type="text" class="form-control form-control-sm datepicker" placeholder="">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-2">
											&nbsp;<br />
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
								<div class="card-body">
									<div class="form-group row">
									<div class="col-md-1">
										<select multiple class="form-control form-control-sm selectpicker" name="status" id="status">
										<?php echo $opttstatus?>
										</select>
									</div>
									<div class="col-md-2">
										<select class="form-control form-control-sm" name="customer" id="customer">
										<option value="">All Kanwil</option>
										<?php echo $optcus?>
										</select>
									</div>
									<div class="col-md-1">
										<select class="form-control form-control-sm " name="grp" id="grp">
										<option value="">All Groups</option>
										<?php echo $optgrp?>
										</select>
									</div>
									<div class="col-md-4">
										<!--select class="form-control form-control-sm" name="pic" id="pic">
										<option value="">All Type</option>
										<?php echo $optsubj?>
										</select-->
										<select multiple class="form-control form-control-sm selectpicker" name="pic[]" id="pic">
										<?php echo $optsubj?>
										</select>
									</div>
									<div class="col-md-2">
										<select class="form-control form-control-sm selectpicker" name="st" id="st" multiple>
										<!--option value="">All Service</option-->
										<?php echo $optst?>
										</select>
									</div>
									<div class="col-md-1">
										<select class="form-control form-control-sm " name="blink" id="blink">
										<option value="">All Secondary Link</option>
										<?php echo $optblink?>
										</select>
									</div>
									<div class="col-md-1">
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
                                                <th>ID</th>
                                                <th>Date</th>
                                                <th>Unit ID</th>
                                                <th>Subject</th>
                                                <th>Detail</th>
                                                <th>Kanwil</th>
                                                <th>SID</th>
                                                <th>Service</th>
                                                <th>Group</th>
                                                <th>Problem</th>
                                                <th>Sec.Link</th>
                                                <th>Filtering</th>
                                                <th>Solving</th>
                                                <th>Status</th>
                                                <th>Solved On</th>
                                                <th>Closed On</th>
                                                <th>Last Update</th>
                                                <th>Updated By</th>
												<th>Notes</th>
												<th>By</th>
												<th>Notes Date</th>
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
$(document).ready(function() {
	mytbl = $('#example').DataTable({
	//dom: 'T<"clear"><lrBf<t>ip>',
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
	order: [[ 0, "asc" ]],
		ajax: {
			type: 'POST',
			url: 'dataget.php',
			data: function (d) {
				d.cols= '<?php echo base64_encode($cols); ?>',
				d.tname= '<?php echo base64_encode($tname); ?>',
				d.csrc= '<?php echo $colsrc; ?>',
				d.where= '<?php echo base64_encode($where);?>',
				d.ms= getMultipleValues("#status"),
				d.mtyp= getMultipleValues("#pic"),
				d.k= $("#customer").val(),
				d.grp= $("#grp").val(),
				d.mst= getMultipleValues("#st"),
				d.df= $("#df").val(),
				d.dt= $("#dt").val(),
				d.tdf= $("#uf").val(),
				d.tdt= $("#ut").val(),
				d.blink= $("#blink").val(),
				d.x= '<?php echo $menu; ?>';
			}
		}
	});
	jvalidate = $("#myf").validate({
    rules :{
        "customer" : {
            required : true
        },
		"reason" : {
            required : function(element) {
						if ($("#status").val() == "QO") {
							return true;
						}
						else {
							return false;
						}
					}
        }
    }});
	
	$(".selectpicker").select2();
	//runChart();
});

function tblupdate(){
	mytbl.ajax.reload();
}

function oclick(c,v){
	if($(c)[0].checked){
		$(v).val('Y');
	}else{
		$(v).val('');
	}
}

function getMultipleValues(theid){
	var ret="";
	var arr=$(theid).val();
	if(arr){
		for(var i=0;i<arr.length;i++){
			if(ret==""){
				ret="'"+arr[i]+"'";
			}else{
				ret=ret+",'"+arr[i]+"'";
			}
		}
	}
	return ret;
}

</script>


<?php //include "r_tickets.incc.php";?>
	
    </body>
</html>