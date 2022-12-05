@extends("la.layouts.app")

@section("contentheader_title", "Kendaraans")
@section("contentheader_description", "Kendaraans listing")
@section("section", "Kendaraans")
@section("sub_section", "Listing")
@section("htmlheader_title", "Kendaraans Listing")

@section("headerElems")
@la_access("Kendaraans", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add Kendaraan</button>
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
		<li class=""><a role="tab" data-toggle="tab" href="#lists" data-target="#tab-timeline"><i class="fa fa-clock-o"></i>Lists kendaraan</a></li>
		<li class=""><a role="tab" data-toggle="tab" href="#listspajak" data-target="#tab-timeline1"><i class="fa fa-clock-o"></i>List Data Pajak Kendaraan</a></li>
</ul>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

<div class="tab-content">
		<div role="tabpanel" class="tab-pane active fade in" id="tab-info">
			<div class="tab-content">
				<div class="panel infolist">					
						<div class="row">
						<br/>
							<div class="col-lg-6 col-xs-6">
              <!-- small box -->
							<div class="small-box bg-orange">
								
								<div class="inner">
								  <h3>{{ $kendaraan }}</h3>
								  <p>Total Kendaraan</p>
								</div>
								
								<div class="box-body">
								  <div class="col-lg-1 col-xs-6">
											  <div class="small-box bg-orange text-white">
												<div class="inner">
												  <h6>{{ $kendaraanr2 }}</h6>
												  <h6>R2</h6>
												</div>
											  </div>							
										 </div>
										<div class="col-lg-1  col-xs-6">
											  <div class="small-box bg-orange text-white">
												<div class="inner">
												  <h6>{{ $kendaraanr3 }}</h6>
												  <h6>R3</h6>
												</div>
											  </div>							
										 </div>
										 <div class="col-lg-2  col-xs-6">
											  <div class="small-box bg-orange text-white">
												<div class="inner">
												  <h6>{{ $kendaraanr4 }}</h6>
												  <h6>Perorangan</h6>
												</div>
											  </div>							
										 </div>	
										<div class="col-lg-2  col-xs-6">
											  <div class="small-box bg-orange text-white">
												<div class="inner">
												  <h6>{{ $kendaraanrpenumpang }}</h6>
												  <h6>Penumpang</h6>
												</div>
											  </div>							
										 </div>	
										 <div class="col-lg-2  col-xs-6">
											  <div class="small-box bg-orange text-white">
												<div class="inner">
												  <h6>{{ $kendaraanrangkbrg }}</h6>
												  <h6>Barang</h6>
												</div>
											  </div>							
										 </div>
										 <div class="col-lg-2  col-xs-6">
											  <div class="small-box bg-orange text-white">
												<div class="inner">
												  <h6>{{ $kendaraankh }}</h6>
												  <h6>Khusus</h6>
												</div>
											  </div>							
										 </div>
										 <div class="col-lg-2  col-xs-6">
											  <div class="small-box bg-orange text-white">
												<div class="inner">
												  <h6>{{ $kendaraanlainnya }}</h6>
												  <h6>lainnya</h6>
												</div>
											  </div>							
										 </div>
								</div>
									<div class="icon">
									  <i class="ion ion-clipboard"></i>
									</div>								
								<a href="#" class="small-box-footer">
								more info
								</a>
							 </div>							
							</div>
							<div class="col-lg-2 col-xs-6">
								  <div class="small-box bg-black text-white">
									<div class="inner">
									  <h3>{{ $kendaraanhapus }}</h3>
									  <p>Kendaraan Dihapus</p>
									  <div class="box-body">
							
									  </div>
									</div>
									<div class="icon">
									  <i class="ion ion-trash-a"></i>
									</div>
									<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
								  </div>							
							 </div>	
							<div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-aqua">
									<div class="inner">
									  <h3>{{ $bpkbnotempty }}</h3>
									  <p>BPKB Telah Diisi</p>
									  <div class="box-body">							
									  </div>
									</div>
									<div class="icon">
									  <i class="ion ion-clipboard"></i>
									</div>
									<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							  </div>
							  <div class="col-lg-2 col-xs-6">
								  <div class="small-box bg-red">
									<div class="inner">
									  <h3>{{ $bpkbempty }}</h3>
									  <p>BPKB Belum Diisi</p>
									  <div class="box-body">
							
									  </div>
									</div>
									<div class="icon">
									  <i class="ion ion-ios-pulse"></i>
									</div>
									<a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
								  </div>							
							  </div>
													  
						</div>
				</div>
			</div>
			<div class="tab-content">
				<div class="panel infolist">
					<div class="box-body table-responsive tableFixHead">
					<h2>Keterangan</h2>
							<table id="#" class="table table-bordered table-striped">
							<thead>
							<tr class="bg-aqua">
								<th>No.</th>
								<th>Kd Bidang</th>									
								<th>Kd Unit</th>									
								<th>Kd Sub</th>																
								<th>Kd UPB</th>																
								<th>Dept</th>																							
								<th>Total Kendaraan</th>							
								<th>R2</th>																			
								<th>R4</th>																			
								<th>R3</th>																			
																		
								<th>Penumpang</th>																			
								<th>BPKB Diisi</th>							
								<th>No Rangka Diisi</th>							
								<th>No Mesin Diisi</th>							
								<th>BPKB Diupload</th>							
								<th>STNK Diupload</th>													
								<th>Rusak Berat</th>													
								<th>Verif Dok</th>													
								<th>Verif Pajak</th>													
							 </tr>
							</thead>
							<tbody id = "#">	
							
							</tbody>
							</table>
						</div>
				</div>
			</div>
		</div>

		<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="tab-timeline">
				<div class="timeline-item">
					<div class="panel-default panel-heading">
						<h4>Lists</h4>
					</div>
					<div class="box box-success">
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
						<div  class = "col-md-12">
							<div class="col-md-3">
								<label for="#" >Nomor Polisi / Nomor BPKB</label>
								<input type="text" name="search" id="search" class="form-control" placeholder="Cari.." />
							</div>
							<div class="col-md-3">
							<label for="#" >Print List</label>
							<form id = "getprintsoloform" method="POST" action="printsolo" accept-charset="UTF-8">
							<input name="_token" type="hidden" value="{{ csrf_token() }}"/>						
								<div class="input-group">
								  <input type="text" name="searchsolo" id="searchsolo" class="form-control" placeholder="Print List.." readonly />
								  <span class="input-group-btn">															
										<button class="btn btn-success" type="submit" id= "getprintsolo" onclick = "dellastchar()">
											<i class="fa fa-print"></i>
										</button>
										<button class="btn btn-primary" type="submit" id= "printsolo" onclick = "validate()">
											GET
										</button>
										<button class="btn btn-warning" type="submit" onclick="cleartxt()">
												<i class="fa fa-undo"></i>
										</button>
										<button id = "csvbrg" class="btn btn-info btn-sm" type = "button" >EXCEL</button>
								  </span>
								</div>
							</form>
							<span class="input-group-btn">	
								
							 </span>
							</div>
						</div>
							<br/>
							<div class = "col-md-12">
								
									
									
								
								
									
								
							</div>							
						</div>
						</div>
						
						<div class="form-group " class = "col-sm-4">
						
						
						<div class="box-body table-responsive">
							<table id="example1" class="table table-bordered table-striped">
							<thead>
							<tr class="bg-aqua">
								<th>No.</th>
								<th>Dept</th>								
								<th>IDPemda</th>							
								<th>Merk</th>							
								<th>Type</th>							
								<th>CC</th>							
								<th>Bahan</th>							
								<th>Kondisi</th>							
								<th>Tgl_Perolehan</th>							
								<th>Nomor Rangka</th>							
								<th>Nomor Mesin</th>							
								<th>Nomor Polisi</th>							
								<th>Nomor BPKB</th>													
								<th>BPKB File</th>							
								<th>Rack No</th>							
								<th>Storage Name</th>							
								<th>STNK File</th>							
								<th>Pajak</th>							
								<th>File Foto Kendaraan</th>
								<th>File BAST</th>								
								<th>Pemegang Kendaraan</th>							
								<th>Validation Status</th>							
								<th>Action</th>
								<th>Validation</th>
							 </tr>
							</thead>
							<tbody id= "tbody2">	

							</tbody>
							</table>
						</div>
					</div>
		</div>
		<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="tab-timeline1">
						<div class="timeline-item">
							<div class="panel-default panel-heading">
								<h4>Lists Data Pajak</h4>
							</div>
							<div class="box box-success">
								<div class="form-group" >
								<h2>Nomor Polisi / Nomor BPKB</h2>
									<input type="text" name="search" id="search1" class="form-control" placeholder="Cari.." />
								</div>
																
								<div class="box-body table-responsive">
									<table id="example1" class="table table-bordered table-striped">
									<thead>
									<tr class="bg-aqua">
										<th>No.</th>
										<th>Dept</th>								
										<th>IDPemda</th>							
										<th>Merk</th>							
										<th>Type</th>							
										<th>CC</th>							
										<th>Bahan</th>							
										<th>Kondisi</th>							
										<th>Tgl_Perolehan</th>							
										<th>Nomor Rangka</th>							
										<th>Nomor Mesin</th>							
										<th>Nomor Polisi</th>							
										<th>Nomor BPKB</th>													
										<th>BPKB File</th>							
										<th>Rack No</th>							
										<th>Storage Name</th>							
										<th>STNK File</th>							
										<th>Pajak</th>							
										<th>File Foto Kendaraan</th>
										<th>File BAST</th>										
										<th>Pemegang Kendaraan</th>							
										<th>Validation</th>							
										<th>Action</th>							
									 </tr>
									</thead>
									<tbody id= "tbody3">	

									</tbody>
									</table>
								</div>
							</div>
						</div>
				</div>
</div>
<div id="loader" class="lds-dual-ring hidden overlay"></div>	
@endsection

@push('scripts')

<script type="text/javascript">
	jQuery(document).ready(function () {						
			jQuery(document).on('click', '#csvbrg', function(e){
					var kdbidang = $("#bidangs option:selected").val();
					var kdunit = $("#units option:selected").val();		
					var kdsub = $("#subs option:selected").val();						
				fetch_customer_data();

				function fetch_customer_data(query = '') {
					jQuery.ajax({
					//url:'/admin/loadDatakibbs/'+kdbidang+'/'+kdunit+'/'+kdsub+'/'+ids+'/'+idss+'/'+ids3+'/'+ids4+'/'+kond,
					url:"{{ url(config('laraadmin.adminRoute') . '/csvkendall') }}"+'/'+kdbidang+'/'+kdunit+'/'+kdsub,
					method: 'GET',
					data: {query: query},
					dataType: 'json',
					beforeSend: function() {
									$('#loader').removeClass('hidden')
								},
					success: function(result) {
						window.location.href = "{{ url(config('laraadmin.adminRoute') . '/csvkendall') }}"+'/'+kdbidang+'/'+kdunit+'/'+kdsub;
					},
					complete: function(){
						$('#loader').addClass('hidden')
					},
					error: function(result) {
						window.location.href = "{{ url(config('laraadmin.adminRoute') . '/csvkendall') }}"+'/'+kdbidang+'/'+kdunit+'/'+kdsub;
					}
					});
				}		
			});
	});
function getvrfValue(clicked_id){
	var vrfid = document.getElementById(clicked_id);
	var sub = $("#subs option:selected").val();
	var unit = $("#units option:selected").val();
	var bidang =  $("#bidangs option:selected").val();
	var form = $(this);
	
	
	jQuery(document).ready(function(){
		fetch_customer_data();
		function fetch_customer_data(query = '') {	
		 jQuery.ajax({
					url:'/admin/verifkend'+'/'+clicked_id,
					method: 'GET',						
					data: {
							  "_token": "{{ csrf_token() }}",
							  "vrf_status": 1
						  },
					dataType: 'json',
					//error: function(data) {alert(data);},
					success: function (data) {					  
						alert('Data Verified');
					}
				})
		}
	});
	alert('Data Verified');
	jQuery('#showbrg').click();						
}

function getreleaseValue(clicked_id){
	var vrfid = document.getElementById(clicked_id);
	var sub = $("#subs option:selected").val();
	var unit = $("#units option:selected").val();
	var bidang =  $("#bidangs option:selected").val();
	var form = $(this);
	
	
	jQuery(document).ready(function(){
		fetch_customer_data();
		function fetch_customer_data(query = '') {	
		 jQuery.ajax({
					url:'/admin/verifreleasekend'+'/'+clicked_id,
					method: 'GET',						
					data: {
							  "_token": "{{ csrf_token() }}",
							  "vrf_status": 0
						  },
					dataType: 'json',
					//error: function(data) {alert(data);},
					success: function (data) {					  
						alert('Data Verified');
					}
				})
		}
	});
	alert('Data Verified, Data incomplete');
	jQuery('#showbrg').click();						
}

//load rek1
jQuery(document).ready(function (){
            jQuery('select[name="bidangs"]').on('change',function(){
               var bidang = jQuery(this).val();
              
               if(bidang){
                  jQuery.ajax({
                     url : '/admin/kendaraan_unit/' +bidang,
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
                     url : '/admin/kendaraan_sub/'+bidang+'/'+unit,
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
				var form = $(this);			
            fetch_customer_data();

            function fetch_customer_data(query = '') {
                jQuery.ajax({
					url:"{{ url(config('laraadmin.adminRoute') . '/kendaraanscari') }}"+'/'+bidang+'/'+unit+'/'+sub,
                    method: 'GET',
                    data: {query: query},
                    dataType: 'json',
					beforeSend: function() {
									$('#loader').removeClass('hidden')
								},
                    success: function (data) {
                       $('#tbody2').html(data.table_data);
                    },complete: function(){
						$('#loader').addClass('hidden')
					},
                })
            }

            $(document).on('keyup', '#search', function () {
                var query = $(this).val();
                fetch_customer_data(query);				
            });		
        });
	});
	

	
//search
/* $(document).ready(function () {

            fetch_customer_data();

            function fetch_customer_data(query = '') {
                $.ajax({
                    url:"{{ url(config('laraadmin.adminRoute') . '/kendaraanscari') }}",
                    method: 'GET',
                    data: {query: query},
                    dataType: 'json',
                    success: function (data) {
                        $('#tbody2').html(data.table_data);
                    }
                })
            }

            $(document).on('keyup', '#search', function () {
                var query = $(this).val();
                fetch_customer_data(query);				
            });		
        }); */
//endsearch
//search pajak
$(document).ready(function () {
			var form = $(this);	
            fetch_customer_data();

            function fetch_customer_data(query = '') {
                $.ajax({
                    url:"{{ url(config('laraadmin.adminRoute') . '/kendaraanspajak') }}",
                    method: 'GET',
                    data: {query: query},
                    dataType: 'json',
					beforeSend: function() {
									$('#loader').removeClass('hidden')
								},
                    success: function (data) {
                        $('#tbody3').html(data.table_data);
                    },
					complete: function(){
						$('#loader').addClass('hidden')
					},
                })
            }

            $(document).on('keyup', '#search1', function () {
                var query = $(this).val();
                fetch_customer_data(query);				
            });		
        });
//endsearch
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
