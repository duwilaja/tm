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

if(date("H")=="8") $rs=exec_qry($conn,"truncate table tm_dpo");

for($i=0;$i<count($data);$i++){
	if($data[$i]->STATUS=='Up'){
		$sql="delete from tm_dpo where oid='".$data[$i]->LOCATION_ID."'";
	}else{
		$sql="insert ignore into tm_dpo (oid,oname,stts) values ('".$data[$i]->LOCATION_ID."','".$data[$i]->LOCATION."','".$data[$i]->STATUS."')";
	}
	//echo $sql."<br />";
	$rs=exec_qry($conn,$sql);
}

$rs=exec_qry($conn,"update tm_dpo set ctr=ctr+1,lastupd=NOW()");
	
	///create ticket
	$sql="select *,DATE_FORMAT(lastupd,'%Y-%m-%d %H:%i:00') as dts,time(lastupd) as tm from tm_dpo where ctr=3 AND stts='Down' AND 
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
		$dt=$data['crtd'];
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
	
	///solve ticket
	/*$logs=array();
	$sql="SELECT ticketno FROM tm_tickets WHERE s<>'closed' AND s<>'solved' AND st='wifi station' AND i IN (SELECT oid from tm_dpo WHERE stts='Up')";
	$logs=fetch_alla(exec_qry($conn,$sql));
	for($cntr=0;$cntr<count($logs);$cntr++){
		$data=$logs[$cntr];
		$ticketno=$data['ticketno']; $usr='dvo';
		$sql="insert into tm_notes (ticketid,notes,s,lastupd,updby) values ('$ticketno','Up','solved',now(),'$usr')";
		$rs=exec_qry($conn,$sql);
		$sql="update tm_tickets set s='solved', lastupd=now(), updby='$usr' where ticketno='$ticketno'";
		$rs=exec_qry($conn,$sql);
	}*/


}//end if holiday
	
disconnect($conn);

?>