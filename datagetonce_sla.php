<?php
include 'inc.db.php';
include 'inc.common.php';

$conn = connect();

$x=$_POST["x"];
$columns=base64_decode($_POST["cols"]);
$where=base64_decode($_POST["where"]);
$tablename=base64_decode($_POST["tname"]);

$grpby=isset($_POST['grpby']) ? base64_decode($_POST['grpby']):"";
$grpbyx=$grpby;
$grpby=$grpby!=""?" group by $grpby":"";

$having=isset($_POST['having']) ? base64_decode($_POST['having']):"";
$having=$having!=""?" having $having":"";

//inject where
$typ="'All'";
if(count(explode(',',$_POST['typ']))<2) { $typ=$_POST['typ']; }
$where = str_ireplace("!typ!",$_POST["typ"],$where);
$durasi = $_POST["durasi"];
$where = str_ireplace("!durasi!",$durasi,$where);


//standard param
$st="'All'";
$params=explode(",","area,k,grp");
for($i=0;$i<count($params);$i++){
	$param=isset($_POST[$params[$i]]) ? $_POST[$params[$i]]:"";
	if($param!=""){
		$where=$where!=""?"$where and ".$params[$i]."='$param'":$params[$i]."='$param'";
	}
}
//specific
$param=isset($_POST['mst']) ? $_POST['mst']:"";
	if($param!=""){
		$where=$where!=""?"$where and st in ($param)":"st in ($param)";
		$st="'".str_ireplace("'","",$param)."'";
	}
	
$df=$_POST['thn'].'-'.$_POST['bln'].'-01 00:00:00';
$where=$where!=""?"$where and d.dt>='$df'":"d.dt>='$df'";
$dt=date("Y-m-t", strtotime($df)).' 23:59:59';
$where=$where!=""?"$where and d.dt<='$dt'":"d.dt<='$dt'";

/*
$param=isset($_POST['df']) ? $_POST['df']:date('Y-m-d');
	if($param!=""){
		$where=$where!=""?"$where and d.dt>='$param'":"d.dt>='$param'";
		$df=$param.' 00:00:00';
	}
$param=isset($_POST['dt']) ? $_POST['dt']:date('Y-m-d');
	if($param!=""){
		$where=$where!=""?"$where and d.dt<='$param 23:59:59'":"d.dt<='$param 23:59:59'";
		$dt=$param." 23:59:59";
		if($param==date('Y-m-d')) { $dt=date('Y-m-d H:i:s'); }
	}
*/

if($where!=""){
	$tablename.=" where ($where)";
}

//count holidays which is not sunday
$daysoff=0;
$sql="select count(*) from tm_holidays where dt>='$df' and dt<='$dt' and dayofweek(dt)<>1";
$rs=exec_qry($conn,$sql);
if($r=fetch_row($rs)){
	$daysoff=$r[0];
}

