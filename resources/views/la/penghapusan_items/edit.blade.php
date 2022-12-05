@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/penghapusan_items') }}">Penghapusan item</a> :
@endsection
@section("contentheader_description", $penghapusan_item->$view_col)
@section("section", "Penghapusan items")
@section("section_url", url(config('laraadmin.adminRoute') . '/penghapusan_items'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Penghapusan items Edit : ".$penghapusan_item->$view_col)

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
				{!! Form::model($penghapusan_item, ['route' => [config('laraadmin.adminRoute') . '.penghapusan_items.update', $penghapusan_item->id ], 'method'=>'PUT', 'id' => 'penghapusan_item-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'no_ajuan')
					@la_input($module, 'idpemda')
					@la_input($module, 'Validation')
					@la_input($module, 'validation_by')
					@la_input($module, 'validation_at')
					@la_input($module, 'kd_aset8')
					@la_input($module, 'kd_aset80')
					@la_input($module, 'kd_aset81')
					@la_input($module, 'kd_aset82')
					@la_input($module, 'kd_aset83')
					@la_input($module, 'kd_aset84')
					@la_input($module, 'kd_aset85')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/penghapusan_items') }}">Cancel</a></button>
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
	$("#penghapusan_item-edit-form").validate({
		
	});
});
</script>
@endpush
