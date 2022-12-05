@extends("la.layouts.app")

@section("contentheader_title", "Daftar pegawais")
@section("contentheader_description", "Daftar pegawais listing")
@section("section", "Daftar pegawais")
@section("sub_section", "Listing")
@section("htmlheader_title", "Daftar pegawais Listing")

@section("headerElems")
@la_access("Daftar_pegawais", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add Daftar pegawai</button>
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
		<li class="active"><a role="tab" data-toggle="tab" class="active" href="#Entry" data-target="#tab-info"><i class="fa fa-barcode"></i>List Pegawai</a></li>
</ul>

<div class="tab-content">
		<div role="tabpanel" class="tab-pane active fade in" id="tab-info">
			<div class="tab-content">
				<div class="panel infolist">					
						<div class="row">
						<br/>
							<div class="col-lg-2 col-xs-6">
              <!-- small box -->
							<div class="small-box bg-aqua">
								
								<div class="inner">
								  <h3></h3>
								  <p>Total Barang</p>
								  <h6>{{ $totbarang }}</h6>
								</div>																
								<a href="#" class="small-box-footer">
								Download
								</a>
							 </div>							
							</div>
							<div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-green">
									<div class="inner">
									  <h3></h3>
									  <p>Total Pegawai</p>
									  <h6>{{ $totpegawaiuser }}</h6>
									</div>
									<div class="icon">
									  <i class="fa fa-map-o"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							  </div>
							<div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-purple">
									<div class="inner">
									  <h3></h3>
									  <p>Barang yang Digunakan Pegawai</p>
									  <h6>{{ $gunapegawaiuser }}</h6>
									</div>
									<div class="icon">
									  <i class="fa fa-map-o"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							 </div>
							<div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-aqua">
									<div class="inner">
									  <h3></h3>
									  <p>R2 yang Digunakan Pegawai</p>
									  <h6>{{ $kendaraanr2 }}</h6>
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
									  <h3></h3>
									  <p>R4 yang Digunakan Pegawai</p>
									  <h6>{{ $kendaraanr4 }}</h6>
									</div>
									<div class="icon">
									  <i class="fa fa-map-o"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							 </div>
							 <div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-white text-black">
									<div class="inner">
									  <h3></h3>
									  <p>Laptop yang Digunakan Pegawai</p>
									  <h6>{{ $laptop }}</h6>
									</div>
									<div class="icon">
									  <i class="fa fa-map-o"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							 </div>
							 <div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-black text-white">
									<div class="inner">
									  <h3></h3>
									  <p>PC yang Digunakan Pegawai</p>
									  <h6>{{ $pc }}</h6>
									</div>
									<div class="icon">
									  <i class="fa fa-map-o"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							 </div>
							  <div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-grey text-black">
									<div class="inner">
									  <h3></h3>
									  <p>Printer yang Digunakan Pegawai</p>
									  <h6>{{ $printer }}</h6>
									</div>
									<div class="icon">
									  <i class="fa fa-map-o"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							 </div>
							 <div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-green text-white">
									<div class="inner">
									  <h3></h3>
									  <p>Meubel yang Digunakan Pegawai</p>
									  <h6>{{ $meubel }}</h6>
									</div>
									<div class="icon">
									  <i class="fa fa-map-o"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							 </div>
							 <div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-yellow text-black">
									<div class="inner">
									  <h3></h3>
									  <p>Meja/Kursi yang Digunakan Pegawai</p>
									  <h6>{{ $mejakursi }}</h6>
									</div>
									<div class="icon">
									  <i class="fa fa-map-o"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							 </div>
						</div>
				</div>																						
			</div>
			<div class="panel infolist">
				<div class="form-group" class = "col-sm-12" >
						<div class="col-md-3">
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
						<div class="col-md-3">
							<label for="unit" >Unit</label>
							<select name="units" id="units" class="form-control">
								<option value="">== Pilih Unit ==</option>
								<option value="%">%</option>
							</select>
						</div>
						<div class="col-md-4">
							<label for="sub" >Sub</label>
							<select name="subs" id="subs" class="form-control">
								<option value="">== Pilih Sub ==</option>
								<option value="%">%</option>
							</select>
						</div>
						<div class="col-md-2">
						<br/>
							<button id = "showbrg" class="btn btn-success btn-md" >Show</button>
						</div>
				</div>
				<div class="form-group" class = "col-sm-4">
					<div class="col-md-3">
					<label for="alamat" >Nama</label>
						<input type="text" name="search" id="search" class="form-control" placeholder="Cari.." />
					</div>	
				</div>
				
				<div class="form-group " class = "col-sm-5">
					<div class="col-md-5">
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
			<div class="box-body table-responsive">
				<table class="table table-bordered table-striped">
				<thead>
				<tr class="bg-aqua">
					<th>No.</th>
					<th>Dept</th>																							
					<th>NIP</th>							
					<th>Nama</th>							
					<th>Jabatan</th>							
					<th>Action</th>																										
				 </tr>
				</thead>
				<tbody id= "tbody2">	

				</tbody>
				</table>
			</div>	
		</div>

</div>
@la_access("Daftar_pegawais", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Daftar pegawai {{ $kdbidang }}</h4>
			</div>
			{!! Form::open(['action' => 'LA\Daftar_pegawaisController@store', 'id' => 'daftar_pegawai-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
                    {{--@la_form($module)--}}
					
					
					@la_input($module, 'nama')
					@la_input($module, 'nip')
					@la_input($module, 'jabatan')
					@if ($kdbidang == 0)
						@la_input($module, 'instansi')
					@else
						<label for="opd">Instansi:</label>
						<input class="form-control" placeholder="{{ Module::kddept()->name }}" name="instansi" value="" readonly>
						<input name="instansi" type="hidden" value="{{ Module::kddept()->dept }}">	
					@endif
					@la_input($module, 'telp')
					
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

<script type="text/javascript">
//load rek1
jQuery(document).ready(function (){
            jQuery('select[name="bidangs"]').on('change',function(){
               var bidang = jQuery(this).val();
              
               if(bidang){
                  jQuery.ajax({
                     url : '/admin/kibas_unit/' +bidang,
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
//end
//load rek2
jQuery(document).ready(function (){
            jQuery('select[name="units"]').on('change',function(){
				var unit = jQuery(this).val();
			    var bidang = $("#bidangs option:selected").val();
               
               if(unit){				  
                  jQuery.ajax({
                     url : '/admin/kibas_sub/'+bidang+'/'+unit,
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
jQuery(document).ready(function () {						
		jQuery(document).on('click', '#showbrg', function(e){
				var sub = $("#subs option:selected").val();
				var unit = $("#units option:selected").val();
				var bidang =  $("#bidangs option:selected").val();
							
            fetch_customer_data();

            function fetch_customer_data(query = '') {
                jQuery.ajax({
					url:"{{ url(config('laraadmin.adminRoute') . '/daftar_pegawai_cari') }}"+'/'+bidang+'/'+unit+'/'+sub,
                    method: 'GET',
                    data: {query: query},
                    dataType: 'json',
                    success: function (data) {
					   //console.log(data);
					   //alert('tai');
                       $('#tbody2').html(data.table_data);
                    }
                })
            }

            $(document).on('keyup', '#search', function () {
                var query = $(this).val();
                fetch_customer_data(query);				
            });		
        });
	});

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
</script>
@endpush
