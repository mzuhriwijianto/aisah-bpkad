@extends("la.layouts.app")

@section("contentheader_title", "Penghapusan items")
@section("contentheader_description", "Penghapusan items listing")
@section("section", "Penghapusan items")
@section("sub_section", "Listing")
@section("htmlheader_title", "Penghapusan items Listing")

@section("headerElems")
@la_access("Penghapusan_items", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add Penghapusan item</button>
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
							<tr class="bg-aqua">
								<th>No.</th>
								<th>Dept</th>															
								<th>No Ajuan</th>															
								<th>Tgl Ajuan</th>							
								<th>Jenis Ajuan</th>																																																																											
								<th>No Surat PB</th>	
								<th>Tgl Surat PB</th>								
								<th>No Surat PB Pembantu</th>																																																																																																																																																						
								<th>Tgl Surat PB Pembantu</th>																																																																																																																																																						
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
							<h2>Scan QR</h2>
								<input type="text" name="search" id="search1" class="form-control" placeholder="Cari.." />
							</div>
							<div class="box-body table-responsive">
								<table id="example2" class="table table-bordered table-striped">
								<thead>
								<tr class="bg-aqua">
									<th rowspan = 2>No.</th>
									<th rowspan = 2>idpemda</th>
									<th rowspan = 2>Nama Aset</th>
									<th rowspan = 2>Dept</th>															
									<th rowspan = 2>No Ajuan OPD</th>															
									<th rowspan = 2>Tgl Ajuan</th>							
									<th rowspan = 2>Jenis Ajuan OPD</th>							
									<th rowspan = 2>Tipe Ajuan</th>							
									<th rowspan = 2>No Surat PB</th>							
									<th rowspan = 2>Tgl Surat</th>							
									<th rowspan = 2>No Surat PB Pembantu</th>							
									<th rowspan = 2>Tgl Surat PB Pembantu</th>																																																																			
									<th rowspan = 2>Validasi Aset</th>																																																													
									<th rowspan = 2>Validasi Aset by</th>																																																													
									<th rowspan = 2>Validasi Aset at</th>																																																																																							
									<th rowspan = 2>Lokasi</th>																																																																																																																																																																																						
									<th rowspan = 2>Adm Penghapusan</th>																																																																																							
									<th rowspan = 2>Jenis Adm Penghapusan</th>																																																																																							
									<th rowspan = 2>Tgl Adm Penghapusan</th>
									<th colspan = 3>Action</th>										
								 </tr>
								 <tr class="bg-aqua">
									<th>Gudang</th>
									<th>OPD</th>
									<th>Label</th>
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
	<div class="modal fade" id="editsurat" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Tambahkan Nomor Surat</h4>
			</div>
			<form action="/admin/penghapusan_items/" method="get" enctype="multipart/form-data">														
			<input name="_token" type="hidden" value="{{ csrf_token() }}">
			<input name="_token" type="text" value="{{ csrf_token() }}">
			
			<table id="example1" class="table table-bordered table-striped">
				<thead>
				<tr class="bg-aqua">
					<th>No.</th>														
					<th>No Surat</th>															
					<th>Tgl Surat</th>							
					<th>Pejabat</th>																																																																											
					<th>Jenis</th>																																																																																																																																															
					<th>Action</th>																																																					
				 </tr>
				</thead>
				<tbody id = "tbody1">
				
					@foreach($adm as $index=>$adms)
					<tr>
					
					<td>{{$index+1}}</td>
					<td>{{$adms->no_surat}}</td>
					<td>{{$adms->tanggal_surat}}</td>
					<td>{{$adms->pejabat}}</td>
					<td>{{$adms->jenis_surat}}</td>
					@endforeach
					</tr>
				</tbody>
			</table>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				{!! Form::submit( 'Submit', ['class'=>'btn btn-success']) !!}
			</div>
			</form>
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
                    url:"{{ url(config('laraadmin.adminRoute') . '/penghapusan_item_dt_ajax') }}",
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
                    url:"{{ url(config('laraadmin.adminRoute') . '/dt_ajax_item') }}",
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
$(document).ready(function() {
   $('.inputClass').each(function() {
      $(this).click(function(){
          var id = $(this).attr('id');
         alert(id);
      });
   });
});		

</script>
@endpush
