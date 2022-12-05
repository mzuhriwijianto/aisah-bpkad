<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ LAConfigs::getByKey('site_description') }}">
    <meta name="author" content="Dwij IT Solutions">

    <meta property="og:title" content="{{ LAConfigs::getByKey('sitename') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="{{ LAConfigs::getByKey('site_description') }}" />
    
    <meta property="og:url" content="http://laraadmin.com/" />
    <meta property="og:sitename" content="laraAdmin" />
	<meta property="og:image" content="http://demo.adminlte.acacha.org/img/LaraAdmin-600x600.jpg" />
    
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@laraadmin" />
    <meta name="twitter:creator" content="@laraadmin" />
    
    <title>{{ LAConfigs::getByKey('sitename') }}</title>
    
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('/la-assets/css/bootstrap.css') }}" rel="stylesheet">

	<link href="{{ asset('la-assets/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    
    <!-- Custom styles for this template -->
    <link href="{{ asset('/la-assets/css/main.css') }}" rel="stylesheet">

    <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,300,700' rel='stylesheet' type='text/css'>

    <script src="{{ asset('/la-assets/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('/la-assets/js/smoothscroll.js') }}"></script>


</head>

<body data-spy="scroll" data-offset="0" data-target="#navigation">
<div id="watermark">
	 <!--<img src="https://drive.google.com/thumbnail?id=12KPV_2qCGrnYubEA5gRAI-ZwdQI3u_sq" />-->
</div>
<div id="page-content" class="profile2">
	
		<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="tab-timeline">
			<ul class="timeline timeline-inverse">

				<div class="timeline-item">
					<div class="timeline-body">
					<div class="box-body table-responsive">
						<table style="width: 100%;">
							<tbody>
								<tr>
									<td style="width: 8%;text-align:center;">
										<!--<b style = "font-size: 20px;" ><img src="{{ public_path('la-assets\img\Logo.jpg') }}" alt="Logo" width="45" class="logo"/></b>-->
										<b style = "font-size: 20px;" ><img src="https://drive.google.com/thumbnail?id=1E9Gzlyi0RPb1-Vg6LDPM6i-O-UKGsuV8" alt="Logo" width="65" class="logo"/></b>
									</td>
									<td style="width: 50%;text-align:center;">
										<b style = "font-size: 30px;" > PEMERINTAH KABUPATEN BOJONEGORO</b>
										<br/>
										<h3 class="timeline-header"><a href="#">PERALATAN & MESIN</a></h3>
									</td>
									<td style="width: 10%;text-align:right;font-size: 7px;">
										
									</td>
								</tr>
							</tbody>

						</table>
						<table id="pm" class="table table-bordered table-striped">
							<thead>
							@foreach ($check as $index =>$checks)
							<tr class="bg-aqua"><th>OPD</th><td>{{ $checks->nm_sub_unit }}</td></tr>
							<tr class="bg-aqua"><th>Kode Brg</th><td>{{ $checks->kd_barang }}</td></tr>
							<tr class="bg-aqua"><th>No Reg</th><td>{{ $checks->no_reg }}</td></tr>					
							<tr class="bg-aqua"><th>Nama Brg</th><td>{{ $checks->Nm_Aset5 }}</td></tr>
							<tr class="bg-aqua"><th>Thn Perolehan</th><td>{{ $checks->tgl_perolehan }}</td></tr>				
							<tr class="bg-aqua"><th>Merk/Type</th><td>{{ $checks->merk }} - {{ $checks->type }}</td></tr>																																																																
							<tr class="bg-aqua"><th>No Polisi</th><td>{{ $checks->nomor_polisi }}</td></tr>																																																																
							<tr class="bg-aqua"><th>No Rangka</th><td>{{ $checks->nomor_rangka }}</td></tr>																																																																
							<tr class="bg-aqua"><th>No Mesin</th><td>{{ $checks->nomor_mesin }}</td></tr>																																																																
							<tr class="bg-aqua"><th>Bahan</th><td>{{ $checks->bahan }}</td></tr>								
							<tr class="bg-aqua"><th>Asal Usul</th><td>{{ $checks->asal_usul }}</td></tr>																																																																																																																																							
							<tr class="bg-aqua"><th>Harga</th><td>{{ $checks->harga }}</td></tr>																																																																																																																									
							<tr class="bg-aqua"><th>KET</th><td>{{ $checks->keterangan }}</td></tr>																																																																																							
							<tr class="bg-aqua"><th>Validation Image</th>
									<td>					
									@if($checks->imgname != '')
									<img src="{{url('/storage/imgkib/Image/'.$checks->imgname)}}" alt="gambar" style="width:150px;height:150px;"/>								
									@else
									<i>no pic</i>
									@endif					
									</td></tr>																																																																																							
																																																																																														
							<tr class="bg-aqua"><th>Pemegang Barang</th><td>{{ $checks->nama }}</td></tr>
							<tr class="bg-aqua"><th>Label</th><td>
							<a href="{{url(config('laraadmin.adminRoute') . '/label/'.$checks->idkibb)}}"><button  class="btn btn-info">Print Label</button></a>
							 	
							 </td></tr>
							@endforeach
							</thead>
						</table>
					</div>
					</div>
				</div>
				<table style="width: 100%;">
					<hr/>
						<tbody>
							<tr>
								<td style="width: 10%;text-align:left;font-size: 7px;">
									<b>{{ Module::userlogin()->dept_name }}</b>
									<br/>
									<b>KABUPATEN BOJONEGORO</b>
									<br/>
									<b>Print at : {{ date('d-m-Y') }}</b>				
									<br/>
									<i>Url:</i>
									<i>{{ url(config('laraadmin.adminRoute')) }}</i>
								</td>
								<td style="width: 50%;text-align:center;">
								</td>
								<td style="width: 10%;text-align:right;font-size: 7px;">
									<b>BADAN PENGELOLAAN KEUANGAN DAN</b>
									<br/>
									<b>ASET DAERAH</b>
									<b>KABUPATEN BOJONEGORO</b>
									<br/>
									<i>Jl. P. Mastumapel No.01</i>
									<i>Bojonegoro</p>
									<i>Jawa Timur, Indonesia</i>
								</td>
								
							</tr>
						</tbody>

					</table>
				
			</ul>
			<!--<div class="text-center p30"><i class="fa fa-list-alt" style="font-size: 100px;"></i> <br> No posts to show</div>-->
		</div>
		
	</div>
	</div>
	</div>
</div>
</body>
</html>
