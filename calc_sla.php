<?php
include 'inc.db.php';
include 'inc.common.php';

date_default_timezone_set("Asia/Jakarta");

function jlentrehken($conn,$data){
	$dari=$data['dfr'];
	$sampai=$data['dto'];
	
	$dtm=$data['dt']; //start
	$clsd=$data['closed']; //end
	
	$tiket=$data['ticketno'];
	$dur=$data['dur'];
	$hari=$data['dft'];
	$jamdari=$data['tfr'];
	$jamsampai=$data['tto'];
	$wibstart=$data['wibstart']==''?'08:00:00':$data['wibstart'];
	$wibend=$data['wibend']==''?'14:30:00':$data['wibend'];
	
	if($dari==$sampai){ //same day
		$durwh = 0;
		if($jamdari>='06:00:00' and $jamsampai<='18:00:00'){ //start-end between 6-18 = clean
			$durwh = $dur;
		}
		if($jamdari>='06:00:00' and $jamsampai>'18:00:00' and $jamdari<'18:00:00'){ //start>6 end after 18
			$durwh = strtotime($sampai.' 18:00:00')-strtotime($dtm);
		}
		if($jamdari<'06:00:00' and $jamsampai>'18:00:00'){ //start<6 end after 18 = full day
			$durwh = 12*60*60;
		}
		if($jamdari<'06:00:00' and $jamsampai<='18:00:00'){ //start<6 end before 18
			$durwh = strtotime($clsd)-strtotime($dari.' 06:00:00');
		}
		
		$durwib=0;
		if($jamdari>=$wibstart and $jamsampai<=$wibend){ //start-end between wibstart-wibend = clean
			$durwib = $dur;
		}
		if($jamdari>=$wibstart and $jamsampai>$wibend and $jamdari<$wibend){ //start>wibstart end after wibend
			$durwib = strtotime($sampai.' '.$wibend)-strtotime($dtm);
		}
		if($jamdari<$wibstart and $jamsampai>$wibend){ //start<wibstart end after wibend = full day
			$durwib = 6.5*60*60; //6.5hour
		}
		if($jamdari<$wibstart and $jamsampai<=$wibend){ //start<wibstart end before wibend
			$durwib = strtotime($clsd)-strtotime($dari.' '.$wibstart);
		}

		$sql="insert into tm_sla_daily (dt,dtm,tiket,dur,durwh,durwib) values ('$dari','$clsd','$tiket','$dur','$durwh','$durwib')";
		echo "-- $tiket --- same day -- $dtm s/d $clsd --- $sql<br />";
		
		$rs=exec_qry($conn,$sql);
		
	}else{ // different day
		$dt=$dari;
		echo "-- $tiket --- $hari days : $dtm s/d $clsd <br />";
		for($j=0;$j<$hari;$j++){
			$k=$j+1;
			$dur=0; $durwh=0; $durwib=0; //reset todays duration
			$lastcrond=$dt." 23:59:59";
			if($k==1){ //first day
				$dur=strtotime($dari.' 23:59:59')-strtotime($dtm); //full duration 24h/d
				if($jamdari>='06:00:00' and $jamdari<'18:00:00'){ //start between 6-18
					$durwh = strtotime($dari.' 18:00:00')-strtotime($dtm); 
				}
				if($jamdari<'06:00:00'){ //start early morning = 12h
					$durwh = 12*60*60;
				}
				
				if($jamdari>=$wibstart and $jamdari<$wibend){ //start between wibstart-wibend
					$durwib = strtotime($dari.' '.$wibend)-strtotime($dtm); 
				}
				if($jamdari<$wibstart){ //start early morning = 12h
					$durwib = 6.5*60*60;
				}
				//open after 18:00:00 durwh ignored
				//open after wibstart durwib ignored
			}
			if($k==$hari){ //last day
				$lastcrond=$clsd;
				$dur=strtotime($clsd)-strtotime($sampai.' 00:00:00'); //full duration 24h/d
				if($jamsampai>'06:00:00' and $jamsampai<='18:00:00'){ //closed between 6-18
					$durwh = strtotime($clsd)-strtotime($sampai.' 06:00:00'); 
				}
				if($jamsampai>'18:00:00'){ //closed late night = 12h
					$durwh = 12*60*60;
				}
				
				if($jamsampai>$wibstart and $jamsampai<=$wibend){ //closed between wibstart-wibend
					$durwib = strtotime($clsd)-strtotime($sampai.' '.$wibstart); 
				}
				if($jamsampai>$wibend){ //closed late night = 12h
					$durwib = 6.5*60*60;
				}
				//closed before 06:00:00 durwh ignored
				//closed before wibstart durwib ignored
			}
			if($k!=1 && $k!=$hari){ //full day
				$dur=24*60*60;
				$durwh=12*60*60;
				$durwib=6.5*60*60;
			}
			$sql="insert into tm_sla_daily (dt,dtm,tiket,dur,durwh,durwib) values ('$dt','$lastcrond','$tiket','$dur','$durwh','$durwib')";
			echo "-- $tiket -- day $k  -- $sql<br />";
			
			$dt=date('Y-m-d',strtotime("$dt +1 day"));
			
			$rs=exec_qry($conn,$sql);
		}
	}
}

