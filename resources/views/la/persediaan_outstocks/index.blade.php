@extends("la.layouts.app")

@section("contentheader_title", "Persediaan outstocks")
@section("contentheader_description", "Persediaan outstocks listing")
@section("section", "Persediaan outstocks")
@section("sub_section", "Listing")
@section("htmlheader_title", "Persediaan outstocks Listing")

@section("headerElems")
@la_access("Persediaan_outstocks", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add Persediaan outstock</button>
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
						<th>JENIS PERSEDIAAN</th>
						<th>NAMA BARANG</th>
						<th>URAIAN</th>
						<th>TYPE</th>
						<th>SATUAN</th>
						<th>JUMLAH IN</th>						
						<th>JUMLAH OUT</th>
						<th>HARGA IN</th>
						<th>HARGA OUT</th>
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

@la_access("Persediaan_outstocks", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Persediaan outstock</h4>
			</div>
			{!! Form::open(['action' => 'LA\Persediaan_outstocksController@store', 'id' => 'persediaan_outstock-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
                    @la_form($module)
					
					{{--
					@la_input($module, 'ref_persediaan')
					@la_input($module, 'ref_brg')
					@la_input($module, 'kd_bidang')
					@la_input($module, 'kd_unit')
					@la_input($module, 'kd_sub')
					@la_input($module, 'kd_upb')
					@la_input($module, 'jml_outstock')
					@la_input($module, 'tgl_outstock')
					--}}
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
                     url : '/admin/outstock_unit/' +bidang,
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
                     url : '/admin/outstock_sub/'+bidang+'/'+unit,
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
                     url : '/admin/outstock_upb/'+bidang+'/'+unit+'/'+sub,
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
jQuery(document).ready(function () {						
		jQuery(document).on('click', '#showbrg', function(e){
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
				url:"{{ url(config('laraadmin.adminRoute') . '/rekapinstockout') }}"+"/"+kdbidang+"/"+kdunit+"/"+kdsub+"/"+kdupb+"/",
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
</script>
@endpush
