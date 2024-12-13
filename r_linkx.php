<?php
$corona=true;

include 'inc.chksession.php';
include 'inc.common.php';

$title="Data Link";
$icon="fa fa-file-text";
$menu="-";

include 'inc.head.php';

$where="";
$tname="tm_outlets o left join tm_ips i on i.oid=o.oid";
$cols="o.oid,oname,kanwil,layanan,bubw,boq,o.rowid";
$colsrc="o.oid,oname,kanwil";

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
									<!--div class="col-md-2">
										<select class="form-control form-control-sm" name="k" id="k">
										<option value="">All Kanwil</option>
										<?php echo $optcus?>
										</select>
									</div>
									<div class="col-md-2">
										<select class="form-control form-control-sm" name="area" id="area">
										<option value="">All Area</option>
										<?php echo $optarea?>
										</select>
									</div-->
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
                                                <th>Outlet ID</th>
												<th>Name</th>
												<th>Kanwil</th>
												<th>Link</th>
												<th>BW</th>
												<th>BOQ</th>
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
	order: [[ 0, "asc" ]],
		ajax: {
			type: 'POST',
			url: 'dataget.php',
			data: function (d) {
				d.cols= '<?php echo base64_encode($cols); ?>',
				d.tname= '<?php echo base64_encode($tname); ?>',
				d.csrc= '<?php echo $colsrc; ?>',
				d.where= getWhere(),
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
	
	$(".selectpicker").select2();
	
});

function tblupdate(){
	mytbl.ajax.reload();
}

function getWhere(){
	var s=getMultipleValues('#st');
	if(s!='') return btoa("layanan <> 'router/switch/ip-phn' and layanan in ("+s+")");
	
	return btoa("layanan <> 'router/switch/ip-phn'");
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
	
    </body>
</html>

