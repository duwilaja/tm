		
		<div class="modal" id="modal_delete" tabindex="-3" role="dialog" aria-labelledby="smallModalHead" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="smallModalHead">Delete</h4>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </div>
                    <div class="modal-body">
                        Are you sure to delete this record?
                    </div>
                    <div class="modal-footer">
						<button type="button" class="btn btn-success" data-dismiss="modal" onclick="sendDataFile('#myf','DEL');">Yes</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>  
                    </div>
                </div>
            </div>
        </div>
		<div class="modal" id="modal_no_head" tabindex="-2" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">                    
                    <div class="modal-body" style="text-align: center; font-size: 15px;">
					   <div id="processing">
                        <h3><i class='fa fa-spin fa-spinner'></i></h3>
						 Processing...
					   </div>
					   <div id="processing_msgs">
					   </div>
                    </div>
                    <div class="modal-footer">
						<button id="btncontinue" type="button" class="btn btn-success" onclick="$('#yakin').val('Yes');sendDataFile('#myf','SAVE');">Yes</button>
                        <button id="btndone" type="button" class="btn btn-default" data-dismiss="modal" onclick="mmCloseClick('<?php echo $menu?>');">Close</button>
                    </div>
                </div>
            </div>
        </div>
		
          <!-- partial:../../partials/_footer.html -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2025</span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"><a href="https://www.pegadaian.co.id" target="_blank">Pegadaian, PT</a></span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="corona/assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="corona/assets/js/off-canvas.js"></script>
    <script src="corona/assets/js/hoverable-collapse.js"></script>
    <script src="corona/assets/js/misc.js"></script>
    <!-- endinject -->

		<script type="text/javascript" src="js/push.min.js"></script>
		
<?php
include "inc.js.corona.php";
?>

<script>
function mmCloseClick(m){
	if($('#processing_msgs').text()=='Data has been saved'){
		$("#modal_large").modal('hide');
		$(".modal-backdrop").remove();
		if(typeof(parent.$.fancybox.close)=='function'){
			parent.$.fancybox.close();
		}
	}
	return;
}
function openDelete(id){
	$("#id").val(id);
}
function openBatch(id){
	$('#'+id).find("input[type=text], input[type=password], input[type=file], textarea, select").val("");
}
function openForm(id){
	jvalidate.resetForm();
	$(".error").removeClass("error");
	$(".valid").removeClass("valid");
	$('#id').val(id);
	$('#myf').find("input[type=text], input[type=password], input[type=file], textarea, select").val("");
	$('#myf').find("input[type=checkbox]").prop('checked',false);
	
	//console.log($('#id').val());
	if(id==0){
		$('#bdel').hide();
		if($('.selectpicker').length){	$('.selectpicker').selectpicker('refresh'); }
		//$("#preview").attr("src",'img/nopic.png');
		//$("#preview2").attr("src",'img/nopic.png');
	}else{
		$('#bdel').show();
		getData(id);
	}
}

