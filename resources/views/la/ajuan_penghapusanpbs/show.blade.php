@extends('la.layouts.app')

@section('htmlheader_title')
	Ajuan penghapusanpb View
@endsection


@section('main-content')
<div id="page-content" class="profile2">
	<div class="bg-primary clearfix">
	
	</div>

	<ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
		<li class="active"><a href="{{ url(config('laraadmin.adminRoute') . '/ajuan_penghapusanpbs') }}" data-toggle="tooltip" data-placement="right" title="Back to Ajuan penghapusanpbs"><i class="fa fa-chevron-left"></i></a></li>
		<li class=""><a role="tab" data-toggle="tab" class="active" href="#tab-general-info" data-target="#tab-info"><i class="fa fa-bars"></i> General Info</a></li>
		<li class=""><a role="tab" data-toggle="tab" href="#tab-timeline" data-target="#tab-timeline"><i class="fa fa-clock-o"></i> Timeline</a></li>
	</ul>

	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active fade in" id="tab-info">		
			<div class="tab-content">
				<div class="panel infolist">
					<div class="panel-default panel-heading">
						<div class="box-body table-responsive">
							<div class="col-md-3">	
								<div class="alert alert-success">														
									  <h4> Nama UPB Pengusul : </h4> <i> {{ $ajuan_penghapusanpb->nm_opd }}</i>
									  <h4> Nama Ka. UPB Pengusul : </h4> <i> {{ $ajuan_penghapusanpb->nm_pimpinan }}</i>
									  <h4> NIP Ka. UPB Pengusul : </h4> <i> {{ $ajuan_penghapusanpb->nip_pimpinan }}</i>
									  <h4> Jabatan Ka. OPD Pengusul : </h4> <i> {{ $ajuan_penghapusanpb->jbt_pimpinan }}</i> 													
									  <h4> Jenis Ajuan : </h4> <i> {{ $ajuan_penghapusanpb->jenis_ajuan }}</i> 												
								</div>
							</div>
							<div class="col-md-3">								
								<div class="alert alert-info">
								<h4> Proses</h4>
									@if($ajuan_penghapusanpb->validation_aset != 0 )
										<button type="button" class="btn btn-primary " data-dismiss="modal" disabled>Telah diajukan Ke Bidang Aset</button>
									@else
										<button type="button" class="btn btn-danger " data-dismiss="modal" disabled>Belum diajukan Ke Bidang Aset</button>									
									@endif
								</div>
							</div>
							<div class="col-md-3">
								<div class="alert alert-success">
									@if($ajuan_penghapusanpb->surat_persetujuan != '')
									@foreach ($ajnphp as $index =>$ajnphp)
									<br/>
									<label> Surat Usulan </label>
									<br/>	
									<label for="no_surat">No_Surat* :</label>
									<input class="form-control" placeholder="Enter No_Surat" data-rule-maxlength="256" required="1" name="no_surat" type="text" value="{{$ajuan_penghapusanpb->no_surat}}" readonly>
									<label for="perihal">Tgl_Surat :</label>
									<input class="form-control" placeholder="Enter Tgl Surat" data-rule-maxlength="256" required="1" name="tgl_surat" type="text" value="{{ $ajuan_penghapusanpb->tgl_surat }}" readonly>								
									<label for="perihal">Perihal :</label>
									<input class="form-control" placeholder="Enter Perihal" data-rule-maxlength="256" required="1" name="perihal" type="text" value="{{$ajuan_penghapusanpb->perihal}}" readonly>
									<div class="btn-group" role="group" aria-label="Basic example">	
											<button class="btn btn-success" onclick=" window.open('{{url('/storage/php_pb/file/'.$ajnphp->filepdf)}}','_blank')">Preview Surat usulan</button>
									</div>
									<div class="btn-group" role="group" aria-label="Basic example">	
											<button class="btn btn-info" onclick=" window.open('{{url('/admin/printlampiranpbppb/'.$ajnphp->id)}}','_blank')">Preview Lampiran</button>
									</div>
									
										
									@endforeach	
									@else
									@foreach ($ajnphp as $index =>$ajnphp)	
									<br/>
									<label> Surat Usulan </label>
									<br/>	
									<label for="no_surat">No_Surat* :</label>
									<input class="form-control" placeholder="Enter No_Surat" data-rule-maxlength="256" required="1" name="no_surat" type="text" value="{{$ajuan_penghapusanpb->no_surat}}" readonly>
									<label for="perihal">Tgl_Surat :</label>
									<input class="form-control" placeholder="Enter Tgl Surat" data-rule-maxlength="256" required="1" name="tgl_surat" type="text" value="{{ $ajuan_penghapusanpb->tgl_surat }}" readonly>								
									<label for="perihal">Perihal :</label>
									<input class="form-control" placeholder="Enter Perihal" data-rule-maxlength="256" required="1" name="perihal" type="text" value="{{$ajuan_penghapusanpb->perihal}}" readonly>
									<div class="btn-group" role="group" aria-label="Basic example">	
											<button class="btn btn-success" onclick=" window.open('{{url('/storage/php_pb/file/'.$ajnphp->filepdf)}}','_blank')">Preview Surat usulan</button>
									</div>
									<div class="btn-group" role="group" aria-label="Basic example">	
											<button class="btn btn-info" onclick=" window.open('{{url('/admin/printlampiranpbppb/'.$ajnphp->id)}}','_blank')">Preview Lampiran</button>
									</div>
									@endforeach
									@endif
								</div>
							</div>
							<div class="col-md-3">	
								<div class="alert alert-info">																							 
									  <h4> Status Validasi Bidang Aset : </h4> 
										@if($ajuan_penghapusanpb->validation_aset == 1)
											<button type="button" class="btn btn-primary " data-dismiss="modal">Menunggu Validasi Bidang Aset</button>
										@elseif ($ajuan_penghapusanpb->validation_aset == 2)
											<button type="button" class="btn btn-warning" data-dismiss="modal">Validasi Tim Penilai</button>
										@elseif ($ajuan_penghapusanpb->validation_aset == 3)
											<button type="button" class="btn btn-primary" data-dismiss="modal">Permohonan Penghapusan ke Bupati</button>
										@elseif ($ajuan_penghapusanpb->validation_aset == 4)
											<button type="button" class="btn btn-primary" data-dismiss="modal">Barang telah dihapus</button>
										@else
											<button type="button" class="btn btn-primary" data-dismiss="modal">Proses Input PB Pembantu</button>
										@endif							
								</div>
							</div>
							<div class="col-md-12">
							<h4> <span class="bg-purple">Referensi No Ajuan </span></h4>
							<table id="example4" class="table table-bordered table-striped">
								<thead>
									<tr class="bg-purple">
										<th>No.</th>
										<th>Dept</th>															
										<th>No Ajuan</th>															
										<th>Tgl Ajuan</th>							
										<th>Jenis Ajuan</th>																																																																											
										<th>No Surat</th>																																																																											
										<th>Tgl Surat</th>																																																													
										<th>Perihal</th>																																																																																																																																																				
									</tr>
								</thead>
								<tbody id = "tbody4">
								@foreach ($data as $index =>$data)
								<tr>
									<td>{{ $index + 1 }}</td>
									<td>{{ $data->deptname }}</td>
									<td><a href="{{ url(config('laraadmin.adminRoute') . '/ajuan_penghapusanpbs/showpbp/'.$data->id) }}"> {{ $data->no_ajuan}} </a></td>
									<td>{{ date('d-m-Y', strtotime($data->tgl_ajuan)) }}</td>
									<td>{{ $data->jenis_ajuan }}</td>	
									<td>{{ $data->no_surat }}</td>	
									<td>{{ date('d-m-Y', strtotime($data->tgl_surat)) }}</td>
									<td>{{ $data->perihal }}</td>	
									
								</tr>
								@endforeach									
								</tbody>
							</table>
							</div>
						</div>
					</div>
									
				</div>					
			</div>			
		</div>
	</div>
	
		<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="tab-timeline">
			<ul class="timeline timeline-inverse">
			
				<!-- timeline time label -->
				<li class="time-label">													
				</li>
				<li class="time-label">
					<span class="bg-green">
						DAFTAR BARANG
					</span>
				</li>
				<!-- /.timeline-label -->
				<!-- timeline item -->
				<li>
				@if(count($data_a) == 0 )
					<h3 class="timeline-header"><a href="#"></a></h3>
				@else
				<i class="fa fa-map bg-blue"></i>

				<div class="timeline-item">
					<span class="time"><i class="fa fa-clock-o"></i></span>

					<h3 class="timeline-header"><a href="#">TANAH</a></h3>

					<div class="timeline-body">
					<div class="box-body table-responsive">
							<table id="pm" class="table table-bordered table-striped">
							<thead>
							<tr class="bg-aqua">
								<th rowspan="2">No.</th>
								<th rowspan="2">Kode Brg</th>
								<th rowspan="2">No Reg</th>					
								<th rowspan="2">Nama Brg</th>																													
								<th rowspan="2">Luas M2</th>															
								<th colspan="3">Status Tanah</th>															
								<th rowspan="2">Alamat</th>																					
								<th rowspan="2">Thn Perolehan</th>							
								<th rowspan="2">Penggunaan</th>																																																													
								<th rowspan="2">Harga</th>																																																																																																																																																				
								<th rowspan="2">Validation Image</th>																																																																																																																																																				
							 </tr>
							<tr class="bg-aqua">
								<th>Hak</th>
								<th>Tgl</th>
								<th>No</th>
							</tr>
							</thead>
							<tbody id = "pm1">
								@foreach ($data_a as $index =>$data_as)
								<tr>
									<td>{{ $index + 1 }}</td>
									<td>{{ $data_as->kd_barang }}</td>
									<td>{{ $data_as->no_reg }}</td>
									<td>{{ $data_as->Nm_Aset5 }}</td>
									<td>{{ $data_as->Luas_M2 }}</td>
									<td>{{ $data_as->Hak_Tanah }}</td>
									<td>{{ $data_as->Sertifikat_Tanggal }}</td>
									<td>{{ $data_as->Sertifikat_Nomor }}</td>
									<td>{{ $data_as->Alamat }}</td>
									<td>{{ $data_as->tgl_pembelian }}</td>
									<td>{{ $data_as->Penggunaan }}</td>
									<td>{{ $data_as->harga }}</td>
									<td>					
									@if($data_as->validation_img != '')
									<img src="{{url('/storage/php_pb/Image/'.$data_as->imgname)}}" alt="gambar" style="width:150px;height:150px;"/>								
									@else
									<i>no pic</i>
									@endif					
								</td>
								</tr>
								@endforeach	
							</tbody>
							<tfoot>
								<tr>
								@foreach ($data_a_sum as $data_a_sum)
									<td colspan="11" align = "center"><b>TOTAL</B></td>								
									<td><b>{{ $data_a_sum->total }}</b></td>
								@endforeach	
								</tr>
							</tfoot>
							</table>
						</div>
					</div>
				</div>
				@endif
				</li>
				<!-- END timeline item -->
				<!-- timeline item -->
				<li>
				
				<i class="fa fa-wrench bg-orange"></i>

				<div class="timeline-item">
					<span class="time"><i class="fa fa-clock-o"></i></span>

					<h3 class="timeline-header"><a href="#">PERALATAN & MESIN</a></h3>
					<div class="timeline-body">
					<div class="box-body table-responsive">
						<table id="pm" class="table table-bordered table-striped">
							<thead>
							<tr class="bg-aqua">
								<th rowspan="2">No.</th>
								<th rowspan="2">Kode Brg</th>
								<th rowspan="2">No Reg</th>					
								<th rowspan="2">Nama Brg</th>
								<th rowspan="2">Thn Perolehan</th>				
								<th rowspan="2">Merk/Type</th>																																																																
								<th rowspan="2">Bahan</th>								
								<th rowspan="2">Asal Usul</th>																																																																																																																																							
								<th rowspan="2">Harga</th>																																																													
								<th rowspan="2">Nilai Buku</th>																																																													
								<th rowspan="2">KET</th>																																																																																							
								<th rowspan="2">Validation Image</th>																																																																																							
								<th rowspan="2">UPB</th>																																																																																							
							 </tr>
							</thead>
							<tbody id = "pm1">
								@foreach ($data_b as $index =>$data_bs)
								<tr>
									<td>{{ $index + 1 }}</td>
									<td>{{ $data_bs->kd_barang }}</td>
									<td>{{ $data_bs->no_reg }}</td>
									<td>{{ $data_bs->Nm_Aset5 }}</td>
									<td>{{ $data_bs->tgl_pembelian }}</td>
									<td>{{ $data_bs->merk }} - {{ $data_bs->type }}</td>
									<td>{{ $data_bs->bahan }}</td>
									<td>{{ $data_bs->kondisi }}</td>
									<td>{{ $data_bs->harga }}</td>					
									<td>{{ $data_bs->nilaibuku }}</td>
									<td>{{ $data_bs->keterangan }}</td>
									<td>{{ $data_bs->nm_upb }}</td>
									<td>					
									@if($data_bs->validation_img != '')
									<img src="{{url('/storage/php_pb/Image/'.$data_bs->imgname)}}" alt="gambar" style="width:150px;height:150px;"/>								
									@else
									<i>no pic</i>
									@endif					
									</td>
								</tr>								
								@endforeach																
							</tbody>
							<tfoot>
								<tr>
								@foreach ($data_b_sum as $data_b_sum)
									<td colspan="8" align = "center"><b>TOTAL</B></td>								
									<td><b>{{ $data_b_sum->total }}</b></td>
									<td><b>{{ $data_b_sum->totalnilaibuku }}</b></td>
								@endforeach	
								</tr>
							</tfoot>
							</table>
					</div>
					</div>
				</div>
				
				</li>
				<!-- END timeline item -->
				<!-- timeline item -->
				<li>
				@if(count($data_c) == 0 )
					<h3 class="timeline-header"><a href="#"></a></h3>
				@else
				<i class="fa fa-building bg-green"></i>

				<div class="timeline-item">
					<h3 class="timeline-header"><a href="#">GEDUNG & BANGUNAN</a></h3>

					<div class="timeline-body">
					<div class="box-body table-responsive">
						<table id="pm" class="table table-bordered table-striped">
						<thead>
						<tr class="bg-aqua">
							<th rowspan="2">No.</th>
							<th rowspan="2">Kode Brg</th>
							<th rowspan="2">No Reg</th>					
							<th rowspan="2">Nama Brg</th>
							<th rowspan="2">Thn Perolehan</th>				
							<th rowspan="2">Luas Lantai</th>																																																																																																																																																																																																							
							<th rowspan="2">Harga</th>																																																													
							<th rowspan="2">Nilai Buku</th>																																																													
							<th rowspan="2">Lokasi</th>																																																																																																																																																																																																																																																																																																																																							
							<th rowspan="2">Validation Image</th>																																																																																																																																																																																																																																																																																																																																							
						 </tr>
						</thead>
						<tbody id = "pm1">
							@foreach ($data_c as $index =>$data_cs)
							<tr>
								<td>{{ $index + 1 }}</td>
								<td>{{ $data_cs->kd_barang }}</td>
								<td>{{ $data_cs->no_reg }}</td>
								<td>{{ $data_cs->Nm_Aset5 }}</td>
								<td>{{ $data_cs->tgl_pembelian }}</td>
								<td>{{ $data_cs->Luas_Lantai }}</td>
								<td>{{ $data_cs->harga }}</td>
								<td>{{ $data_cs->nilaibuku }}</td>
								<td>{{ $data_cs->lokasi }}</td>				
								<td>					
									@if($data_cs->validation_img != '')
									<img src="{{url('/storage/php_pb/Image/'.$data_cs->imgname)}}" alt="gambar" style="width:150px;height:150px;"/>								
									@else
									<i>no pic</i>
									@endif					
								</td>	
							</tr>
							@endforeach	
						</tbody>
						<tfoot>
							<tr>
							@foreach ($data_c_sum as $data_c_sum)
								<td colspan="6" align = "center"><b>TOTAL</B></td>								
								<td><b>{{ $data_c_sum->total }}</b></td>
								<td><b>{{ $data_c_sum->totalnilaibuku }}</b></td>
							@endforeach	
							</tr>
						</tfoot>
						</table>
					</div>
					</div>
				</div>
				@endif
				</li>
				
				<li>
				@if(count($data_d) == 0 )
					<h3 class="timeline-header"><a href="#"></a></h3>
				@else
				<i class="fa fa-phone bg-purple"></i>

				<div class="timeline-item">
					<h3 class="timeline-header"><a href="#">JALAN JARINGAN & IRIGASI</a></h3>

					<div class="timeline-body">
					<div class="box-body table-responsive">
						<table id="pm" class="table table-bordered table-striped">
						<thead>
						<tr class="bg-aqua">
							<th rowspan="2">No.</th>
							<th rowspan="2">Kode Brg</th>
							<th rowspan="2">No Reg</th>					
							<th rowspan="2">Nama Brg</th>
							<th rowspan="2">Thn Perolehan</th>				
							<th rowspan="2">Konstruksi</th>																																																																																																																																																																																																							
							<th rowspan="2">Harga</th>																																																													
							<th rowspan="2">Nilai Buku</th>																																																													
							<th rowspan="2">Lokasi</th>																																																																																																																																																																																																																																																																																																													
							<th rowspan="2">KET</th>																																																																																																																																																																																																																																																																																																																																							
							<th rowspan="2">Validation Image</th>																																																																																																																																																																																																																																																																																																																																							
						 </tr>
						</thead>
						<tbody id = "pm1">
							@foreach ($data_d as $index =>$data_ds)
							<tr>
								<td>{{ $index + 1 }}</td>
								<td>{{ $data_ds->kd_barang }}</td>
								<td>{{ $data_ds->no_reg }}</td>
								<td>{{ $data_ds->Nm_Aset5 }}</td>
								<td>{{ $data_ds->tgl_pembelian }}</td>
								<td>{{ $data_ds->konstruksi }}</td>
								<td>{{ $data_ds->harga }}</td>
								<td>{{ $data_ds->nilaibuku }}</td>
								<td>{{ $data_ds->lokasi }}</td>				
								<td>{{ $data_ds->keterangan }}</td>				
								<td>					
									@if($data_ds->validation_img != '')
									<img src="{{url('/storage/php_pb/Image/'.$data_ds->imgname)}}" alt="gambar" style="width:150px;height:150px;"/>								
									@else
									<i>no pic</i>
									@endif					
								</td>			
							</tr>
							@endforeach	
						</tbody>
						<tfoot>
							<tr>
							@foreach ($data_d_sum as $data_d_sum)
								<td colspan="6" align = "center"><b>TOTAL</B></td>								
								<td><b>{{ $data_d_sum->total }}</b></td>
								<td><b>{{ $data_d_sum->totalnilaibuku }}</b></td>
							@endforeach	
							</tr>
						</tfoot>
						</table>
					</div>
					</div>
				</div>
				@endif
				</li>
				
				<li>
				@if(count($data_e) == 0 )
					<h3 class="timeline-header"><a href="#"></a></h3>
				@else
				<i class="fa fa-bell bg-grey"></i>

				<div class="timeline-item">
					<h3 class="timeline-header"><a href="#">ASET TETAP LAINNYA</a></h3>

					<div class="timeline-body">
					<div class="box-body table-responsive">
					<table id="pm" class="table table-bordered table-striped">
					<thead>
					<tr class="bg-aqua">
						<th rowspan="2">No.</th>
						<th rowspan="2">Kode Brg</th>
						<th rowspan="2">No Reg</th>					
						<th rowspan="2">Nama Brg</th>
						<th rowspan="2">Thn Perolehan</th>				
						<th rowspan="2">Judul</th>																																																																																																																																																																																																							
						<th rowspan="2">Harga</th>																																																																																																																																																																																																																																																																																																																																																																									
						<th rowspan="2">Nilai Buku</th>																																																																																																																																																																																																																																																																																																																																																																									
						<th rowspan="2">KET</th>																																																																																																																																																																																																																																																																																																																																							
						<th rowspan="2">Validation Image</th>																																																																																																																																																																																																																																																																																																																																							
					 </tr>
					</thead>
					<tbody id = "pm1">
						@foreach ($data_e as $index =>$data_es)
						<tr>
							<td>{{ $index + 1 }}</td>
							<td>{{ $data_es->kd_barang }}</td>
							<td>{{ $data_es->no_reg }}</td>
							<td>{{ $data_es->Nm_Aset5 }}</td>
							<td>{{ $data_es->tgl_pembelian }}</td>
							<td>{{ $data_es->judul }}</td>
							<td>{{ $data_es->harga }}</td>			
							<td>{{ $data_es->nilaibuku }}</td>			
							<td>{{ $data_es->keterangan }}</td>				
							<td>					
									@if($data_es->validation_img != '')
									<img src="{{url('/storage/php_pb/Image/'.$data_es->imgname)}}" alt="gambar" style="width:150px;height:150px;"/>								
									@else
									<i>no pic</i>
									@endif					
								</td>		
						</tr>
						@endforeach	
					</tbody>
						<tfoot>
							<tr>
							@foreach ($data_e_sum as $data_e_sum)
								<td colspan="6" align = "center"><b>TOTAL</B></td>								
								<td><b>{{ $data_e_sum->total }}</b></td>
								<td><b>{{ $data_e_sum->totalnilaibuku }}</b></td>
							@endforeach	
							</tr>
						</tfoot>
					</table>
				</div>
					</div>
				</div>
				@endif
				</li>
				<li>
				@if(count($data_f) == 0 )
					<h3 class="timeline-header"><a href="#"></a></h3>
				@else
				<i class="fa fa-fax bg-yellow"></i>
				<div class="timeline-item">
					<h3 class="timeline-header"><a href="#">KONSTRUKSI DALAM PENGERJAAN</a></h3>

					<div class="timeline-body">
					<div class="box-body table-responsive">
						<table id="pm" class="table table-bordered table-striped">
						<thead>
						<tr class="bg-aqua">
							<th rowspan="2">No.</th>
							<th rowspan="2">Kode Brg</th>
							<th rowspan="2">No Reg</th>					
							<th rowspan="2">Nama Brg</th>
							<th colspan="3">Konstruksi Bangunan</th>
							<th rowspan="2">Tgl Perolehan</th>																																																																																																																																																																																																											
							<th rowspan="2">Harga</th>																																																																																																																																																																																																																																																																																																																																																																									
							<th rowspan="2">KET</th>																																																																																																																																																																																																																																																																																																																																								
							<th rowspan="2">Validation Image</th>																																																																																																																																																																																																																																																																																																																																								
						 </tr>
						 <tr class="bg-aqua">
							<th>Luas</th>
							<th>Bertingkat/Tidak</th>
							<th>Beton/Tidak</th>
						</tr>
						</thead>
						<tbody id = "pm1">
							@foreach ($data_f as $index =>$data_fs)
							<tr>
								<td>{{ $index + 1 }}</td>
								<td>{{ $data_fs->kd_barang }}</td>
								<td>{{ $data_fs->no_reg }}</td>
								<td>{{ $data_fs->nm_aset5 }}</td>
								<td>{{ $data_fs->luas }}</td>
								<td>{{ $data_fs->bertingkat }}</td>
								<td>{{ $data_fs->beton }}</td>					
								<td>{{ $data_fs->Tgl_Perolehan }}</td>
								<td>{{ $data_fs->harga }}</td>			
								<td>{{ $data_fs->keterangan }}</td>				
											
								<td>					
									@if($data_fs->validation_img != '')									
									<img src="{{url('/storage/php_pb/Image/'.$data_fs->imgname)}}" alt="gambar" style="width:150px;height:150px;"/>								
									@else
									<i>no pic</i>
									@endif					
								</td>			
							</tr>
							@endforeach	
						</tbody>
						</table>
					</div>
					</div>
				</div>
				@endif
				</li>
				
				<!-- END timeline item -->
				<!-- timeline time label -->

				<!-- /.timeline-label -->
				<!-- timeline item -->
				<!-- END timeline item -->
				<li>
				<i class="fa fa-clock-o bg-gray"></i>
				</li>
			</ul>
			<!--<div class="text-center p30"><i class="fa fa-list-alt" style="font-size: 100px;"></i> <br> No posts to show</div>-->
		</div>
		
	</div>
	</div>
	</div>
</div>
@endsection

