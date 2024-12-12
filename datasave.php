<?php
include "inc.chksession.php";
include "inc.common.php";
include "inc.db.php";

//error_reporting(E_ERROR);
//ini_set('display_error',1);
//set_time_limit(60*5);

//excel 2003 loader
require "excel_reader.php";

function batch_db($conn,$tname,$data,$pk,$sv,$obj=""){
	$inserted=0;
	$error=0;
	$p=-1;
	$msgs="";
	$s_ID=$_SESSION['s_ID'];
	$pkeys=array();
	$pks=explode(',',$pk);
	
	$columns=str_replace("	",",",$data[0]);
	$acol=explode(",",$columns);

	for($a=0;$a<count($acol);$a++){
		//if($acol[$a]==$pk) { $p=$a; }
		if(in_array($acol[$a],$pks)){$pkeys[]=$a;$p=$a;}
	}
	if($p>-1){
		for($i=1;$i<count($data)-1;$i++){

			$aval=explode("	",$data[$i]);
			$w='';
			for($k=0;$k<count($pkeys);$k++){
				$w.=$w==''?$pks[$k]."='".post($aval[$pkeys[$k]],$conn)."'":" and ".$pks[$k]."='".post($aval[$pkeys[$k]],$conn)."'";
			}
			if($sv=="DEL"){
				$sql="delete from $tname where $w";
				$result = exec_qry($conn,$sql);
			}
			if($sv=="UPD"){
				$s="";
				for($j=0;$j<count($aval);$j++){
					if($s!=""){
						$s.=",";
					}
					$s.=$acol[$j]."='".$aval[$j]."'";
				}
				$sql="update $tname set $s,lastupd=now(),updby='$s_ID' where $w";
				$result = exec_qry($conn,$sql);
			}
			if($sv=="ADD"){
				$val=str_replace("	","','",$data[$i]);
				$sql="insert into $tname (".$columns.",lastupd,updby) values ('".$val."',now(),'$s_ID')";
				$result = exec_qry($conn,$sql);
			}
			//$msgs.= $sql."<br>";
			if(db_error($conn)<>""){
				//$msgs.= $sql.";<br>";
				$msgs.= "ERROR line $i <br />";//.db_error($conn)."<br>";
				$error++;
			}else{
				$inserted++;
			}
		}
		$i--;
		if($obj!=''){
			$txt=$_POST['txt'];
			$sql="insert into tm_updatelogs (obj,typ,tot,suc,err,uid,dtm,txt) values ('$obj','$sv',$i,$inserted,$error,'$s_ID',NOW(),'$txt')";
			$xrs=exec_qry($conn,$sql);
		}
		return "Total : $i <br> Inserted/Updated/Deleted : $inserted <br> Error : $error <br>$msgs";
	}else{
		return "Primary Key $pk is not defined";
	}
}

