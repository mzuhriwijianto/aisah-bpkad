@extends("la.layouts.app")

@section("contentheader_title", "Persediaan instocks")
@section("contentheader_description", "Persediaan instocks listing")
@section("section", "Persediaan instocks")
@section("sub_section", "Listing")
@section("htmlheader_title", "Persediaan instocks Listing")

@section("headerElems")
@la_access("Persediaan_instocks", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add Persediaan instock</button>
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
		<li class=""><a role="tab" data-toggle="tab" href="#lists" data-target="#tab-timeline"><i class="fa fa-clock-o"></i>Rekapitulasi</a></li>
</ul>

<div class="tab-content">
	<div role="tabpanel" class="tab-pane active fade in" id="tab-info">
		<div class="form-group" class = "col-sm-12">
			
			<div class="col-md-1">
				<label for="name" >Tahun</label>
				<select name="thn" id="thn" class="form-control">
					<option value="">== Pilih Tahun ==</option>
					{{ $last= date('Y')-1 }}
					{{ $now = date('Y') }}

					@for ($i = $now; $i >= $last; $i--)
						<option value="{{ $i }}">{{ $i }}</option>
					@endfor
				</select>
			</div>
			<div class="col-md-2">
				<label for="bidangs">Bidang</label>
				<select name="bidangs" id="bidangs" class="form-control">
					<option value="">== Pilih Bidang ==</option>
					<option value="%">%</option>
					 @foreach($refbidang as $refbidangs)
						<option value="{{ $refbidangs -> kd_bidang }}">
							{{ $refbidangs->kd_bidang.'.'.$refbidangs->nm_bidang }}
						</option>
					 @endForeach
				</select>					
			</div>
			<div class="col-md-2">
				<label for="unit" >Unit</label>
				<select name="units" id="units" class="form-control">
					<option value="">== Pilih Unit ==</option>

				</select>
			</div>
			<div class="col-md-2">
				<label for="sub" >Sub</label>
				<select name="subs" id="subs" class="form-control">
					<option value="">== Pilih Sub ==</option>
				</select>
			</div>
			<div class="col-md-3">
				<label for="upb" >UPB</label>
				<select name="upbs" id="upbs" class="form-control">
					<option value="">== Pilih UPB ==</option>
				</select>
			</div>

			<div class="col-md-1">
				<br/>
				<button id = "showbrg" class="btn btn-success btn-sm">Show Barang</button>																																
			</div>
			<div class="col-md-12">
			<br/>
			</div>
		</div>
		<div class="form-group" class = "col-sm-4">
			<div class="col-md-12">
			<label for="alamat" >Jenis Persediaan/Nama Barang/Uraian Barang</label>
				<input type="text" name="search" id="search" class="form-control" placeholder="Cari.." />
			</div>	
		</div>
		
		<div class="panel infolist">
			<div class="col-md-12">
				<table class="table table-bordered table-striped">
				<thead>
					<tr class="bg-aqua">
						<th>No.</th>
						<th>TAHUN</th>
						<th>TGL INSTOCK</th>
						<th>JENIS PERSEDIAAN</th>
						<th>ID BARANG</th>
						<th>NAMA BARANG</th>
						<th>URAIAN</th>
						<th>TYPE</th>
						<th>SATUAN</th>
						<th>JUMLAH</th>
						<th>HARGA</th>
						<th>ACTION</th>
					</tr>
				</thead>
				<tbody id= "tbody1">	

				</tbody>
				</table>
			</div>	
		</div>
	</div>
	<div role="tabpanel" class="tab-pane fade in" id="tab-timeline">
		<div class="form-group" class = "col-sm-12">
			<div class="col-md-2">
				<label for="tglawal" >Tanggal Awal</label>
				<div class="form-group">
					<input type="text" class="form-control datetimepicker" name="tglawal" id = "tglawal"> 
				</div>
			</div>
			<div class="col-md-2">
				<label for="tglakhir" >Tanggal Akhir</label>
				<div class="form-group">
					<input type="text" class="form-control datetimepicker" name="tglakhir" id = "tglakhir"> 
				</div>
			</div>

			<div class="col-md-1">
				<br/>
				<button id = "showrkp" class="btn btn-success btn-sm">Show Rekap</button>																																
			</div>
			<div class="col-md-12" >	
				<label for="search4" >Nama/Uraian Barang</label>
				<input type="text" name="search4" id="search4" class="form-control" placeholder="Cari.." />
			</div>
			<div class="col-md-12">
			<br/>
			</div>
		</div>
		
		<div class="panel infolist">
			<div class="col-md-12">
				<table class="table table-bordered table-striped">
				<thead>
					<tr class="bg-aqua">
						<th>No.</th>
						<th>JENIS PERSEDIAAN</th>
						<th>NAMA BARANG</th>
						<th>URAIAN</th>
						<th>TYPE</th>
						<th>SATUAN</th>
						<th>JUMLAH</th>
						<th>HARGA</th>
					</tr>
				</thead>
				<tbody id= "tbody4">	

				</tbody>
				</table>
			</div>	
		</div>
	</div>
</div>
<div id="loader" class="lds-dual-ring hidden overlay"></div>
@la_access("Persediaan_instocks", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Persediaan instock</h4>
			</div>
			{!! Form::open(['action' => 'LA\Persediaan_instocksController@store', 'id' => 'persediaan_instock-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">                					
				<div class="col-md-12">
					<label for="upbuser" >UPB</label>
					<select name="upbuser" id="upbuser" class="form-control" required>
						<option value="1">== Pilih UPB ==</option>
							 @foreach($upbuser as $upbusers)
								<option value="{{ $upbusers -> kd_upb }}">
									{{ $upbusers->kd_upb.'.'.$upbusers->nm_upb }}
								</option>
							 @endForeach
					</select>
				</div>
					<div class="col-md-12">
						@la_input($module, 'tgl_instock')					
					</div>
					<div class="col-md-12">
						<label for="persediaans">Ref Persediaan</label>
						<select name="persediaans" id="persediaans" class="form-control" required>
							<option value="1">== Pilih Ref ==</option>
							 @foreach($refpersediaan as $refpersediaans)
								<option value="{{ $refpersediaans -> id }}">
									{{ $refpersediaans->id.'.'.$refpersediaans->jenis_persediaan }}
								</option>
							 @endForeach
						</select>					
					</div>
					<div class="col-md-12">
						<label for="baranggroup">Ref Barang</label>
						<select name="baranggroup" id="baranggroup" class="form-control" required>
							<option value="1">== Pilih Barang ==</option>
						</select>					
					</div>
					<div class="col-md-12" id = "tablebarang">
						<label for="barangs">Barang</label>
						<table class="table table-bordered" >
						<thead>
							<tr class="bg-aqua">
								<th>No.</th>										
								<th>ACTION</th>										
								<th>NAMA BARANG</th>
								<th>URAIAN</th>
								<th>SATUAN</th>
								<th>TYPE</th>																																																																																																																												
							</tr>
						</thead>
						<tbody id= "tbody2">	

						</tbody>
						</table>			
					</div>
					<div class="col-md-12">
						<input type="hidden" name="dipilih" id="dipilih" class="form-control" placeholder="Print.." readonly />
					</div>
					<div class="col-md-12">
						<label for="barangs">Barang</label>
						<input type="text" name="barang" id="barang" class="form-control" placeholder="..." readonly />
						<label for="barangs">Uraian</label>
						<input type="text" name="uraian" id="uraian" class="form-control" placeholder="..." readonly />
						<label for="barangs">Satuan</label>
						<input type="text" name="satuan" id="satuan" class="form-control" placeholder="..." readonly />
						<label for="barangs">Type</label>
						<input type="text" name="tipe" id="tipe" class="form-control" placeholder="..." readonly />
						<label for="barangs">Harga</label>
						<input type="text" name="harga" id="harga" class="form-control" placeholder="0"/>
					</div>
					<div class="col-md-12">
						@la_input($module, 'jml_instock')				
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				{!! Form::submit( 'Submit', ['class'=>'btn btn-success']) !!}
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
@endla_access
<div class="modal fade" id="editbrg" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button  type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Edit instock</h4>
			</div>
			<div class="modal-body">
			<div class="col-md-8 col-md-offset-2">
				<form action="/admin/updateitempersediaan/" method="POST" enctype="multipart/form-data">
				<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
					<div class="col-md-12">
					<label for="upbuser" >UPB</label>
						<select name="upbuser" id="upbuser" class="form-control" required>
							<option value="1">== Pilih UPB ==</option>
								 @foreach($upbuser as $upbusers)
									<option value="{{ $upbusers -> kd_upb }}">
										{{ $upbusers->kd_upb.'.'.$upbusers->nm_upb }}
									</option>
								 @endForeach
						</select>
					</div>
					<div class="col-md-12">
						<label for="tgl">Tgl Instock</label>
						<input type="text" name="tglinstocks" id="tglinstocks" class="form-control" placeholder="..." readonly/>
						<br/>
						@la_input($module, 'tgl_instock')					
					</div>
					<div class="col-md-12">
						<label for="persediaans">Ref Persediaan</label>
						<select name="persediaansedit" id="persediaansedit" class="form-control" required>
							<option value="1">== Pilih Ref ==</option>
							 @foreach($refpersediaan as $refpersediaans)
								<option value="{{ $refpersediaans -> id }}">
									{{ $refpersediaans->id.'.'.$refpersediaans->jenis_persediaan }}
								</option>
							 @endForeach
						</select>					
					</div>
					<div class="col-md-12">
						<label for="baranggroupedit">Ref Barang</label>
						<select name="baranggroupedit" id="baranggroupedit" class="form-control" required>
							<option value="1">== Pilih Barang ==</option>
						</select>					
					</div>
					<div class="col-md-12" id = "tablebarangedit">
						<label for="barangs">Barang</label>
						<table class="table table-bordered" >
						<thead>
							<tr class="bg-aqua">
								<th>No.</th>										
								<th>ACTION</th>										
								<th>NAMA BARANG</th>
								<th>URAIAN</th>
								<th>SATUAN</th>
								<th>TYPE</th>																																																																																																																												
							</tr>
						</thead>
						<tbody id= "tbody3">	

						</tbody>
						</table>			
					</div>
					<div class="col-md-12">
						<input type="hidden" name="dipilihs" id="dipilihs" class="form-control" placeholder="Print.." readonly />
						<input type="hidden" name="iditem" id="iditem" class="form-control" placeholder="Print.." readonly />
					</div>
					<div class="col-md-12">
						<label for="barangs">Barang</label>
						<input type="text" name="barangs" id="barangs" class="form-control" placeholder="..." readonly />
						<label for="barangs">Uraian</label>
						<input type="text" name="uraians" id="uraians" class="form-control" placeholder="..." readonly />
						<label for="barangs">Satuan</label>
						<input type="text" name="satuans" id="satuans" class="form-control" placeholder="..." readonly />
						<label for="barangs">Type</label>
						<input type="text" name="tipes" id="tipes" class="form-control" placeholder="..." readonly />
						<label for="barangs">Jumlah</label>
						<input type="text" name="jumlahs" id="jumlahs" class="form-control" placeholder="..."/>
						<label for="barangs">Harga</label>
						<input type="text" name="hargas" id="hargas" class="form-control" placeholder="..."/>
					</div>					
					<div class="col-md-12" align = "right">
						<!--<button type="submit" type = "submit" name = "submit" class="btn btn-warning">Update</button>-->
						<button class="btn btn-warning" onclick = "insertRecord();" >UPDATE</button>	
					</div>
				</form>
				{!! Form::close() !!}
			</div>
			</div>
			<div class="modal-footer">
			
			</div>
		</div>
	</div>
</div>




@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script>
 $(function () {
            $('.datetimepicker').datetimepicker({format:'Y-M-D'});
        });
function getInputValue(clicked_id){
	var property = document.getElementById(clicked_id);	

	document.getElementById("dipilihs").value = clicked_id;
	document.getElementById("iditem").value = document.getElementById("getidbutton" ).value;
	$('#editbrg').modal('show');
}
//load rek1
jQuery(document).ready(function (){
            jQuery('select[name="bidangs"]').on('change',function(){
               var bidang = jQuery(this).val();
              
               if(bidang){
                  jQuery.ajax({
                     url : '/admin/instock_unit/' +bidang,
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
               }else{
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
                     url : '/admin/instock_sub/'+bidang+'/'+unit,
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
jQuery(document).ready(function (){
            jQuery('select[name="subs"]').on('change',function(){
				var unit = jQuery(this).val();
			    var bidang = $("#bidangs option:selected").val();
			    var sub = $("#subs option:selected").val();
               
               if(unit){				  
                  jQuery.ajax({
                     url : '/admin/instock_upb/'+bidang+'/'+unit+'/'+sub,
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

//search
jQuery(document).ready(function () {						
		jQuery(document).on('click', '#showbrg', function(e){
				var thn = $("#thn option:selected").val();
				var kdbidang = $("#bidangs option:selected").val();
				var kdunit = $("#units option:selected").val();		
				var kdsub = $("#subs option:selected").val();						
				var kdupb = $("#upbs option:selected").val();
				var form = $(this);				
            fetch_customer_data();

            function fetch_customer_data(query = '') {
				$('#loader3',form).html('Please wait...');
                jQuery.ajax({
				url:"{{ url(config('laraadmin.adminRoute') . '/loadinstock') }}"+'/'+kdbidang+'/'+kdunit+'/'+kdsub+'/'+kdupb+'/'+thn,
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
//load rek1
jQuery(document).ready(function (){
            jQuery('select[name="persediaans"]').on('change',function(){
			$('#tbody2').empty();
               var refbrg = jQuery(this).val();			   
			   //fetch_customer_data();
			   //if(refbrg){
				  jQuery.ajax({
					 url : '/admin/persediaansgroup/'+refbrg,
					 type : "GET",
					 dataType : "json",
					 success:function(data)
					 {
						 //console.log(data);
                        jQuery('select[name="baranggroup"]').empty();
						$('select[name="baranggroup"]').append('<option value="%">%</option>');
                        jQuery.each(data, function(key,value){
                           $('select[name="baranggroup"]').append('<option value="'+ value +'">'+ value +'</option>');
                        });
					 }
				  });

            });
    });
//end
//load rek1
jQuery(document).ready(function (){
            jQuery('select[name="baranggroup"]').on('change',function(){
               var refbrg = $("#baranggroup option:selected").val();
				$('#tbody2').empty();
			   fetch_customer_data();
			   function fetch_customer_data(query = '') {
			   //if(refbrg){
				  jQuery.ajax({
					 url : '/admin/persediaansbrg/'+refbrg,
					 type : "GET",
					 dataType : "json",
					 success:function(data)
					 {
						$('#tablebarang').show();
						$('#tbody2').html(data.table_data);
					 }
				  });
				  
			   //}
			   }
            });
    });
//end
//load rek1
jQuery(document).ready(function (){
            jQuery('select[name="persediaansedit"]').on('change',function(){
			$('#tbody3').empty();
               var refbrg = jQuery(this).val();			   
			   //fetch_customer_data();
			   //if(refbrg){
				  jQuery.ajax({
					 url : '/admin/persediaansgroup/'+refbrg,
					 type : "GET",
					 dataType : "json",
					 success:function(data)
					 {
						 //console.log(data);
                        jQuery('select[name="baranggroupedit"]').empty();
						$('select[name="baranggroupedit"]').append('<option value="%">%</option>');
                        jQuery.each(data, function(key,value){
                           $('select[name="baranggroupedit"]').append('<option value="'+ value +'">'+ value +'</option>');
                        });
					 }
				  });

            });
    });
//end
//load rek1
jQuery(document).ready(function (){
            jQuery('select[name="baranggroupedit"]').on('change',function(){
               var refbrg = $("#baranggroupedit option:selected").val();
				$('#tbody3').empty();
			   fetch_customer_data();
			   function fetch_customer_data(query = '') {
			   //if(refbrg){
				  jQuery.ajax({
					 url : '/admin/persediaansbrg/'+refbrg,
					 type : "GET",
					 dataType : "json",
					 success:function(data)
					 {
						$('#tablebarangedit').show();
						$('#tbody3').html(data.table_data);
					 }
				  });
				  
			   //}
			   }
            });
    });
//end

 function pilihbarang(clicked_id, color) {
        var property = document.getElementById(clicked_id);				
		
		document.getElementById("dipilih").value= clicked_id;    
		document.getElementById("barang").value= document.getElementById("barangz" ).innerHTML;    
		document.getElementById("uraian").value= document.getElementById("uraianz" ).innerHTML;    
		document.getElementById("satuan").value= document.getElementById("satuanz" ).innerHTML;     
		document.getElementById("tipe").value= document.getElementById("typez" ).innerHTML;     
		property.style.backgroundColor = "#a0faf2";
		
		document.getElementById("dipilihs").value = clicked_id;
		document.getElementById("tglinstocks").value= document.getElementById("tglinstockx" ).innerHTML;    
		document.getElementById("barangs").value= document.getElementById("barangz" ).innerHTML;    
		document.getElementById("uraians").value= document.getElementById("uraianz" ).innerHTML;
		document.getElementById("tipes").value= document.getElementById("typez" ).innerHTML;
		document.getElementById("satuans").value= document.getElementById("satuanz" ).innerHTML;	
		document.getElementById("jumlahs").value= document.getElementById("jumlahx" ).innerHTML;     
		document.getElementById("hargas").value= document.getElementById("hargax" ).innerHTML;
		$('#tablebarang').hide();
    }

function insertRecord(){
var iditem = document.getElementById("iditem").value;
var refpersediaan = $("#persediaansedit option:selected").val();
var kdupb = $("#upbuser option:selected").val();
var dipilih = document.getElementById("dipilihs").value;
var tglinstocks = document.getElementById("tglinstocks").value;    
var barangs = document.getElementById("barangs").value;    
var uraians = document.getElementById("uraians").value;
var tipes  = document.getElementById("tipes" ).value;
var satuans = document.getElementById("satuans").value;	
var jumlahs = document.getElementById("jumlahs").value;     
var hargas = document.getElementById("hargas").value;

    $.ajax({
						url : '/admin/updateitempersediaans/'+iditem,
						headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
						method: 'post',						
						data: {
								   "_token": "{{ csrf_token() }}",
								  "id" : iditem,
								  "ref_persediaan": refpersediaan,
								  "ref_brg": barangs,
								  "kd_upb": kdupb,
								  "jml_instock" : jumlahs,
								  "tgl_instock" : tglinstocks,
								  "harga" : hargas
							  },
						dataType: 'json',
						//error: function(data) {alert(data);},
						success: function (data) {					  
							 alert("Update Berhasil");
							 //alert(iditem+' '+refpersediaan+' '+barangs+' '+kdupb+' '+jumlahs+' '+tglinstocks+' '+hargas);
						}
	});            
}

jQuery(document).ready(function () {						
		jQuery(document).on('click', '#showrkp', function(e){
				var kdbidang = $("#bidangs option:selected").val();
				var kdunit = $("#units option:selected").val();		
				var kdsub = $("#subs option:selected").val();
				var kdupb = $("#upbs option:selected").val();				
				var tglawal = document.getElementById("tglawal").value; 						
				var tglakhir = document.getElementById("tglakhir").value; 
				var form = $(this);	
            fetch_customer_data();

            function fetch_customer_data(query = '') {
				$('#loader3',form).html('Please wait...');
                jQuery.ajax({
				url:"{{ url(config('laraadmin.adminRoute') . '/rekapinstock') }}"+"/"+kdbidang+"/"+kdunit+"/"+kdsub+"/"+kdupb+"/'"+tglawal + "'/'" + tglakhir +"'",
				method: 'GET',
				data: {query: query},
				dataType: 'json',
				beforeSend: function() {
								$('#loader').removeClass('hidden')
							},
				success: function (data) {
				   //console.log(data);
				   $('#tbody4').html(data.table_data);					   
				},
				complete: function(){
					$('#loader').addClass('hidden')
				},
                });
            }
			$(document).on('keyup', '#search4', function () {
							var query = $(this).val();
							fetch_customer_data(query);				
						});
        });
	});
//endsearch
</script>
@endpush
