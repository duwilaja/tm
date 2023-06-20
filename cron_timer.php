<?php 
include 'inc.db.php';

$conn = connect();

$rs=exec_qry($conn,"update tm_tickets set solved = closed where solved is null and closed is not null");

$sql="select rowid from tm_holidays where dt=DATE(NOW()) and TRIM(kanwil)=''";
$ar=fetch_all(exec_qry($conn,$sql));
if(count($ar)==0 && strtolower(date('D'))!='sun'){ // today is not holiday

//select all timers
$sql="select grp,typ,mnt,stts from tm_timers";
//echo $sql;
$timers = fetch_alla(exec_qry($conn,$sql));
$tks=array();
for($i=0;$i<count($timers);$i++){
	$grp=$timers[$i]['grp'];
	$typ=$timers[$i]['typ'];
	$mnt=$timers[$i]['mnt'];
	$stts=$timers[$i]['stts'];
	
	$tickets=array();
	//select tickets match with the timer  //not in ('closed','pending')
	$sql="select ticketno,s from tm_tickets where grp='$grp' and typ='$typ' and s = '$stts'
	and mod(timestampdiff(minute,date_format(lastupd,'%Y-%m-%d %H:%i:00'),date_format(now(),'%Y-%m-%d %H:%i:00')),$mnt)=0
	and timestampdiff(minute,date_format(dtm,'%Y-%m-%d %H:%i:00'),date_format(now(),'%Y-%m-%d %H:%i:00'))>0";
	//echo $sql;
	$tickets=fetch_alla(exec_qry($conn,$sql));
	for($j=0;$j<count($tickets);$j++){
		$ticket=$tickets[$j]['ticketno'];
		$s=$tickets[$j]['s'];
		$sql="insert into tm_notes (ticketid,notes,s,lastupd,updby) values ('$ticket','Please respond [ $grp ]','$s',now(),'system')";
		//echo $sql;
		$rs=exec_qry($conn,$sql);
		$rs=exec_qry($conn,"update tm_tickets set o='1' where ticketno='$ticket'");
		//echo $sql;
		if($s!='solved') $tks[]=$ticket;
	}
}

disconnect($conn);

$msg="Cuy, urusin dunk tiket2 ini : ".implode("\n",$tks);
$token="949635145:AAGmpoIpI3No34qEjv9yVXvRT4tmDV0FnUI";
$chat="-694769643";
if(count($tks)>0){
	$ms=sendMessage($chat,$msg,$token);
}

}//endif holiday


function sendMessage($chatID, $messaggio, $token) {
    echo "sending message to " . $chatID . "\n";

    $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chatID;
    $url = $url . "&text=" . urlencode($messaggio);
    $ch = curl_init();
    $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
    );
    curl_setopt_array($ch, $optArray);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
?>