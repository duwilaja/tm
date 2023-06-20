<?php 
include 'inc.db.php';
include 'inc.common.php';

date_default_timezone_set("Asia/Jakarta");

$skr=date("H");

$token_tele="949635145:AAGmpoIpI3No34qEjv9yVXvRT4tmDV0FnUI";
$token_ruwa="a7hHmRkQwmiwQ4LTmGi8gQeHVA7LYuEGXofCuibMCsm6M9wy7i";

$nomor="-694769643"; //tele
$nomor=array("085892178767");//array("120363041663807116"); //WA

$conn = connect();

$sql="select rowid from tm_holidays where dt=DATE(NOW()) and TRIM(kanwil)=''";
$ar=fetch_all(exec_qry($conn,$sql));
if(count($ar)>0 || strtolower(date('D'))=='sun') { disconnect($conn); die ("Today is holiday"); }// today is not holiday

//echo "bukan holide";

$timers = array(array("4-5 hours"," and TIMESTAMPDIFF(HOUR,lastupd,NOW()) in (4,5)"),
			array("6-7 hours"," and TIMESTAMPDIFF(HOUR,lastupd,NOW()) in (6,7)"),
			array("8-23 hours"," and TIMESTAMPDIFF(HOUR,lastupd,NOW()) between 8 and 23"),
			array(">= 24 hours"," and (TIMESTAMPDIFF(HOUR,lastupd,NOW())>=24)")
			);
			
$timers = array(array("6-7 hours"," and TIMESTAMPDIFF(MINUTE,dt,NOW()) >=(6*60) and TIMESTAMPDIFF(MINUTE,dt,NOW()) <(8*60)",$nomor),
			array("8-11 hours"," and TIMESTAMPDIFF(MINUTE,dt,NOW()) >=(8*60) and TIMESTAMPDIFF(MINUTE,dt,NOW()) <(12*60)",$nomor),
			array("12-23 hours"," and TIMESTAMPDIFF(MINUTE,dt,NOW()) >=(12*60) and TIMESTAMPDIFF(MINUTE,dt,NOW()) <(24*60)",$nomor),
			array(">= 24 hours"," and TIMESTAMPDIFF(MINUTE,dt,NOW()) >=(24*60)",$nomor)
			);
			
$whr="(HOUR(lastupd)>=".(intval($skr)-1)." OR TIMESTAMPDIFF(HOUR,dt,NOW()) IN (6,8,12,24,48))";

$tks=array(); $ada=false;
for($i=0;$i<count($timers);$i++){
	$where=$timers[$i][1];
	$txt=$timers[$i][0];
	$chat=$timers[$i][2];
	
	$sql="select ticketno from tm_tickets where s='progress' and typ in $homewidget $where";
	$sql="select ticketno,h,i,typ,st,s,p,nossa from tm_tickets where TRIM(nossa)<>'' and TRIM(nossa)<>'-' and $whr and s<>'closed' and grp='link' and typ in $homewidget $where";
	//echo $sql;
	$tickets=fetch_alla(exec_qry($conn,$sql));
	$tk=array();
	for($j=0;$j<count($tickets);$j++){
		$tno=$tickets[$j]['ticketno'];
		$not=fetch_alla(exec_qry($conn,"select notes from tm_notes where ticketid='$tno' and updby<>'system' order by lastupd desc limit 1"));
		
		$tk[]="\n".$tickets[$j]['ticketno']."\n".$tickets[$j]['h']."(".$tickets[$j]['i'].")\n".$tickets[$j]['st'].
				"\n".$tickets[$j]['typ']."\n".$tickets[$j]['s']."\n".$tickets[$j]['nossa']."\n".$tickets[$j]['p']."\n".$not[0]['notes'];
		$ada=true;
	}
	if(count($tk)>0){
		$msg="Eskalasi $txt :\n".implode("\n",$tk);
		//$ms=sendTele($chat,$msg,$token_tele);
		$ms=sendWAs($chat,$msg,$token_ruwa);
	}
}

disconnect($conn);


function sendTele($chatID, $messaggio, $token) {
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

function sendWAs($phones,$message,$token){
	$ret=array();
	for($i=0;$i<count($phones);$i++){
		$ret[]=sendWa($phones[$i],$message,$token);
	}
	return json_encode($ret);
}
function sendWa($phone,$message,$token){
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://app.ruangwa.id/api/send_message',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS => 'token='.$token.'&number='.$phone.'&message='.$message,
	));
	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
}
?>