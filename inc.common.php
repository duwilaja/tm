<?php
$env=".php";
$app="Cloud NEO Pegadaian ";

$template=isset($corona)?"corona":"joli"; // joli / corona
//$template="corona";
//$dark=isset($_GET['dark'])?$_GET['dark']:1;
//$dark=$dark==1?true:false;
$dark=false;

$feedback=false;
$anonfeedback=false;
$anonsurvey=false;

$onetofive=array("1"=>"Very Bad","2"=>"Bad","3"=>"Average","4"=>"Good","5"=>"Very Good");
$onetothree=array("1"=>"Bad","2"=>"Average","3"=>"Good");
$onetoten=array("1"=>"1","2"=>"2","3"=>"3","4"=>"4","5"=>"5","6"=>"6","7"=>"7","8"=>"8","9"=>"9","10"=>"10");
$surveyopt=array("1-3"=>$onetothree,"1-5"=>$onetofive,"1-10"=>$onetoten);

$optsurvey="<option value='1-3'>1-3 score</option><option value='1-5'>1-5 score</option><option value='1-10'>1-10 score</option>";


$homewidget="('offline','keluhan lambat','link up-down','link intermitten','ganti IP WAN ke LAN','ganti IP LAN ke WAN')";
$homewidget2="('pengecekan router','pengecekan switch','pengecekan ip phone')";

$gangguan="(nossa<>'-' and nossa<>'') and typ in ('offline','keluhan lambat','link up-down','link intermitten')";
 
