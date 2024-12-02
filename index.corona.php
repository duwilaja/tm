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
		//session_start();
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
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $app."-".$title;?></title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="corona/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="corona/assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="corona/assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="corona/assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card col-lg-4 mx-auto">
              <div class="card-body px-5 py-5">
                <h3 class="card-title text-left mb-3">Login</h3>
                <form action="" method="post">
                  <div class="form-group">
                    <label>Username *</label>
                    <input type="text" name="u" class="form-control p_input">
                  </div>
                  <div class="form-group">
                    <label>Password *</label>
                    <input type="password" name="p" class="form-control p_input">
                  </div>
				  <div class="form-group">
                    <input type="text" name="k" class="form-control p_input" placeholder="Type the word here">
                    <img src="captcha.php" style="width:50%;" />
                  </div>
                  <!--div class="form-group d-flex align-items-center justify-content-between">
                    <div class="form-check">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input"> Remember me </label>
                    </div>
                    <a href="#" class="forgot-pass">Forgot password</a>
                  </div-->
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block enter-btn">Login</button>
                  </div>
                  <!--div class="d-flex">
                    <button class="btn btn-facebook mr-2 col">
                      <i class="mdi mdi-facebook"></i> Facebook </button>
                    <button class="btn btn-google col">
                      <i class="mdi mdi-google-plus"></i> Google plus </button>
                  </div>
                  <p class="sign-up">Don't have an Account?<a href="#"> Sign Up</a></p-->
				  <?php if($msg!=""){?>
							<div class="alert alert-danger" role="alert">
                                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                <strong><i class="fa fa-info-circle"></i></strong> <?php echo $msg;?>
                            </div> 
				 <?php } ?>
                </form>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
        <!-- row ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../../assets/js/off-canvas.js"></script>
    <script src="../../assets/js/hoverable-collapse.js"></script>
    <script src="../../assets/js/misc.js"></script>
    <script src="../../assets/js/settings.js"></script>
    <script src="../../assets/js/todolist.js"></script>
    <!-- endinject -->
  </body>
</html>