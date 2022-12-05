@extends("la.layouts.app")

@section("contentheader_title", "Adm penghapusans")
@section("contentheader_description", "Adm penghapusans listing")
@section("section", "Adm penghapusans")
@section("sub_section", "Listing")
@section("htmlheader_title", "Adm penghapusans Listing")

@section("headerElems")
@la_access("Adm_penghapusans", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add Adm penghapusan</button>
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
		<li class="active"><a role="tab" data-toggle="tab" class="active" href="#Entry" data-target="#tab-info"><i class="fa fa-barcode"></i> Daftar Ajuan PB</a></li>
		<li class=""><a role="tab" data-toggle="tab" class="active" href="#Entry" data-target="#tab-timeline"><i class="fa fa-barcode"></i> Item Ajuan</a></li>
</ul>

@la_access("Adm_penghapusans", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Adm penghapusan</h4>
			</div>
			{!! Form::open(['action' => 'LA\Adm_penghapusansController@store', 'id' => 'adm_penghapusan-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
				{{-- @la_form($module) --}}
					
					@la_input($module, 'no_surat')
					@la_input($module, 'tanggal_surat')
					@la_input($module, 'pejabat')
					@la_input($module, 'jenis_surat')
					<div class="col-md-12">
							<label for="rekening">Alasan</label>
							<select name="kd_alasan" id="kd_alasan" class="form-control">
								<option value="">== Pilih Alasan ==</option>
								<option value="%">%</option>
								 @foreach($alasan as $alasans)
									<option value="{{ $alasans -> kd_alasan }}" >
										{{ $alasans ->kd_alasan.'.'.$alasans -> ur_alasan }}
									</option>
								 @endForeach
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
						<div class="box-body table-responsive">
							<table id="example1" class="table table-bordered table-striped">
							<thead>
							<tr class="bg-aqua text-center">
								<th rowspan = 2 class="text-center">No.</th>														
								<th rowspan = 2 class="text-center">Alasan.</th>														
								<th colspan = 6 class="text-center">Bukti Penghapusan</th>																																																																																																																																																																																																																																																													
								<th colspan = 4 class="text-center">SK Penghapusan</th>
								<th colspan = 4 class="text-center">Berita Acara</th>
								<th rowspan = 2 class="text-center">Action</th>
							 </tr>
							 <tr class="bg-aqua" >
									<th class="text-center">Jenis Surat</th>
									<th class="text-center">No Surat</th>
									<th class="text-center">Tgl Surat</th>
									<th class="text-center">Nama Pejabat</th>
									<th class="text-center">File Surat</th>
									<th class="text-center">Upload Bukti</th>
									<th class="text-center">No SK</th>
									<th class="text-center">Tgl SK</th>
									<th class="text-center">Upload SK</th>
									<th class="text-center">File SK</th>
									<th class="text-center">No BA</th>
									<th class="text-center">Tgl BA</th>
									<th class="text-center">Upload BA</th>
									<th class="text-center">File BA</th>
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
@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script>
$(document).ready(function () {

            fetch_customer_data();

            function fetch_customer_data(query = '') {
                $.ajax({
                    url:"{{ url(config('laraadmin.adminRoute') . '/adm_penghapusan_dt_ajax') }}",
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

            $(document).on('keyup', '#search1', function () {
                var query = $(this).val();
                fetch_customer_data(query);				
            });		
        });

</script>
@endpush
