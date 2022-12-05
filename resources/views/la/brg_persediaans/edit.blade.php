@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/brg_persediaans') }}">Brg persediaan</a> :
@endsection
@section("contentheader_description", $brg_persediaan->$view_col)
@section("section", "Brg persediaans")
@section("section_url", url(config('laraadmin.adminRoute') . '/brg_persediaans'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Brg persediaans Edit : ".$brg_persediaan->$view_col)

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
				{!! Form::model($brg_persediaan, ['route' => [config('laraadmin.adminRoute') . '.brg_persediaans.update', $brg_persediaan->id ], 'method'=>'PUT', 'id' => 'brg_persediaan-edit-form']) !!}
					{{--@la_form($module)--}}
					
					
					@la_input($module, 'nama_barang')
					@la_input($module, 'ref_brg')
					@la_input($module, 'satuan')
					@la_input($module, 'type')
					
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/brg_persediaans') }}">Cancel</a></button>
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
	$("#brg_persediaan-edit-form").validate({
		
	});
});
</script>
@endpush
