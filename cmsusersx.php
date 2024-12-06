<?php
$corona=true;

include 'inc.chksession.php';
include 'inc.common.php';

if($s_LVL!=0){
	header("Location:error.php?m=Unauthorized");
}

$title="Users";
$icon="fa fa-users";
$menu="users";

include 'inc.head.php';

$where="";
$tname="tm_users";
$cols="userid,username,usermail,usergrp,rowid";
$colsrc="userid,username";

$opt1=$optgrp;
$opt2="<option value='0'>super</option><option value='2'>creator</option><option value='3'>read only</option><option value='4'>company</option><option value='5'>engineer</option><option value='6'>relok</option><option value='9'>end user</option>";

include 'inc.menu.php';
?>
               
        <div class="main-panel">
          <div class="content-wrapper">
                
					<div class="row">
						<div class="col-md-12">
                <div class="page-header">                    
                    <h3 class="page-title"><?php echo $title;?></h3>
					<a href="#" onclick="openForm(0);" data-toggle="modal" data-target="#modal_large" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Create</a>
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
                                                <th>Name</th>
                                                <th>Mail</th>
												<th>Group</th>
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
									<input type="hidden" id="svt" name="svt" value="">
									<input type="hidden" name="id" id="id" value="0">
									
								<div class="form-group row">
									<label for="userid" class="col-md-3 control-label">ID</label>
									<div class="col-md-9">
										<input type="text" class="form-control form-control-sm input-sm" name="userid" id="userid" placeholder="...">
									</div>
								</div>
								<div class="form-group row">
									<label for="username" class="col-md-3 control-label">Name</label>
									<div class="col-md-9">
										<input type="text" class="form-control form-control-sm input-sm" name="username" id="username" placeholder="...">
									</div>
								</div>
								<div class="form-group row">
									<label for="userlvl" class="col-md-3 control-label">Level</label>
									<div class="col-md-9">
										<select class="form-control form-control-sm" name="userlevel" id="userlevel">
										<?php echo $opt2;?>
										</select>
										<!--input type="text" class="form-control form-control-sm input-sm" name="userlevel" id="userlevel" placeholder="..."-->
									</div>
								</div>
								<div class="form-group row">
									<label for="usergrp" class="col-md-3 control-label">Group</label>
									<div class="col-md-9">
										<select class="form-control form-control-sm" name="usergrp" id="usergrp">
											<option value="">All</option>
											<?php echo $opt1;?>
										</select>
										<!--input type="text" class="form-control form-control-sm input-sm" name="usergrp" id="usergrp" placeholder="..."-->
									</div>
								</div>
								<div class="form-group row">
									<label for="usermail" class="col-md-3 control-label">Mail</label>
									<div class="col-md-9">
										<input type="text" class="form-control form-control-sm input-sm" name="usermail" id="usermail" placeholder="...">
									</div>
								</div>
								<div class="form-group row">
									<label for="userpwd" class="col-md-3 control-label">Password</label>
									<div class="col-md-9">
										<input type="text" class="form-control form-control-sm input-sm" name="userpwd" id="userpwd" placeholder="...">
									</div>
								</div>
								<!--div id="ccp" class="form-group row">
									<label for="cp" class="col-md-3 control-label">Change Password</label>
									<div class="col-md-9">
										<input type="checkbox" value="Y" class="" name="cp" id="cp">
									</div>
								</div-->
							</div>
							</div>
						</form>

                    </div>
                    <div class="modal-footer">
						<button type="button" class="btn btn-success" onclick="if($('#myf').valid()){sendDataFile('#myf','SAVE');}">Save</button>
						<button type="button" class="btn btn-danger" id="bdel" onclick="sendDataFile('#myf','DEL');">Delete</button>
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

