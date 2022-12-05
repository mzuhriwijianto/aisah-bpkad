@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/logacts') }}">Logact</a> :
@endsection
@section("contentheader_description", $logact->$view_col)
@section("section", "Logacts")
@section("section_url", url(config('laraadmin.adminRoute') . '/logacts'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Logacts Edit : ".$logact->$view_col)

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
				{!! Form::model($logact, ['route' => [config('laraadmin.adminRoute') . '.logacts.update', $logact->id ], 'method'=>'PUT', 'id' => 'logact-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'username')
					@la_input($module, 'menuname')
					@la_input($module, 'act')
					@la_input($module, 'idpemda')
					@la_input($module, 'no_reg')
					@la_input($module, 'tgl_perolehan')
					@la_input($module, 'harga')
					@la_input($module, 'luas')
					@la_input($module, 'koordx')
					@la_input($module, 'koordy')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <a href="{{ url(config('laraadmin.adminRoute') . '/logacts') }}" class="btn btn-default pull-right">Cancel</a>
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
	$("#logact-edit-form").validate({
		
	});
});
</script>
@endpush
