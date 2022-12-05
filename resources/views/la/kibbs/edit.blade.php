@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/kibbs') }}">Kibb</a> :
@endsection
@section("contentheader_description", $kibb->$view_col)
@section("section", "Kibbs")
@section("section_url", url(config('laraadmin.adminRoute') . '/kibbs'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Kibbs Edit : ".$kibb->$view_col)

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
				
				<div class="col-md-3">
					<label for="pgw">Pilih Pegawai</label>
					<form action="/admin/kibbs/updpemegangbrg/$kibb->id" method="post" enctype="multipart/form-data">
					<select name="pgw" id="pgw" class="form-control">
						<option value="">== Pilih Pegawai ==</option>
						<option value="%">%</option>
						 @foreach($pgw as $pgws)
							<option value="{{ $pgws -> id }}">
								{{ $pgws->nip.' / '.$pgws->jabatan.' / '.$pgws->nama }}
							</option>
						 @endForeach
					</select>
					<button type="submit" name="submit" class="btn btn-warning btn-block mt-4">
						Update Pemegang Barang
					</button>
					</form>
					<label for="gbr">Foto Barang</label>
					@if($kibb->imgname != '')														
					<img src="{{url('/storage/imgkib/Image/'.$kibb->imgname)}}"alt="gambar" width = "190" height = "160"/>
					<form action="/admin/kibbs/upload-file/{{ $kibb->id }}" method="post" enctype="multipart/form-data">														
						<input name="_token" type="hidden" value="{{ csrf_token() }}">
							<div class="custom-file">
								<input type="file" name="file" class="custom-image-input" id="chooseFile">
							</div>
							<button type="submit" name="submit" class="btn btn-warning btn-block mt-4">
								Update Files
							</button>
					</form>
					@else				
						<form action="/admin/kibbs/upload-file/{{ $kibb->id }}" method="post" enctype="multipart/form-data">														
						<input name="_token" type="hidden" value="{{ csrf_token() }}">
							<div class="custom-file">
								<input type="file" name="file" class="custom-image-input" id="chooseFile">
							</div>
							<button type="submit" name="submit" class="btn btn-warning btn-block mt-4">
								Update Files
							</button>
						</form>	
					@endif
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
	$("#kibb-edit-form").validate({
		
	});
});
</script>
@endpush
