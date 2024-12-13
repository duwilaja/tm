<?php
$corona=true;

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
										<div class="col-md-2">
											Type
											<select class="form-control form-control-sm" name="id" id="id" onchange="idchanged(this.value);">
											<?php for($i=0;$i<count($r_templates);$i++){?>
												<option value="<?php echo $r_templates[$i][0]?>"><?php echo $r_templates[$i][1]?></option>
											<?php }?>
											</select>
										</div>
										<div class="col-md-1 viu_all">
											2nd Link
											<select class="form-control form-control-sm viuval" name="blink" id="blink">
												<option value=''>All Secondary Link</option>
												<?php echo $optblink?>
											</select>
										</div>
										<div class="col-md-1 viu viu_5">
											Device
											<select class="form-control form-control-sm viuval" name="jp" id="jp">
												<option value=''>All Device</option>
												<?php echo $optjp?>
											</select>
										</div>
										<div class="col-md-1 viu viu_10">
											Service
											<select class="form-control form-control-sm viuval" name="st" id="st">
												<option value=''>All Services</option>
												<option value='wifi'>Wifi</option>
												<option value='nonwifi'>Non Wifi</option>
											</select>
										</div>
										<div class="col-md-1 viu viu_16">
											Aging
											<select class="form-control form-control-sm viuval" name="age" id="age">
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
												<input id="cdf" name="cdf" type="text" class="form-control form-control-sm datepicker viuval" placeholder="">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-2 viu viu_10">
											Closed To
											<div class="input-group">
												<input id="cdt" name="cdt" type="text" class="form-control form-control-sm datepicker viuval" placeholder="">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-2">
											Created From
											<div class="input-group">
												<input id="df" name="df" type="text" class="form-control form-control-sm datepicker" placeholder="">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-2">
											Created To
											<div class="input-group">
												<input id="dt" name="dt" type="text" class="form-control form-control-sm datepicker" placeholder="">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-2 viu viu_all">
											Updated From
											<div class="input-group">
												<input id="fdf" name="fdf" type="text" class="form-control form-control-sm datepicker viuval" placeholder="">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-2 viu viu_all">
											Updated To
											<div class="input-group">
												<input id="fdt" name="fdt" type="text" class="form-control form-control-sm datepicker viuval" placeholder="">
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
							<div class="card card-default">
								<div class="card-body">
									<div class="form-group row">
									<div class="col-md-2">
										<select class="form-control form-control-sm" name="status" id="status">
										<option value="">All Status</option>
										<?php echo $opttstatus?>
										</select>
									</div>
									<div class="col-md-2">
										<select class="form-control form-control-sm" name="customer" id="customer">
										<option value="">All Kanwil</option>
										<?php echo $optcus?>
										</select>
									</div>
									<div class="col-md-2">
										<select class="form-control form-control-sm" name="grp" id="grp">
										<option value="">All Groups</option>
										<?php echo $optgrp?>
										</select>
									</div>
									<div class="col-md-2">
										<select class="form-control form-control-sm" name="pic" id="pic">
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
          <!-- content-wrapper ends -->

<?php
include 'inc.logout.php';
?>
  
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