function crud($conn,$fcols="",$fvals=""){
	$s_ID=$_SESSION['s_ID'];
	$id=post($_POST['id'],$conn);
	$table=post($_POST['tname'],$conn);
	$columns=$_POST['columns'];
	$acols = explode(",",$columns);
	$msg="Data has been saved";
	$sql="";
	$proc="insert";
	
	$afcols = explode(",",$fcols);
	$afvals = explode(",",$fvals);
	
	if($id=="0"){
		for($i=0;$i<count($acols);$i++){
			$sql.=$sql==""?"":",";
			$val=isset($_POST[$acols[$i]])?post($_POST[$acols[$i]],$conn):'';
			$sql.="'".$val."'";
		}
		$columns.=$fcols==""?"":",$fcols";
		$sql.=$fvals==""?"":",$fvals";
		$sql="insert into $table ($columns,lastupd,updby) values ($sql,now(),'$s_ID')";
	}else{
		$addcomma=false;
		for($i=0;$i<count($acols);$i++){
			if(isset($_POST[$acols[$i]])){
				$sql.=$addcomma?",":"";
				$sql.=$acols[$i]."='".post($_POST[$acols[$i]],$conn)."'";
				$addcomma=true;
			}
		}
		for($i=0;$i<count($afcols);$i++){
			$sql.=$sql!=""&&$afcols[$i]!=""?",":"";
			$sql.=$afcols[$i]==""?"":$afcols[$i]."=".$afvals[$i]."";
		}
		$proc="update";
		$sql="update $table set $sql,lastupd=now(),updby='$s_ID' where rowid=$id";
	}
	if($_POST['svt']=="DEL"){
		$proc="delete";
		$sql="delete from $table where rowid=$id";
		$msg="Data has been deleted";
	}
		
		$rs=exec_qry($conn,$sql);
		if(db_error($conn)!=""){
			$msg=db_error($conn);
			//echo count($afcols);
		}else{
			$xsql=base64_encode($sql);
			//$rs=exec_qry($conn,"insert into cms_logs values (null,'$table','$proc','$s_ID',now(),'$xsql')");
		}
	return $msg;
}
function process_file($svt,$fileinput,$lnk="",$dir=""){
		$file_path = "";
		$file_name = "";
		if(isset($_FILES[$fileinput])){
			$file_name = basename($_FILES[$fileinput]['name']);
			$fileInfo = pathinfo($_FILES[$fileinput]['name']);
			//$file_path = $file_path . 'reference_' . $nip . "." . $fileInfo['extension'];
			//$file_name = date('Ymdhis');
			if($file_name!=""){
				$file_name = date('Ymdhis'). "_". $file_name;
				$file_path = $dir .  $file_name;
			}
		}
		if($svt!="DEL"){
			if($file_path!=""){
				if(file_exists($file_path)){
					unlink($file_path);
				}
				/*if($lnk!=""){
					if(file_exists($lnk)){
						unlink($lnk);
						$lnk="";
					}
				}*/
				if(!move_uploaded_file($_FILES[$fileinput]['tmp_name'], $file_path)) {
					$file_path=$lnk;
				}
			}else{
				$file_path = $lnk;
			}
		}else{
			$file_path=$lnk;
			if($file_path!="" && file_exists($file_path)){
				unlink($file_path);
				$file_path="";
			}
		}
		return $file_path;
}

function load_excel($jenis,$file,$col,$conn,$tname,$pk="",$replace=false){
		$s_ID=$_SESSION['s_ID'];
		
		$data = new Spreadsheet_Excel_Reader($file,false);
		//    menghitung jumlah baris file xls
		$baris = $data->rowcount($sheet_index=0);
		//build cols
		$cols="";$pkeys=array();
		$pks=explode(',',$pk);
		for($j=0;$j<$col;$j++){
			$cols.=($cols=="")?$data->val(1,$j):",".$data->val(1,$j);
			if(in_array($data->val(1,$j),$pks)){$pkeys[]=$j;}
		}
		$acols=explode(",",$cols);
		$tot=0; $ins=0; $upd=0; $err=0; $eline=""; $skip=0;
		$msg="";
		for($i=2;$i<=$baris;$i++){
			$tot++;
			//build val
			$vals=""; $uvals=""; $where="";
			for($j=1;$j<$col;$j++){
				$vals.=($vals=="")?"'".post($data->val($i,$j),$conn)."'":",'".post($data->val($i,$j),$conn)."'";
				$uvals.=($uvals=="")?$acols[$j-1]."='".post($data->val($i,$j),$conn)."'":",".$acols[$j-1]."='".post($data->val($i,$j),$conn)."'";
			}
			$sql="insert into $tname ($cols,lastupd,updby) values ($vals,now(),'$s_ID')";
			//$msg.=$sql."<br>";
			$rs=exec_qry($conn,$sql);
			if(affected_row($conn)>0){
				$ins++;
			}else{
				if($replace&&count($pkeys)>0){
					$u=false;
					$w='';
					for($k=0;$k<count($pkeys);$k++){
						$w.=$w==''?$pks[$k]."='".post($data->val($i,$pkeys[$k]),$conn)."'":" and ".$pks[$k]."='".post($data->val($i,$pkeys[$k]),$conn)."'";
					}
					$sql="update $tname set $uvals, lastupd=now(), updby='$s_ID' where $w";
					//$msg.=$sql;
					$rs=exec_qry($conn,$sql);
					if(affected_row($conn)>0){
						$upd++;$u=true;
					}
				}
				if(db_error($conn)!=""){$err++; $eline.=$eline==""?($i-1)."-".db_error($conn):", ".($i-1)."-".db_error($conn);}else{if(!$u){$skip++;}}
				//if(db_error($conn)!=""){$err++; $eline.=$eline==""?($i-1):", ".($i-1);}else{if(!$u){$skip++;}}
			}
			//$msg.=$sql."<br>";
		}
		//$rem=$eline==""?"":"Error Line : $eline";
		//$afile=explode("/",$file);
		//$sq="insert into load_data (jenis,file,dtmstart,dtmend,tot,ins,upd,skp,err,rem) values ('$jenis','".$afile[1]."','$mulai',now(),$tot,$ins,$upd,$skip,$err,'$rem')";
		//$rs=exec_qry($conn,$sq);
		$msg.="Total Read=$tot , Inserted=$ins , Updated=$upd , Skipped:$skip , Error=$err (Line : $eline)";
	return $msg;
}

