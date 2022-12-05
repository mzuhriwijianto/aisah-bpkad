@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/kibas') }}">Tanah</a> :
@endsection
@section("contentheader_description", $kiba->$view_col)
@section("section", "Kibas")
@section("section_url", url(config('laraadmin.adminRoute') . '/kibas'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Kibas Edit : ".$kiba->$view_col)

@section("main-content")

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- mapbox -->
<!--<script src="https://api.mapbox.com/mapbox-gl-js/v1.9.1/mapbox-gl.js"></script>-->
<script src='https://api.mapbox.com/mapbox-gl-js/v2.0.0/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.0.0/mapbox-gl.css' rel='stylesheet' />

<!--<script src="https://api.tiles.mapbox.com/mapbox.js/plugins/turf/v2.0.0/turf.min.js"></script>-->

<script src="https://api.tiles.mapbox.com/mapbox.js/plugins/turf/v3.0.11/turf.min.js"></script>
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.2.0/mapbox-gl-draw.js"></script>
<link
rel="stylesheet"
href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.2.0/mapbox-gl-draw.css"
type="text/css"
/>

<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.4.2/mapbox-gl-geocoder.min.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.4.2/mapbox-gl-geocoder.css" type="text/css"/>
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js"></script>

<div class="box">
	<div class="box-header">
		
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-12">
			<div class="col-md-2">
				{!! Form::model($kiba, ['route' => [config('laraadmin.adminRoute') . '.kibas.update', $kiba->id ], 'method'=>'PUT', 'id' => 'kiba-edit-form']) !!}
					{{--@la_form($module) --}}				
					
					@la_input($module, 'sertifikat_an')
					@la_input($module, 'sert_file')
					@la_input($module, 'photo_tanah')
					@la_input($module, 'pemanfaatan')					
										
					<div class="form-group">
						<input class="form-control" placeholder="Enter idpemda" data-rule-maxlength="256" id = "idpemda" name="idpemda" type="hidden" value="{{$kiba->idpemda}}" readonly>
					</div>					 
					<form method="POST" action="/admin/kibas/{{ $kiba->id }}" accept-charset="UTF-8" id="kiba-edit-form" novalidate="novalidate">
					<input name="_method" type="hidden" value="PUT">
					<input name="_token" type="hidden" value="{{ csrf_token() }}">
						
					<div class="form-group">
						<label for="geo">Geografi :</label>						
						<input id = "geo" class="form-control valid" placeholder="Enter Geo" data-rule-maxlength="500" name="geo" type="text" value="{{ $kiba->geo }}" aria-invalid="false" readonly>															
						<div class="input-group-append">
							<br>
							<button class="btn btn-warning" type="button" onclick = "delgeo()">Clear Geo</button>
						</div>						
					</div>
																			
			</div>	
					
		<div class="col-md-10">
					
			<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="tab-timeline">																	  	
				<div id ="mapid" style = " height: 800px; "></div>
				<div class="calculation-box" style = " height: 75px; width: 150px; position: absolute; bottom: 120px; left: 10px; background-color: rgba(255, 255, 255, 0.9); padding: 15px; text-align: center; ">
				<p style = " font-family: 'Open Sans'; margin: 0; font-size: 13px;">Tandai Wilayah</p>
				<div id="calculated-area"></div>
				</div>
			</div>
<!--
edit-->										
<script language="JavaScript" type="text/javascript">

//convert to json
var loctanah = {
'type': 'geojson',
'data': {
		'type': 'Feature',
		'geometry': {
					'type': 'Polygon',
					'coordinates': [
								[
									{{ $kiba->geo }}
								]
							]
					}
		}
};
//end

//init	
var tengah = [111.88028062855591,-7.149526000599138];


mapboxgl.accessToken = 'pk.eyJ1IjoicHJhdG9tb2dpbGFuZyIsImEiOiJjazhvNXFva20xMTgwM2ZtaW9nb2h1a2gzIn0.5Xu4wSzifGPaMy5F-taUkA';
var mymap = new mapboxgl.Map({
	container: 'mapid',
	//style: 'mapbox://styles/mapbox/satellite-v9',
	style: 'mapbox://styles/mapbox/satellite-streets-v10',
	center: tengah,
	zoom: 15,
	attributionControl: false
});

//control
// init control
var draw = new MapboxDraw({
	displayControlsDefault: false,
	controls: {
				polygon: true,
				trash: true
				}
});
var geocoder = new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            mapboxgl: mapboxgl
        });
var nav = new mapboxgl.NavigationControl();
		
mymap.addControl(geocoder);
mymap.addControl(nav,'top-left');
mymap.addControl(draw);
mymap.addControl(
new mapboxgl.GeolocateControl({
positionOptions: {
enableHighAccuracy: true
},
// When active the map will receive updates to the device's location as it changes.
trackUserLocation: true,
// Draw an arrow next to the location dot to indicate which direction the device is heading.
showUserHeading: true
})
);

//draw


mymap.on('draw.create', updateArea);
//mymap.on('draw.delete', updateArea);
//mymap.on('draw.update', updateArea);
//document.getElementById('geo').value = '';
 
function updateArea(e) {
	
	var data = draw.getAll();
	var answer = document.getElementById('calculated-area');
	
	if (data.features.length > 0) {
	var area = turf.area(data);
	// restrict to area to 2 decimal points
	var rounded_area = Math.round(area * 100) / 100;
	            
	answer.innerHTML =
	'<p><strong>' +
	rounded_area +
	'</strong> M2 </p>';
	} else {
		answer.innerHTML = '';
		if (e.type !== 'draw.delete'){			
			alert('Perkiraan Luas' + area);			
		}
	}
}
//end

mymap.on('draw.delete', function(e) {
	document.getElementById('geo').value = '';
});
mymap.on('draw.update', function(e) { 
	document.getElementById('geo').value = '';
});

//set new location
mymap.on('click', function(e) {

			var coord = e.lngLat.lng +','+e.lngLat.lat;
			const arr = [];
			const geom = arr.push(coord);			
			geom;
			document.getElementById('geo').value += '['+ arr +']' + ',';						
			//console.log(arr);			
});

//end

//load save polygon
mymap.on('load', function() {
	mymap.addSource('tanahkab', loctanah );
	mymap.addLayer({
			'id': 'tanahkab',
			'type': 'fill',
			'source': 'tanahkab',
			'layout': {},
			'paint': {
					'fill-color': '#e942f5',
					'fill-opacity': 0.6
					}
			});
});
//end
;
	
 mymap.fitBounds([
 loctanah.data.geometry.coordinates[0][0],
 loctanah.data.geometry.coordinates[0][loctanah.data.geometry.coordinates[0].length-1],
 ],{ zoom: 17 });
 
 //mymap.flyTo({ center: e.features[0].geometry.coordinates });


</script>			

<!--
-->	
<br/>				
					<div class="col-md-2">
					<div class="form-group">
						{{-- Form::submit( 'Update', ['class'=>'btn btn-success']) --}} 
						<input class="btn btn-success" type="submit" value="Update" onclick = "dellastchar()">
						<button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/kibas') }}">Cancel</a></button>
					</div>
					</div>
				{!! Form::close() !!}
			</div>
			
		</div>
	</div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
	$("#kiba-edit-form").validate({
		
	});
});

function dellastchar(){
	var strng=document.getElementById("geo").value;
	document.getElementById("geo").value=strng.substring(0,strng.length-1)
	//alert(strng.substring(0,strng.length-1));
}

function delgeo(){
	document.getElementById("geo").value = '';
}
</script>
@endpush
