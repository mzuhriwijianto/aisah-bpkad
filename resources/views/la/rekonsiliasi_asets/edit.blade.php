@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/rekonsiliasi_asets') }}">Rekonsiliasi aset</a> :
@endsection
@section("contentheader_description", $rekonsiliasi_aset->$view_col)
@section("section", "Rekonsiliasi asets")
@section("section_url", url(config('laraadmin.adminRoute') . '/rekonsiliasi_asets'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Rekonsiliasi asets Edit : ".$rekonsiliasi_aset->$view_col)

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
				{!! Form::model($rekonsiliasi_aset, ['route' => [config('laraadmin.adminRoute') . '.rekonsiliasi_asets.update', $rekonsiliasi_aset->id ], 'method'=>'PUT', 'id' => 'rekonsiliasi_aset-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'id_rek_aset')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/rekonsiliasi_asets') }}">Cancel</a></button>
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
	$("#rekonsiliasi_aset-edit-form").validate({
		
	});
});
</script>
@endpush
