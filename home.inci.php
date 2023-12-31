                    <?php
					$tot1=0;
					$open1=0;
					$pending1=0;
					$solved1=0;
					$progr=0;
					
					$tot2=0;
					$open2=0;
					$pending2=0;
					$solved2=0;
					$closed2=0;
					
					$tot3=0;
					$open3=0;
					$pending3=0;
					$solved3=0;
					
					$rs=exec_qry($conn,"select count(*) from tm_tickets where typ in $homewidget and datediff(date(now()),date(dt))<=30");
					if($row=fetch_row($rs)){ $tot1=$row[0];}
					$rs=exec_qry($conn,"select count(*)  from tm_tickets where typ in $homewidget and s='progress' and datediff(date(now()),date(dt))<=30");
					if($row=fetch_row($rs)){ $progr=$row[0];}
					$rs=exec_qry($conn,"select count(*)  from tm_tickets where typ in $homewidget and s='solved' and datediff(date(now()),date(dt))<=30");
					if($row=fetch_row($rs)){ $solved1=$row[0];}
					$rs=exec_qry($conn,"select count(*) from tm_tickets where typ in $homewidget and s='pending' and datediff(date(now()),date(dt))<=30");
					if($row=fetch_row($rs)){ $pending1=$row[0];}
					$rs=exec_qry($conn,"select count(*) from tm_tickets where typ in $homewidget and s in ('open','new') and datediff(date(now()),date(dt))<=30");
					if($row=fetch_row($rs)){ $open1=$row[0];}
					
					$rs=exec_qry($conn,"select count(*) from tm_tickets where typ = 'relokasi'");
					if($row=fetch_row($rs)){ $tot2=$row[0];}
					$rs=exec_qry($conn,"select count(*)  from tm_tickets where typ = 'relokasi' and s='solved'");
					if($row=fetch_row($rs)){ $solved2=$row[0];}
					$rs=exec_qry($conn,"select count(*) from tm_tickets where typ = 'relokasi' and s='progress'");
					if($row=fetch_row($rs)){ $pending2=$row[0];}
					$rs=exec_qry($conn,"select count(*) from tm_tickets where typ = 'relokasi' and s in ('open','new')");
					if($row=fetch_row($rs)){ $open2=$row[0];}
					$rs=exec_qry($conn,"select count(*) from tm_tickets where typ = 'relokasi' and s='closed'");
					if($row=fetch_row($rs)){ $closed2=$row[0];}
					
					$rs=exec_qry($conn,"select count(*) from tm_tickets where grp='jarkom'");
					if($row=fetch_row($rs)){ $tot3=$row[0];}
					$rs=exec_qry($conn,"select count(*)  from tm_tickets where grp='jarkom' and s='solved'");
					if($row=fetch_row($rs)){ $solved3=$row[0];}
					$rs=exec_qry($conn,"select count(*) from tm_tickets where grp='jarkom' and s='progress'");
					if($row=fetch_row($rs)){ $pending3=$row[0];}
					$rs=exec_qry($conn,"select count(*) from tm_tickets where grp='jarkom' and s in ('open','new')");
					if($row=fetch_row($rs)){ $open3=$row[0];}
					
					$dt=date("d M Y H:i:s");
					?>
					
					<!-- START WIDGETS -->                    
                    <div class="row">
                        <div class="col-md-2">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-info widget-item-icon" onclick="location.href='tickets<?php echo $env?>?s=30';">
                                <div class="widget-item-left">
                                    <span class="fa fa-globe"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count" id="total"><?php echo number_format($tot1)?></div>
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
                                    <div class="widget-int num-count" id="open"><?php echo number_format($open1)?></div>
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
                                    <div class="widget-int num-count" id="progr"><?php echo number_format($progr)?></div>
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
                                    <div class="widget-int num-count" id="pending"><?php echo number_format($pending1)?></div>
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
                                    <div class="widget-int num-count" id="solved"><?php echo number_format($solved1)?></div>
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
					<div class="row" style="display:none;">
                        <div class="col-md-6">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-success widget-item-icon" onclick="location.href='tickets<?php echo $env?>?s=re';">
                                <div class="widget-item-left">
                                    <span class="fa fa-globe"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count" id="total2"><?php echo number_format($tot2)?></div>
                                    <div class="widget-title">Total</div>
                                    <div class="widget-title">Relokasi</div>
                                </div>      
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
							
                        </div>
						<div class="col-md-6">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-danger widget-item-icon" onclick="location.href='tickets<?php echo $env?>?s=rm';">
                                <div class="widget-item-left">
                                    <span class="fa fa-globe"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count" id="total3"><?php echo number_format($tot3)?></div>
                                    <div class="widget-title">Total</div>
                                    <div class="widget-title">Jarkom</div>
                                </div>      
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
							
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
                                    <div class="widget-int num-count" id="open2"><?php echo number_format($open2)?></div>
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
                                    <div class="widget-int num-count" id="pending2"><?php echo number_format($pending2)?></div>
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
                                    <div class="widget-int num-count" id="solved2"><?php echo number_format($solved2)?></div>
                                    <div class="widget-title">Solved</div>
                                    <div class="widget-title">Relokasi</div>
                                </div>      
                                <div class="widget-controls">                                
                                    <a href="#" class="widget-control-right widget-remove" data-toggle="tooltip" data-placement="top" title="Remove Widget"><span class="fa fa-times"></span></a>
                                </div>
                            </div>                            
                            <!-- END WIDGET MESSAGES -->
							
                        </div>
						<div class="col-md-2 " style="display:none;">
                            
                            <!-- START WIDGET MESSAGES -->
                            <div class="widget widget-success widget-item-icon" onclick="location.href='tickets<?php echo $env?>?s=reclosed';">
                                <div class="widget-item-left">
                                    <span class="fa fa-window-close"></span>
                                </div>                             
                                <div class="widget-data">
                                    <div class="widget-int num-count" id="closed2"><?php echo number_format($closed2)?></div>
                                    <div class="widget-title">Closed</div>
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
                                    <div class="widget-int num-count" id="open3"><?php echo number_format($open3)?></div>
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
                                    <div class="widget-int num-count" id="pending3"><?php echo number_format($pending3)?></div>
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
                                    <div class="widget-int num-count" id="solved3"><?php echo number_format($solved3)?></div>
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
