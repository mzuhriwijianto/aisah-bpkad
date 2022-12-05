@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/racks') }}">Racks</a> :
@endsection
@section("contentheader_description", $kendaraan->$view_col_kendaraan)
@section("section", "Racks")
@section("section_url", url(config('laraadmin.adminRoute') . '/racks'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Inventory Edit : ".$kendaraan->$view_col_kendaraan)

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

<div class="box">
	<div class="box-header">
		
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
			<form method="POST" action="/admin/updatekendaraan/{{ $kendaraan->id }}" accept-charset="UTF-8" id="kendaraan-edit-form" novalidate="novalidate">
			<input name="_method" type="hidden" value="PUT">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			
					
			{{-- Form::model($kendaraan, ['route' => [config('laraadmin.adminRoute') . '.kendaraans.update', $kendaraan->id ], 'method'=>'PUT', 'id' => 'kendaraan-edit-form']) --}}
				{{-- Form::model($kendaraan, ['route' => [config('laraadmin.adminRoute') . '.racks.updatekendaraan', $kendaraan->id ], 'method'=>'PUT', 'id' => 'kendaraan-edit-form']) --}}
					{{--@la_form($module)--}}
					
					{{--
					@la_input($module, 'idpemda')
					@la_input($module, 'merk')
					@la_input($module, 'type')
					@la_input($module, 'cc')
					@la_input($module, 'tgl_perolehan')
					@la_input($module, 'no_rangka')
					@la_input($module, 'no_mesin')
					@la_input($module, 'nomor_polisi')
					@la_input($module, 'nomor_bpkb')
					@la_input($module, 'storage_no')
					--}}
					@la_input($module, 'bpkb_file')
					@la_input($module, 'stnk_file')
					@la_input($module, 'photo')
					@la_input($module, 'rack_no')
					
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <a href="{{ url(config('laraadmin.adminRoute') . '/racks#lists') }}" class="btn btn-default pull-right">Cancel</a>
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
	$("#kendaraan-edit-form").validate({
		
	});
});
</script>
@endpush
