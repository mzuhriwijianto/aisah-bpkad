@extends("la.layouts.app")

@section("contentheader_title", "Peralatan dan Mesin")
@section("contentheader_description", "Peralatan dan Mesin listing")
@section("section", "Peralatan dan Mesin")
@section("sub_section", "Listing")
@section("htmlheader_title", "Peralatan dan Mesin Listing")

@section("headerElems")
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
		<li class=""><a role="tab" data-toggle="tab" href="#lists" data-target="#tab-timeline"><i class="fa fa-clock-o"></i>Lists Peralatan & Mesin</a></li>
</ul>

<div class="tab-content">
		<div role="tabpanel" class="tab-pane active fade in" id="tab-info">
			<div class="tab-content">
				<div class="panel infolist">					
						<div class="row">
						<br/>
							<div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-green">
									<div class="inner">
									  <h3></h3>
									  <p>Alat Besar</p>
									  <div class="box-body">							
									  </div>
									</div>
									<div class="icon">
									  <i class="fa fa-map-o"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							  </div>
							<div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-orange">
									<div class="inner">
									  <h3></h3>
									  <p>Alat Angkutan</p>
									  <div class="box-body">							
									  </div>
									</div>
									<div class="icon">
									  <i class="fa fa-map-o"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							 </div>	
							 <div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-blue">
									<div class="inner">
									  <h3></h3>
									  <p>Alat Bengkel dan Alat Ukur</p>
									  <div class="box-body">							
									  </div>
									</div>
									<div class="icon">
									  <i class="ion ion-clipboard"></i>
									</div>
									<a href="{{ url(config('laraadmin.adminRoute') . '/printtanahanpemkab') }}" target="_blank"" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							  </div>
							<div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-yellow">
									<div class="inner">
									  <h3></h3>
									  <p>Alat Pertanian</p>
									  <div class="box-body">							
									  </div>
									</div>
									<div class="icon">
									  <i class="ion ion-clipboard"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							  </div>

							<div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-aqua">
									<div class="inner">
									  <h3></h3>
									  <p>Alat Kantor dan Rumah Tangga</p>
									  <div class="box-body">							
									  </div>
									</div>
									<div class="icon">
									  <i class="ion ion-clipboard"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							  </div>
							  <div class="col-lg-2 col-xs-6">
								  <div class="small-box bg-yellow">
									<div class="inner">
									  <h3></h3>
									  <p>Alat Studio, Komunikasi dan Pemancar</p>
									  <div class="box-body">
							
									  </div>
									</div>
									<div class="icon">
									  <i class="ion ion-ios-pulse"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>							
							  </div>
							  <div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-blue">
									<div class="inner">
									  <h3></h3>
									  <p>Alat Kedokteran dan Kesehatan</p>
									  <div class="box-body">							
									  </div>
									</div>
									<div class="icon">
									  <i class="ion ion-clipboard"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							  </div>
							  <div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-red">
									<div class="inner">
									  <h3></h3>
									  <p>Alat Laboratorium</p>
									  <div class="box-body">							
									  </div>
									</div>
									<div class="icon">
									  <i class="ion ion-clipboard"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							  </div>
							  <div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-green">
									<div class="inner">
									  <h3></h3>
									  <p>Alat Persenjataan</p>
									  <div class="box-body">							
									  </div>
									</div>
									<div class="icon">
									  <i class="ion ion-clipboard"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							  </div>
							   <div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-orange">
									<div class="inner">
									  <h3></h3>
									  <p>Komputer</p>
									  <div class="box-body">							
									  </div>
									</div>
									<div class="icon">
									  <i class="ion ion-clipboard"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							  </div>
							  <div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-yellow">
									<div class="inner">
									  <h3></h3>
									  <p>Alat Eksplorasi</p>
									  <div class="box-body">							
									  </div>
									</div>
									<div class="icon">
									  <i class="ion ion-clipboard"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							  </div>
							  <div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-purple">
									<div class="inner">
									  <h3></h3>
									  <p>Alat Pengeboran</p>
									  <div class="box-body">							
									  </div>
									</div>
									<div class="icon">
									  <i class="ion ion-clipboard"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							  </div>
							  <div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-aqua">
									<div class="inner">
									  <h3></h3>
									  <p>Alat Produksi, Pengolahan dan Pemurnian</p>
									  <div class="box-body">							
									  </div>
									</div>
									<div class="icon">
									  <i class="ion ion-clipboard"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							  </div>
							  <div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-green">
									<div class="inner">
									  <h3></h3>
									  <p>Alat Bantu Eksplorasi</p>
									  <div class="box-body">							
									  </div>
									</div>
									<div class="icon">
									  <i class="ion ion-clipboard"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							  </div>
							  <div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-red">
									<div class="inner">
									  <h3></h3>
									  <p>Alat Keselamatan Kerja</p>
									  <div class="box-body">							
									  </div>
									</div>
									<div class="icon">
									  <i class="ion ion-clipboard"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							  </div>
							  <div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-orange">
									<div class="inner">
									  <h3></h3>
									  <p>Alat Peraga</p>
									  <div class="box-body">							
									  </div>
									</div>
									<div class="icon">
									  <i class="ion ion-clipboard"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							  </div>
							  <div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-blue">
									<div class="inner">
									  <h3></h3>
									  <p>Peralatan Proses produksi</p>
									  <div class="box-body">							
									  </div>
									</div>
									<div class="icon">
									  <i class="ion ion-clipboard"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							  </div>
							  <div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-orange">
									<div class="inner">
									  <h3></h3>
									  <p>Rambu-rambu</p>
									  <div class="box-body">							
									  </div>
									</div>
									<div class="icon">
									  <i class="ion ion-clipboard"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							  </div>
							  <div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-white text-black">
									<div class="inner">
									  <h3></h3>
									  <p>Peralatan Olahraga</p>
									  <div class="box-body">							
									  </div>
									</div>
									<div class="icon">
									  <i class="ion ion-clipboard"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							  </div>
																				  
						</div>
				</div>
			</div>
			
			<div class="tab-content">						
				<div class="panel infolist">
					<div class="box-body table-responsive">
					<h2>Keterangan</h2>
							<table class="table table-bordered table-striped table align-middle">
							<thead>
							<tr class="bg-aqua">
								<th>No.</th>
								<th>Kd Bidang</th>									
								<th>Kd Unit</th>									
								<th>Kd Sub</th>																																	
								<th>Dept</th>																							
								<th>TOTAL PERALATAN & MESIN</th>																							
								<th> ALAT BESAR</th>
								<th> ALAT ANGKUTAN</th>																																																			
								<th> ALAT BENGKEL DAN ALAT UKUR</th>																																																																																																					
								<th> ALAT PERTANIAN</th>																																																																																																					
								<th> ALAT KANTOR DAN RUMAH TANGGA </th>																																																																																																					
								<th> ALAT STUDIO, KOMUNIKASI DAN PEMANCAR </th>																																																																																																					
								<th> ALAT KEDOKTERAN DAN KESEHATAN </th>																																																																																																					
								<th> ALAT LABORATORIUM </th>																																																																																																					
								<th> ALAT PERSENJATAAN </th>																																																																																																					
								<th> KOMPUTER </th>																																																																																																					
								<th> ALAT EKSPLORASI </th>																																																																																																					
								<th> ALAT PENGEBORAN </th>																																																																																																					
								<th> ALAT PRODUKSI, PENGOLAHAN DAN PEMURNIAN </th>																																																																																																					
								<th> ALAT BANTU EKSPLORASI </th>																																																																																																					
								<th> ALAT KESELAMATAN KERJA </th>																																																																																																					
								<th> ALAT PERAGA </th>																																																																																																					
								<th> PERALATAN PROSES/PRODUKSI </th>																																																																																																					
								<th> RAMBU - RAMBU </th>																																																																																																					
								<th> PERALATAN OLAH RAGA </th>																																																																																																					
							</tr>
							</thead>
							<tbody>	
								@foreach ($brgcount as $index =>$brgcounts)
								<tr>
									<td>{{ $index + 1 }}</td>
									<td>{{ $brgcounts->kd_bidang }}</td>
									<td>{{ $brgcounts->kd_unit }}</td>
									<td>{{ $brgcounts->kd_sub }}</td>
									<td>{{ $brgcounts->Nm_UPB }}</td>
									<td>{{ $brgcounts->brgtot }}</td>
									<td>{{ $brgcounts->abesartot }}</td>
									<td>{{ $brgcounts->angkutantot }}</td>
									<td>{{ $brgcounts->bengkeltot }}</td>
									<td>{{ $brgcounts->pertaniantot }}</td>
									<td>{{ $brgcounts->kantortot }}</td>
									<td>{{ $brgcounts->studiotot }}</td>
									<td>{{ $brgcounts->kedokterantot }}</td>
									<td>{{ $brgcounts->labtot }}</td>
									<td>{{ $brgcounts->senjatatot }}</td>
									<td>{{ $brgcounts->komputertot }}</td>
									<td>{{ $brgcounts->eksplortot }}</td>
									<td>{{ $brgcounts->bortot }}</td>
									<td>{{ $brgcounts->prodtot }}</td>
									<td>{{ $brgcounts->bantuexplortot }}</td>
									<td>{{ $brgcounts->k3tot }}</td>
									<td>{{ $brgcounts->peragatot }}</td>
									<td>{{ $brgcounts->prosestot }}</td>
									<td>{{ $brgcounts->rambutot }}</td>
									<td>{{ $brgcounts->olahtot }}</td>
								</tr>
								@endforeach														
							</tbody>
							</table>
						</div>
				</div>
			</div>
		</div>
	<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="tab-timeline">
		<div class="tab-content">
			<div class="panel infolist">					
					<div class="row">
						<div class="box box-success">
	<!--<div class="box-header"></div>-->
							<div class="timeline-item">
								<div class="form-group" class = "col-sm-12" >
									<div class="col-md-4">
										<label for="bidangs">Bidang</label>
										<select name="bidangs" id="bidangs" class="form-control">
											<option value="">== Pilih Bidang ==</option>
											 @foreach($refbidang as $refbidangs)
												<option value="{{ $refbidangs -> kd_bidang }}">
													{{ $refbidangs->kd_bidang.'.'.$refbidangs->nm_bidang }}
												</option>
											 @endForeach
										</select>					
									</div>
									<div class="col-md-4">
										<label for="unit" >Unit</label>
										<select name="units" id="units" class="form-control">
										</select>
									</div>
									<div class="col-md-4">
										<label for="sub" >Sub</label>
										<select name="subs" id="subs" class="form-control">
										</select>
									</div>
									<hr>
									<div class="col-md-2">
										<label for="rekening">Rek 0</label>
										<select name="rek0" id="rek0" class="form-control">
											<option value="">== Pilih Rekening 0 ==</option>
											 @foreach($refrek0 as $refrek0s)
												<option value="{{ $refrek0s -> kd_aset0 }}">
													{{ $refrek0s->kd_aset.'.'.$refrek0s->kd_aset0.'.'.$refrek0s->nm_aset0 }}
												</option>
											 @endForeach
										</select>					
									</div>
									<div class="col-md-2">
										<label for="name" >Rek 1</label>
										<select name="rek1" id="rek1" class="form-control">
											<option value="">== Pilih Rekening 1 ==</option>
										</select>
									</div>
									<div class="col-md-2">
										<label for="name" >Rek 2</label>
										<select name="rek2" id="rek2" class="form-control">
											<option value="">== Pilih Rekening 2 ==</option>
										</select>							
									</div>
									<div class="col-md-2">
										<label for="name" >Rek 3</label>
										<select name="rek3" id="rek3" class="form-control">
											<option value="">== Pilih Rekening 3 ==</option>
										</select>
									</div>
									
									<div class="col-md-2">
										<label for="name" >Rek 4</label>
										<select name="rek4" id="rek4" class="form-control">
											<option value="">== Pilih Rekening 4 ==</option>
										</select>
									</div>
									<div class="col-md-1">
										<label for="name" >Kondisi</label>
										<select name="kond" id="kond" class="form-control">
											<option value="">== Pilih Kondisi ==</option>
											@foreach($kond as $konds)
												<option value="{{ $konds -> Kd_Kondisi }}" >
													{{ $konds->Kd_Kondisi.'.'.$konds->uraian }}
												</option>
											 @endForeach
										</select>
									</div>
									<div class="col-md-1">
										<br/>
										<button id = "showbrg" class="btn btn-success btn-sm">Show Barang SUB</button>																																
									</div>
									<div class="col-md-4">
										<label for="upb" >UPB</label>
										<select name="upbs" id="upbs" class="form-control">
										</select>
									</div>
									<div class="col-md-1">
										<br/>
										<button id = "showbrgupb" class="btn btn-success btn-sm">Show Barang UPB</button>																																
									</div>
								</div>
								<div class="box box-success">
										<br/>								
										<label for="export" >Export</label>
										<button id = "csvbrg" class="btn btn-info btn-sm">EXCEL SUB</button>
										<button id = "csvbrgupb" class="btn btn-info btn-sm">EXCEL UPB</button>
										<!--<button id = "pdfbrg" class="btn btn-success btn-sm">PDF</button>-->
										<br/>
								</div>
								<div class="box box-success">
									<div class="form-group">
									<h2>Nama Aset/Nomor Polisi/Keterangan</h2>
										<input type="text" name="search" id="search" class="form-control" placeholder="Cari.." />
									</div>
									<div class="box-body table-responsive">
										<table id="example1" class="table table-bordered table-striped">
										<thead>
										<tr class="bg-aqua">
											<th>No.</th>															
											<th>KD Barang</th>															
											<th>IDPEMDA</th>																													
											<th>Dept</th>															
											<th>NAMA ASET</th>																						
											<th>NO REG</th>																						
											<th>THN PEROLEHAN</th>																						
											<th>TGL PEROLEHAN</th>																																																																																													
											<th>MERK/TYPE</th>																											
											<th>NO POLISI</th>																											
											<th>NO RANGKA</th>																											
											<th>NO MESIN</th>																											
											<th>HARGA INDUK</th>																																																						
											<th>HARGA KAP</th>																																																																																																												
											<th>KET</th>																																																				
											<th>PEMEGANG BRG</th>																																																				
											<th>GAMBAR</th>																																																				
											<th>ACTION</th>																																																				
											<th>LABEL</th>																																																				
										 </tr>
										</thead>
										<tbody id= "tbody1">	

										</tbody>
										</table>
									</div>
								</div>
								
								<div class="modal fade" id="addbrg" role="dialog" aria-labelledby="myModalLabel">
									<div class="modal-dialog modal-lg" role="document">
										<div class="modal-content">
											
												<div class="modal-header">
													<button  type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
													<h4 class="modal-title" id="myModalLabel">Edit Barang</h4>
												</div>
											
											<div class="modal-body">
											
											<!--<form action="/admin/kibbs/upload-file/" method="post" enctype="multipart/form-data">-->
											<form method="post" enctype="multipart/form-data" id = "uploadfiles">
												<div class="col-md-12">
													<label for="idpemdas" >IDPemda</label>
														<input type="hidden" id="inputidpemda" name = "inputidpemda" class="form-control" value="" readonly />							
													<label for="pgw" >Daftar Pegawai</label>
														<select name="pgw" id="pgw" class="form-control">
															<option value="">== Pilih Pegawai ==</option>
															<option value="0">%</option>
															 @foreach($pgw as $pgws)
																<option value="{{ $pgws -> id }}">
																	{{ $pgws->nip.' / '.$pgws->jabatan.' / '.$pgws->nama }}
																</option>
															 @endForeach
														</select>
												<!--</div>
												<div class="col-md-5">-->
													<label for="image" >Upload Foto Barang</label>													
														<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
														<div class="custom-file">
															<input type="file" name="file" class="custom-image-input" id="chooseFile"/>
														</div>
														<button type="submit" name="submit" class="btn btn-info btn-block mt-4">
															Save Files
														</button>
												</div>
												<br/>											
											</div>
											</form>
											<div class="modal-footer">
											
											</div>
											
										</div>
									</div>
								</div>
								
							</div>
						</div>
					</div>
			</div>
		</div>

	</div>
