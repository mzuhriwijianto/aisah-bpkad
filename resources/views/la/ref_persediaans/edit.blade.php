@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/ref_persediaans') }}">Ref persediaan</a> :
@endsection
@section("contentheader_description", $ref_persediaan->$view_col)
@section("section", "Ref persediaans")
@section("section_url", url(config('laraadmin.adminRoute') . '/ref_persediaans'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Ref persediaans Edit : ".$ref_persediaan->$view_col)

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
				{!! Form::model($ref_persediaan, ['route' => [config('laraadmin.adminRoute') . '.ref_persediaans.update', $ref_persediaan->id ], 'method'=>'PUT', 'id' => 'ref_persediaan-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'jenis_persediaan')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/ref_persediaans') }}">Cancel</a></button>
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
	$("#ref_persediaan-edit-form").validate({
		
	});
});
</script>
@endpush
