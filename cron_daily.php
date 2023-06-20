<?php
include 'inc.db.php';
include 'inc.common.php';

date_default_timezone_set("Asia/Jakarta");

$conn = connect();

if(strtolower(date('D'))!='sun'){
	$sql="update tm_tickets set s='open' where s='pending' and grp='link' and typ in $homewidget";
	$rs=exec_qry($conn,$sql);
}
if(strtolower(date('D'))=='mon'){
	$sql="update tm_tickets set s='open' where s='pending'  and typ='relokasi'";
	$sql="update tm_tickets set o='1' where typ='relokasi'";
	$rs=exec_qry($conn,$sql);
}

$sql="insert into tm_apicreate_log_h select * from tm_apicreate_log where date(dt)<date(now())";
$rs=exec_qry($conn,$sql);
$sql="delete from tm_apicreate_log where date(dt)<date(now())";
$rs=exec_qry($conn,$sql);

$sql="insert into tm_apiupdate_log_h select * from tm_apiupdate_log where date(dt)<date(now())";
$rs=exec_qry($conn,$sql);
$sql="delete from tm_apiupdate_log where date(dt)<date(now())";
$rs=exec_qry($conn,$sql);

disconnect($conn);
?>