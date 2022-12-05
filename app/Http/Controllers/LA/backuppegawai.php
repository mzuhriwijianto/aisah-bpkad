<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;
use Validator;
use Datatables;
use Collective\Html\FormFacade as Form;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;

use App\Models\Data_Pegawai;

class Data_PegawaisController extends Controller
{
	public $show_action = true;
	public $view_col = 'nama_peg';
	public $listing_cols = ['id', 'nama_peg', 'nip', 'jabatan', 'department', 'pemegang_aset'];

	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Data_Pegawais', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Data_Pegawais', $this->listing_cols);
		}
	}

	public function LoadDataPegawais(Requests $request){
		if(Module::hasAccess("data_pegawais","view")){
			if($request->ajax()){
				$output = '';
				$query = $request->get('query');
				if($query != ''){
					$data = DB::table('data_pegawais as peg')
					->leftjoin(DB::table('kibbs'))
					->leftjoin('departments as dept', function ($join){
						$join->on('dept.id','=','peg.id');
					})
					->select('peg.id','peg.nama_peg','peg.nip','peg.jabatan','dept.name as Dept','peg.pemegang_aset')
					->where([['peg.nama_peg','LIKE','%'.$query.'%']])
					->take(10)
					->get();
				}else{
					$data = DB::table('data_pegawais as peg')
					->leftjoin(DB::table('kibbs'))
					->leftjoin('departments as dept', function ($join){
						$join->on('dept.id','=','peg.id');
					})
					->select('peg.id','peg.nama_peg','peg.nip','peg.jabatan','dept.name as Dept','peg.pemegang_aset')
					->where([['peg.nama_peg','LIKE','%'.$query.'%']])
					->take(10)
					->get();
				}
				$total_row = count($data);
					if($total_row > 0){
						foreach($data as $row){
							if(Module::hasAccess("data_pegawais","edit")){
								$output .='
							<tr>
							 <td>'.$row->id.'</td>
							 <td><a href="'.url(config('laraadmin.adminRoute') . '/data_pegawais/'.$row->id).'">'.$row->nama_peg.'</a></td>
							 <td>'.$row->nip.'</td>
							 <td>'.$row->jabatan.'</td>
							 <td>'.$row->Dept.'</td>
							 <td>'.$row->pemegang_aset.'</td>
							 <td>
							 <a href="'.url(config('laraadmin.adminRoute') . '/data_pegawais/'.$row->id.'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>
							 </td>
							</tr>';

							}else{
								$output .='
							<tr>
							 <td>'.$row->id.'</td>
							 <td><a href="'.url(config('laraadmin.adminRoute') . '/data_pegawais/'.$row->id).'">'.$row->nama_peg.'</a></td>
							 <td>'.$row->nip.'</td>
							 <td>'.$row->jabatan.'</td>
							 <td>'.$row->Dept.'</td>
							 <td>'.$row->pemegang_aset.'</td>
							 <td>
							 Not Authorize
							 </td>
							</tr>';
							}
						}
					}else{
						$output = '
						<tr>
							<td align="center" colspan="5">No Data Found</td>
						</tr>';
					}
					$data = array(
					'table_data' => $output,
					'total_data' => $total_row );
					echo json_encode($data);
			}
		}else{
			return view('errors.404');
		}

	}
	/**
	 * Display a listing of the Data_Pegawais.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Data_Pegawais');
		$values = DB::table('data_pegawais as peg')
					->leftjoin('departments as dept','peg.id','=','dept.id')
					->leftjoin('kibbs as barang','peg.id','=','barang.id')
					->select('nama_peg','nip','jabatan','department','pemegang_aset')
					->whereNull('deleted_at');
					//dd($values);
		if(Module::hasAccess($module->id)) {
			return View('la.data_pegawais.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new data_pegawai.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created data_pegawai in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Data_Pegawais", "create")) {

			$rules = Module::validateRules("Data_Pegawais", $request);

			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}

			$insert_id = Module::insert("Data_Pegawais", $request);

			return redirect()->route(config('laraadmin.adminRoute') . '.data_pegawais.index');

		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified data_pegawai.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Data_Pegawais", "view")) {

			$data_pegawai = Data_Pegawai::find($id);
			if(isset($data_pegawai->id)) {
				$module = Module::get('Data_Pegawais');
				$module->row = $data_pegawai;

				return view('la.data_pegawais.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('data_pegawai', $data_pegawai);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("data_pegawai"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified data_pegawai.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Data_Pegawais", "edit")) {
			$data_pegawai = Data_Pegawai::find($id);
			if(isset($data_pegawai->id)) {
				$module = Module::get('Data_Pegawais');

				$module->row = $data_pegawai;

				return view('la.data_pegawais.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('data_pegawai', $data_pegawai);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("data_pegawai"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified data_pegawai in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Data_Pegawais", "edit")) {

			$rules = Module::validateRules("Data_Pegawais", $request, true);

			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}

			$insert_id = Module::updateRow("Data_Pegawais", $request, $id);

			return redirect()->route(config('laraadmin.adminRoute') . '.data_pegawais.index');

		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified data_pegawai from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Data_Pegawais", "delete")) {
			Data_Pegawai::find($id)->delete();

			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.data_pegawais.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax(Request $request)
	{


		if(Module::hasAccess("Data_Pegawais","view")){
			if($request->ajax()){
				$output='';
				$query = $request->get('query');
				if($query != ''){
					$values = DB::table('data_pegawais as peg')
					->leftjoin('departments as dept','peg.id','=','dept.id')
					->leftjoin('kibbs as barang','peg.id','=','barang.id')
					->select('nama_peg','nip','jabatan','department','pemegang_aset')
					->where('peg.name','like','%'.$query.'%')
					->get();
				}else{
					$values = DB::table('data_pegawais as peg')
					->leftjoin('departments as dept','peg.id','=','dept.id')
					->leftjoin('kibbs as barang','peg.id','=','barang.id')
					->select('nama_peg','nip','jabatan','department','pemegang_aset')
					->get();
				}
			}
		}
		/* $values = DB::table('data_pegawais')->select($this->listing_cols)->whereNull('deleted_at'); */
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Data_Pegawais');

		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) {
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/data_pegawais/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}

			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Data_Pegawais", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/data_pegawais/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}

				if(Module::hasAccess("Data_Pegawais", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.data_pegawais.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($values);
		return $out;
	}
}
