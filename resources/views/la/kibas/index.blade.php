@extends("la.layouts.app")

@section("contentheader_title", "Kibas")
@section("contentheader_description", "Kibas listing")
@section("section", "Kibas")
@section("sub_section", "Listing")
@section("htmlheader_title", "Kibas Listing")

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
		<li class=""><a role="tab" data-toggle="tab" href="#lists" data-target="#tab-timeline"><i class="fa fa-clock-o"></i>Lists Tanah</a></li>
</ul>

<div class="tab-content">
		<div role="tabpanel" class="tab-pane active fade in" id="tab-info">
			{{-- <div class="tab-content">
				<div class="panel infolist">
						<div class="row">
						<br/>
							<!--<div class="col-lg-2 col-xs-6">
							<div class="small-box bg-aqua">

								<div class="inner">
								  <h3>{{ $tanah }}</h3>
								  <p>Total Tanah</p>
								</div>
									<div class="box-body">
									  </div>
									<div class="icon">
									  <i class="fa fa-map-o"></i>
									</div>
								<a href="#" class="small-box-footer">
								Download
								</a>
							 </div>
							</div>-->
							<div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-green">
									<div class="inner">
									  <h3>{{ $tanahpemkab }}</h3>
									  <p>Tanah Pemkab</p>
									  <div class="box-body">
										<i>Total Tanah Milik Pemkab</i>
									  </div>
									</div>
									<div class="icon">
									  <i class="fa fa-map-o"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							  </div>
							<!--<div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-orange">
									<div class="inner">
									  <h3>{{ $tanahnonpemkab }}</h3>
									  <p>Tanah Pemerintahan Lainnya</p>
									  <div class="box-body">
									  </div>
									</div>
									<div class="icon">
									  <i class="fa fa-map-o"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							 </div>-->
							 <div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-blue">
									<div class="inner">
									  <h3>{{ $tanahpemkabsdhsert }}</h3>
									  <p>Tanah Pemkab Sudah Sertipikat</p>
									  <div class="box-body">
										<i>Tanah Milik Pemkab yang telah terbit Sertipikat Hak Pakai</i>
									  </div>
									</div>
									<div class="icon">
									  <i class="ion ion-clipboard"></i>
									</div>
									<a href="{{ url(config('laraadmin.adminRoute') . '/printtanahanpemkab') }}" target="_blank"" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							  </div>
							<div class="col-lg-2 col-xs-6">

								 <div class="small-box bg-yellow">
									<div class="inner">
									  <h3>{{ $tanahpemkabblmsert }}</h3>
									  <p>Tanah Pemkab Belum Sertipikat</p>
									  <div class="box-body">
										<i>Tanah Milik Pemkab : SHP belum an Pemkab</i>
									  </div>
									</div>
									<div class="icon">
									  <i class="ion ion-clipboard"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							  </div>
							<!--<div class="col-lg-2 col-xs-6">
								  <div class="small-box bg-black text-white">
									<div class="inner">
									  <h3>{{ $tanahhapus }}</h3>
									  <p>Tanah Dihapus</p>
									  <div class="box-body">

									  </div>
									</div>
									<div class="icon">
									  <i class="ion ion-trash-a"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							 </div>-->
							<div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-aqua">
									<div class="inner">
									  <h3>{{ $sertnotempty }}</h3>
									  <p>No. Sertipikat Telah Diisi</p>
									  <div class="box-body">
										<i>Data SHP Telah diinput</i>
									  </div>
									</div>
									<div class="icon">
									  <i class="ion ion-clipboard"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							  </div>
							  <div class="col-lg-2 col-xs-6">
								  <div class="small-box bg-yellow">
									<div class="inner">
									  <h3>{{ $sertempty }}</h3>
									  <p>No. Sertipikat Belum Diisi</p>
									  <div class="box-body">
										<i>Data SHP Belum diinput</i>
									  </div>
									</div>
									<div class="icon">
									  <i class="ion ion-ios-pulse"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							  </div>
							  <div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-blue">
									<div class="inner">
									  <h3>{{ $sertupload }}</h3>
									  <p>Sertipikat Diupload</p>
									  <div class="box-body">
										<i>Scan Sertipikat Telah Diupload</i>
									  </div>
									</div>
									<div class="icon">
									  <i class="ion ion-clipboard"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							  </div>
							  <div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-red">
									<div class="inner">
									  <h3>{{ $sertnotupload }}</h3>
									  <p>Sertipikat Belum Diupload</p>
									  <div class="box-body">
										<i>Scan Sertipikat Belum Diupload</i>
									  </div>
									</div>
									<div class="icon">
									  <i class="ion ion-clipboard"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							  </div>
							  <div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-green">
									<div class="inner">
									  <h3>{{ $tanahkantor }}</h3>
									  <p>Tanah digunakan Pemkab</p>
									  <div class="box-body">
										<i>Tanah yang digunakan sendiri untuk kepentingan Pemkab</i>
									  </div>
									</div>
									<div class="icon">
									  <i class="ion ion-clipboard"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							  </div>
							   <div class="col-lg-2 col-xs-6">
								 <div class="small-box bg-orange">
									<div class="inner">
									  <h3>{{ $tanahidle }}</h3>
									  <p>Tanah Idle</p>
									  <div class="box-body">
									  </div>
									</div>
									<div class="icon">
									  <i class="ion ion-clipboard"></i>
									</div>
									<a href="#" class="small-box-footer">Download <i class="fa fa-arrow-circle-right"></i></a>
								  </div>
							  </div>


						</div>
				</div>
			</div> --}}

			<div class="tab-content">
				<div class="panel infolist">
					<div class="box-body table-responsive tableFixHead">
						<canvas id="myChart" width="80%" height="40%"></canvas>
					</div>
				</div>
			</div>
			<div class="tab-content">
				<div class="panel infolist">
					<div class="box-body table-responsive tableFixHead">
					<h2>Keterangan</h2>
							<table class="table table-bordered table-striped table align-middle">
							<thead>
							<tr class="bg-aqua">
								<th>No.</th>
								<th>Kd Bidang</th>
								<th>Kd Unit</th>
								<th>Kd Sub</th>
								<th>Kd UPB</th>
								<th>Dept</th>
								<th>Total Tanah</th>
								<th>Total Tanah Pemkab</th>
								<th>Total Tanah Pemerintahan Lainnya</th>
								<!--<th>Total Tanah Dihapus</th>-->
								<th>No Sert Diisi</th>
								<th>No Sert Tidak Diisi</th>
								<th>Tgl Sert Diisi</th>
								<th>Tgl Sert Tidak Diisi</th>
								<th>Sert Diupload</th>
								<th>Foto Tanah Diupload</th>
								<th>Verif Geo</th>
							</tr>
							</thead>
							<tbody>
								@foreach ($sertcount as $index =>$sertcounts)
								<tr>
									<td>{{ $index + 1 }}</td>
									<td>{{ $sertcounts->kd_bidang }}</td>
									<td>{{ $sertcounts->kd_unit }}</td>
									<td>{{ $sertcounts->kd_sub }}</td>
									<td>{{ $sertcounts->kd_upb }}</td>
									<td>{{ $sertcounts->name }}</td>
									<td>{{ $sertcounts->tanahtot }}</td>
									<td>{{ $sertcounts->tanahpemkab }}</td>
									<td>{{ $sertcounts->tanahnonpemkab }}</td>
									<!--<td>{{ $sertcounts->tanahdihapus }}</td>-->
									<td>{{ $sertcounts->sertisis }}</td>
									<td>{{ $sertcounts->sertnotisis }}</td>
									<td>{{ $sertcounts->tglsertisis }}</td>
									<td>{{ $sertcounts->tglsertnotisis }}</td>
									<td>{{ $sertcounts->sertdiupload }}</td>
									<td>{{ $sertcounts->fotodiupload }}</td>
									<td>{{ $sertcounts->vrfgeo }}</td>
								</tr>
								@endforeach
							</tbody>
							</table>
						</div>
				</div>
			</div>
		</div>

		<div role="tabpanel" class="tab-pane fade in p20 bg-white" id="tab-timeline">
				<div class="timeline-item">
					<div class="panel-default panel-heading">
						<h4>Lists Tanah</h4>
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
						</br>
						<div class="form-group" class = "col-sm-4">
							<div class="col-md-12">
							<label for="alamat" >Alamat/Luas</label>
								<input type="text" name="search" id="search" class="form-control" placeholder="Cari.." />
							</div>
						</div>

						<div class="form-group " class = "col-sm-5">
								<div class="col-md-12">
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
								<div class="col-md-12">
										<br/>
										<label for="export" >Export</label>
										<button id = "csvbrg" class="btn btn-info btn-sm">CSV</button>
										<br/>
								</div>
						</div>

				</div>

						<div class="box-body table-responsive tableFixHead">
							<table class="table table-bordered table-striped">
							<thead>
							<tr class="bg-aqua">
								<th>No.</th>
								<th>Dept</th>
								<th>No.Reg</th>
								<th>Luas/M2</th>
								<th>Hak Tanah</th>
								<th>Tgl Sert</th>
								<th>No. Sert</th>
								<th>Alamat</th>
								<th>Tgl Perolehan</th>
								<th>Thn Perolehan</th>
								<th>Penggunaan</th>
								<th>Harga</th>
								<th>Sert File</th>
								<th>Photo Tanah</th>
								<th>Rack No</th>
								<th>Storage Name</th>
								<th>Pemanfaatan</th>
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
		</div>



