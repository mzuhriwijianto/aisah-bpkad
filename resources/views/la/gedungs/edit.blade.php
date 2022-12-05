@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/gedungs') }}">Gedung</a> :
@endsection
@section("contentheader_description", $gedung->$view_col)
@section("section", "Gedungs")
@section("section_url", url(config('laraadmin.adminRoute') . '/gedungs'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Gedungs Edit : ".$gedung->$view_col)

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
				{!! Form::model($gedung, ['route' => [config('laraadmin.adminRoute') . '.gedungs.update', $gedung->id ], 'method'=>'PUT', 'id' => 'gedung-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'idpemda')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/gedungs') }}">Cancel</a></button>
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
	$("#gedung-edit-form").validate({
		
	});
});
</script>
@endpush
