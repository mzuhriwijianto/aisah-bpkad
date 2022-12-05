@extends("la.layouts.app")

@section("contentheader_title")
	<a href="{{ url(config('laraadmin.adminRoute') . '/loanings') }}">Loaning</a> :
@endsection
@section("contentheader_description", $loaning->$view_col)
@section("section", "Loanings")
@section("section_url", url(config('laraadmin.adminRoute') . '/loanings'))
@section("sub_section", "Edit")

@section("htmlheader_title", "Loanings Edit : ".$loaning->$view_col)

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
			<div class="col-md-8 col-md-offset-2">
			{!! Form::model($loaning, ['route' => [config('laraadmin.adminRoute') . '.loanings.update', $loaning->id ], 'method'=>'PUT', 'id' => 'loaning-edit-form']) !!}
					{{-- @la_form($module) --}}
					
					{{-- @la_input($module, 'lend_by')
					@la_input($module, 'lend_date')
					@la_input($module, 'lend_phone') 
					@la_input($module, 'lend_status') --}}
                    <br>
					{{-- @la_input($module, 'lend_estimation') --}}
					
				{{-- Form::close() --}}
			</div>
			<div class="col-md-8 col-md-offset-2">
			<form method="POST" action="/admin/loanings/{{ $loaning->id }}" accept-charset="UTF-8" 
				id="loaning-edit-form" novalidate="novalidate">
				<input name="_method" type="hidden" value="PUT">
				<input name="_token" type="hidden" value="{{ csrf_token() }}">							
					<div class="form-group">
						<label for="idpemda">IDPemda :</label>
						<input class="form-control" placeholder="Enter IDPemda" data-rule-maxlength="256" name="idpemda" id = "idpemda" type="text" value = "{{ $loaning->idpemda }}" readonly>
					</div>
					
					<div class="form-group">
						<label for="lend_by">Barcode BPKB</label>
						<input class="form-control" placeholder="Barcode" name="bcdbpkb" id = "bcdbpkb" type="text" value="" >
					</div>	
										
					<div class="form-group">
						<label for="lend_by">Nama Peminjam</label>
						<input  class="form-control" placeholder="Nama Peminjam" name="lend_by" type="text" value="{{ $loaning->lend_by }}" required />
					</div>
					<div class="form-group">
						<label for="lend_phone">No.HP Peminjam</label>
						<input class="form-control" placeholder="No.HP Peminjam" name="lend_phone" type="text" value="{{ $loaning->lend_phone }}" required />
					</div> 
					@foreach ($data as $datas)
					<div class="form-group">
						<label for="lend_by">Nomor BPKB</label>
						<input class="form-control" placeholder="" name="nobpkb" id = "nobpkb" type="text" value="{{ $datas->nomor_bpkb }}" >
					</div>	
					<div class="form-group">
						<label for="lend_by">Tanggal Peminjaman :</label>
						<input class="form-control" placeholder="Tanggal Peminjaman" name="lend_date" type="text" value="{{ date('d-m-Y',strtotime($datas->tgl_peminjaman)) }}" readonly>
					</div>
					<div class="form-group">
						<label for="lend_estimation">Tanggal Pengembalian :</label>
							<input class="form-control" placeholder="Tanggal Pengembalian" name="lend_estimation" type="text" value="{{ date('d-m-Y',strtotime($datas->tgl_pengembalian)) }}" readonly />	
					</div>
					@endforeach
					<div class="form-group"><label for="lend_status"></label>
					<!--<select class="form-control select2-hidden-accessible" data-placeholder="Enter lend_status" rel="select2" name="lend_status" tabindex="-1" aria-hidden="true">
					<option value="DIPINJAM" selected="selected">DIPINJAM</option>
					<option value="DIKEMBALIKAN">DIKEMBALIKAN</option>
					</select>-->
					{{-- @la_input($module, 'lend_status') --}}
					</div>
					<br>
					<div class="form-group">
						<div class="form-group" >
						<div id = "updatebutton">
							{!! Form::submit( 'Update', ['class'=>'btn btn-success']) !!}
						</div>
						<div>
							<button class="btn btn-default pull-right"><a href="{{ url(config('laraadmin.adminRoute') . '/loanings') }}">Cancel</a></button>
						</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
<script>
$("#updatebutton").hide();


$(document).ready(function () {
	$(document).on('keyup', '#bcdbpkb', function () {
		var inputidpemda = document.getElementById("idpemda").value;
		var inputbcd = document.getElementById("bcdbpkb").value;	
		var inputnobpkb = document.getElementById("nobpkb").value;	
					
		if(inputbcd.length = 17) {
			setTimeout(function() {
		  //your code to be executed after 1 second
				//if (inputbcd.length = 17) { 
					if (inputidpemda == inputbcd){
						//if(inputnobpkb != ""){
							$("#updatebutton").show();
						//}
						
					} else {
						alert('Data not found');
						$("#updatebutton").hide();
						 document.getElementById("bcdbpkb").value = '';
						 document.getElementById("bcdbpkb").focus();
					}
				//}else{
					//alert('Data not found');
				//}
			}, 100);
		}else{
			document.getElementById("bcdbpkb").value = '';
		}
	});	
});


function validate() {
	//cleartxt();
	$('input[id="chkbox1"]:checked').each(function() {				
			var selectedidpemda = new Array();			
			selectedidpemda.push(this.value);
			var data = selectedidpemda+ ',';
			document.getElementById('searchsolo').value += data;
	});
}
</script>
@endpush
