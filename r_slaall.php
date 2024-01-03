<?php
include 'inc.chksession.php';
include 'inc.common.php';

$title="SLA";
$icon="fa fa-file-text";
$menu="rslaall";

include 'inc.head.php';

$where="grp='link' and typ in (!typ!) and 
(p<>'link normal' or (p='link normal' and TIMESTAMPDIFF(MINUTE,t.dt,solved)>=30))";

$where="typ in (!typ!) and (TIMESTAMPDIFF(SECOND,t.dt,IF(s='closed',closed,NOW()))>900 or (nossa<>'' and nossa<>'-'))";

$where = "$gangguan";

//$where="grp='link' and typ in (!typ!)";
$tname="tm_tickets t left join tm_outlets o on t.i=o.oid left join tm_sla_daily d on d.tiket=t.ticketno";
$cols="st,i,k,area,cabang,h,";
$colsrc="";
$grpby="st,i,k,area,cabang,h,tt";

$optcus="";$optsla="";$optgrp="";$opttstatus="";$optsubj="";$optarea="";

include 'inc.db.php';
$conn=connect();
$rs=exec_qry($conn,"select locid,locname from tm_kanwils order by locname");
while($row=fetch_row($rs)){
	$optcus.='<option value="'.$row[0].'">'.$row[1].'</option>';
}
$rs=exec_qry($conn,"select distinct grp from tm_tickets");
while($row=fetch_row($rs)){
	$optgrp.='<option value="'.$row[0].'">'.$row[0].'</option>';
}
$rs=exec_qry($conn,"select distinct s from tm_tickets");
while($row=fetch_row($rs)){
	$opttstatus.='<option value="'.$row[0].'">'.$row[0].'</option>';
}
$rs=exec_qry($conn,"select distinct typ from tm_tickets");
while($row=fetch_row($rs)){
	$optsubj.='<option value="'.$row[0].'">'.$row[0].'</option>';
}
$rs=exec_qry($conn,"select distinct area from tm_outlets");
while($row=fetch_row($rs)){
	$optarea.='<option value="'.$row[0].'">'.$row[0].'</option>';
}

disconnect($conn);
?>
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
<?php
include 'inc.menu.php';
?>
                
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="home.php">Home</a></li>
                    <li class="active"><?php echo $title;?></li>
                </ul>
                <!-- END BREADCRUMB -->                
                
                <div class="page-title">                    
                    <h2><span class="<?php echo $icon;?>"></span> <?php echo $title;?></h2>
					<!--a href="#" onclick="openForm(0);" data-toggle="modal" data-target="#modal_large" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Create</a>
                --></div>                   
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-body">
									<div class="form-group">
										<div class="col-md-2">
											<select class="form-control" name="cols" id="cols">
											<option value="<?php echo base64_encode("$cols (24*60*60) as tt, SUM(dur) as td")?>">24 Hour</option>
											<!--option value="<?php echo base64_encode("$cols (12*60*60) as tt, SUM(durwh) as tdwh")?>">12 Hour</option-->
											<option value="<?php echo base64_encode("$cols (6.5*60*60) as tt, SUM(durwib) as tdwib")?>">Operation Hour</option>
											</select>
										</div>
										<div class="col-md-1 hidden">
											From
										</div>
										<div class="col-md-2 hidden">
											<div class="input-group">
												<input id="df" name="df" type="text" class="form-control datepicker" placeholder="" value="<?php echo date('Y-m-d')?>">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-1 hidden">
											To
										</div>
										<div class="col-md-2 hidden">
											<div class="input-group">
												<input id="dt" name="dt" type="text" class="form-control datepicker" placeholder="" value="<?php echo date('Y-m-d')?>">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-2">
											<select class="form-control" name="bln" id="bln">
											<?php for($i=1;$i<13;$i++){?>
											<option value="<?php echo ($i<10)?"0$i":$i?>"><?php echo date('F', mktime(0, 0, 0, $i, 10)) ?></option>
											<?php }?>
											</select>
										</div>
										<div class="col-md-2">
											<select class="form-control" name="thn" id="thn">
											<?php $y=date("Y");
											for($i=$y;$i>($y-2);$i--){?>
											<option value="<?php echo $i?>"><?php echo $i ?></option>
											<?php }?>
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
							<div class="panel panel-default">
								<div class="panel-body">
									<div class="form-group">
									<div class="col-md-2">
										<select class="form-control" name="k" id="k">
										<option value="">All Kanwil</option>
										<?php echo $optcus?>
										</select>
									</div>
									<div class="col-md-2">
										<select class="form-control" name="area" id="area">
										<option value="">All Area</option>
										<?php echo $optarea?>
										</select>
									</div>
									<!--div class="col-md-2">
										<select class="form-control" name="grp" id="grp">
										<option value="">All Groups</option>
										<?php echo $optgrp?>
										</select>
									</div-->
									<div class="col-md-2 hidden">
										<select class="form-control" name="typ" id="typ">
										<option value="'offline','keluhan lambat','link up-down','link intermitten'">All Type</option>
										<option value="'offline'">Offline</option>
										<option value="'keluhan lambat'">Keluhan Lambat</option>
										<option value="'link up-down'">Link Up-Down</option>
										<option value="'link intermitten'">Link Intermitten</option>
										</select>
									</div>
									<div class="col-md-2">
										<select class="form-control selectpicker" name="st" id="st" multiple>
										<!--option value="">All Service</option-->
										<?php echo $optst?>
										</select>
									</div>
									<!--div class="col-md-2">
										<select class="form-control" name="durasi" id="durasi">
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
                            <div class="panel panel-default">
                                <div class="panel-body table-responsive">
                                    <table id="example" class="table">
                                        <thead>
                                            <tr>
                                                <th>Layanan</th>
                                                <th>Unit ID</th>
                                                <th>Kanwil</th>
                                                <th>Area</th>
                                                <th>Cabang</th>
                                                <th>Unit</th>
                                                <th>Durasi</th>
                                                <th>Restitusi</th>
                                                <th>SLA Tercapai</th>
												<!--th>Gangguan</th>
												<th>Durasi</th-->
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
                <!-- PAGE CONTENT WRAPPER -->                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