$sql = "select ".$columns.",SUM(TIMESTAMPDIFF(SECOND,dt,IF(s='closed',closed,'$dt'))) as tda,DATEDIFF('$dt','$df')+1 as dft, $typ as typ, '$durasi' as dur, 
SUM(DATEDIFF(IF(s='closed',DATE(closed),DATE('$dt')),DATE(dt))+1) as dd from ". $tablename ." ".$grpby.",typ,dur,dft ".$having;
$sql = "select ".$columns.",DATEDIFF('$dt','$df')+1 as dft, $typ as typ, count_weekdays('$df','$dt',6) as doff from ". $tablename ." ".$grpby.",typ,dft,doff ".$having;
//$sql = "select ".$columns.",count_weekdays('$df','$dt',6)+$daysoff as dft, $typ as typ from ". $tablename ." ".$grpby.",dft,typ ".$having;
$sql = "select ".$columns.",DATEDIFF('$dt','$df')+1 as dft, $typ as typ, count_weekdays('$df','$dt',6) as doff from ". $tablename ." ".$grpby." ".$having;
//echo $sql;
$result = exec_qry($conn,$sql);
$rows = fetch_all($result);
$oid=""; $kan="";
for($i=0;$i<count($rows);$i++){
	if($x=='ips'){
		$lnk = '<a title="edit" href="JavaScript:;" data-fancybox data-type="iframe" data-src="ipsfrm.php?id='.$rows[$i][5].'">'.$rows[$i][0].'</a>';
		$lnk = '<a title="edit" href="JavaScript:openForm('.$rows[$i][5].');">'.$rows[$i][0].'</a>';
		$rows[$i][0] = $lnk;
	}
	if($x=='ipsr'){
		$lnk = '<a title="scan" href="JavaScript:rescan(\''.$rows[$i][1].'\');">scan</a>';
		$rows[$i][8] = $lnk;
		$lnk = '<a title="detail" href="JavaScript:;" data-fancybox data-type="iframe" data-src="ipsdtl.php?id='.$rows[$i][1].'">'.$rows[$i][0].'</a>';
		$rows[$i][0] = $lnk;
	}
	if($x=='rsla'){
		$offline=$rows[$i][2]; //berapa lama dalam detik
		$day=($rows[$i][3]-$rows[$i][5]-$daysoff);
		$tot=(12*60*60*$day*$rows[$i][1]); //berapa hari dalam detik
		
		$rows[$i][1] = sec_to_dhms($offline);
		$rows[$i][2] = round($offline/$tot*100,2).'%'; //off in %
		$rows[$i][3] = (100-round($offline/$tot*100,2)).'%'; //on in %
	}
	if($x=='rsla24'){
		$offline=$rows[$i][6]; //berapa lama dalam detik
		$day=($rows[$i][8]-$rows[$i][10]-$daysoff);
		$tot=(24*60*60*$day); //berapa hari dalam detik
		
		$rows[$i][6] = sec_to_dhms($offline);
		$rows[$i][7] = round($offline/$tot*100,2).'%'; //off in %
		$rows[$i][8] = (100-round($offline/$tot*100,2)).'%'; //on in %
	}
	if($x=='rsla12'){
		$offline=$rows[$i][7]; //berapa lama dalam detik
		$day=($rows[$i][8]-$rows[$i][10]-$daysoff);
		$tot=(12*60*60*$day); //berapa hari dalam detik
		
		$rows[$i][6] = sec_to_dhms($offline);
		$rows[$i][7] = round($offline/$tot*100,2).'%'; //off in %
		$rows[$i][8] = (100-round($offline/$tot*100,2)).'%'; //on in %
	}
	if($x=='rslaall'){
		$offline=$rows[$i][7]; //berapa lama dalam detik
		$day=($rows[$i][8]-$rows[$i][10]-$daysoff);
		$tot=($rows[$i][6]*$day); //berapa hari dalam detik
		
		$rows[$i][6] = sec_to_dhms($offline);
		$rows[$i][7] = round($offline/$tot*100,2).'%'; //off in %
		$rows[$i][8] = (99.95-round($offline/$tot*100,2)).'%'; //on in %
	}
	
	$oid.=$oid==''?'':',';
	$oid.="'".$rows[$i][1]."'";
	$kan.=$kan==''?'':',';
	$kan.="'".$rows[$i][0]."'";
}
$oid=$oid==''?"''":$oid;
$kan=$kan==''?"''":$kan;

$sqlx=$sql;
$sql = "select $st,oid,kanwil,area,cabang,oname,0,0,'100%',$typ as typ, '$durasi' as dur from tm_outlets where oid not in ($oid) and 1=0";
if($x=='rsla')$sql = "select locid,0,0,'100%',$typ as typ, '$durasi' as dur from tm_kanwils where locid not in ($kan) and 1=0";
$result = exec_qry($conn,$sql);
//$rows = fetch_all($result);
	while($row=fetch_row($result)){
		$rows[]=$row;
	}
	
disconnect($conn);

echo json_encode(array("data"=>$rows,"sql"=>$sqlx));
?>