function manage_msgs(s){
	if(s=='start'){
		$("#btndone").hide();
		$("#btncontinue").hide();
		$("#processing").show();
		$("#processing_msgs").hide();
	}else{
		$("#btndone").show();
		$("#processing").hide();
		$("#processing_msgs").show();
	}
}

		function sendDataFile(f,svt,fld='#svt'){
			manage_msgs('start');
			$("#modal_no_head").modal('show');
			$(fld).val(svt);
			
			var url='datasave.php';
			var mtd='POST';
			var frmdata=new FormData($(f)[0]);
			
			//alert(frmdata);
			
			$.ajax({
				type: mtd,
				url: url,
				data: frmdata,
				success: function(data){
					if(typeof(svcallback)=='function'){ svcallback(data,f); }else{
						$("#processing_msgs").html(data);
						manage_msgs('end');
						if('<?php echo $menu?>'!='surveydeu'){
							tblupdate();
						}						
					}
					//$("#modal_large").modal('hide');
				},
				error: function(xhr){
					$("#processing_msgs").html(xhr);
					manage_msgs('end');
				},
				cache: false,
				contentType: false,
				processData: false
			});
			
		};

		function getData(id){	
			
			manage_msgs('start');
			$("#modal_no_head").modal('show');
			
			var url='datajson.php';
			var mtd='POST';
			var frmdata={q:'<?php echo $menu?>',id:id};
			
			//alert(frmdata);
			
			$.ajax({
				type: mtd,
				url: url,
				data: frmdata,
				success: function(data){
					var json=JSON.parse(data);
					//console.log(json);
					var pict="img/nopic.png";
					var pict2=pict;
					$.each(json[0],function (key,val){
						$('#'+key).val(val);
						if (typeof multiSelect === 'function') { multiSelect(key,val); }
						/*if(val=='Y'){$('#'+key+'x')[0].checked=true;}
						if((key=='pict'||key=='img'||key=='pic')&&val!=''){
							pict=val;
						}
						if((key=='cover')&&val!=''){
							pict2=val;
						}
						if(key=="sqlstr"){
							$('#sqlstrx').val(atob(val));
						}*/
					});
					//$("#preview").attr("src",pict);
					//$("#preview2").attr("src",pict2);
					$("#modal_no_head").modal('hide');
					$('body').addClass('modal-open');
				},
				error: function(xhr){
					$("#processing_msgs").html(xhr);
					manage_msgs('end');
				}
			});
			
		};

		<?php if(false){?>
		function getLog(){	
			
			var url='datajson.php';
			var mtd='POST';
			var frmdata={q:'log',id:0};
			
			//alert(frmdata);
			
			$.ajax({
				type: mtd,
				url: url,
				data: frmdata,
				success: function(data){
					var json=JSON.parse(data);
					var a=0, n=0, msg="", s="";
					for(var i=0;i<json.length;i++){
						a++;
						msg+=  '<a href="ticket<?php echo $env;?>?id='+json[i]['rowid']+'" class="list-group-item fancylog">'+
                                    '<div class="list-group-status status-away"></div>'+
                                    '<span class="contacts-title">'+json[i]['h']+'</span>'+
                                    '<p>'+json[i]['lastupd']+'</p>'+
                                '</a>';
					}
					//console.log(json[0]['alert']);
					if(a>=4){
						//console.log('lebih 4');
						$("#txtlog").css('height','200px');
					}else{
						$("#txtlog").css('height','100%');
					}
					$("#infolog").text(a);
					$("#txtlog").html(msg);
					$(".fancylog").fancybox({'type':'iframe'});
				},
				error: function(xhr){
					console.log(xhr);
				}
			});
			setTimeout(getLog,5*60*1000);
		};
		setTimeout(getLog,5*1000);
		<?php }?>
		
		var thePopup=[];
		var popupbody="";
		function getNotif(q='notif'){	
			
			var url='datajson.php';
			var mtd='POST';
			var frmdata={q:q,id:0};
			
			//alert(frmdata);
			
			$.ajax({
				type: mtd,
				url: url,
				data: frmdata,
				success: function(data){
					thePopup = []; popupbody = "";
					var json=JSON.parse(data);
					var a=0, n=0, msg="", s="";
					for(var i=0;i<json.length;i++){
						a++;
						s=json[i]['s'];
						if(s=='new'){
							n++;
							s='success';
							thePopup.push(json[i]);
							popupbody += json[i]['h']+'-'+json[i]['s']+'\n';
						}else{
							if(s=='solved'){
								thePopup.push(json[i]);
								popupbody += json[i]['h']+'-'+json[i]['s']+'\n';
							}
							//if(s=='open'){
							//	s='away';
							//}else{
								s='danger';
							//}
						}
						/*msg+=  '<a target="_blank" href="ticket<?php echo $env;?>?g=1&id='+json[i]['rowid']+'" class="list-group-item fancy">'+
                                    '<div class="list-group-status status-'+s+'"></div>'+
                                    '<span class="contacts-title">'+json[i]['h']+'</span>'+
                                    '<p>'+json[i]['tglj']+'</p>'+
                                '</a>';*/
								
						msg+= 	'<a class="dropdown-item preview-item" href="JavaScript:;" data-fancybox data-type="iframe" data-src="ticket<?php echo $env;?>?g=1&id='+json[i]['rowid']+'">'+
									'<div class="preview-thumbnail">'+
									  '<div class="preview-icon bg-dark rounded-circle">'+
										'<i class="mdi mdi-ticket text-'+s+'"></i>'+
									  '</div>'+
									'</div>'+
									'<div class="preview-item-content">'+
									  '<p class="preview-subject mb-1">'+json[i]['h']+'</p>'+
									  '<p class="text-muted ellipsis mb-0"> '+json[i]['tglj']+' </p>'+
									'</div>'+
								  '</a>'+
								  '<div class="dropdown-divider"></div>'
										
					}
					
					if(a>0){
						msg='<h6 class="p-3 mb-0">Notifications</h6>'+
                  '<div class="dropdown-divider"></div>'+msg;
						$(".count").removeClass("hidden");
					}else{
						$(".count").addClass("hidden");
					}
					/*/console.log(json[0]['alert']);
					if(a>=4){
						//console.log('lebih 4');
						$("#txtmsg").css('height','200px');
					}else{
						$("#txtmsg").css('height','100%');
					}*/
					
					$("#alert").text(a);
					$("#nalert").text(n);
					$("#txtmsg").html(msg);
					if(typeof $(".fancy").fancybox==='function'){
						$(".fancy").fancybox({'type':'iframe'});
					}
					if(a==0){
						$("#txtlnk").css('display','none');
					}else{
						$("#txtlnk").css('display','inline');
					}
					pushThis();
					//if (typeof tblPupdate === 'function') { tblPupdate(); }
				},
				error: function(xhr){
					console.log(xhr);
				}
			});
			setTimeout(checkTime,1*60*1000);
		};
		setTimeout(checkTime,3*1000);
		
		function checkTime(){
			var dtm=new Date();
			var h=dtm.getHours();
			var mi=dtm.getMinutes();
			if(h>=7&&h<=18){
				var jams = [8,10,12,14,16,18];
				if(jams.indexOf(h)>-1 && mi==0) {getNotif('notifall');} else {getNotif();}
			}
		}
		
		function pushThis(){
			var fromnotif = "<?php echo isset($_GET['fromnotif'])?"1":"";?>";
			if(thePopup.length>0 && fromnotif=="" && Push.Permission.has()){
				var lnk = "";
				var body= "";
				var fancyx = false;
				if(thePopup.length>1){
					lnk = 'tickets<?php echo $env;?>?fromnotif=1';
					body = popupbody;
				}else{
					lnk = 'ticket<?php echo $env;?>?g=1&fromnotif=1&id='+thePopup[0]['rowid'];
					body = thePopup[0]['h']+'-'+thePopup[0]['s'];
					fancyx = true;
				}
				Push.create("Ticket(s) need attention",{
					body: body,
					timeout: 10000,
					onClick: function () {
						this.close();
						window.focus();
						if(fancyx){
							if(typeof $(".fancy").fancybox==='function'){
								$.fancybox.open({type:'iframe',src: lnk});
							}else{
								window.open(lnk);
							}
						}else{
							document.location.href = lnk;
						}
					}
				});
			}
			
		}
		
		$(".input-group").removeClass("input-group");
		if($(".datepicker").length > 0){
			$(".datepicker").datepicker({format: 'yyyy-mm-dd'});                
		}
		
		
function datetime(){
	if($(".plugin-date").length > 0){
		
		var days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
		var months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
				
		var now     = new Date();
		var day     = days[now.getDay()];
		var date    = now.getDate();
		var month   = months[now.getMonth()];
		var year    = now.getFullYear();
		
		$(".plugin-date").html(day+", "+month+" "+date+", "+year);
	}
	if($(".plugin-clock").length > 0){
		
		tp_clock_time();		
	}
	window.setInterval(function(){
		datetime();                    
	},10000);
}
function tp_clock_time(){
	var now     = new Date();
	var hour    = now.getHours();
	var minutes = now.getMinutes();                    
	
	hour = hour < 10 ? '0'+hour : hour;
	minutes = minutes < 10 ? '0'+minutes : minutes;
	
	$(".plugin-clock").html(hour+"<span>:</span>"+minutes);

}
datetime();
</script>