<?php
include 'inc.chksession.php';
include 'inc.common.php';
include 'inc.db.php';

$menu="home";
$title="Home";
$icon="fa fa-tachometer";

include 'inc.head.php';

$conn=connect();
?>
<style type="text/css">
.widget.widget-secondary{
	background: linear-gradient(to bottom, #54321a 0%, #54321f 100%);
}
</style>
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
<?php
include 'inc.menu.php';
?>
                
                <!-- START BREADCRUMB --
                <ul class="breadcrumb">
                    <li><a href="#">Home</a></li>
                </ul>
                <!- END BREADCRUMB -->                
                
                <div class="page-title">                    
                    <h2><span class="<?php echo $icon;?>"></span> <?php echo $title;?></h2>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<!--a href="home.php" class="btn btn-success"><i class="fa fa-calendar"></i>Daily</a>
					<a href="home.php?p=week" class="btn btn-warning"><i class="fa fa-calendar"></i>Weekly</a>
					<a href="home.php?p=month" class="btn btn-danger"><i class="fa fa-calendar"></i>Monthly</a-->
                </div>                   
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">    
				<div class="panel panel-default"><div class="panel-body scroll-left">
					<span>Welcome, <?php echo $s_NAME; ?></span>
				</div></div>
				
					<!-- START WIDGETS -->                    
                    <div class="row">
                        <div class="col-md-2">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-info widget-item-icon" onclick="location.href='tickets<?php echo $env?>?s=30';">
                                <div class="widget-item-left">
                                    <span class="fa fa-globe"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count" id="30days_total">0</div>
                                    <div class="widget-title">Total</div>
                                    <div class="widget-subtitle">Last 30 days</div>
                                </div>      
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
							
                        </div>
                        <div class="col-md-2">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-info widget-item-icon" onclick="location.href='tickets<?php echo $env?>?s=30open';">
                                <div class="widget-item-left">
                                    <span class="fa fa-folder-open"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count" id="30days_newopen">0</div>
                                    <div class="widget-title">Open</div>
                                    <div class="widget-subtitle">Last 30 days</div>
                                </div>      
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
							
                        </div>
						<div class="col-md-2">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-info widget-item-icon" onclick="location.href='tickets<?php echo $env?>?s=30progress';">
                                <div class="widget-item-left">
                                    <span class="fa fa-refresh"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count" id="30days_progress">0</div>
                                    <div class="widget-title">Progress</div>
                                    <div class="widget-subtitle">Last 30 days</div>
                                </div>      
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
							
                        </div>
                        <div class="col-md-2">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-info widget-item-icon" onclick="location.href='tickets<?php echo $env?>?s=30pending';">
                                <div class="widget-item-left">
                                    <span class="fa fa-hourglass-start"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count" id="30days_pending">0</div>
                                    <div class="widget-title">Pending</div>
                                    <div class="widget-subtitle">Last 30 days</div>
                                </div>      
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
							
                        </div>
						<div class="col-md-2">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-info widget-item-icon" onclick="location.href='tickets<?php echo $env?>?s=30solved';">
                                <div class="widget-item-left">
                                    <span class="fa fa-flag-checkered"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count" id="30days_solved">0</div>
                                    <div class="widget-title">Solved</div>
                                    <div class="widget-subtitle">Last 30 days</div>
                                </div>      
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
							
                        </div>
						<div class="col-md-2">
                            
                            <!-- START WIDGET CLOCK -->
                            <div class="widget widget-warning widget-padding-sm">
                                <div class="widget-big-int plugin-clock">00:00</div>                            
                                <div class="widget-subtitle plugin-date">Loading...</div>
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="left" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>                            
                                <div class="widget-buttons widget-c3">
                                    <div class="col">
                                        <a href="#"><span class="fa fa-clock-o"></span></a>
                                    </div>
                                    <div class="col">
                                        <a href="tickets<?php  echo $env?>?a=1"><span class="fa fa-bell"></span></a>
                                    </div>
                                    <div class="col">
                                        <a href="tickets<?php  echo $env?>"><span class="fa fa-calendar"></span></a>
                                    </div>
                                </div>                            
                            </div>                        
                            <!-- END WIDGET CLOCK -->
							
                        </div>
						
                    </div>
					<div class="row">
                        <div class="col-md-2">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-success widget-item-icon" onclick="location.href='tickets<?php echo $env?>?s=reopen';">
                                <div class="widget-item-left">
                                    <span class="fa fa-folder-open"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count" id="relokasi_link_newopen">0</div>
                                    <div class="widget-title">Open</div>
                                    <div class="widget-title">Relokasi</div>
                                </div>      
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
							
                        </div>
						<div class="col-md-2">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-success widget-item-icon" onclick="location.href='tickets<?php echo $env?>?s=reprogress';">
                                <div class="widget-item-left">
                                    <span class="fa fa-hourglass-start"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count" id="relokasi_link_progress">0</div>
                                    <div class="widget-title">Progress</div>
                                    <div class="widget-title">Relokasi</div>
                                </div>      
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
							
                        </div>
						<div class="col-md-2">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-success widget-item-icon" onclick="location.href='tickets<?php echo $env?>?s=resolved';">
                                <div class="widget-item-left">
                                    <span class="fa fa-flag-checkered"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count" id="relokasi_link_solved">0</div>
                                    <div class="widget-title">Solved</div>
                                    <div class="widget-title">Relokasi</div>
                                </div>      
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
							
                        </div>
					    <div class="col-md-2">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-danger widget-item-icon" onclick="location.href='tickets<?php echo $env?>?s=rmopen';">
                                <div class="widget-item-left">
                                    <span class="fa fa-folder-open"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count" id="jarkom_newopen">0</div>
                                    <div class="widget-title">Open</div>
                                    <div class="widget-title">Jarkom</div>
                                </div>      
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
							
                        </div>
						<div class="col-md-2">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-danger widget-item-icon" onclick="location.href='tickets<?php echo $env?>?s=rmprogress';">
                                <div class="widget-item-left">
                                    <span class="fa fa-hourglass-start"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count" id="jarkom_progress">0</div>
                                    <div class="widget-title">Progress</div>
                                    <div class="widget-title">Jarkom</div>
                                </div>      
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
							
                        </div>
						<div class="col-md-2">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-danger widget-item-icon" onclick="location.href='tickets<?php echo $env?>?s=rmsolved';">
                                <div class="widget-item-left">
                                    <span class="fa fa-flag-checkered"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count" id="jarkom_solved">0</div>
                                    <div class="widget-title">Solved</div>
                                    <div class="widget-title">Jarkom</div>
                                </div>      
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
							
                        </div>
						
                    </div>
                    <!-- END WIDGETS -->  
					<div class="row">
						<div class="col-md-2">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-primary widget-item-icon" onclick="reloadtbl('distinct kanwil','Kanwil','kanwil');">
                                <div class="widget-item-left">
                                    <span class="fa fa-folder-open"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count" id="tot_kanwil">0</div>
                                    <div class="widget-title">Total</div>
                                    <div class="widget-subtitle">Kanwil</div>
                                </div>      
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
							
                        </div>
						<div class="col-md-2">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-primary widget-item-icon" onclick="reloadtbl('oname','Deputy','oname',' tipe= \'deputy\'');">
                                <div class="widget-item-left">
                                    <span class="fa fa-hourglass-start"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count" id="tot_area">0</div>
                                    <div class="widget-title">Total</div>
                                    <div class="widget-subtitle">Deputy</div>
                                </div>      
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
							
                        </div>
						<div class="col-md-2">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-primary widget-item-icon" onclick="reloadtbl('oname','Outlet','oname',' tipe= \'outlet\'');">
                                <div class="widget-item-left">
                                    <span class="fa fa-flag-checkered"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count" id="tot_outlet">0</div>
                                    <div class="widget-title">Total</div>
                                    <div class="widget-subtitle">Outlets</div>
                                </div>      
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
							
                        </div>
                        <div class="col-md-2">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-secondary widget-item-icon" onclick="location.href='tickets<?php echo $env?>?s=miopen';">
                                <div class="widget-item-left">
                                    <span class="fa fa-folder-open"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count" id="migrasi_link_newopen">0</div>
                                    <div class="widget-title">Open</div>
                                    <div class="widget-subtitle">Migrasi Link</div>
                                </div>      
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
							
                        </div>
						<div class="col-md-2">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-secondary widget-item-icon" onclick="location.href='tickets<?php echo $env?>?s=miprogress';">
                                <div class="widget-item-left">
                                    <span class="fa fa-hourglass-start"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count" id="migrasi_link_progress">0</div>
                                    <div class="widget-title">Progress</div>
                                    <div class="widget-subtitle">Migrasi Link</div>
                                </div>      
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
							
                        </div>
						<div class="col-md-2">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-secondary widget-item-icon" onclick="location.href='tickets<?php echo $env?>?s=misolved';">
                                <div class="widget-item-left">
                                    <span class="fa fa-flag-checkered"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count" id="migrasi_link_solved">0</div>
                                    <div class="widget-title">Solved</div>
                                    <div class="widget-subtitle">Migrasi Link</div>
                                </div>      
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
							
                        </div>

					</div>

					<div class="row">
                        <div class="col-md-4">

                            <!-- START BAR CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
								<div  class="panel-title-box">
                                    <h3>Ticket By Date</h3>
									<span>Last 7 days</span>
								</div>
                                </div>
                                <div class="panel-body">
                                    <div id="morris-bar-daily" style="height: 300px;"></div>
                                </div>
                            </div>
                            <!-- END BAR CHART -->
                        </div>
					<!--/div>
					
                    <div class="row"-->
                        <div class="col-md-4">

                            <!-- START BAR CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                <div  class="panel-title-box">
                                    <h3>Link</h3>
									<span>Last 30 days</span>
								</div>
								</div>
                                <div class="panel-body">
                                    <div id="morris-donut-customer" style="height: 300px;"></div>
                                </div>
                            </div>
                            <!-- END BAR CHART -->
                        </div>

                        <div class="col-md-4">

                            <!-- START DONUT CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                <div  class="panel-title-box">
                                    <h3>Jarkom</h3>
									<span>Last 30 days</span>
								</div>
								</div>
                                <div class="panel-body">
                                    <div id="morris-donut-sla" style="height: 300px;"></div>
                                </div>
                            </div>
                            <!-- END DONUT CHART -->
                        </div>

                        <div class="col-md-4" style="display:none;"> 
                            <!-- START DONUT CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Ticket by Status</h3>                                
                                </div>
                                <div class="panel-body">
                                    <div id="morris-donut-status" style="height: 300px;"></div>
                                </div>
                            </div>
                            <!-- END DONUT CHART -->                                                 

                        </div>
                    </div>
                </div>
                <!-- PAGE CONTENT WRAPPER -->                
            </div>            
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->

		<div class="modal" id="modal_madul" tabindex="-3" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">                    
                    <div class="modal-body">
						<div class="panel panel-default">
							<div class="panel-body table-responsive">
								<table id="example" class="table" width="100%">
									<thead>
										<tr>
											<th id="namacap">Kanwil</th>									
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
                    </div>
                    <div class="modal-footer">
                        <button id="buto" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
<?php
include 'inc.logout.php';
?>

    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>        
        <script type="text/javascript" src="js/jquery.fancybox.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css" media="screen" />
		<!-- END PLUGINS -->

        <!-- THIS PAGE PLUGINS -->
        <script type="text/javascript" src="js/plugins/datatables/jquery.dataTables.min.js"></script>    
        <script type='text/javascript' src='js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
		<script type="text/javascript" src="js/plugins/owl/owl.carousel.min.js"></script>
		<script type="text/javascript" src="js/plugins/morris/raphael-min.js"></script>
		<script type="text/javascript" src="js/plugins/morris/morris.min.js"></script>
        <!-- END PAGE PLUGINS -->       

        <!-- START TEMPLATE >
        <script type="text/javascript" src="js/settings.js"></script-->
        
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>        
		<!--script type="text/javascript" src="js/cdemo_charts_morris.js"></script>
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->
	
<?php
include 'home.incc.php';
disconnect($conn);
?>
    </body>
</html>

