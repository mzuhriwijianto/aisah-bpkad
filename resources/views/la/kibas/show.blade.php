@extends('la.layouts.app')

@section('htmlheader_title')
	Kiba View
@endsection


@section('main-content')
<script src='https://api.mapbox.com/mapbox-gl-js/v2.0.0/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.0.0/mapbox-gl.css' rel='stylesheet' />

<div id="page-content" class="profile2">
	<div class="bg-primary clearfix">
		<div class="col-md-2">
			<div class="row">
				<div class="col-md-4">
					<div class="profile-icon text-primary">
						<i class="fa {{ $module->fa_icon }} fa-15x">Tanah</i>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="dats1"><span class="bg-blue">User</span>
			<div class="label2">{{ Auth::user()->name }}</div></div>
			<div class="dats1"><span class="bg-blue">From</span>
				<div class="label2">
					 {{ Module::userlogin()->dept_name }}</div>
				</div>
		</div>
		
		<div class="col-md-1 actions">
			@la_access("Kibas", "edit")
				<a href="{{ url(config('laraadmin.adminRoute') . '/kibas/'.$kiba->id.'/edit') }}" class="btn btn-xs btn-edit btn-default"><i class="fa fa-pencil"></i></a><br>
			@endla_access
		</div>
	</div>

	<ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
		<li class=""><a href="{{ url(config('laraadmin.adminRoute') . '/kibas') }}" data-toggle="tooltip" data-placement="right" title="Back to Kibas"><i class="fa fa-chevron-left"></i></a></li>
		<li class="active"><a role="tab" data-toggle="tab" class="active" href="#tab-general-info" data-target="#tab-info"><i class="fa fa-bars"></i> General Info</a></li>
		<li class=""><a role="tab" data-toggle="tab" href="#tab-timeline" data-target="#tab-timeline"><i class="fa fa-clock-o"></i> Timeline</a></li>
	</ul>

	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active fade in" id="tab-info">
			<div class="tab-content">
				<div class="panel infolist">
					<div class="panel-default panel-heading">
						<h4>General Info</h4>
					</div>
					<div class="panel-body">
						@la_display($module, 'idpemda')
						@la_display($module, 'sertifikat_an')
						@la_display($module, 'geo')
						@la_display($module, 'sert_file')
						@la_display($module, 'photo_tanah')
					</div>
					<div class="panel-body">
						<div id ="mapid" style = " height: 800px; "></div>
					</div>
				</div>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="tab-timeline">
			<!--<div class="text-center p30"><i class="fa fa-list-alt" style="font-size: 100px;"></i> <br> No posts to show</div>-->
		</div>
		
	</div>
	</div>
	</div>
</div>
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
	zoom: 250,
	attributionControl: false
});

		
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
@endsection
