@extends("la.layouts.app")

@section("contentheader_title", "Pengajuan Peminjaman BPKB")
@section("contentheader_description", "Pengajuan Peminjaman BPKB listing")
@section("section", "Pengajuan Peminjaman BPKB")
@section("sub_section", "Listing")
@section("htmlheader_title", "Pengajuan Peminjaman BPKB Listing")

@section("headerElems")
@la_access("Pengajuan_loanings", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add Pengajuan loaning</button>
@endla_access
@endsection

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

<div class="tab-content">
	<div role="tabpanel" class="tab-pane active fade in" id="tab-info">
		<div class="timeline-item">
				<div class="timeline-item">
					<div class="panel-default panel-heading">
						<h4>Lists</h4>
					</div>
					<div class="box box-success">
						<div class="form-group">
						<h2>Nomor Polisi</h2>
							<input type="text" name="search" id="search" class="form-control" placeholder="Cari.." />
						</div>
						<div class="form-group ">
							<h2>Print List</h2>	
						<form id = "getprintsoloform" method="POST" action="bcdsolo" accept-charset="UTF-8" class = "col-sm-6">
						<input name="_token" type="hidden" value="{{ csrf_token() }}">						
							<div class="input-group">
							  <input type="text" name="searchsolo" id="searchsolo" class="form-control" placeholder="Cari.." readonly />
							  <span class="input-group-btn">															
									<button class="btn btn-success" type="submit" id= "getprintsolo" onclick = "dellastchar()">
										<i class="fa fa-print"></i>
									</button>																									
							  </span>
							</div>
						</form>
							<div class="input-group" class = "col-sm-6">
							<span class="input-group-btn">	
							<button class="btn btn-primary" type="submit" id= "printsolo" onclick = "validate()">
								GET
							</button>
							<button class="btn btn-warning" type="submit" onclick="cleartxt()">
									<i class="fa fa-undo"></i>
							</button>
							 </span>
							</div>
						</div>
						<div class="box-body table-responsive">
							<table id="example1" class="table table-bordered table-striped">
							<thead>
							<tr class="bg-aqua">
								<th>No.</th>
								<th>Dept</th>															
								<th>User</th>															
								<th>Merk</th>							
								<th>Type</th>																										
								<th>No Polisi</th>							
								<th>No BPKB</th>													
								<th>Tgl Pajak</th>																											
								<th>Tgl Peminjaman</th>																											
								<th>Tgl Pengembalian</th>																											
								<th>Pemegang Kendaraan</th>																											
								<th>Status</th>																											
								<th>Action</th>																											
							 </tr>
							</thead>
							<tbody id = "tbody1">	

							</tbody>
							</table>
						</div>
					</div>
				</div>
		</div>
	</div>		
</div>

@la_access("Pengajuan_loanings", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Pengajuan loaning</h4>
			</div>
			{!! Form::open(['action' => 'LA\Pengajuan_loaningsController@store', 'id' => 'pengajuan_loaning-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
                   {{-- @la_form($module) --}}
					
					{{--@la_input($module, 'idpemda')
					@la_input($module, 'alasan_peminjaman')
					@la_input($module, 'peminjam')
					@la_input($module, 'tgl_peminjaman')
					@la_input($module, 'tgl_pengembalian')
					@la_input($module, 'no_polisi')
					@la_input($module, 'status')
					@la_input($module, 'dept')--}}
					@la_input($module, 'alasan_peminjaman')
					<div class="form-group">
						<label for="peminjam">Peminjam :</label>
						<input class="form-control" placeholder="{{ $username }}" name="peminjam" value="" readonly>
					</div>
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
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				{!! Form::submit( 'Submit', ['class'=>'btn btn-success']) !!}
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endla_access

@endsection

@push('styles')

@endpush

@push('scripts')

<script>
//search
$(document).ready(function () {

            fetch_customer_data();

            function fetch_customer_data(query = '') {
                $.ajax({
                    url:"{{ url(config('laraadmin.adminRoute') . '/pengajuan_loaning_dt_ajax') }}",
                    method: 'GET',
                    data: {query: query},
                    dataType: 'json',
                    success: function (data) {
                        $('#tbody1').html(data.table_data);
                    }
                })
            }

            $(document).on('keyup', '#search', function () {
                var query = $(this).val();
                fetch_customer_data(query);				
            });		
        });
//endsearch
</script>
@endpush
