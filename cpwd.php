<?php
include 'inc.chksession.php';
include 'inc.common.php';
$title="Change Password";
include 'inc.head.php';

$icon="fa fa-magic";

$menu="cpwd";

?>
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
<?php
include 'inc.menu.php';
?>
                
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="home.php">Home</a></li>
                    <li class="active"><?php echo $title;?></li>
                </ul>
                <!-- END BREADCRUMB -->                
                
                <div class="page-title">                    
                    <h2><span class="<?php echo $icon;?>"></span> <?php echo $title;?></h2>
                </div>                   
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">                
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <form id="myf">
									<div class="col-md-4">
									<input type="hidden" name="t" value="<?php echo $menu;?>">
									<input title="ID" class="form-control" type="text" name="uid" value="<?php echo $s_ID;?>" disabled><br />
									<input title="Name" class="form-control" type="text" name="uname" value="<?php echo $s_NAME;?>" disabled><br />
									<input title="Old Password" class="form-control" type="password" name="old" value="" placeholder="Old Password"><br />
									<input title="New Password" class="form-control" type="password" name="new" value="" placeholder="New Password"><br />
									<input title="Re-Type Password" class="form-control" type="password" name="ret" value="" placeholder="Re-Type Password"><br />
									<button type="button" class="btn btn-success" onclick="sendData('#myf');">Submit</button>
									<br /><br/><div id="pesan"></div>
									</div>
									</form>
                                </div>
                            </div>
                        </div>
                    </div>
                
                </div>
                <!-- PAGE CONTENT WRAPPER -->                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

<?php
include 'inc.logout.php';
?>

    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>        
        <!-- END PLUGINS -->

        <!-- THIS PAGE PLUGINS -->
        <script type='text/javascript' src='js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
        <script type='text/javascript' src='js/plugins/jquery-validation/jquery.validate.js'></script>
		<!-- END PAGE PLUGINS -->       

        <!-- START TEMPLATE >
        <script type="text/javascript" src="js/settings.js"></script-->
        
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>        
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->         
	
	<script>
		function sendData(f){	
			manage_msgs('start');
			$("#modal_no_head").modal('show');
			
			var url='datasave.php';
			var mtd='POST';
			var frmdata=$(f).serialize();
			
			//alert(frmdata);
			
			$.ajax({
				type: mtd,
				url: url,
				data: frmdata,
				success: function(data){
					$("#processing_msgs").html(data);
					manage_msgs('end');
					
				}
			});
			
		};

	</script>
	
    </body>
</html>

