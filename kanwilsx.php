<?php
$corona=true;

include 'inc.chksession.php';
include 'inc.common.php';

$title="Kanwil";
$icon="fa fa-map-o";
$menu="kanwil";

include 'inc.head.php';

$where="";
$tname="tm_kanwils";
$cols="locid,locname,rowid";
$colsrc="locname";

$opt1="";

include 'inc.menu.php';
?>
                
        <div class="main-panel">
          <div class="content-wrapper">
			
					<div class="row">
						<div class="col-md-12">
						
                <div class="card">
                  <div class="card-body">
                    <div class="card-title">
						<span><h4>Kanwil</h4></span>
						<a href="#" onclick="openForm(0);" data-toggle="modal" data-target="#modal_large" class="btn btn-info pull-right"><i class="mdi mdi-plus"></i> Create</a>
					</div>
                    <p class="card-description hidden"> Add class <code>.table-dark</code>
                    </p>
                    <div class="table-responsive">
                                    <table id="example" class="table table-dark">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
												
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
			
          </div>
          <!-- content-wrapper ends -->
		
		<div class="modal" id="modal_large" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="largeModalHead" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="largeModalHead"><b><i class="fa <?php echo $icon;?>"></i> <?php echo $title;?></b></h4>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </div>
					<div class="">
					
						<form class="form-horizontal" id="myf">
                            <div class="panel panel-default">
							<div class="panel-body">
									<input type="hidden" name="t" value="<?php echo $menu;?>">
									<input type="hidden" name="tname" value="<?php echo $tname;?>">
									<input type="hidden" name="columns" value="locid,locname">
									<input type="hidden" id="svt" name="svt" value="">
									<input type="hidden" name="id" id="id" value="0">
									
								<div class="form-group row">
									<label class="col-md-2 control-label">ID</label>
									<div class="col-md-10">
										<input type="text" class="form-control form-control-sm" name="locid" id="locid" placeholder="...">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-2 control-label">Name</label>
									<div class="col-md-10">
										<input type="text" class="form-control form-control-sm" name="locname" id="locname" placeholder="...">
									</div>
								</div>
								
							</div>
							<div class="panel-body" id="pesan"></div>
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
        "locid" : {
            required : true
        },
		"locname" : {
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

