@extends("la.layouts.app")

@section("contentheader_title", "Rekonsiliasi asets")
@section("contentheader_description", "Rekonsiliasi asets listing")
@section("section", "Rekonsiliasi asets")
@section("sub_section", "Listing")
@section("htmlheader_title", "Rekonsiliasi asets Listing")

@section("headerElems")
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
</ul>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

<div class="tab-content">
		<div role="tabpanel" class="tab-pane active fade in" id="tab-info">
			<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="tab-timeline">
				<div class="timeline-item">
					<div class="panel-default panel-heading">
						<h4>Rekonsiliasi</h4>
					</div>
					
					<div class="box box-success">
						<br/>
						<div class="box-body ">
							<div class="col-md-4">						
								<div class="form-group row">
									<label for="saldo_awal">Tgl Saldo Awal</label>
									<div class="input-group date">
										<input class="form-control" placeholder="Enter Tgl Saldo Awal" id="saldo_awals" name="saldo_awal" type="text" value="">
										<span class="input-group-addon">
											<span class="fa fa-calendar"></span>
										</span>
									</div>
								</div>
								<div class="form-group row">
									<label for="saldo_akhir">Tgl Saldo Akhir</label>
									<div class="input-group date">
										<input class="form-control" placeholder="Enter Tgl Saldo Akhir" id="saldo_akhirs" name="saldo_akhir" type="text" value="">
										<span class="input-group-addon">
											<span class="fa fa-calendar"></span>
										</span>
									</div>
								</div>
							</div>
							<div class="col-md-8">
								<div class="form-group row">																		
									<div class="col-md-4">
									<label for="name" class="col-md-4 col-form-label">Bidang</label>
										<select name="bidang" id="bidang" class="form-control">
											<option value="">== Pilih Bidang ==</option>
											<option value="%">%</option>
											 @foreach($bidang as $bidangs)
												<option value="{{ $bidangs->kd_bidang }}">
													{{ $bidangs->kd_bidang.'. '.$bidangs->nm_bidang }}
												</option>
											 @endForeach
										</select>
									</div>
									<div class="col-md-3">
									<label for="name" class="col-md-4 col-form-label">Unit</label>
										<select name="unit" id="unit" class="form-control">
											<option value="">== Pilih Unit ==</option>
											<option value="%">%</option>
										</select>
									</div>
									<div class="col-md-2">
											<label for="kertaskerjaunit" class="col-md-4 col-form-label">Load</label>
											<button class="btn btn-danger" type="submit" id= "kertaskerjaunit">
												GET Kertas Kerja OPD
											</button>
									</div>																											
								</div>
							</div>
							
							<div class="col-md-8">
								<div class="form-group row">
									<div class="col-md-7">
									<label for="name" class="col-md-4 col-form-label">Sub</label>
										<select name="subunit" id="subunit" class="form-control">
											<option value="">== Pilih Sub Unit ==</option>
											<option value="%">%</option>
										</select>
									</div>
															
									<div class="col-md-2">
										<label for="kertaskerjaopd" class="col-md-4 col-form-label">Load</label>
										<button class="btn btn-warning" type="submit" id= "kertaskerjaopd">
											GET Kertas Kerja SUB
										</button>
									</div>
								</div>
							</div>	
							<div class="col-md-8">
								<div class="form-group row">
									<div class="col-md-6">
										<label for="name" class="col-md-4 col-form-label">UPB</label>
											<select name="upb" id="upb" class="form-control">
												<option value="">== Pilih UPB ==</option>
												<option value="%">%</option>
											</select>
									</div>
									<div class="col-md-2">
											<label for="kertaskerjaupb" class="col-md-4 col-form-label">Load</label>
											<button class="btn btn-success" type="submit" id= "kertaskerjaupb">
												GET Kertas Kerja UPB
											</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
		</div>
			
		</div>	
</div>
<div id="loader" class="lds-dual-ring hidden overlay">Please Wait.......</div>

@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')
<script type="text/javascript">


function stringToDate(str){
    var date = str.split("/"),
        d = date[0],
        m = date[1],
        y = date[2],
        temp = [];
    temp.push(y,m,d);
    return temp.join("-");
}

function stringToYear(str){
    var date = str.split("/"),
        d = date[0],
        m = date[1],
        y = date[2],
        temp = [];
    temp.push(y);
    return temp;
}


