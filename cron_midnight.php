<?php
include 'inc.db.php';
include 'inc.common.php';

//executed at 0

$conn = connect();

//update yesterday's duration
$sql="UPDATE tm_sla_daily SET dur=dur+(TIMESTAMPDIFF(SECOND,dtm,NOW())) WHERE dt=SUBDATE(CURDATE(),1)";
$rs=exec_qry($conn,$sql);

//create new record for today
$sql="insert into tm_sla_daily (dt,tiket) select DATE(NOW()),ticketno from tm_tickets where s<>'closed'";
$rs=exec_qry($conn,$sql);

disconnect($conn);
?>