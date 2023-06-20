<?php
include "inc.db.php";
//include "dvo.php";

date_default_timezone_set("Asia/Jakarta");
$now=date("Y-m-d H:i:s");

$conn=connect();

$sql="select rowid from tm_holidays where dt=DATE(NOW()) and TRIM(kanwil)=''";
$ar=fetch_all(exec_qry($conn,$sql));
if(count($ar)==0 && strtolower(date('D'))!='sun'){ // today is not holiday

	///create ticket
	$sql="select *,DATE_FORMAT(lastupd,'%Y-%m-%d %H:%i:00') as dts,time(lastupd) as tm from tm_dpo where proc='Y'  AND stts='Down' AND 
		oid NOT IN (SELECT i FROM tm_tickets WHERE s<>'closed' AND s<>'solved' AND st='wifi station')";
		$logs=fetch_alla(exec_qry($conn,$sql));

	for($cntr=0;$cntr<count($logs);$cntr++){
		$data=$logs[$cntr];
		$i=$data['oid'];
		$h=$data['oname'];
		$typ='offline';
		$usr='dvo';
		$rid=date("YmdHis").$cntr;
		$d=$data['stts'];
		$dt=$data['lastupd'];
		$st='wifi station';
		$tm=$data['tm'];
		$dts=$data['dts'];
		$grp='link';
		
		$sql="select oname,kanwil,lnk,wibstart,wibend,subtime(wibend,'2:30:00') as wibendsat from tm_outlets where oid='$i' and kanwil not in (select kanwil from tm_holidays where dt=DATE(NOW()))";
		$ar=fetch_all(exec_qry($conn,$sql));
		if(count($ar)>0){//not holiday
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
				//$sql="delete from tm_yellow where i='$i'";
				//$rs=exec_qry($conn,$sql);
			}
		}
	}
	
}//end if holiday
	
disconnect($conn);

?>