<?php
$corona=true;
include 'inc.chksession.php';
$s_NAME="Nama User";
include 'inc.common.php';
$title="Page Title";
include 'inc.head.php';

$menu="";

$icon="fa fa-tachometer";

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
        <!-- END PAGE PLUGINS -->       
		
		<script src="https://cdn.jsdelivr.net/npm/chart.js@3.0.0/dist/chart.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
		<script src="https://www.chartjs.org/samples/2.9.4/utils.js"></script>

    <!-- END SCRIPTS -->         
	<script>
	
	
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

	</script>
    </body>
</html>

