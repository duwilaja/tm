<?php
include 'inc.db.php';
include 'inc.common.php';

//executed at 6 and 18

$conn = connect();

if(date("H")=="18"){
$sql="UPDATE tm_sla_daily SET dur=dur+(TIMESTAMPDIFF(SECOND,dtm,NOW())), durwh=durwh+(TIMESTAMPDIFF(SECOND,dtm,NOW())), dtm=CURRENT_TIMESTAMP() WHERE dt=DATE(NOW())";
}else{
$sql="UPDATE tm_sla_daily SET dur=dur+(TIMESTAMPDIFF(SECOND,dtm,NOW())), dtm=CURRENT_TIMESTAMP() WHERE dt=DATE(NOW())";
}

$rs=exec_qry($conn,$sql);

disconnect($conn);
?>