@extends('la.layouts.app')

@section('htmlheader_title')
	Penghapusan item Detail
@endsection

@section("contentheader_description", "Item listing")
@section("contentheader_title", "Penghapusan Item")
@section('main-content')
<div id="page-content" class="profile2">

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
								<h4> Proses - {{ $ajuan_penghapusanpb->jenis_ajuan }}</h4>
									@if($ajuan_penghapusanpb->validation_aset == 1 )
										<i class="btn-primary btn-xs">Telah diajukan Ke Bidang Aset</i>
										<br/>
										<form action="/admin/edit_ajuan/valaset/{{ $ajuan_penghapusanpb->id }}" method="get" enctype="multipart/form-data">
											<button type="submit" class="btn btn-warning " data-dismiss="modal" enabled>Validasi Bidang Aset</button>
										</form>
									@elseif ($ajuan_penghapusanpb->validation_aset == 2 )
										<i class="btn-danger btn-xs">Telah diajukan Ke Bidang Aset</i>
										<i class="btn-warning btn-xs">Telah Validasi Bidang Aset</i>
									@elseif ($ajuan_penghapusanpb->validation_aset == 3 )	
										<i class="btn-danger btn-xs">Telah Validasi Bidang Aset</i>
										<i class="btn-warning btn-xs">Telah Validasi Tim Penilai</i>
									@elseif ($ajuan_penghapusanpb->validation_aset == 99 )	
										<i class="btn-danger btn-xs">Usulan Ditolak</i>
										<br/>
										Komentar: 
										<div class="alert alert-danger">
										<p>{{$ajuan_penghapusanpb->komentar}}</p>
										</div>
									@else
										<button type="button" class="btn btn-warning " data-dismiss="modal" enabled>Validasi Bidang Aset</button>
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
											<button type="button" class="btn btn-info " data-dismiss="modal" disabled>Telah Validasi Bidang Aset</button>
											<br/>
											<form action="/admin/edit_ajuan/valtimpenilai/{{ $ajuan_penghapusanpb->id }}" method="get" enctype="multipart/form-data">
												@la_input($module, 'rekom_jenis_ajuan')								
												<button type="submit" class="btn btn-warning" data-dismiss="modal">Validasi Tim Penilai</button>
											</form>
										@elseif ($ajuan_penghapusanpb->validation_aset == 3)								
											<label>Rekomendasi Tim Penilai : </label><i class="btn-warning btn-xs"> {{ $ajuan_penghapusanpb->rekom_jenis_ajuan }}</i>
											<button type="submit" class="btn btn-warning" data-dismiss="modal" disabled>Telah Validasi Tim Penilai</button>
											<button type="button" class="btn btn-primary" data-dismiss="modal">Permohonan Penghapusan ke Bupati</button>
										@elseif ($ajuan_penghapusanpb->validation_aset == 4)
											<button type="button" class="btn btn-primary" data-dismiss="modal">Barang telah dihapus</button>
										@elseif ($ajuan_penghapusanpb->validation_aset == 99 )	
										<button type="button" class="btn btn-danger" data-dismiss="modal">Usulan Ditolak</button>
			
										@else
											<button type="button" class="btn btn-primary" data-dismiss="modal">Proses Input PB Pembantu</button>
										@endif							
								</div>
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
				@if(count($data) == 0 )
					<h3 class="timeline-header"><a href="#"></a></h3>
				@else
				<i class="fa fa-map bg-blue"></i>

				<div class="timeline-item">
					<span class="time"><i class="fa fa-clock-o"></i></span>

					<h3 class="timeline-header"><a href="#">ITEMS</a></h3>

					<div class="timeline-body">
					<div class="box-body table-responsive">
							<table id="pm" class="table table-bordered table-striped">
							<thead>
							<tr class="bg-aqua">
								<th>No.</th>
								<th>IDPemda</th>				
								<th>Nama Brg</th>																													
								<th>OPD</th>																													
								<th>No Ajuan</th>															
								<th>Jenis Ajuan</th>															
								<th>No. Surat Pengurus Barang</th>																					
								<th>Tgl Surat</th>							
								<th>No. Surat Pengurus Barang Pembantu</th>
								<th>Tgl Surat Pengurus Barang Pembantu</th>									
								<th>Lokasi</th>																																																																																																																																																																																																																																																																																																							
							 </tr>
							</thead>
							<tbody id = "pm1">
								@foreach ($data as $index =>$datas)
								<tr>
									<td>{{ $index + 1 }}</td>
									<td>{{ $datas->idpemda }}</td>
									<td>{{ $datas->nm_aset5 }}</td>
									<td>{{ $datas->deptname }}</td>
									<td>{{ $datas->no_ajuan }}</td>
									<td>{{ $datas->jenis_ajuan }}</td>
									<td>{{ $datas->no_surat_pb }}</td>
									<td>{{ date('d-m-Y', strtotime($datas->tgl_surat)) }}</td>
									<td>{{ $datas->no_surat_pbp }}</td>
									 @if (($datas->tgl_surat_pbp) == 'null')  OR (($datas->tgl_surat_pbp) == '1970-01-01')
									 <td>{{ date('d-m-Y', strtotime($datas->tgl_surat_pbp)) }}</td>
									 @else
									 <td>-</td>
									 @endif	
									 @if (($datas->location == 'null')  OR	 ($datas->location == 0))
									 <td><i class="btn-warning btn-xs">OPD</td>
									 @else
									  <td><i class="btn-primary btn-xs">Gudang</td>
									 @endif									

								</tr>
								@endforeach	
							</tbody>
							<tfoot>
								<tr>
								
								</tr>
							</tfoot>
							</table>
						</div>
					</div>
				</div>
				@endif
				</li>
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
