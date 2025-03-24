<?php
include 'inc.chksession.php';
include 'inc.db.php';
include 'inc.common.php';

$conn = connect();

$q=$_POST['q'];
$id=isset($_POST['id'])?$_POST['id']:'0';
$idx=isset($_POST['idx'])?$_POST['idx']:'';
$idx2=isset($_POST['idx2'])?$_POST['idx2']:'';
$idx3=isset($_POST['idx3'])?$_POST['idx3']:'';
$idx4=isset($_POST['idx4'])?$_POST['idx4']:'';

switch($q){
	case 'users': $sql="select userid,username,userlevel,usergrp,usermail from tm_users where rowid='$id'"; break;
	case 'kanwiluser': $sql="select * from tm_kanwilusers where rowid='$id'"; break;
	case 'kanwil': $sql="select * from tm_kanwils where rowid='$id'"; break;
	case 'problem': $sql="select * from tm_problems where rowid='$id'"; break;
	case 'notify': $sql="select * from tm_timers where rowid='$id'"; break;
	case 'holiday': $sql="select * from tm_holidays where rowid='$id'"; break;
	case 'shift': $sql="select * from tm_shifts where rowid='$id'"; break;
	case 'runtxt': $sql="select * from tm_runningtext where rowid='$id'"; break;
	case 'tickets': $sql="select * from tm_tickets where rowid='$id'"; break;
	case 'outlet': $sql="select * from tm_outlets where rowid='$id'"; break;
	case 'ips': $sql="select * from tm_ips where rowid='$id'"; break;
	case 'houtlet': $sql="select * from tm_outlets where oid='$id'"; break;
	case 'houtletx': $sql="select oid,oname,kanwil from tm_outlets where oid='$id' or area like '%$id%' order by oname"; break;
	case 'hip': $sql="select * from tm_ips where oid='$id' and layanan='$idx'"; break;
	case 'ticket': $sql="select *,DATE(o.lastupd) as oupd from tm_tickets t left join tm_outlets o on t.i=o.oid where t.rowid='$id'"; break;
	
	case 'ipdr': $sql="select * from ipdr where rowid='$id'"; break;
	
	case 'm2m': $sql="select * from tm_m2ms where rowid='$id'"; break;
	case 'm2mx': $sql="select m.* from tm_m2ms m where m.oidx='$id'"; break;
	
	case 'rcreatelog': $sql="select * from tm_apicreate_log where rowid='$id'"; break;
	case 'rwifi': $sql="select * from tm_dpo where rowid='$id'"; break;
	
	case 'comment': $sql="select * from tm_comments where rowid='$id'"; break;
	case 'survey': $sql="select * from tm_surveys where rowid='$id'"; break;
	case 'surveyd': $sql="select * from tm_survey where rowid='$id'"; break;
	
	case 'notif': $where="o='1'"; $lastupd="lastupd as tglj";
		if($s_LVL==4){$lastupd="dtm as tglj";}
		$where.=$s_LVL==0?" and s<>'closed'":""; //all
		$where.=$s_LVL==4?" and s='solved' and k in (select kanwil from tm_kanwilusers where user='$s_ID')":""; //pgd
		$where.=$s_LVL==5?" and s in ('new','open','pending','progress') and grp = '$s_GRP'":""; //eng
		$sql="select rowid,s,h,$lastupd from tm_tickets where $where order by lastupd desc"; 
		break;
		
	case 'notifall': $where="1=1"; $lastupd="lastupd as tglj";
		if($s_LVL==4){$lastupd="dtm as tglj";}
		$where.=$s_LVL==0?" and s<>'closed'":""; //all
		$where.=$s_LVL==4?" and s='solved' and k in (select kanwil from tm_kanwilusers where user='$s_ID')":""; //pgd
		$where.=$s_LVL==5?" and s in ('new','open','pending','progress') and grp = '$s_GRP'":""; //eng
		$sql="select rowid,s,h,$lastupd from tm_tickets where $where order by lastupd desc"; 
		break;
		
	case 'log': $sql="select rowid,s,h,lastupd from tm_tickets where date(lastupd)=date(now()) order by lastupd desc"; break;
	
	case 'bar': $sql="select date(dt) as y, count(rowid) as a from tm_tickets where date(dt)<='$idx' and date(dt)>='$id' group by y"; break;
	
	case 'mapv': $sql="select distinct lat,lng,	concat(oname,'(',oid,')<br />Service: ',st,'<br />Reported: ',dt,'<br />Solved: ',if(s='solved',solved,'')) as popup, if(s='solved','1','0') as icon 
				from tm_outlets o join tm_tickets t on o.oid=t.i where lat<>'' and lng<>'' and s<>'closed' and (grp='link' or st='xxx') and typ in $homewidget order by icon desc";
				break;
	case 'todays': $sql="select s,count(s) as c from tm_tickets where timestampdiff(hour,dt,now())<=24 and (grp='link' or st='xxx') and typ in $homewidget group by s"; break;
	case 'agings': $sql="select timestampdiff(minute,dt,now()) as a,count(s) as c from tm_tickets where s<>'closed' and (grp='link' or st='xxx') and typ in $homewidget group by a"; break;
	
	case 'mapvkuning': $sql="select distinct lat,lng,concat(oname,'(',oid,')') as popup, if(s='solved','1','0') as icon 
				from tm_outlets o join tm_tickets t on o.oid=t.i where lat<>'' and lng<>'' and s<>'closed' and grp='link' and typ in $homewidget
				union select distinct lat,lng,concat(oname,'(',oid,')') as popup, '2' as icon 
				from tm_outlets o join tm_yellow y on o.oid=y.i and i not in (select i from tm_tickets where s<>'closed' and typ in $homewidget)";
				break;
	case 'mapl': $sql="select lat,lng,	concat(oname,'(',oid,')<br />',svcs,'<br />',addr) as popup from tm_outlets where lat<>'' and lng<>'' and 
				(oid='$id' or oname like '%$id%') and buprovider like '%$idx%' and lnk like '%$idx2%' and kanwil like '%$idx3%' and tipe like '%$idx4%'";
				break;
				
	case 'markui': $sql="select * from tm_runningtext order by lastupd desc"; break;
	
	case '30days': $sql="select s,count(*) as t from tm_tickets where grp='link' and typ in $homewidget and datediff(date(now()),date(dt))<=30 group by s"; break;
	case 'prm': $sql="select s,count(*) as t,typ,grp from tm_tickets where typ in ('relokasi','psb','migrasi') group by s,typ,grp"; break;
	case 'jarkom': $sql="select s,count(*) as t from tm_tickets where grp='jarkom' and typ not in ('relokasi','psb','migrasi') group by s"; break;
	case 'trlog': $sql="select count(*) as trlog from tm_otrans where timestampdiff(minute,date_format(lastupd,'%Y-%m-%d %H:%i:00'),date_format(now(),'%Y-%m-%d %H:%i:00'))<=75"; break;
	case 'kao': $sql="select tipe,COUNT(tipe) as tot from tm_outlets GROUP BY tipe"; break;
	
	case 'homepie': $or11=$idx=='link'?")":" or 1=1) and s<>'closed'";
		$sql="select $id as x,COUNT($id) as y from tm_tickets WHERE grp='$idx' and ((timestampdiff(hour,dt,now())<=24 $or11) GROUP BY $id"; break;
	case 'homerel': $sql="select datediff(date(now()),date(tp)) as z, st as x,COUNT(rowid) as y from tm_tickets WHERE typ='relokasi' and s<>'closed' GROUP BY z,x ORDER BY x,z"; break;
	case 'homebar': $sql="select DATE_FORMAT(dt,'%b %Y') as x,COUNT(rowid) as y from tm_tickets WHERE YEAR(dt)=YEAR(now()) GROUP BY DATE_FORMAT(dt,'%b %Y') ORDER BY year(dt),month(dt)"; break;
}

//echo $sql;

$result = exec_qry($conn,$sql);
$output = fetch_alla($result);

disconnect($conn);

echo json_encode( $output );
?>