<?php
$corona=true;

include 'inc.chksession.php';
include 'inc.common.php';

$title="Outlets Transactions";
$icon="fa fa-file-text";
$menu="-";

include 'inc.head.php';

$where="typ in $homewidget";
$tname="tm_tickets t left join tm_otrans_h o on o.oid=t.i and date(o.lastupd)=date(dt)";
$cols="ticketno,dt,i,h,d,st,s,MY_TIMEDIFF(dt,NOW()) as tmd,ttrans,MAX(lasttrans) as maxlt,o.lastupd";
$cols="ticketno,dt,i,h,d,st,s,nossa,MY_TIMEDIFF(dt,if(s<>'closed',NOW(),closed)) as tmd,if(ttrans is null,0,ttrans) as ttr,if(lasttrans is null,'N/A',lasttrans) as lst,if(o.lastupd is null,'N/A',o.lastupd) as lupd";
$colsrc="h,i,st";
$grpby="ticketno,dt,i,h,d,st,s,tmd,o.lastupd,nossa";
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
                    
                    <div class="row">
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
                                                <th>ID</th>
                                                <th>Date</th>
												<th>Unit ID</th>
												<th>Name</th>
												<th>Detail</th>
												<th>Service</th>
												<th>Status</th>
												<th>NOSSA</th>
												<th>Duration</th>
												<th>Transaction</th>
												<th>Latest</th>
												<th>@</th>
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
	order: [[ 0, "desc" ]],
		ajax: {
			type: 'POST',
			url: 'dataget.php',
			data: function (d) {
				d.cols= '<?php echo base64_encode($cols); ?>',
				d.tname= '<?php echo base64_encode($tname); ?>',
				d.csrc= '<?php echo $colsrc; ?>',
				d.where= '<?php echo base64_encode($where);?>',
				d.grpby= '<?php echo base64_encode($grpby);?>',
				d.df=$("#df").val(),
				d.dt=$("#dt").val(),
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