function multiple_select($f){
	$return="";
	for($i=0;$i<count($_POST[$f]);$i++){
		$return.=$return==""?"":";";
		$return.=$_POST[$f][$i];
	}
	return $return;
}

function post($field,$theconn=null){
	//$return = isset($_POST[$field])?$_POST[$field]:"";
	return $theconn==null?$field:esc_str($theconn,$field);
}

$conn=connect();

$msg="Invalid command.";
$t=$_POST['t'];

if($t=="cpwd"){
	$new=post($_POST['new'],$conn);
	$old=post($_POST['old'],$conn);
	$ret=post($_POST['ret'],$conn);
	if($ret!=""&&$old!=""&&$new!=""){
		if($ret==$new){
			$sql="update tm_users set userpwd=md5('$new') where userid='$s_ID' and userpwd=md5('$old')";
			$rs=exec_qry($conn,$sql);
			if(affected_row($conn)>0){
				$msg="Password changed.";
			}else{
				$msg="Invalid old password.";
			}
		}else{
			$msg="New password and re-type password doesnt match.";
		}
	}else{
		$msg="Old/New/Re-Type password could not blank.";
	}
}

if($t=="users"){
	$id=post($_POST['id'],$conn);
	$userid=post($_POST['userid'],$conn);
	$username=post($_POST['username'],$conn);
	$userpwd=post($_POST['userpwd'],$conn);
	$userlvl=post($_POST['userlevel'],$conn);
	$usergrp=post($_POST['usergrp'],$conn);
	$usermail=post($_POST['usermail'],$conn);
	$msg="Saved";
	$cp="";
	$proc="insert";
	
	if($id=="0"){
		$sql="insert into tm_users (userid,username,userpwd,userlevel,usergrp,usermail) values ('$userid','$username',md5('$userpwd'),'$userlvl','$usergrp','$usermail')";
	}else{
		$cp="";
		//if(isset($_POST['cp'])){
		if($_POST['userpwd']!=""){
			$cp=",userpwd=md5('$userpwd')";
		}//}
		$proc="update";
		$sql="update tm_users set userid='$userid',username='$username',userlevel='$userlvl',usergrp='$usergrp',usermail='$usermail' $cp where rowid=$id";
	}
	if($_POST['svt']=="DEL"){
		$proc="delete";
		$sql="delete from tm_users where rowid=$id";
		$msg="Deleted";
	}
		
		$rs=exec_qry($conn,$sql);
		if(db_error($conn)!=""){
			$msg=db_error($conn);
		}else{
			$xsql=base64_encode($sql);
			//$rs=exec_qry($conn,"insert into cms_logs values (null,'users','$proc','$s_ID',now(),'$xsql')");
		}

}

