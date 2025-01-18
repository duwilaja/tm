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
			
			<div class="row row-cols-1 row-cols-sm-1 row-cols-md-5 row-cols-lg-5 row-cols-xl-5">
				<div class="col">
					<div class="card">
						<div class="card-body" style="padding: 10px 0px; min-height: 110px;">
							<div class="mywijval"><span id="30days_new">0</span> &nbsp;<i class="mdi mdi-ticket"></i></div>
							<div class="mywijtxt bg-orange">New</div>
						</div>
					</div>
				</div>
				<div class="col">
					<div class="card">
						<div class="card-body" style="padding: 10px 0px; min-height: 110px;">
							<div class="mywijval"><span id="30days_open">0</span> &nbsp;<i class="mdi mdi-book-open-page-variant"></i></div>
							<div class="mywijtxt bg-green">Open</div>
						</div>
					</div>
				</div>
				<div class="col">
					<div class="card">
						<div class="card-body" style="padding: 10px 0px; min-height: 110px;">
							<div class="mywijval"><span id="30days_progress">0</span> &nbsp;<i class="mdi mdi-reload"></i></div>
							<div class="mywijtxt bg-red">Progress</div>
						</div>
					</div>
				</div>
				<div class="col">
					<div class="card">
						<div class="card-body" style="padding: 10px 0px; min-height: 110px;">
							<div class="mywijval"><span id="30days_solved">0</span> &nbsp;<i class="mdi mdi-bookmark-check"></i></div>
							<div class="mywijtxt bg-pink">Solved</div>
						</div>
					</div>
				</div>
				<div class="col">
					<div class="card">
						<div class="card-body" style="padding: 10px 0px; min-height: 110px;">
							<div class="mywijval"><span id="30days_total">0</span> &nbsp;<i class=" mdi mdi-basket-fill"></i></div>
							<div class="mywijtxt bg-purple">Total</div>
						</div>
					</div>
				</div>
			</div>
			<br />
			<div class="row">
				<div class="col-lg-6">
				<div class="card">
				  <div class="card-body">
				  <h4 class="card-title">SLA Gangguan</h4>
					<div class="row">
					  <div class="col-lg-4  stretch-card" style="padding-left: 0; padding-right: 0">
						<div class="">
						  <div class="card-body" style="text-align: center; padding-top: 0px;padding-bottom: 0px;">
							<div class="indonut" id="1hr" style="color:#a7d990;">
								0
							</div>
							<canvas id="doughnutChart" style="max-height:120px"></canvas>
							>1 Hour
						  </div>
						</div>
					  </div>
					  <div class="col-lg-4  stretch-card" style="padding-left: 0; padding-right: 0">
						<div class="">
						  <div class="card-body" style="text-align: center; padding-top: 0px;padding-bottom: 0px;">
							<div class="indonut" id="6hr" style="color:#ff9799;">
								0
							</div>
							<canvas id="doughnutChart2" style="max-height:120px"></canvas>
							>6 Hour
						  </div>
						</div>
					  </div>
					  <div class="col-lg-4  stretch-card" style="padding-left: 0; padding-right: 0">
						<div class="">
						  <div class="card-body" style="text-align: center; padding-top: 0px;padding-bottom: 0px;">
							<div class="indonut" id="24hr" style="color:#10729c;">
								0
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
				<div class="col-lg-6">
				<div class="card">
				  <div class="card-body">
				  <h4 class="card-title">SLA Relokasi</h4>
					<div class="row">
					  <div class="col-lg-4  stretch-card" style="padding-left: 0; padding-right: 0">
						<div class="">
						  <div class="card-body" style="text-align: center; padding-top: 0px;padding-bottom: 0px;">
							<div id="relok" class="indonut" style="color:#a7d990;">
								0
							</div>
							<canvas id="doughnutChart4" style="max-height:120px"></canvas>
							> SLA
						  </div>
						</div>
					  </div>
					  <div class="col-lg-4  stretch-card" style="padding-left: 0; padding-right: 0">
						<div class="">
						  <div class="card-body" style="text-align: center; padding-top: 0px;padding-bottom: 0px;">
							<div id="inet" class="indonut" style="color:#ff9799;">
								0
							</div>
							<canvas id="doughnutChart5" style="max-height:120px"></canvas>
							Internet
						  </div>
						</div>
					  </div>
					  <div class="col-lg-4  stretch-card" style="padding-left: 0; padding-right: 0">
						<div class="">
						  <div class="card-body" style="text-align: center; padding-top: 0px;padding-bottom: 0px;">
							<div id="vpn" class="indonut" style="color:#10729c;">
								0
							</div>
							<canvas id="doughnutChart6" style="max-height:120px"></canvas>
							VPN
						  </div>
						</div>
					  </div>
					</div>
				  </div>
				</div>
				</div>
			</div>
			<br />
			<div class="row">
              <div class="col-lg-3 stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Ticket By Services</h4>
                    <canvas id="pieChart" style="max-height:150px"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Ticket By Issue</h4>
                    <canvas id="pieChart2" style="max-height:150px"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Ticket Jarkom</h4>
                    <canvas id="pieChart3" style="max-height:150px"></canvas>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Ticket By Date</h4>
                    <canvas id="barChart" style="max-height:150px"></canvas>
                  </div>
                </div>
              </div>
            </div>
			<br />
			<div class="row">
				<div class="col-lg-2"><a class="ahome" href="javascript:;"  data-fancybox data-type="iframe" data-src="peta<?php echo $env?>?tipe=kanwil">
					<div class="card">
						<div class="card-body" style="padding: 10px 20px; display: flex; color: #000000;">
							<div class="mywijval"><i class="mdi mdi-hospital-building"></i></div>
							<div class="mywijet"><span id="kanwil">0</span><br />Kanwil</div>
						</div>
					</div></a>
				</div>
				<div class="col-lg-2"><a class="ahome" href="javascript:;"  data-fancybox data-type="iframe" data-src="peta<?php echo $env?>?tipe=area">
					<div class="card">
						<div class="card-body" style="padding: 10px 20px; display: flex; color: #000000;">
							<div class="mywijval"><i class="mdi mdi-bank"></i></div>
							<div class="mywijet"><span id="area">0</span><br />Kantor Area</div>
						</div>
					</div></a>
				</div>
				<div class="col-lg-2"><a class="ahome" href="javascript:;"  data-fancybox data-type="iframe" data-src="peta<?php echo $env?>?tipe=cpp">
					<div class="card">
						<div class="card-body" style="padding: 10px 20px; display: flex; color: #000000;">
							<div class="mywijval"><i class=" mdi mdi-home-modern"></i></div>
							<div class="mywijet"><span id="cpp">0</span><br />Kantor CPP</div>
						</div>
					</div></a>
				</div>
				<div class="col-lg-2"><a class="ahome" href="javascript:;"  data-fancybox data-type="iframe" data-src="peta<?php echo $env?>?tipe=upc">
					<div class="card">
						<div class="card-body" style="padding: 10px 20px; display: flex; color: #000000;">
							<div class="mywijval"><i class="mdi mdi-hospital-building"></i></div>
							<div class="mywijet"><span id="upc">0</span><br />Kantor UPC</div>
						</div>
					</div></a>
				</div>
				<div class="col-lg-2"><a class="ahome" href="javascript:;"  data-fancybox data-type="iframe" data-src="peta<?php echo $env?>?tipe=deputy">
					<div class="card">
						<div class="card-body" style="padding: 10px 20px; display: flex; color: #000000;">
							<div class="mywijval"><i class="mdi mdi-bank"></i></div>
							<div class="mywijet"><span id="deputy">0</span><br />Deputy</div>
						</div>
					</div></a>
				</div>
				<div class="col-lg-2"><a class="ahome" href="javascript:tabel();">
					<div class="card">
						<div class="card-body" style="padding: 10px 20px; display: flex; color: #000000;">
							<div class="mywijval"><i class=" mdi mdi-home-modern"></i></div>
							<div class="mywijet"><span id="outlet">0</span><br />Outlet</div>
						</div>
					</div></a>
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
											<th id="namacap">Outlet</th>									
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
	getKAO();
	bikinchart();
	initTbl();
})

