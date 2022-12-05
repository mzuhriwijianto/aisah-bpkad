@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/adm_penghapusans') }}">Adm penghapusan</a> :
@endsection
@section("contentheader_description", $adm_penghapusan->$view_col)
@section("section", "Adm penghapusans")
@section("section_url", url(config('laraadmin.adminRoute') . '/adm_penghapusans'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Adm penghapusans Edit : ".$adm_penghapusan->$view_col)

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
		
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-2">
				{!! Form::model($adm_penghapusan, ['route' => [config('laraadmin.adminRoute') . '.adm_penghapusans.update', $adm_penghapusan->id ], 'method'=>'PUT', 'id' => 'adm_penghapusan-edit-form']) !!}
					{{-- @la_form($module) --}}					

					@la_input($module, 'no_surat')
					@la_input($module, 'tanggal_surat')
					@la_input($module, 'pejabat')
					@la_input($module, 'jenis_surat')
					@la_input($module, 'no_sk_penghapusan')
					@la_input($module, 'tgl_sk_penghapusan')
					@la_input($module, 'no_berita_acara')
					@la_input($module, 'tgl_berita_acara')
					
							<label for="rekening">Alasan</label>
							<select name="kd_alasan" id="kd_alasan" class="form-control">
								<option value="">== Pilih Alasan ==</option>
								<option value="%">%</option>
								 @foreach($alasan as $alasans)
									<option value="{{ $alasans -> kd_alasan }}" >
										{{ $alasans -> kd_alasan.'.'.$alasans -> ur_alasan }}
									</option>
								 @endForeach
							</select>					
					
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} 
						<button class="btn btn-default pull-right">
							<a href="{{ url(config('laraadmin.adminRoute') . '/adm_penghapusans') }}">Cancel</a>
						</button>
						
					</div>
				{!! Form::close() !!}
			</div>
			<div class="row">
			  <div class="col-6 border-right">
				<div class="form-group">
						<button id = "showbrg" class="btn btn-success" data-toggle="modal" data-target="#addbrg" >Add Barang</button>
						<button id = "showbrgbcd" class="btn btn-primary" data-toggle="modal" data-target="#addbrgbcd" >Scan Barcode</button>
				</div>
			  </div>
			  <div class="col-2 border-right">
				<label for="rekening">DAFTAR BARANG </label>
				<hr class="divider">
				<div class="box-body table-responsive">
				<table id="total" class="table table-bordered table-striped">
					<thead>
						<tr class="bg-purple">															
							<th colspan = 6 class="text-center">Total harga</th>																																																																				
						</tr>
					</thead>
					<tbody>
						@foreach ($datasum as $datasums)
						<tr class="text-center">
							<td><b>{{ $datasums->jmlharga }} </b></td>
						</tr>
						@endforeach	
					</tbody>
				</table>
				</div>
				 <div class="form-group">					
						<button id = "{{ $adm_penghapusan->id }}"
						   href="url(config('laraadmin.adminRoute')/hapusbarangaset/'{{ $adm_penghapusan->id }})."
						   class="btn btn-danger" type="button" onclick = "delbrgaset(this.id)" 
						   value = "{{ $adm_penghapusan->id }}" enabled>Proses Penghapusan
						 </button>
						
						
				 </div>
				<div class="box-body table-responsive">
					<table id="pm" class="table table-bordered table-striped">
					<thead>
					<tr class="bg-aqua">
						<th>No.</th>															
						<th>IDPemda</th>															
						<th>Dept</th>															
						<th>Jenis Aset</th>															
						<th>Kondisi</th>							
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
						<th colspan = 2 class="text-center">KET</th>																																																					
						<th>Status Hapus</th>																																																					
						<th>Action</th>																																																					
					 </tr>
					</thead>
					<tbody id = "pm1">
						@foreach ($data as $index =>$datas)
						<tr>
							<td>{{ $index + 1 }}</td>
							<td>{{ $datas->idpemda }}</td>
							<td>{{ $datas->dept }}</td>
							<td>{{ $datas->Jenis_aset }}</td>
							<td>{{ $datas->Uraian }}</td>
							<td>{{ date('d-m-Y', strtotime($datas->tgl_pembukuan)) }}</td>
							<td>{{ $datas->no_register }}</td>
							<td>{{ $datas->harga }}</td>
							<td>{{ $datas->nomor_polisi }}</td>
							<td>{{ $datas->merk }}</td>
							<td>{{ $datas->type }}</td>
							<td>{{ $datas->luas }}</td>
							<td>{{ $datas->Luas_Lantai }}</td>
							<td>{{ $datas->Konstruksi }}</td>
							<td>{{ $datas->lokasi }}</td>
							<td>{{ $datas->Judul }}</td>
							<td>{{ $datas->Keterangan }}</td>
							<td>
							@if($datas->status_hapus == 0 || $datas->status_hapus == '') 
								<i class="fa fa-times btn-info btn-sm" alt = "Belum ada Jadwal">Belum ada Jadwal</i>	
							@elseif ($datas->status_hapus == 1)
								<i class="fa fa-check btn-warning btn-sm" alt = "Belum ada Jadwal">Siap Dihapus</i>	
							@elseif ($datas->status_hapus == 2)
								<i class="fa fa-check btn-danger btn-sm" alt = "Belum ada Jadwal">Telah Dihapus</i>
							@else
								<i class="fa fa-check btn-secondary btn-sm" alt = "Belum ada Jadwal">Silahkan Hubungi Bidang Aset</i>
							@endif
							</td>
							<td>
							@if ($datas->status_hapus == 2)
								<button id = "{{$datas->idpemda}}" 
							   href="url(config('laraadmin.adminRoute')/delbrgidphp/'$datas->idpemda)."
							   class="btn btn-danger" type="button" onclick = "delidpemda(this.id)" 
							   value = "{{ $datas->idpemda }}" disabled>Del</button>
							@else
								<button id = "{{$datas->idpemda}}" 
							  href="url(config('laraadmin.adminRoute')/delbrgidphp/'$datas->idpemda)."
							   class="btn btn-danger" type="button" onclick = "delidpemda(this.id)" 
							   value = "{{ $datas->idpemda }}" enabled>Del</button>
							@endif
							
							 </td>
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
			  <div class="col-6">
			  <hr class="divider">				
				<div class="col-md-10">
					<div class="modal fade" id="addbrg" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button  type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="myModalLabel">Add Barang</h4>
								</div>
								<div class="modal-body">
								<div class="form-group" >
									<h3>No Surat:</h3>
										<input type="text" id="ajuan" class="form-control" value="{{ $adm_penghapusan->no_surat }}" readonly />
									<!--<h2>Keterangan/Lokasi/Judul</h2>
									<input type="text" name="search" id="search" class="form-control" placeholder="Cari.." />-->
								</div>
									<div class="box-body table-responsive">
										<table id="example1" class="table table-bordered table-striped">
										<thead>
										<tr class="bg-aqua">
											<th>No.</th>
											<th>Action</th>											
											<th>IDPemda</th>																														
											<th>Dept</th>															
											<th>Jenis Aset</th>															
											<th>Kondisi</th>							
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
											<th colspan = 2 class="text-center">KET</th>																																																															
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
										<h3>No Surat:</h3>
											<input type="text" id="ajuan" class="form-control" value="{{ $adm_penghapusan->no_surat }}" readonly />
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
	</div>
</div>

@endsection

@push('scripts')
<script>
$(function () {
	$("#adm_penghapusan-edit-form").validate({
		
	});
});

function reload(){
	location.reload();
}

jQuery(document).ready(function () {						
		jQuery(document).on('click', '#showbrg', function(e){
				$(document).ready(function () {

					fetch_customer_data();

					function fetch_customer_data(query = '') {
						$.ajax({
							
							url : '/admin/showbarangaadm/'+{{ $adm_penghapusan->id }},
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
        });
	});

function getidpemda(clicked_id){
			var idadm =  {{ $adm_penghapusan->id }};
			var idpemdas =  clicked_id;		
			
					   $.ajax({
						url : '/admin/updatebrgidphp/'+idadm+'/'+idpemdas,
						headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
						method: 'POST',						
						data: {
								  "_token": "{{ csrf_token() }}",
								  "adm_php_id": idadm
							  },
						dataType: 'json',
						success: function (data) {					  
							document.getElementById(clicked_id).disabled = true;
						}
					}).fail(function(){
						//console.log('failed');
						document.getElementById(clicked_id).disabled = true;
					});	   

}

function delidpemda(clicked_id){
			
			var idpemdas =  clicked_id;		
			
					   $.ajax({
						url : '/admin/delbrgidphp/'+idpemdas,
						headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
						method: 'POST',						
						data: {
								  "_token": "{{ csrf_token() }}"
							  },
						dataType: 'json',
						success: function (data) {					  
							document.getElementById(clicked_id).disabled = true;
							reload();
						}
					}).fail(function(){
						//console.log('failed');
						document.getElementById(clicked_id).disabled = true;
						reload();
					});	   

}
function delbrgaset(clicked_id){
			
			var idadm =  clicked_id;		
			//alert(idadm);
					  $.ajax({
						url : '/admin/hapusbarangaset/'+idadm,
						headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
						method: 'GET',						
						dataType: 'json',
						success: function (data) {
							//alert(url);
							document.getElementById(clicked_id).disabled = true;
							reload();
						}
						
						
					}).fail(function(){
						//alert(url);
						document.getElementById(clicked_id).disabled = true;
						reload();
					});  

}
function cleartxt(){
	document.getElementById('myInput').value = ''
}
function updateRecord(){
var idpemda = document.getElementById('myInput').value;
var idadm =  {{ $adm_penghapusan->id }};
    $.ajax({
						url : '/admin/updatebrgidphp/'+idadm+'/'+idpemda,
						headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
						method: 'POST',						
						data: {
								 "_token": "{{ csrf_token() }}",
								  "adm_php_id": idadm
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


function valinst() {
 // check if input is bigger than 17
var idpemda = document.getElementById('myInput').value;
	if(idpemda.length <= 17){
		setTimeout(function() {
		//your code to be executed after 1 second
			if (idpemda.length = 17) { 
				updateRecord();
				//alert('Data found');
			}else{
				alert('Data not found');
			}
		}, 100);
	}
}
</script>
@endpush
