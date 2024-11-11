<?php
$corona=true;
include 'inc.chksession.php';
include 'inc.common.php';
include 'inc.db.php';

$menu="home";
$title="Summary";
$icon="fa fa-tachometer";

include 'inc.head.php';

$conn=connect();

include 'inc.menu.php';
?>
        
        <div class="main-panel">
          <div class="content-wrapper">
			
			<div class="row">
				
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0" id="30days_total">0</h3>
                          <!--p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p-->
                        </div>
                      </div>
                      <div class="col-2">
                        <div class="icon icon-box-success ">
                          <span class="mdi mdi-ticket icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Total</h6>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0" id="30days_open">0</h3>
                          <!--p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p-->
                        </div>
                      </div>
                      <div class="col-2">
                        <div class="icon icon-box-danger ">
                          <span class="mdi mdi-ticket icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Open</h6>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0" id="30days_progress">0</h3>
                          <!--p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p-->
                        </div>
                      </div>
                      <div class="col-2">
                        <div class="icon icon-box-warning ">
                          <span class="mdi mdi-ticket icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Progress</h6>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0" id="30days_pending">0</h3>
                          <!--p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p-->
                        </div>
                      </div>
                      <div class="col-2">
                        <div class="icon icon-box-info ">
                          <span class="mdi mdi-ticket icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Pending</h6>
                  </div>
                </div>
              </div>
            
			</div>
			
			<div class="row">
				
              <div class="col-xl-2 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0" id="relokasi_link_newopen">0</h3>
                          <!--p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p-->
                        </div>
                      </div>
                      <div class="col-2">
                        <div class="icon icon-box-danger ">
                          <span class="mdi mdi-vector-difference-ba icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Open Relokasi</h6>
                  </div>
                </div>
              </div>
              <div class="col-xl-2 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0" id="relokasi_link_progress">0</h3>
                          <!--p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p-->
                        </div>
                      </div>
                      <div class="col-2">
                        <div class="icon icon-box-warning ">
                          <span class="mdi mdi-vector-difference-ba icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Progress Relokasi</h6>
                  </div>
                </div>
              </div>
              <div class="col-xl-2 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0" id="relokasi_link_solved">0</h3>
                          <!--p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p-->
                        </div>
                      </div>
                      <div class="col-2">
                        <div class="icon icon-box-success ">
                          <span class="mdi mdi-vector-difference-ba icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Solved Relokasi</h6>
                  </div>
                </div>
              </div>
            
              <div class="col-xl-2 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0" id="jarkom_newopen">0</h3>
                          <!--p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p-->
                        </div>
                      </div>
                      <div class="col-2">
                        <div class="icon icon-box-danger ">
                          <span class="mdi mdi-server-network icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Open Jarkom</h6>
                  </div>
                </div>
              </div>
              <div class="col-xl-2 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0" id="jarkom_progress">0</h3>
                          <!--p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p-->
                        </div>
                      </div>
                      <div class="col-2">
                        <div class="icon icon-box-warning ">
                          <span class="mdi mdi-server-network icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Progress Jarkom</h6>
                  </div>
                </div>
              </div>
              <div class="col-xl-2 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0" id="jarkom_solved">0</h3>
                          <!--p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p-->
                        </div>
                      </div>
                      <div class="col-2">
                        <div class="icon icon-box-success ">
                          <span class="mdi mdi-server-network icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Solved Jarkom</h6>
                  </div>
                </div>
              </div>

			</div>
		  
			<div class="row">
				
              <div class="col-xl-2 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0" id="tot_kanwil">0</h3>
                          <!--p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p-->
                        </div>
                      </div>
                      <div class="col-2">
                        <div class="icon icon-box-info ">
                          <span class="mdi mdi-select-all icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Kanwil</h6>
                  </div>
                </div>
              </div>
              <div class="col-xl-2 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0" id="tot_area">0</h3>
                          <!--p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p-->
                        </div>
                      </div>
                      <div class="col-2">
                        <div class="icon icon-box-info ">
                          <span class="mdi mdi-select-inverse icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Deputy</h6>
                  </div>
                </div>
              </div>
              <div class="col-xl-2 col-sm-6 grid-margin stretch-card">
                <div class="card" onclick="reloadtbl('oname','Outlet','oname',' tipe= \'outlet\'');">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0" id="tot_outlet">0</h3>
                          <!--p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p-->
                        </div>
                      </div>
                      <div class="col-2">
                        <div class="icon icon-box-info ">
                          <span class="mdi mdi-select icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Outlet</h6>
                  </div>
                </div>
              </div>
            
              <div class="col-xl-2 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0" id="migrasi_link_newopen">0</h3>
                          <!--p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p-->
                        </div>
                      </div>
                      <div class="col-2">
                        <div class="icon icon-box-danger ">
                          <span class="mdi mdi-shuffle-variant icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Open Mugrasi Link</h6>
                  </div>
                </div>
              </div>
              <div class="col-xl-2 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0" id="migrasi_link_progress">0</h3>
                          <!--p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p-->
                        </div>
                      </div>
                      <div class="col-2">
                        <div class="icon icon-box-warning ">
                          <span class="mdi mdi-shuffle-variant icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Progress Migrasi Link</h6>
                  </div>
                </div>
              </div>
              <div class="col-xl-2 col-sm-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                          <h3 class="mb-0" id="migrasi_link_solved">0</h3>
                          <!--p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p-->
                        </div>
                      </div>
                      <div class="col-2">
                        <div class="icon icon-box-success ">
                          <span class="mdi mdi-shuffle-variant icon-item"></span>
                        </div>
                      </div>
                    </div>
                    <h6 class="text-muted font-weight-normal">Solved Migrasi Link</h6>
                  </div>
                </div>
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
          <!-- content-wrapper ends -->
		  
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
  <!-- END SCRIPTS -->
	
<?php
include 'home.incc.php';
disconnect($conn);
?>
    </body>
</html>

