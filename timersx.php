<?php
$corona=true;

include 'inc.chksession.php';
include 'inc.common.php';

$title="Notify";
$icon="fa fa-clock-o";
$menu="notify";

include 'inc.head.php';

$where="";
$tname="tm_timers";
$cols="grp,typ,stts,mnt,rowid";
$colsrc="grp,typ,stts";

$opt1="";

/*
include "inc.db.php";
$conn=connect();
$rs=exec_qry($conn,"select locid,locname from ep_locations order by locname");
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
                    <h3 class="page-title"><?php echo $title;?></h2>
					<div>
					<a href="#" onclick="openForm(0);" data-toggle="modal" data-target="#modal_large" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Create</a>
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
                                                <th>Group</th>
                                                <th>Type</th>
												<th>Status</th>
												<th>Time(Minutes)</th>
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
									<input type="hidden" name="columns" value="grp,typ,mnt,stts">
									<input type="hidden" id="svt" name="svt" value="">
									<input type="hidden" name="id" id="id" value="0">
									
								<div class="form-group row">
									<label class="col-md-2 control-label">Group</label>
									<div class="col-md-10">
										<select class="form-control form-control-sm" name="grp" id="grp">
											<?php echo $optgrp;?>
										</select>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-2 control-label">Type</label>
									<div class="col-md-10">
										<select class="form-control form-control-sm" name="typ" id="typ">
											<?php echo $opttyp;?>
										</select>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-2 control-label">Status</label>
									<div class="col-md-10">
										<select class="form-control form-control-sm" name="stts" id="stts">
											<option value="new">new</option>
											<option value="open">open</option>
											<option value="progress">progress</option>
											<option value="pending">pending</option>
											<option value="solved">solved</option>
											<option value="closed">closed</option>
										</select>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-2 control-label">Minutes</label>
									<div class="col-md-10">
										<input type="text" class="form-control form-control-sm input-sm" name="mnt" id="mnt" placeholder="...">
									</div>
								</div>
								
							</div>
							<div class="card-body" id="pesan"></div>
							</div>
						</form>

                    </div>
                    <div class="modal-footer">
						<button type="button" class="btn btn-success" onclick="if($('#myf').valid()){sendDataFile('#myf','SAVE');}">Save</button>
						<button type="button" class="btn btn-danger" id="bdel" data-toggle="modal" data-target="#modal_delete">Delete</button>
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
        "typ" : {
            required : true
        },
		"grp" : {
            required : true
        },
		"stts" : {
            required : true
        },
		"mnt" : {
            required : true,
			number : true
        }
    }});
});

function tblupdate(){
	mytbl.ajax.reload();
}

</script>
	
    </body>
</html>

