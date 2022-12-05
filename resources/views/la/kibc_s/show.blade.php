@extends('la.layouts.app')

@section('htmlheader_title')
	Detail Gedung dan Bangunan 
@endsection


<link href="https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.8.2/mapbox-gl.js"></script>



@section('main-content')
<div id="page-content" class="profile2">
	<div class="bg-primary clearfix">
		<div class="bg-primary clearfix">
		<div class="col-md-2">
			<div class="row">
				<div class="col-md-4">
					<div class="profile-icon text-primary">
						<i class="fa {{ $module->fa_icon }} fa-15x">{{ $module->name}}</i>
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
			@la_access("Kibc_s", "edit")
				<a href="{{ url(config('laraadmin.adminRoute') . '/kibc_s/'.$kibc_s->id.'/edit') }}" class="btn btn-xs btn-edit btn-default"><i class="fa fa-pencil"></i></a><br>
			@endla_access
			
			@la_access("Kibc_s", "delete")
				{{ Form::open(['route' => [config('laraadmin.adminRoute') . '.kibc_s.destroy', $kibc_s->id], 'method' => 'delete', 'style'=>'display:inline']) }}
					<button class="btn btn-default btn-delete btn-xs" type="submit"><i class="fa fa-times"></i></button>
				{{ Form::close() }}
			@endla_access
		</div>
	</div>
	</div>

	<ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
		<li class=""><a href="{{ url(config('laraadmin.adminRoute') . '/kibc_s') }}" data-toggle="tooltip" data-placement="right" title="Back to Kibcs"><i class="fa fa-chevron-left"></i></a></li>
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
						@la_display($module, 'idpemdas')
						@la_display($module, 'koordx')
						@la_display($module, 'koordy')
					<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="">	
						<ul class="timeline timeline-inverse">
							<li class="time-label">
								<span class="bg-blue">
									KAPITALISASI
								</span>
							</li>							
							<li>
								<div class="timeline-item">
									<table class="table table-striped" >
									<thead>
									  <tr>
										<th class="bg-blue">Tgl Perolehan</th>
										<th>Tgl Dokumen</th>
										<th>No Register</th>
										<th>No Dokumen</th>
										<th>Luas Lantai</th>
										<th>Masa Manfaat</th>      
										<th>Harga</th>								
										<th>Kondisi</th>								
										<th>Kd_Riwayat</th>								
									  </tr>
									</thead>
									<tbody>
									@foreach($valueskap as $valuess)
									<tr>
										<td>{{ $valuess->tgl_perolehan }} </td>
										<td>{{ $valuess->tgl_dokumen }} </td>
										<td>{{ $valuess->no_register }} </td>
										<td>{{ $valuess->no_dokumen }} </td>
										<td>{{ $valuess->luas_lantai }} </td>
										<td>{{ $valuess->masa_manfaat }} </td>
										<td>@currency($valuess->harga)</td>
										<td>{{ $valuess->kondisi }} </td>
										<td>{{ $valuess->Kd_Riwayat }} </td>
									</tr>
									@endforeach
									</tbody>
									</TABLE>
								</div>
							</li>
							
						</ul>						
					</div>
					<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="">	
						<ul class="timeline timeline-inverse">
							<li class="time-label">
								<span class="bg-orange">
									MUTASI
								</span>
							</li>							
							<li>
								<div class="timeline-item">
									<table class="table table-striped" >
									<thead>
									  <tr>
										<th class="bg-orange">Tgl Perolehan</th>
										<th>Tgl Dokumen</th>
										<th>No Register</th>
										<th>No Dokumen</th>
										<th>Luas Lantai</th>
										<th>Masa Manfaat</th>      
										<th>Harga</th>								
										<th>Kondisi</th>								
										<th>Kd_Riwayat</th>								
									  </tr>
									</thead>
									<tbody>
									@foreach($valuesmut as $valuesm)
									<tr>
										<td>{{ $valuesm->tgl_perolehan }} </td>
										<td>{{ $valuesm->tgl_dokumen }} </td>
										<td>{{ $valuesm->no_register }} </td>
										<td>{{ $valuesm->no_dokumen }} </td>
										<td>{{ $valuesm->luas_lantai }} </td>
										<td>{{ $valuesm->masa_manfaat }} </td>
										<td>@currency($valuesm->harga) </td>
										<td>{{ $valuesm->kondisi }} </td>
										<td>{{ $valuesm->Kd_Riwayat }} </td>
									</tr>
									@endforeach
									</tbody>
									</TABLE>
								</div>
							</li>
							
						</ul>						
					</div>
					<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="">	
						<ul class="timeline timeline-inverse">
							<li class="time-label">
								<span class="bg-green">
									PENYUSUTAN
								</span>
							</li>
							
							<li>
								<div class="timeline-item">
									<table class="table table-striped">
									<thead>
									  <tr>
										<th class="bg-green">Tahun</th>
										<th>Harga</th>
										<th>Nilai Susut 1</th>
										<th>Nilai Susut 2</th>
										<th>Akumulasi Susut</th>      																
										<th>Nilai Sisa</th>      																
										<th>Sisa Umur</th>      																
									  </tr>
									</thead>
									<tbody>
									@foreach($valuespeny as $valuessp)
									<tr>
										<td>{{ $valuessp->tahun }} </td>
										<td>@currency($valuessp->harga) </td>
										<td>@currency ($valuessp->nilai_susut1) </td>
										<td>@currency ($valuessp->nilai_susut2) </td>
										<td>@currency ($valuessp->akum_susut) </td>
										<td>@currency ($valuessp->nilai_sisa) </td>
										<td>{{ $valuessp->sisa_umur }} </td>
									</tr>
									@endforeach
									</tbody>
								</table>
								</div>
							</li>							
						</ul>						
					</div>
					</div>
				</div>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="tab-timeline">
			<div class="tab-content">
				<div class="panel infolist">
					<div class="panel-default panel-heading">
						<h4>Maps</h4>
					</div>
					<div class="panel-body">
					<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="tab-timeline">	
						<ul class="timeline timeline-inverse">
							<li class="time-label">
								<span class="bg-green">
									MAPS
								</span>
							</li>
							
							<li>
								<div class="timeline-item">
									<div class="embed-responsive embed-responsive-16by9">								  
									<style>
									 #marker{
										 background-image : url('/storage/imgkib/Image/'.$row->imgname');
										 background-size: cover;
										 width: 50px;
										 height: 50px;
										 border-radius: 50%;
										 cursor: pointer;
									 }
									 .mapboxgl-popup{
										 max-width: 200px;
									 }
									
									</style>
										<div id="map"></div>
										<script>
											mapboxgl.accesToken= 'pk.eyJ1IjoiaWhzYW4zNyIsImEiOiJja3E5OHZwZmMwMDF3MnZueGl4c2twYTZvIn0.OdTBZzAAicPMfeOo-dBylQ';
											const tengah=[111.88101108413372,-7.144900849286884];
											const map= new mapboxgl.map({
												container: 'map',
												style: 'mapbox://styles/mapbox/satellite-streets-v11',
												center: tengah,
												zoom: 18
											});
										</script>
									</div>
								</div>
							</li>							
						</ul>						
					</div>
					</div>
				</div>
			</div>
			
			
<!---->
			
<!---->			
		</div>		
		
	</div>
	</div>
	</div>
</div>
@endsection