</div>
<div id="loader" class="lds-dual-ring hidden overlay"></div>

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script type="text/javascript">


$(document).ready(function (e) {
	$.ajaxSetup({
		headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$('#uploadfiles').submit(function(e) {
	e.preventDefault();
		var formData = new FormData(this);
		var ids4 = $("#rek4 option:selected").val();
		var ids3 = $("#rek3 option:selected").val();
		var idss = $("#rek2 option:selected").val();
		var ids = $("#rek1 option:selected").val();
		var kond = $("#kond option:selected").val();
		var kdbidang = $("#bidangs option:selected").val();
		var kdunit = $("#units option:selected").val();		
		var kdsub = $("#subs option:selected").val();
		var form = $(this);
		$.ajax({
			type:'POST',
			url:"{{ url(config('laraadmin.adminRoute') . '/kibbs/upload-file') }}",
			data: formData,
			cache:false,
			contentType: false,
			processData: false,
			success: (data) => {
				this.reset();
				$("#addbrg").modal("hide")
				alert('File has been uploaded successfully');
				//console.log(data);
								
				fetch_customer_data();
				function fetch_customer_data(query = '') {
					$('#loader3',form).html('Please wait...');
					jQuery.ajax({
					url:"{{ url(config('laraadmin.adminRoute') . '/loadDatakibbs') }}"+'/'+kdbidang+'/'+kdunit+'/'+kdsub+'/'+ids+'/'+idss+'/'+ids3+'/'+ids4+'/'+kond,
					method: 'GET',
					data: {query: query},
					dataType: 'json',
					beforeSend: function() {
									$('#loader').removeClass('hidden')
								},
					success: function (data) {
					   //console.log(data);
					   $('#tbody1').html(data.table_data);					   
					},
					complete: function(){
						$('#loader').addClass('hidden')
					},
					});
				}
			},
			error: function(data){
				console.log(data);
			}
		});
	});
});

function getInputValue(o){

	document.getElementById("inputidpemda").value = o.value;
	$('#addbrg').modal('show');
}

//reload
function reload(){
	location.reload();
}
//load rek1
jQuery(document).ready(function (){
            jQuery('select[name="bidangs"]').on('change',function(){
               var bidang = jQuery(this).val();
              
               if(bidang){
                  jQuery.ajax({
                     url : '/admin/kibbs_unit/' +bidang,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        //console.log(data);
                        jQuery('select[name="units"]').empty();
						$('select[name="units"]').append('<option value="%">%</option>');
                        jQuery.each(data, function(key,value){
                           $('select[name="units"]').append('<option value="'+ key +'">'+key+ '. '+ value +'</option>');
                        });
                     }
                  });
               }
               else
               {
                  $('select[name="units"]').empty();
               }
            });
    });
//end
//load rek2
jQuery(document).ready(function (){
            jQuery('select[name="units"]').on('change',function(){
				var unit = jQuery(this).val();
			    var bidang = $("#bidangs option:selected").val();
               
               if(unit){				  
                  jQuery.ajax({
                     url : '/admin/kibbs_sub/'+bidang+'/'+unit,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        //console.log(data);
                        jQuery('select[name="subs"]').empty();
						$('select[name="subs"]').append('<option value="%">%</option>');
                        jQuery.each(data, function(key,value){
                           $('select[name="subs"]').append('<option value="'+ key +'">'+key+ '. '+ value +'</option>');
                        });
                     }
                  });
               }else{
                  $('select[name="subs"]').empty();
               } 
            });
    });
