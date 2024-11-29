<?php
$corona=true;

include 'inc.chksession.php';
include 'inc.common.php';
$title="Change Password";
include 'inc.head.php';

$icon="fa fa-magic";

$menu="cpwd";

include 'inc.menu.php';
?>
                
        
        <div class="main-panel">
          <div class="content-wrapper">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <form id="myf">
									<div class="col-md-4">
									<input type="hidden" name="t" value="<?php echo $menu;?>">
									<input title="ID" class="form-control" type="text" name="uid" value="<?php echo $s_ID;?>" readonly><br />
									<input title="Name" class="form-control" type="text" name="uname" value="<?php echo $s_NAME;?>" readonly><br />
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
          <!-- content-wrapper ends -->


<?php
include 'inc.logout.php';
?>
	
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
