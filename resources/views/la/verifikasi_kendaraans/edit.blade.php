@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/verifikasi_kendaraans') }}">Verifikasi kendaraan</a> :
@endsection
@section("contentheader_description", $verifikasi_kendaraan->$view_col)
@section("section", "Verifikasi kendaraans")
@section("section_url", url(config('laraadmin.adminRoute') . '/verifikasi_kendaraans'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Verifikasi kendaraans Edit : ".$verifikasi_kendaraan->$view_col)

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
				{!! Form::model($verifikasi_kendaraan, ['route' => [config('laraadmin.adminRoute') . '.verifikasi_kendaraans.update', $verifikasi_kendaraan->id ], 'method'=>'PUT', 'id' => 'verifikasi_kendaraan-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'idpemda')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/verifikasi_kendaraans') }}">Cancel</a></button>
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
	$("#verifikasi_kendaraan-edit-form").validate({
		
	});
});
</script>
@endpush
