@extends('la.layouts.app')

@section('htmlheader_title')
	Storage View
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

		<div class="col-md-1 actions">
			@la_access("Storages", "edit")
				<a href="{{ url(config('laraadmin.adminRoute') . '/storages/'.$storage->id.'/edit') }}" class="btn btn-xs btn-edit btn-default"><i class="fa fa-pencil"></i></a><br>
			@endla_access
			@la_access("Storages", "delete")
				{{ Form::open(['route' => [config('laraadmin.adminRoute') . '.storages.destroy', $storage->id], 'method' => 'delete', 'style'=>'display:inline']) }}
					<button class="btn btn-default btn-delete btn-xs" type="submit"><i class="fa fa-times"></i></button>
				{{ Form::close() }}
			@endla_access
		</div>
	</div>

	<ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
		<li class=""><a href="{{ url(config('laraadmin.adminRoute') . '/storages') }}" data-toggle="tooltip" data-placement="right" title="Back to Storages"><i class="fa fa-chevron-left"></i></a></li>
		<li class="active"><a role="tab" data-toggle="tab" class="active" href="#tab-general-info" data-target="#tab-info"><i class="fa fa-bars"></i> General Info</a></li>
		<!-- <li class=""><a role="tab" data-toggle="tab" href="#tab-timeline" data-target="#tab-timeline"><i class="fa fa-clock-o"></i> Timeline</a></li>-->
	</ul>

	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active fade in" id="tab-info">
			<div class="tab-content">
				<div class="panel infolist">
					<div class="panel-default panel-heading">
						<h4>General Info</h4>
					</div>
					<div class="panel-body">
						@la_display($module, 'storage_code')
						@la_display($module, 'storage_name')
					</div>
				</div>
			</div>
			<div class="panel-body">
					<div class="box box-success">
						<div class="box-body">
							<table id="example4" class="table table-bordered table-striped">
							<thead>
							<tr class="success">
								<th>Storage Name</th>
								<th>Rack Name</th>
								<th>Count Rack</th>
								<th>Count Item</th>
							</tr>
							</thead>
							<tbody>
							@foreach($storagerack as $storageracks)
							<tr >
								<td>{{ $storageracks->storage_name }}</td>
								<td>{{ $storageracks->rack_name }}</td>
								<td class = "rack">{{ $storageracks->Count_racks }}</td>
								<td class = "rack">{{ $storageracks->Count_item }}</td>
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
