<?php
include 'inc.chksession.php';
include 'inc.common.php';
include 'inc.db.php';

$conn = connect();

$x=isset($_POST["x"])?$_POST["x"]:"-";
$where=isset($_POST["where"])?base64_decode($_POST["where"]):"";
$tablename=base64_decode($_POST["tname"]);
$columns=base64_decode($_POST["cols"]);
$colsearch=isset($_POST["csrc"])?$_POST["csrc"]:"";
$searcheq = isset($_POST["srceq"])?$_POST["srceq"]:"";

$grp=isset($_POST['grpby']) ? base64_decode($_POST['grpby']):"";
$grpx=$grp;
$grp=$grp!=""?" group by $grp":"";

$having=isset($_POST['having']) ? base64_decode($_POST['having']):"";
$having=$having!=""?" having $having":"";

//standard param
$params=explode(",","s,k,grp,typ,st,blink");
for($i=0;$i<count($params);$i++){
	$param=isset($_POST[$params[$i]]) ? $_POST[$params[$i]]:"";
	if($param!=""){
		$where=$where!=""?"$where and ".$params[$i]."='$param'":$params[$i]."='$param'";
	}
}
//specific param
$g=isset($_POST['g'])?$_POST['g']:"";

$param=isset($_POST['ljp']) ? $_POST['ljp']:"";
	if($param!=""){
		$where=$where!=""?"$where and jp like '%$param%'":"jp like '%$param%'";
	}
$param=isset($_POST['mk']) ? $_POST['mk']:"";
	if($param!=""){
		$where=$where!=""?"$where and k in ($param)":"k in ($param)";
	}
$param=isset($_POST['ms']) ? $_POST['ms']:"";
	if($param!=""){
		$where=$where!=""?"$where and s in ($param)":"s in ($param)";
	}
$param=isset($_POST['mst']) ? $_POST['mst']:"";
	if($param!=""){
		$where=$where!=""?"$where and st in ($param)":"st in ($param)";
	}
$param=isset($_POST['mtyp']) ? $_POST['mtyp']:"";
	if($param!=""){
		$where=$where!=""?"$where and typ in ($param)":"typ in ($param)";
	}
$param=isset($_POST['mgrp']) ? $_POST['mgrp']:"";
	if($param!=""){
		$where=$where!=""?"$where and grp in ($param)":"grp in ($param)";
	}
	
$param=isset($_POST['ssurvid']) ? $_POST['ssurvid']:"";
	if($param!=""){
		$where=$where!=""?"$where and s.survid='$param'":"s.survid='$param'";
	}
$param=isset($_POST['pstatus']) ? $_POST['pstatus']:"";
	if($param!=""){
		$where=$where!=""?"$where and p.status='$param'":"p.status='$param'";
	}
	
$param=isset($_POST['fdf']) ? $_POST['fdf']:"";
	if($param!=""){
		$where=$where!=""?"$where and date(lastupd)>='$param'":"date(lastupd)>='$param'";
	}
$param=isset($_POST['fdt']) ? $_POST['fdt']:"";
	if($param!=""){
		$where=$where!=""?"$where and date(lastupd)<='$param'":"date(lastupd)<='$param'";
	}
$param=isset($_POST['df']) ? $_POST['df']:"";
	if($param!=""){
		$where=$where!=""?"$where and dt>='$param'":"dt>='$param'";
	}
$param=isset($_POST['dt']) ? $_POST['dt']:"";
	if($param!=""){
		$where=$where!=""?"$where and dt<='$param 23:59:59'":"dt<='$param 23:59:59'";
	}
$param=isset($_POST['tdf']) ? $_POST['tdf']:"";
	if($param!=""){
		$where=$where!=""?"$where and date(t.lastupd)>='$param'":"date(t.lastupd)>='$param'";
	}
$param=isset($_POST['tdt']) ? $_POST['tdt']:"";
	if($param!=""){
		$where=$where!=""?"$where and date(t.lastupd)<='$param'":"date(t.lastupd)<='$param'";
	}


$adf=isset($_POST['adf']) ? $_POST['adf']:"";
$adt=isset($_POST['adt']) ? $_POST['adt']:"";
if($adf!="" && $adt!=""){
	$whr="(date(dt) between '$adf' and '$adt') or (date(solved) between '$adf' and '$adt') or (date(closed) between '$adf' and '$adt')"; //inbetween 2months
	$whr.=" or (date(dt) <= '$adf' and date(closed) >= '$adt') or (date(dt) <= '$adf' and date(solved) >= '$adt')";//more than 2 months solved/closed
	$whr.=" or (date(dt) <= '$adf' and date(t.lastupd) >= '$adt' and s not in('solved','closed'))";//more than 2 months open
	$where=$where!=""?"$where and ($whr)":"($whr)";
}

