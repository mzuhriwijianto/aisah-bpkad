@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/pengajuan_loanings') }}">Pengajuan loaning</a> :
@endsection
@section("contentheader_description", $pengajuan_loaning->$view_col)
@section("section", "Pengajuan loanings")
@section("section_url", url(config('laraadmin.adminRoute') . '/pengajuan_loanings'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Pengajuan loanings Edit : ".$pengajuan_loaning->$view_col)

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
				{!! Form::model($pengajuan_loaning, ['route' => [config('laraadmin.adminRoute') . '.pengajuan_loanings.update', $pengajuan_loaning->id ], 'method'=>'PUT', 'id' => 'pengajuan_loaning-edit-form']) !!}
					{{--@la_form($module)--}}
					
					
					{{--@la_input($module, 'idpemda')--}}
					
					{{--@la_input($module, 'peminjam')										
					@la_input($module, 'status')
					@la_input($module, 'dept')
					@la_input($module, 'alasan_peminjaman')
					@la_input($module, 'tgl_peminjaman')
					@la_input($module, 'tgl_pengembalian')--}}
					@la_input($module, 'alasan_peminjaman')
					<div class="form-group">
						<label for="tgl_peminjaman">tgl_peminjaman :</label>
						<div class="input-group date">
							<input class="form-control" placeholder="Enter tgl_peminjaman" name="tgl_peminjaman" type="text" value="">
							<span class="input-group-addon">
								<span class="fa fa-calendar"></span>
							</span>
						</div>
					</div>
					<div class="form-group">
						<label for="tgl_pengembalian">tgl_pengembalian :</label>
						<div class="input-group date">
							<input class="form-control" placeholder="Enter tgl_pengembalian" name="tgl_pengembalian" type="text" value="">
							<span class="input-group-addon">
								<span class="fa fa-calendar"></span>
							</span>
						</div>
					</div>
					<div class="form-group">
					<select class="form-control select2-hidden-accessible" data-placeholder="Enter Nomor Polisi" rel="select2" name="idpemda">
						@foreach ($data as $datas)
						<option value="{{ $datas->idpemda }}">{{ $datas->nomor_polisi }} - {{$datas->merk}}</option>						
						@endforeach
					</select>
					</div>
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/pengajuan_loanings') }}">Cancel</a></button>
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
	$("#pengajuan_loaning-edit-form").validate({
		
	});
});
</script>
@endpush
