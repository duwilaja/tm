<?php
include 'inc.chksession.php';
include 'inc.common.php';
include 'inc.db.php';

function one_dimension($arr,$idx){
	$ret=array();
	for($i=0;$i<count($arr);$i++){
		$ret[]=$arr[$i][$idx];
	}
	return $ret;
}
function get24Hours(){
	$ret=array();
	for($i=0;$i<24;$i++){
		$ret[]="$i";
	}
	return $ret;
}
function getMY($start,$end){
	$origin = date_create($start);
	$target = date_create($end);
	$origin = date_create($origin->format('Y').'-'.$origin->format('m').'-1');
	$interval = date_diff($origin, $target);
	$mon=$interval->m + ($interval->y*12);
	$mon=$interval->d > 0 ?$mon+1:$mon;
	$mon=$origin->format("m") != $target->format("m") ?$mon+1:$mon;
	$labels=array(); $bln=$origin->format('Y-m-d');
	for($i=0;$i<$mon;$i++){
		if($bln<=$end) $labels[]=date('M Y',strtotime("$bln"));
		$bln=date('Y-m-d',strtotime("$bln 1 month"));
	}
	return $labels;
}

date_default_timezone_set("Asia/Jakarta");

$conn = connect();

$q=$_POST['q'];
$df=$_POST['df']!=''?$_POST['df']:date('Y-m-d');
$dt=$_POST['dt']!=''?$_POST['dt']:date('Y-m-d');

$axis=""; $label=""; $data="";

$r_axis=array();
$r_data=array();
$r_label=array();

switch($q){
	case 'chart0': //main link
		//$axis="select distinct kanwil from tm_outlets";
		$label="select distinct lnk from tm_outlets";
		$data="select 'Main Link' as z, lnk as x, count(rowid) as y from tm_outlets group by x,z";// where date(dt)<='$dt' and date(dt)>='$df' group by x,z";
		break;
	case 'chart1': //main link / wil
		$axis="select distinct kanwil from tm_outlets";
		$label="select distinct lnk from tm_outlets";
		$data="select lnk as z,kanwil as x, count(rowid) as y from tm_outlets group by x,z";// where date(dt)<='$dt' and date(dt)>='$df' group by x,z";
		break;
	case 'chart2': //vpn problem / wil
		$where="$gangguan and st='vpn' and date(dt)<='$dt' and date(dt)>='$df'";
		$axis="select distinct kanwil from tm_outlets";
		$r_label=array("Gangguan");
		//$label="select distinct lnk from tm_outlets";
		$data="select 'Gangguan' as z,k as x, count(rowid) as y from tm_tickets where $where group by x,z";
		break;
	case 'chart3': //problem / wil
		$where="$gangguan and date(dt)<='$dt' and date(dt)>='$df'";
		$axis="select distinct kanwil from tm_outlets";
		$r_label=array("Gangguan");
		//$label="select distinct lnk from tm_outlets";
		$data="select 'Gangguan' as z,k as x, count(rowid) as y from tm_tickets where $where group by x,z";
		break;
	case 'chart4': //vpn problem dur
		$where="$gangguan and date(dt)<='$dt' and date(dt)>='$df' and st='vpn' and s='closed'";
		//$axis="select distinct kanwil from tm_outlets";
		$r_axis=get24Hours(); $r_axis[]="1D"; $r_axis[]="2D"; $r_axis[]="3D"; $r_axis[]=">3D";
		$r_label=array("Gangguan");
		//$label="select distinct lnk from tm_outlets";
		$xselect="CASE
					WHEN TIMESTAMPDIFF(HOUR,dt,closed)=24 THEN '1D'
					WHEN TIMESTAMPDIFF(HOUR,dt,closed)>24 THEN '2D'
					WHEN TIMESTAMPDIFF(HOUR,dt,closed)>48 THEN '3D'
					WHEN TIMESTAMPDIFF(HOUR,dt,closed)>72 THEN '>3D'
					ELSE TIMESTAMPDIFF(HOUR,dt,closed)
				END";
		$data="select 'Gangguan' as z, $xselect as x, count(rowid) as y from tm_tickets where $where group by x,z";
		break;
	case 'chart5': //wifi problem dur
		$where="$gangguan and date(dt)<='$dt' and date(dt)>='$df' and st='wifi station' and s='closed'";
		//$axis="select distinct kanwil from tm_outlets";
		$r_axis=get24Hours(); $r_axis[]="1D"; $r_axis[]="2D"; $r_axis[]="3D"; $r_axis[]=">3D";
		$r_label=array("Gangguan");
		//$label="select distinct lnk from tm_outlets";
		$xselect="CASE
					WHEN TIMESTAMPDIFF(HOUR,dt,closed)=24 THEN '1D'
					WHEN TIMESTAMPDIFF(HOUR,dt,closed)>24 THEN '2D'
					WHEN TIMESTAMPDIFF(HOUR,dt,closed)>48 THEN '3D'
					WHEN TIMESTAMPDIFF(HOUR,dt,closed)>72 THEN '>3D'
					ELSE TIMESTAMPDIFF(HOUR,dt,closed)
				END";
		$data="select 'Gangguan' as z, $xselect as x, count(rowid) as y from tm_tickets where $where group by x,z";
		break;
	case 'chart6': //gamas vpn dur
		$where="d like '%gamas%' and s='closed' and LOWER(st)='vpn'";
		$r_axis=getMY($df,$dt);
		$r_label=array("Gamas VPN");
		$data="select 'Gamas VPN' as z, DATE_FORMAT(dt,'%b %Y') as x, SUM(TIMESTAMPDIFF(SECOND,dt,closed)) as y from tm_tickets where $where group by x,z";
		break;
	case 'chart7': //gamas vpn dur
		$where="d like '%gamas%' and s='closed' and LOWER(st) like '%wifi%'";
		$r_axis=getMY($df,$dt);
		$r_label=array("Gamas Wifi Station");
		$data="select 'Gamas Wifi Station' as z, DATE_FORMAT(dt,'%b %Y') as x, SUM(TIMESTAMPDIFF(SECOND,dt,closed)) as y from tm_tickets where $where group by x,z";
		break;
}

//echo $sql;
if($axis!=''){
	$r_axis = one_dimension(fetch_all(exec_qry($conn,$axis)),0);
}
if($label!=''){
	$r_label = one_dimension(fetch_all(exec_qry($conn,$label)),0);
}
if($data!=''){
	$r_data = fetch_alla(exec_qry($conn,$data));
}

$output = array("axis"=>$r_axis,"label"=>$r_label,"data"=>$r_data);

disconnect($conn);

echo json_encode( $output );
?>