if($where!=""){
	$tablename.=" where ($where)";
}

$result = exec_qry($conn,"select ".$columns." from ".$tablename." ".$grp." limit 0");
$acol=array();
while($field = fetch_field($result)){
	$acol[]=$field->name;
}
$col=count($acol);

$countfield=$grp==""?"*":"distinct $grpx";
//$countfield="*";
$result = exec_qry($conn,"select count($countfield) from ".$tablename." ".$grp." ".$having);
$iTotal = 0;
while($row=fetch_row($result)){
	$iTotal+=$row[0];
}
$iFilteredTotal = $iTotal;
//echo "select count($countfield) from ".$tablename." ".$grp;

$draw = $_POST["draw"];
$limit="";
if ( isset($_POST['start']) && $_POST['length'] != -1 ) {
			$limit = "LIMIT ".intval($_POST['start']).", ".intval($_POST['length']);
		}


$str = $_POST["search"]["value"];
$search = "";
if($str!=""){
	if($colsearch!=""){
		$acs=explode(",",$colsearch);
		for($j=0;$j<count($acs);$j++){
			$search.=" or ".$acs[$j]." like '%".$str."%'";
		}
	}
	if($searcheq!=""){
		$acseq=explode(",",$searcheq);
		for($j=0;$j<count($acseq);$j++){
			$search.=" or ".$acseq[$j]." = '".$str."'";
		}
	}
	if($where==""){
		$search=" where 1=0".$search;
	}else{
		$search=" and (1=0".$search.")";
	}
}

if($search!=""){
$sql = "select count(*) from ". $tablename ." ".$search." ".$grp." ".$having;
$result = exec_qry($conn,$sql);
if($row=fetch_row($result)){
	$iFilteredTotal=$row[0];
}
}

$order="";
$ordercol=$_POST["order"][0]["column"];
$orderdir=$_POST["order"][0]["dir"];
if($ordercol<=$col){
	$order=" order by ".$acol[$ordercol]." ".$orderdir;
}
if($x=="notes"||$x=='ticket'){
	$order.=$order==""?" order by rowid desc":", rowid desc";
}

$sql = "select ".$columns." from ". $tablename ." ".$search." ".$grp." ".$having." ".$order." ".$limit;
//echo $sql;

$result = exec_qry($conn,$sql);

$output = array(
          "draw"=>$draw,
          "recordsTotal"=>$iTotal, // total number of records 
          "recordsFiltered"=>$iFilteredTotal, // if filtered data used then tot after filter
          "data"=>array(),
		  "sql"=>$sql
        );