//end
//load rek2
jQuery(document).ready(function (){
            jQuery('select[name="subs"]').on('change',function(){
				var unit = jQuery(this).val();
				var bidang = $("#bidangs option:selected").val();
				var unit = $("#units option:selected").val();
			    var sub = $("#subs option:selected").val();
               
               if(unit){				  
                  jQuery.ajax({
                     url : '/admin/kibbs_upb/'+bidang+'/'+unit+'/'+sub,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        //console.log(data);
                        jQuery('select[name="upbs"]').empty();
						$('select[name="upbs"]').append('<option value="%">%</option>');
                        jQuery.each(data, function(key,value){
                           $('select[name="upbs"]').append('<option value="'+ key +'">'+key+ '. '+ value +'</option>');
                        });
                     }
                  });
               }else{
                  $('select[name="upbs"]').empty();
               } 
            });
    });
//end

//load rek1
jQuery(document).ready(function (){
            jQuery('select[name="rek0"]').on('change',function(){
               var rekening0 = jQuery(this).val();
              
               if(rekening0){
                  jQuery.ajax({
                     url : '/admin/daftar_barang_rek1/' +rekening0,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        //console.log(data);
                        jQuery('select[name="rek1"]').empty();
						$('select[name="rek1"]').append('<option value="%">%</option>');
                        jQuery.each(data, function(key,value){
                           $('select[name="rek1"]').append('<option value="'+ key +'">'+key+ '. '+ value +'</option>');
                        });
                     }
                  });
               }
               else
               {
                  $('select[name="rek1"]').empty();
               }
            });
    });