//Chart.register(ChartDataLabels);

var mytbl;

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
	cutout: "80%",
	 plugins: {
			legend:{
				display: false
			},
			tooltip: {
				enabled: false
			}
	 }
  };

  var data = {
    labels: ["2013", "2014", "2014", "2015", "2016"],
    datasets: [{
      label: '# of Votes',
      data: [10, 19, 3, 5, 2],
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
  
  var piecolors=["#e95c60","#fcd46c","#fcd66f","#9999ff","#66ff33","#ff66cc","#cccc00","#cc00ff","#996633","#336600","#336699","#339966"];
  
function randomColor(){
	return "#"+(Math.random().toString(16)+"000000").slice(2, 8).toUpperCase();
}

function buildPieData(jsn,cls=[]){
	var lbl=[];
	var dta=[];
	var clr=[];
	for(var i=0;i<jsn.length;i++){
		lbl.push(jsn[i]['x']);
		dta.push(jsn[i]['y']);
		if(cls.length>i){
			clr.push(cls[i]);
		}else{
			clr.push(randomColor());
		}
	}
	var piedata={
			datasets: [{
			  data: dta,
			  backgroundColor: clr,
			  borderColor: clr,
			}],

			// These labels appear in the legend and in the tooltips when hovering different arcs
			labels: lbl
	};
	return piedata;
}

function buildBarData(jsn,cls=[]){
	var lbl=[];
	var dta=[];
	var clr=[];
	for(var i=0;i<jsn.length;i++){
		lbl.push(jsn[i]['x']);
		dta.push(jsn[i]['y']);
		if(cls.length>i){
			clr.push(cls[i]);
		}else{
			clr.push(randomColor());
		}
	}
	var bardata={
			datasets: [{
			  label: "Total",
			  data: dta,
			  backgroundColor: clr,
			  borderColor: clr,
			}],

			// These labels appear in the legend and in the tooltips when hovering different arcs
			labels: lbl
	};
	return bardata;
}

function bikinSLA(divid,json,color){
	if ($(divid).length) {
    var doughnutChartCanvas = $(divid).get(0).getContext("2d");
	doughnutPieData=buildPieData(json,color);
    var doughnutChart = new Chart(doughnutChartCanvas, {
      type: 'doughnut',
      data: doughnutPieData,
      options: doughnutOptions
    });
  }
}

function bikinchart(){
  if ($("#barChart").length) {
	$.ajax({
		type: 'POST',
		url: 'datajson<?php echo $env?>',
		data: {q:'homebar'},
		success: function(data){
			var json=JSON.parse(data);
			//console.log(jsn);
			data = buildBarData(json,piecolors);
			var barChartCanvas = $("#barChart").get(0).getContext("2d");
			// This will get the first returned node in the jQuery collection.
			var barChart = new Chart(barChartCanvas, {
			  type: 'bar',
			  data: data,
			  options: options
			});
		}
	});
  }
  
  $.ajax({
		type: 'POST',
		url: 'datajson.php',
		data: {q:'agings',id:'0'},
		success: function(datax){
			var data=JSON.parse(datax);
			console.log(data);
			var hr1=0; var hr2=0; var hr4=0; var hr6=0; var hr8=0; var hr9=0; var hr24=0; var jam=60; var tott=0;
			for(var i=0;i<data.length;i++){
				if(parseInt(data[i]['a'])>=(24*jam)){
					hr24+=parseInt(data[i]['c']);
				/*}else if(parseInt(data[i]['a'])>=(12*jam)){
					hr9+=parseInt(data[i]['c']);
				}else if(parseInt(data[i]['a'])>=(8*jam)){
					hr8+=parseInt(data[i]['c']);*/
				}else if(parseInt(data[i]['a'])>=(6*jam)){
					hr6+=parseInt(data[i]['c']);
				/*}else if(parseInt(data[i]['a'])>=(4*jam)){
					hr4+=parseInt(data[i]['c']);
				}else if(parseInt(data[i]['a'])>=(2*jam)){
					hr2+=parseInt(data[i]['c']);*/
				}else if(parseInt(data[i]['a'])>=(1*jam)){
					hr1+=parseInt(data[i]['c']);
				}
				tott+=parseInt(data[i]['c']);
			}
			if(tott==0) tott=1;
			bikinSLA("#doughnutChart",[{x:"Total",y:hr1},{x:"",y:(tott-hr1)}],["#a7d990","#d2ebc6"]);
			bikinSLA("#doughnutChart2",[{x:"Total",y:hr6},{x:"",y:(tott-hr6)}],["#ff9799","#ffcccd"]);
			bikinSLA("#doughnutChart3",[{x:"Total",y:hr24},{x:"",y:(tott-hr24)}],["#10729c","#bae5f7"]);
			$("#1hr").html(hr1); $("#4hr").html(hr4); $("#6hr").html(hr6); $("#8hr").html(hr8); $("#9hr").html(hr9); $("#24hr").html(hr24); 
		},
		error: function(xhr){
			console.log(xhr);
		}
  });
  
  $.ajax({
		type: 'POST',
		url: 'datajson.php',
		data: {q:'homerel',id:'0'},
		success: function(datax){
			var data=JSON.parse(datax);
			console.log(data);
			var ovr=0; var wif=0; var nonwif=0; var tott=0;
			for(var i=0;i<data.length;i++){
				if(data[i]['x']=='wifi station'){
					if(parseInt(data[i]['z']) > 28){ //wif
						ovr+=parseInt(data[i]['y']);
					}
					wif+=parseInt(data[i]['y']);
				}else{
					if(parseInt(data[i]['z']) > 56){ //nonwif
						ovr+=parseInt(data[i]['y']);
					}
					nonwif+=parseInt(data[i]['y']);
				}
				tott+=parseInt(data[i]['y']);
			}
			if(tott==0) tott=1;
			bikinSLA("#doughnutChart4",[{x:"Total",y:ovr},{x:"",y:(tott-ovr)}],["#a7d990","#d2ebc6"]);
			bikinSLA("#doughnutChart5",[{x:"Total",y:wif},{x:"",y:(tott-wif)}],["#ff9799","#ffcccd"]);
			bikinSLA("#doughnutChart6",[{x:"Total",y:nonwif},{x:"",y:(tott-nonwif)}],["#10729c","#bae5f7"]);
			$("#relok").html(ovr); $("#inet").html(wif); $("#vpn").html(nonwif);
		},
		error: function(xhr){
			console.log(xhr);
		}
  });
  
  if ($("#pieChart").length) {
	$.ajax({
		type: 'POST',
		url: 'datajson<?php echo $env?>',
		data: {q:'homepie',id:'st',idx:'link'},
		success: function(data){
			var json=JSON.parse(data);
			//console.log(jsn);
			doughnutPieData = buildPieData(json,piecolors);
			var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
			var pieChart = new Chart(pieChartCanvas, {
			  type: 'pie',
			  data: doughnutPieData,
			  options: doughnutPieOptions
			});
		}
	});
  }
  if ($("#pieChart2").length) {
    $.ajax({
		type: 'POST',
		url: 'datajson<?php echo $env?>',
		data: {q:'homepie',id:'typ',idx:'link'},
		success: function(data){
			var json=JSON.parse(data);
			//console.log(jsn);
			doughnutPieData = buildPieData(json,piecolors);
			var pieChartCanvas = $("#pieChart2").get(0).getContext("2d");
			var pieChart = new Chart(pieChartCanvas, {
			  type: 'pie',
			  data: doughnutPieData,
			  options: doughnutPieOptions
			});
		}
	});
  }
  if ($("#pieChart3").length) {
    $.ajax({
		type: 'POST',
		url: 'datajson<?php echo $env?>',
		data: {q:'homepie',id:'s',idx:'jarkom'},
		success: function(data){
			var json=JSON.parse(data);
			//console.log(jsn);
			doughnutPieData = buildPieData(json,piecolors);
			var pieChartCanvas = $("#pieChart3").get(0).getContext("2d");
			var pieChart = new Chart(pieChartCanvas, {
			  type: 'pie',
			  data: doughnutPieData,
			  options: doughnutPieOptions
			});
		}
	});
  }
}
function getKAO(q='kao'){
	$.ajax({
		type: 'POST',
		url: 'datajson<?php echo $env?>',
		data: {q:q},
		success: function(data){
			var json=JSON.parse(data);
			//console.log(jsn);
			for(var i=0;i<json.length;i++){
				$("#"+json[i]['tipe']).html(json[i]['tot']);
			}
		}
	});
	setTimeout(getKAO,300*1000);
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
					$("#"+q+"_"+jsn[i]['s']).html(jsn[i]['t']);
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

function initTbl(){
	mytbl = $('#example').DataTable({
	//dom: 'T<"clear"><lrf<t>ip>',
	searching: true,
	serverSide: true,
	processing: true,
	ordering: true,
	order: [[ 0, "asc" ]],
		ajax: {
			type: 'POST',
			url: 'dataget.php',
			data: function (d) {
				d.cols= '<?php echo base64_encode("oname"); ?>',
				d.tname= '<?php echo base64_encode("tm_outlets"); ?>',
				d.csrc= 'oname',
				d.where= '<?php echo base64_encode("tipe='outlet'"); ?>',
				d.x= '-';
			}
		}
	});
}

function tabel(){
	//mytbl.ajax.reload();
	$('#modal_madul').modal('show');
}
</script>

    </body>
</html>

