@extends("la.layouts.app")

@section("contentheader_title")
<a href="{{ url(config('laraadmin.adminRoute') . '/kibc_s') }}">Gedung & Bangunan</a> :
@endsection
@section("contentheader_description", $kibc_s->$view_col)
@section("section", "Kibc_s")
@section("section_url", url(config('laraadmin.adminRoute') . '/kibc_s'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Kibc_s Edit : ".$kibc_s->$view_col)
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
<!-- mapbox -->


<script src="https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.js"></script>
<link href="https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.css" rel="stylesheet">


<script src="https://api.tiles.mapbox.com/mapbox.js/plugins/turf/v2.0.0/turf.min.js"></script>

<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.min.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.css" type="text/css">

<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js"></script>



<style>
.geocoder {
	position: absolute;
	z-index: 1;
	width: 50%;
	left: 50%;
	margin-left: -25%;
	top: 10px;
}
.mapboxgl-ctrl-geocoder {
	min-width: 100%;
}
#mymap {
	margin-top: 80px;
}
</style>

<div class="box">
	<div class="box-body">
	<div class="col-sm-3" style="border: #f2f2f2; border-width: 0.2px 0.2px 0px 3px; border-style: solid;">
			<form method="POST" action="/admin/kibc_s/{{$kibc_s->id}}" accept-charset="UTF-8" id="kibc_-edit-form">
				<input name="_method" type="hidden" value="PUT">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<div class="form-group"><label for="koordx">KoordX* :</label>
					<input id = "koordx" class="form-control" placeholder="Enter KoordX" data-rule-minlength="5" data-rule-maxlength="100" required="1" name="koordx" type="text" value="{{ $kibc_s->koordx }}" aria-invalid="false" readonly>
				</div>
				<div class="form-group"><label for="koordy">KoordY* :</label>
					<input id = "koordy" class="form-control" placeholder="Enter KoordY" data-rule-minlength="5" data-rule-maxlength="100" required="1" name="koordy" type="text" value="{{ $kibc_s->koordy }}" aria-invalid="false" readonly>
				</div>
				<div class="form-group"><label for="no_imb_lama">No. IMB Lama : </label>
					<input class="form-control" placeholder="Masukkan Nomor IMB Lama" data-rule-maxlength="200" name="no_imb_lama" type="text">
				</div>
				<div class="form-group"><label for="no_imb_baru">No. IMB Baru : </label>
					<input class="form-control" placeholder="Masukkan Nomor IMB Baru" data-rule-maxlength="200" name="no_imb_baru" type="text" >
				</div>
				<div class="form-group">
					<label for="tgl_awal_imb">Tgl Terbit IMB : </label>
					<div class="input-group date">
						<input class="form-control" placeholder="Enter Tanggal Terbit IMB" name="tgl_awal_imb" type="text">
						<span class="input-group-addon">
							<span class="fa fa-calendar"></span>
						</span>
					</div>
				</div>
				<div class="form-group">
					<label for="tgl_akhir_imb">Tgl Akhir IMB : </label>
					<div class="input-group date">
						<input class="form-control" placeholder="Enter Tanggal Akhir IMB" name="tgl_akhir_imb" type="text">
						<span class="input-group-addon">
							<span class="fa fa-calendar"></span>
						</span>
					</div>
				</div>
				<div class="form-group">
					{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!}<a href="{{ url(config('laraadmin.adminRoute') . '/kibc_s#listdatagedung') }}" class="btn btn-default pull-right">Cancel</a>
				</div>
			</div>
						<div class="col-md-9" style="border: #f2f2f2; border-width: 2px 1px 2px 1px; height: 500px; border-style: solid;" >
				<div class="panel-default">
					<label>Lokasi:</label>
				</div>
				<ul class="timeline timeline-inverse">
					<div class="embed-responsive" id ="mapboxdiv" bannerid="yyy" style="height: 450px;">	  
						<div id ="mapid" style="height: 500px;"></div>
						<script language="JavaScript" type="text/javascript">
//location
//convert to json
var marker = new mapboxgl.Marker();
var locgedung = {
	'type': 'geojson',
	'data': {
		'type': 'FeatureCollection',
		'features': [
		{
				// feature for Mapbox DC
				'type': 'Feature',
				'geometry': {
					'type': 'Point',
					'coordinates': [
					{{ $kibc_s->koordy }},{{ $kibc_s->koordx }}
					]
				},
				
				'properties': {
					'title': {{ $kibc_s->idpemdas}},
					'fillColor':'#669933',
					'icon': 'circle',
					'marker-color': '#44bcd8'
				}
			}
			]
		}
	};								  

//init	
var tengah = [111.88101108413372,-7.144900849286884];


mapboxgl.accessToken = 'pk.eyJ1IjoiaWhzYW4zNyIsImEiOiJja3E5OHZwZmMwMDF3MnZueGl4c2twYTZvIn0.OdTBZzAAicPMfeOo-dBylQ';

var mymap = new mapboxgl.Map({
	container: 'mapid',
	style: 'mapbox://styles/mapbox/satellite-streets-v11',
	//style: 'mapbox://styles/mapbox/outdoors-v11',
	//style: 'mapbox://styles/mapbox/satellite-v11',
	center: tengah,
	zoom: 16.8,
	attributionControl: false
});

//3d

mymap.on('load', () => {
        // Insert the layer beneath any symbol layer.
        const layers = mymap.getStyle().layers;
        const labelLayerId = layers.find(
            (layer) => layer.type === 'symbol' && layer.layout['text-field']
        ).id;

        // The 'building' layer in the Mapbox Streets
        // vector tileset contains building height data
        // from OpenStreetMap.
        mymap.addLayer(
            {
                'id': 'add-3d-buildings',
                'source': 'composite',
                'source-layer': 'building',
                'filter': ['==', 'extrude', 'true'],
                'type': 'fill-extrusion',
                'minzoom': 15,
                'paint': {
                    'fill-extrusion-color': '#aaa',

                    // Use an 'interpolate' expression to
                    // add a smooth transition effect to
                    // the buildings as the user zooms in.
                    'fill-extrusion-height': [
                        'interpolate',
                        ['linear'],
                        ['zoom'],
                        15,
                        0,
                        15.05,
                        ['get', 'height']
                    ],
                    'fill-extrusion-base': [
                        'interpolate',
                        ['linear'],
                        ['zoom'],
                        15,
                        0,
                        15.05,
                        ['get', 'min_height']
                    ],
                    'fill-extrusion-opacity': 0.6
                }
            },
            labelLayerId
        );
    });


//control
var geocoder = new MapboxGeocoder({
	accessToken: mapboxgl.accessToken,
	mapboxgl: mapboxgl

});
mymap.addControl(geocoder);
mymap.addControl(new mapboxgl.NavigationControl());
//end
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
),
setTimeout(function() {
    $(".mapboxgl-ctrl-geolocate").click();
},5000);

	//addpoint				
	mymap.on('click', function(e) {
		var popup = new mapboxgl.Popup()
		.setLngLat(e.lngLat)
		.setHTML("Lokasi Baru")
		.addTo(mymap);

		document.getElementById('koordx').value = e.lngLat.lat.toString();
		document.getElementById('koordy').value = e.lngLat.lng.toString();

	});			
//end

mymap.on('load', function() {
	
	mymap.addSource('points', locgedung);							
	mymap.addLayer({
		'id': 'points',
		'type': 'symbol',
		'source': 'points',
		'layout': {
				// get the icon name from the source's "icon" property
				// concatenate the name to get an icon from the style's sprite sheet
				'icon-image': ['concat', ['get', 'icon'], '-15'],
				// get the title name from the source's "title" property
				'text-field': ['get', 'title'],
				'text-font': ['Open Sans Semibold', 'Arial Unicode MS Bold'],
				'text-offset': [0, 0.6],
				'text-anchor': 'top'
			},
			'paint': {
				'icon-color': '#44bcd8',
				'icon-halo-color': '#44bcd8',
				'icon-halo-width': 2
			}
		});

});
//end
/* const popup = new mapboxgl.Popup({closeOnClick: false})
	.setLngLat({$kibc_s->koordy,$kibc_s->koordx})
	.setHTML({$kibc_s->keterangan})
	.addTo(map); */
</script>

</div>
</li>
</ul>
</div>
</form>
	</div>
</div>

@endsection

@push('scripts')
<script>
	$(function () {
		$("#kibc_-edit-form").validate({

		});
	});
</script>
@endpush