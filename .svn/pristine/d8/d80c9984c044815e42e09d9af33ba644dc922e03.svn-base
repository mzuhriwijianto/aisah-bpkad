@extends('la.layouts.app')

@section('htmlheader_title')
	Verifikasi kendaraan View
@endsection


@section('main-content')
<div id="page-content" class="profile2">
	<div class="bg-primary clearfix">

		<div class="col-md-10">
			<div class="row">
				<div class="col-md-8">
					<div class="profile-icon text-primary">
						<i class="fa {{ $module->fa_icon }} fa-15x">Verifikasi {{ $module->name}}</i>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-1">
			<div class="dats1"><span class="bg-blue">User</span>
			<div class="label2">{{ Auth::user()->name }}</div></div>
			<div class="dats1"><span class="bg-blue">From</span>
				<div class="label2">
					 {{ Module::userlogin()->dept_name }}</div>
				</div>
		</div>

		<div class="col-sm-1 actions rightPane">
			@la_access("Kendaraans", "edit")
				<a href="{{ url(config('laraadmin.adminRoute') . '/kendaraans/'.$kendaraan->id.'/edit') }}" class="btn btn-xs btn-edit btn-default"><i class="fa fa-pencil"></i></a><br>
			@endla_access
			
			@la_access("Kendaraans", "delete")
				{{ Form::open(['route' => [config('laraadmin.adminRoute') . '.kendaraans.destroy', $kendaraan->id], 'method' => 'delete', 'style'=>'display:inline']) }}
					<button class="btn btn-default btn-delete btn-xs" type="submit"><i class="fa fa-times"></i></button>
				{{ Form::close() }}
			@endla_access
		</div>
	</div>

	<ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
		<li class=""><a href="{{ url(config('laraadmin.adminRoute') . '/kendaraans#lists') }}" data-toggle="tooltip" data-placement="right" title="Back to Kendaraan"><i class="fa fa-chevron-left"></i></a></li>
		<li class="active"><a role="tab" data-toggle="tab" class="active" href="#tab-general-info" data-target="#tab-info"><i class="fa fa-bars"></i> General Info</a></li>
	</ul>

	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active fade in" id="tab-info">
			<div class="tab-content">
				<div class="panel infolist">
					<ul class="timeline timeline-inverse">
						<!-- timeline time label -->
						<li>
							<i class="fa fa-clock-o bg-gray"></i>
						</li>
						<br/>		
						<!-- /.timeline-label -->
						<!-- timeline item -->
						<li>
						<i class="fa fa-user bg-blue"></i>
						<div class="timeline-item">
							<span class="time"><i class="fa fa-clock-o"></i> {{ $kendaraans[0]->updated_at }}</span>
							<h3 class="timeline-header"><a href="#">{{ $kendaraans[0]->update_by }}</a> Has update this data</h3>
						</div>
						</li>
						<!-- END timeline item -->

						<!-- timeline item -->
						<li>
						<i class="fa fa-file bg-yellow"></i>

						<div class="timeline-item">
							<div class="timeline-body">
							  <h3> Pemegang Kendaraan: </h3> <h4> {{ $kendaraans[0]->owner }}</h4>
							  <h3> Tgl Perolehan: </h3> <h4> {{ date('d-m-Y', strtotime($kendaraans[0]->tgl_perolehan)) }}</h4>
							  <h3> Nomor Polisi: </h3> <h4> {{ $kendaraans[0]->nomor_polisi }}</h4>
							  <h3> Nomor BPKB: </h3> <h4> {{ $kendaraans[0]->nomor_bpkb }}</h4> 
							  <h3> Merk: </h3> <h4> {{ $kendaraans[0]->merk }}</h4>
							  <h3> Type: </h3> <h4> {{ $kendaraans[0]->type }}</h4>
							  <h3> CC: </h3> <h4> {{ $kendaraans[0]->cc }}</h4>
							  <h3> Bahan: </h3> <h4> {{ $kendaraans[0]->bahan }}</h4>
							  <h3> No Rangka: </h3> <h4>{{ $kendaraans[0]->nomor_rangka }}</h4> 
							  <h3> No Mesin: </h3> <h4>{{ $kendaraans[0]->nomor_mesin }}</h4> 
							  <h3> Kondisi: </h3> <h4>{{ $kendaraans[0]->kondisi }}</h4> 
							</div>
			

						</div>
						</li>
						<!-- END timeline item -->

						<!-- timeline item -->
						<li>
						<i class="fa fa-file bg-purple"></i>

						<div class="timeline-item">
							<h3 class="timeline-header"><a href="#">Document</a></span></h3>
							<div class="timeline-body">
								<div class="panel-body">
									@la_display($module, 'bpkb_file')
									@la_display($module, 'stnk_file')
									@la_display($module, 'photo')
								</div>
							</div>
						</div>
						</li>
						<!-- END timeline item -->
						<li>
						<i class="fa fa-clock-o bg-gray"></i>
						</li>
					</ul>
				</div>
			</div>
		</div>
		
	</div>
	</div>
	</div>
</div>
@endsection