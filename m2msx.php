<?php
$corona=true;

include 'inc.chksession.php';
include 'inc.common.php';

$title="M2M";
$icon="fa fa-signal";
$menu="m2m";

include 'inc.head.php';

$where="";
$tname="tm_m2ms m left join tm_outlets o on o.oid=m.oid left join tm_outlets o2 on o2.oid=m.oidx";
$cols="notel,iptel,sn,m.oid,o.oname as oname1,o.kanwil,stts,guna,jenis,oidx,o2.oname as oname2,m.lastupd,m.updby,m.ticketno,m.rowid";
$colsrc="notel,iptel,m.oid,o.oname,o2.oname";

$opt1="";

include "inc.db.php";
/*
$conn=connect();
$rs=exec_qry($conn,"select oid,oname from tm_outlets order by oname");
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
					<a style="margin-right:5px;" href="#" onclick="openBatch('myff');" data-toggle="modal" data-target="#modal_file" class="btn btn-warning pull-right"><i class="fa fa-upload"></i> Upload</a>
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
                                                <th>Telp#</th>
                                                <th>IP</th>
												<th>SN</th>
												<th>Outlet ID</th>
												<th>Name</th>
												<th>Kanwil</th>
												<th>Status</th>
												<th>Penggunaan</th>
												<th>Jenis</th>
												<th>Outlet Pengguna</th>
												<th>Nama Pengguna</th>
												<th>Updated</th>
												<th>By</th>
												<th>Tiket</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
		
		<div class="modal" id="modal_file" tabindex="-2" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="largeModalHead"><b><i class="fa <?php echo $icon;?>"></i> <?php echo $title;?></b></h4>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </div>
					<div class="">
					
						<form class="form-horizontal" id="myff">
                            <div class="card card-default">
							<div class="card-body">
									<input type="hidden" name="t" value="batch_<?php echo $menu;?>">
									<input type="hidden" name="tname" value="tm_m2ms">
									<input type="hidden" id="svtf" name="svt" value="">
								
								<!--div class="form-group row">
									<label class="col-md-2 control-label">File</label>
									<div class="col-md-10">
										<input type="file" class="form-control form-control-sm input-sm" name="uploaded_file" id="uploaded_file" placeholder="...">
										<br /><a target="_blank" href="sample_m2ms.xls">Click Sample Upload File XLS 2003 Format</a>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-2 control-label">NIK</label>
									<div class="col-md-10">
										<input type="text" class="form-control form-control-sm input-sm" name="nik" id="nik" placeholder="...">
									</div>
								</div>
								--div id="ccp" class="form-group row">
									<label for="cp" class="col-md-2 control-label">Change Password</label>
									<div class="col-md-10">
										<input type="checkbox" value="Y" class="" name="cp" id="cp">
									</div>
								</div-->
								<div class="form-group row">
									<label class="col-md-2 control-label"><b>Data</b><br />
									Copy from <a target="_blank" href="sample_m2ms.xls">Sample</a> to data area</label>
									<div class="col-md-10">
										<textarea rows="10" class="form-control form-control-sm input-sm" name="datas" id="datas" placeholder="..."></textarea>
									</div>
								</div>
							</div>
							</div>
						</form>

                    </div>
                    <div class="modal-footer">
						<button type="button" class="btn btn-danger" onclick="sendDataFile('#myff','DEL','#svtf')">Delete</button>
						<button type="button" class="btn btn-warning" onclick="sendDataFile('#myff','UPD','#svtf')">Update</button>
						<button type="button" class="btn btn-success" onclick="sendDataFile('#myff','ADD','#svtf')">Add</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>                        
                    </div>
                </div>
            </div>
        </div>
		<div class="modal" id="modal_large" tabindex="-1" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-lg">
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
										<input type="hidden" name="tname" value="tm_m2ms">
										<input type="hidden" name="columns" value="oid,oidx,iptel,notel,sn,stts,guna,jenis,ticketno">
										<input type="hidden" id="svt" name="svt" value="">
										<input type="hidden" name="id" id="id" value="0">
										
									<div class="form-group row">
										<label class="col-md-2 control-label">No Telp</label>
										<div class="col-md-4">
											<input type="text" class="form-control form-control-sm input-sm" name="notel" id="notel" placeholder="...">
										</div>
										<label class="col-md-2 control-label">IP</label>
										<div class="col-md-4">
											<input type="text" class="form-control form-control-sm input-sm" name="iptel" id="iptel" placeholder="...">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-2 control-label">SN</label>
										<div class="col-md-4">
											<input type="text" class="form-control form-control-sm input-sm" name="sn" id="sn" placeholder="...">
										</div>
										<label class="col-md-2 control-label">Jenis</label>
										<div class="col-md-4">
											<input type="text" class="form-control form-control-sm input-sm" name="jenis" id="jenis" placeholder="...">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-2 control-label">Outlet ID</label>
										<div class="col-md-4">
											<input type="text" class="form-control form-control-sm input-sm" name="oid" id="oid" placeholder="...">
										</div>
										<label class="col-md-2 control-label">Outlet ID Pengguna</label>
										<div class="col-md-4">
											<input type="text" class="form-control form-control-sm input-sm" name="oidx" id="oidx" placeholder="...">
											<!--select class="form-control form-control-sm" name="oidx" id="oidx">
											<?php echo $opt1?>
											</select-->
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-2 control-label">Penggunaan</label>
										<div class="col-md-4">
											<input type="text" class="form-control form-control-sm input-sm" name="guna" id="guna" placeholder="...">
										</div>
										<label class="col-md-2 control-label">Status</label>
										<div class="col-md-4">
											<input type="text" class="form-control form-control-sm input-sm" name="stts" id="stts" placeholder="...">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-2 control-label">Tiket#</label>
										<div class="col-md-4">
											<input type="text" class="form-control form-control-sm input-sm" name="ticketno" id="ticketno" placeholder="...">
										</div>
									</div>
									
								</div>
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