//end
//load rek2
jQuery(document).ready(function (){
            jQuery('select[name="rek1"]').on('change',function(){
				var rekening1 = jQuery(this).val();
			    var rekening0 = $("#rek0 option:selected").val();
               
               if(rekening1){				  
                  jQuery.ajax({
                     url : '/admin/daftar_barang_rek2/' +rekening0+'/'+rekening1,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        //console.log(data);
                        jQuery('select[name="rek2"]').empty();
						$('select[name="rek2"]').append('<option value="%">%</option>');
                        jQuery.each(data, function(key,value){
                           $('select[name="rek2"]').append('<option value="'+ key +'">'+key+ '. '+ value +'</option>');
                        });
                     }
                  });
               }else{
                  $('select[name="rek2"]').empty();
               } 
            });
    });
//end
//load rek3
jQuery(document).ready(function (){
            jQuery('select[name="rek2"]').on('change',function(){
				var rekening2 = jQuery(this).val();
				var rekening1 = $("#rek1 option:selected").val();
			    var rekening0 = $("#rek0 option:selected").val();
               
               if(rekening1){				  
                  jQuery.ajax({
                     url : '/admin/daftar_barang_rek3/' +rekening0+'/'+rekening1+'/'+rekening2,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        //console.log(data);
                        jQuery('select[name="rek3"]').empty();
						$('select[name="rek3"]').append('<option value="%">%</option>');
                        jQuery.each(data, function(key,value){
                           $('select[name="rek3"]').append('<option value="'+ key +'">'+key+ '. '+ value +'</option>');
                        });
                     }
                  });
               }else{
                  $('select[name="rek2"]').empty();
               } 
            });
    });
