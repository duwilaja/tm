<?php
include 'inc.chksession.php';
include 'inc.common.php';

$title="Custom Tickets Report";
$icon="fa fa-file-text";
$menu="-";

include 'inc.head.php';

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
											Type
											<select class="form-control" name="id" id="id" onchange="idchanged(this.value);">
											<?php for($i=0;$i<count($r_templates);$i++){?>
												<option value="<?php echo $r_templates[$i][0]?>"><?php echo $r_templates[$i][1]?></option>
											<?php }?>
											</select>
										</div>
										<div class="col-md-1 viu_all">
											Secondary Link
											<select class="form-control viuval" name="blink" id="blink">
												<option value=''>All Secondary Link</option>
												<?php echo $optblink?>
											</select>
										</div>
										<div class="col-md-1 viu viu_5">
											Device
											<select class="form-control viuval" name="jp" id="jp">
												<option value=''>All Device</option>
												<?php echo $optjp?>
											</select>
										</div>
										<div class="col-md-1 viu viu_10">
											Service
											<select class="form-control viuval" name="st" id="st">
												<option value=''>All Services</option>
												<option value='<?php echo base64_encode(" and st='wifi station'")?>'>Wifi</option>
												<option value='<?php echo base64_encode(" and st<>'wifi station' and 1=1")?>'>Non Wifi</option>
											</select>
										</div>
										<div class="col-md-1 viu viu_16">
											Aging
											<select class="form-control viuval" name="age" id="age">
												<option value=''>None Selected</option>
												<option value='<?php echo base64_encode(" and TIMESTAMPDIFF(HOUR,lastupd,NOW())>=4")?>'>All Aging</option>
												<option value='<?php echo base64_encode(" and TIMESTAMPDIFF(HOUR,lastupd,NOW()) in (4,5)")?>'>4/5 hours</option>
												<option value='<?php echo base64_encode(" and (TIMESTAMPDIFF(HOUR,lastupd,NOW()) in (6,7))")?>'>6/7 hours</option>
												<option value='<?php echo base64_encode(" and (TIMESTAMPDIFF(HOUR,lastupd,NOW()) between 8 and 23)")?>'>8-23 hours</option>
												<option value='<?php echo base64_encode(" and (TIMESTAMPDIFF(HOUR,lastupd,NOW())>=24)")?>'>>=24 hours</option>
												
											</select>
										</div>
										<div class="col-md-2 viu viu_10">
											Closed From
											<div class="input-group">
												<input id="cdf" name="cdf" type="text" class="form-control datepicker viuval" placeholder="">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-2 viu viu_10">
											Closed To
											<div class="input-group">
												<input id="cdt" name="cdt" type="text" class="form-control datepicker viuval" placeholder="">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-2">
											Created From
											<div class="input-group">
												<input id="df" name="df" type="text" class="form-control datepicker" placeholder="">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-2">
											Created To
											<div class="input-group">
												<input id="dt" name="dt" type="text" class="form-control datepicker" placeholder="">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-2 viu viu_all">
											Updated From
											<div class="input-group">
												<input id="fdf" name="fdf" type="text" class="form-control datepicker viuval" placeholder="">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-2 viu viu_all">
											Updated To
											<div class="input-group">
												<input id="fdt" name="fdt" type="text" class="form-control datepicker viuval" placeholder="">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-1">&nbsp;
											<button onclick="runReport();" class="btn btn-info"><i class="fa fa-search"></i> Submit</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
                    <div class="row" style="display:none;">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-body">
									<div class="form-group">
									<div class="col-md-2">
										<select class="form-control" name="status" id="status">
										<option value="">All Status</option>
										<?php echo $opttstatus?>
										</select>
									</div>
									<div class="col-md-2">
										<select class="form-control" name="customer" id="customer">
										<option value="">All Kanwil</option>
										<?php echo $optcus?>
										</select>
									</div>
									<div class="col-md-2">
										<select class="form-control" name="grp" id="grp">
										<option value="">All Groups</option>
										<?php echo $optgrp?>
										</select>
									</div>
									<div class="col-md-2">
										<select class="form-control" name="pic" id="pic">
										<option value="">All Type</option>
										<?php echo $optsubj?>
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
	function runReport(){
		var id=$("#id").val();
		var blink=$("#blink").val();
		var jp=$("#jp").val();
		var age=$("#age").val();
		var df=$("#df").val();
		var dt=$("#dt").val();
		var fdf=$("#fdf").val();
		var fdt=$("#fdt").val();
		var cdf=$("#cdf").val();
		var cdt=$("#cdt").val();
		var st=$("#st").val();
		
		var lnk = "r_templates.php?id="+id+"&blink="+blink+"&jp="+jp+"&st="+st+"&age="+age+"&df="+df+"&dt="+dt+"&fdf="+fdf+"&fdt="+fdt+"&cdf="+cdf+"&cdt="+cdt;
		$.fancybox.open({
			type: 'iframe',
			src: lnk
		});
	}
	function idchanged(tv=''){
		$('.viuval').val('');
		$('.viu').hide();
		$('.viu_all').show();
		$('.viu_'+tv).show();
		if(tv=='16'||tv=='10') $('.viu_all').hide();
		//console.log(tv);
	}
	idchanged();
</script>
    </body>
</html>