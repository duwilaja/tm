<?php
include "inc.db.php";

date_default_timezone_set("Asia/Jakarta");

$conn=connect();

$sql="select rowid from tm_holidays where dt=DATE(NOW()) and TRIM(kanwil)=''";
$ar=fetch_all(exec_qry($conn,$sql));

if(count($ar)==0 && strtolower(date('D'))!='sun'){ //today is not holiday

	$sql="select *,time(dt) as tm from tm_apicreate_log_h where DATE(dt)=DATE(date_add(NOW(),INTERVAL -1 DAY)) and TIMESTAMPDIFF(MINUTE,dt,NOW()) > 10 and v='1' and rid NOT IN (SELECT ticketno FROM tm_tickets)";
	$sql.=" UNION select *,time(dt) as tm from tm_apicreate_log where DATE(dt)<=DATE(NOW()) and TIMESTAMPDIFF(MINUTE,dt,NOW()) > 10 and v='1' and rid NOT IN (SELECT ticketno FROM tm_tickets)";
	$logs=fetch_alla(exec_qry($conn,$sql));

	for($cntr=0;$cntr<count($logs);$cntr++){
		$data=$logs[$cntr];
		$i=$data['i'];
		$h=$data['h'];
		$typ=$data['typ'];
		$usr=$data['crtdby'];
		$rid=$data['rid'];
		$d=$data['d'];
		$dt=$data['dt'];
		$st=$data['st'];
		$tm=$data['tm'];
		$grp='link';
		
		if(strtolower($i)=='xxxx'){
			
			if(substr($d,0,8)=='Cellular') { $st='LTE'; $grp='jarkom'; }
			
			$outlets=explode("-",$h);
			if(count($outlets)>0){
				$i=$outlets[0];
			}
			if(count($outlets)>1){
				//echo "hoho". $outlets[1]. strtoupper(substr($outlets[1],3));
				switch(strtoupper(substr($outlets[1],3))){
					case 'AP': 
						$st='Access Point';
						$grp='jarkom';
						$d=$h.'/'.$d;
						$typ='pengecekan AP';
						break;
					case 'FW':
						$st='Firewall';
						$grp='jarkom';
						$d=$h.'/'.$d;
						$typ='pengecekan firewall';
						break;
					case 'SW':
						$st='Switch';
						$grp='jarkom';
						$d=$h.'/'.$d;
						$typ='pengecekan switch';
						break;
					case 'RT':
						$st='Router';
						$grp='jarkom';
						$d=$h.'/'.$d;
						$typ='pengecekan router';
						break;
				}
			}
		}
		if($st==''){
			$sql="select lnk from tm_outlets where oid='$i'";
			$ar=fetch_all(exec_qry($conn,$sql));
			if(count($ar)>0){
				$st=$ar[0][0];
			}
		}
		
		//check double
		$sql="select ticketno from tm_tickets where i='$i' and s<>'closed' and typ in ('$typ','relokasi') and st='$st'";
		$arx=fetch_all(exec_qry($conn,$sql));
		
		//check up
		$sql="select rid from tm_apiupdate_log where ((i='xxxx' and h = '$h') or i='$i') and dt>='$dt'";
		$arz=fetch_all(exec_qry($conn,$sql));
		
		//check up history
		if(count($arz)==0){
			$sql="select rid from tm_apiupdate_log_h where ((i='xxxx' and h = '$h') or i='$i') and dt>='$dt'";
			$arz=fetch_all(exec_qry($conn,$sql));
		}
		
		if(count($arx)==0&&count($arz)==0){ //not double not up
			$sql="select oname,kanwil,lnk,wibstart,wibend,subtime(wibend,'2:30:00') as wibendsat from tm_outlets where oid='$i' and kanwil not in (select kanwil from tm_holidays where dt=DATE(NOW()) or dt=DATE('$dt'))";
			$ar=fetch_all(exec_qry($conn,$sql));
			$stime="";
			$etime="";
			$found=false;
			if(count($ar)>0){
				$h=$ar[0][0];
				$k=$ar[0][1];
				//$st=$ar[0][2];
				$stime=$ar[0][3];
				$etime=strtolower(date('D'))=='sun'?$ar[0][5]:$ar[0][4];
				$found=true;
			}
			
			if($found && $stime<=date('H:i:s')){ //now is workhour for this branch
				$mystart=date('Y-m-d').' '.$stime;
				$nows="DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i:00')";
				$sql="insert into tm_tickets (rowid,ticketno,dtm,createdby,lastupd,updby,dt,i,h,d,k,st,typ,grp) values ('$rid','$rid',$nows,'$usr',$nows,'$usr','$dt','$i','$h','$d','$k','$st','$typ','$grp')";
				$rs=exec_qry($conn,$sql);
			}
		}
	}
}

disconnect($conn);
?>