if($t=="mobileuser"){
	$pwd=($_POST['hupwd']=="")?"":"upwd";
	$vpwd=($_POST['hupwd']=="")?"":"md5('".$_POST['hupwd']."')";
	$msg=crud($conn,$pwd,$vpwd);
}
if($t=="pic"){
	if($_POST["id"]==""){
		$msg="Please select an outlet first.";
	}else{
		$msg=crud($conn);
		if($msg=="Data has been saved") $msg="Data has been saved.";
	}
}
if($t=="kanwil"){
	$msg=crud($conn);
}
if($t=="outlet"){
	$msg=crud($conn);
}
if($t=="ipdr"){
	$msg=crud($conn);
}
if($t=="ips"){
	$msg=crud($conn);
}
if($t=="kanwiluser"){
	$msg=crud($conn);
}
if($t=="problem"){
	$msg=crud($conn);
}
if($t=="notify"){
	$msg=crud($conn);
}
if($t=="holiday"){
	$msg=crud($conn);
}
if($t=="shift"){
	$msg=crud($conn);
}
if($t=="m2m"){
	$msg=crud($conn);
}
if($t=="runtxt"){
	$msg=crud($conn);
}
if($t=="rcreatelog"){
	$msg=crud($conn);
}
if($t=="rwifi"){
	$msg=crud($conn);
	if($_POST["proc"]=="Y") {
		//$msg.="Y";
		$rs=fetch_alla(exec_qry($conn,"select * from tm_dpo where rowid=".post($_POST["id"],$conn)));
		if(count($rs)>0){
			//$msg.="Y";
			$r=$rs[0]; 
			$dt=$r['crtd']; $i=$r["oid"]; $d='Down'; $usr=$s_ID; $nows=date("Y-m-d H:i:s");
			$rid=date("YmdHis",strtotime($dt)); $st='wifi station'; $grp='link'; $typ='offline';
			
			$rs=fetch_alla(exec_qry($conn,"select * from tm_outlets where oid='$i'"));
			if(count($rs)>0){
				//$msg.="Y";
				$h=$rs[0]["oname"];
				$k=$rs[0]["kanwil"];
				$sql="insert into tm_tickets (rowid,ticketno,dtm,createdby,lastupd,updby,dt,i,h,d,k,st,typ,grp) values 
				('$rid','$rid','$nows','$usr','$nows','$usr','$dt','$i','$h','$d','$k','$st','$typ','$grp')";
				$rs=exec_qry($conn,$sql);
				
				$sql="delete from tm_dpo where oid='$i'";
				$rs=exec_qry($conn,$sql);
			}else{
				$msg.="<br />Master outlet not found";
			}
		}
	}
}
if($t=="comment"){
	$msg=crud($conn);
}
if($t=="survey"){
	$msg=crud($conn);
}
if($t=="surveyd"){
	$msg=crud($conn);
}
if($t=="surveydeu"){
	$msg="Data has been saved";
	$cnt=$_POST['cnt']; $id=$_POST['id'];$uid=$_POST['uid'];
	$rs=exec_qry($conn,"delete from tm_surveyresult where survid='$id' and uid='$uid'");
	for($i=1;$i<=$cnt;$i++){
		$qid=$_POST['key_'.$i];
		$val=isset($_POST['val_'.$i])?$_POST['val_'.$i]:"0";
		$sql="insert into tm_surveyresult (survid,qid,v,uid,lastupd,updby) values ('$id','$qid','$val','$uid',now(),'$s_ID')";
		$rs=exec_qry($conn,$sql);
		//echo $sql;
	}
	if(db_error($conn)!=""){
		$msg=db_error($conn);
	}
}
if($t=="ticket"){
	$ada=true;
	if(post($_POST['createdby'],$conn)=='SolarWinds'&&post($_POST['s'],$conn)=='solved'){
		$co=post($_POST['i'],$conn);
		$dt=post($_POST['dt'],$conn);
		$up=fetch_alla(exec_qry($conn,"select rid from tm_apiupdate_log where dt>'$dt' and h like '$co%'"));
		if(count($up)<1){
			$ada=false;
			$msg="No Up Logs. Solved is not allowed.";
		}
	}
	if($ada){
		if(isset($_POST['jp'])){
			$jp=multiple_select("jp");
			//$msg=$jp;
			$msg=crud($conn,"jp","'$jp'");
		}else{
			$msg=crud($conn);
		}
		if($_POST['s']=='closed' && $_POST['blink']=='m2m'){
			$oid=$_POST['i'];
			$sql="update tm_m2ms set stts='Tidak Terpakai' where oidx='$oid'";
			$rs=exec_qry($conn,$sql);
		}
	}
}
if($t=="m2mx"){
	$msg="M2M Assigned.";
	$oid=post($_POST['oid'],$conn);
	$id=post($_POST['id'],$conn);
	$tno=post($_POST['ticketno'],$conn);
	$sql="update tm_m2ms set stts='Terpakai', oidx='$oid', ticketno='$tno' where rowid='$id'";
	$rs=exec_qry($conn,$sql);
	//$msg=$sql;
	if(db_error($conn)!=""){
		$msg=db_error($conn);
	}
}

