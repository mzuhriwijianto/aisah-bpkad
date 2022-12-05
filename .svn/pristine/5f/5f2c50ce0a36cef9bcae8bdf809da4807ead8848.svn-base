@extends("la.layouts.app")

@section("contentheader_title", "Racks")
@section("contentheader_description", "Racks listing")
@section("section", "Racks")
@section("sub_section", "Listing")
@section("htmlheader_title", "Racks Listing")

@section("headerElems")
@la_access("Racks", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add Rack</button>
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
		<li class="active"><a role="tab" data-toggle="tab" class="active" href="#rack" data-target="#tab-info"><i class="fa fa-barcode"></i> Entry</a></li>
		<li class=""><a role="tab" data-toggle="tab" href="#lists" data-target="#tab-timeline"><i class="fa fa-clock-o"></i>Lists</a></li>
</ul>
<div class="tab-content">
	<div role="tabpanel" class="tab-pane active fade in" id="tab-info">
		<div class="tab-content">
			<div class="panel infolist">
				<div class="panel-default panel-heading">
					<h4>Entry</h4>
				</div>
				<div class="panel-body">
					<div class="box box-success">
						<div class="box-body">
							<table id="example4" class="table table-bordered table-striped">
							<thead>
							<tr class="success">
								<th>Storage Name</th>
								<th>Rack Name</th>
								<th>Count</th>
								<th>Actions</th>
							</tr>
							</thead>
							<tbody>
							@foreach($storagerack as $storageracks)
							<tr >
								<td>{{ $storageracks->storage_name }}</td>
								<td data-id="{{ $storageracks->id }}" 
									data-storage = "{{ $storageracks->storage_name }}"
									data-rack = "{{ $storageracks->rack_name }}"
									data-rackid = "{{ $storageracks->id }}"
									data-target="#orderModal" class = "rack">{{ $storageracks->rack_name }}</td>
								<td>{{ $storageracks->Count }}</td>
								<td><a href='racks/{{ $storageracks->id }}' class="btn btn-xs btn-edit btn-warning"><i class="fa fa-pencil"></i></a></td>
								
							</tr>		
							@endforeach
							</tbody>
							</table>		
						</div>						
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div role="tabpanel" class="tab-pane bg-white" id="tab-timeline">

		<div class="timeline-item">
				<div class="timeline-item">
					<div class="panel-default panel-heading">
						<h4>Lists</h4>
					</div>
					<div class="box box-success">
						<div class="form-group">
						<h2>Nomor Polisi / Nomor BPKB</h2>
							<input type="text" name="search" id="search" class="form-control" placeholder="Cari.." />
						</div>
						<div class="form-group ">
							<h2>Print List</h2>	
						<form id = "getprintsoloform" method="POST" action="bcdsolo" accept-charset="UTF-8" class = "col-sm-6">
						<input name="_token" type="hidden" value="{{ csrf_token() }}">						
							<div class="input-group">
							  <input type="text" name="searchsolo" id="searchsolo" class="form-control" placeholder="Cari.." readonly />
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
						<div class="box-body table-responsive">
							<table id="example1" class="table table-bordered table-striped">
							<thead>
							<tr class="bg-aqua">
								<th>id</th>
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
								<th>Pemegang Kendaraan</th>							
								<th>File Foto Kendaraan</th>							
								<th>Action</th>							
							 </tr>
							</thead>
							<tbody>	

							</tbody>
							</table>
						</div>
					</div>
				</div>
		</div>
	</div>
</div>
<div class="modal fade" id="orderModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden = "true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden = "true">&times;</button>
				<h2 class="modal-title" id="myModalLabel">INPUT BPKB</h2>				
			</div>
			<div class="modal-body">
				<ul class="timeline bg-white">
					<li>
							<div id="storagename" class="modal-body bg-blue"></div>						
					</li>
					<li>
							<div id="rackname" class="modal-body bg-purple"></div>				
					</li>
					<li>
						<input type="text" id="myInput" name = 'bcd' 
						onkeyup="valinst()" placeholder="Barcode" 
						style = "height : 90px; width : 560px; font-size: 50px;"/>
						<div id="rackid" class="modal-body bg-white" style = "color: #fff;"></div>
					</li>														
				</ul>								
			</div>
			<div class="modal-footer">							
				<button type="button" class="btn btn-secondary" data-dismiss="modal" aria-hidden = "true">Close</button>
			</div>			
		</div>
	</div>
</div>

@la_access("Racks", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Rack</h4>
			</div>
			{!! Form::open(['action' => 'LA\RacksController@store', 'id' => 'rack-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
                    {{--@la_form($module)--}}
										
					{{--@la_input($module, 'rack_code')--}}
					@la_input($module, 'rack_name')
					@la_input($module, 'storage')
					
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
<script src="{{ asset('la-assets/plugins/datatables/datatables.min.js') }}"></script>
<script>

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

$(document).ready(function () {

            fetch_customer_data();

            function fetch_customer_data(query = '') {
                $.ajax({
                    url:"{{ url(config('laraadmin.adminRoute') . '/rackskendaraanscari') }}",
                    method: 'GET',
                    data: {query: query},
                    dataType: 'json',
                    success: function (data) {
                        $('#example1 tbody').html(data.table_data);
                    }
                })
            }

            $(document).on('keyup', '#search', function () {
                var query = $(this).val();
                fetch_customer_data(query);
            });
        });

//focus to input text
 $('#orderModal').on('shown.bs.modal', function() {
  $('#myInput').focus();
});
//close and refresh
$('#orderModal').on('hidden.bs.modal', function () {
 location.reload();
 //alert('hidden event fired!');
})

$(function () {
document.getElementById("myInput").focus();
    $('#orderModal').modal({
        keyboard: true,
        backdrop: "static",
        show: false,
    }).on('show', function () {
		
	});
    $(".table-striped").find('td[data-id]').on('click', function () {
        debugger;
        //do all your operation populate the modal and open the modal now. DOnt need to use show event of modal again
        $('#Details').html($('<b> Order Id selected : ' + $(this).data('id') + '</b>'));
        $('#storagename').html($('<b> Storage Name : ' + $(this).data('storage') + '</b>'));
        $('#rackname').html($('<b> Rack Name : ' + $(this).data('rack') + '</b>'));
		$('#rackid').html($(this).data('id'));
        $('#orderModal').modal('show');
    });
			
});


function cleartxt(){
	document.getElementById('myInput').value = ''
}

function valinst() {

 // check if input is bigger than 17
var idpemda = document.getElementById('myInput').value;
	if(idpemda.length <= 17){
		setTimeout(function() {
		//your code to be executed after 1 second
			if (idpemda.length = 17) { 
				UpdateRecord();
			}else{
				alert('Data not found');
			}
		}, 1000);
	}
}

function UpdateRecord(){
var idpemda = document.getElementById('myInput').value;
var rackid = document.querySelector('#rackid').innerHTML; 
var link = '/admin/rackss/insrack';

       $.ajax({
				 url: link,
				 data: 'idpemda='+idpemda+'&rackid='+rackid,
				 method:'get',
				 success: function(data){       // variabel data hasil dari return controller
					if(data.status == "Data Not Found!"){
						    alert(data.status);
							cleartxt();											  
					}else{
						 //data.message;
						$('#example4').load(document.URL + ' #example4');
						 cleartxt();						 
					}
				 }									
			 })           
}  
</script>
@endpush
