<?php
include 'inc.chksession.php';
include 'inc.common.php';

$menu="r_templates";

$id=isset($_GET['id'])?$_GET['id']:0;
$df=isset($_GET['df'])?$_GET['df']:"";
$dt=isset($_GET['dt'])?$_GET['dt']:"";
$fdf=isset($_GET['fdf'])?$_GET['fdf']:"";
$fdt=isset($_GET['fdt'])?$_GET['fdt']:"";
$cdf=isset($_GET['cdf'])?$_GET['cdf']:"";
$cdt=isset($_GET['cdt'])?$_GET['cdt']:"";
$blink=isset($_GET['blink'])?$_GET['blink']:"";
$jp=isset($_GET['jp'])?$_GET['jp']:"";
$age=isset($_GET['age'])?$_GET['age']:"";
$st=isset($_GET['st'])?$_GET['st']:"";
if($st!=''){
	$st=$st=='wifi'?" and st='wifi station'":" and st<>'wifi station'";
}

$title=$id<6?$r_templates[$id][1]." Tickets":$r_templates[$id][1];
$icon="fa fa-file-o";

include 'inc.head.php';

$tname=$r_templates[$id][2];
$caps=explode(",",$r_templates[$id][3]);
$cols=$r_templates[$id][4];
$where=$r_templates[$id][5].base64_decode(urldecode($age)).$st;

$grpby=count($r_templates[$id])>6?$r_templates[$id][6]:"";
$having=count($r_templates[$id])>7?$r_templates[$id][7]:"";

$colsrc="";

?>
        <!-- START PAGE CONTAINER -->
        <div class="page-container page-navigation-top">            
            <!-- PAGE CONTENT -->
            <div class="page-content">
                
<?php
//include 'inc.menu.php';
?>
                
                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <!--li><a href="home.php">Home</a></li-->
                    <li class="active">&nbsp;</li>
                </ul>
                <!-- END BREADCRUMB -->                
                
                <div class="page-title">                    
                    <h2><span class="<?php echo $icon;?>"></span> <?php echo $title;?></h2>
				<!--	<a href="#" onclick="openForm(0);" data-toggle="modal" data-target="#modal_large" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Create</a>
                -->
				</div>                   
                
                <!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">                
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body table-responsive">
                                    <table id="example" class="table">
                                        <thead>
                                            <tr>
											<?php for($i=0;$i<count($caps);$i++){?>
                                                <th><?php echo $caps[$i]?></th>
											<?php }?>
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
        
		<script type="text/javascript" src="js/plugins/datatables/jquery.dataTables.min.js"></script>    
        <script type='text/javascript' src='js/plugins/jquery-validation/jquery.validate.js'></script>
		<script type='text/javascript' src='js/jquery-validate-multi-email.js'></script>
		<script type="text/javascript" src="js/plugins/bootstrap/bootstrap-datepicker.js"></script>
        <!-- END PAGE PLUGINS -->       
		
		<script src="js/plugins/datatables/dataTables.buttons.js"></script>
		<script src="js/plugins/datatables/buttons.flash.js"></script>
		<script src="js/plugins/datatables/jszip.min.js"></script>
		<script src="js/plugins/datatables/pdfmake.min.js"></script>
		<script src="js/plugins/datatables/vfs_fonts.js"></script>
		<script src="js/plugins/datatables/buttons.html5.js"></script>
		<script src="js/plugins/datatables/buttons.print.js"></script>

		<link rel="stylesheet" href="js/plugins/datatables/buttons.dataTables.css">

        <!-- START TEMPLATE >
        <script type="text/javascript" src="js/settings.js"></script-->
        
        <script type="text/javascript" src="js/plugins.js"></script>        
        <script type="text/javascript" src="js/actions.js"></script>        
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->         
	
	<script>
	var mytbl, jvalidate;
$(document).ready(function() {
	mytbl = $('#example').DataTable({
	dom: 'T<"clear"><lrB<t>ip>',
	lengthMenu: [[10,50,100,500,1000,5000,10000,-1],["10","50","100","500","1000","5000","10000","All"]],
	buttons: [
            'copy', 'csv', {
				extend: 'excelHtml5'/*,
				customizeData: function(data) {
					for(var i = 0; i < data.body.length; i++) {
					  for(var j = 0; j < data.body[i].length; j++) {
						data.body[i][j] = '\u200C' + data.body[i][j];
					  }
					}
				  }*/
			}, 'print', {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL'
            }
        ],
	searching: false,
	serverSide: true,
	processing: true,
	ordering: true,
	order: [[ 0, "desc" ]],
		ajax: {
			type: 'POST',
			url: 'dataget.php',
			data: function (d) {
				d.cols= '<?php echo base64_encode($cols); ?>',
				d.tname= '<?php echo base64_encode($tname); ?>',
				d.csrc= '<?php echo $colsrc; ?>',
				d.where= '<?php echo base64_encode($where);?>',
				d.grpby= '<?php echo base64_encode($grpby);?>',
				d.having= '<?php echo base64_encode($having);?>',
				d.df= '<?php echo $df; ?>',
				d.dt= '<?php echo $dt; ?>',
				d.fdf= '<?php echo $fdf; ?>',
				d.fdt= '<?php echo $fdt; ?>',
				d.cdf= '<?php echo $cdf; ?>',
				d.cdt= '<?php echo $cdt; ?>',
				d.blink= '<?php echo $blink; ?>',
				d.ljp= '<?php echo $jp; ?>',
				d.rpt= '<?php echo $id?>',
				d.x= '<?php echo $menu; ?>';
			}
		}
	});
});

function tblupdate(){
	mytbl.ajax.reload();
}

function oclick(c,v){
	if($(c)[0].checked){
		$(v).val('Y');
	}else{
		$(v).val('');
	}
}
</script>
	
    </body>
</html>
