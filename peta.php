<?php 
include "inc.db.php";
$conn=connect();
$rs=fetch_all(exec_qry($conn,"select distinct lnk from tm_outlets where lnk<>''"));
$svcs="";
for($i=0;$i<count($rs);$i++){
	$svcs.='<option value="'.$rs[$i][0].'">'.$rs[$i][0].'</option>';
}
disconnect($conn);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Lokasi Pegadaian</title>
	<meta charset="utf-8" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
    <link rel="stylesheet" type="text/css" id="theme" href="css/theme-blue.css"/>
    
	<script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
	<link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch@3.1.0/dist/geosearch.css"/>
	<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />

	
	<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
	<script src="https://unpkg.com/leaflet-geosearch@3.1.0/dist/bundle.min.js"></script>
	<script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>
<style type="text/css">
html, body {
  height: 100%;
}
.fa {
	color: white;
}
.input-group{
	max-width: 200px;
}
</style>
</head>
<body>
&nbsp;
	<div id="map" style="position: absolute; top: 0px; left: 0; width: 100%; height: 100%;"></div>
&nbsp;
<script>
L.Control.textbox = L.Control.extend({
		onAdd: function(map) {
			
		var text = L.DomUtil.create('div');
		text.id = "search_text";
		text.innerHTML = '<div>'+
							'<select id="svcs" class="form-control">'+
							'<option value="">All Services</option>'+
							'<?php echo str_ireplace("'",'"',$svcs)?>'+
							'</select>'+
							'<select id="phase" class="form-control">'+
							'<option value="">SDWAN All Phase</option>'+
							'<option value="phase 1">SDWAN Phase 1</option>'+
							'<option value="phase 2">SDWAN Phase 2</option>'+
							'<option value="phase 3">SDWAN Phase 3</option>'+
							'</select>'+
						'<div class="input-group">'+
							'<input id="srctxt" type="text" onClick="this.select();" onkeydown="keydown(event);" class="form-control" placeholder="ID/Name">'+
							'<span class="input-group-addon add-on"><a title="Search" href="#" onclick="loadMarker();"><span class="fa fa-search"></span></a></span>'+
							'<span class="input-group-addon add-on"><a title="Center" href="#" onclick="gohome();"><span class="fa fa-crosshairs"></span></a></span>'+
						'</div></div>';
		return text;
		},

		onRemove: function(map) {
			// Nothing to do here
		}
	});
	
var map, markers;
$(document).ready(function(){
	map = L.map('map').setView([-2,118], 5);
	
	var osm = L.tileLayer("http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",{
		attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
		}),
	Esri_WorldStreetMap = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
		attribution: 'Tiles &copy; Esri &mdash; Source: Esri, DeLorme, NAVTEQ, USGS, Intermap, iPC, NRCAN, Esri Japan, METI, Esri China (Hong Kong), Esri (Thailand), TomTom, 2012'
	}),
	Stamen_TonerLite = L.tileLayer('https://stamen-tiles-{s}.a.ssl.fastly.net/toner-lite/{z}/{x}/{y}{r}.{ext}', {
		attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
		subdomains: 'abcd',
		minZoom: 0,
		maxZoom: 20,
		ext: 'png'
		}),
	Stamen_Terrain = L.tileLayer('https://stamen-tiles-{s}.a.ssl.fastly.net/terrain/{z}/{x}/{y}{r}.{ext}', {
		attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
		subdomains: 'abcd',
		minZoom: 0,
		maxZoom: 18,
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
		"EsriWorldStreetMap": Esri_WorldStreetMap,
		"StamenTonerLight": Stamen_TonerLite,
		"StamenTerrain": Stamen_Terrain,
		"EsriWorldImagery": Esri_WorldImagery,
		"StadiaAlidadeSmoothDark": Stadia_AlidadeSmoothDark,
		"NASAGIBSViirsEarthAtNight2012": NASAGIBS_ViirsEarthAtNight2012,
		"CyclOSM": CyclOSM,
		"EsriNatGeoWorldMap": Esri_NatGeoWorldMap
	};

	var overlays =  {//add any overlays here

		};

	L.control.layers(baseMaps,overlays, {position: 'bottomleft'}).addTo(map);
	
	/*L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
	attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
	}).addTo(map);
	*/
	osm.addTo(map);
	
	L.control.textbox = function(opts) { return new L.Control.textbox(opts);}
	L.control.textbox({ position: 'topright' }).addTo(map);
	markers=null;
	loadMarker();
})

function keydown(e){
	var keycode = (e.keyCode ? e.keyCode : e.which);
	if (keycode == '13' || keycode == '9') {
		loadMarker();
	}
}
function gohome(){
	map.setView([-2,118], 5);
}
function loadMarker(){
	gohome();
	if(markers!=null)  {
		map.removeLayer(markers);
		markers.clearLayers();
	}
	markers=L.markerClusterGroup();
	var err='';
	$.ajax({
		type: 'POST',
		url: 'datajson.php',
		data: {q:'mapl',id:$("#srctxt").val(),idx:$("#phase").val(),idx2:$("#svcs").val()},
		success: function(datax){
			var data=JSON.parse(datax);
			for(var i=0;i<data.length;i++){
				var popup = data[i]['popup'];
				//var ico = data[i]['icon'];
				//if(ico=="0"){
					var icon = L.icon({iconUrl:'img/p2.png',iconSize:[30,30],iconAnchor:[15,30]});
				//}else{
				//	var icon = L.icon({iconUrl:'img/'+ico+'.png',iconSize:[34,34],iconAnchor:[17,34]});
				//}
				if(isNaN(data[i]['lat'])||isNaN(data[i]['lng'])){
					err+=data[i]['popup']+'/';
				}else{
					L.marker(new L.LatLng(data[i]['lat'],data[i]['lng']), { icon:icon }).bindPopup(popup).addTo(markers);
					//L.marker(new L.LatLng(data[i]['lat'],data[i]['lng']), {}).addTo(map).bindPopup(popup);
				}
			}
			markers.addTo(map);
			if(err!='') {
				alert('Error: '+err);
			}
		},
		error: function(xhr){
			console.log(xhr);
		}
	});
}
</script>
</body>
</html>
