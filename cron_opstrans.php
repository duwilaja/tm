<?php
include 'inc.db.php';
include 'inc.common.php';

date_default_timezone_set("Asia/Jakarta");

$dir='/jail/pgdsftp/home/'; //test
$dir='/home/pgdsftp/files/'; //prod

$conn = connect();

$arr=glob( $dir.'*.csv' );

if(count($arr)>0){
	
	$rs=exec_qry($conn,"truncate table tm_otrans_tmp");

$fname=$arr[count($arr)-1];
$skr=substr(basename($fname),0,16);//  date("Y-m-d H").":00:00";

$file = fopen("$fname","r") or die("Unable to open file!");
$ctr=0;
$strinsert="insert into tm_otrans_tmp (oid,ttrans,lasttrans,lastupd,updby) values ";
$strval=""; $i=0;
while(! feof($file))
  {
	  $str=str_ireplace('"',"",fgets($file));
	  $str=str_ireplace("\r","",$str);
	  $str=str_ireplace("\n","",$str);	  
	  
	  if($str!=""){
		  $i++;
		  $values=explode(",",implode("','",explode(",",$str)));
	      $values[]="STR_TO_DATE('$skr','%Y%m%d__%H%i%s')"; $values[]="'pgdsftp";
		  $values[2]="STR_TO_DATE(".$values[2]."', '%Y-%m-%d-%H.%i.%s')";
		  
	      $strval.=$strval==""?"":",";
		  $strval.="('".implode(",",$values)."')";
	  }
	  if($i==10){
		  $rs=exec_qry($conn,$strinsert.$strval);
		  $strval="";
		  $i=0;
	  }
	 // echo $str . "\n";
  }

  if($strval!=""){
	  $rs=exec_qry($conn,$strinsert.$strval);
  }
  
  $rows=fetch_all(exec_qry($conn,"select count(oid) from tm_otrans_tmp"));
  if($rows[0][0]>0){
	  $rs=exec_qry($conn,"truncate table tm_otrans");
	  $rs=exec_qry($conn,"insert into tm_otrans select oid,sum(ttrans),max(lasttrans),lastupd,updby from tm_otrans_tmp group by oid,lastupd,updby");
  }
  
fclose($file);

rename ("$fname",$dir."done/".basename($fname));

}

$rs=fetch_all(exec_qry($conn,"select i,min(dt),max(if(s='closed',closed,now())) as dtt from tm_tickets where (s<>'closed' or date(dt)=date(now())) and typ in $homewidget group by i"));
for($i=0;$i<count($rs);$i++){
	$cnt=0; $oid=$rs[$i][0]; $dt=$rs[$i][1]; $dtt=$rs[$i][2];
	$sql="select sum(ttrans) from tm_otrans_tmp where oid='$oid' and lasttrans > '$dt' and lasttrans < '$dtt'";
	$rsx=exec_qry($conn,$sql);
	if($row=fetch_row($rsx)){
		$cnt=$row[0]==null?0:$row[0];
	}
	//update
	$xxx=exec_qry($conn,"update tm_otrans set ttrans=$cnt where oid='$oid'");
	//make backup
	$xxx=exec_qry($conn,"delete from tm_otrans_h where oid='$oid' and date(lastupd)=date(now())");
	$xxx=exec_qry($conn,"insert into tm_otrans_h select * from tm_otrans where oid='$oid' and date(lastupd)=date(now())");
}
disconnect($conn);
?>