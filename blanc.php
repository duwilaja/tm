<?php
$corona=true;
include 'inc.chksession.php';
$s_NAME="Nama User";
include 'inc.common.php';
$title="Page Title";
include 'inc.head.php';

$menu="";

$icon="fa fa-tachometer";


$where="";
$tname="tm_kanwils";
$cols="locid,locname,rowid";
$colsrc="locname";


include 'inc.menu.php';
?>
        
        <div class="main-panel">
          <div class="content-wrapper">
			
					<div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    Add class <code>.page-navigation-top</code> to <code>.page-container</code> to use top navigation
									<canvas id="cart" style="height: 300px; max-height: 300px;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="row">
						<div class="col-md-12">
						
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Inverse table</h4>
                    <p class="card-description"> Add class <code>.table-dark</code>
                    </p>
                    <div class="table-responsive">
                      <table class="table table-dark">
                        <thead>
                          <tr>
                            <th> # </th>
                            <th> First name </th>
                            <th> Amount </th>
                            <th> Deadline </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td> 1 </td>
                            <td> Herman Beck </td>
                            <td> $ 77.99 </td>
                            <td> May 15, 2015 </td>
                          </tr>
                          <tr>
                            <td> 2 </td>
                            <td> Messsy Adam </td>
                            <td> $245.30 </td>
                            <td> July 1, 2015 </td>
                          </tr>
                          <tr>
                            <td> 3 </td>
                            <td> John Richards </td>
                            <td> $138.00 </td>
                            <td> Apr 12, 2015 </td>
                          </tr>
                          <tr>
                            <td> 4 </td>
                            <td> Peter Meggik </td>
                            <td> $ 77.99 </td>
                            <td> May 15, 2015 </td>
                          </tr>
                          <tr>
                            <td> 5 </td>
                            <td> Edward </td>
                            <td> $ 160.25 </td>
                            <td> May 03, 2015 </td>
                          </tr>
                          <tr>
                            <td> 6 </td>
                            <td> John Doe </td>
                            <td> $ 123.21 </td>
                            <td> April 05, 2015 </td>
                          </tr>
                          <tr>
                            <td> 7 </td>
                            <td> Henry Tom </td>
                            <td> $ 150.00 </td>
                            <td> June 16, 2015 </td>
                          </tr>
                        </tbody>
                      </table>
						<table id="example" class="table">
							<thead>
								<tr>
									<th>ID</th>
									<th>Name</th>
									
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
                    </div>
                  </div>
                </div>
              
						</div>
					</div>
			
          </div>
          <!-- content-wrapper ends -->
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
		<script type="text/javascript" src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap4.js"></script>		
        <script type='text/javascript' src='js/plugins/jquery-validation/jquery.validate.js'></script>
        <!-- END PAGE PLUGINS -->       
		
		<script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
		<script src="https://www.chartjs.org/samples/2.9.4/utils.js"></script>

    <!-- END SCRIPTS -->         
	<script>
	var mytbl, jvalidate;
$(document).ready(function() {
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
				d.cols= '<?php echo base64_encode($cols); ?>',
				d.tname= '<?php echo base64_encode($tname); ?>',
				d.csrc= '<?php echo $colsrc; ?>',
				d.where= '<?php echo base64_encode($where);?>',
				//d.sever= $("#sever").val(),
				d.x= '<?php echo $menu; ?>';
			}
		}
	});
	
	jvalidate = $("#myf").validate({
    rules :{
        "locid" : {
            required : true
        },
		"locname" : {
            required : true
        }
    }});
});
	
function cart(){	
	var DATA_COUNT = 10;
var labels = [];

Samples.utils.srand(2);

for (var i = 0; i < DATA_COUNT; ++i) {
  labels.push('' + i);
}
var ctx = document.getElementById("cart").getContext('2d');
var chart = new Chart(ctx, {
  plugins: [ChartDataLabels],
	  type: 'bar',
	  data: {
		labels: labels,
		datasets: [{
		  backgroundColor: Samples.utils.color(0),
		  data: Samples.utils.numbers({
			count: DATA_COUNT,
			min: 0,
			max: 100
		  }),
		  datalabels: {
			align: 'end',
			anchor: 'start'
		  }
		}, {
		  backgroundColor: Samples.utils.color(1),
		  data: Samples.utils.numbers({
			count: DATA_COUNT,
			min: 0,
			max: 100
		  }),
		  datalabels: {
			align: 'center',
			anchor: 'center'
		  }
		}, {
		  backgroundColor: Samples.utils.color(2),
		  data: Samples.utils.numbers({
			count: DATA_COUNT,
			min: 0,
			max: 100
		  }),
		  datalabels: {
			anchor: 'end',
			align: 'start',
		  }
		}]
	  },
	  options: {
		plugins: {
		  datalabels: {
			color: 'white',
			display: function(context) {
			  return context.dataset.data[context.dataIndex] > 15;
			},
			font: {
			  weight: 'bold'
			},
			formatter: Math.round
		  }
		},

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
			stacked: true
		  },
		  y: {
			stacked: true
		  }
		}
	  }
})
}

	</script>
    </body>
</html>

