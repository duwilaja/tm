<?php
include 'inc.chksession.php';
include 'inc.common.php';

$title="Rekonsiliasi Report";
$icon="fa fa-file-text";
$menu="-";

include 'inc.head.php';

$where="";
$tname="tm_tickets t left join tm_kanwils k on k.locid=t.k left join tm_ips i on i.oid=t.i and i.layanan=t.st left join tm_problems p on p.probid=t.p";
$cols="ticketno,dt,i,h,d,locname,sid,st,grp,typ,gamas,nossa,blink,p,solving,s,solved,closed,t.lastupd,t.updby,
MY_TIMEDIFF(dt,IF(s='closed',closed,NOW())) as tmd,QUARTER(dt) as twl,
if(TIMESTAMPDIFF(SECOND,dt,IF(s='closed',closed,NOW()))>=86400,'>= 1 hari','< 1 hari') as heri,
if(typ IN $homewidget,'Gangguan','Non Gangguan') as ganggu,
if(s='closed',if(month(dt)=month(closed) and year(dt)=year(closed),'','carry over'),if(month(dt)=month(now()) and year(dt)=year(now()),'','carry over')) as keri,
tpic,tctct,t.rowid";
$colsrc="h,ticketno,nossa,gamas";
$cols="DATE_FORMAT(dt,'%d-%m-%Y %H:%i:%s') as dts,DATE_FORMAT(closed,'%d-%m-%Y %H:%i:%s') as cls,REPLACE(MY_TIMEDIFF(dt,IF(s='closed',closed,NOW())),'d','hari') as tmd,
if(typ IN $homewidget and (TIMESTAMPDIFF(SECOND,dt,IF(s='closed',closed,NOW()))>900 or (nossa<>'' and nossa<>'-')),'Gangguan','Bukan Gangguan') as jns,
nossa,locname,i,'' as area,h,sid,p,solving,st,grping,gamas,typ,
if(TIMESTAMPDIFF(SECOND,dt,IF(s='closed',closed,NOW()))>=86400,'>= 1 hari','< 1 hari') as heri,dayname(dt) as dy,QUARTER(dt) as twl";

$optcus="";$optsla="";$optgrp="";$opttstatus="";$optsubj="";

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
											Active From
										<!--/div>
										<div class="col-md-2"-->
											<div class="input-group">
												<input id="af" name="af" type="text" class="form-control datepicker" placeholder="">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-2">
											To
										<!--/div>
										<div class="col-md-2"-->
											<div class="input-group">
												<input id="at" name="at" type="text" class="form-control datepicker" placeholder="">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-2">
											Created From
										<!--/div>
										<div class="col-md-2"-->
											<div class="input-group">
												<input id="df" name="df" type="text" class="form-control datepicker" placeholder="">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-2">
											To
										<!--/div>
										<div class="col-md-2"-->
											<div class="input-group">
												<input id="dt" name="dt" type="text" class="form-control datepicker" placeholder="">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-2">
											Updated From
										<!--/div>
										<div class="col-md-2"-->
											<div class="input-group">
												<input id="uf" name="uf" type="text" class="form-control datepicker" placeholder="">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-2">
											To
										<!--/div>
										<div class="col-md-2"-->
											<div class="input-group">
												<input id="ut" name="ut" type="text" class="form-control datepicker" placeholder="">
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
							<div class="panel panel-default">
								<div class="panel-body">
									<div class="form-group">
									<div class="col-md-1">
										<select multiple class="form-control selectpicker" name="status" id="status">
										<?php echo $opttstatus?>
										</select>
									</div>
									<div class="col-md-2">
										<select multiple class="form-control selectpicker" name="customer" id="customer">
										<!--option value="">All Kanwil</option-->
										<?php echo $optcus?>
										</select>
									</div>
									<div class="col-md-1">
										<select class="form-control selectpicker" name="grp" id="grp">
										<option value="">All Groups</option>
										<?php echo $optgrp?>
										</select>
									</div>
									<div class="col-md-4">
										<!--select class="form-control" name="pic" id="pic">
										<option value="">All Type</option>
										<?php echo $optsubj?>
										</select-->
										<select multiple class="form-control selectpicker" name="pic[]" id="pic">
										<?php echo $opttyp?>
										</select>
									</div>
									<div class="col-md-2">
										<select class="form-control selectpicker" multiple name="st" id="st">
										<!--option value="">All Service</option-->
										<?php echo $optst?>
										</select>
									</div>
									<div class="col-md-1">
										<select class="form-control selectpicker" name="blink" id="blink">
										<option value="">All Secondary Link</option>
										<?php echo $optblink?>
										</select>
									</div>
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
                                                <th>Open</th>
                                                <th>Close</th>
                                                <th>Duration</th>
												<th>Jenis</th>
												<th>Nossa</th>
                                                <th>Kanwil</th>
                                                <th>Unit</th>
                                                <th>Class</th>
                                                <th>Nama</th>
                                                <th>SID</th>
                                                <th>Penyebab</th>
												<th>Solusi</th>
												<th>Link</th>
												<th>Filtering</th>
                                                <th>Gamas</th>
                                                <th>Laporan</th>
                                                <th>Jml.Hari</th>
												<th>Hari</th>
												<th>Triwulan</th>
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
	dom: 'T<"clear"><lrB<t>ip>',
	lengthMenu: [[10,25,50,100,-1],["10","25","50","100","All"]],
	buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
	searching: false,
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
				d.ms= getMultipleValues("#status"),
				d.mtyp= getMultipleValues("#pic"),
				d.mk= getMultipleValues("#customer"),
				d.grp= $("#grp").val(),
				d.mst= getMultipleValues("#st"),
				d.df= $("#df").val(),
				d.dt= $("#dt").val(),
				d.tdf= $("#uf").val(),
				d.tdt= $("#ut").val(),
				d.adf= $("#af").val(),
				d.adt= $("#at").val(),
				d.blink= $("#blink").val(),
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