//$output = array();	
$i=0;
$xx="";
while($row = fetch_row($result)){
	if($i==0){$dropup="";}else{$dropup="dropup";}
	$i++;
	$act="";
	
	$act='<a title="Edit" href="#" class="btn btn-warning" data-toggle="modal" data-target="#modal_large" onclick="openForm(\''.$row[$col-1].'\');"><i class="fa fa-pencil"></i></a>';
	$act.='&nbsp;<a title="Delete" href="#" class="btn btn-danger" data-toggle="modal" data-target="#modal_delete" onclick="openDelete(\''.$row[$col-1].'\');"><i class="fa fa-trash"></i></a>';
	
	/*
	if($x=="projects"){
		$act.='&nbsp;<div class="btn-group dropup">
                                                    <a aria-expanded="true" href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle"><i class="fa fa-bars"></i> <span class="caret"></span></a>
                                                    <ul class="dropdown-menu" role="menu" style="min-width:0;">
                                                        <li><a style="padding-top: 4px; padding-bottom: 5px;" title="Timelines" href="JavaScript:;" class="btn btn-success" data-fancybox data-type="iframe" data-src="prjtimes'.$env.'?id='.$row[$col-2].'"><i class="fa fa-tasks"></i></a></li>
                                                        <li><a style="padding-top: 4px; padding-bottom: 5px;" title="Locations" href="JavaScript:;" class="btn btn-warning" data-fancybox data-type="iframe" data-src="prjlocs'.$env.'?id='.$row[$col-2].'"><i class="fa fa-map-signs"></i></a></li>
                                                        <li><a style="padding-top: 4px; padding-bottom: 5px;" title="Docs" href="JavaScript:;" class="btn btn-info" data-fancybox data-type="iframe" data-src="prjdocs'.$env.'?id='.$row[$col-2].'"><i class="fa fa-paperclip"></i></a></li>                                                    
                                                    </ul>
                                                </div>';
		$row[$col-2]=$act;
	}
	if($x!="-"){
		$row[$col-1]=$act;
	}
	$xx="-";
	*/
	if($x=="notes"||$x=='ticket'){
		$row[4]='<a title="Open" href="JavaScript:;" data-fancybox data-type="iframe" data-src="'.$row[4].'">'.substr($row[4],23,30).'</a>';
		$xx="-";
	}
	if($x=="tickets"){
		//$row[$col-1]='<a title="Notes" href="JavaScript:;" class="btn btn-success" data-fancybox data-type="iframe" data-src="notes'.$env.'?id='.$row[$col-1].'"><i class="fa fa-edit"></i></a>';
		$btn=''; $style='';
		if($row[9]=='new'){$btn=' btn-success';}
		if($row[9]=='open'){$btn=' btn-info'; }//$style='style="background-color: green;"';}
		if($row[9]=='solved' && $row[13]=='SolarWinds') { $btn=' btn-warning';}
		//$row[0]='<a title="Open" href="JavaScript:;" class="btn'.$btn.'" data-fancybox data-type="iframe" data-src="ticket'.$env.'?id='.$row[$col-1].'">'.$row[0].'</a>';
		$row[0]='<a '.$style.' title="Open" class="btn'.$btn.' fancy" href="ticket'.$env.'?id='.$row[$col-1].'&g='.$g.'">'.$row[0].'</a>';
		$xx='-';
	}
	if(substr($x,0,8)=="rsummary"){
		$df=$_POST['df'];$dt=$_POST['dt'];
		$row[$col-1]='<a title="Detail" href="JavaScript:;" data-fancybox data-type="iframe" data-src="r_detail'.$env.'?df='.$df.'&dt='.$dt.'&r='.$x.'&id='.$row[0].'&id2='.$row[1].'">'.$row[$col-1].'</a>';
		$xx="-";
	}
	if($x=="m2mx"){
		$row[$col-1]='<button class="btn btn-success" title="Assign" onclick="setM2M(\''.$row[$col-1].'\')"><i class="fa fa-handshake-o"></i></button>';
		$xx="-";
	}
	if($x=="surveyeu"){
		$row[$col-1]='<a class="btn btn-warning" title="Detail" href="JavaScript:;" data-fancybox data-type="iframe" data-src="f_surveyeu'.$env.'?id='.$row[$col-1].'"><i class="fa fa-pencil"></i></a>';
		$xx="-";
	}
	if($x=="rslastt"){
		$row[9] = sec_to_dhms($row[9]);
		$row[10] = sec_to_dhms($row[10]);
		$row[11] = sec_to_dhms($row[11]);
		$row[12] = sec_to_dhms($row[12]);
		$row[13] = sec_to_dhms($row[13]);
		$row[14] = sec_to_dhms($row[14]);
		$row[15] = sec_to_dhms($row[15]);
		$xx="-";
	}
	if($x=="surveydeu"){
		$row[$col-1]=array_to_radio($i,$row[0],$surveyopt[$row[$col-1]]);
		$xx="-";
	}
	if($x=="r_templates"){
		if($_POST['rpt']!="7"){
		$row[2]='<a title="History" href="JavaScript:;" data-fancybox data-type="iframe" data-src="ticket'.$env.'?id='.$row[$col-1].'">'.$row[2].'</a>';
		}
		$xx="-";
	}
	if($x=="rm2m"){
		//if($_POST['rpt']!="7"){
		$row[$col-2]='<a title="History" href="JavaScript:;" data-fancybox data-type="iframe" data-src="ticket'.$env.'?id='.$row[$col-2].'">'.$row[$col-2].'</a>';
		//}
		$xx="-";
	}
	if($x!="-"&&$xx!="-"){ //- means no need to modify first column
		$row[0]='<a href="#" data-toggle="modal" data-target="#modal_large" onclick="openForm(\''.$row[$col-1].'\');">'.$row[0].'&nbsp;</a>';
	}
	if($x=="survey"){
		$row[$col-1]='<a class="btn btn-warning" title="Detail" href="JavaScript:;" data-fancybox data-type="iframe" data-src="f_survey'.$env.'?id='.$row[$col-1].'"><i class="fa fa-bars"></i></a>';
	}
	
	$output["data"][] = $row ;
}

disconnect($conn);

echo json_encode( $output );
?>