@extends("la.layouts.app")

@section("contentheader_title", "Verifikasi kendaraans")
@section("contentheader_description", "Verifikasi kendaraans listing")
@section("section", "Verifikasi kendaraans")
@section("sub_section", "Listing")
@section("htmlheader_title", "Verifikasi kendaraans Listing")

@section("headerElems")
@la_access("Verifikasi_kendaraans", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add Verifikasi kendaraan</button>
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
		<li class="active"><a role="tab" data-toggle="tab" class="active" href="#Entry" data-target="#tab-info"><i class="fa fa-barcode"></i> Entry</a></li>
		<li class=""><a role="tab" data-toggle="tab" href="#lists" data-target="#tab-timeline"><i class="fa fa-clock-o"></i>Lists Belum Verifikasi</a></li>
		<li class=""><a role="tab" data-toggle="tab" href="#listsver" data-target="#tab-timeline1"><i class="fa fa-clock-o"></i>Lists Sudah Verifikasi</a></li>
</ul>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

<div class="tab-content">
		<div role="tabpanel" class="tab-pane active fade in" id="tab-info">
			<div class="tab-content">
				<div class="panel infolist">					
						<div class="row">
						<br/>
							<div class="col-lg-3 col-xs-6">
              <!-- small box -->
							<div class="small-box bg-orange">
								<div class="inner">
								  <h3>{{ $kendaraan }}</h3>
								  <p>Total Kendaraan</p>
								  <div class="box-body">
						
								  </div>
								</div>
								<div class="icon">
								  <i class="ion ion-ios-cart"></i>
								</div>
								<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
							 </div>							
							</div>
							<div class="col-lg-3 col-xs-6">
								  <div class="small-box bg-black text-white">
									<div class="inner">
									  <h3>{{ $kendaraanhapus }}</h3>
									  <p>Kendaraan Dihapus</p>
									  <div class="box-body">
							
									  </div>
									</div>
									<div class="icon">
									  <i class="ion ion-trash-a"></i>
									</div>
									<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
								  </div>							
							 </div>	
							<div class="col-lg-3 col-xs-6">
								 <div class="small-box bg-aqua">
									<div class="inner">
									  <h3>{{ $bpkbnotempty }}</h3>
									  <p>BPKB Telah Diisi</p>
									  <div class="box-body">							
									  </div>
									</div>
									<div class="icon">
									  <i class="ion ion-clipboard"></i>
									</div>
									<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							  </div>
							  <div class="col-lg-3 col-xs-6">
								  <div class="small-box bg-red">
									<div class="inner">
									  <h3>{{ $bpkbempty }}</h3>
									  <p>BPKB Belum Diisi</p>
									  <div class="box-body">
							
									  </div>
									</div>
									<div class="icon">
									  <i class="ion ion-ios-pulse"></i>
									</div>
									<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
								  </div>							
							  </div>
													  
						</div>
				</div>
			</div>
			<div class="tab-content">
				<div class="panel infolist">
					<div class="box-body table-responsive">
					<h2>Keterangan</h2>
							<table id="#" class="table table-bordered table-striped">
							<thead>
							<tr class="bg-aqua">
								<th>No.</th>
								<th>Kd Bidang</th>									
								<th>Kd Unit</th>									
								<th>Kd Sub</th>																
								<th>Kd UPB</th>																
								<th>Dept</th>																							
								<th>Total Kendaraan</th>							
								<th>BPKB Diisi</th>							
								<th>No Rangka Diisi</th>							
								<th>No Mesin Diisi</th>							
								<th>BPKB Diupload</th>							
								<th>STNK Diupload</th>
								<th>Verif Dok</th>													
								<th>Verif Pajak</th>								
							 </tr>
							</thead>
							<tbody id = "#">	
							@foreach ($bpkbcount as $index =>$bpkbcounts)
								<tr>
									<td>{{ $index + 1 }}</td>
									<td>{{ $bpkbcounts->kd_bidang }}</td>
									<td>{{ $bpkbcounts->kd_unit }}</td>
									<td>{{ $bpkbcounts->kd_sub }}</td>
									<td>{{ $bpkbcounts->kd_upb }}</td>
									<td>{{ $bpkbcounts->name }}</td>
									<td>{{ $bpkbcounts->kendaraantot }}</td>
									<td>{{ $bpkbcounts->nobpkbdiisi }}</td>
									<td>{{ $bpkbcounts->norangkadiisi }}</td>
									<td>{{ $bpkbcounts->nomesindiisi }}</td>
									<td>{{ $bpkbcounts->bpkbdiupload }}</td>
									<td>{{ $bpkbcounts->stnkdiupload }}</td>
									<td>{{ $bpkbcounts->verifdok }}</td>
									<td>{{ $bpkbcounts->veriftax }}</td>
								</tr>
								@endforeach
							</tbody>
							</table>
						</div>
				</div>
			</div>
		</div>

		<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="tab-timeline">
				<div class="timeline-item">
					<div class="panel-default panel-heading">
						<h4>Lists Data Belum Verifikasi</h4>
					</div>
					<div class="box box-success">
						<div class="form-group" >
						<h2>Nomor Polisi / Nomor BPKB</h2>
							<input type="text" name="search" id="search" class="form-control" placeholder="Cari.." />
						</div>
						
						<div class="form-group ">
							<h2>Print List</h2>	
						<form id = "getprintsoloform" method="POST" action="printsolo" accept-charset="UTF-8" class = "col-sm-6">
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
								<th>IDPemda</th>							
								<th>Merk</th>							
								<th>Type</th>							
								<th>CC</th>														
								<th>Nomor Rangka</th>							
								<th>Nomor Mesin</th>							
								<th>Nomor Polisi</th>							
								<th>Nomor BPKB</th>													
								<th>BPKB File</th>														
								<th>STNK File</th>							
								<th>Pajak</th>							
								<th>File Foto Kendaraan</th>							
								<th>File BAST</th>							
								<th>Pemegang Kendaraan</th>							
								<th>Val.Dokumen</th>
								<th>Val.Pajak</th>		
								<th>Act. Dok</th>																																					
								<th>Act. Pajak</th>																																																																									
							 </tr>
							</thead>
							<tbody id= "tbody2">	

							</tbody>
							</table>
						</div>
					</div>
				</div>
		</div>
		<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="tab-timeline1">
				<div class="timeline-item">
					<div class="panel-default panel-heading">
						<h4>Lists Data Sudah Verifikasi</h4>
					</div>
					<div class="box box-success">
						<div class="form-group" >
						<h2>Nomor Polisi / Nomor BPKB</h2>
							<input type="text" name="search" id="search1" class="form-control" placeholder="Cari.." />
						</div>
						
						<div class="form-group ">
							<h2>Print List</h2>	
						<form id = "getprintsoloform" method="POST" action="printsolo" accept-charset="UTF-8" class = "col-sm-6">
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
								<th>IDPemda</th>							
								<th>Merk</th>							
								<th>Type</th>							
								<th>CC</th>														
								<th>Nomor Rangka</th>							
								<th>Nomor Mesin</th>							
								<th>Nomor Polisi</th>							
								<th>Nomor BPKB</th>													
								<th>BPKB File</th>														
								<th>STNK File</th>							
								<th>Pajak</th>							
								<th>File Foto Kendaraan</th>							
								<th>File BAST</th>							
								<th>Pemegang Kendaraan</th>							
								<th>Val.Dokumen</th>
								<th>Val.Pajak</th>	
								<th>Act. Dok</th>																																					
								<th>Act. Pajak</th>															
							 </tr>
							</thead>
							<tbody id= "tbody3">	

							</tbody>
							</table>
						</div>
					</div>
				</div>
		</div>
</div>
	
@endsection

@push('scripts')

<script type="text/javascript">
//search
$(document).ready(function () {

            fetch_customer_data();

            function fetch_customer_data(query = '') {
                $.ajax({
                    url:"{{ url(config('laraadmin.adminRoute') . '/notverifikasikendaraanscari') }}",
                    method: 'GET',
                    data: {query: query},
                    dataType: 'json',
                    success: function (data) {
                        $('#tbody2').html(data.table_data);
                    }
                })
            }

            $(document).on('keyup', '#search', function () {
                var query = $(this).val();
                fetch_customer_data(query);				
            });		
        });
//endsearch
//search
$(document).ready(function () {

            fetch_customer_data();

            function fetch_customer_data(query = '') {
                $.ajax({
                    url:"{{ url(config('laraadmin.adminRoute') . '/verifikasikendaraanscari') }}",
                    method: 'GET',
                    data: {query: query},
                    dataType: 'json',
                    success: function (data) {
                        $('#tbody3').html(data.table_data);
                    }
                })
            }

            $(document).on('keyup', '#search1', function () {
                var query = $(this).val();
                fetch_customer_data(query);				
            });		
        });
//endsearch
function dellastchar(){
	var strng=document.getElementById("searchsolo").value;
	document.getElementById("searchsolo").value=strng.substring(0,strng.length-1)
	//alert(strng.substring(0,strng.length-1));
}

//get checkbox		
function validate() {
	//cleartxt();
	$('input[id="chkbox1"]:checked').each(function() {				
			var selectedidpemda = new Array();			
			selectedidpemda.push(this.value);
			var data = selectedidpemda+ ',';
			document.getElementById('searchsolo').value += data;
	});
}
//clear text
function cleartxt() {
	var form = document.getElementById("getprintsoloform");
form.reset();
}
</script>
@endpush
