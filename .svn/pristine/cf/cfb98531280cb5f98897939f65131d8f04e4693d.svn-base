@extends('la.layouts.app')

@section('htmlheader_title')
	Rack View
@endsection


@section('main-content')
<div id="page-content" class="profile2">
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
		<div class="col-md-2 actions">
			@la_access("Racks", "edit")
				<a href="{{ url(config('laraadmin.adminRoute') . '/racks/'.$rack->id.'/edit') }}" class="btn btn-xs btn-edit btn-default"><i class="fa fa-pencil"></i></a><br>
			@endla_access
			
			@la_access("Racks", "delete")
				{{ Form::open(['route' => [config('laraadmin.adminRoute') . '.racks.destroy', $rack->id], 'method' => 'delete', 'style'=>'display:inline']) }}
					<button class="btn btn-default btn-delete btn-xs" type="submit"><i class="fa fa-times"></i></button>
				{{ Form::close() }}
			@endla_access
		</div>
	</div>

	<ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
		<li class=""><a href="{{ url(config('laraadmin.adminRoute') . '/racks') }}" data-toggle="tooltip" data-placement="right" title="Back to Racks"><i class="fa fa-chevron-left"></i></a></li>
		<li class="active"><a role="tab" data-toggle="tab" class="active" href="#tab-general-info" data-target="#tab-info"><i class="fa fa-bars"></i> General Info</a></li>
		<!--<li class=""><a role="tab" data-toggle="tab" href="#tab-timeline" data-target="#tab-timeline"><i class="fa fa-clock-o"></i> List</a></li>-->
	</ul>

	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active fade in" id="tab-info">
			<div class="tab-content">
				<div class="panel infolist">
					<div class="panel-default panel-heading">
						<h4>General Info</h4>
					</div>
					<div class="panel-body">
						@la_display($module, 'rack_code')
						@la_display($module, 'rack_name')
						@la_display($module, 'storage')
					</div>
				</div>
			</div>
			<div class="tab-content">
				<div class="panel infolist">
					<div class="panel-default panel-heading">
						<h4>List</h4>
					</div>
					<div class="panel-body">
						<table id="example2" class="table table-hover">
					<thead>
					<tr class="success">
						<th>IDPemda</th>
						<th>No Pol</th>
						<th>Merk</th>
						<th>Type</th>
						<th>cc</th>
						<th>Nomor_rangka</th>
						<th>Nomor_Mesin</th>
					</tr>
					</thead>
					<tbody>
					@foreach($daftar as $daftars)
					<tr>
						<td>{{ $daftars->idpemda }}</td>
						<td>{{ $daftars->nomor_polisi }}</td>
						<td>{{ $daftars->merk }}</td>
						<td>{{ $daftars->type }}</td>
						<td>{{ $daftars->cc }}</td>
						<td>{{ $daftars->nomor_rangka }}</td>
						<td>{{ $daftars->nomor_mesin }}</td>
					</tr>		
					@endforeach
					</tbody>
				</table>
					</div>
				</div>
			</div>
		</div>

		
	</div>
	</div>
	</div>
</div>
@endsection