$r_templates=array(

			array("0","Relokasi","tm_tickets",
			"Tanggal/Jam,Kode,Nama,Kanwil,Layanan,#,Pelaksanaan,Status,Selesai,Ket,Durasi,Secondary Link,Secondary Durasi",
			"dt,i,h,k,st,ticketno,tp,s,closed,solving,MY_TIMEDIFF(dt,closed) as wx,blink,MY_TIMEDIFF(bdtm,solved) as wx2,ticketno","typ='relokasi'"), // id,title,tbl,caps,cols,where
			array("1","PSB","tm_tickets",
			"Tanggal/Jam,Kode,Nama,Kanwil,Layanan,#,Pelaksanaan,Status,Selesai,Ket",
			"dt,i,h,k,st,ticketno,tp,s,closed,solving,ticketno","typ='psb'"),
			array("2","Gangguan","tm_tickets",
			"Tanggal/Jam,Kode,Nama,Kanwil,Layanan,Problem,#,Nossa,Penyebab,Perbaikan,Created,Solved,Closed,ShallClosed,Total,Secondary.Link,W,W/O,Petugas Input,CloseBy",
			"dt,i,h,k,st,d,ticketno,nossa,p,solving,dtm,solved,closed,MY_CLOSED(s,solved,closed) as sc,TIMEDIFF(closed,dt) as w,blink,TIMEDIFF(solved,bdtm) as w2,
			TIMEDIFF(TIMEDIFF(closed,dt),TIMEDIFF(solved,bdtm)) as w3,createdby,IF(s='closed',updby,'') as clsby,ticketno",$gangguan),
			array("3","Migrasi","tm_tickets",
			"Tanggal/Jam,Kode,Nama,Kanwil,Layanan,#,Pelaksanaan,Status,Selesai,Ket,Deskripsi",
			"dt,i,h,k,st,ticketno,tp,s,closed,solving,d,ticketno","typ='migrasi'"),
			array("4","Wifi Station","tm_tickets",
			"Tanggal/Jam,Nama,Kanwil,Layanan,Problem,#,Nossa,Penyebab,Perbaikan,Selesai,Total,Secondary.Link,W,W/O,Petugas Input",
			"dt,h,k,st,d,ticketno,nossa,p,solving,closed,TIMEDIFF(closed,dt) as w,blink,TIMEDIFF(solved,bdtm) as w2,
			TIMEDIFF(TIMEDIFF(closed,dt),TIMEDIFF(solved,bdtm)) as w3,createdby,ticketno","st = 'wifi station'  and  typ in $homewidget"),
			array("5","Jarkom","tm_tickets",
			"Tanggal/Jam,Kode,Nama,Kanwil,Layanan,Problem,#,Nossa,Penyebab,Perbaikan,Created,Progress,Solved,Closed,ShallClosed,Total,Secondary.Link,W,W/O,Petugas Input,Status,Perangkat,Gangguan",
			"dt,i,h,k,st,d,ticketno,nossa,p,solving,dtm,progress,solved,closed,MY_CLOSED(s,solved,closed) as sc,TIMEDIFF(closed,dt) as w,blink,TIMEDIFF(solved,bdtm) as w2,
			TIMEDIFF(TIMEDIFF(closed,dt),TIMEDIFF(solved,bdtm)) as w3,createdby,s,jp,typ,ticketno","grp='jarkom'"),// and typ in ('pengecekan router','pengecekan switch','pengecekan ip phone')"),
            array("6","Durasi Gangguan >=1 hari","tm_tickets t left join tm_outlets o on o.oid=t.i",
			"Kode,Kanwil,Nama,Link,Hari,Durasi,Penyebab,Backup","i,k,h,st,DAYNAME(dt) as dn,MY_TIMEDIFF(dt,closed) as w,p,buprovider,ticketno","$gangguan and TIMESTAMPDIFF(HOUR,dt,solved)>24"),
			array("7","Gangguan >=3x","tm_tickets t left join tm_outlets o on o.oid=t.i",
			"Kode,Kanwil,Nama,&Sigma; Tiket,Durasi,Backup Link,Backup",
			"i,k,h,COUNT(ticketno) as cnt,MY_SECTOTIME(SUM(TIMESTAMPDIFF(SECOND,dt,closed))) as w,blink,buprovider",$gangguan,
			"i,k,h,blink", "count(ticketno)>2"),
			array("8","Solved By SolarWinds","tm_tickets",
			"No.Tiket,Tgl,ID,Nama,Kanwil,Layanan,Masalah,Status,Solved,Closed,Filter,Ket",
			"ticketno,dt,i,h,k,st,typ,s,solved,closed,p,solving","ticketno in (select ticketid from tm_notes where s='solved' and updby='SolarWinds')"),
            array("9","Jarkom-RMA","tm_tickets",
			"Tanggal/Jam,Kode,Nama,Kanwil,Layanan,Problem,#,Nossa,Penyebab,Perbaikan,Selesai,Total,Secondary.Link,W,W/O,Petugas Input,Status",
			"dt,i,h,k,st,d,ticketno,nossa,p,solving,closed,TIMEDIFF(closed,dt) as w,blink,TIMEDIFF(solved,bdtm) as w2,
			TIMEDIFF(TIMEDIFF(closed,dt),TIMEDIFF(solved,bdtm)) as w3,createdby,s","grp='jarkom' and p='RMA'"),
			array("10","Rekonsiliasi","tm_tickets t left join tm_problems p on p.probid=t.p left join tm_ips y on y.oid=t.i and y.layanan=t.st",
			"Ticket#,Open,Close,Duration,Jenis,Nossa,Kanwil,Unit,Class,Nama,SID,Penyebab,Solusi,Link,Filtering,Gamas,Laporan,Jml.Hari,Hari,Triwulan,C/O,ShallClosed,By,BOQ",
			"ticketno,DATE_FORMAT(dt,'%d-%m-%Y %H:%i:%s') as dts,DATE_FORMAT(closed,'%d-%m-%Y %H:%i:%s') as cls,
			REPLACE(MY_TIMEDIFF(dt,IF(s='closed',closed,NOW())),'d','hari') as tmd,'Gangguan' as jns,nossa,k,i,'' as area,h,'' as sid,p,solving,st,grping,
			gamas,typ,if(TIMESTAMPDIFF(SECOND,dt,IF(s='closed',closed,NOW()))>=86400,'>= 1 hari','< 1 hari') as heri,dayname(dt) as dy,QUARTER(dt) as twl,
			if(MONTH(dt)=MONTH(closed) AND YEAR(dt)=YEAR(closed),'','Y') as co,MY_CLOSED(s,solved,closed) as sc,t.updby,boq,ticketno",
			"s='closed' and $gangguan"),//"(TIMESTAMPDIFF(MINUTE,t.dt,solved)>15 or (nossa<>'-' and nossa<>'')) and typ in ('offline','keluhan lambat','link up-down','link intermitten')"),
			array("11","Solved To Closed","tm_tickets",
			"No.Tiket,Tgl,ID,Nama,Kanwil,Layanan,Masalah,Status,Solved,Closed,Durasi,Filter,Ket,By",
			"ticketno,dt,i,h,k,st,typ,s,solved,closed,TIMEDIFF(closed,solved) as dur,p,solving,updby","s='closed'"),
            array("12","Gangguan > 15mnt","tm_tickets",
			"Tanggal/Jam,Kode,Nama,Kanwil,Layanan,Problem,#,Nossa,Penyebab,Perbaikan,Selesai,Total,Secondary.Link,W,W/O,Petugas Input",
			"dt,i,h,k,st,d,ticketno,nossa,p,solving,closed,TIMEDIFF(closed,dt) as w,blink,TIMEDIFF(solved,bdtm) as w2,
			TIMEDIFF(TIMEDIFF(closed,dt),TIMEDIFF(solved,bdtm)) as w3,createdby,ticketno",
			"(TIMESTAMPDIFF(MINUTE,dt,solved)>15 or (nossa<>'-' and nossa<>'')) and typ in ('offline','keluhan lambat','link up-down','link intermitten')"),
			array("13","Relokasi VPN/VSAT > 8 weeks","tm_tickets",
			"Tanggal/Jam,Kode,Nama,Kanwil,Layanan,#,Pelaksanaan,Status,Selesai,Ket,Durasi,Secondary Link,Secondary Durasi",
			"dt,i,h,k,st,ticketno,tp,s,closed,solving,MY_TIMEDIFF(dt,closed) as wx,blink,MY_TIMEDIFF(bdtm,solved) as wx2,ticketno",
			"typ='relokasi' and st in ('vpn','vsat') and s<>'closed' and TIMESTAMPDIFF(HOUR,tp,DATE(now()))>1744"), // id,title,tbl,caps,cols,where
			array("14","Relokasi Wifi > 6 weeks","tm_tickets",
			"Tanggal/Jam,Kode,Nama,Kanwil,Layanan,#,Pelaksanaan,Status,Selesai,Ket,Durasi,Secondary Link,Secondary Durasi",
			"dt,i,h,k,st,ticketno,tp,s,closed,solving,MY_TIMEDIFF(dt,closed) as wx,blink,MY_TIMEDIFF(bdtm,solved) as wx2,ticketno",
			"typ='relokasi' and st = 'wifi station' and s<>'closed' and TIMESTAMPDIFF(HOUR,tp,DATE(now()))>1008"), // id,title,tbl,caps,cols,where
			array("15","Summary Gangguan","tm_tickets",
			"Jenis,Jumlah,Durasi",
			"typ,COUNT(rowid),MY_SECTOTIME(SUM(TIMESTAMPDIFF(SECOND,dt,closed))) as dur","s='closed' and $gangguan","typ"),
            array("16","Progress Aging","tm_tickets",
			"No.Tiket,Tgl,ID,Nama,Kanwil,Layanan,Masalah,Status,Last Update,By,Age(h)",
			"ticketno,dt,i,h,k,st,typ,s,lastupd,updby,TIMESTAMPDIFF(HOUR,lastupd,NOW()) as x,rowid","s='progress' and typ in $homewidget"),
            array("17","Gangguan Link >3x All","tm_tickets t left join tm_outlets o on o.oid=t.i",
			"Kode,Wilayah,Nama Outlet,Jml Tiket,Durasi,Backup Link,Wi-Fi",
			"i,k,h,COUNT(i) as cnt,MY_SECTOTIME(SUM(TIMESTAMPDIFF(SECOND,dt,closed))) as dur,buprovider,wifi","s='closed' and $gangguan",
			"i,k,h,buprovider,wifi","COUNT(i)>3"),
            array("18","Gangguan >3x Main Link","tm_tickets t left join tm_outlets o on o.oid=t.i",
			"Kode,Wilayah,Nama Outlet,Jml Tiket,Durasi,Backup Link,Wi-Fi",
			"i,k,h,COUNT(i) as cnt,MY_SECTOTIME(SUM(TIMESTAMPDIFF(SECOND,dt,closed))) as dur,buprovider,wifi","st in ('vpn','vsat') and s='closed' and $gangguan",
			"i,k,h,buprovider,wifi","COUNT(i)>3"),
                        );
			

$optgrp="<option value='link'>link</option><option value='jarkom'>jarkom</option>";
$opttyp="
<option value='offline'>Gangguan - Offline</option>
<option value='keluhan lambat'>Gangguan - keluhan lambat</option>
<option value='link up-down'>Gangguan - link up-down</option>
<option value='link intermitten'>Gangguan - link intermitten</option>
<option value='ganti IP WAN ke LAN'>ganti IP WAN ke LAN</option>
<option value='ganti IP LAN ke WAN'>ganti IP LAN ke WAN</option>
<option value='migrasi'>Migrasi</option>
<option value='psb'>PSB</option>
<option value='relokasi'>Relokasi</option>
<option value='reposisi modem'>Reposisi - Modem</option>
<option value='vsat reposisi'>Reposisi - VSAT</option>
<option value='vpn reposisi'>Reposisi - VPN</option>
<option value='fo reposisi'>Reposisi - FO</option>
<option value='pengecekan AP'>Pengecekan Access Point</option>
<option value='pengecekan router'>Pengecekan Router</option>
<option value='pengecekan switch'>Pengecekan Switch</option>
<option value='pengecekan firewall'>Pengecekan firewall</option>
<option value='pengecekan ip phone'>Pengecekan ip phone</option>
<option value='pengecekan SDWAN'>Pengecekan SDWAN</option>
";
$optjp="
<option value='router'>router</option>
<option value='switch'>switch</option>
<option value='juniper'>juniper</option>
<option value='ip phone'>ip phone</option>
<option value='handset ip phone'>handset ip phone</option>
<option value='adaptor ip phone'>adaptor ip phone</option>
<option value='adaptor router'>adaptor router</option>
";
$optst="
<option value='vpn'>VPN</option>
<option value='vsat'>VSAT</option>
<option value='m2m'>M2M</option>
<option value='astinet'>ASTINET</option>
<option value='sdwan'>SDWAN</option>
<option value='wifi station'>Wifi Station</option>
<option value='LTE'>LTE</option>
<option value='router/switch/ip-phn'>router/switch/ip phone</option>
<option value='Access Point'>Access Point</option>
<option value='Switch'>Switch</option>
<option value='Firewall'>Firewall</option>
<option value='Router'>Router</option>
";

$optblink="
<option value='-'>-</option>
<option value='m2m'>M2M</option>
<option value='Lintasarta'>Lintasarta</option>
<option value='sdwan lte'>SDWAN LTE</option>
<option value='anyconnect'>Anyconnect</option>
<option value='user menolak'>User Menolak</option>
<option value='temporary link belum digunakan'>Temporary Link belum digunakan</option>
";

function array_to_radio($id,$hidden,$arr){
	$return="";
	$return .= '<input type="hidden" name="key_'.$id.'" value="'.$hidden.'">';
	foreach($arr as $key=>$val){
		$return .= '<input type="radio" name="val_'.$id.'" value="'.$key.'">&nbsp;&nbsp;'.$val.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	}
	return $return;
}
function sec_to_dhmsx($seconds){
	$dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%a days %h:%i:%s');
}
function sec_to_dhms($seconds){
	$s = (int)$seconds;
    return sprintf('%d days %02d:%02d:%02d', $s/86400, $s/3600%24, $s/60%60, $s%60);
}

$ipdrfields = [
['f_a','Nama Field a'],
['f_b','Nama Field b'],
['f_c','Nama Field c'],
['f_d','Nama Field d'],
['f_e','Nama Field e'],
['f_f','Nama Field f'],
['f_g','Nama Field g'],
['f_h','Nama Field h'],
['f_i','Nama Field i'],
['f_j','Nama Field j'],
['f_k','Nama Field k'],
['f_l','Nama Field l'],
['f_m','Nama Field m'],
['f_n','Nama Field n'],
['f_o','Nama Field o'],
['f_p','Nama Field p'],
['f_q','Nama Field q'],
['f_r','Nama Field r'],
['f_s','Nama Field s'],
['f_t','Nama Field t'],
['f_u','Nama Field u'],
['f_v','Nama Field v'],
['f_w','Nama Field w'],
['f_x','Nama Field x'],
['f_y','Nama Field y'],
['f_z','Nama Field z'],
['f_aa','Nama Field aa'],
['f_ab','Nama Field ab'],
['f_ac','Nama Field ac'],
['f_ad','Nama Field ad'],
['f_ae','Nama Field ae'],
['f_af','Nama Field af'],
['f_ag','Nama Field ag'],
['f_ah','Nama Field ah'],
['f_ai','Nama Field ai'],
['f_aj','Nama Field aj'],
['f_ak','Nama Field ak'],
['f_al','Nama Field al'],
['f_am','Nama Field am'],
['f_an','Nama Field an'],
['f_ao','Nama Field ao'],
['f_ap','Nama Field ap'],
['f_aq','Nama Field aq'],
['f_ar','Nama Field ar'],
['f_as','Nama Field as'],
['f_at','Nama Field at'],
['f_au','Nama Field au'],
['f_av','Nama Field av'],
['f_aw','Nama Field aw'],
['f_ax','Nama Field ax'],
['f_ay','Nama Field ay'],
['f_az','Nama Field az'],
['f_ba','Nama Field ba'],
['f_bb','Nama Field bb'],
['f_bc','Nama Field bc'],
['f_bd','Nama Field bd'],
['f_be','Nama Field be'],
['f_bf','Nama Field bf'],
['f_bg','Nama Field bg'],
['f_bh','Nama Field bh'],
['f_bi','Nama Field bi'],
['f_bj','Nama Field bj'],
['f_bk','Nama Field bk'],
['f_bl','Nama Field bl'],
['f_bm','Nama Field bm'],
['f_bn','Nama Field bn'],
['f_bo','Nama Field bo'],
['f_bp','Nama Field bp'],
['f_bq','Nama Field bq'],
['f_br','Nama Field br'],
['f_bs','Nama Field bs'],
['f_bt','Nama Field bt'],
['f_bu','Nama Field bu'],
['f_bv','Nama Field bv'],
['f_bw','Nama Field bw'],
['f_bx','Nama Field bx'],
['f_by','Nama Field by'],
['f_bz','Nama Field bz']
];
?>
