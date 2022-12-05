@extends("la.layouts.app")

@section("contentheader_title", "Log Activity")
@section("contentheader_description", "Log Activity Listing")
@section("section", "Logacts")
@section("sub_section", "Listing")
@section("htmlheader_title", "Log Activity Listing")

@section("headerElems")
@la_access("Logacts", "create")
	<button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#AddModal">Add Logact</button>
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

<div class="box box-success">
	<!--<div class="box-header"></div>-->
	<div class="timeline-item">
				<div class="timeline-item">
					<div class="panel-default panel-heading">
						<h4>Dept name / Username</h4>
						<div class="form-group">
							<input type="text" name="search" id="search" class="form-control" placeholder="Cari.." />
						</div>
					</div>
					<div class="box box-success">
						<div class="box-body table-responsive">
							<table id="example1" class="table table-bordered table-striped">
							<thead>
							<tr class="bg-aqua">
								<th>id</th>
								<th>Dept</th>								
								<th>Username</th>							
								<th>Menu Name</th>							
								<th>Action</th>							
								<th>IDPemda</th>							
								<th>No Reg</th>							
								<th>Tgl_Perolehan</th>							
								<th>Harga</th>							
								<th>Keterangan</th>																				
								<th>Created At</th>																				
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

@endsection

@push('scripts')
<script>
//datalog
$(document).ready(function () {

            fetch_customer_data();

            function fetch_customer_data(query = '') {
                $.ajax({
                    url:"{{ url(config('laraadmin.adminRoute') . '/loaddata') }}",
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
</script>
@endpush
