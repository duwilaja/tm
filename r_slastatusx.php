<?php
$corona=true;

include 'inc.chksession.php';
include 'inc.common.php';

$title="Status Duration";
$icon="fa fa-file-text";
$menu="rslastt";

include 'inc.head.php';

$where="((nossa<>'' and nossa<>'-') or p<>'link normal' or (p='link normal' and TIMESTAMPDIFF(MINUTE,t.dt,solved)>15))";
$where="TIMESTAMPDIFF(MINUTE,t.dt,solved)>15";
$tname="tm_tickets t left join tm_outlets o on t.i=o.oid left join tm_sla_status d on d.tiket=t.ticketno";
$cols="ticketno,dt,typ,st,i,k,area,cabang,h,dnew,dopen,dprog,dsolv,dpend,TIMESTAMPDIFF(SECOND,t.dt,closed),avgprg,pas,usr";
$colsrc="";
//$grpby="st,i,k,area,cabang,h,tt";
$grpby="";

$optcus="";$optsla="";$optgrp="";$opttstatus="";$optsubj="";$optarea="";

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
$rs=exec_qry($conn,"select distinct area from tm_outlets");
while($row=fetch_row($rs)){
	$optarea.='<option value="'.$row[0].'">'.$row[0].'</option>';
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
										<div class="col-md-1">
											From
										</div>
										<div class="col-md-2">
											<div class="input-group">
												<input id="df" name="df" type="text" class="form-control form-control-sm datepicker" placeholder="" value="<?php echo date('Y-m-d')?>">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-1">
											To
										</div>
										<div class="col-md-2">
											<div class="input-group">
												<input id="dt" name="dt" type="text" class="form-control form-control-sm datepicker" placeholder="" value="<?php echo date('Y-m-d')?>">
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
								<div class="card-body">
									<div class="form-group row">
									<div class="col-md-2">
										<select class="form-control form-control-sm" name="k" id="k">
										<option value="">All Kanwil</option>
										<?php echo $optcus?>
										</select>
									</div>
									<!--div class="col-md-2">
										<select class="form-control form-control-sm" name="area" id="area">
										<option value="">All Area</option>
										<?php echo $optarea?>
										</select>
									</div-->
									<div class="col-md-2">
										<select class="form-control form-control-sm" name="grp" id="grp">
										<option value="">All Groups</option>
										<?php echo $optgrp?>
										</select>
									</div>
									<div class="col-md-2">
										<select class="form-control form-control-sm" name="typ" id="typ">
										<option value="'offline','keluhan lambat','link up-down','link intermitten'">All Type</option>
										<option value="'offline'">Offline</option>
										<option value="'keluhan lambat'">Keluhan Lambat</option>
										<option value="'link up-down'">Link Up-Down</option>
										<option value="'link intermitten'">Link Intermitten</option>
										<option value="">Jarkom Tiket</option>
										</select>
									</div>
									<div class="col-md-5">
										<select class="form-control form-control-sm selectpicker" name="st" id="st" multiple>
										<!--option value="">All Service</option-->
										<?php echo $optst?>
										</select>
									</div>
									<!--div class="col-md-2">
										<select class="form-control form-control-sm" name="durasi" id="durasi">
										<option value=">0">All</option>
										<option value=">30">Link Normal >30</option>
										<option value="<=30">Link Normal <=30</option>
										</select>
									</div-->
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
                                                <th>#</th>
                                                <th>Tgl</th>
                                                <th>Jenis</th>
                                                <th>Layanan</th>
                                                <th>Unit ID</th>
                                                <th>Kanwil</th>
                                                <th>Area</th>
                                                <th>Cabang</th>
                                                <th>Unit</th>
                                                <th>New</th>
                                                <th>Open</th>
                                                <th>Progress</th>
												<th>Solved</th>
												<th>Pending</th>
												<th>Total</th>
												<th>Avg Progress Response</th>
												<th>Response Passed (x)</th>
												<th>User</th>
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
	//dom: 'lrfB<t>ip',
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
				d.where= getWhere(),
				d.grpby= '<?php echo base64_encode($grpby);?>',
				d.grp= $("#grp").val(),
				d.mtyp= $("#typ").val(),
				d.k= $("#k").val(),
				d.mst= getMultipleValues("#st"),
				d.df= $("#df").val(),
				d.dt= $("#dt").val(),
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
function getWhere(){
	if($("#grp")=='link') return '<?php echo base64_encode($where);?>';
	
	return '';
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