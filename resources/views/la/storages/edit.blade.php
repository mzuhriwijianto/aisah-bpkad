@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/storages') }}">Storage</a> :
@endsection
@section("contentheader_description", $storage->$view_col)
@section("section", "Storages")
@section("section_url", url(config('laraadmin.adminRoute') . '/storages'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Storages Edit : ".$storage->$view_col)

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
				{!! Form::model($storage, ['route' => [config('laraadmin.adminRoute') . '.storages.update', $storage->id ], 'method'=>'PUT', 'id' => 'storage-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'storage_code')
					@la_input($module, 'storage_name')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <a href="{{ url(config('laraadmin.adminRoute') . '/storages') }}" class="btn btn-default pull-right">Cancel</a>
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
	$("#storage-edit-form").validate({
		
	});
});
</script>
@endpush
