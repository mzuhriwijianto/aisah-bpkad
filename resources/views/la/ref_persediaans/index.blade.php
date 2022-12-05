@extends("la.layouts.app")

@section("contentheader_title", "Ref Persediaan")
@section("contentheader_description", "Ref Persediaan listing")
@section("section", "Ref Persediaans")
@section("sub_section", "Listing")
@section("htmlheader_title", "Ref Persediaan Listing")

@section("headerElems")
@la_access("Ref_persediaans", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add Ref persediaan</button>
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
</ul>
<div class="tab-content">
	<div role="tabpanel" class="tab-pane active fade in" id="tab-info">
		<div class="form-group" class = "col-sm-4">
			<div class="col-md-12">
			<label for="alamat" >Jenis Persediaan</label>
				<input type="text" name="search" id="search" class="form-control" placeholder="Cari.." />
			</div>	
		</div>
		<div class="panel infolist">	
				<h2>Jenis Persediaan</h2>
					<table class="table table-bordered table-striped">
					<thead>
						<tr class="bg-aqua">
							<th>No.</th>
							<th>Jenis Persediaan</th>
							<th>Action</th>																																																
						</tr>
					</thead>
					<tbody id= "tbody1">	

					</tbody>
					</table>
		</div>
	</div>
</div>

@la_access("Ref_persediaans", "create")
<div class="modal fade" id="AddModal" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Add Ref persediaan</h4>
			</div>
			{!! Form::open(['action' => 'LA\Ref_persediaansController@store', 'id' => 'ref_persediaan-add-form']) !!}
			<div class="modal-body">
				<div class="box-body">
                    @la_form($module)
					
					{{--
					@la_input($module, 'jenis_persediaan')
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

@push('scripts')
<script>
//search
$(document).ready(function () {

            fetch_customer_data();

            function fetch_customer_data(query = '') {
                $.ajax({
                    url:"{{ url(config('laraadmin.adminRoute') . '/loadrefpersediaan') }}",
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

            $(document).on('keyup', '#search', function () {
                var query = $(this).val();
                fetch_customer_data(query);				
            });		
        });
//endsearch


</script>
@endpush
