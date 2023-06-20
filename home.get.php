<?php
include 'inc.common.php';
include 'inc.db.php';

$conn=connect();

$translog=0;
$rs=exec_qry($conn,"select count(*) from tm_otrans where timestampdiff(minute,date_format(lastupd,'%Y-%m-%d %H:%i:00'),date_format(now(),'%Y-%m-%d %H:%i:00'))<=75");
if($row=fetch_row($rs)){ $translog=$row[0];}

					$tot1=0;
					$open1=0;
					$pending1=0;
					$solved1=0;
					$progr=0;
					
					$tot2=0;
					$open2=0;
					$pending2=0;
					$solved2=0;
					$closed2=0;
					
					$tot3=0;
					$open3=0;
					$pending3=0;
					$solved3=0;
					
					$rs=exec_qry($conn,"select count(*) from tm_tickets where typ in $homewidget and datediff(date(now()),date(dt))<=30");
					if($row=fetch_row($rs)){ $tot1=$row[0];}
					$rs=exec_qry($conn,"select count(*)  from tm_tickets where typ in $homewidget and s='progress' and datediff(date(now()),date(dt))<=30");
					if($row=fetch_row($rs)){ $progr=$row[0];}
					$rs=exec_qry($conn,"select count(*)  from tm_tickets where typ in $homewidget and s='solved' and datediff(date(now()),date(dt))<=30");
					if($row=fetch_row($rs)){ $solved1=$row[0];}
					$rs=exec_qry($conn,"select count(*) from tm_tickets where typ in $homewidget and s='pending' and datediff(date(now()),date(dt))<=30");
					if($row=fetch_row($rs)){ $pending1=$row[0];}
					$rs=exec_qry($conn,"select count(*) from tm_tickets where typ in $homewidget and s in ('open','new') and datediff(date(now()),date(dt))<=30");
					if($row=fetch_row($rs)){ $open1=$row[0];}
					
					$rs=exec_qry($conn,"select count(*) from tm_tickets where typ = 'relokasi'");
					if($row=fetch_row($rs)){ $tot2=$row[0];}
					$rs=exec_qry($conn,"select count(*)  from tm_tickets where typ = 'relokasi' and s='solved'");
					if($row=fetch_row($rs)){ $solved2=$row[0];}
					$rs=exec_qry($conn,"select count(*) from tm_tickets where typ = 'relokasi' and s='progress'");
					if($row=fetch_row($rs)){ $pending2=$row[0];}
					$rs=exec_qry($conn,"select count(*) from tm_tickets where typ = 'relokasi' and s in ('open','new')");
					if($row=fetch_row($rs)){ $open2=$row[0];}
					$rs=exec_qry($conn,"select count(*) from tm_tickets where typ = 'relokasi' and s='closed'");
					if($row=fetch_row($rs)){ $closed2=$row[0];}
					
					$rs=exec_qry($conn,"select count(*) from tm_tickets where grp='jarkom'");
					if($row=fetch_row($rs)){ $tot3=$row[0];}
					$rs=exec_qry($conn,"select count(*)  from tm_tickets where grp='jarkom' and s='solved'");
					if($row=fetch_row($rs)){ $solved3=$row[0];}
					$rs=exec_qry($conn,"select count(*) from tm_tickets where grp='jarkom' and s='progress'");
					if($row=fetch_row($rs)){ $pending3=$row[0];}
					$rs=exec_qry($conn,"select count(*) from tm_tickets where grp='jarkom' and s in ('open','new')");
					if($row=fetch_row($rs)){ $open3=$row[0];}
					
					
disconnect($conn);
$first=array("total"=>$tot1,"open"=>$open1,"solved"=>$solved1,"pending"=>$pending1,"progr"=>$progr);
$second=array("total"=>$tot2,"open"=>$open2,"solved"=>$solved2,"pending"=>$pending2,"closed"=>$closed2);
$third=array("total"=>$tot3,"open"=>$open3,"solved"=>$solved3,"pending"=>$pending3);

$res=array($first,$second,$third,$translog);
echo json_encode($res);
?>