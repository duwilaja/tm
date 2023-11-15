                <!-- START X-NAVIGATION VERTICAL -->
                <ul class="x-navigation x-navigation-horizontal">
                    <li class="xn-logo">
                        <a href="home.php"><img width="200px" height="50px" style="position:absolute;left:0px;top:0px;" src="img/logo.jpg"></a>
						<a href="#" class="x-navigation-control"></a>
                    </li>
					<?php
						if($s_LVL==0&&$s_GRP==""){
						?>
					<li class="xn-openable xn-icon-button">
                        <a style="width:auto;" href="#"><span class="fa fa-database"></span> <span class="xn-text">Master</span></a>
                        <ul class="animated zoomIn">
                            <li><a href="kanwils<?php echo $env?>"><span class="fa fa-map-o"></span> Kanwil</a></li>
							<li><a href="outlets<?php echo $env?>"><span class="fa fa-map-signs"></span> Outlets</a></li>
							<li><a href="outletips<?php echo $env?>"><span class="fa fa-tty"></span> Outlet IP</a></li>
							<li><a href="problems<?php echo $env?>"><span class="fa fa-warning"></span> Filters</a></li>
							<li><a href="timers<?php echo $env?>"><span class="fa fa-clock-o"></span> Notify</a></li>
							<li><a href="kanwilusers<?php echo $env?>"><span class="fa fa-user-circle-o"></span> User Kanwil</a></li>
							<li><a href="holidays<?php echo $env?>"><span class="fa fa-calendar-times-o"></span> Holiday</a></li>
							<li><a href="shifts<?php echo $env?>"><span class="fa fa-retweet"></span> Shifts</a></li>
							<li><a href="m2ms<?php echo $env?>"><span class="fa fa-signal"></span> M2M</a></li>
							<li><a href="runningtxt<?php echo $env?>"><span class="fa fa-recycle"></span> Running Text</a></li>
                        </ul>
                    </li>
						<?php }
				if($s_LVL<9){
						?>
                    <li class="xn-openable xn-icon-button">
                        <a style="width:auto;" href="#"><span class="fa fa-check-square-o"></span> <span class="xn-text">Tickets</span></a>
                        <ul class="animated zoomIn">
							<li><a href="tickets<?php echo $env?>"><span class="fa fa-ticket"></span>All Tickets</a></li>
							<li><a href="tickets<?php echo $env?>?pic=1&grp=1"><span class="fa fa-ticket"></span>Open Tickets</a></li>
					<?php
						if($s_LVL==4){
						?>
							<li><a href="tickets<?php echo $env?>?grp=1"><span class="fa fa-ticket"></span>My Group Tickets</a></li>
						<?php } ?>
						</ul>
                    </li>
					<?php
						if($s_LVL!=3){
						?>
					<li class="xn-openable xn-icon-button">
                        <a style="width:auto;" href="#"><span class="fa fa-file-text-o"></span> <span class="xn-text">Reports</span></a>                        
                        <ul class="animated zoomIn">
							<li><a href="r_summary<?php echo $env?>"><span class="fa fa-file-text"></span> Summary</a></li>
							<li><a href="r_diagram<?php echo $env?>"><span class="fa fa-bar-chart"></span> Diagram</a></li>
							<li><a href="r_tickets<?php echo $env?>"><span class="fa fa-file-text"></span> Tickets</a></li>
							<li><a href="r_htickets<?php echo $env?>"><span class="fa fa-file-text"></span> Ticket History</a></li>
							<li><a href="r_moutlets<?php echo $env?>"><span class="fa fa-file-text"></span> Outlets</a></li>
							<li><a href="r_outlets<?php echo $env?>"><span class="fa fa-file-text"></span> Outlet History</a></li>
							<li><a href="r_customs<?php echo $env?>"><span class="fa fa-file-text"></span> Customs</a></li>
							<li><a href="r_sla<?php echo $env?>"><span class="fa fa-file-text"></span> Summary SLA</a></li>
							<li><a href="r_slaall<?php echo $env?>"><span class="fa fa-file-text"></span> SLA</a></li>
							<li><a href="r_slastatus<?php echo $env?>"><span class="fa fa-file-text"></span> Status Duration</a></li>
							<li><a href="r_m2m<?php echo $env?>"><span class="fa fa-file-text"></span> M2M</a></li>
							<li><a href="r_tickets.arc<?php echo $env?>"><span class="fa fa-file-text"></span> Archive</a></li>
						</ul>
                    </li>
				<?php 
						}
					if(($s_LVL==0&&$s_GRP=="")){?>
					<li class="xn-openable xn-icon-button">
                        <a style="width:auto;" href="#"><span class="fa fa-exchange"></span> <span class="xn-text">Interfaces</span></a>                        
                        <ul class="animated zoomIn">
						<?php if($s_LVL!=5){?>
							<li><a href="r_createlog<?php echo $env?>"><span class="fa fa-file-text"></span> Create Ticket</a></li>
							<li><a href="r_updatelog<?php echo $env?>"><span class="fa fa-file-text"></span> Update Ticket</a></li>
							<li><a href="r_operation<?php echo $env?>"><span class="fa fa-file-text"></span> Operation</a></li>
						<?php }?>
							<li><a href="r_wifi<?php echo $env?>"><span class="fa fa-file-text"></span> WiFi</a></li>
						</ul>
                    </li>
				<?php }?>
					
					<?php 
				}
					if($feedback){
						if($s_LVL==0||$s_LVL==4){?>
					<li class="xn-openable xn-icon-button">
                        <a style="width:auto;" href="#"><span class="fa fa-reply-all"></span> <span class="xn-text">Feedbacks</span></a>                        
                        <ul class="animated zoomIn">
							<li><a href="f_surveys<?php echo $env?>"><span class="fa fa-binoculars"></span> Survey</a></li>
							<li><a href="f_comments<?php echo $env?>"><span class="fa fa-comments"></span> Comments</a></li>
							<li><a href="fr_feedbacks<?php echo $env?>"><span class="fa fa-file-text"></span> Reports</a></li>
						</ul>
                    </li>
						<?php }else{?>
					<li class="xn-openable xn-icon-button">
                        <a style="width:auto;" href="#"><span class="fa fa-reply-all"></span> <span class="xn-text">Feedbacks</span></a>                        
                        <ul class="animated zoomIn">
							<li><a href="f_surveyseu<?php echo $env?>"><span class="fa fa-binoculars"></span> My Survey</a></li>
							<li><a href="f_comments<?php echo $env?>"><span class="fa fa-comments"></span> My Comments</a></li>
						</ul>
                    </li>
					<?php	}
					}?>
					<li class="xn-openable pull-right">
                        <a href="#"><span class="fa fa-user"></span><span class="xn-text"><?php echo $s_NAME;?></span></a>
                        <ul class="animated zoomIn xn-drop-left">
						<?php
						if($s_LVL==0&&$s_GRP==""){
						?>
                            <li <?php if($menu=="users"){?> class="active"<?php }?>><a href="cmsusers<?php echo $env?>"><span class="fa fa-users"></span> Users</a></li>
							<li <?php if($menu=="userlogs"){?> class="active"<?php }?>><a href="userlogs<?php echo $env?>"><span class="fa fa-history"></span> Logs</a></li>
							<li <?php if($menu=="updatelogs"){?> class="active"<?php }?>><a href="updatelogs<?php echo $env?>"><span class="fa fa-check"></span> Updates</a></li>
							<li class="divider"></li>
						<?php } ?>
							<!--li><a target="_blank" href="../chat/"><span class="fa fa-comments"></span> Chats</a></li-->
							<li <?php if($menu=="cpwd"){?> class="active"<?php }?>><a href="cpwd.php"><span class="fa fa-magic"></span> Change Password</a></li>
							<li><a title="Logout" href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span> Logout</a></li>
                        </ul>
                    </li>
					<li class="xn-icon-button pull-right" <?php if($s_LVL==9) echo 'style="display:none"'?>>
						<!--a href="tickets<?php echo $env?>?pic=1&a=1"><span class="fa fa-bell-o"></span></a-->
						<a href="#"><span class="fa fa-bell-o"></span></a>
						<div id="alert" class="informer informer-danger">0</div>
						<div class="panel panel-primary animated zoomIn xn-drop-left">
                            <div class="panel-heading">
                                <h3 class="panel-title"><span class="fa fa-comments"></span> New Tickets</h3>                                
                                <div class="pull-right">
                                    <span class="label label-success"><span id="nalert">0</span></span>
                                </div>
                            </div>
                            <div id="txtmsg" class="panel-body list-group list-group-contacts scroll"></div>     
                            <div id="txtlnk" class="panel-footer text-center">
                                <a href="tickets<?php echo $env?>?pic=1&a=1&grp=1">Show all</a>
                            </div>                            
                        </div>
					</li>
					<li class="xn-icon-button pull-right">
						<a href="peta.php" target="_blank"><span class="fa fa-balance-scale" title="Outlets"></span></a>
					</li>
					<li class="xn-icon-button pull-right">
						<a href="map<?php echo $env?>"><span class="fa fa-map-marker" title="Map View"></span></a>
					</li>
					<?php if($menu=='home'){?>
					<li class="xn-icon-button pull-right">
						<a href="r_operation<?php echo $env?>"><span class="fa fa-unlink" title="Transaction Log"></span></a>
						<div id="trlog" class="informer informer-danger">0</div>
					</li>
					<?php }?>
					<?php if(false){?>
					<li class="xn-icon-button pull-right">
						<a href="#"><span class="fa fa-comments-o"></span></a>
						<div id="infolog" class="informer informer-info">0</div>
						<div class="panel panel-primary animated zoomIn xn-drop-left">
                            <div id="txtlog" class="panel-body list-group list-group-contacts scroll"></div>
                        </div>
					</li>
					<?php }?>
                </ul>
                <!-- END X-NAVIGATION VERTICAL -->