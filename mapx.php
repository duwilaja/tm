<?php
$corona=true;

include 'inc.chksession.php';
include 'inc.common.php';
$title="Map View";
include 'inc.head.php';

$menu="mapv";

$icon="fa fa-map-marker";

include 'inc.menu.php';
?>
                
        <div class="main-panel">
          <div class="content-wrapper" style="padding-left:0;padding-right:0;padding-top:0;">
                    
                    <div class="row hidden">
                        <div class="col-md-12">
                            <div class="card card-default">
								<div class="card-heading hidden">
                                    <div class="card-title-box">
                                        <h3></h3>
                                    </div>                                    
                                    <ul class="card-controls">
                                        <li><a href="#" class="card-fullscreen"><span class="fa fa-expand"></span></a></li>
                                        <!--li><a href="JavaScript:goToBase();"><span class="fa fa-refresh"></span></a></li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>                                        
                                            <ul class="dropdown-menu">
                                                <li><a href="#" class="card-collapse"><span class="fa fa-angle-down"></span> Collapse</a></li>
                                                <li><a href="#" class="card-remove"><span class="fa fa-times"></span> Remove</a></li>
                                            </ul>                                        
                                        </li-->                                        
                                    </ul>                                    
                                </div> 
                                <div class="card-body">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
					<div class="row">
						<div id="leafletMap" style="width:100%;height:570px;"></div>
					</div>
					<br />
			<div style="padding: 1.875rem 1.75rem;">
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
			</div>
          </div>
          <!-- content-wrapper ends -->

<?php
include 'inc.logout.php';
?>

    <!-- START SCRIPTS -->

        <!-- START TEMPLATE >
        <script type="text/javascript" src="js/settings.js"></script-->
		
		<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
		<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
		
        <!-- END TEMPLATE -->
    <!-- END SCRIPTS -->
	
<style type="text/css">
.leaflet-pane{z-index:0;}
</style>	
<script>
var map, markers;
var markersx=null;

L.Control.textbox = L.Control.extend({
		onAdd: function(map) {
			
		var text = L.DomUtil.create('div');
		text.id = "text_legend";
		text.innerHTML = '<div style="background: white; color: black; padding:10px; border: 1px solid black">'+
							'<img src="img/0.png" style="width:20px; height:20px;"> : Gangguan <br />'+
							'<img src="img/1.png" style="width:20px; height:20px;"> : Solved'+
						'</div>';
		return text;
		},

		onRemove: function(map) {
			// Nothing to do here
		}
	});


$(document).ready(function(){
	map = L.map('leafletMap').setView([-2,118], 5);

	var osm = L.tileLayer("http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",{
		attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
		}),
	Esri_WorldStreetMap = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
		attribution: 'Tiles &copy; Esri &mdash; Source: Esri, DeLorme, NAVTEQ, USGS, Intermap, iPC, NRCAN, Esri Japan, METI, Esri China (Hong Kong), Esri (Thailand), TomTom, 2012'
	}),
	OpenTopoMap = L.tileLayer('https://{s}.tile.opentopomap.org/{z}/{x}/{y}.png', {
		maxZoom: 17,
		attribution: 'Map data: &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, <a href="http://viewfinderpanoramas.org">SRTM</a> | Map style: &copy; <a href="https://opentopomap.org">OpenTopoMap</a> (<a href="https://creativecommons.org/licenses/by-sa/3.0/">CC-BY-SA</a>)'
	}),
	Stadia_OSMBright = L.tileLayer('https://tiles.stadiamaps.com/tiles/osm_bright/{z}/{x}/{y}{r}.{ext}', {
		minZoom: 0,
		maxZoom: 20,
		attribution: '&copy; <a href="https://www.stadiamaps.com/" target="_blank">Stadia Maps</a> &copy; <a href="https://openmaptiles.org/" target="_blank">OpenMapTiles</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
		ext: 'png'
	}),
	Stadia_StamenTerrain = L.tileLayer('https://tiles.stadiamaps.com/tiles/stamen_terrain/{z}/{x}/{y}{r}.{ext}', {
		minZoom: 0,
		maxZoom: 18,
		attribution: '&copy; <a href="https://www.stadiamaps.com/" target="_blank">Stadia Maps</a> &copy; <a href="https://www.stamen.com/" target="_blank">Stamen Design</a> &copy; <a href="https://openmaptiles.org/" target="_blank">OpenMapTiles</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
		ext: 'png'
	}),
		Esri_WorldImagery = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
		attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
		}),
	Stadia_AlidadeSmoothDark = L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}{r}.png', {
		maxZoom: 20,
		attribution: '&copy; <a href="https://stadiamaps.com/">Stadia Maps</a>, &copy; <a href="https://openmaptiles.org/">OpenMapTiles</a> &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors'
		}),
	NASAGIBS_ViirsEarthAtNight2012 = L.tileLayer('https://map1.vis.earthdata.nasa.gov/wmts-webmerc/VIIRS_CityLights_2012/default/{time}/{tilematrixset}{maxZoom}/{z}/{y}/{x}.{format}', {
		attribution: 'Imagery provided by services from the Global Imagery Browse Services (GIBS), operated by the NASA/GSFC/Earth Science Data and Information System (<a href="https://earthdata.nasa.gov">ESDIS</a>) with funding provided by NASA/HQ.',
		bounds: [[-85.0511287776, -179.999999975], [85.0511287776, 179.999999975]],
		minZoom: 1,
		maxZoom: 8,
		format: 'jpg',
		time: '',
		tilematrixset: 'GoogleMapsCompatible_Level'
		}),
	CyclOSM = L.tileLayer('https://{s}.tile-cyclosm.openstreetmap.fr/cyclosm/{z}/{x}/{y}.png', {
			maxZoom: 20,
			attribution: '<a href="https://github.com/cyclosm/cyclosm-cartocss-style/releases" title="CyclOSM - Open Bicycle render">CyclOSM</a> | Map data: &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
		}),
	Esri_NatGeoWorldMap = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/NatGeo_World_Map/MapServer/tile/{z}/{y}/{x}', {
		attribution: 'Tiles &copy; Esri &mdash; National Geographic, Esri, DeLorme, NAVTEQ, UNEP-WCMC, USGS, NASA, ESA, METI, NRCAN, GEBCO, NOAA, iPC',
		maxZoom: 16
	});

	var baseMaps = {
		"OpenStreetMap": osm,
		"OpenTopoMap": OpenTopoMap,
		"EsriWorldStreetMap": Esri_WorldStreetMap,
		"StadiaOSMBright": Stadia_OSMBright,
		"StadiaStamenTerrain": Stadia_StamenTerrain,
		"EsriWorldImagery": Esri_WorldImagery,
		"StadiaAlidadeSmoothDark": Stadia_AlidadeSmoothDark,
		"NASAGIBSViirsEarthAtNight2012": NASAGIBS_ViirsEarthAtNight2012,
		"CyclOSM": CyclOSM,
		"EsriNatGeoWorldMap": Esri_NatGeoWorldMap
	};

	var overlays =  {//add any overlays here

		};

	L.control.layers(baseMaps,overlays, {position: 'bottomleft'}).addTo(map);
	
	L.control.textbox = function(opts) { return new L.Control.textbox(opts);}
	L.control.textbox({ position: 'topright' }).addTo(map);

	/*L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
	attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
	}).addTo(map);*/
	Esri_WorldImagery.addTo(map);
	
	loadMarker();
});

