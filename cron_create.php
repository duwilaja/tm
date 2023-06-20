<?php
include "inc.db.php";

date_default_timezone_set("Asia/Jakarta");

$conn=connect();

$sql="update tm_apicreate_log set v='0' where d='Up'";
$rsv=exec_qry($conn,$sql);

$sql="select rowid from tm_holidays where dt=DATE(NOW()) and TRIM(kanwil)=''";
$ar=fetch_all(exec_qry($conn,$sql));
if(count($ar)==0 && strtolower(date('D'))!='sun'){ // today is not holiday

	$sql="select *,DATE_FORMAT(dt,'%Y-%m-%d %H:%i:00') as dts,time(dt) as tm from tm_apicreate_log where DATE(dt)=DATE(NOW()) and v='1' and 
	TIMESTAMPDIFF(SECOND,dt,NOW()) >= 480 and rid NOT IN (SELECT ticketno FROM tm_tickets)";
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
		$dts=$data['dts'];
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
		
		$sql="select oname,kanwil,lnk,wibstart,wibend,subtime(wibend,'2:30:00') as wibendsat from tm_outlets where oid='$i' and kanwil not in (select kanwil from tm_holidays where dt=DATE(NOW()))";
		$ar=fetch_all(exec_qry($conn,$sql));
		$arx=array(); $arz=array();
		if(count($ar)>0){//not holiday
			//check double
			if($st==''){
				$st=$ar[0][2];
			}
			$sql="select ticketno from tm_tickets where i='$i' and s<>'closed' and typ in ('$typ','relokasi') and st='$st'";
			$arx=fetch_all(exec_qry($conn,$sql));
			
			//check up
			$sql="select rid from tm_apiupdate_log where ((i='xxxx' and h = '$h') or i='$i') and dt>='$dt'";
			$arz=fetch_all(exec_qry($conn,$sql));
		}
		if(count($arx)==0&&count($arz)==0&&count($ar)>0){ //not double not up
			//$sql="select oname,kanwil,lnk,wibstart,wibend,subtime(wibend,'2:30:00') as wibendsat from tm_outlets where oid='$i' and kanwil not in (select kanwil from tm_holidays where dt=DATE(NOW()))";
			//$ar=fetch_all(exec_qry($conn,$sql));
			$stime="";
			$etime="";
			$found=false;
			if(count($ar)>0){
				$h=$ar[0][0];
				$k=$ar[0][1];
				//$st=$ar[0][2];
				$stime=$ar[0][3];
				$etime=strtolower(date('D'))=='sat'?$ar[0][5]:$ar[0][4];
				$found=true;
			}
			if($found && $tm>=$stime && $tm<=$etime){ //working hour
				$nows="DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i:00')";
				$sql="insert into tm_tickets (rowid,ticketno,dtm,createdby,lastupd,updby,dt,i,h,d,k,st,typ,grp) values ('$rid','$rid',$nows,'$usr',$nows,'$usr','$dt','$i','$h','$d','$k','$st','$typ','$grp')";
				$rs=exec_qry($conn,$sql);
				$sql="delete from tm_yellow where i='$i'";
				$rs=exec_qry($conn,$sql);
			}
		}else{
			$sql="update tm_apicreate_log set  v='0' where rid='$rid'";
			$rs=exec_qry($conn,$sql);
		}
	}
}

disconnect($conn);
?>