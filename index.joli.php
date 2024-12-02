<?php
$title="Login";
//include "inc.common.php";
include "inc.db.php";

function getmac(){
	return "MAC:MAC:MAC:MAC";
}

$u="";
$p="";
$msg="";
$captcha="";

if(isset($_POST["u"])){$u=$_POST["u"];}
if(isset($_POST["p"])){$p=$_POST["p"];}
if(isset($_GET["m"])){$msg=$_GET['m'];}

if(isset($_POST["k"])){$captcha=$_POST["k"];}
session_start();

if($u!=""&&$captcha==$_SESSION['kode_captcha']){
$loggedin=false;

$sql="select username,userlevel,usergrp from tm_users where (userid='$u') and userpwd=MD5('$p')";

	$conn = connect();
	$rs = exec_qry($conn,$sql);
	if ($row = fetch_row($rs)) {
		//if (!isset($_SESSION['s_ID'])) {
    		$_SESSION['s_ID'] = $u;
		//}
		//if (!isset($_SESSION['s_NAME'])) {
    		$_SESSION['s_NAME'] = $row[0];
		//}
		//if (!isset($_SESSION['s_LVL'])) {
    		$_SESSION['s_LVL'] = $row[1];
		//}
		//if (!isset($_SESSION['s_GRP'])) {
    		$_SESSION['s_GRP'] = $row[2];
		//}
		//if (!isset($_SESSION['s_MAC'])) {
    		$_SESSION['s_MAC'] = getmac();
		//}
		/*$sqlm="select menu from custom_user_menus where userid='$u'";
		$rsm=exec_qry($conn,$sqlm);
		$mnu=fetch_all($rsm);
		if(count($mnu)>0){
			$_SESSION['s_MENU']=$mnu[0];
		}
		*if (!isset($_SESSION['s_ISADMIN'])) {
    		$_SESSION['s_ISADMIN'] = $row[4];
		}
		$msg = "Welcome to Site Manager.<br>";
		$title = "Welcome ".$_SESSION['s_NAME'];*/
		$loggedin=true;
		$sql="insert into tm_userlogs (uid,user_agent,remote_addr,remote_host) values ('$u','".$_SERVER['HTTP_USER_AGENT']."','".$_SERVER['REMOTE_ADDR']."','".$_SERVER['REMOTE_HOST']."')";
		$r=exec_qry($conn,$sql);
	}else{
		$msg="Invalid ID or password.";
	}

	disconnect($conn);
	//if($u=="a"&&$p=="a"){$loggedin=true;session_start();$_SESSION['s_ID']="user";$_SESSION['s_NAME']="Nama User";}else{$msg="Invalid ID or password.";}
if($loggedin){
	if($_SESSION['s_LVL']==9){
		header("Location: homexx$env");
	}else{
		header("Location: home$env");
	}
}
}else{
	if($u!=''){
		$msg="Wrong Captcha.";
	}
}
?>

<!DOCTYPE html>
<html lang="en" class="body-full-height">
    <head>        
        <!-- META SECTION -->
        <title><?php echo $app."-".$title;?></title>            
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <link rel="icon" href="favicon-16.png" type="image/png" />
        <!-- END META SECTION -->
        
        <!-- CSS INCLUDE -->        
        <link rel="stylesheet" type="text/css" id="theme" href="css/theme-default.css"/>
        <!-- EOF CSS INCLUDE -->                                    
    </head>
    <body>
        
        <div class="login-container" style="background-color:rgba(0,0,0,0.05);">
        
            <div class="login-box animated fadeInDown">
                <div class="" style="text-align:center;"><img width="100%" src="img/logo.jpg"><!--&nbsp;&nbsp;<img src="img/bi.png" width="37" height="37"--></div><br />
                <div class="login-body" style="background-color:rgba(0,0,0,0.3);">
                    <div class="login-title"><strong>Welcome</strong>, Please login</div>
                    <form action="" class="form-horizontal" method="post">
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="u" placeholder="Username"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="password" class="form-control" name="p" placeholder="Password"/>
                        </div>
                    </div>
                    <div class="form-group">
						<div class="col-sm-6 text-center">
						  <img src="captcha.php" style="width:100%;" />
						</div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="k" placeholder="Type the word here"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <!--div class="col-md-6">
                            <a href="#" class="btn btn-link btn-block">Forgot your password?</a>
                        </div-->
                        <div class="col-md-6">
                            <button class="btn btn-info btn-block">Log In</button>
                        </div>
						<div class="col-md-6">
                        <?php if($anonfeedback){?>
						    <a href="updatesql.txt" class="btn btn-link btn-block fancybox">Feedback</a>
						<?php } if($anonsurvey){?>
							<a href="#" class="btn btn-link btn-block">Survey</a>
						<?php }?>
                        </div>
                        
                    </div>
                    </form>
                </div>
                <div class="login-footer">
                    <div style="text-align:center;">
                        <a style="color:#000;" href="#">&copy; 2019 </a>
                    </div>
                    <!--div class="pull-right">
                        <a href="#">About</a> |
                        <a href="#">Privacy</a> |
                        <a href="#">Contact Us</a>
                    </div-->
                </div>
				<?php if($msg!=""){?>
							<div class="alert alert-danger" role="alert">
                                <strong><i class="fa fa-info-circle"></i></strong> <?php echo $msg;?>
                            </div> 
				<?php } ?>
            </div>
        </div>
        <!-- START PLUGINS -->
            <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
            <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
            <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>        
			
			<script type="text/javascript" src="js/jquery.fancybox.min.js"></script>
			<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css" media="screen" />
		
            <!-- END PLUGINS -->
			<!-- START TEMPLATE -->
            <script type="text/javascript" src="js/plugins.js"></script>        
            <script type="text/javascript" src="js/actions.js"></script>        
            <!-- END TEMPLATE -->
			
			<script>
			$(document).ready(function() {
				$(".fancybox").fancybox({'type':'iframe'});
			});
			</script>
    </body>
</html>