function loaddataopd() {
	
	var tahunp = stringToYear($("#saldo_awals").val());
	var kdupb = $("#upb option:selected").val();
	var kdsub = $("#subunit option:selected").val();
	var kdunit = $("#unit option:selected").val();
	var kdbidang = $("#bidang option:selected").val();
	var saldoawals =  stringToDate($("#saldo_awals").val());
	var saldoakhirs =  stringToDate($("#saldo_akhirs").val());
	var urls = 'kk_opd/'+tahunp+'/'+saldoawals+'/'+saldoakhirs+'/'+kdbidang+'/'+kdunit+'/'+kdsub+'/'+kdupb;

 $(document).ready(function () {
            fetch_customer_data();
            function fetch_customer_data(query = '') {
                $.ajax({
					//url: '/admin/kk_opd'+'/'+tahunp+'/'+saldoawals+'/'+saldoakhirs+'/'+kdbidang+'/'+kdunit+'/'+kdsub,  
					url: urls,
					type: 'GET',
					data: {query: query},
                    dataType: 'application/json',
					timeout:6000,
					beforeSend: function() {
									alert('Generating document,press "OK" to continue');
									$('#loader').removeClass('hidden')
								},
					success:function () {								
								alert('generating document, please wait');
							},
					complete: function(){
						$('#loader').addClass('hidden')
					},
					error:function () {
						alert('your network is anyinggggggggggg',urls);
					}
                })
           }	
        });
}



//kertaskerjasub
jQuery(document).ready(function () {						
			jQuery(document).on('click', '#kertaskerjaunit', function(e){
					var tahunp = stringToYear($("#saldo_akhirs").val());
					var kdsub = $("#subunit option:selected").val();
					var kdunit = $("#unit option:selected").val();
					var kdbidang = $("#bidang option:selected").val();
					var saldoawals =  stringToDate($("#saldo_awals").val());
					var saldoakhirs =  stringToDate($("#saldo_akhirs").val());					
				fetch_customer_data();

				function fetch_customer_data(query = '') {
					jQuery.ajax({
					url: 'kk_unit/'+tahunp+'/'+saldoawals+'/'+saldoakhirs+'/'+kdbidang+'/'+kdunit,
					method: 'GET',
					data: {query: query},
					dataType: 'application/json',
					beforeSend:function() {
									alert('this will taking long, please dont close your page until document ready to download, please press "OK"');
									window.location.href = "{{ url(config('laraadmin.adminRoute') . '/kk_unit') }}"+'/'+tahunp+'/'+saldoawals+'/'+saldoakhirs+'/'+kdbidang+'/'+kdunit;
									$('#loader').removeClass('hidden')
								},
					success:function(result) {
						alert('generating document, please wait');
					},
					complete: function(){
						$('#loader').addClass('hidden')
					},
					error:function(xhr, textStatus, errorThrown){
					   //alert('please try again');
					   //window.location.href = "{{ url(config('laraadmin.adminRoute') . '/rekonsiliasi_asets') }}";						
					},
					fail: function(xhr, textStatus, errorThrown){
						alert('request failed');
					}
					});
				}	
			});
	});
//end

//kertaskerjasub
jQuery(document).ready(function () {						
			jQuery(document).on('click', '#kertaskerjaopd', function(e){
					var tahunp = stringToYear($("#saldo_akhirs").val());
					var kdsub = $("#subunit option:selected").val();
					var kdunit = $("#unit option:selected").val();
					var kdbidang = $("#bidang option:selected").val();
					var saldoawals =  stringToDate($("#saldo_awals").val());
					var saldoakhirs =  stringToDate($("#saldo_akhirs").val());					
				fetch_customer_data();

				function fetch_customer_data(query = '') {
					jQuery.ajax({
					url: 'kk_opd/'+tahunp+'/'+saldoawals+'/'+saldoakhirs+'/'+kdbidang+'/'+kdunit+'/'+kdsub,
					method: 'GET',
					data: {query: query},
					dataType: 'application/json',
					beforeSend:function() {
									alert('this will taking long, please dont close your page until document ready to download, please press "OK"');
									window.location.href = "{{ url(config('laraadmin.adminRoute') . '/kk_opd') }}"+'/'+tahunp+'/'+saldoawals+'/'+saldoakhirs+'/'+kdbidang+'/'+kdunit+'/'+kdsub;
									$('#loader').removeClass('hidden')
								},
					success:function(result) {
						alert('generating document, please wait');
					},
					complete: function(){
						$('#loader').addClass('hidden')
					},
					error:function(xhr, textStatus, errorThrown){
					   //alert('please try again');
					   //window.location.href = "{{ url(config('laraadmin.adminRoute') . '/rekonsiliasi_asets') }}";						
					},
					fail: function(xhr, textStatus, errorThrown){
						alert('request failed');
					}
					});
				}	
			});
	});
