      <!-- partial:../../partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
          <a class="sidebar-brand brand-logo" href="homex<?php echo $env;?>"><img src="img/logo.jpg" alt="logo" /></a>
          <a class="sidebar-brand brand-logo-mini" href="homex<?php echo $env;?>"><img src="favicon-16.png" alt="logo" /></a>
        </div>
        <ul class="nav">
          <li class="nav-item profile hidden">
            <div class="profile-desc">
              <div class="profile-pic">
                <div class="count-indicator">
                  <img class="img-xs rounded-circle " src="../../assets/images/faces/face15.jpg" alt="">
                  <span class="count bg-success"></span>
                </div>
                <div class="profile-name">
                  <h5 class="mb-0 font-weight-normal">Henry Klein</h5>
                  <span>Gold Member</span>
                </div>
              </div>
              <a href="#" id="profile-dropdown" data-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
              <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-settings text-primary"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">Account settings</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-onepassword  text-info"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">Change Password</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-calendar-today text-success"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">To-do list</p>
                  </div>
                </a>
              </div>
            </div>
          </li>
          <li class="nav-item nav-category">
            <span class="nav-link">&nbsp;</span>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="homex<?php echo $env;?>">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
		  <?php
						if($s_LVL==0&&$s_GRP==""){
						?>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-laptop"></i>
              </span>
              <span class="menu-title">Master</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="kanwilsx<?php echo $env;?>">Kanwils</a></li>
                <li class="nav-item"> <a class="nav-link" href="outletx<?php echo $env;?>">Outlets</a></li>
                <li class="nav-item"> <a class="nav-link" href="outletipsx<?php echo $env;?>">Outlets IP</a></li>
				<li class="nav-item"> <a class="nav-link" href="holidaysx<?php echo $env;?>">Holiday</a></li>
				<li class="nav-item"> <a class="nav-link" href="problemsx<?php echo $env;?>">Filters</a></li>
				<li class="nav-item"> <a class="nav-link" href="timersx<?php echo $env;?>">Notify</a></li>
				<li class="nav-item"> <a class="nav-link" href="kanwilusersx<?php echo $env;?>">Kanwil User</a></li>
				<li class="nav-item"> <a class="nav-link" href="m2msx<?php echo $env;?>">M2M</a></li>
              </ul>
            </div>
          </li>
						<?php }
				if($s_LVL<9){
						?>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#ticketz" aria-expanded="false" aria-controls="tiketz">
              <span class="menu-icon">
                <i class="mdi mdi-playlist-play"></i>
              </span>
              <span class="menu-title">Tickets</span>
			  <i class="menu-arrow"></i>
            </a>
			<div class="collapse" id="ticketz">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="ticketzx<?php echo $env;?>">All</a></li>
                <li class="nav-item"> <a class="nav-link" href="ticketox<?php echo $env;?>?pic=1&grp=1">Open</a></li>
				<li class="nav-item"> <a class="nav-link" href="ticketjx<?php echo $env;?>?s=jk">Jarkom</a></li>
				<li class="nav-item"> <a class="nav-link" href="ticketrx<?php echo $env;?>?s=rl">Relokasi</a></li>
					<?php
						if($s_LVL==4){
						?>
				<li class="nav-item"> <a class="nav-link" href="ticketgx<?php echo $env;?>?grp=1">My Group</a></li>
						<?php } ?>
              </ul>
            </div>
          </li>
					<?php
						if($s_LVL!=3){
						?>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#reportsz" aria-expanded="false" aria-controls="reports">
              <span class="menu-icon">
                <i class="mdi mdi-table-large"></i>
              </span>
              <span class="menu-title">Reports</span>
			  <i class="menu-arrow"></i>
            </a>
			<div class="collapse" id="reportsz">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="r_summaryx<?php echo $env;?>">Summary</a></li>
                <li class="nav-item"> <a class="nav-link" href="r_diagramx<?php echo $env;?>">Diagram</a></li>
                <li class="nav-item"> <a class="nav-link" href="r_ticketsx<?php echo $env;?>">Tickets</a></li>
                <li class="nav-item"> <a class="nav-link" href="r_hticketsx<?php echo $env;?>">Ticket History</a></li>
                <li class="nav-item"> <a class="nav-link" href="r_slaallx<?php echo $env;?>">SLA</a></li>
                <li class="nav-item"> <a class="nav-link" href="r_slastatusx<?php echo $env;?>">Status Duration</a></li>
                <li class="nav-item"> <a class="nav-link" href="r_customsx<?php echo $env;?>">Custom</a></li>
                <li class="nav-item"> <a class="nav-link" href="r_moutletsx<?php echo $env;?>">Outlets</a></li>
                <li class="nav-item"> <a class="nav-link" href="r_outletsx<?php echo $env;?>">Outlet History</a></li>
                <li class="nav-item"> <a class="nav-link" href="r_linkx<?php echo $env;?>">Data Link</a></li>
                <li class="nav-item"> <a class="nav-link" href="r_m2mx<?php echo $env;?>">M2M</a></li>
                <li class="nav-item"> <a class="nav-link" href="r_tickets.arcx<?php echo $env;?>">Archive</a></li>
              </ul>
            </div>
          </li>
				<?php 
				}}
					if(($s_LVL==0&&$s_GRP=="")){?>
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#ifacesz" aria-expanded="false" aria-controls="ifaces">
              <span class="menu-icon">
                <i class="mdi mdi-chart-bar"></i>
              </span>
              <span class="menu-title">Interfaces</span>
			  <i class="menu-arrow"></i>
            </a>
			<div class="collapse" id="ifacesz">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="r_createlogx<?php echo $env;?>">Create Ticket</a></li>
                <li class="nav-item"> <a class="nav-link" href="r_updatelogx<?php echo $env;?>">Update Ticket</a></li>
                <li class="nav-item"> <a class="nav-link" href="r_operationx<?php echo $env;?>">Transactions</a></li>
                <li class="nav-item"> <a class="nav-link" href="r_wifix<?php echo $env;?>">DVO</a></li>
              </ul>
            </div>
          </li>
				<?php }?>
					
          <li class="nav-item menu-items hidden">
            <a class="nav-link" href="../../pages/icons/mdi.html">
              <span class="menu-icon">
                <i class="mdi mdi-contacts"></i>
              </span>
              <span class="menu-title">Icons</span>
            </a>
          </li>
          <li class="nav-item menu-items hidden">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
              <span class="menu-icon">
                <i class="mdi mdi-security"></i>
              </span>
              <span class="menu-title">User Pages</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/blank-page.html"> Blank Page </a></li>
                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/error-404.html"> 404 </a></li>
                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/error-500.html"> 500 </a></li>
                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/login.html"> Login </a></li>
                <li class="nav-item"> <a class="nav-link" href="../../pages/samples/register.html"> Register </a></li>
              </ul>
            </div>
          </li>
          <li class="nav-item menu-items hidden">
            <a class="nav-link" href="http://www.bootstrapdash.com/demo/corona-free/jquery/documentation/documentation.html">
              <span class="menu-icon">
                <i class="mdi mdi-file-document-box"></i>
              </span>
              <span class="menu-title">Documentation</span>
            </a>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_navbar.html -->
        <nav class="navbar p-0 fixed-top d-flex flex-row">
          <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
            <a class="navbar-brand brand-logo-mini" href="homex<?php echo $env;?>"><img src="favicon-16.png" alt="logo" /></a>
          </div>
          <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="mdi mdi-menu"></span>
            </button>
            <ul class="navbar-nav w-100">
              <li class="nav-item w-50">
                <form method="get" action="ticketzx<?php echo $env?>" class="nav-link mt-2 mt-md-0 d-none d-lg-flex search">
                  <input name="tsrc" type="text" class="form-control" placeholder="Search tickets">
                </form>
              </li>
			  <li class="nav-item w-50  d-none d-lg-flex">
				 <i class="mdi mdi-calendar-clock"></i>
				 <span class="plugin-date"></span>&nbsp;<span class="plugin-clock"></span>
			  </li>
            </ul>
            <ul class="navbar-nav navbar-nav-right">
              <li class="nav-item dropdown d-none d-lg-block hidden">
                <a class="nav-link btn btn-success create-new-button hidden" id="createbuttonDropdown" data-toggle="dropdown" aria-expanded="false" href="#">+ Create New Project</a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="createbuttonDropdown">
                  <h6 class="p-3 mb-0">Projects</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-file-outline text-primary"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Software Development</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-web text-info"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">UI Development</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-layers text-danger"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Software Testing</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <p class="p-3 mb-0 text-center">See all projects</p>
                </div>
              </li>
              <li class="nav-item nav-settings d-none d-lg-block">
                <a class="nav-link" title="Map View" href="mapx<?php echo $env;?>">
                  <i class="mdi mdi-map-marker-multiple"></i>
                </a>
              </li>
			  <li class="nav-item nav-settings d-none d-lg-block">
                <a class="nav-link" title="Outlets" target="_blank" href="peta<?php echo $env;?>">
                  <i class="mdi mdi-scale-balance"></i>
                </a>
              </li>
              <li class="nav-item dropdown border-left hidden">
                <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                  <i class="mdi mdi-email"></i>
                  <span class="count bg-success"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                  <h6 class="p-3 mb-0">Messages</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <img src="../../assets/images/faces/face4.jpg" alt="image" class="rounded-circle profile-pic">
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Mark send you a message</p>
                      <p class="text-muted mb-0"> 1 Minutes ago </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <img src="../../assets/images/faces/face2.jpg" alt="image" class="rounded-circle profile-pic">
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Cregh send you a message</p>
                      <p class="text-muted mb-0"> 15 Minutes ago </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <img src="../../assets/images/faces/face3.jpg" alt="image" class="rounded-circle profile-pic">
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject ellipsis mb-1">Profile picture updated</p>
                      <p class="text-muted mb-0"> 18 Minutes ago </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <p class="p-3 mb-0 text-center">4 new messages</p>
                </div>
              </li>
              <li class="nav-item dropdown border-left" <?php if($s_LVL==9) echo 'style="display:none"'?>>
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                  <i class="mdi mdi-bell"></i>
                  <span class="count bg-danger"></span>
                </a>
                <div id="txtmsg" class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                  <div class="navbar-profile">
                    <!--img class="img-xs rounded-circle hidden" src="../../assets/images/faces/face15.jpg" alt=""-->
					<div class="preview-icon bg-dark rounded-circle"><i class="mdi mdi-account-circle text-success"></i></div>
                    <p class="mb-0 d-none d-sm-block navbar-profile-name"><?php echo $s_ID?></p>
                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                  </div>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                  <h6 class="p-3 mb-0 text-center text-warning"><b><?php echo $s_NAME?></b></h6>
                  <?php if($s_LVL==0){?>
				  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item" href="cmsusersx<?php echo $env;?>">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-account-multiple text-success"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Users</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item" href="userlogsx<?php echo $env;?>">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-account-network text-info"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Logs</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item" href="updatelogsx<?php echo $env;?>">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-account-check text-danger"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Updates</p>
                    </div>
                  </a>
				  <?php }?>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item" href="cpwdx<?php echo $env;?>">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-settings text-success"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Change Password</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item" href="logout<?php echo $env;?>">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-dark rounded-circle">
                        <i class="mdi mdi-logout text-danger"></i>
                      </div>
                    </div>
                    <div class="preview-item-content">
                      <p class="preview-subject mb-1">Log out</p>
                    </div>
                  </a>
                </div>
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="mdi mdi-format-line-spacing"></span>
            </button>
          </div>
        </nav>
        <!-- partial -->
