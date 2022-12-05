@extends("la.layouts.app")

@section("contentheader_title", "KIB C")
@section("contentheader_description", "Gedung & Bangunan")
@section("section", "Kibc_s")
@section("sub_section", "Listing")
@section("htmlheader_title", "List Gedung & Bangunan")
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
	<li class=""><a role="tab" data-toggle="tab" href="#listdatagedung" data-target="#tab-timeline"><i class="fa fa-clock-o"></i>Lists Gedung dan Bangunan</a></li>
	<!--<li class=""><a role="tab" data-toggle="tab" href="#dokumenimb" data-target="#tab-timeline1"><i class="fa fa-building"></i>Dokumen IMB</a></li>-->
	
</ul>
<div class="tab-content">
	<div role="tabpanel" class="tab-pane active fade in " id="tab-info">
		<!--kotak kotak-->
		<div class="tab-content">
			<div class="panel infolist">					
				<div class="row">
					<div class="col-lg-2 col-xs-6">
						<!-- small box -->
						<div class="small-box bg-aqua">
							<div class="inner">
								<h3>{{ $gedung}}</h3>
								<p>Total Gedung dan Bangunan</p>
							</div>
							<div class="box-body">							
							</div>	
							<div class="icon">
								<i class="fa fa-building"></i>
							</div>								
							<a href="#" class="small-box-footer">
								Download
							</a>
						</div>							
					</div>
					<div class="col-lg-2 col-xs-6">
						<div class="small-box bg-green">
							<div class="inner">
								<h3>{{ $gedungbeli }}</h3>
								<p>Total Gedung & Bangunan Pembelian</p>
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
								<h3>{{ $gedunghibah }}</h3>
								<p>Total Gedung & Bangunan Hibah</p>
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
								<h3>{{ $dokumenempty }}</h3>
								<p>No. Dokumen Belum Diisi</p>
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
								<h3>{{ $dokumennotempty }}</h3>
								<p>Nomor Dokumen Sudah Diisi</p>
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
								<h3>{{ $dokumenupload }}</h3>
								<p>IMB Di Upload</p>
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
								<h3>{{ $fotoupload }}</h3>
								<p>Foto Uploaded</p>
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
								<h3>{{ $gedungkantor }}</h3>
								<p>Gedung dan Bangunan Kantor</p>
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
								<h3>{{ $gedungpinjam }}</h3>
								<p>Gedung & Bangunan Pinjam Pakai</P>
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
								<h3>{{ $gedungidle }}</h3>
								<p>Gedung dan Bangunan Idle</p>
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
		<!--end kotak kotak-->
		<div class="tab-content">
			<div class="panel infolist">
				<div id="" class="table-responsive ">
					<h2>Keterangan</h2>
					<table id="" class="table-bordered table-striped tableFixHead" >
						<thead>
							<tr class="bg-aqua">
								<th>No.</th>
								<th>Kd Bidang</th>									
								<th>Kd Unit</th>									
								<th>Kd Sub</th>																
								<th>Kd UPB</th>																
								<th style="width:30%">Dept</th>																							
								<th>Total Gedung</th>
								<th>Total Bangunan</th>														
								<th>No. Dokumen Diisi</th>							
								<th>No. Dokumen Tidak Diisi</th>													
								<th>Tgl Dokumen Diisi</th>							
								<th>Tgl Dokumen Tidak Diisi</th>							
								<th>IMB Diupload</th>																				
								<th>Foto KIBC Diupload</th>																					
								<!-- <th>Verif Geo</th> -->
							</tr>
						</thead>
						<tbody id = "#">	
							@foreach ($gedungcount as $index =>$gedungcounts)
							<tr >
								<td>{{ $index + 1 }}</td>
								<td>{{ $gedungcounts->kd_bidang }}</td>
								<td>{{ $gedungcounts->kd_unit }}</td>
								<td>{{ $gedungcounts->kd_sub }}</td>
								<td>{{ $gedungcounts->kd_upb }}</td>
								<td style="width:30%">{{ $gedungcounts->name }}</td>
								<td style="text-align: center">{{ $gedungcounts->gedungtot }}</td>
								<td style="text-align: center">{{ $gedungcounts->gedung }}</td>
								<td style="text-align: center">{{ $gedungcounts->dokumenisi }}</td>
								<td style="text-align: center">{{ $gedungcounts->dokumennotisi }}</td>
								<td style="text-align: center">{{ $gedungcounts->tgldokisi}}</td>
								<td style="text-align: center">{{ $gedungcounts->tgldoknotisi }}</td>
								<td style="text-align: center">{{ $gedungcounts->imbisi}}</td>
								<td style="text-align: center">{{ $gedungcounts->fotoisi }}</td>

							</tr>
							@endforeach														
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!--Gedung dan Bangunan-->
	<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="tab-timeline">
		<div class="timeline-item">
			<div class="form-group" class = "col-sm-12">
				<div class="col-md-3">
					<label for="bidangs">Bidang</label>
					<select name="bidangs" id="bidangs" class="form-control">
						<option value="">== Pilih Bidang ==</option>
						<option value="%">%</option>
						@foreach($refbidang as $refbidangs1)
						<option value="{{ $refbidangs1 -> kd_bidang }}">
							{{ $refbidangs1->kd_bidang.'.'.$refbidangs1->nm_bidang }}
						</option>
						@endForeach
					</select>					
				</div>
				<div class="col-md-3">
					<label for="unit" >Unit</label>
					<select name="units" id="units" class="form-control">
						<option value="">== Pilih Unit ==</option>
						<option value="%">%</option>
					</select>
				</div>
				<div class="col-md-2">
					<label for="sub" >Sub</label>
					<select name="subs" id="subs" class="form-control">
						<option value="">== Pilih Sub ==</option>
						<option value="%">%</option>
					</select>
				</div>
				<div class="col-md-3">
					<label for="upb" >Upb</label>
					<select name="upbs" id="upbs" class="form-control">
						<option value="">== Pilih UPB ==</option>
						<option value="%">%</option>
					</select>
				</div>
				<div class="col-md-2">
				
					<button id = "showbrg" class="btn btn-success btn-md" >Show ALL</button>
				</div>
			</div>
		</br>
		<div class="panel-default panel-heading">

		</div>

	</br>
	<br>
	</br>
		<div class="box box-success" >
			<div class="form-group" >
				<input type="text" name="search" id="search1" class="form-control" placeholder="Masukkan nama SKPD/Lokasi" />
			</div>

			<div class="form-group ">
				<h4>Print List</h4>	
				<form id = "getprintsoloform" method="POST" action="printsologedung" accept-charset="UTF-8" class = "col-sm-6">
					<input name="_token" type="hidden" value="{{ csrf_token() }}">						
					<div class="input-group">
						<input type="text" name="search1" id="search1" class="form-control" placeholder="Cari.." readonly />
						<span class="input-group-btn">															
							<button class="btn btn-success" type="submit" id= "getprintsologedung" onclick = "dellastchar()">
								<i class="fa fa-print"></i>
							</button>																									
						</span>
					</div>
				</form>
				<div class="input-group" class = "col-sm-6">
					<span class="input-group-btn">	
						<button class="btn btn-primary" type="submit" id= "printsologedung" onclick = "validate()">
							GET
						</button>
						<button class="btn btn-warning" type="submit" onclick="cleartxt()">
							<i class="fa fa-undo"></i>
						</button>
					</div>
				</div>

				<div class="box-body table-responsive ">
					<table id="example1" class="table table-bordered table-striped tableFixHead ">
						<thead>
							<tr class="bg-aqua">
								<th>Id.</th>
								<th>SKPD</th>	
								<th>ID Pemda</th>		
								<th>Koord X</th>							
								<th>Koord Y</th>							
								<th>Tgl Perolehan</th>							
								<th>Tgl Dokumen</th>							
								<th>No. Dokumen</th>							
								<th>Lokasi</th>							
								<th>Status Tanah</th>																	
								<th>Penggunaan</th>
								<th>Harga</th>
								<th>Kondisi</th>
								<th>Pemanfaatan</th>																			
								<th>Foto Gedung</th>																
								<th>Action</th>
								<th>Verifikasi</th>						
							</tr>
						</thead>
						<tbody id= "tbody2">	
							
						</tbody>
					</table>
				</div>
				<!--upload foto-->
				<div class="modal fade" id="addbrg" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button  type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel"><strong>Upload Foto</strong></h4s>
							</div>

							<div class="modal-body">
								<!--<form action="/admin/kibcs/upload-file/" method="post" enctype="multipart/form-data">-->
									<form method="post" enctype="multipart/form-data" id = "uploadfiles">
										<div class="col-md-5">
											<label for="idpemda" >ID</label>
											<input type="text" id="inputidpemda" name = "inputidpemda" class="form-control" value="" readonly />
											<p><strong>*Hanya file jpg,png,dan pdf yang kami terima!
														<br>Batas Upload File Maksimal 2 MB</strong></P>
										</div>
										<div class="col-md-5">
											<label for="image" >Upload Foto Gedung & Bangunan</label>													
											<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
											<div class="custom-file">
												<input type="file" name="file" class="custom-image-input" id="chooseFile"/>
											</div>
										</div>
										<br>
										<button type="submit" name="submit" class="btn btn-info btn-block mt-4">
												Update Files
										</button>
									</div>
									</form>
									<div class="modal-footer">
											
									</div>
								</div>
							</div>
				</div>
				<!---hapus foto----->
				<div class="modal fade" id="hapus" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button  type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h3 class="modal-title" id="myModalLabel"><strong>Hapus Foto</strong></h3>
							</div>

							<div class="modal-body">
								<!--<form action="/admin/kibcs/upload-file/" method="post" enctype="multipart/form-data">-->
									<form method="get" enctype="multipart/form-data" id = "hapusfile">
										<h4 align="center"><strong>Apakah Anda yakin ingin menghapus file ini?</strong></h4>
										<button type="submit" name="submit" class="btn btn-danger btn-block mt-4">
												Hapus File
										</button>
									</div>
									</form>
									<div class="modal-footer">
											
									</div>
								</div>
						</div>
				</div>
				<!----->

			</div>
		</div>
     </div>

					<!--urusanIMB-->
					<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="tab-timeline1">
						<div class="timeline-item">
							<div class="box box-success">
								<div class="form-group" >
									<h4>Lokasi Gedung</h4>
									<input type="text" name="search" id="search2" class="form-control" placeholder="Masukkan nama SKPD/Lokasi" />
								</div>

								<div class="form-group ">
									<h4>Print List</h4>	
									<form id = "getprintsoloform" method="POST" action="printsoloimb" accept-charset="UTF-8" class = "col-sm-6">
										<input name="_token" type="hidden" value="{{ csrf_token() }}">						
										<div class="input-group">
											<input type="text" name="searchsoloimb" id="searchsoloimb" class="form-control" placeholder="Cari.." readonly />
											<span class="input-group-btn">															
												<button class="btn btn-success" type="submit" id= "getprintsoloimb" onclick = "dellastchar()">
													<i class="fa fa-print"></i>
												</button>																									
											</span>
										</div>
									</form>
									<div class="input-group" class = "col-sm-6">
										<span class="input-group-btn">	
											<button class="btn btn-primary" type="submit" id= "printsoloimb" onclick = "validate()">
												GET
											</button>
											<button class="btn btn-warning" type="submit" onclick="cleartxt()">
												<i class="fa fa-undo"></i>
											</button>
										</span>
									</div>
								</div>

								<div class="box-body table-responsive tableFixHead">
									<table id="example1" class="table table-bordered table-striped ">
										<thead>
											<tr class="bg-aqua">
												<th>Id.</th>
												<th>SKPD</th>	
												<th>ID Pemda</th>		
												<th>No. IMB Lama</th>							
												<th>No. IMB Baru</th>							
												<th>Tgl Perolehan</th>						
												<th>Lokasi</th>							
												<th>Asal-Usul</th>
												<th>Kondisi</th>
												<th>Penggunaan</th>
												<th>Pemanfaatan</th>																			
												<th>Tanggal Terbit IMB</th>
												<th>Tanggal Akhir IMB</th>
												<th>Dokumen IMB</th>																		
												<th>Action</th>						
											</tr>
										</thead>
										<tbody id= "tbody3">	

										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="tab-timeline2">
						<div class="timeline-item">
						</br>
						<div class="form-group" class = "col-sm-4">
							<div class="col-md-12">
								<label for="alamat" >Alamat/Luas</label>
								<input type="text" name="search" id="search" class="form-control" placeholder="Cari.." />
							</div>	
						</div>
						
						<div class="form-group " class = "col-sm-5">
							<div class="col-md-12">
								<label for="print" >Print List</label>
							</div>
							<div class="col-md-12">
								<form id = "getprintsoloform" method="POST" action="printsolotanah" accept-charset="UTF-8" class = "col-sm-6">
									<input name="_token" type="hidden" value="{{ csrf_token() }}">						
									<div class="input-group">
										<input type="text" name="searchsolo" id="searchsolo" class="form-control" placeholder="Print.." readonly />
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
						</div>

					</div>

					<div class="box-body table-responsive tableFixHead">
						<table class="table table-bordered table-striped">
							<thead>
								<tr class="bg-aqua">
									<th>No.</th>
									<th>Dept</th>																							
									<th>No.Reg</th>							
									<th>Luas/M2</th>							
									<th>Hak Tanah</th>							
									<th>Tgl Sert</th>							
									<th>No. Sert</th>							
									<th>Alamat</th>							
									<th>Tgl Perolehan</th>							
									<th>Thn Perolehan</th>							
									<th>Penggunaan</th>							
									<th>Harga</th>																			
									<th>Sert File</th>																			
									<th>Photo Tanah</th>																			
									<th>Rack No</th>																			
									<th>Storage Name</th>																			
									<th>Pemanfaatan</th>																			
									<th>Validation</th>																		
									<th>Action</th>																			
								</tr>
							</thead>
							<tbody id= "tbody4">	

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

	</div>