//end
jQuery(document).ready(function (){
            jQuery('select[name="rek3"]').on('change',function(){
				var rekening3 = jQuery(this).val();
				var rekening2 = $("#rek2 option:selected").val();
				var rekening1 = $("#rek1 option:selected").val();
			    var rekening0 = $("#rek0 option:selected").val();
               
               if(rekening1){				  
                  jQuery.ajax({
                     url : '/admin/daftar_barang_rek4/'+rekening0+'/'+rekening1+'/'+rekening2+'/'+rekening3,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        //console.log(data);
                        jQuery('select[name="rek4"]').empty();
						$('select[name="rek4"]').append('<option value="%">%</option>');
                        jQuery.each(data, function(key,value){
                           $('select[name="rek4"]').append('<option value="'+ key +'">'+key+ '. '+ value +'</option>');
                        });
                     }
                  });
               }else{
                  $('select[name="rek3"]').empty();
               } 
            });
    });
//end
	jQuery(document).ready(function () {						
		jQuery(document).on('click', '#showbrg', function(e){
				var ids4 = $("#rek4 option:selected").val();
				var ids3 = $("#rek3 option:selected").val();
				var idss = $("#rek2 option:selected").val();
				var ids = $("#rek1 option:selected").val();
				var kond = $("#kond option:selected").val();
				var kdbidang = $("#bidangs option:selected").val();
				var kdunit = $("#units option:selected").val();		
				var kdsub = $("#subs option:selected").val();
				var form = $(this);				
            fetch_customer_data();

            function fetch_customer_data(query = '') {
				$('#loader3',form).html('Please wait...');
                jQuery.ajax({
				//url:'/admin/loadDatakibbs/'+kdbidang+'/'+kdunit+'/'+kdsub+'/'+ids+'/'+idss+'/'+ids3+'/'+ids4+'/'+kond,
				url:"{{ url(config('laraadmin.adminRoute') . '/loadDatakibbs') }}"+'/'+kdbidang+'/'+kdunit+'/'+kdsub+'/'+ids+'/'+idss+'/'+ids3+'/'+ids4+'/'+kond,
				method: 'GET',
				data: {query: query},
				dataType: 'json',
				beforeSend: function() {
								$('#loader').removeClass('hidden')
							},
				success: function (data) {
				   //console.log(data);
				   $('#tbody1').html(data.table_data);					   
				},
				complete: function(){
					$('#loader').addClass('hidden')
				},
                });
            }
			
			

            $(document).on('keyup', '#search', function () {
                var query = $(this).val();
                fetch_customer_data(query);				
            });		
        });
	});
	
	jQuery(document).ready(function () {						
		jQuery(document).on('click', '#showbrgupb', function(e){
				var ids4 = $("#rek4 option:selected").val();
				var ids3 = $("#rek3 option:selected").val();
				var idss = $("#rek2 option:selected").val();
				var ids = $("#rek1 option:selected").val();
				var kond = $("#kond option:selected").val();
				var kdbidang = $("#bidangs option:selected").val();
				var kdunit = $("#units option:selected").val();		
				var kdsub = $("#subs option:selected").val();
				var kdupb = $("#upbs option:selected").val();
				var form = $(this);				
            fetch_customer_data();

            function fetch_customer_data(query = '') {
				$('#loader3',form).html('Please wait...');
                jQuery.ajax({
				//url:'/admin/loadDatakibbs/'+kdbidang+'/'+kdunit+'/'+kdsub+'/'+ids+'/'+idss+'/'+ids3+'/'+ids4+'/'+kond,
				url:"{{ url(config('laraadmin.adminRoute') . '/loadDatakibbsupb') }}"+'/'+kdbidang+'/'+kdunit+'/'+kdsub+'/'+kdupb+'/'+ids+'/'+idss+'/'+ids3+'/'+ids4+'/'+kond,
				method: 'GET',
				data: {query: query},
				dataType: 'json',
				beforeSend: function() {
								$('#loader').removeClass('hidden')
							},
				success: function (data) {
				   //console.log(data);
				   $('#tbody1').html(data.table_data);					   
				},
				complete: function(){
					$('#loader').addClass('hidden')
				},
                });
            }
			
			

            $(document).on('keyup', '#search', function () {
                var query = $(this).val();
                fetch_customer_data(query);				
            });		
        });
	});
	
	jQuery(document).ready(function () {						
			jQuery(document).on('click', '#csvbrg', function(e){
					var ids4 = $("#rek4 option:selected").val();
					var ids3 = $("#rek3 option:selected").val();
					var idss = $("#rek2 option:selected").val();
					var ids = $("#rek1 option:selected").val();
					var kond = $("#kond option:selected").val();
					var kdbidang = $("#bidangs option:selected").val();
					var kdunit = $("#units option:selected").val();		
					var kdsub = $("#subs option:selected").val();						
				fetch_customer_data();

				function fetch_customer_data(query = '') {
					jQuery.ajax({
					//url:'/admin/loadDatakibbs/'+kdbidang+'/'+kdunit+'/'+kdsub+'/'+ids+'/'+idss+'/'+ids3+'/'+ids4+'/'+kond,
					url:"{{ url(config('laraadmin.adminRoute') . '/csvkibball') }}"+'/'+kdbidang+'/'+kdunit+'/'+kdsub+'/'+ids+'/'+idss+'/'+ids3+'/'+ids4+'/'+kond,
					method: 'GET',
					data: {query: query},
					dataType: 'json',
					beforeSend: function() {
									$('#loader').removeClass('hidden')
								},
					success: function(result) {
						window.location.href = "{{ url(config('laraadmin.adminRoute') . '/csvkibball') }}"+'/'+kdbidang+'/'+kdunit+'/'+kdsub+'/'+ids+'/'+idss+'/'+ids3+'/'+ids4+'/'+kond;
					},
					complete: function(){
						$('#loader').addClass('hidden')
					},
					error: function(result) {
						window.location.href = "{{ url(config('laraadmin.adminRoute') . '/csvkibball') }}"+'/'+kdbidang+'/'+kdunit+'/'+kdsub+'/'+ids+'/'+idss+'/'+ids3+'/'+ids4+'/'+kond;
					}
					});
				}
				
				

				$(document).on('keyup', '#search', function () {
					var query = $(this).val();
					fetch_customer_data(query);				
				});		
			});
	});
	
	jQuery(document).ready(function () {						
			jQuery(document).on('click', '#csvbrgupb', function(e){
					var ids4 = $("#rek4 option:selected").val();
					var ids3 = $("#rek3 option:selected").val();
					var idss = $("#rek2 option:selected").val();
					var ids = $("#rek1 option:selected").val();
					var kond = $("#kond option:selected").val();
					var kdbidang = $("#bidangs option:selected").val();
					var kdunit = $("#units option:selected").val();		
					var kdsub = $("#subs option:selected").val();
					var kdupb = $("#upbs option:selected").val();					
				fetch_customer_data();

				function fetch_customer_data(query = '') {
					jQuery.ajax({
					//url:'/admin/loadDatakibbs/'+kdbidang+'/'+kdunit+'/'+kdsub+'/'+ids+'/'+idss+'/'+ids3+'/'+ids4+'/'+kond,
					url:"{{ url(config('laraadmin.adminRoute') . '/csvkibballupb') }}"+'/'+kdbidang+'/'+kdunit+'/'+kdsub+'/'+kdupb+'/'+ids+'/'+idss+'/'+ids3+'/'+ids4+'/'+kond,
					method: 'GET',
					data: {query: query},
					dataType: 'json',
					beforeSend: function() {
									$('#loader').removeClass('hidden')
								},
					success: function(result) {
						window.location.href = "{{ url(config('laraadmin.adminRoute') . '/csvkibballupb') }}"+'/'+kdbidang+'/'+kdunit+'/'+kdsub+'/'+kdupb+'/'+ids+'/'+idss+'/'+ids3+'/'+ids4+'/'+kond;
					},
					complete: function(){
						$('#loader').addClass('hidden')
					},
					error: function(result) {
						window.location.href = "{{ url(config('laraadmin.adminRoute') . '/csvkibballupb') }}"+'/'+kdbidang+'/'+kdunit+'/'+kdsub+'/'+kdupb+'/'+ids+'/'+idss+'/'+ids3+'/'+ids4+'/'+kond;
					}
					});
				}
				
				

				$(document).on('keyup', '#search', function () {
					var query = $(this).val();
					fetch_customer_data(query);				
				});		
			});
	});
	
	
	jQuery(document).ready(function () {						
		jQuery(document).on('click', '#pdfbrg', function(e){
				var ids4 = $("#rek4 option:selected").val();
				var ids3 = $("#rek3 option:selected").val();
				var idss = $("#rek2 option:selected").val();
				var ids = $("#rek1 option:selected").val();
				var kond = $("#kond option:selected").val();
				var kdbidang = $("#bidangs option:selected").val();
				var kdunit = $("#units option:selected").val();		
				var kdsub = $("#subs option:selected").val();						
            fetch_customer_data();

            function fetch_customer_data(query = '') {
                jQuery.ajax({
				//url:'/admin/loadDatakibbs/'+kdbidang+'/'+kdunit+'/'+kdsub+'/'+ids+'/'+idss+'/'+ids3+'/'+ids4+'/'+kond,
				url:"{{ url(config('laraadmin.adminRoute') . '/printkibball') }}"+'/'+kdbidang+'/'+kdunit+'/'+kdsub+'/'+ids+'/'+idss+'/'+ids3+'/'+ids4+'/'+kond,
				method: 'GET',
				data: {query: query},
				dataType: 'json',
				beforeSend: function() {
								$('#loader').removeClass('hidden')
							},
				success: function(result) {
					window.location.href = "{{ url(config('laraadmin.adminRoute') . '/printkibball') }}"+'/'+kdbidang+'/'+kdunit+'/'+kdsub+'/'+ids+'/'+idss+'/'+ids3+'/'+ids4+'/'+kond;
				},
				complete: function(){
					$('#loader').addClass('hidden')
				},
				error: function(result) {
					window.location.href = "{{ url(config('laraadmin.adminRoute') . '/printkibball') }}"+'/'+kdbidang+'/'+kdunit+'/'+kdsub+'/'+ids+'/'+idss+'/'+ids3+'/'+ids4+'/'+kond;
				}
                });
            }

			

            $(document).on('keyup', '#search', function () {
                var query = $(this).val();
                fetch_customer_data(query);				
            });		
        });
	});
//endsearch

</script>
@endpush
