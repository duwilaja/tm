<?php
$corona=true;

include 'inc.chksession.php';
include 'inc.common.php';

$title="Outlets";
$icon="fa fa-file-text";
$menu="-";

include 'inc.head.php';

$where="";
$tname="tm_outlets";
$cols="oid,oname,addr,cabang,kanwil,area,propinsi,pic,contact,pic2,contact2,lnk,wibstart,wibend,lat,lng,buprovider,bupe,buce,busid,bubw,addr,svcs,wifi,rowid";
$colsrc="oid,oname,cabang,kanwil,area,lnk,propinsi";

$opt1="";

include "inc.db.php";
$conn=connect();
$rs=exec_qry($conn,"select locid,locname from tm_kanwils order by locname");
while($row=fetch_row($rs)){
	$opt1.='<option value="'.$row[0].'">'.$row[1].'</option>';
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
                                <div class="card-body table-responsive">
                                    <table id="example" class="table table-dark">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
												<th>Address</th>
												<th>Cabang</th>
												<th>Kanwil</th>
												<th>Area</th>
												<th>Propinsi</th>
												<th>PIC1</th>
												<th>Contact1</th>
												<th>PIC2</th>
												<th>Contact2</th>
												<th>Main Link</th>
												<th>Start(WIB)</th>
												<th>End(WIB)</th>
												<th>Lat</th>
												<th>Lng</th>
												<th>Backup</th>
												<th>BU PE</th>
												<th>BU CE</th>
												<th>BU SID</th>
												<th>BU Bandwidth</th>
												<th>Address</th>
												<th>Services</th>
												<th>WiFi</th>
												
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

