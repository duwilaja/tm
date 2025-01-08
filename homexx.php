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
				<div class="col-xl-3">
					<div class="card">
						<div class="card-body" style="padding: 10px 0px;">
							<div class="mywijval"><span>1000</span> &nbsp;<i class="mdi mdi-book-open-page-variant"></i></div>
							<div class="mywijtxt bg-danger">Open</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3">
					<div class="card">
						<div class="card-body" style="padding: 10px 0px;">
							<div class="mywijval"><span>1000</span> &nbsp;<i class="mdi mdi-reload"></i></div>
							<div class="mywijtxt bg-info">Progress</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3">
					<div class="card">
						<div class="card-body" style="padding: 10px 0px;">
							<div class="mywijval"><span>1000</span> &nbsp;<i class="mdi mdi-clock-alert"></i></div>
							<div class="mywijtxt bg-warning">Pending</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3">
					<div class="card">
						<div class="card-body" style="padding: 10px 0px;">
							<div class="mywijval"><span>1000</span> &nbsp;<i class="mdi mdi-bookmark-check"></i></div>
							<div class="mywijtxt bg-success">Solved</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-5">
				<div class="card">
				  <div class="card-body">
				  <h4 class="card-title">SLA Breach</h4>
					<div class="row">
					  <div class="col-lg-4 grid-margin stretch-card" style="padding-left: 0; padding-right: 0">
						<div class="card">
						  <div class="card-body" style="text-align: center;">
							<div class="indonut">
								99
							</div>
							<canvas id="doughnutChart" style="max-height:120px"></canvas>
							>1 Hour
						  </div>
						</div>
					  </div>
					  <div class="col-lg-4 grid-margin stretch-card" style="padding-left: 0; padding-right: 0">
						<div class="card">
						  <div class="card-body" style="text-align: center;">
							<div class="indonut">
								100
							</div>
							<canvas id="doughnutChart2" style="max-height:120px"></canvas>
							>6 Hour
						  </div>
						</div>
					  </div>
					  <div class="col-lg-4 grid-margin stretch-card" style="padding-left: 0; padding-right: 0">
						<div class="card">
						  <div class="card-body" style="text-align: center;">
							<div class="indonut">
								101
							</div>
							<canvas id="doughnutChart3" style="max-height:120px"></canvas>
							>24 Hour
						  </div>
						</div>
					  </div>
					</div>
				  </div>
				</div>
				</div>
				<div class="col-lg-7">
					<div class="card">
					  <div class="card-body">
						<h4 class="card-title">Ticket By Date</h4>
						<canvas id="barChart" style="max-height:230px"></canvas>
					  </div>
					</div>
				</div>
			</div>
			<div class="row">
              <div class="col-lg-3 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Ticket By Services</h4>
                    <canvas id="pieChart" style="max-height:150px"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Ticket By Issue</h4>
                    <canvas id="pieChart2" style="max-height:150px"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Ticket Jarkom</h4>
                    <canvas id="pieChart3" style="max-height:150px"></canvas>
                  </div>
                </div>
              </div>
            </div>

			<div class="row">
				<div class="col-lg-4">
					<div class="card">
						<div class="card-body" style="padding: 10px 20px; display: flex;">
							<div class="mywijval"><i class="mdi mdi-hospital-building"></i></div>
							<div class="mywijet"><span>1000</span><br />Kanwil</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="card">
						<div class="card-body" style="padding: 10px 20px; display: flex;">
							<div class="mywijval"><i class="mdi mdi-bank"></i></div>
							<div class="mywijet"><span>1000</span><br />Deputy</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="card">
						<div class="card-body" style="padding: 10px 20px; display: flex;">
							<div class="mywijval"><i class=" mdi mdi-home-modern"></i></div>
							<div class="mywijet"><span>1000</span><br />Outlet</div>
						</div>
					</div>
				</div>
			</div>
			
			
			<div class="row hidden">
				
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
                          <h3 class="mb-0" id="30days_newopen">0</h3>
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
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.8.0/chart.min.js"></script> 
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script> 
		
