<?php
include 'inc.chksession.php';
include 'inc.db.arc.php';
include 'inc.common.php';

$conn = connect();

$q=$_POST['q'];
$id=isset($_POST['id'])?$_POST['id']:'0';
$idx=isset($_POST['idx'])?$_POST['idx']:'';

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
	case 'ticket': $sql="select * from tm_tickets t left join tm_outlets o on t.i=o.oid where t.rowid='$id'"; break;
	
	case 'm2m': $sql="select * from tm_m2ms where rowid='$id'"; break;
	case 'm2mx': $sql="select m.* from tm_m2ms m where m.oidx='$id'"; break;
	
	case 'rcreatelog': $sql="select * from tm_apicreate_log where rowid='$id'"; break;
	
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
	
	case 'mapv': $sql="select distinct lat,lng,	concat(oname,'(',oid,')<br />Reported:',dt,'<br />Solved:',if(s='solved',solved,'')) as popup, if(s='solved','1','0') as icon 
				from tm_outlets o join tm_tickets t on o.oid=t.i where lat<>'' and lng<>'' and s<>'closed' and grp='link' and typ in $homewidget order by icon desc";
				break;
	case 'mapvkuning': $sql="select distinct lat,lng,concat(oname,'(',oid,')') as popup, if(s='solved','1','0') as icon 
				from tm_outlets o join tm_tickets t on o.oid=t.i where lat<>'' and lng<>'' and s<>'closed' and grp='link' and typ in $homewidget
				union select distinct lat,lng,concat(oname,'(',oid,')') as popup, '2' as icon 
				from tm_outlets o join tm_yellow y on o.oid=y.i and i not in (select i from tm_tickets where s<>'closed' and typ in $homewidget)";
				break;
	case 'mapl': $sql="select lat,lng,	concat(oname,'(',oid,')<br />',addr) as popup from tm_outlets where lat<>'' and lng<>'' and (oid='$id' or oname like '%$id%')";
				break;
				
	case 'markui': $sql="select * from tm_runningtext order by lastupd"; break;
	
}

//echo $sql;

$result = exec_qry($conn,$sql);
$output = fetch_alla($result);

disconnect($conn);

echo json_encode( $output );
?>