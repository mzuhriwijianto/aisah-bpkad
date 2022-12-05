@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/persediaan_instocks') }}">Persediaan instock</a> :
@endsection
@section("contentheader_description", $persediaan_instock->$view_col)
@section("section", "Persediaan instocks")
@section("section_url", url(config('laraadmin.adminRoute') . '/persediaan_instocks'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Persediaan instocks Edit : ".$persediaan_instock->$view_col)

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
				{!! Form::model($persediaan_instock, ['route' => [config('laraadmin.adminRoute') . '.persediaan_instocks.update', $persediaan_instock->id ], 'method'=>'PUT', 'id' => 'persediaan_instock-edit-form']) !!}
					@la_form($module)
					
					{{--
					@la_input($module, 'ref_persediaan')
					@la_input($module, 'ref_brg')
					@la_input($module, 'kd_bidang')
					@la_input($module, 'kd_unit')
					@la_input($module, 'kd_sub')
					@la_input($module, 'kd_upb')
					@la_input($module, 'jml_instock')
					@la_input($module, 'tgl_instock')
					@la_input($module, 'tahun_instock')
					--}}
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/persediaan_instocks') }}">Cancel</a></button>
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
	$("#persediaan_instock-edit-form").validate({
		
	});
});
</script>
@endpush
