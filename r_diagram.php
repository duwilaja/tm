<?php
include 'inc.chksession.php';
include 'inc.common.php';

$title="Summary Diagram";
$icon="fa fa-bar-chart";
$menu="rsummary";

include 'inc.head.php';
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
					<!--a href="#" onclick="openForm(0);" data-toggle="modal" data-target="#modal_large" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Create</a>
                --></div>                   
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">
					
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-body">
									<div class="form-group">
										<div class="col-md-3">
											<label>Report</label>
											<select class="form-control" name="chart" id="chart" onchange="rchange(this.value);">
												<option value="chart0">Main Link Total</option>
												<option value="chart1">Main Link Per Kanwil</option>
												<option value="chart2">Gangguan VPN Outlet Per Kanwil</option>
												<option value="chart3">Gangguan Per Kanwil</option>
												<option value="chart4">Durasi Gangguan VPN</option>
												<option value="chart5">Durasi Gangguan Wi-fi Station</option>
												<option value="chart6">Durasi Gangguan Masal VPN</option>
												<option value="chart7">Durasi Gangguan Masal Wi-fi Station</option>
											</select>
										</div>
										<div class="col-md-2 gone chart2 chart3 chart4 chart5 chart6">
											<label>From</label>
											<div class="input-group">
												<input id="df" name="df" type="text" class="form-control datepicker" placeholder="" value="<?php echo date('Y-m-d')?>">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-2 gone chart2 chart3 chart4 chart5 chart6">
											<label>To</label>
											<div class="input-group">
												<input id="dt" name="dt" type="text" class="form-control datepicker" placeholder="" value="<?php echo date('Y-m-d')?>">
												<span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
											</div>
										</div>
										<div class="col-md-2">
											&nbsp;<br />
											<button class="btn btn-info" onclick="redraw()"><i class="fa fa-search"></i> Filter</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row" style="">
                        <div class="col-md-12">

                            <!-- START BAR CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title" id="ctitle">Diagram</h3>                                
                                </div>
                                <div class="panel-body">
								    <canvas id="chart1" style="height: 300px; max-height: 300px;"></canvas>
								</div>
                            </div>
                            <!-- END BAR CHART -->
							
                        </div>
					</div>
					<div class="row" style="">
                        <div class="col-md-12">

                            <!-- START BAR CHART -->
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title" id="">Data</h3>                                
                                </div>
                                <div class="panel-body">
								    <table id="mytable" class="table">
										<thead>
                                            <tr>
                                                <th class="l">Label</th>
                                                <th class="x">X</th>
                                                <th class="y">Y</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
									</table>
								</div>
                            </div>
                            <!-- END BAR CHART -->
							
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
        <script type="text/javascript" src="js/jquery.fancybox.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.min.css" media="screen" />
		<!-- END PLUGINS -->

        <!-- THIS PAGE PLUGINS -->
        <script type='text/javascript' src='js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>

        <!--script type="text/javascript" src="js/plugins/morris/raphael-min.js"></script>
		<script type="text/javascript" src="js/plugins/morris/morris.min.js"></script-->
        
		<script type="text/javascript" src="js/plugins/datatables/jquery.dataTables.min.js"></script>    
        <script type='text/javascript' src='js/plugins/jquery-validation/jquery.validate.js'></script>
		<script type="text/javascript" src="js/plugins/bootstrap/bootstrap-datepicker.js"></script>
		
		<script src="js/plugins/datatables/dataTables.buttons.js"></script>
		<script src="js/plugins/datatables/buttons.flash.js"></script>
		<script src="js/plugins/datatables/jszip.min.js"></script>
		<script src="js/plugins/datatables/pdfmake.min.js"></script>
		<script src="js/plugins/datatables/vfs_fonts.js"></script>
		<script src="js/plugins/datatables/buttons.html5.js"></script>
		<script src="js/plugins/datatables/buttons.print.js"></script>

		<link rel="stylesheet" href="js/plugins/datatables/buttons.dataTables.css">
		<!-- END PAGE PLUGINS -->

        <!-- START TEMPLATE >
        <script type="text/javascript" src="js/settings.js"></script-->
        
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"></script> 
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script> 
        
        <script type="text/javascript" src="js/plugins.js"></script>
        <script type="text/javascript" src="js/actions.js"></script>        
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->         
	
	<script>
