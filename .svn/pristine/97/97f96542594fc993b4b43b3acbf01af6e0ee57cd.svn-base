@extends("la.layouts.app")

@section("contentheader_title", "Users")
@section("contentheader_description", "users listing")
@section("section", "Users")
@section("sub_section", "Listing")
@section("htmlheader_title", "Users Listing")

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

<div class="box box-success">
	<!--<div class="box-header"></div>-->
	<div class="box-body">
		<div class="timeline-item">
					<div class="panel-default panel-heading">
						<h4>Lists Users</h4>
					</div>
					<div class="box box-success">
						<div class="form-group">
						<h2>Users</h2>
							<input type="text" name="search" id="search" class="form-control" placeholder="Cari.." />
						</div>
						<div class="box-body table-responsive">
							<table id="example1" class="table table-bordered table-striped">
							<thead>
							<tr class="bg-aqua">
								<th>No.</th>
								<th>Name</th>								
								<th>Designation</th>							
								<th>Mobile</th>							
								<th>Department</th>													
							 </tr>
							</thead>
							<tbody id="tbody1">	

							</tbody>
							</table>
						</div>
					</div>
				</div>
	</div>
</div>

@endsection

@push('styles')

@endpush

@push('scripts')

<script>
$(document).ready(function () {
            fetch_customer_data();

            function fetch_customer_data(query = '') {
                $.ajax({
                    url:"{{ url(config('laraadmin.adminRoute') . '/user_dt_ajax') }}",
                    method: 'GET',
                    data: {query: query},
                    dataType: 'json',
                    success: function (data) {
                        //$('tbody').html(data.table_data);
						$('#tbody1').html(data.table_data);
                    }
                })
            }

            $(document).on('keyup', '#search', function () {
                var query = $(this).val();
                fetch_customer_data(query);
            });
        });
</script>
@endpush