function terangken($conn,$dat){
	$tik=$dat["ticketno"]; $s=""; $dtm=strtotime($dat["dt"]);
	$r=fetch_alla(exec_qry($conn,"select * from tm_notes where ticketid='$tik' order by lastupd,rowid"));
	$new=0; $open=0; $prog=0; $solv=0; $pend=0; $avg=0; $pas=0; $usr='';
	for($i=0;$i<count($r);$i++){
		if($s!=$r[$i]["s"]){
			switch($s){
				case "": $new+=(strtotime($r[$i]["lastupd"])-$dtm); break;
				case "new": $new+=(strtotime($r[$i]["lastupd"])-$dtm); break;
				case "open": $open+=(strtotime($r[$i]["lastupd"])-$dtm);
						$usr=($usr==''||$usr=='system')?$r[$i]['updby']:$usr;
						break;
				case "progress": $prog+=(strtotime($r[$i]["lastupd"])-$dtm);
						$usr=($usr==''||$usr=='system')?$r[$i]['updby']:$usr;
						break;
				case "solved": $solv+=(strtotime($r[$i]["lastupd"])-$dtm);
						$usr=($usr==''||$usr=='system')?$r[$i]['updby']:$usr;
						break;
				case "pending": $pend+=(strtotime($r[$i]["lastupd"])-$dtm); break;
			}
			$s=$r[$i]["s"];
			$dtm=strtotime($r[$i]["lastupd"]);
		}
		$pas+=($r[$i]["updby"]=='system')?1:0;
		$avg+=($r[$i]["updby"]!='system'&&$r[$i]["s"]=='progress')?1:0;
	}
	$avg=($avg==0)?0:($prog/$avg);
	$sql="insert ignore into tm_sla_status (dnew,dopen,dprog,dsolv,dpend,tiket,avgprg,pas,usr) values ('$new','$open','$prog','$solv','$pend','$tik','$avg','$pas','$usr')";
	echo $sql."<br />";
	$rs=exec_qry($conn,$sql);
}

$conn = connect();

$sql="select ticketno,dt,closed,DATEDIFF(closed,dt)+1 as dft,DATE(dt) as dfr,DATE(closed) as dto,TIME(dt) as tfr,TIME(closed) as tto,
TIMESTAMPDIFF(SECOND,dt,closed) as dur,wibstart,wibend from tm_tickets t left join tm_outlets o on o.oid=t.i
where s='closed' and YEAR(dt)>=2020 and ticketno not in (select tiket from tm_sla_daily) order by dt limit 50";
$rs=exec_qry($conn,$sql);
$rows=fetch_alla($rs);
for($i=0;$i<count($rows);$i++){
	echo "<br />";
	jlentrehken($conn,$rows[$i]);
	terangken($conn,$rows[$i]);
}

$sql="update tm_sla_daily set dur=0, durwh=0, durwib=0 where dayofweek(dt)=1"; //sunday is off
$rs=exec_qry($conn,$sql);

$sql="update tm_sla_daily set dur=0, durwh=0, durwib=0 where dt in (select dt from tm_holidays)"; //holiday is off
$rs=exec_qry($conn,$sql);

$sql="update tm_sla_daily set dur=0, durwh=0, durwib=0 where tiket in (select ticketno from tm_tickets where p='catudaya-pegadaian')"; //power-pgd is off
$rs=exec_qry($conn,$sql);

disconnect($conn);
?>