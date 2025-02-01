<?php
$corona=true;

include 'inc.chksession.php';
include 'inc.common.php';

//0:master 3:readonly 4:pgd 5:engineer

$title="Ticket";
$icon="fa fa-ticket";
$menu="tickets";

include 'inc.head.php';

$pic=isset($_GET['pic'])?$_GET['pic']:"";
$g=isset($_GET['grp'])?$_GET['grp']:"";
$a=isset($_GET['a'])?$_GET['a']:"";
$s=isset($_GET['s'])?$_GET['s']:"";
$tsrc=isset($_GET['tsrc'])?$_GET['tsrc']:"";

$titles=$title;
$titles=isset($_GET['grp'])?"My Group ".$title:$titles;
$titles=isset($_GET['pic'])?"Open ".$title:$titles;
$titles=$a!=""?"Overdue ".$title:$titles;
$titles=substr($s,0,2)=="30"?"Last 30days ".$title:$titles;
$titles=substr($s,0,2)=="rm"?"Jarkom ".$title:$titles;
$titles=substr($s,0,2)=="re"?"Relokasi ".$title:$titles;
$titles=substr($s,0,2)=="mi"?"Migrasi Link ".$title:$titles;
$titles=substr($s,0,2)=="mj"?"Migrasi Jarkom ".$title:$titles;
$titles=substr($s,0,2)=="td"?"Last 24hr ".$title:$titles;
$titles=$title==$titles?"All ".$title:$titles;

$titles.=$s!=""?" ".substr($s,2):"";

$shift="(k in (select kanwil from tm_kanwilusers where user='$s_ID') or '$s_ID' in (select uid from tm_shifts where dt=date(NOW())))";

$where=" 1=1 ";
$where.=$s_LVL==4 && $g!=""?" and $shift":""; //my group
if($s_LVL==5){
	$where.=" and grp like '%$s_GRP%'"; //engineer
}
if($s_LVL==6){
	$where.=" and typ='relokasi'"; //engineer
}

//Open
$where.=$a!=""?" and o='1'":""; //alerted
$where.=$pic!="" && ($s_LVL==0 || $s_LVL==3)?" and s<>'closed'":""; //master
$where.=$pic!="" && $s_LVL==4?" and s='solved' and $shift":""; //officer
$where.=$pic!="" && ($s_LVL==5||$s_LVL==6)?" and s in ('new','open','pending')":""; //engineer

$para=true;
//from home
if(substr($s,0,2)=="30"){
	$para=false;
	//if(substr($s,2)=='open'){
	//$where.=$s!=""?" and grp='link' and s in ('open','new') and typ in $homewidget and datediff(date(now()),date(dt))<=30":"";
	//}else{
	$where.=$s!=""?" and grp='link' and s like '%".substr($s,2)."%' and typ in $homewidget and datediff(date(now()),date(dt))<=30":"";
	//}
}
if(substr($s,0,2)=="rm"){
	$para=false;
	if(substr($s,2)=='open'){
	$where.=$s!=""?" and s in ('open','new') and grp='jarkom'":"";
	}else{
	$where.=$s!=""?" and s like '%".substr($s,2)."%' and grp='jarkom'":"";
	}
}
if(substr($s,0,2)=="re"){
	$para=false;
	if(substr($s,2)=='open'){
	$where.=$s!=""?" and s in ('open','new') and typ = 'relokasi'":"";
	}else{
	$where.=$s!=""?" and s like '%".substr($s,2)."%' and typ = 'relokasi'":"";
	}
}
if(substr($s,0,2)=="mi"){
	$para=false;
	if(substr($s,2)=='open'){
	$where.=$s!=""?" and s in ('open','new') and typ = 'migrasi' and grp='link'":"";
	}else{
	$where.=$s!=""?" and s like '%".substr($s,2)."%' and typ = 'migrasi' and grp='link'":"";
	}
}
if(substr($s,0,2)=="mj"){
	$para=false;
	if(substr($s,2)=='open'){
	$where.=$s!=""?" and s in ('open','new') and typ = 'migrasi' and grp='jarkom'":"";
	}else{
	$where.=$s!=""?" and s like '%".substr($s,2)."%' and typ = 'migrasi' and grp='jarkom'":"";
	}
}
if(substr($s,0,2)=="td"){
	$para=false;
	if(substr($s,2)=='open'){
	$where.=$s!=""?" and s in ('open','new') and timestampdiff(hour,dt,now())<=24 and (grp='link' or st='xxx') and typ in $homewidget":"";
	}else{
	$where.=$s!=""?" and s like '%".substr($s,2)."%' and timestampdiff(hour,dt,now())<=24 and (grp='link' or st='xxx') and typ in $homewidget":"";
	}
}