<?php
disconnect($conn);
?>
<script>

$(document).ready(function() {
	get30();
	bikinchart();
})

Chart.register(ChartDataLabels);

  var doughnutPieData = {
    datasets: [{
      data: [30, 40, 30],
      backgroundColor: [
        'rgba(255, 99, 132, 0.5)',
        'rgba(54, 162, 235, 0.5)',
        'rgba(255, 206, 86, 0.5)',
        'rgba(75, 192, 192, 0.5)',
        'rgba(153, 102, 255, 0.5)',
        'rgba(255, 159, 64, 0.5)'
      ],
      borderColor: [
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
      ],
    }],

    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels: [
      'Pink',
      'Blue',
      'Yellow',
    ]
  };
  var doughnutPieOptions = {
    responsive: true,
    animation: {
      animateScale: true,
      animateRotate: true
    },
	 plugins: {
            datalabels: { // This code is used to display data values
                //anchor: 'end',
                //align: 'top',
                //formatter: Math.round,
                font: {
                    weight: 'bold',
                    size: 16
                },
				color: 'white'
            },
			legend:{
				position: 'right',
				align: 'start'
			}
	 }
  };
  var doughnutOptions = {
    responsive: true,
    animation: {
      animateScale: true,
      animateRotate: true
    },
	 plugins: {
			legend:{
				display: false
			}
	 }
  };

  var data = {
    labels: ["2013", "2014", "2014", "2015", "2016", "2017"],
    datasets: [{
      label: '# of Votes',
      data: [10, 19, 3, 5, 2, 3],
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
      ],
      borderColor: [
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
      ],
      borderWidth: 1,
      fill: false
    }]
  };
  var options = {
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true
        },
        gridLines: {
          color: "rgba(204, 204, 204,0.1)"
        }
      }],
      xAxes: [{
        gridLines: {
          color: "rgba(204, 204, 204,0.1)"
        }
      }]
    },
	plugins:{
    legend: {
      display: false
    }},
    elements: {
      point: {
        radius: 0
      }
    }
  };
  