@endsection

@push('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('la-assets/plugins/datatables/datatables.min.css') }}"/>
@endpush

@push('scripts')

<script type="text/javascript">

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
					url:'/admin/verif'+'/'+clicked_id,
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
					url:'/admin/verifrelease'+'/'+clicked_id,
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
					url:"{{ url(config('laraadmin.adminRoute') . '/kibascari') }}"+'/'+bidang+'/'+unit+'/'+sub,
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

jQuery(document).ready(function () {
		jQuery(document).on('click', '#csvbrg', function(e){
				var kdbidang = $("#bidangs option:selected").val();
				var kdunit = $("#units option:selected").val();
				var kdsub = $("#subs option:selected").val();
            fetch_customer_data();

            function fetch_customer_data(query = '') {
                jQuery.ajax({
				//url:'/admin/loadDatakibbs/'+kdbidang+'/'+kdunit+'/'+kdsub+'/'+ids+'/'+idss+'/'+ids3+'/'+ids4+'/'+kond,
				url:"{{ url(config('laraadmin.adminRoute') . '/csvkibaall') }}"+'/'+kdbidang+'/'+kdunit+'/'+kdsub,
				method: 'GET',
				data: {query: query},
				dataType: 'json',
				success: function(result) {
					window.location.href = "{{ url(config('laraadmin.adminRoute') . '/csvkibaall') }}"+'/'+kdbidang+'/'+kdunit+'/'+kdsub;
				},
				error: function(result) {
					window.location.href = "{{ url(config('laraadmin.adminRoute') . '/csvkibaall') }}"+'/'+kdbidang+'/'+kdunit+'/'+kdsub;
				}
                });
            }



            $(document).on('keyup', '#search', function () {
                var query = $(this).val();
                fetch_customer_data(query);
            });
        });
	});

	function getRandomColor() {
				var letters = '0123456789ABCDEF'.split('');
				var color = '#';
				for (var i = 0; i < 6; i++ ) {
					color += letters[Math.floor(Math.random() * 16)];
				}
				return color;
			}

$.ajax({


        type: "GET",
        url: "{{ url(config('laraadmin.adminRoute') . '/charts_a') }}",
        success: function (response) {
            var labels = response.data.map(function (e) {
                return e.name
            })

            var tnpemkab = response.data.map(function (e) {
                return e.tanahpemkab
            })

			var tnonpemkab = response.data.map(function (e) {
                return e.tanahnonpemkab
            })



            var ctx = document.getElementById('myChart');
			var myChart = new Chart(ctx, {
				type: 'scatter',
				data: {
					labels: labels,
					datasets: [{
						type:'bar',
						label: 'Data Tanah Pemkab',
                        data: tnpemkab,
                        backgroundColor: color => {var r = Math.floor(Math.random() * 255);
                        var g = Math.floor(Math.random() * 255);
                        var b = Math.floor(Math.random() * 255);
                        return "rgba(" + r + "," + g + "," + b + ", 0.5)";},
						borderWidth: 3
					},
					{
						type:'line',
						label: 'Data Tanah Pemerintahan Lainnya',
                        data: tnonpemkab,
                         backgroundColor: color => {var r = Math.floor(Math.random() * 255);
                        var g = Math.floor(Math.random() * 255);
                        var b = Math.floor(Math.random() * 255);
                        return "rgba(" + r + "," + g + "," + b + ", 0.5)";},
						borderWidth: 3
					}]
				},
				options: {
					scales: {
						y: {
							beginAtZero: true
						}
					}
				}
			});
        },
        error: function(xhr) {
            console.log(xhr.responseJSON);
        }
    });
</script>
@endpush