$swhere=" and s<>'closed' and (grp='link' or st='xxx') and typ in $homewidget ";

if(substr($s,0,2)=="02"){
	$para=false;
	$titles.=" (2hr+)";
	$where.="$swhere and timestampdiff(minute,dt,now())>=(2*60) and timestampdiff(minute,dt,now())<(4*60)";
}
if(substr($s,0,2)=="04"){
	$para=false;
	$titles.=" (4hr+)";
	$where.="$swhere and timestampdiff(minute,dt,now())>=(4*60) and timestampdiff(minute,dt,now())<(6*60)";
}
if(substr($s,0,2)=="06"){
	$para=false;
	$titles.=" (6hr+)";
	$where.="$swhere and timestampdiff(minute,dt,now())>=(6*60) and timestampdiff(minute,dt,now())<(8*60)";
}
if(substr($s,0,2)=="08"){
	$para=false;
	$titles.=" (8hr+)";
	$where.="$swhere and timestampdiff(minute,dt,now())>=(8*60) and timestampdiff(minute,dt,now())<(12*60)";
}
if(substr($s,0,2)=="12"){
	$para=false;
	$titles.=" (12hr+)";
	$where.="$swhere and timestampdiff(minute,dt,now())>=(12*60) and timestampdiff(minute,dt,now())<(24*60)";
}
if(substr($s,0,2)=="24"){
	$para=false;
	$titles.=" (24hr+)";
	$where.="$swhere and timestampdiff(minute,dt,now())>=(24*60)";
}
//echo "aaaaaa".$where;

$tname="tm_tickets";
$tnames="tm_tickets t left join tm_kanwils k on k.locid=t.k";
$cols="ticketno,dt,i,h,d,locname,grp,typ,st,s,blink,nossa,p,t.lastupd,t.updby,t.rowid";
$colsrc="h,d";
$srceq="ticketno,i";

$opt1="<option value=''></option>";$opt2="<option value=''></option>";$opt3="";

include 'inc.db.php';
$conn=connect();
$rs=exec_qry($conn,"select locid,locname from tm_kanwils order by locname");
while($row=fetch_row($rs)){
	$opt1.='<option value="'.$row[0].'">'.$row[1].'</option>';
	$opt3.='<option value="'.$row[0].'">'.$row[1].'</option>';
}
$rs=exec_qry($conn,"select probid,probname from tm_problems order by probname");
while($row=fetch_row($rs)){
	$opt2.='<option value="'.$row[0].'">'.$row[1].'</option>';
}
disconnect($conn);


$dis="disabled";
if(($s_GRP==""&&$s_LVL=="0")||$s_LVL>4||$g=="1"){
	$dis="";
}
$vis='style="display:none;"';
if($s_GRP==""||$s_GRP=="jarkom"){
	$vis="";
}
$optdis="";
if($s_LVL==5||$s_LVL==6){
	$optdis="disabled";
}

