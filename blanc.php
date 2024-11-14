<?php
$corona=true;
include 'inc.chksession.php';
$s_NAME="Nama User";
include 'inc.common.php';
$title="Page Title";
include 'inc.head.php';

$menu="kanwil";

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
						<div class="col-md-6">

                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Default form</h4>
                    <p class="card-description"> Basic form layout </p>
                    <form class="forms-sample">
                      <div class="form-group">
                        <label for="exampleInputUsername1">Username</label>
                        <input type="text" class="form-control" id="exampleInputUsername1" placeholder="Username">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputConfirmPassword1">Confirm Password</label>
                        <input type="password" class="form-control" id="exampleInputConfirmPassword1" placeholder="Password">
                      </div>
                      <div class="form-check form-check-flat form-check-primary">
                        <label class="form-check-label">
                          <input type="checkbox" class="form-check-input"> Remember me <i class="input-helper"></i></label>
                      </div>
                      <button type="submit" class="btn btn-primary mr-2">Submit</button>
                      <button class="btn btn-dark">Cancel</button>
                    </form>
                  </div>
                </div>
              
						</div>
						<div class="col-md-6">

                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Horizontal Form</h4>
                    <p class="card-description"> Horizontal form layout </p>
                    <form class="forms-sample">
                      <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="exampleInputUsername2" placeholder="Username">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Email">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="exampleInputMobile" class="col-sm-3 col-form-label">Mobile</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="exampleInputMobile" placeholder="Mobile number">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Password</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" id="exampleInputPassword2" placeholder="Password">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label">Re Password</label>
                        <div class="col-sm-9">
                          <input type="password" class="form-control" id="exampleInputConfirmPassword2" placeholder="Password">
                        </div>
                      </div>
                      <div class="form-check form-check-flat form-check-primary">
                        <label class="form-check-label">
                          <input type="checkbox" class="form-check-input"> Remember me <i class="input-helper"></i></label>
                      </div>
                      <button type="submit" class="btn btn-primary mr-2">Submit</button>
                      <button class="btn btn-dark">Cancel</button>
                    </form>
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
                      <table class="table table-dark hidden">
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
						
						<br /><br />
					
						<table id="example" class="table table-dark">
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
		  
		<div class="modal" id="modal_large" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="largeModalHead" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="largeModalHead"><b><i class="fa <?php echo $icon;?>"></i> <?php echo $title;?></b></h4>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </div>
					<div class="">
					
						<form class="form-horizontal" id="myf">
                            <div class="panel panel-default">
							<div class="panel-body">
									<input type="hidden" name="t" value="<?php echo $menu;?>">
									<input type="hidden" name="tname" value="<?php echo $tname;?>">
									<input type="hidden" name="columns" value="locid,locname">
									<input type="hidden" id="svt" name="svt" value="">
									<input type="hidden" name="id" id="id" value="0">
									
								<div class="form-group">
									<label class="col-md-2 control-label">ID</label>
									<div class="col-md-10">
										<input type="text" class="form-control input-sm" name="locid" id="locid" placeholder="...">
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-2 control-label">Name</label>
									<div class="col-md-10">
										<input type="text" class="form-control input-sm" name="locname" id="locname" placeholder="...">
									</div>
								</div>
								
							</div>
							<div class="panel-body" id="pesan"></div>
							</div>
						</form>

                    </div>
                    <div class="modal-footer">
						<button type="button" class="btn btn-success" onclick="if($('#myf').valid()){sendDataFile('#myf','SAVE');}">Save</button>
						<button type="button" class="btn btn-danger" id="bdel" data-toggle="modal" data-target="#modal_delete">Delete</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
        <!-- END PLUGINS -->

        <!-- THIS PAGE PLUGINS --
        <script type='text/javascript' src='js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script-->
		<script type="text/javascript" src="corona/bs4/dataTables.js"></script>
		<script type="text/javascript" src="corona/bs4//dataTables.bootstrap4.js"></script>		
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