<?php
include 'inc.logout.php';
?>

    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>        
        <script type="text/javascript" src="js/jquery.fancybox.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css" media="screen" />
		<!-- END PLUGINS -->

        <!-- THIS PAGE PLUGINS -->
        <script type='text/javascript' src='js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>

        <script type="text/javascript" src="js/plugins/morris/raphael-min.js"></script>
		<script type="text/javascript" src="js/plugins/morris/morris.min.js"></script>
        
		<script type="text/javascript" src="js/plugins/datatables/jquery.dataTables.min.js"></script>    
        <script type='text/javascript' src='js/plugins/jquery-validation/jquery.validate.js'></script>
		<script type="text/javascript" src="js/plugins/bootstrap/bootstrap-datepicker.js"></script>
		<script type="text/javascript" src="js/plugins/bootstrap/bootstrap-select.js"></script>
		
		<script src="js/plugins/datatables/dataTables.buttons.js"></script>
		<script src="js/plugins/datatables/buttons.flash.js"></script>
		<script src="js/plugins/datatables/jszip.min.js"></script>
		<script src="js/plugins/datatables/pdfmake.min.js"></script>
		<script src="js/plugins/datatables/vfs_fonts.js"></script>
		<script src="js/plugins/datatables/buttons.html5.js"></script>
		<script src="js/plugins/datatables/buttons.print.js"></script>

		<link rel="stylesheet" href="js/plugins/datatables/buttons.dataTables.css">
		<!-- END PAGE PLUGINS -->

        <!-- START TEMPLATE >
        <script type="text/javascript" src="js/settings.js"></script-->
        
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>        
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->         
	
	<script>
	var mytbl, jvalidate;
$(document).ready(function() {
	mytbl = $('#example').DataTable({
	dom: 'lrfB<t>ip',
	lengthMenu: [[10,25,50,100,-1],["10","25","50","100","All"]],
	buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
	searching: true,
	serverSide: false,
	processing: true,
	ordering: true,
	order: [[ 0, "asc" ]],
		ajax: {
			type: 'POST',
			url: 'datagetonce_sla.php',
			data: function (d) {
				d.cols= $("#cols").val(),//'<?php echo base64_encode($cols); ?>',
				d.tname= '<?php echo base64_encode($tname); ?>',
				d.csrc= '<?php echo $colsrc; ?>',
				d.where= '<?php echo base64_encode($where);?>',
				d.grpby= '<?php echo base64_encode($grpby);?>',
				d.area= $("#area").val(),
				d.typ= $("#typ").val(),
				d.k= $("#k").val(),
				d.durasi= '',//$("#durasi").val(),
				d.mst= getMultipleValues("#st"),
				d.df= $("#df").val(),
				d.dt= $("#dt").val(),
				d.bln= $("#bln").val(),
				d.thn= $("#thn").val(),
				d.x= '<?php echo $menu; ?>';
			}
		}
	});
	jvalidate = $("#myf").validate({
    rules :{
        "customer" : {
            required : true
        },
		"reason" : {
            required : function(element) {
						if ($("#status").val() == "QO") {
							return true;
						}
						else {
							return false;
						}
					}
        }
    }});
	
	$(".selectpicker").selectpicker();
	
	//runChart();
});

function tblupdate(){
	mytbl.ajax.reload();
}

function oclick(c,v){
	if($(c)[0].checked){
		$(v).val('Y');
	}else{
		$(v).val('');
	}
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


<?php //include "r_tickets.incc.php";?>
	
    </body>
</html>