<div id="loader" class="lds-dual-ring hidden overlay"></div>
	@endsection

	@push('scripts')
	<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
	<script type="text/javascript">
//start
$(document).ready(function (e) {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$('#uploadfiles').submit(function(e) {
		e.preventDefault();
		var formData = new FormData(this);
		//var ids4 = $("#rek4 option:selected").val();
		//var ids3 = $("#rek3 option:selected").val();
		//var idss = $("#rek2 option:selected").val();
		//var ids = $("#rek1 option:selected").val();
		//var kond = $("#kond option:selected").val();
		var kdbidang = $("#bidangs option:selected").val();
		var kdunit = $("#units option:selected").val();		
		var kdsub = $("#subs option:selected").val();
		var kdupb = $("#upbs option:selected").val();
		var form = $(this);
		$.ajax({
			type:'POST',
			url:"{{ url(config('laraadmin.adminRoute') . '/kibc_s/upload-file') }}",
			data: formData,
			cache:false,
			contentType: false,
			processData: false,
			success: (data) => {
				this.reset();
				$("#addbrg").modal("hide")
				alert('Selamat! File berhasil di upload');
				//console.log(data);

				fetch_customer_data();
				function fetch_customer_data(query = '') {
					//$('#loader3',form).html('Please wait...');
					jQuery.ajax({
					//url:'/admin/loadDatakibbs/'+kdbidang+'/'+kdunit+'/'+kdsub+'/'+ids+'/'+idss+'/'+ids3+'/'+ids4+'/'+kond,
					url:"{{ url(config('laraadmin.adminRoute') . '/kibc_scari') }}"+'/'+kdbidang+'/'+kdunit+'/'+kdsub+'/'+kdupb,
					method: 'GET',
					data: {query: query},
					dataType: 'json',
					beforeSend: function() {
									$('#loader').removeClass('hidden')
								},
					success: function (data) {
					   //console.log(data);
					   $('#tbody2').html(data.table_data);					   
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
	
	///////////////hapus file


//
});

/*edit function*/
/*end edut function*/
	//upload function"an
	function getInputValue(o){
		document.getElementById("inputidpemda").value = o.value;
		$('#addbrg').modal('show');
	}
	//////hapus foto
	function delidpemda(clicked_id){

	var id =  clicked_id;
		

			$.ajax({
			url : '/admin/hapus/'+id,
			headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
			method: 'GET',						
			dataType: 'json',
			success: function (data) {	
				location.reload();
				document.getElementById(clicked_id).disabled = true;
			}
		}).fail(function(){
			//console.log('failed');
			location.reload();
			document.getElementById(clicked_id).disabled = true;
		});
	}

	
	//endhapusfoto
	function reload(){
		location.reload();
	}
	//short1
	jQuery(document).ready(function (){
		jQuery('select[name="bidangs"]').on('change',function(){
			var bidang = jQuery(this).val();

			if(bidang){
				jQuery.ajax({
					url : '/admin/kibc_s_unit/' +bidang,
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
    //end short1
//short 2
jQuery(document).ready(function (){
	jQuery('select[name="units"]').on('change',function(){
		var unit = jQuery(this).val();
		var bidang = $("#bidangs option:selected").val();

		if(unit){				  
			jQuery.ajax({
				url : '/admin/kibc_s_sub/'+bidang+'/'+unit,
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
//end short2
//shortupb
jQuery(document).ready(function (){
            jQuery('select[name="subs"]').on('change',function(){
				var unit = jQuery(this).val();
				var bidang = $("#bidangs option:selected").val();
				var unit = $("#units option:selected").val();
			    var sub = $("#subs option:selected").val();
               
               if(unit){				  
                  jQuery.ajax({
                     url : '/admin/kibc_s_upb/'+bidang+'/'+unit+'/'+sub,
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
///endshortupb
//shwbrg kibc
jQuery(document).ready(function () {						
	jQuery(document).on('click', '#showbrg', function(e){
		//var ids4 = $("#rek4 option:selected").val();
		//var ids3 = $("#rek3 option:selected").val();
		//var idss = $("#rek2 option:selected").val();
		//var ids = $("#rek1 option:selected").val();
		//var kond = $("#kond option:selected").val();
		var kdbidang = $("#bidangs option:selected").val();
		var kdunit = $("#units option:selected").val();		
		var kdsub = $("#subs option:selected").val();
		var kdupb = $("#upbs option:selected").val();		
		fetch_customer_data();

		function fetch_customer_data(query = '') {
			jQuery.ajax({
				//url:'/admin/loadDatakibbs/'+kdbidang+'/'+kdunit+'/'+kdsub+'/'+ids+'/'+idss+'/'+ids3+'/'+ids4+'/'+kond,
				url:"{{ url(config('laraadmin.adminRoute') . '/kibc_scari') }}"+'/'+kdbidang+'/'+kdunit+'/'+kdsub+'/'+kdupb,
				method: 'GET',
				data: {query: query},
				dataType: 'json',
				success: function (data) {
				   //console.log(data);
				   $('#tbody2').html(data.table_data);					   
				}
			});
		}
		
		

		$(document).on('keyup', '#search1', function () {
			var query = $(this).val();
			fetch_customer_data(query);				
		});		
	});
});
//end shwbrg
//search
/* jQuery(document).ready(function () {						
	jQuery(document).on('click', '#showbrg', function(e){
		//var ids4 = $("#rek4 option:selected").val();
		//var ids3 = $("#rek3 option:selected").val();
		//var idss = $("#rek2 option:selected").val();
		//var ids = $("#rek1 option:selected").val();
		//var kond = $("#kond option:selected").val();
		var kdbidang = $("#bidangs option:selected").val();
		var kdunit = $("#units option:selected").val();		
		var kdsub = $("#subs option:selected").val();						
		fetch_customer_data();

		function fetch_customer_data(query = '') {
			jQuery.ajax({
				//url:'/admin/loadDatakibbs/'+kdbidang+'/'+kdunit+'/'+kdsub+'/'+ids+'/'+idss+'/'+ids3+'/'+ids4+'/'+kond,
				url:"{{ url(config('laraadmin.adminRoute') . '/imb_load') }}"+'/'+kdbidang+'/'+kdunit+'/'+kdsub,
				method: 'GET',
				data: {query: query},
				dataType: 'json',
				success: function (data) {
				   //console.log(data);
				   $('#tbody3').html(data.table_data);					   
				}
			});
		}
		
		

		$(document).on('keyup', '#search2', function () {
			var query = $(this).val();
			fetch_customer_data(query);				
		});		
	});
}); */

//searchimb------------------------------->09/09/2021
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
//export to csv

</script>
@endpush