include 'inc.menu.php';
?>                
                
        <div class="main-panel">
          <div class="content-wrapper">
			<div class="page-header">
              <h3 class="page-title"> <?php echo $titles;?> </h3>
              <!--nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Forms</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Form elements</li>
                </ol>
              </nav-->
			  <div>
	<?php if($para){?>
				<?php if($s_GRP==""&&($s_LVL==0||$s_LVL==4||$s_LVL==2)&&$s==''){?>
					<a href="#" onclick="" data-toggle="modal" data-target="#modal_banyak" class="btn btn-warning pull-right"><i class="mdi mdi-checkbox-multiple-marked-circle"></i> Mass</a>
					<a href="#" onclick="$('#yakin').val('');$('#notes').html('');clearAuto();openForm(0);" data-toggle="modal" data-target="#modal_large" class="btn btn-info pull-right"><i class="mdi mdi-plus"></i> Create</a>
					<?php if($s_LVL==0&&$s_GRP==""){?>
					<a class="btn btn-danger pull-right" href="JavaScript:;" data-fancybox data-type="iframe" data-src="md_bi.php"><i class="mdi mdi-cloud-upload"></i> Batch</a>
				<?php }}?>
	<?php }else{?>
				<button class="btn btn-info pull-right" onclick="tblupdate()"><i class="mdi mdi-refresh"></i> Refresh</button>	
	<?php }?>
				</div>
            </div>
                                    
	<?php if($para){?>
					<div class="row">
						<div class="col-md-12">
							<div class="card card-default">
								<div class="card-body">
									<div class="form-group row">
										<div class="col-md-1">
											From
										</div>
										<div class="col-md-2">
											<div class="input-group">
												<input id="fdf" name="fdf" type="text" class="form-control form-control-sm datepicker" placeholder="">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-1">
											To
										</div>
										<div class="col-md-2">
											<div class="input-group">
												<input id="fdt" name="fdt" type="text" class="form-control form-control-sm datepicker" placeholder="">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
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
                            <div class="card card-default">
                                <div class="card-body"  style="padding-right: 0px;">
								<div class="form-group row">
									<div class="col-md-2 control-label">Kanwil<!--/div>
									<div class="col-md-2"-->
										<select multiple class="form-control form-control-sm selectpicker" id="fk">
										<?php echo $opt3?>
										</select>
									</div>
									<div class="col-md-2 control-label">Status<!--/div>
									<div class="col-md-1"-->
										<select multiple id="fs" class="form-control form-control-sm selectpicker">
										<option value="new">new</option>
										<option value="open">open</option>
										<option value="progress">progress</option>
										<option value="pending">pending</option>
										<option value="solved">solved</option>
										<option value="closed">closed</option>
										</select>
									</div>
									<div class="col-md-2 control-label">Jenis Layanan<!--/div>
									<div class="col-md-2"-->
										<select multiple class="form-control form-control-sm selectpicker" id="fst">
										<?php echo $optst?>
										</select>
									</div>
									<div class="col-md-3 control-label">Jenis Gangguan<!--/div>
									<div class="col-md-2"-->
										<select multiple class="form-control form-control-sm selectpicker" id="ftyp">
										<?php echo $opttyp?>
										</select>
									</div>
									<div class="col-md-2 control-label">Group<!--/div>
									<div class="col-md-1"-->
										<select multiple class="form-control form-control-sm selectpicker" id="fgrp">
										<?php echo $optgrp?>
										</select>
									</div>
									
									<div class="col-md-1"><br />
										<button type="button" class="btn btn-info " onclick="tblupdate();"><i class="mdi mdi-refresh"></i></button>
									</div>
									
								</div>
								</div>
							</div>
						</div>
					</div>
	<?php }?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
								<div class="card-body">
									<div class="table-responsive">
                                    <table id="example" class="table table-dark">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Date</th>
                                                <th>Unit</th>
                                                <th>Subject</th>
                                                <th>Detail</th>
                                                <th>Kanwil</th>
                                                <th>Group</th>
                                                <th>Gangguan</th>
												<th>Layanan</th>
                                                <th>Status</th>
                                                <th>Sec.Link</th>
												<th>Nossa</th>
												<th>Result</th>
												<th>Last Update</th>
                                                <th>Updated By</th>
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
		
		<div class="modal" id="modal_banyak" tabindex="-3" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="smallModalHead"><b><i class="fa <?php echo $icon;?>"></i> Mass <?php echo $title;?></b></h4>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </div>
                    <div class="">
                        <form class="form-horizontal" id="myfx">
                            <div class="card card-default">
							<div class="card-body">
									<input type="hidden" name="t" value="mass<?php echo $menu;?>">
									<input type="hidden" name="tname" value="<?php echo $tname;?>">
									<input type="hidden" name="columns" value="h,d,k,typ,i,st,grp">
									<input type="hidden" id="svt" name="svt" value="">
									<input type="hidden" name="id" id="id" value="0">
								<div class="form-group row">
									<label class="col-md-2 control-label">Ticket No</label>
									<div class="col-md-4">
										<input disabled type="text" class="form-control form-control-sm input-sm" name="ticketno" id="ticketno" placeholder="auto">
									</div>
									<label class="col-md-2 control-label">Created By</label>
									<div class="col-md-4">
										<input disabled type="text" class="form-control form-control-sm input-sm" name="createdby" id="createdby" placeholder="auto">
									</div>
									
								</div>
								<div class="form-group row">
									<label class="col-md-2 control-label">Created Date/Time</label>
									<div class="col-md-4">
										<div class="input-group">
                                            <input disabled id="dtm" name="dtm" type="text" class="form-control form-control-sm" placeholder="auto">
											<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div>
									<label class="col-md-2 control-label">Report Date/Time</label>
									<div class="col-md-4">
										<div class="input-group">
                                            <input id="dtx" name="dt" type="text" class="form-control form-control-sm" placeholder="<?php echo date('Y-m-d H:i')?>">
											<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div>
									
								</div>
								<div class="form-group row">
									<label class="col-md-2 control-label">ID/Area</label>
									<div class="col-md-4">
										<div class="input-group">
										<input type="text" class="form-control form-control-sm input-sm" name="iarea" id="iarea" placeholder="...">
										<span onclick="getOutletx();" class="input-group-addon add-on"><i class="fa fa-refresh"></i></span>
										</div>
									</div>
									<label class="col-md-2 control-label">Detail</label>
									<div class="col-md-4">
										<textarea class="form-control form-control-sm input-sm" name="d" id="dx" placeholder="..."></textarea>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-2 control-label">Jenis Layanan</label>
									<div class="col-md-10">
										<select multiple class="form-control form-control-sm selectpicker" name="st[]" id="stx">
										<?php echo $optst?>
										</select>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-2 control-label">Jenis Gangguan</label>
									<div class="col-md-3">
										<select class="form-control form-control-sm" name="typ" id="typx" style="-webkit-appearance: menulist;">
										<?php echo $opttyp?>
										</select>
									</div>
									<label class="col-md-2 control-label">Outlet(s)</label>
									<div class="col-md-5">
										<textarea readonly class="form-control form-control-sm input-sm" name="outletx" id="outletx" placeholder="auto"></textarea>
										<textarea style="display:none;" readonly class="form-control form-control-sm input-sm" name="outlet" id="outlet" placeholder="auto"></textarea>
									</div>								
								</div>
							</div>
							</div>
						</form>
                    </div>
                    <div class="modal-footer">
						<button type="button" class="btn btn-success" onclick="sendForm();">Submit</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>  
                    </div>
                </div>
            </div>
        </div>
		
		<div class="modal" id="modal_large" tabindex="-2" role="dialog" aria-labelledby="largeModalHead" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-lg" style="margin-top: 1px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="largeModalHead"><b><i class="fa <?php echo $icon;?>"></i> <?php echo $title;?></b></h4>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </div>
					<div class="">
					
						    <div class="card card-default">
							<div class="card-body">
								<form class="form-horizontal" id="myf">
                        			<input type="hidden" name="t" value="<?php echo $menu;?>">
									<input type="hidden" name="tname" value="<?php echo $tname;?>">
									<input type="hidden" name="columns" value="h,d,k,typ,i,st,grp">
									<input type="hidden" id="svt" name="svt" value="">
									<input type="hidden" name="id" id="id" value="0">
									
									<input type="hidden" name="k" id="k" />
									<input type="hidden" id="lnk" name="lnk">
									<input type="hidden" id="yakin" name="yakin" value="">
								
								<div class="form-group row">
									<label class="col-md-2 control-label">Ticket No</label>
									<div class="col-md-4">
										<input disabled type="text" class="form-control form-control-sm input-sm" name="ticketno" id="ticketno" placeholder="auto">
									</div>
									<label class="col-md-2 control-label">Created By</label>
									<div class="col-md-4">
										<input disabled type="text" class="form-control form-control-sm input-sm" name="createdby" id="createdby" placeholder="auto">
									</div>
									
								</div>
								<div class="form-group row">
									<label class="col-md-2 control-label">Created Date/Time</label>
									<div class="col-md-4">
										<div class="input-group">
                                            <input disabled id="dtm" name="dtm" type="text" class="form-control form-control-sm" placeholder="auto">
											<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div>
									<label class="col-md-2 control-label">Report Date/Time</label>
									<div class="col-md-4">
										<div class="input-group">
                                            <input id="dt" name="dt" type="text" class="form-control form-control-sm" placeholder="<?php echo date('Y-m-d H:i')?>">
											<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div>
									
								</div>
								<div class="form-group row">
									<label class="col-md-2 control-label">Unit ID</label>
									<div class="col-md-4">
										<div class="input-group">
										<input type="text" class="form-control form-control-sm input-sm" name="i" id="i" placeholder="...">
										<span onclick="getOutlet();" class="input-group-addon add-on"><i class="fa fa-refresh"></i></span>
										</div>
									</div>
									<label class="col-md-2 control-label">Detail</label>
									<div class="col-md-4">
										<textarea class="form-control form-control-sm input-sm" name="d" id="d" placeholder="..."></textarea>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-md-2 control-label">Jenis Gangguan</label>
									<div class="col-md-4">
										<!--input type="text" class="form-control form-control-sm input-sm" name="pic" id="pic" placeholder="..."-->
										<select onchange="typChange();" class="form-control form-control-sm" name="typ" id="typ" style="-webkit-appearance: menulist;">
										<?php echo $opttyp?>
										</select>
									</div>
									<label class="col-md-2 control-label">Jenis Layanan</label>
									<div class="col-md-4">
										<select class="form-control form-control-sm" name="st" id="st" onchange="stChange();" style="-webkit-appearance: menulist;">
										<?php echo $optst?>
										</select>
									</div>
									
								</div>
								<div class="form-group row">
								<?php if($s_LVL==4){?>
									<label class="col-md-2 control-label cls-grp">Group</label>
									<div class="col-md-4 cls-grp">
										<select class="form-control form-control-sm class-grp" name="grp" id="grp" style="-webkit-appearance: menulist;">
										<?php echo $optgrp?>
										</select>
									</div>
								<?php }else{?>
										<input type="hidden" name="grp" class="class-grp" value="link" />
								<?php }?>
										<label class="col-md-2 control-label">Outlet Name</label>
										<div class="col-md-4">
											<input type="hidden" name="h" id="h" />
											<input readonly type="text" class="form-control form-control-sm input-sm" name="oname" id="oname" placeholder="auto">
										</div>
										<label class="col-md-2 control-label psbrelokmig" style="display:none;">Install Date</label>
										<div class="col-md-4 psbrelokmig" style="display:none;">
											<div class="input-group">
												<input id="tp" name="tp" type="text" class="form-control form-control-sm datepicker" placeholder="">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<label class="col-md-2 control-label nonpsbrelokmig">Backup Link</label>
										<div class="col-md-4 nonpsbrelokmig" style="">
											<input id="buprovider" type="text" readonly class="form-control form-control-sm" placeholder="">
										</div>
								</div>
									<div class="form-group row">
										<label class="col-md-2 control-label">Kanwil</label>
										<div class="col-md-4">
											<input readonly type="text" class="form-control form-control-sm input-sm" name="kanwil" id="kanwil" placeholder="auto">
											<!--select class="form-control form-control-sm" name="kanwil" id="kanwil" onchange="$('#k').val($('#kanwil').val());" placeholder="auto">
											<?php echo $opt1?>
											</select-->
										</div>
										<label class="col-md-2 control-label">SID</label>
										<div class="col-md-4">
											<input disabled type="text" class="form-control form-control-sm input-sm" name="sid" id="sid" placeholder="auto">
										</div>
										
									</div>
									<div class="form-group row">
										<label class="col-md-2 control-label">IP WAN</label>
										<div class="col-md-4">
											<input disabled type="text" class="form-control form-control-sm input-sm" name="ipwan" id="ipwan" placeholder="auto">
										</div>
										<label class="col-md-2 control-label">IP LAN</label>
										<div class="col-md-4">
											<input disabled type="text" class="form-control form-control-sm input-sm" name="iplan" id="iplan" placeholder="auto">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-md-2 control-label">Area</label>
										<div class="col-md-4">
											<input disabled type="text" class="form-control form-control-sm input-sm" name="area" id="area" placeholder="auto">
										</div>
										<label class="col-md-2 control-label">Cabang</label>
										<div class="col-md-4">
											<input disabled type="text" class="form-control form-control-sm input-sm" name="cabang" id="cabang" placeholder="auto">
										</div>
									</div>
									<!--div class="form-group row">
										<label class="col-md-2 control-label">Name</label>
										<div class="col-md-4">
											<input disabled type="text" class="form-control form-control-sm input-sm" name="hx" id="hx" placeholder="auto">
										</div>
									</div-->
								</form>
								<br />
								<form class="form-horizontal" id="myfpic">
									<input type="hidden" name="t" value="pic">
									<input type="hidden" name="tname" value="tm_outlets">
									<input type="hidden" name="columns" value="pic,pic2,contact,contact2">
									<input type="hidden" name="svt" value="SAVE">
									<input type="hidden" name="id" id="orowid" value="">
									
									<div class="form-group row">
										<label class="col-md-2 control-label">PIC 1</label>
										<div class="col-md-4">
											<input type="text" class="form-control form-control-sm input-sm" name="pic" id="pic" placeholder="auto">
										</div>
										<label class="col-md-2 control-label">PIC 2</label>
										<div class="col-md-4">
											<input type="text" class="form-control form-control-sm input-sm" name="pic2" id="pic2" placeholder="auto">
										</div>
										
									</div>
									<div class="form-group row">
										<label class="col-md-2 control-label">Contact 1</label>
										<div class="col-md-4">
											<input type="text" class="form-control form-control-sm input-sm" name="contact" id="contact" placeholder="auto">
										</div>
										<label class="col-md-2 control-label">Contact 2</label>
										<div class="col-md-4">
											<input type="text" class="form-control form-control-sm input-sm" name="contact2" id="contact2" placeholder="auto">
										</div>
									</div>
								</form>

							</div>
							</div>
						
                    </div>
                    <div class="modal-footer">
						<button type="button" class="btn btn-warning" onclick="sendDataFile('#myfpic','SAVE');">Update PIC</button>
						<button type="button" class="btn btn-success" onclick="if($('#myf').valid()){$('#yakin').val('');sendDataFile('#myf','SAVE');}">Submit</button>
						<button type="button" class="btn btn-danger" id="bdel" data-toggle="modal" data-target="#modal_delete">Delete</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="tblupdate();getNotif();">Close</button>                                                
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
jQuery.validator.addMethod("equals", function(value, element, param) {
	//console.log(value);
	//console.log(param);
  return this.optional(element) || $.inArray(value,param) != -1;
}, "Please specify a different value");