var mychart1=null;
var mytable=null;

$(document).ready(function() {
	mychart1 = draw_chart();
	rchange('x');
	
	mytable=$("#mytable").DataTable({
		dom: 'T<"clear"><lrB<t>ip>',
		lengthMenu: [[10,50,100,-1],["10","50","100","All"]],
		buttons: [
				'copy', 'csv', 'excel', 'print'
				],
		searching: false
	});
});

function rchange(tv){
	$(".gone").hide();
	$("."+tv).show();
}
function redraw(){
	if(mychart1!=null) mychart1.destroy();
	mychart1 = draw_chart();
}
function reloadtable(datx,chrid=""){
	var ll="Label"; var lx="X"; var ly="Y";
	switch(chrid){
		case "chart0" : lx="Link"; ly="Total"; break;
		case "chart1" : ll="Link"; lx="Kanwil"; ly="Total"; break;
		case "chart2" : ll="Label"; lx="Kanwil"; ly="Tiket"; break;
		case "chart3" : ll="Label"; lx="Kanwil"; ly="Tiket"; break;
		case "chart4" : ll="Label"; lx="Jam"; ly="Tiket"; break;
		case "chart5" : ll="Label"; lx="Jam"; ly="Tiket"; break;
		case "chart6" : ll="Label"; lx="Bulan"; ly="Tiket"; break;
		case "chart7" : ll="Label"; lx="Bulan"; ly="Tiket"; break;
	}
	var ax=[];
	for(var i=0;i<datx.length;i++){
		ax.push([datx[i]['z'],datx[i]['x'],datx[i]['y']]);
	}
	$(".l").html(ll); $(".x").html(lx); $(".y").html(ly);
	
	if(mytable!=null) {mytable.clear();}
	
	mytable.rows.add(ax).draw();
}
function draw_chart() {
    var start = $("#df").val();
    var end = $("#dt").val();
    var q=$("#chart").val();
	var ytime=q=='chart6'?true:false;
	
	$("#ctitle").text($("#chart option:selected").text());
	
	$.ajax({
        url: "datachart.php",
        method : "POST",
        data : {q:q, df:start, dt:end },
        success: function(r){
			console.log(r);
			var dat=JSON.parse(r);
			
			//var label=["OK"];
			//var axis=["Jan","Feb", "Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"];
			//var dataset=[32,32,55,66,34,87,34,11,19,99,11,64];
			if(q=='chart0'){
				var dataset=pie_datas("Main Link",dat['label'],dat['data']);
				console.log(dataset);
				mychart1 = pie_chart("chart1",'pie',dat['label'],dataset);
			}else{
				var dataset=build_datasets(dat['label'],dat['axis'],dat['data']);
				mychart1 = series_chart("chart1",'bar',dat['label'],dat['axis'],dataset,ytime);
			}
			reloadtable(dat['data'],q);
        }
    });
}

