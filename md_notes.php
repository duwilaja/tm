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
        <title>Batch Input</title>
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
 

<div><h3>Data<h3></div>

<hr class="uk-grid-divider">

<?php
include 'inc.db.php';
$conn=connect();
$rs=exec_qry($conn,"select * from tm_notes where ticketid='".$_GET["id"]."' order  by lastupd desc");
$datas=fetch_alla($rs);
disconnect($conn);
?>

<table border="1">
<tr>
<td>rowid</td>
<td>ticketid</td>
<td>notes</td>
<td>lastupd</td>
<td>updby</td>
<td>s</td>
</tr>
<?php for($i=0;$i<count($datas);$i++){ 
$data=$datas[$i];
?>
<tr>
<td><?php echo $data['rowid']?></td>
<td><?php echo $data['ticketid']?></td>
<td><?php echo $data['notes']?></td>
<td><?php echo $data['lastupd']?></td>
<td><?php echo $data['updby']?></td>
<td><?php echo $data['s']?></td>
</tr>
<?php }
?>
</table>

<hr class="uk-grid-divider">
			
		</div>
 
 	</body>
 
</html>
