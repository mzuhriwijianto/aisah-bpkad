@extends('la.layouts.app')

@section('htmlheader_title')
	Daftar pegawai View
@endsection


@section('main-content')
<div id="page-content" class="profile2">
	<div class="bg-primary clearfix">
		<div class="col-md-4">
			<div class="row">
				<div class="col-md-3">
					<!--<img class="profile-image" src="{{ asset('la-assets/img/avatar5.png') }}" alt="">-->
					<div class="profile-icon text-primary"><i class="fa {{ $module->fa_icon }}"></i></div>
				</div>
				<div class="col-md-9">
					<h4 class="name">{{ $daftar_pegawai->$view_col }}</h4>
					<div class="row stats">
						<div class="col-md-4"><i class="fa fa-user">NIP:</i>{{ $daftar_pegawai->nip }}</div>
						<div class="col-md-4"><i class="fa fa-user">No Telp:</i>{{$daftar_pegawai->telp}}</div>
					</div>
					<p class="desc">Jabatan : {{$daftar_pegawai->jabatan}}</p>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			
		</div>
		<div class="col-md-1 actions">
			@la_access("Daftar_pegawais", "edit")
				<a href="{{ url(config('laraadmin.adminRoute') . '/daftar_pegawais/'.$daftar_pegawai->id.'/edit') }}" class="btn btn-xs btn-edit btn-default"><i class="fa fa-pencil"></i></a><br>
			@endla_access			
		</div>
	</div>

	<ul data-toggle="ajax-tab" class="nav nav-tabs profile" role="tablist">
		<li class=""><a href="{{ url(config('laraadmin.adminRoute') . '/daftar_pegawais') }}" data-toggle="tooltip" data-placement="right" title="Back to Daftar pegawais"><i class="fa fa-chevron-left"></i></a></li>
		<li class="active"><a role="tab" data-toggle="tab" class="active" href="#tab-general-info" data-target="#tab-info"><i class="fa fa-bars"></i>Daftar Pegawai</a></li>
	</ul>

	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active fade in" id="tab-info">
			<div class="tab-content">
				<div class="panel infolist">
					<div class="panel-default panel-heading">
						<h4>General Info</h4>
					</div>
					<div class="panel-body">
						@la_display($module, 'nama')
						@la_display($module, 'nip')
						@la_display($module, 'jabatan')
						@la_display($module, 'instansi')
						@la_display($module, 'telp')
					</div>
					<div class="panel-body">
					<div class="panel-default panel-heading">
						<h4>Report</h4>
						<button class="btn btn-info" onclick=" window.open('{{url('admin/printbrgpgw/'.$daftar_pegawai->id)}}','_blank')">PDF</button>
					</div>
					</div>
					<div class="panel-body">
						<div class="card text-left">
						  <div class="card-header">
							<h4 class="card-title"><b>DAFTAR BARANG</b></h4>
						  </div>
						  <div class="card-body">
							<table id="pm" class="table table-bordered table-striped">
										<thead>
										<tr class="bg-aqua">
											<th rowspan="2">No.</th>
											<th rowspan="2">Kode Brg</th>
											<th rowspan="2">No Reg</th>					
											<th rowspan="2">Nama Brg</th>
											<th rowspan="2">Thn Perolehan</th>				
											<th rowspan="2">Tgl Perolehan</th>				
											<th rowspan="2">Merk/Type</th>																																																																
											<th rowspan="2">Bahan</th>								
											<th rowspan="2">Kondisi Awal</th>																																																																																																																																							
											<th rowspan="2">Kondisi Akhir</th>																																																																																																																																							
											<th rowspan="2">Harga</th>																																																																																																																									
											<th rowspan="2">KET</th>																																																																																																																																																			
											<th rowspan="2">Gambar</th>																																																																																																																																																			
										 </tr>
										</thead>
										<tbody id = "pm1">
											@foreach ($kibbsuserbrg as $index =>$kibbsuserbrgs)
											<tr>
												<td>{{ $index + 1 }}</td>
												<td>{{ $kibbsuserbrgs->kd_barang }}</td>
												<td>{{ $kibbsuserbrgs->no_reg }}</td>
												<td>{{ $kibbsuserbrgs->Nm_Aset5 }}</td>
												<td>{{ $kibbsuserbrgs->thnperolehan }}</td>
												<td>{{ $kibbsuserbrgs->tgl_perolehan }}</td>
												<td>{{ $kibbsuserbrgs->merk }} - {{ $kibbsuserbrgs->type }}</td>
												<td>{{ $kibbsuserbrgs->bahan }}</td>
												<td>{{ $kibbsuserbrgs->kondisi }}</td>
												<td>{{ $kibbsuserbrgs->kondisi_akhir }}</td>
												<td>{{ $kibbsuserbrgs->harga }}</td>					
												<td>{{ $kibbsuserbrgs->keterangan }}</td>
												<td><img src="{{url('/storage/imgkib/Image/'.$kibbsuserbrgs->imgname)}}"alt="gambar" width = "190" height = "160"/></td>
												</td>
											</tr>
											@endforeach	
										</tbody>
										<tfoot>
										</tfoot>
										</table>
						  </div>
						  <div class="card-footer text-muted">
							
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
					<span class="bg-red">
						10 Feb. 2014
					</span>
				</li>
				<!-- /.timeline-label -->
				<!-- timeline item -->
				<li>
				<i class="fa fa-envelope bg-blue"></i>

				<div class="timeline-item">
					<span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

					<h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

					<div class="timeline-body">
					Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
					weebly ning heekya handango imeem plugg dopplr jibjab, movity
					jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
					quora plaxo ideeli hulu weebly balihoo...
					</div>
					<div class="timeline-footer">
					<a class="btn btn-primary btn-xs">Read more</a>
					<a class="btn btn-danger btn-xs">Delete</a>
					</div>
				</div>
				</li>
				<!-- END timeline item -->
				<!-- timeline item -->
				<li>
				<i class="fa fa-user bg-aqua"></i>

				<div class="timeline-item">
					<span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>

					<h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request
					</h3>
				</div>
				</li>
				<!-- END timeline item -->
				<!-- timeline item -->
				<li>
				<i class="fa fa-comments bg-yellow"></i>

				<div class="timeline-item">
					<span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>

					<h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

					<div class="timeline-body">
					Take me to your leader!
					Switzerland is small and neutral!
					We are more like Germany, ambitious and misunderstood!
					</div>
					<div class="timeline-footer">
					<a class="btn btn-warning btn-flat btn-xs">View comment</a>
					</div>
				</div>
				</li>
				<!-- END timeline item -->
				<!-- timeline time label -->
				<li class="time-label">
					<span class="bg-green">
						3 Jan. 2014
					</span>
				</li>
				<!-- /.timeline-label -->
				<!-- timeline item -->
				<li>
				<i class="fa fa-camera bg-purple"></i>

				<div class="timeline-item">
					<span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>

					<h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

					<div class="timeline-body">
					<img src="http://placehold.it/150x100" alt="..." class="margin">
					<img src="http://placehold.it/150x100" alt="..." class="margin">
					<img src="http://placehold.it/150x100" alt="..." class="margin">
					<img src="http://placehold.it/150x100" alt="..." class="margin">
					</div>
				</div>
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
