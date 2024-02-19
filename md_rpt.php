<?php
include 'inc.chksession.php';
if($_SESSION['s_LVL']<>"0"){
	echo "you are not super";
	exit;
}
?>
<!DOCTYPE html>
<html lang="en-gb" dir="ltr">
 
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Report</title>
        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
        <link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon.png">
        <link rel="stylesheet" href="uikit/css/uikit.docs.min.css">
		<link rel="stylesheet" href="datatables/css/jquery.dataTables.min.css">
		
		<script src="vendor/jquery.js"></script>
        <script src="uikit/js/uikit.min.js"></script>
		<script src="datatables/js/jquery.dataTables.min.js"></script>
		
    </head>
 
    <body>
 
        <div class="uk-container uk-container-center uk-margin-top uk-margin-large-bottom">
 

<div><h3>Report <?php echo date("d F Y")?><h3></div>

<hr class="uk-grid-divider">

<?php
include 'inc.common.php';
include 'inc.db.php';

$conn = connect();
$totgang=0;
$totlink=0;
$totjark=0;
$jark="(grp='jarkom' and (date(dt)=date(now()) or s <> 'closed'))";
$lnk="($gangguan and (date(dt)=date(now()) or s = 'progress'))";
$sql="select grp,count(grp) as cnt from tm_tickets where ($lnk or $jark) and st<>'LTE' group by grp";
//echo $sql;
$res=fetch_alla(exec_qry($conn,$sql));
for($i=0;$i<count($res);$i++){
	$totgang+=$res[$i]["cnt"];
	if($res[$i]["grp"]=="jarkom") $totjark=$res[$i]["cnt"];
	if($res[$i]["grp"]=="link") $totlink=$res[$i]["cnt"];
}
$totprog=0;
//$sql="select i,h,k,st,dt from tm_tickets where $gangguan and s='progress' and grp='link' and st<>'LTE'";
//echo $sql;
if($totlink>0){
$sql="select i,h,k,st,dt,nossadt from tm_tickets where $gangguan and s='progress' and grp='link' and st<>'LTE'";
$res=fetch_alla(exec_qry($conn,$sql));
$totprog=count($res);
}


echo "Total Tiket		: $totgang Tiket <br />";
echo "Dengan detail sebagai berikut : <br />";
echo "---------------------------------------- <br />";
echo "Tiket Link Telkom	: $totlink Tiket <br />";
echo "Progress  : $totprog Tiket <br />";

for($i=0;$i<$totprog;$i++){
	$d=$res[$i];
	echo ($i+1).".".$d["i"]." ".$d["h"]."<br />";
	echo "Kanwil ".$d["k"]."<br />";
	echo "Jenis Layanan      : ".$d["st"]."<br />";
	echo "Create Ticket      : ".$d["dt"]."<br />";
	echo "Create Ticket Nossa: ".$d["nossadt"]."<br /><br />";
}
echo "Closed   : ".($totlink-$totprog)." Tiket <br />";
echo "---------------------------------------- <br />";
echo "Tiket Link Lintasarta : 0 Tiket <br />";
echo "Progress : 0 Tiket <br />";
echo "Closed : 0 Tiket <br />";
echo "---------------------------------------- <br />";
echo "Tiket Jarkom : $totjark Tiket <br />";

$jp=array("router","switch","juniper","ip phone","handset ip phone","adaptor ip phone","adaptor router");
for($x=0;$x<count($jp);$x++){
	$sql="select ticketno,i,h,k,dt from tm_tickets where jp = '".$jp[$x]."' and s<>'closed' and grp='jarkom' and st<>'LTE'";
	$res=fetch_alla(exec_qry($conn,$sql));
	$totprog=count($res);
	echo "- ".$jp[$x]." : $totprog Ticket <br />";
	for($i=0;$i<$totprog;$i++){
		$d=$res[$i];
		echo ($i+1).".".$d["i"]." ".$d["h"]."<br />";
		echo "Kanwil ".$d["k"]."<br />";
		echo "Create Ticket      : ".$d["dt"]."<br />";
		$n=fetch_alla(exec_qry($conn,"select notes from tm_notes where ticketid='".$d["ticketno"]."' order by lastupd desc limit 1"));
		if(count($n)>0){
			echo $n[0]["notes"]."<br /><br />";
		}
	}
}

disconnect($conn);

?>

<br /><br />
<hr class="uk-grid-divider">
			
		</div>
 
 	</body>
 
</html>
