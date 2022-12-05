@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/daftar_pegawais') }}">Daftar pegawai</a> :
@endsection
@section("contentheader_description", $daftar_pegawai->$view_col)
@section("section", "Daftar pegawais")
@section("section_url", url(config('laraadmin.adminRoute') . '/daftar_pegawais'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Daftar pegawais Edit : ".$daftar_pegawai->$view_col)

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
	<div class="col-sm-3" style="border:#f2f2f2; border-width:0.2px 0.2px 0px 0px; border-style:solid;">
		<h4 class="alert alert-info"> Data Pegawai</h4>
				{!! Form::model($daftar_pegawai, ['route' => [config('laraadmin.adminRoute') . '.daftar_pegawais.update', $daftar_pegawai->id ], 'method'=>'PUT', 'id' => 'daftar_pegawai-edit-form']) !!}
					{{--@la_form($module)--}}
					
					
					@la_input($module, 'nama')
					@la_input($module, 'nip')
					@la_input($module, 'jabatan')
					@la_input($module, 'instansi')
					@la_input($module, 'telp')
					
                    <br>
					<div class="form-group">
						{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!} <button class="btn btn-secondary pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/daftar_pegawais') }}">Cancel</a></button>
					</div>
				{!! Form::close() !!}
		
	</div>
	<div class="col-md-3" style="border:#f2f2f2; border-width:0.2px 0.2px 0px 0px; border-style:solid;">
					<h4 class="alert alert-success"> Data Barang</h4>
						<div class="col-md-12">
							<label for="rekening">Rek 0</label>
							<select name="rek0" id="rek0" class="form-control">
								<option value="">== Pilih Rekening 0 ==</option>
								<option value="%">%</option>
								 @foreach($refrek0 as $refrek0s)
									<option value="{{ $refrek0s -> kd_aset0 }}">
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
						<div class="col-md-12">
							<br/>
							<button id = "showbrg" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addbrg" enabled>Show Barang</button>
																			
						</div>
						<div class="col-md-12">
						<br/>
						</div>
	</div>
	<div class="col-md-3" style="border:#f2f2f2; border-width:0.2px 0.2px 0px 0px; border-style:solid;">
	<h4 class="alert alert-warning"> Report</h4>
		<div class="btn-group" role="group" aria-label="Basic example">	
			<button class="btn btn-info" onclick=" window.open('{{url('admin/printbrgpgw/'.$daftar_pegawai->id)}}','_blank')">PDF</button>
		</div>
	</div>
	</div>
	<div class="col-md-12">
		<div class="modal fade" id="addbrg" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button  type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Edit Barang</h4>
					</div>
					<div class="modal-body">
					<div class="form-group" >
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
								<th>Tgl Perolehan</th>																																																													
								<th>No Reg</th>																											
								<th>Harga</th>																																																						
								<th>NOPOL</th>																																																						
								<th>Merk</th>																											
								<th>Type</th>																																																						
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
	<hr/>		

</div>
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
					<th rowspan="2">No. Polisi</th>
					<th rowspan="2">Thn Perolehan</th>				
					<th rowspan="2">Merk/Type</th>																																																																
					<th rowspan="2">Bahan</th>								
					<th rowspan="2">Kondisi Awal</th>																																																																																																																																							
					<th rowspan="2">Kondisi Akhir</th>																																																																																																																																							
					<th rowspan="2">Harga</th>																																																																																																																									
					<th rowspan="2">KET</th>																																																																																																																									
					<th rowspan="2">FOTO BARANG</th>																																																																																																																									
					<th rowspan="2">FOTO KENDARAAN</th>																																																																																																																									
					<th rowspan="2">Action</th>																											
					<th rowspan="2">Label</th>																											
				 </tr>
				</thead>
				<tbody id = "pm1">
					@foreach ($kibbsuserbrg as $index =>$kibbsuserbrgs)
					<tr>
						<td>{{ $index + 1 }}</td>
						<td>{{ $kibbsuserbrgs->kd_barang }}</td>
						<td>{{ $kibbsuserbrgs->no_reg }}</td>
						<td>{{ $kibbsuserbrgs->Nm_Aset5 }}</td>
						<td>{{ $kibbsuserbrgs->nomor_polisi }}</td>
						<td>{{ $kibbsuserbrgs->tgl_perolehan }}</td>
						<td>{{ $kibbsuserbrgs->merk }} - {{ $kibbsuserbrgs->type }}</td>
						<td>{{ $kibbsuserbrgs->bahan }}</td>
						<td>{{ $kibbsuserbrgs->kondisi }}</td>
						<td>{{ $kibbsuserbrgs->kondisi_akhir }}</td>
						<td>{{ $kibbsuserbrgs->harga }}</td>					
						<td>{{ $kibbsuserbrgs->keterangan }}</td>
						<td>
							@if($kibbsuserbrgs->imgname != '')							
							
							<img src="{{url('/storage/imgkib/Image/'.$kibbsuserbrgs->imgname)}}"alt="gambar" width = "190" height = "160"/>
							<form action="/admin/daftar_pegawais/upload-file/{{ $daftar_pegawai->id }}/{{ $kibbsuserbrgs->idpemda }}" method="post" enctype="multipart/form-data">														
								<input name="_token" type="hidden" value="{{ csrf_token() }}">
									<div class="custom-file">
										<input type="file" name="file" class="custom-image-input" id="chooseFile">
									</div>
									<button type="submit" name="submit" class="btn btn-warning btn-block mt-4">
										Update Files
									</button>
							</form>
							@else				
								<form action="/admin/daftar_pegawais/upload-file/{{ $daftar_pegawai->id }}/{{ $kibbsuserbrgs->idpemda }}" method="post" enctype="multipart/form-data">														
								<input name="_token" type="hidden" value="{{ csrf_token() }}">
									<div class="custom-file">
										<input type="file" name="file" class="custom-image-input" id="chooseFile">
									</div>
									<button type="submit" name="submit" class="btn btn-warning btn-block mt-4">
										Update Files
									</button>
								</form>	
							@endif
						</td>
						<td>
							@if($kibbsuserbrgs->photokendaraan != '')															
							<a target="_blank" href="{{url('/files/'.$kibbsuserbrgs->hashphoto.'/'.$kibbsuserbrgs->photokendaraan)}}"> <i class="fa fa-check btn-success btn-xs"> Preview </i>
							@else
							<i class="fa fa-times btn-danger btn-xs">
							@endif
						</td>
						<td>
						 <button id = "{{ $kibbsuserbrgs->id }}" 
								   href="{{ url(config('laraadmin.adminRoute') . '/delbrgpemegang/'.$kibbsuserbrgs->id)}}" 
								   class="btn btn-danger" type="button" onclick = "delidpemda(this.id)" 
								   value = "{{ $kibbsuserbrgs->idpemda }}" enabled>Del</button>
						</td>
						 <td>
							 <a href="{{url(config('laraadmin.adminRoute') . '/label/'.$kibbsuserbrgs->id)}}"  target="_blank"><button  class="btn btn-info">Print Label</button></a>	
							 </td>
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

@endsection

@push('scripts')
<script>
$(function () {
	$("#daftar_pegawai-edit-form").validate({
		
	});
});
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
				var kdbidang = {{ $kdbidang }};
				var kdunit = {{ $kdunit }};			
				var kdsub = {{ $kdsub }};			
				var kdupb = {{ $kdupb }};			
            fetch_customer_data();

            function fetch_customer_data(query = '') {
                jQuery.ajax({
				url:'/admin/showbarang/'+{{$daftar_pegawai->id}}+'/'+kdbidang+'/'+kdunit+'/'+kdsub+'/'+kdupb+'/'+ids+'/'+idss+'/'+ids3+'/'+ids4+'/'+kond,
                    method: 'GET',
                    data: {query: query},
                    dataType: 'json',
                    success: function (data) {
					   //console.log(data);
                       $('#tbody1').html(data.table_data);
					   
                    }
                }).fail(function(){
					$('#tbody1').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
					//$('#tbody1').html(ids,idss,ids3,ids4,kond);
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
			var ids4 = $("#rek4 option:selected").val();
			var ids3 = $("#rek3 option:selected").val();
			var idss = $("#rek2 option:selected").val();
			var ids = $("#rek1 option:selected").val();
			var kond = $("#kond option:selected").val();
			var kdbidang = {{ $kdbidang }};
			var kdunit = {{ $kdunit }};			
			var kdsub = {{ $kdsub }};			
			var kdupb = {{ $kdupb }};
			//var url:'/admin/showbarang/'+{{$daftar_pegawai->id}}+'/'+kdbidang+'/'+kdunit+'/'+kdsub+'/'+kdupb+'/'+ids+'/'+idss+'/'+ids3+'/'+ids4+'/'+kond,
			var pemegang =  {{ $daftar_pegawai->id }};
			var idpemdas =  clicked_id;		
			
					   $.ajax({
						url : '/admin/updbrg/'+idpemdas+'/3'+'/'+ids+'/'+idss+'/'+ids3+'/'+ids4+'/'+{{$daftar_pegawai->id}},
						headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
						method: 'GET',						
						data: {
								  "_token": "{{ csrf_token() }}",
								  "pemegang_brg": {{$daftar_pegawai->id}}
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
function reload(){
	location.reload();
}
function delidpemda(clicked_id){
	
	var id =  clicked_id;
		
	
						$.ajax({
						url : '/admin/delbrgpemegang/'+id,
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
</script>
@endpush