function randomColor(){
	return "#"+(Math.random().toString(16)+"000000").slice(2, 8).toUpperCase();
}
function pie_datas(l,axs,ds){
	var set=[];
	for(var x=0;x<axs.length;x++){ //loop axis
		set.push(get_data(l,axs[x],ds));
	}
	return set;
}
function get_data(a,b,c){
	var ret=0;
	for(var y=0;y<c.length;y++){
		var d=c[y];
		if(d['x']==b && d['z']==a) ret=parseInt(d['y']);
	}
	return ret;
}
function get_sets(l,ds,axs,type='line'){
	var set=[];
	for(var x=0;x<axs.length;x++){ //loop axis
		set.push(get_data(l,axs[x],ds));
	}
	var sd={
		label: l,
		data: set,
		fill: false,
		type: type,
		borderColor: randomColor(),
		backgroundColor: randomColor(),
		borderWidth: 1,
		  datalabels: {
			align: 'center',
			anchor: 'center'
		  }
	}
	return sd;
}
function build_datasets(label,axis,dataset,type='bar'){
	var data=[];
	for(var i=0;i<label.length;i++){
		data.push(get_sets(label[i],dataset,axis,type));
	}
	//console.log(datax);
	
	return data;
}
function series_chart(canvas,type='bar',labels=[],axis=[],datasets=[],ytime=false){
	var ctx = document.getElementById(canvas).getContext('2d');
	var thechart = new Chart(ctx, {
		plugins: [ChartDataLabels],
		type: type, 
		data: {
			labels: axis,
			datasets: datasets
		},
		options: {
			plugins: {
			  datalabels: {
				color: 'black',
				display: function(context) {
				  return context.dataset.data[context.dataIndex] > 0;
				},
				font: {
				  weight: 'bold'
				},
				formatter: Math.round
			  }
			},
		  responsive: true, // Instruct chart js to respond nicely.
		  maintainAspectRatio: false, // Add to prevent default behaviour of full-width/height 
		  // Core options
		aspectRatio: 5 / 3,
		layout: {
		  padding: {
			top: 24,
			right: 16,
			bottom: 0,
			left: 8
		  }
		},
		elements: {
		  line: {
			fill: false
		  },
		  point: {
			hoverRadius: 7,
			radius: 5
		  }
		},
		  scales: {
			  x: {
				stacked: true,
			  },
			  y: {
				stacked: true,
				ticks: {
                    // Include a dollar sign in the ticks
                    callback: function(value, index, values) {
                        return ytime? secondsToDhms(value): value;
                    }
                }
			  }
			}
		}
	});
	
	return thechart;
}
function pie_chart(canvas,type,labels,datas,colors=[],legend=true,tooltip=true){
	//-------------
  //- PIE CHART -
  //-------------
  // Get context with jQuery - using jQuery's .get() method.
  
  if(colors.length==0){
	  for(var i=0;i<datas.length;i++){
		  colors.push(randomColor());
	  }
  }
  
    var pieChartCanvas = document.getElementById(canvas).getContext('2d');
    var pieData        = {
      labels: labels,/*[
          'Chrome', 
          'IE',
          'FireFox', 
          'Safari', 
      ],*/
      datasets: [
        {
          data: datas,//[700,500,400,600,300,100],
          backgroundColor : colors,//['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    var pieOptions = {
		plugins: {
            tooltip: {
				enabled: tooltip,
                callbacks: {
                    label: function(context) {
                        let label = context.label || '';

                        if (label) {
                            label += ': ';
                        }
						let sum = 0;
						let dataArr = context.dataset.data;
						dataArr.map(data => {
							sum += data;
						});
						//let percentage = (value*100 / sum).toFixed(2)+"%";
						
                        if (context.parsed !== null) {
                            //label += new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(context.parsed);
							label += context.parsed+" ("+(context.parsed*100/sum).toFixed(2)+"%)";
                        }
						
						//console.log(context);
						
                        return label;
                    }
                }
            },
			legend: {
				display: legend
			}
        }
	};
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var pieChart = new Chart(pieChartCanvas, {
      type: type,
      data: pieData,
      options: pieOptions
    })

  //-----------------
  //- END PIE CHART -
  //-----------------
  
  return pieChart;
}
function secondsToDhms(seconds) {
	seconds = Number(seconds);
	var d = Math.floor(seconds / (3600*24));
	var h = Math.floor(seconds % (3600*24) / 3600);
	var m = Math.floor(seconds % 3600 / 60);
	var s = Math.floor(seconds % 60);

	var dDisplay = d > 0 ? d + (d == 1 ? " d, " : " d, ") : "";
	var hDisplay = h > 0 ? h + (h == 1 ? ":" : ":") : "";
	var mDisplay = m > 0 ? m + (m == 1 ? ":" : ":") : "";
	var sDisplay = s > 0 ? s + (s == 1 ? "" : "") : "";
	return dDisplay + hDisplay + mDisplay + sDisplay;
}
</script>

    </body>
</html>