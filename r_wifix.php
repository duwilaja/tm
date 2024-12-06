<?php
$corona=true;

include 'inc.chksession.php';
include 'inc.common.php';

$title="Outlets WiFi";
$icon="fa fa-file-text";
$menu="-";
if($s_LVL==0||$s_LVL==5) $menu="rwifi";

include 'inc.head.php';

$where="";
$tname="tm_dpo";// t left join tm_outlets o on o.oid=t.oid";
$cols="oid,oname,stts,crtd,lastupd,proc,ctr,updby,rmk,rowid";
$colsrc="oid,oname,stts";
$grpby="";

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
                    
                    <div class="row hidden">
						<div class="col-md-12">
							<div class="card card-default">
								<div class="card-body">
									<div class="form-group row">
										<div class="col-md-3 hidden">
											<label>Report</label>
											<select class="form-control form-control-sm" name="chart" id="chart" onchange="rchange(this.value);">
												<option value="chart1">Main Link Per Kanwil</option>
												<option value="chart2">Gangguan VPN Outlet Per Kanwil</option>
												<option value="chart3">Gangguan Per Kanwil</option>
												<option value="chart4">Durasi Gangguan VPN</option>
												<option value="chart5">Durasi Gangguan Wi-fi Station</option>
											</select>
										</div>
										<div class="col-md-2">
											<label>From</label>
											<div class="input-group">
												<input id="df" name="df" type="text" class="form-control form-control-sm datepicker" placeholder="" value="<?php echo date('Y-m-d')?>">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-2">
											<label>To</label>
											<div class="input-group">
												<input id="dt" name="dt" type="text" class="form-control form-control-sm datepicker" placeholder="" value="<?php echo date('Y-m-d')?>">
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
                                <div class="card-body table-responsive">
                                    <table id="example" class="table table-dark">
                                        <thead>
                                            <tr>
                                                <th>Unit ID</th>
												<th>Name</th>
												<th>Status</th>
												<th>Created</th>
												<th>Updated</th>
												<th>Process?</th>
												<th>Counter</th>
												<th>Check</th>
												<th>Remark</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
		
		<div class="modal" id="modal_large" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="largeModalHead"><b><i class="fa <?php echo $icon;?>"></i> <?php echo $title;?></b></h4>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </div>
					<div class="">
					
						<form class="form-horizontal" id="myf">
                            <div class="card card-default">
							<div class="card-body">
									<input type="hidden" name="t" value="<?php echo $menu;?>">
									<input type="hidden" name="tname" value="<?php echo $tname;?>">
									<input type="hidden" name="columns" value="proc,rmk">
									<input type="hidden" id="svt" name="svt" value="">
									<input type="hidden" name="id" id="id" value="0">
									
								<div class="form-group row">
									<label class="col-md-2 control-label">Process?</label>
									<div class="col-md-10">
										<select class="form-control form-control-sm" name="proc" id="proc" placeholder="...">
											<option value="Y">Yes</option>
											<option value="N">No</option>
										</select>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-2 control-label">Remark</label>
									<div class="col-md-10">
										<textarea class="form-control form-control-sm" name="rmk" id="rmk"></textarea>
									</div>
								</div>
								
							</div>
							<div class="card-body" id="pesan"></div>
							</div>
						</form>

                    </div>
                    <div class="modal-footer">
						<button type="button" class="btn btn-success" onclick="if($('#myf').valid()){sendDataFile('#myf','SAVE');}">Save</button>
						<!--button type="button" class="btn btn-danger" id="bdelb" data-toggle="modal" data-target="#modal_delete">Delete</button-->
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
	//dom: 'T<"clear"><lrfB<t>ip>',
	lengthMenu: [[10,25,50,100,1000,-1],["10","25","50","100","1000","All"]],
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
				d.tname= '<?php echo base64_encode($tname); ?>',
				d.csrc= '<?php echo $colsrc; ?>',
				//d.where= '<?php echo base64_encode($where);?>',
				//d.grpby= '<?php echo base64_encode($grpby);?>',
				//d.df=$("#df").val(),
				//d.dt=$("#dt").val(),
				//d.sever= $("#sever").val(),
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

</script>
	
    </body>
</html>