function loadMarker(){
	markers=L.layerGroup();
	$.ajax({
		type: 'POST',
		url: 'datajson.php',
		data: {q:'mapv',id:'0'},
		success: function(datax){
			var data=JSON.parse(datax);
			for(var i=0;i<data.length;i++){
				var popup = data[i]['popup'];
				var ico = data[i]['icon'];
				if(ico=="0"){
					var icon = L.icon({iconUrl:'img/'+ico+'.png',iconSize:[30,30],iconAnchor:[15,30]});
				}else{
					var icon = L.icon({iconUrl:'img/'+ico+'.png',iconSize:[34,34],iconAnchor:[17,34]});
				}
				L.marker(new L.LatLng(data[i]['lat'],data[i]['lng']), { icon: icon }).bindPopup(popup).addTo(markers);
				//L.marker(new L.LatLng(data[i]['lat'],data[i]['lng']), {}).addTo(map).bindPopup(popup);
				
			}
			markers.addTo(map);
			setTimeout(reloadMap,60*1000);
		},
		error: function(xhr){
			console.log(xhr);
			if(markersx!=null) {
				markers=markersx;
				markers.addTo(map);
			}
			
			setTimeout(reloadMap,60*1000);
		}
	});
	countToday();
	//countAging();
}
function countToday(){
	$("#30days_new").html('0'); $("#30days_open").html('0'); $("#30days_progress").html('0'); $("#30days_solved").html('0'); 
	$("#30days_total").html('0'); 
	$.ajax({
		type: 'POST',
		url: 'datajson.php',
		data: {q:'todays',id:'0'},
		success: function(datax){
			var data=JSON.parse(datax);
			var tot=0;
			var newopen=0;
			for(var i=0;i<data.length;i++){
				$("#30days_"+data[i]['s']).html(data[i]['c']);
				//newopen+=(data[i]['s']=='new'||data[i]['s']=='open')?parseInt(data[i]['c']):0;
				tot+=parseInt(data[i]['c']);
			}
			$("#30days_total").html(tot);
			$("#newopen").html(newopen);
		},
		error: function(xhr){
			console.log(xhr);
		}
	});
}
function countAging(){
	$("#2hr").html('0'); $("#4hr").html('0'); $("#6hr").html('0'); $("#8hr").html('0'); $("#9hr").html('0'); $("#24hr").html('0'); 
	$.ajax({
		type: 'POST',
		url: 'datajson.php',
		data: {q:'agings',id:'0'},
		success: function(datax){
			var data=JSON.parse(datax);
			var hr2=0; var hr4=0; var hr6=0; var hr8=0; var hr9=0; var hr24=0; var jam=60;
			for(var i=0;i<data.length;i++){
				if(parseInt(data[i]['a'])>=(24*jam)){
					hr24+=parseInt(data[i]['c']);
				}else if(parseInt(data[i]['a'])>=(12*jam)){
					hr9+=parseInt(data[i]['c']);
				}else if(parseInt(data[i]['a'])>=(8*jam)){
					hr8+=parseInt(data[i]['c']);
				}else if(parseInt(data[i]['a'])>=(6*jam)){
					hr6+=parseInt(data[i]['c']);
				}else if(parseInt(data[i]['a'])>=(4*jam)){
					hr4+=parseInt(data[i]['c']);
				}else if(parseInt(data[i]['a'])>=(2*jam)){
					hr2+=parseInt(data[i]['c']);
				}
			}
			$("#2hr").html(hr2); $("#4hr").html(hr4); $("#6hr").html(hr6); $("#8hr").html(hr8); $("#9hr").html(hr9); $("#24hr").html(hr24); 
		},
		error: function(xhr){
			console.log(xhr);
		}
	});
}
function reloadMap(){
	markersx=markers;
	map.removeLayer(markers);
	loadMarker();
}
</script>
    </body>
</html>