if($t=="batch_m2mx"){
	$col=9;
	$pk="oid";
	$tname=post($_POST['tname'],$conn);
	$update=true;//isset($_POST['update'])?true:false;
	$file=process_file('SAVE',"uploaded_file","","tmps/");
	$msg="";
	if($file){
		$msg=load_excel('M2M',$file,$col,$conn,$tname,$pk,$update);
	}else{
		$msg="File Upload failed.";
	}
}
if($t=="batch_m2m"){
	$pk="oid";
	$sv=post($_POST['svt'],$conn);
	$tname=post($_POST['tname'],$conn);
	$data=explode("\r\n",$_POST['datas']);
	
	$columns=str_replace("	",",",$data[0]);
	$acol=explode(",",$columns);

	$msg=batch_db($conn,$tname,$data,$pk,$sv);
}
if($t=="batch_outlet"){
	$pk="oid";
	$sv=post($_POST['svt'],$conn);
	$tname=post($_POST['tname'],$conn);
	$data=explode("\r\n",$_POST['datas']);
	
	$columns=str_replace("	",",",$data[0]);
	$acol=explode(",",$columns);

	$msg=batch_db($conn,$tname,$data,$pk,$sv,'Master Outlet');
}
if($t=="batch_ipdr"){
	$pk="f_a";
	$sv=post($_POST['svt'],$conn);
	$tname=post($_POST['tname'],$conn);
	$data=explode("\r\n",$_POST['datas']);
	
	$columns=str_replace("	",",",$data[0]);
	$acol=explode(",",$columns);

	$msg=batch_db($conn,$tname,$data,$pk,$sv);
}
if($t=="bulk_outlet"){
	$tname=post($_POST['tname'],$conn);
	$prop=post($_POST['prop'],$conn);
	$wibs=post($_POST['wibs'],$conn);
	$wibe=post($_POST['wibe'],$conn);
	$sql="update $tname set wibstart='$wibs',wibend='$wibe' where propinsi='$prop'";
	$rs=exec_qry($conn,$sql);
	$msg=affected_row($conn)." rows updated";
}
if($t=="batch_ips"){
	$col=6;
	$pk="oid,layanan";
	$sv=post($_POST['svtf'],$conn);
	$tname=post($_POST['tname'],$conn);
	$data=explode("\r\n",$_POST['datas']);
	
	$columns=str_replace("	",",",$data[0]);
	$acol=explode(",",$columns);

	$msg=batch_db($conn,$tname,$data,$pk,$sv);

	//$tname=$_POST['tname'];
	//$update=true;//isset($_POST['update'])?true:false;
	//$file=process_file('SAVE',"uploaded_file","","tmps/");
	//$msg="";
	//if($file){
	//	$msg=load_excel('IPs',$file,$col,$conn,$tname,$pk,$update);
	//}else{
	//	$msg="File Upload failed.";
	//}
}

