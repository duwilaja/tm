<?php
$corona=true;

include 'inc.chksession.php';
include 'inc.common.php';

$title="M2M";
$icon="fa fa-file-text";
$menu="rm2m";

include 'inc.head.php';

$where="";
$tname="tm_m2ms m left join tm_outlets o on o.oid=m.oid left join tm_outlets o2 on o2.oid=m.oidx";
$cols="notel,iptel,sn,m.oid,o.oname as oname1,o.kanwil,stts,guna,jenis,oidx,o2.oname as oname2,ticketno,m.rowid";
$colsrc="notel,iptel,m.oid,o.oname,o2.oname";

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