var mytbl, jvalidate, jvalidate2;
$(document).ready(function() {
	$("#i").keypress(function (e){
		var keycode = (e.keyCode ? e.keyCode : e.which);
		if (keycode == '13' || keycode == '9') {
			getOutlet();
		}else{
			clearAuto();
		}
	});
	$("#iarea").keypress(function (e){
		var keycode = (e.keyCode ? e.keyCode : e.which);
		if (keycode == '13' || keycode == '9') {
			getOutletx();
		}else{
			clearAuto();
		}
	});
	
	$.fn.dataTable.ext.errMode = 'none';
	
	mytbl = $('#example').DataTable({
	//dom: 'T<"clear"><lrf<t>ip>',
	searching: true,
	serverSide: true,
	processing: true,
	ordering: true,
	search: {
        search: '<?php echo $tsrc?>'
    },
	order: [[1,"desc"]],
		ajax: {
			type: 'POST',
			url: 'dataget.php',
			data: function (d) {
				d.cols= '<?php echo base64_encode($cols); ?>',
				d.tname= '<?php echo base64_encode($tnames); ?>',
				d.csrc= '<?php echo $colsrc; ?>',
				d.srceq= '<?php echo $srceq; ?>',
				d.where= '<?php echo base64_encode($where);?>',
				d.g= '<?php echo $g; ?>',
				d.ms= getMultipleValues('#fs'),
				d.mst= getMultipleValues('#fst'),
				d.mtyp= getMultipleValues('#ftyp'),
				d.mgrp= getMultipleValues('#fgrp'),
				d.mk= getMultipleValues('#fk'),
				d.df= $("#fdf").val(),
				d.dt= $("#fdt").val(),
				d.x= '<?php echo $menu; ?>'
			}
		},
		drawCallback: function( settings ) {
			$(".fancy").fancybox({
				type : 'iframe',
				afterClose : function(instance, current, e){
					//console.info('heheheheh');
					tblupdate();
				}
			});
		}
	});
	jvalidate = $("#myf").validate({
    rules :{
        "d" : {
            required : true
        },
		"grp" : {
            required : true,
			equals : function(element){
				if($("#st").val()=="router/switch/ip-phn"){
					return ["jarkom"];
				}else{
					return ["jarkom","link"];
				}
			}
        },
		"typ" : {
            required : true
        },
		"st" : {
            required : true
        },
		"oname" : {
            required : true
        },
		"i" : {
            required : true
        },
		"kanwil" : {
            required : true
        }
    }});
	jvalidate2 = $("#myfx").validate({
    rules :{
        "d" : {
            required : true
        },
		"typ" : {
            required : true
        },
		"st" : {
            required : true,
			minlength : 1
        },
		"outletx" : {
            required : true
        }
    }});
	$.datetimepicker.setLocale('en');
	$("#dt").datetimepicker({
		format:'Y-m-d H:i',
		step: 1
	});
	$("#dtx").datetimepicker({
		format:'Y-m-d H:i',
		step: 1
	});
	//$(".selectpicker").selectpicker();
	$(".selectpicker").select2();
	$(".datepicker").datepicker({format: 'yyyy-mm-dd'});
	
	setTimeout(tblupdate,5*1000);
});