//end

//kertaskerjaupb
jQuery(document).ready(function () {						
			jQuery(document).on('click', '#kertaskerjaupb', function(e){
					var tahunp = stringToYear($("#saldo_akhirs").val());
					var kdupb = $("#upb option:selected").val();
					var kdsub = $("#subunit option:selected").val();
					var kdunit = $("#unit option:selected").val();
					var kdbidang = $("#bidang option:selected").val();
					var saldoawals =  stringToDate($("#saldo_awals").val());
					var saldoakhirs =  stringToDate($("#saldo_akhirs").val());					
				fetch_customer_data();

				function fetch_customer_data(query = '') {
					jQuery.ajax({
					url: 'kk_upb/'+tahunp+'/'+saldoawals+'/'+saldoakhirs+'/'+kdbidang+'/'+kdunit+'/'+kdsub+'/'+kdupb,
					method: 'GET',
					data: {query: query},
					dataType: 'application/json',
					beforeSend:function() {
									alert('this will taking long, please dont close your page until document ready to download, please press "OK"');
									window.location.href = "{{ url(config('laraadmin.adminRoute') . '/kk_upb') }}"+'/'+tahunp+'/'+saldoawals+'/'+saldoakhirs+'/'+kdbidang+'/'+kdunit+'/'+kdsub+'/'+kdupb;
									$('#loader').removeClass('hidden')
								},
					success:function(result) {
						alert('generating document, please wait');
					},
					complete: function(){
						$('#loader').addClass('hidden')
					},
					error:function(xhr, textStatus, errorThrown){
					   //alert('please try again');
					   //window.location.href = "{{ url(config('laraadmin.adminRoute') . '/rekonsiliasi_asets') }}";						
					},
					fail: function(xhr, textStatus, errorThrown){
						alert('request failed');
					}
					});
				}	
			});
	});
//end

//endsearch
//load unit
jQuery(document).ready(function (){
            jQuery('select[name="bidang"]').on('change',function(){
               var kdbidang = jQuery(this).val();
               if(kdbidang){
                  jQuery.ajax({
                     url : 'rekonsiliasi_aset_getunit/' +kdbidang,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        //console.log(data);
                        jQuery('select[name="unit"]').empty();
						$('select[name="unit"]').append('<option value="%">%</option>');
                        jQuery.each(data, function(key,value){
                           $('select[name="unit"]').append('<option value="'+ key +'">'+key+ '. '+ value +'</option>');
                        });
                     }
                  });
               }
               else
               {
                  $('select[name="unit"]').empty();
               }
            });
    });
//end
//load sub unit
jQuery(document).ready(function (){
            jQuery('select[name="unit"]').on('change',function(){
				var kdunit= jQuery(this).val();
			    var kdbidang = $("#bidang option:selected").val();
               
               if(kdunit){				  
                  jQuery.ajax({
                     url : 'rekonsiliasi_aset_getsubunit/' +kdbidang+'/'+kdunit,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        //console.log(data);
                        jQuery('select[name="subunit"]').empty();
						$('select[name="subunit"]').append('<option value="%">%</option>');
                        jQuery.each(data, function(key,value){
                           $('select[name="subunit"]').append('<option value="'+ key +'">'+key+ '. '+ value +'</option>');
                        });
                     }
                  });
               }else{
                  $('select[name="subunit"]').empty();
               } 
            });
    });
//end
//load upb
jQuery(document).ready(function (){
         jQuery('select[name="subunit"]').on('change',function(){
				var kdsub= jQuery(this).val();
				var kdunit = $("#unit option:selected").val();
			    var kdbidang = $("#bidang option:selected").val();
               
               if(kdsub){				  
                  jQuery.ajax({
                     url : 'rekonsiliasi_aset_getupb/' +kdbidang+'/'+kdunit+'/'+kdsub,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        //console.log(data);
                        jQuery('select[name="upb"]').empty();
						$('select[name="upb"]').append('<option value="%">%</option>');
                        jQuery.each(data, function(key,value){
                           $('select[name="upb"]').append('<option value="'+ key +'">'+key+ '. '+ value +'</option>');
                        });
                     }
                  });
               }else{
                  $('select[name="upb"]').empty();
               } 
            });
    });
//end
</script>
@endpush
