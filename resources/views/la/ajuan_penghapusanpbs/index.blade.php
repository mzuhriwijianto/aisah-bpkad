@extends("la.layouts.app")

@section("contentheader_title", "Ajuan penghapusan PB")
@section("contentheader_description", "Ajuan penghapusan PB listing")
@section("section", "Ajuan penghapusan PB")
@section("sub_section", "Listing")
@section("htmlheader_title", "Ajuan penghapusan PB Listing")

@section("headerElems")
@la_access("Ajuan_penghapusanpbs", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add Ajuan penghapusan PB</button>
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
<ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
		<li class="active"><a role="tab" data-toggle="tab" class="active" href="#Entry" data-target="#tab-info"><i class="fa fa-barcode"></i> Pengajuan PB</a></li>
		<li class=""><a role="tab" data-toggle="tab" class="active" href="#Entry" data-target="#tab-timeline"><i class="fa fa-barcode"></i> Pengajuan PB Pembantu</a></li>
</ul>
<div class="tab-content">
	<div role="tabpanel" class="tab-pane active fade in" id="tab-info">
		<div class="timeline-item">
				<div class="timeline-item">
					<div class="panel-default panel-heading">
						<h4>Lists</h4>
					</div>
					<div class="box box-success">
						<div class="form-group">
						<h2>Nomor Ajuan</h2>
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
								<th>No Ajuan</th>															
								<th>Tgl Ajuan</th>							
								<th>Jenis Ajuan</th>																																																																											
								<th>No Surat</th>																																																																											
								<th>Validasi Aset</th>																																																													
								<th>Validasi Aset by</th>																																																													
								<th>Validasi Aset at</th>																																																													
								<th>Komentar</th>																																																													
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
	
	<div role="tabpanel" class="tab-pane fade in" id="tab-timeline">
			<div class="timeline-item">
					<div class="timeline-item">
						<div class="panel-default panel-heading">
							<h4>Lists</h4>
						</div>
						<div class="box box-success">
							<div class="form-group">
							<h2>Nomor Ajuan</h2>
								<input type="text" name="search2" id="search2" class="form-control" placeholder="Cari.." />
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
								<table id="example2" class="table table-bordered table-striped">
								<thead>
								<tr class="bg-aqua">
									<th>No.</th>
									<th>Dept</th>															
									<th>No Ajuan</th>															
									<th>Tgl Ajuan</th>							
									<th>Jenis Ajuan</th>							
									<th>No Surat</th>							
									<th>Validasi PB</th>																																																													
									<th>Validasi PB by</th>																																																													
									<th>Validasi PB at</th>																																																													
									<th>Validasi Aset</th>																																																													
									<th>Validasi Aset by</th>																																																													
									<th>Validasi Aset at</th>																																																																																							
									<th>Komentar</th>																																																																																							
								 </tr>
								</thead>
								<tbody id = "tbody2">	

								</tbody>
								</table>
							</div>
						</div>
					</div>
			</div>
	</div>		
</div>

@la_access("Ajuan_penghapusanpbs", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Ajuan penghapusanpb</h4>
			</div>
			{!! Form::open(['action' => 'LA\Ajuan_penghapusanpbsController@store', 'id' => 'ajuan_penghapusanpb-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
							<label for="tgl_ajuan">Tgl_ajuan : </label>
							<input class="form-control" placeholder="Enter Tgl_ajuan" name="tgl_ajuan" type="text" value="{{ date('d-m-Y', strtotime("now")) }}" readonly>

							<label for="opd">OPD :</label>
							<input class="form-control" placeholder="{{ Module::usersubunit()->nm_sub }}" name="opd" type="number" value="" readonly>
													
							<label for="opd">Kepala OPD :</label>
							<input class="form-control" placeholder="{{ Module::userkaopd()->Nm_Pimpinan }}" name="opd" type="number" value="" readonly>
							
							<label for="opd">NIP Kepala OPD :</label>
							<input class="form-control" placeholder="{{ Module::userkaopd()->Nip_pimpinan }}" name="opd" type="number" value="" readonly>
							
							<label for="opd">Jabatan Ka OPD :</label>
							<input class="form-control" placeholder="{{ Module::userkaopd()->Jbt_Pimpinan }}" name="opd" type="number" value="" readonly>
							<div class="form-group">
							<label for="jenis_ajuan">Jenis_ajuan :</label>
							<select class="form-control select2-hidden-accessible" data-placeholder="Enter Jenis_ajuan" rel="select2" name="jenis_ajuan" tabindex="-1" aria-hidden="true">
								<option value="Putusan Pengadilan">Putusan Pengadilan</option>
								<option value="Menjalankan ketentuan undang-undang">Ketentuan undang-undang</option>
								<option value="Pemusnahan">Pemusnahan</option><option value="Sebab lain">Sebab lain</option>
								<option value="Pemindahtanganan (Dalam bentuk Hibah)">Pemindahtanganan (Dalam bentuk Hibah)</option>
								<option value="Pemindahtanganan (Dalam bentuk Penjualan)">Pemindahtanganan (Dalam bentuk Penjualan)</option>
							</select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100px;"><span class="selection"><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
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
<div class="modal fade" id="ajuanpbp" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Ajuan Pengurus Barang Pembantu</h4>
			</div>
			<div class="modal-body">
				<div class="box-body">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
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
                    url:"{{ url(config('laraadmin.adminRoute') . '/ajuan_penghapusanpb_dt_ajax') }}",
                    method: 'GET',
                    data: {query: query},
                    dataType: 'json',
                    success: function (data) {
                        $('#tbody1').html(data.table_data);
						//console.log(data);
						//alert(data);
                    }
                }).fail(function(){
					$('#tbody1').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
					//$('#tbody1').hide();
				});
            }

            $(document).on('keyup', '#search', function () {
                var query = $(this).val();
                fetch_customer_data(query);				
            });		
        });
$(document).ready(function () {

            fetch_customer_data();

            function fetch_customer_data(query = '') {
                $.ajax({
                    url:"{{ url(config('laraadmin.adminRoute') . '/ajuan_penghapusanpb_dt_ajax2') }}",
                    method: 'GET',
                    data: {query: query},
                    dataType: 'json',
                    success: function (data) {
                        $('#tbody2').html(data.table_data);
						//console.log(data);
						//alert(data);
                    }
                }).fail(function(){
					$('#tbody2').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
					//$('#tbody1').hide();
				});
            }

            $(document).on('keyup', '#search1', function () {
                var query = $(this).val();
                fetch_customer_data(query);				
            });		
        });
//endsearch

//load nomor ajuan

</script>
@endpush