function tblupdate(){
	mytbl.ajax.reload(null, false);
	
	setTimeout(tblupdate,300*1000);
}

function sendForm(){
	if(!$('#stx').val()){
			$("#processing_msgs").html("Jenis Layanan harus diisi.");
			manage_msgs('end');
			$("#modal_no_head").modal('show');
	}else{
		if($('#myfx').valid()){
			sendDataFile("#myfx","SAVE");
		}
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

function oclick(c,v){
	if($(c)[0].checked){
		$(v).val('Y');
	}else{
		$(v).val('');
	}
}

function multiSelect(id,data){
	/*
	if(id=="area"){
		$("#"+id).val(data.split(";"));
		$("#"+id).selectpicker('refresh');
	}
	if(id=="pic"){
		getPIC(data);
	}*/
	if(id=="ticketno"){
		//$("#notes").html('<a title="Notes" href="JavaScript:;" class="btn btn-warning" data-fancybox data-type="iframe" data-src="notes.php?id='+data+'">Notes</a>');
	}
}

function clearAuto(oin='kanwil,oname,iplan,ipwan,area,cabang,sid,pic,pic2,contact,contact2,outlet,outletx,orowid'){
	var outlets=oin.split(',');
	var toutlet=0;
	
	for(toutlet=0;toutlet<outlets.length;toutlet++){
		$('#'+outlets[toutlet]).val('');
	}
}

function getOutlet(){
	var url='datajson.php';
	var mtd='POST';
	var frmdata={q:'houtlet',id:$('#i').val()};
	$.ajax({
		type: mtd,
		url: url,
		data: frmdata,
		success: function(data){
			var json=JSON.parse(data);
			$.each(json[0],function (key,val){
				$('#'+key).val(val);
				if(key=='rowid'){$('#orowid').val(val);}
				if(key=='kanwil'){$('#k').val(val);}
				if(key=='oname'){$('#h').val(val);$('#hx').val(val);}
			});
			if(json.length<1){
				alert('Outlet not found');
			}else{
				getIP();
			}
			//console.log($('#orowid').val());
		},
		error: function(xhr){
			console.log("Error:"+xhr);
		}
	});
}
function getOutletx(){
	var url='datajson.php';
	var mtd='POST';
	var frmdata={q:'houtletx',id:$('#iarea').val()};
	$.ajax({
		type: mtd,
		url: url,
		data: frmdata,
		success: function(data){
			var json=JSON.parse(data);
			if(json.length<1){
				alert('Outlet not found');
			}else{
				$("#outlet").val(data);
				var s="#. ID - Name - Kanwil\n";
				for(var i=0;i<json.length;i++){
					s+=(i+1)+'. '+json[i]['oid']+' - '+json[i]['oname']+' - '+json[i]['kanwil']+'\n';
				}
				$("#outletx").val(s);
			}
		},
		error: function(xhr){
			console.log("Error:"+xhr);
		}
	});
}
function stChange(){
	if($('#st').val()=='router/switch/ip-phn'){
		$('.class-grp').val('jarkom');
	}else{
		$('.class-grp').val('link');
	}
	getIP();
}
function typChange(){
	var v=$("#typ").val();
	if(v=="relokasi"||v=="psb"||v=="migrasi"){
		$(".psbrelokmig").show();
		$(".nonpsbrelokmig").hide();
	}else{
		$(".psbrelokmig").hide();
		$(".nonpsbrelokmig").show();
	}
}
function getIP(){
if($('#st').val()!=""&&$('#i').val()!=""){
	var vst=$('#st').val();
	if(vst=='router/switch/ip-phn'){
		//vst=$('#lnk').val();
	}
	var url='datajson.php';
	var mtd='POST';
	var frmdata={q:'hip',id:$('#i').val(),idx:vst};
	$.ajax({
		type: mtd,
		url: url,
		data: frmdata,
		success: function(data){
			clearAuto('iplan,ipwan,sid');
			var json=JSON.parse(data);
			if(json.length<1){
				//alert('IP not found');
			}else{
				$.each(json[0],function (key,val){
					$('#'+key).val(val);
				});
			}
			//console.log($('#orowid').val());
		},
		error: function(xhr){
			console.log("Error:"+xhr);
			clearAuto('iplan,ipwan,sid');
		}
	});
}else{
	clearAuto('iplan,ipwan,sid');
}
}

function getPIC(x=""){
			var url='datajson.php';
			var mtd='POST';
			var frmdata={q:'hdgrp',id:$('#grp').val()};
			
			//alert(frmdata);
			
			$.ajax({
				type: mtd,
				url: url,
				data: frmdata,
				success: function(data){
					var json=JSON.parse(data);
					console.log(json);
					$("#pic").find('option').remove();
					var s='<option value=""></option>';
					for(i=0;i<json.length;i++){
						v="";t="";
						$.each(json[i],function (key,val){
							if(key=='v'){v=val;}
							if(key=='t'){t=val;}
						});
						if(v==x){
							s+='<option selected value="'+v+'">'+t+'</option>';
						}else{
							s+='<option value="'+v+'">'+t+'</option>';
						}
					}
					$("#pic").append(s);
				},
				error: function(xhr){
					console.log("Error:"+xhr);
				}
			});
}

function svcallback(data,f){
	console.log('callback hit'+data);
	$("#processing_msgs").html(data);
	manage_msgs('end');
	if(data!="Data has been saved"){
		if(f=='#myf'){ $("#btncontinue").show(); }
	}else{
		$("#btncontinue").hide();
		tblupdate();
	}
}
</script>
	
    </body>
</html>