if($t=="maintenances"){
	$msg=crud($conn,"dtm,createdby","now(),'$s_ID'");
}
if($t=="tickets"){
	if($_POST['id']=="0"){
		$cek=true;
		$i=post($_POST['i'],$conn);
		$typ=post($_POST['typ'],$conn);
		if($_POST['yakin']==''){
			$st=post($_POST['st'],$conn);
			$grp=post($_POST['grp'],$conn);
			$sql="select ticketno,s,typ,grp from tm_tickets where i='$i' and st='$st' and s<>'closed'";// and typ='$typ'";// and grp='$grp' and
				//timestampdiff(minute,date_format(dtm,'%Y-%m-%d %H:%i:00'),date_format(now(),'%Y-%m-%d %H:%i:00'))<=120";
			$rs=exec_qry($conn,$sql);
			if($row=fetch_row($rs)){
				$msg="Ticket #".$row[0]." exist<br />Outlet# $i<br />(".$row[2]." - $st - ".$row[3]." - ".$row[1].")<br /> Continue?";
				$cek=false;
			}
		}
		if($cek){
			$rid=date("YmdHis");
			$dt=($_POST['dt']=='')?"now()":"'".post($_POST['dt'],$conn)."'";
			$dtx=$dt;
			$ridx=$rid;
			if($typ=='offline'){
				$sql="select max(rid),max(dt) from tm_apicreate_log where (i='$i' or h like '$i-%') and rid not in (select ticketno from tm_tickets)";
				$rs=exec_qry($conn,$sql);
				if($row=fetch_row($rs)){
					if(!is_null($row[0])&&!is_null($row[1])){
						$dtx="'".$row[1]."'"; $ridx=$row[0];
						$sql="select rid from tm_apiupdate_log where (i='$i' or h like '$i-%') and dt>$dtx";
						$rs=exec_qry($conn,$sql);
						if($row=fetch_row($rs)){}else{
							$rid=$ridx; $dt=$dtx;
						}
					}
				}
			}
			
			$msg=crud($conn,"rowid,ticketno,dtm,createdby,dt","'$rid','$rid',now(),'$s_ID',$dt");
		}
	}else{
		$msg=crud($conn);
	}
}
if($t=="notes"){
	$fattc = process_file($_POST['svt'],"fattc",$_POST['attc'],"uploads/");
	$msg=crud($conn,"attc","'$fattc'");
}
if($t=="masstickets"){
	$tid=time();
	$sts=post($_POST["st"],$conn);
	$outlets = json_decode($_POST["outlet"]);
	$typ = post($_POST["typ"],$conn);
	$d = post($_POST["d"],$conn);
	$tname= post($_POST["tname"],$conn);
	$cols = post($_POST["columns"],$conn);
	$dt=($_POST['dt']=='')?"now()":"'".post($_POST['dt'],$conn)."'";
	$itung=0;
	for($i=0;$i<count($outlets);$i++){
		$outlet=$outlets[$i];
		for($j=0;$j<count($sts);$j++){
			$oid=$outlet->oid;
			$st=$sts[$j];
			$r=exec_qry($conn,"select rowid from tm_ips where oid='$oid' and layanan='$st'");
			if($rr=fetch_row($r)){
				$rtid="$tid$i$j";
				$sql="insert into $tname (rowid,ticketno,dt,dtm,createdby,lastupd,updby,gamas,$cols) values 
				('$rtid','$rtid',$dt,now(),'$s_ID',now(),'$s_ID','$tid','".$outlet->oname."','$d','".$outlet->kanwil."','$typ','$oid','$st','link')";
				//echo $sql;
				$rs=exec_qry($conn,$sql);
				$itung++;
			}
		}
	}
	$msg=$itung." tickets created with pattern ($tid).";
}

disconnect($conn);

echo $msg;
?>
