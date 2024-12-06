<?php
$corona=true;

include 'inc.chksession.php';
include 'inc.common.php';

$title="Log API Create Ticket";
$icon="fa fa-file-text";
$menu="-";
if($s_LVL==0) $menu="rcreatelog";

include 'inc.head.php';

$where="";
$tname="tm_apicreate_log";
$cols="dt,rid,typ,st,i,h,k,d,crtdby,v,rowid";
$colsrc="i,h,st,typ,k,d,crtdby";

$opt1="";

include "inc.db.php";
$conn=connect();
$rs=exec_qry($conn,"select distinct lnk from tm_outlets where trim(lnk)<>'' order by lnk");
while($row=fetch_row($rs)){
	$opt1.='<option value="'.$row[0].'">'.$row[0].'</option>';
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
											<select class="form-control form-control-sm" name="lnk" id="lnk">
												<option value="">All Main Link</option>
												<?php echo $opt1?>
											</select>
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
												<th>Service</th>
												<th>Outlet ID</th>
                                                <th>Name</th>
												<th>Kanwil</th>
												<th>Detail</th>
												<th>By</th>
												<th>Process?</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
					
		<div class="modal" id="modal_large" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true" data-backdrop="static">
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
									<input type="hidden" name="columns" value="v">
									<input type="hidden" id="svt" name="svt" value="">
									<input type="hidden" name="id" id="id" value="0">
									
								<div class="form-group row">
									<label class="col-md-2 control-label">Process?</label>
									<div class="col-md-10">
										<select class="form-control form-control-sm" name="v" id="v" placeholder="...">
											<option value="1">Yes</option>
											<option value="0">No</option>
										</select>
									</div>
								</div>
								
							</div>
							<div class="card-body" id="pesan"></div>
							</div>
						</form>

                    </div>
                    <div class="modal-footer">
						<button type="button" class="btn btn-success" onclick="if($('#myf').valid()){sendDataFile('#myf','SAVE');}">Save</button>
						<button type="button" class="btn btn-danger" id="bdelb" data-toggle="modal" data-target="#modal_delete">Delete</button>
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
				d.where= getWhere(),
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
		return '<?php echo base64_encode("tm_apicreate_log_h"); ?>';
	}
}
function getWhere(){
	if($("#lnk").val()==''){
		return '';
	}else{
		return btoa("left(h,5) in (select oid from tm_outlets where lnk='"+$("#lnk").val()+"')");
	}
}
</script>
	
    </body>
</html>

