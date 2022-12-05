@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/racks') }}">Rack</a> :
@endsection
@section("contentheader_description", $rack->$view_col)
@section("section", "Racks")
@section("section_url", url(config('laraadmin.adminRoute') . '/racks'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Racks Edit : ".$rack->$view_col)

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
				{!! Form::model($rack, ['route' => [config('laraadmin.adminRoute') . '.racks.update', $rack->id ], 'method'=>'PUT', 'id' => 'rack-edit-form']) !!}
					{{--@la_form($module)--}}
					
					
					{{--@la_input($module, 'rack_code')--}}
					@la_input($module, 'rack_name')
					@la_input($module, 'storage')
					
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <a href="{{ url(config('laraadmin.adminRoute') . '/racks') }}" class="btn btn-default pull-right">Cancel</a>
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
	$("#rack-edit-form").validate({
		
	});
});
</script>
@endpush