function bikinchart(){
  if ($("#barChart").length) {
    var barChartCanvas = $("#barChart").get(0).getContext("2d");
    // This will get the first returned node in the jQuery collection.
    var barChart = new Chart(barChartCanvas, {
      type: 'bar',
      data: data,
      options: options
    });
  }
  
  if ($("#doughnutChart").length) {
    var doughnutChartCanvas = $("#doughnutChart").get(0).getContext("2d");
    var doughnutChart = new Chart(doughnutChartCanvas, {
      type: 'doughnut',
      data: doughnutPieData,
      options: doughnutOptions
    });
  }
  if ($("#doughnutChart2").length) {
    var doughnutChartCanvas = $("#doughnutChart2").get(0).getContext("2d");
    var doughnutChart = new Chart(doughnutChartCanvas, {
      type: 'doughnut',
      data: doughnutPieData,
      options: doughnutOptions
    });
  }
  if ($("#doughnutChart3").length) {
    var doughnutChartCanvas = $("#doughnutChart3").get(0).getContext("2d");
    var doughnutChart = new Chart(doughnutChartCanvas, {
      type: 'doughnut',
      data: doughnutPieData,
      options: doughnutOptions
    });
  }

  if ($("#pieChart").length) {
    var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
    var pieChart = new Chart(pieChartCanvas, {
      type: 'pie',
      data: doughnutPieData,
      options: doughnutPieOptions
    });
  }
  if ($("#pieChart3").length) {
    var doughnutChartCanvas = $("#pieChart3").get(0).getContext("2d");
    var doughnutChart = new Chart(doughnutChartCanvas, {
      type: 'pie',
      data: doughnutPieData,
      options: doughnutPieOptions
    });
  }

  if ($("#pieChart2").length) {
    var pieChartCanvas = $("#pieChart2").get(0).getContext("2d");
    var pieChart = new Chart(pieChartCanvas, {
      type: 'pie',
      data: doughnutPieData,
      options: doughnutPieOptions
    });
  }
}
function getKAO(q='kao'){
	$.ajax({
		type: 'POST',
		url: 'datajson<?php echo $env?>',
		data: {q:q},
		success: function(data){
			var jsn=JSON.parse(data);
			//console.log(jsn);
			$.each(jsn[0],function (key,val){
				$('#'+key).html(val);
				//console.log(key);
			})
		}
	});
	setTimeout(getKAO,300*1000);
}
function getTR(q='trlog'){
	$.ajax({
		type: 'POST',
		url: 'datajson<?php echo $env?>',
		data: {q:q},
		success: function(data){
			var jsn=JSON.parse(data);
			//$("#"+q).html(jsn[0][q]);
			$("#trlog").removeClass("informer-danger").removeClass("informer-success");
			if(jsn[0][q]>0){
				$("#trlog").addClass("informer-success").html(jsn[0][q]);
			}else{
				$("#trlog").addClass("informer-danger").html("0");
			}
		}
	});
	setTimeout(getTR,300*1000);
}
function get30(q='30days'){
	$.ajax({
		type: 'POST',
		url: 'datajson<?php echo $env?>',
		data: {q:q},
		success: function(data){
			var jsn=JSON.parse(data);
			var op=0;
			var tot=0;
			for(var i=0;i<jsn.length;i++){
				if(jsn[i]['s']=='new'||jsn[i]['s']=='open') {
					op+=parseInt(jsn[i]['t']);
				}else{
					$("#"+q+"_"+jsn[i]['s']).html(jsn[i]['t']);
				}
				tot+=parseInt(jsn[i]['t']);
			}
			$("#"+q+"_newopen").html(op);
			$("#"+q+"_total").html(tot);
		}
	});
	setTimeout(get30,30*1000);
}
function getJarkom(q='jarkom'){
	$.ajax({
		type: 'POST',
		url: 'datajson<?php echo $env?>',
		data: {q:q},
		success: function(data){
			var jsn=JSON.parse(data);
			var op=0;
			var tot=0;
			for(var i=0;i<jsn.length;i++){
				if(jsn[i]['s']=='new'||jsn[i]['s']=='open') {
					op+=parseInt(jsn[i]['t']);
				}else{
					$("#"+q+"_"+jsn[i]['s']).html(jsn[i]['t']);
				}
				tot+=parseInt(jsn[i]['t']);
			}
			$("#"+q+"_newopen").html(op);
			$("#"+q+"_total").html(tot);
		}
	});
	setTimeout(getJarkom,30*1000);
}
function getPRM(q='prm'){
	$.ajax({
		type: 'POST',
		url: 'datajson<?php echo $env?>',
		data: {q:q},
		success: function(data){
			var jsn=JSON.parse(data);
			var mlop=0;
			var mjop=0;
			var rlop=0;
			for(var i=0;i<jsn.length;i++){
				if(jsn[i]['s']=='new'||jsn[i]['s']=='open') {
					if(jsn[i]['grp']=='link'&&jsn[i]['typ']=='migrasi') mlop+=parseInt(jsn[i]['t']);
					if(jsn[i]['grp']=='jarkom'&&jsn[i]['typ']=='migrasi') mjop+=parseInt(jsn[i]['t']);
					if(jsn[i]['grp']=='link'&&jsn[i]['typ']=='relokasi') rlop+=parseInt(jsn[i]['t']);
				}else{
					$("#"+jsn[i]['typ']+"_"+jsn[i]['grp']+"_"+jsn[i]['s']).html(jsn[i]['t']);
				}
				//tot+=parseInt(jsn[i]['t']);
			}
			$("#migrasi_link_newopen").html(mlop);
			$("#migrasi_jarkom_newopen").html(mjop);
			$("#relokasi_link_newopen").html(rlop);
		}
	});
	setTimeout(getPRM,30*1000);
}
</script>

    </body>
</html>

