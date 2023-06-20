<?php 
include 'inc.db.php';
include 'inc.common.php';

date_default_timezone_set("Asia/Jakarta");

$token_tele="949635145:AAGmpoIpI3No34qEjv9yVXvRT4tmDV0FnUI";
$token_ruwa="a7hHmRkQwmiwQ4LTmGi8gQeHVA7LYuEGXofCuibMCsm6M9wy7i";

$nomor="-694769643"; //tele
$nomor=array("120363041663807116"); //WA

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
			
$timers = array(array("2-3 hours"," and TIMESTAMPDIFF(MINUTE,dt,NOW()) >=(2*60) and TIMESTAMPDIFF(MINUTE,dt,NOW()) <(4*60)",$nomor),
			array("4-5 hours"," and TIMESTAMPDIFF(MINUTE,dt,NOW()) >=(4*60) and TIMESTAMPDIFF(MINUTE,dt,NOW()) <(6*60)",$nomor),
			array("6-7 hours"," and TIMESTAMPDIFF(MINUTE,dt,NOW()) >=(6*60) and TIMESTAMPDIFF(MINUTE,dt,NOW()) <(8*60)",$nomor),
			array("8-11 hours"," and TIMESTAMPDIFF(MINUTE,dt,NOW()) >=(8*60) and TIMESTAMPDIFF(MINUTE,dt,NOW()) <(12*60)",$nomor),
			array("12-23 hours"," and TIMESTAMPDIFF(MINUTE,dt,NOW()) >=(12*60) and TIMESTAMPDIFF(MINUTE,dt,NOW()) <(24*60)",$nomor),
			array(">= 24 hours"," and TIMESTAMPDIFF(MINUTE,dt,NOW()) >=(24*60)",$nomor)
			);
			
$timers = array(
			array("All esk"," and TIMESTAMPDIFF(MINUTE,dt,NOW()) >=(6*60)",$nomor)
			);
			
$tks=array(); $ada=false;
for($i=0;$i<count($timers);$i++){
	$where=$timers[$i][1];
	$txt=$timers[$i][0];
	$chat=$timers[$i][2];
	
	$sql="select ticketno from tm_tickets where s='progress' and typ in $homewidget $where";
	$sql="select ticketno,i from tm_tickets where TRIM(nossa)<>'' and s<>'closed' and grp='link' and typ in $homewidget $where";
	//echo $sql;
	$tickets=fetch_alla(exec_qry($conn,$sql));
	$tk=array();
	for($j=0;$j<count($tickets);$j++){
		$t=$tickets[$j]; $pic='';$ctc=''; $onm='';
		$oid=$t['i']; $tno=$t['ticketno'];
		//get pic
		$out=fetch_alla(exec_qry($conn,"select oname,pic,contact from tm_outlets where oid='$oid' limit 1"));
		if(count($out)>0){
			$pic=$out[0]['pic'];$ctc=implode("", explode(" ", $out[0]['contact'])); $onm=$out[0]['oname'];
		}
		if($pic!='' && $ctc!=''){
			$not=fetch_alla(exec_qry($conn,"select notes from tm_notes where ticketid='$tno' and updby<>'system' order by lastupd desc limit 1"));
			if(count($not)>0){
				$msg="Dear Ibu/Bapak $pic di $onm \n Informasi terkait kendala di outlet ibu/bapak adalah sebagai berikut :  ".$not[0]['notes'].
				"\n\n Mohon maaf atas ketidak nyamanannya.\n\n Tim NMS Pegadaian.";
				$ms=sendWa($ctc,$msg,$token_ruwa);
			}
		}
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