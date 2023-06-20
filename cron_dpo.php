<?php
include "inc.db.php";
//include "dvo.php";

date_default_timezone_set("Asia/Jakarta");
$now=date("Y-m-d H:i:s");

function bearer(){
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://apigw.telkom.co.id:7777/invoke/pub.apigateway.oauth2/getAccessToken',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS =>'{ 
		"grant_type": "client_credentials", 
		"client_id": "d5c91884-2915-4bb4-a1b1-793e3c198691", 
		"client_secret": "90e8d2d2-1ef3-46c7-b5bf-1800922b5a67" 
	}',
	  CURLOPT_HTTPHEADER => array(
		'Content-Type: application/json'
	  ),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	
	echo $response;
	
	return json_decode($response);
}

function ambiltoken($bearer){
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://apigw.telkom.co.id:7777/gateway/telkom-wifi-venue/1.0/apiDVO/getdvotoken',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS =>'{
		"apiDVORequest": {
			"eaiHeader": {
				"externalId": "",
				"timestamp": ""
			},
			"eaiBody": {
				"uname": "perumpegadaian_170523",
				"password": "9Esg0j6BF2CM"
			}
		}
	}',
	  CURLOPT_HTTPHEADER => array(
		'Content-Type: application/json',
		'Authorization: Bearer '.$bearer
	  ),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	echo $response;
	
	return json_decode($response);
}

function ambildata($bearer,$token){
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://apigw.telkom.co.id:7777/gateway/telkom-wifi-venue/1.0/apiDVO/getinventory',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS =>'{
		"apiDVORequest": {
			"eaiHeader": {
				"externalId": "",
				"timestamp": ""
			},
			"eaiBody": {
				"uname": "perumpegadaian_170523"
			}
		}
	}',
	  CURLOPT_HTTPHEADER => array(
		'Content-Type: application/json',
		'Authorization: Bearer '.$bearer,
		'Dvo-Token: '.$token
	  ),
	));

	$response = curl_exec($curl);

	curl_close($curl);
	
	return json_decode($response);
}

$conn=connect();

$sql="select rowid from tm_holidays where dt=DATE(NOW()) and TRIM(kanwil)=''";
$ar=fetch_all(exec_qry($conn,$sql));
if(count($ar)==0 && strtolower(date('D'))!='sun'){ // today is not holiday

$res=bearer();
if($res->access_token){
	$bearer=$res->access_token;
	$res=ambiltoken($bearer);
	if($res->apiDVOResponse->eaiBody->dvo_token){
		$datas=ambildata($bearer,$res->apiDVOResponse->eaiBody->dvo_token);
		if(!is_array($datas->apiDVOResponse->eaiBody->data)){
			die ("Get data failed");
		}
	}else{
		die ("Get token failed");
	}
}else{
	die ("Get bearer failed");
}


$data=$datas->apiDVOResponse->eaiBody->data;

//var_dump($data);
$rs=exec_qry($conn,"truncate table tm_dpo");
for($i=0;$i<count($data);$i++){
	$sql="insert ignore into tm_dpo values ('".($i+1)."','".$data[$i]->LOCATION_ID."','".$data[$i]->LOCATION."','".$data[$i]->STATUS."','$now','N','sys')";
	//echo $sql."<br />";
	$rs=exec_qry($conn,$sql);
}
	
	
	///solve ticket
	$logs=array();
	$sql="SELECT ticketno FROM tm_tickets WHERE s<>'closed' AND s<>'solved' AND st='wifi station' AND i IN (SELECT oid from tm_dpo WHERE stts='Up')";
	$logs=fetch_alla(exec_qry($conn,$sql));
	for($cntr=0;$cntr<count($logs);$cntr++){
		$data=$logs[$cntr];
		$ticketno=$data['ticketno']; $usr='dvo';
		$sql="insert into tm_notes (ticketid,notes,s,lastupd,updby) values ('$ticketno','Up','solved',now(),'$usr')";
		$rs=exec_qry($conn,$sql);
		$sql="update tm_tickets set s='solved', lastupd=now(), updby='$usr' where ticketno='$ticketno'";
		$rs=exec_qry($conn,$sql);
	}


}//end if holiday
	
disconnect($conn);

?>