@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/ajuan_penghapusanpbs') }}">Ajuan penghapusanpb</a> :
@endsection
@section("contentheader_description", $ajuan_penghapusanpb->$view_col)
@section("section", "Ajuan penghapusanpbs")
@section("section_url", url(config('laraadmin.adminRoute') . '/ajuan_penghapusanpbs'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Ajuan penghapusanpbs Edit : ".$ajuan_penghapusanpb->$view_col)

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
		 <i></i>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-12">

				<div class="col-md-2">
					<div class="alert alert-info">
						<label for="no_ajuan">No_ajuan :</label>
						<input class="form-control" style="font-size:13px" placeholder="Enter No_ajuan" data-rule-maxlength="256" name="no_ajuan" type="text" value="{{ $ajuan_penghapusanpb->no_ajuan }}" readonly>
						<label for="no_ajuan">Tgl ajuan :</label>
						<input class="form-control" placeholder="Enter Tgl_ajuan" name="tgl_ajuan" type="text" value="{{ $ajuan_penghapusanpb->tgl_ajuan }}" readonly>									
						<br>
						
					</div>
					@if($ajuan_penghapusanpb->validation_aset == 0 OR $ajuan_penghapusanpb->validation_aset == 99)
						<div class="alert alert-danger">
						<label for="komentar">Komentar :</label>
						<p>
						{{ $ajuan_penghapusanpb->komentar }}
						</p>
						</div>
					@else
						<div class="alert alert-info">
						<label for="komentar">Komentar :</label>
						<p>
						{{ $ajuan_penghapusanpb->komentar }}
						</p>
						</div>
					@endif
				</div>
				<div class="col-md-2" style="border:#48B0F7; border-width:1px; border-style:solid;">
						<div class="col-md-12">
							<label for="rekening">Rek 0</label>
							<select name="rek0" id="rek0" class="form-control">
								<option value="">== Pilih Rekening 0 ==</option>
								<option value="%">%</option>
								 @foreach($refrek0 as $refrek0s)
									<option value="{{ $refrek0s -> kd_aset0 }}" >
										{{ $refrek0s->kd_aset.'.'.$refrek0s->kd_aset0.'.'.$refrek0s->nm_aset0 }}
									</option>
								 @endForeach
							</select>					
						</div>
						<div class="col-md-12">
							<label for="name" >Rek 1</label>
							<select name="rek1" id="rek1" class="form-control">
								<option value="">== Pilih Rekening 1 ==</option>
								<option value="%">%</option>
							</select>
						</div>
						<div class="col-md-12">
							<label for="name" >Rek 2</label>
							<select name="rek2" id="rek2" class="form-control">
								<option value="">== Pilih Rekening 2 ==</option>
								<option value="%">%</option>
							</select>
							
						</div>
						<div class="col-md-12">
							<label for="name" >Rek 3</label>
							<select name="rek3" id="rek3" class="form-control">
								<option value="">== Pilih Rekening 3 ==</option>
								<option value="%">%</option>
							</select>
						</div>
						
						<div class="col-md-12">
							<label for="name" >Rek 4</label>
							<select name="rek4" id="rek4" class="form-control">
								<option value="">== Pilih Rekening 4 ==</option>
								<option value="%">%</option>
							</select>
						</div>
						<div class="col-md-12">
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
						
						<!--<div class="col-md-12">
							<label for="name" >Tahun</label>
							<select name="thn" id="thn" class="form-control">
								<option value="">== Pilih Tahun ==</option>
								{{ $last= date('Y')-120 }}
								{{ $now = date('Y') }}

								@for ($i = $now; $i >= $last; $i--)
									<option value="{{ $i }}">{{ $i }}</option>
								@endfor
							</select>
						</div>-->
						<div class="col-md-12">
							<br/>
							@if($ajuan_penghapusanpb->validation_aset == 0 OR $ajuan_penghapusanpb->validation_aset == 99)
							<button id = "showbrg" class="btn btn-success btn-sm pull-left" data-toggle="modal" data-target="#addbrg" >Show Barang</button>
							<button id = "showbrgbcd" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addbrgbcd" >Scan Barcode</button>							
							@else
							<button id = "showbrg" class="btn btn-success btn-sm pull-left" data-toggle="modal" data-target="#addbrg" disabled>Show Barang</button>
							<button id = "showbrgbcd" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addbrgbcd" disabled>Scan Barcode</button>							
							@endif							
						</div>
						<div class="col-md-12">
						<br/>
						</div>
				</div>
					
				<div class="col-md-3">					
					<div class="alert alert-dark" style="border:#48B0F7; border-width:1px; border-style:solid;">
						<label> Jenis Ajuan : </label> <i> {{ $ajuan_penghapusanpb->jenis_ajuan }}</i>
						<hr/>
						@if($ajuan_penghapusanpb->surat_persetujuan != '')
						@foreach ($ajnphp as $index =>$ajnphp)
						<br/>
						
						<label> Surat Usulan </label>
						<br/>	
						<label for="no_surat">No_Surat* :</label>
						<input class="form-control" placeholder="Enter No_Surat" data-rule-maxlength="256" required="1" name="no_surat" type="text" value="{{ $ajuan_penghapusanpb->no_surat }}" readonly>
						<label for="no_surat">Tgl_Surat :</label>
						<input class="form-control" placeholder="Enter No_Surat" data-rule-maxlength="256" required="1" name="no_surat" type="text" value="{{ date('d-m-Y', strtotime($ajuan_penghapusanpb->tgl_surat))}}" readonly>						
						<label for="perihal">Perihal* :</label>
						<input class="form-control" placeholder="Enter Perihal" data-rule-maxlength="256" required="1" name="perihal" type="text" value="{{$ajuan_penghapusanpb->perihal}}" readonly>
						<br/>
						<div class="btn-group" role="group" aria-label="Basic example">	
								<button class="btn btn-success" onclick=" window.open('{{url('/storage/php_pb/file/'.$ajnphp->filepdf)}}','_blank')">Preview Surat usulan</button>
						</div>																	
						@endforeach	
						@else
						<label for="name" >Upload Surat Usulan</label>
						<form action="/admin/ajuan_penghapusanpbs/upload-pdf/{{ $ajuan_penghapusanpb->id }}" method="post" enctype="multipart/form-data" id = "uploadsurat">														
						<input name="_token" type="hidden" value="{{ csrf_token() }}">
							<div class="custom-file">
								<br/>
									
									<input type="file" name="file" class="custom-file-input" id="chooseFile"/>
									<label for="no_surat">No_Surat* :</label>
									<input class="form-control" placeholder="Enter No_Surat" data-rule-maxlength="256" required="1" name="no_surat" type="text" value="">											
									<div class="form-group">
										<label for="tgl_surat">Tgl_Surat* :</label>
										<div class="input-group date">
											<input class="form-control" placeholder="Enter Tgl_Surat" required="1" name="tgl_surat" type="text" value="">
											<span class="input-group-addon">
												<span class="fa fa-calendar"></span>
											</span>
										</div>
									</div>
									<label for="perihal">Perihal* :</label>
									<input class="form-control" placeholder="Enter Perihal" data-rule-maxlength="256" required="1" name="perihal" type="text" value="">	
									<div class="btn-group" role="group" aria-label="Basic example">	
										<br/>											
										<button type="submit" name="submit" class="btn btn-warning" >Upload Files</button>										  
									</div>																						
								</div>	
						</form>	
						@endif
							</div>									
				</div>
				<div class="col-md-5" style="border:#48B0F7; border-width:1px; border-style:solid;">								
					<h4> Proses</h4>
					<select name="idformat" id="idformat" class="form-control" onchange="changeSelection()">
						<option value="">== Pilih Format ==</option>
						<option value="1">Usulan Pengurus Barang</option>
						<option value="2">Usulan Pengurus Barang Pembantu</option>
					</select>
					<div class="box-body table-responsive">
						
						<table id="example3" class="table table-bordered table-striped">
						<thead>
							<tr class="bg-aqua">
								<th>No.</th>
								<th>Dept</th>															
								<th>No Ajuan</th>															
								<th>Tgl Ajuan</th>							
								<th>Jenis Ajuan</th>																																																																											
								<th>No Surat</th>																																																																											
								<th>Tgl Surat</th>																																																													
								<th>Perihal</th>																																																																																																																									
								<th>Action</th>																											
							</tr>
						</thead>
						<tbody id = "tbody3">										
						</tbody>
						</table>
						
					</div>
					<div class="alert alert-success">
							@if($ajuan_penghapusanpb->validation_aset == 1 )
								
								<form action = "/admin/ajuan_penghapusanpbs/batalkanaset/{{ $ajuan_penghapusanpb->id }}" method="get" enctype="multipart/form-data" id="usulpb">
									<input name="_token" type="hidden" value="{{ csrf_token() }}">	
									<button type="button" class="btn btn-primary " data-dismiss="modal" disabled>Ajukan Ke Bidang Aset</button>
									<button type="submit" name="submit"  class="btn btn-danger " data-dismiss="modal">Batalkan Ajuan Ke Bidang Aset</button>
								</form>
								<form action = "/admin/ajuan_penghapusanpbs/batalkanaset/{{ $ajuan_penghapusanpb->id }}" method="get" enctype="multipart/form-data" id="usulpbp">
									<input name="_token" type="hidden" value="{{ csrf_token() }}">	
									<button type="button" class="btn btn-primary " data-dismiss="modal" disabled>Ajukan Ke Bidang Aset</button>
									<button type="submit" name="submit"  class="btn btn-danger " data-dismiss="modal">Batalkan Ajuan Ke Bidang Aset</button>
								</form>
							@else
								<form action = "/admin/ajuan_penghapusanpbs/ajukanaset/{{ $ajuan_penghapusanpb->id }}" method="get" enctype="multipart/form-data" id="usulpb">
									<input name="_token" type="hidden" value="{{ csrf_token() }}">																					
									<button type="submit" name="submit" class="btn btn-primary " >Ajukan Ke Bidang Aset</button>
									<button type="button" class="btn btn-danger " data-dismiss="modal" disabled>Batalkan Ajuan Ke Bidang Aset</button>
								</form>
								<form action = "/admin/ajuan_penghapusanpbs/ajukanusulpbp/{{ $ajuan_penghapusanpb->id }}" method="get" enctype="multipart/form-data" id="usulpbp">
									<input name="_token" type="hidden" value="{{ csrf_token() }}">
									<input class="form-control" placeholder="No Surat" type="hidden" id = "getidajuanpbp"  name = "getidajuanpbp" value="" readonly/>
									<button type="submit" name="submit" class="btn btn-warning " >Ajukan Ke Bidang Aset</button>
									<button type="button" class="btn btn-danger " data-dismiss="modal" disabled>Batalkan Ajuan Ke Bidang Aset</button>
								</form>
							@endif
					</div>
					<div class="box-body table-responsive">
					<h4> Referensi No Ajuan</h4>
					<table id="example4" class="table table-bordered table-striped">
						<thead>
							<tr class="bg-aqua">
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
							@foreach ($dataref as $index =>$datarefs)
								<tr>
									<td>{{ $index + 1 }}</td>
									<td>{{ $datarefs->deptname }}</td>
									<td><a href="{{ url(config('laraadmin.adminRoute') . '/ajuan_penghapusanpbs/showpbp/'.$datarefs->id) }}"> {{ $datarefs->no_ajuan}} </a></td>
									<td>{{ date('d-m-Y', strtotime($datarefs->tgl_ajuan)) }}</td>
									<td>{{ $datarefs->jenis_ajuan }}</td>	
									<td>{{ $datarefs->no_surat }}</td>	
									<td>{{ date('d-m-Y', strtotime($datarefs->tgl_surat)) }}</td>
									<td>{{ $datarefs->perihal }}</td>	
									
								</tr>
								@endforeach	
						</tbody>
					</table>
					</div>
				</div>
				
											
				<hr class="divider">
				<div class="col-md-12">
					<div class="modal fade" id="addbrg" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button  type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="myModalLabel">Add Barang</h4>
								</div>
								<div class="modal-body">
								<div class="form-group" >
									<h3>No Ajuan:</h3>
										<input type="text" id="ajuan" class="form-control" value="{{ $ajuan_penghapusanpb->no_ajuan }}" readonly />
									<h2>Keterangan/Lokasi/Judul</h2>
									<input type="text" name="search" id="search" class="form-control" placeholder="Cari.." />
								</div>
									<div class="box-body table-responsive">
										<table id="example1" class="table table-bordered table-striped">
										<thead>
										<tr class="bg-aqua">
											<th>No.</th>															
											<th>Action</th>															
											<th>Dept</th>															
											<th>Kondisi</th>							
											<th>Kondisi Akhir</th>							
											<th>Tgl Pembukuan</th>																																																													
											<th>No Reg</th>																											
											<th>Harga</th>																											
											<th>NOPOL</th>																											
											<th>Merk</th>																											
											<th>Type</th>																											
											<th>Luas</th>																											
											<th>Luas Lantai</th>																											
											<th>Kontruksi</th>																											
											<th>Lokasi</th>																											
											<th>Judul</th>																											
											<th>KET</th>																																																				
										 </tr>
										</thead>
										<tbody id = "tbody1">
										
										</tbody>
										</table>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-warning" data-dismiss="modal" onclick = "reload()">Close</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="modal fade" id="addbrgbcd" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button  type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="myModalLabel">Scan Barcode</h4>
								</div>
								<div class="modal-body">
									<div class="form-group" >
										<h3>No Ajuan:</h3>
											<input type="text" id="ajuan" class="form-control" value="{{ $ajuan_penghapusanpb->no_ajuan }}" readonly />
										<h2>Code</h2>
										<input type="text" id="myInput" name = 'bcd' 
										onkeyup="valinst()" placeholder="Barcode" 
										style = "height : 90px; width : 100%; font-size: 50px;"/>
									</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-warning" data-dismiss="modal" onclick = "reload()">Close</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
	<div class="box-body">
		<label for="rekening">DAFTAR BARANG</label>
		<hr class="divider">
		<label for="rekening">TANAH</label>
		<hr class="divider">
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
				<th rowspan="2">KET</th>																																																													
				<th rowspan="2">Validasi</th>																																																													
				<th rowspan="2">Action</th>																											
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
					<td>{{ $data_as->keterangan }}</td>
					<td>					
						@if($data_as->validation_img != '')
						<button class="btn btn-success" onclick=" window.open('{{url('/storage/php_pb/Image/'.$data_as->imgname)}}','_blank')">Preview</button>					
						<form action="/admin/ajuan_penghapusanpbs/upload-file/{{ $data_as->id }}" method="post" enctype="multipart/form-data">														
						<input name="_token" type="hidden" value="{{ csrf_token() }}">
							<div class="custom-file">
								<input type="file" name="file" class="custom-image-input" id="chooseFile">
							</div>
							<button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
								Update Files
							</button>
						</form>	
						@else
						<form action="/admin/ajuan_penghapusanpbs/upload-file/{{ $data_as->id }}" method="post" enctype="multipart/form-data">														
						<input name="_token" type="hidden" value="{{ csrf_token() }}">
							<div class="custom-file">
								<input type="file" name="file" class="custom-image-input" id="chooseFile">
							</div>
							<button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
								Upload Files
							</button>
						</form>	
						@endif
					</td>
					<td>
					@if($ajuan_penghapusanpb->validation_aset == 0 OR $ajuan_penghapusanpb->validation_aset == 99)
					 <button id = "{{ $data_as->id }}" 
							   href="{{ url(config('laraadmin.adminRoute') . '/delbrgpbp/'.$data_as->idpemda)}}" 
							   class="btn btn-danger" type="button" onclick = "delidpemda(this.id)" 
							   value = "{{ $data_as->idpemda }}" enabled>Del</button>
					</td>
					@else
					<i>Telah Diajukan </i>	
					@endif
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
		<label for="rekening">PERALATAN & MESIN</label>
		<hr class="divider">
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
				<th rowspan="2">Kondisi Awal</th>																																																																																																																																							
				<th rowspan="2">Kondisi Akhir</th>																																																																																																																																							
				<th rowspan="2">Harga</th>																																																													
				<th rowspan="2">Nilai Buku</th>																																																													
				<th rowspan="2">KET</th>																																																													
				<th rowspan="2">Validasi</th>																																																													
				<th rowspan="2">Action</th>																											
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
					<td>{{ $data_bs->kondisi_akhir }}</td>
					<td>{{ $data_bs->harga }}</td>					
					<td>{{ $data_bs->nilaibuku }}</td>
					<td>{{ $data_bs->keterangan }}</td>
					<td>					
						@if($data_bs->validation_img != '')
						<button class="btn btn-success" onclick=" window.open('{{url('/storage/php_pb/Image/'.$data_bs->imgname)}}','_blank')">Preview</button>					
						<form action="/admin/ajuan_penghapusanpbs/upload-file/{{ $data_bs->id }}" method="post" enctype="multipart/form-data">														
						<input name="_token" type="hidden" value="{{ csrf_token() }}">
							<div class="custom-file">
								<input type="file" name="file" class="custom-image-input" id="chooseFile">
							</div>
							<button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
								Update Files
							</button>
						</form>
						@else
						<form action="/admin/ajuan_penghapusanpbs/upload-file/{{ $data_bs->id }}" method="post" enctype="multipart/form-data">														
						<input name="_token" type="hidden" value="{{ csrf_token() }}">
							<div class="custom-file">
								<input type="file" name="file" class="custom-image-input" id="chooseFile">
							</div>
							<button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
								Upload Files
							</button>
						</form>	
						@endif					
					</td>
					<td>
					@if($ajuan_penghapusanpb->validation_aset == 0 OR $ajuan_penghapusanpb->validation_aset == 99)
					 <button id = "{{ $data_bs->id }}" 
							   href="{{ url(config('laraadmin.adminRoute') . '/delbrgpbp/'.$data_bs->id)}}" 
							   class="btn btn-danger" type="button" onclick = "delidpemda(this.id)" 
							   value = "{{ $data_bs->idpemda }}" enabled>Del</button>
					</td>
					@else
					<i>Telah Diajukan </i>	
					@endif
					</td>
				</tr>
				@endforeach	
			</tbody>
			<tfoot>
				<tr>
				@foreach ($data_b_sum as $data_b_sum)
					<td colspan="9" align = "center"><b>TOTAL</B></td>								
					<td><b>{{ $data_b_sum->total }}</b></td>
					<td><b>{{ $data_b_sum->totalnilaibuku }}</b></td>
				@endforeach	
				</tr>
			</tfoot>
			</table>
		</div>
		
		<label for="rekening">GEDUNG & BANGUNAN</label>
		<hr class="divider">
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
				<th rowspan="2">Kondisi Induk</th>																																																																																																																																																																																																							
				<th rowspan="2">Kondisi Akhir</th>																																																																																																																																																																																																							
				<th rowspan="2">Harga</th>																																																													
				<th rowspan="2">Nilai Buku</th>																																																													
				<th rowspan="2">Lokasi</th>																																																																																																																																																																																																																																																																																																													
				<th rowspan="2">Validasi</th>																																																													
				<th rowspan="2">Action</th>																											
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
					<td>{{ $data_cs->kondisi }}</td>
					<td>{{ $data_cs->kondisi_akhir }}</td>
					<td>{{ $data_cs->harga }}</td>
					<td>{{ $data_cs->nilaibuku }}</td>
					<td>{{ $data_cs->lokasi }}</td>				
					<td>					
						@if($data_cs->validation_img != '')
						<button class="btn btn-success" onclick=" window.open('{{url('/storage/php_pb/Image/'.$data_cs->imgname)}}','_blank')">Preview</button>					
						<form action="/admin/ajuan_penghapusanpbs/upload-file/{{ $data_cs->id }}" method="post" enctype="multipart/form-data">														
						<input name="_token" type="hidden" value="{{ csrf_token() }}">
							<div class="custom-file">
								<input type="file" name="file" class="custom-image-input" id="chooseFile">
							</div>
							<button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
								Update Files
							</button>
						</form>	
						@else
						<form action="/admin/ajuan_penghapusanpbs/upload-file/{{ $data_cs->id }}" method="post" enctype="multipart/form-data">														
						<input name="_token" type="hidden" value="{{ csrf_token() }}">
							<div class="custom-file">
								<input type="file" name="file" class="custom-image-input" id="chooseFile">
							</div>
							<button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
								Upload Files
							</button>
						</form>	
						@endif					
					</td>
					<td>
					 @if($ajuan_penghapusanpb->validation_aset == 0 OR $ajuan_penghapusanpb->validation_aset == 99)
					 <button id = "{{ $data_cs->id }}" 
							   href="{{ url(config('laraadmin.adminRoute') . '/delbrgpbp/'.$data_cs->id)}}" 
							   class="btn btn-danger" type="button" onclick = "delidpemda(this.id)" 
							   value = "{{ $data_cs->idpemda }}" enabled>Del</button>
					</td>
					@else
					<i>Telah Diajukan </i>	
					@endif
					</td>
				</tr>
				@endforeach	
			</tbody>
			<tfoot>
				<tr>
				@foreach ($data_c_sum as $data_c_sum)
					<td colspan="8" align = "center"><b>TOTAL</B></td>								
					<td><b>{{ $data_c_sum->total }}</b></td>
					<td><b>{{ $data_c_sum->totalnilaibuku }}</b></td>
				@endforeach	
				</tr>
			</tfoot>
			</table>
		</div>
		
		<label for="rekening">JALAN, JARINGAN DAN IRIGASI</label>
		<hr class="divider">
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
				<th rowspan="2">Kondisi Induk</th>																																																																																																																																																																																																							
				<th rowspan="2">Kondisi Akhir</th>																																																																																																																																																																																																							
				<th rowspan="2">Harga</th>																																																													
				<th rowspan="2">Nilai Buku</th>																																																													
				<th rowspan="2">Lokasi</th>																																																																																																																																																																																																																																																																																																													
				<th rowspan="2">KET</th>																																																																																																																																																																																																																																																																																																													
				<th rowspan="2">Validasi</th>																																																													
				<th rowspan="2">Action</th>																											
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
					<td>{{ $data_ds->kondisi }}</td>
					<td>{{ $data_ds->kondisi_akhir }}</td>
					<td>{{ $data_ds->harga }}</td>
					<td>{{ $data_ds->nilaibuku }}</td>
					<td>{{ $data_ds->lokasi }}</td>				
					<td>{{ $data_ds->keterangan }}</td>				
					<td>					
						@if($data_ds->validation_img != '')
						<button class="btn btn-success" onclick=" window.open('{{url('/storage/php_pb/Image/'.$data_ds->imgname)}}','_blank')">Preview</button>					
						<form action="/admin/ajuan_penghapusanpbs/upload-file/{{ $data_ds->id }}" method="post" enctype="multipart/form-data">														
						<input name="_token" type="hidden" value="{{ csrf_token() }}">
							<div class="custom-file">
								<input type="file" name="file" class="custom-image-input" id="chooseFile">
							</div>
							<button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
								Update Files
							</button>
						</form>	
						@else
						<form action="/admin/ajuan_penghapusanpbs/upload-file/{{ $data_ds->id }}" method="post" enctype="multipart/form-data">														
						<input name="_token" type="hidden" value="{{ csrf_token() }}">
							<div class="custom-file">
								<input type="file" name="file" class="custom-image-input" id="chooseFile">
							</div>
							<button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
								Upload Files
							</button>
						</form>	
						@endif					
					</td>
					<td>
					@if($ajuan_penghapusanpb->validation_aset == 0 OR $ajuan_penghapusanpb->validation_aset == 99)
					 <button id = "{{ $data_ds->id }}" 
							   href="{{ url(config('laraadmin.adminRoute') . '/delbrgpbp/'.$data_ds->idpemda)}}" 
							   class="btn btn-danger" type="button" onclick = "delidpemda(this.id)" 
							   value = "{{ $data_ds->idpemda }}" enabled>Del</button>
					</td>
					@else
					<i>Telah Diajukan </i>	
					@endif
					</td>
				</tr>
				@endforeach	
			</tbody>
			<tfoot>
				<tr>
				@foreach ($data_d_sum as $data_d_sum)
					<td colspan="8" align = "center"><b>TOTAL</B></td>								
					<td><b>{{ $data_d_sum->total }}</b></td>
					<td><b>{{ $data_d_sum->totalnilaibuku }}</b></td>
				@endforeach	
				</tr>
			</tfoot>
			</table>
		</div>
		
		<label for="rekening">ASET TETAP LAINNYA</label>
		<hr class="divider">
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
				<th rowspan="2">Kondisi Induk</th>																																																																																																																																																																																																							
				<th rowspan="2">Kondisi Akhir</th>																																																																																																																																																																																																							
				<th rowspan="2">Harga</th>																																																																																																																																																																																																																																																																																																																																																																									
				<th rowspan="2">KET</th>																																																																																																																																																																																																																																																																																																													
				<th rowspan="2">Validasi</th>																																																													
				<th rowspan="2">Action</th>																											
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
					<td>{{ $data_es->kondisi }}</td>
					<td>{{ $data_es->kondisi_akhir }}</td>
					<td>{{ $data_es->harga }}</td>			
					<td>{{ $data_es->keterangan }}</td>				
					<td>{{ $data_es->validation_img }}</td>
					<td>
					@if($ajuan_penghapusanpb->validation_aset == 0 OR $ajuan_penghapusanpb->validation_aset == 99)
					 <button id = "{{ $data_es->idpemda }}" 
							   href="{{ url(config('laraadmin.adminRoute') . '/delbrgpbp/'.$data_es->idpemda)}}" 
							   class="btn btn-danger" type="button" onclick = "delidpemda(this.id)" 
							   value = "{{ $data_es->idpemda }}" enabled>Del</button>
					</td>
					@else
					<i>Telah Diajukan </i>	
					@endif
					</td>
				</tr>
				@endforeach	
			</tbody>
			<tfoot>
				<tr>
				@foreach ($data_e_sum as $data_e_sum)
					<td colspan="8" align = "center"><b>TOTAL</B></td>								
					<td><b>{{ $data_e_sum->total }}</b></td>
				@endforeach	
				</tr>
			</tfoot>
			</table>
		</div>
		
		<label for="rekening">KONSTRUKSI DALAM PENGERJAAN</label>
		<hr class="divider">
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
				<th rowspan="2">Validasi</th>																																																													
				<th rowspan="2">Action</th>																											
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
						<button class="btn btn-success" onclick=" window.open('{{url('/storage/php_pb/Image/'.$data_fs->imgname)}}','_blank')">Preview</button>					
						<form action="/admin/ajuan_penghapusanpbs/upload-file/{{ $data_fs->id }}" method="post" enctype="multipart/form-data">														
						<input name="_token" type="hidden" value="{{ csrf_token() }}">
							<div class="custom-file">
								<input type="file" name="file" class="custom-image-input" id="chooseFile">
							</div>
							<button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
								Update Files
							</button>
						</form>	
						@else
						<form action="/admin/ajuan_penghapusanpbs/upload-file/{{ $data_fs->id }}" method="post" enctype="multipart/form-data">														
						<input name="_token" type="hidden" value="{{ csrf_token() }}">
							<div class="custom-file">
								<input type="file" name="file" class="custom-image-input" id="chooseFile">
							</div>
							<button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
								Upload Files
							</button>
						</form>	
						@endif					
					</td>
					<td>
					@if($ajuan_penghapusanpb->validation_aset == 0 OR $ajuan_penghapusanpb->validation_aset == 99)
					 <button id = "{{ $data_fs->id }}" 
							   href="{{ url(config('laraadmin.adminRoute') . '/delbrgpbp/'.$data_fs->id)}}" 
							   class="btn btn-danger" type="button" onclick = "delidpemda(this.id)" 
							   value = "{{ $data_fs->idpemda }}" enabled>Del</button>
					</td>
					@else
					<i>Telah Diajukan </i>	
					@endif
					</td>
				</tr>
				@endforeach	
			</tbody>			
			</table>
		</div>

	</div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
	$("#ajuan_penghapusanpb-edit-form").validate({
		
	});
});
//load rek1
jQuery(document).ready(function (){
            jQuery('select[name="rek0"]').on('change',function(){
               var rekening0 = jQuery(this).val();
              
               if(rekening0){
                  jQuery.ajax({
                     url : '/admin/ajuan_penghapusanpb_rek1/' +rekening0,
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
                     url : '/admin/ajuan_penghapusanpb_rek2/' +rekening0+'/'+rekening1,
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
                     url : '/admin/ajuan_penghapusanpb_rek3/' +rekening0+'/'+rekening1+'/'+rekening2,
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
                     url : '/admin/ajuan_penghapusanpb_rek4/'+rekening0+'/'+rekening1+'/'+rekening2+'/'+rekening3,
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


	/* jQuery(document).ready(function () {						
		jQuery(document).on('click', '#showbrg', function(e){
				var rekening2 = $("#rek2 option:selected").val();
				var rekening1 = $("#rek1 option:selected").val();
				var tahun = $("#thn option:selected").val();
				var noajuan =  document.getElementById("ajuan").value;
							
            fetch_customer_data();

            function fetch_customer_data(query = '') {
                jQuery.ajax({
					url:'/admin/showbarangphppb/'+{{ $ajuan_penghapusanpb->id }}+'/'+rekening1+'/'+rekening2+'/'+tahun,
                    method: 'GET',
                    data: {query: query},
                    dataType: 'json',
                    success: function (data) {
					   //console.log(data);
                       $('#tbody1').html(data.table_data);
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
	}); */
	jQuery(document).ready(function () {						
		jQuery(document).on('click', '#showbrg', function(e){
				var rekening4 = $("#rek4 option:selected").val();
				var rekening3 = $("#rek3 option:selected").val();
				var rekening2 = $("#rek2 option:selected").val();
				var rekening1 = $("#rek1 option:selected").val();
				var kondisi = $("#kond option:selected").val();
				var noajuan =  document.getElementById("ajuan").value;
							
            fetch_customer_data();

            function fetch_customer_data(query = '') {
                jQuery.ajax({
					url:'/admin/showbarangphppb/'+{{ $ajuan_penghapusanpb->id }}+'/'+rekening1+'/'+rekening2+'/'+rekening3+'/'+rekening4+'/'+kondisi,
                    method: 'GET',
                    data: {query: query},
                    dataType: 'json',
                    success: function (data) {
					   //console.log(data);
                       $('#tbody1').html(data.table_data);
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
	});
//endsearch

function getidpemda(clicked_id){
			var rekening4 = $("#rek4 option:selected").val();
			var rekening3 = $("#rek3 option:selected").val();
			var rekening2 = $("#rek2 option:selected").val();
			var rekening1 = $("#rek1 option:selected").val();
			var rekening0 = $("#rek0 option:selected").val();
			var kondisi = $("#kond option:selected").val();
			var loc = '/admin/showbarangphppb/'+{{ $ajuan_penghapusanpb->id }}+'/'+rekening0+'/'+rekening1+'/'+rekening2+'/'+rekening3+'/'+rekening4;
			var noajuan =  {{ $ajuan_penghapusanpb->id }};
			var idpemdas =  clicked_id;		
			
					   $.ajax({
						url : '/admin/addbrgpb/'+{{ $ajuan_penghapusanpb->id }}+'/'+idpemdas+'/'+rekening0+'/'+rekening1+'/'+rekening2+'/'+rekening3+'/'+rekening4,
						headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
						method: 'GET',						
						data: {
								  "_token": "{{ csrf_token() }}",
								  "no_ajuan": {{ $ajuan_penghapusanpb->id }},
								  "idpemda": idpemdas,
								  "jenis_ajuan": "PB",
								  "kd_aset8" : 1,
								  "kd_aset80" : rekening0,
								  "kd_aset81" : rekening1,
								  "kd_aset82" : rekening2,
								  "kd_aset83" : rekening3,
								  "kd_aset84" : rekening4
							  },
						dataType: 'json',
						//error: function(data) {alert(data);},
						success: function (data) {					  
							document.getElementById(clicked_id).disabled = true;
						}
					}).fail(function(){
						//console.log('failed');
						document.getElementById(clicked_id).disabled = true;
					});	   

}
function delidpemda(clicked_id){
	
	var id =  clicked_id;
		
	
						$.ajax({
						url : '/admin/delbrgpb/'+id,
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
function reload(){
	location.reload();
}

jQuery(document).ready(function (){
	var idjenis = 2;
	var kdbidang = {{ $kdbidang }};
	var kdunit = {{ $kdunit }};
	$("#example3").hide();
	$("#usulpbp").hide();
	$("#usulpb").hide();
            jQuery('select[name="idformat"]').on('change',function(){
				if(this.value == 1)  {
					$("#example3").hide();
					$("#usulpbp").hide();
					$("#usulpb").show();
					//alert('satu');
				}else if (this.value == 2){
					$("#example3").show();
					$("#usulpbp").show();
					$("#usulpb").hide();
					$(document).ready(function () {
						fetch_customer_data();

						function fetch_customer_data(query = '') {
							$.ajax({
								
								url:"{{ url(config('laraadmin.adminRoute') . '/populateidpb') }}",
								method: 'GET',
								data: {query: query},
								dataType: 'json',
								success: function (data) {
									$('#tbody3').html(data.table_data);
									//console.log(data);
									//alert(data);
								}
							}).fail(function(){
								$('#tbody3').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
								//$('#tbody1').hide();
							});
						}

						$(document).on('keyup', '#search', function () {
							var query = $(this).val();
							fetch_customer_data(query);				
						});
				 });
				}else{
					$("#example3").hide();
				}
			  
            });
    });
//end

//get checkbox		
function validate1() {
	$('input[id="chkbox1"]').change(function(){
		var text = "";
		$('input[id="chkbox1"]:checked').each(function(){ 
			text += text != "" ? "," : "";
			if ($(this).prop("checked"))
				text += $(this).val();
		});
		$("#getidajuanpbp").val(text);
		
	});
}
//end

function cleartxt(){
	document.getElementById('myInput').value = ''
}

function valinst() {

 // check if input is bigger than 17
var idpemda = document.getElementById('myInput').value;
	if(idpemda.length <= 17){
		setTimeout(function() {
		//your code to be executed after 1 second
			if (idpemda.length = 17) { 
				insertRecord();
				//alert('Data found');
			}else{
				alert('Data not found');
			}
		}, 100);
	}
}
function insertRecord(){
var idpemda = document.getElementById('myInput').value;
var rekening4 = $("#rek4 option:selected").val();
var rekening3 = $("#rek3 option:selected").val();
var rekening2 = $("#rek2 option:selected").val();
var rekening1 = $("#rek1 option:selected").val();
var rekening0 = $("#rek0 option:selected").val();
var kondisi = $("#kond option:selected").val();
    $.ajax({
						url : '/admin/addbrgpb/'+{{ $ajuan_penghapusanpb->id }}+'/'+idpemdas+'/'+rekening0+'/'+rekening1+'/'+rekening2+'/'+rekening3+'/'+rekening4,
						headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
						method: 'POST',						
						data: {
								   "_token": "{{ csrf_token() }}",
								  "no_ajuan": {{ $ajuan_penghapusanpb->id }},
								  "idpemda": idpemdas,
								  "jenis_ajuan": "PB",
								  "kd_aset8" : 1,
								  "kd_aset80" : rekening0,
								  "kd_aset81" : rekening1,
								  "kd_aset82" : rekening2,
								  "kd_aset83" : rekening3,
								  "kd_aset84" : rekening4
							  },
						dataType: 'json',
						//error: function(data) {alert(data);},
						success: function (data) {					  
							 //alert(data.status);
							 cleartxt();
						}
					}).fail(function(){
						//console.log('failed');
						 //alert(data.status);
						 cleartxt();
					});             
} 
</script>
@endpush
