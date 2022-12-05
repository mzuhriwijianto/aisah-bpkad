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

use App\Models\Logact;

class LogactsController extends Controller
{
	public $show_action = true;
	public $view_col = 'idpemda';
	public $listing_cols = ['id', 'username', 'menuname', 'act', 'idpemda', 'no_reg', 'tgl_perolehan', 'harga', 'luas', 'koordx', 'koordy'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Logacts', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Logacts', $this->listing_cols);
		}
	}
	public function loadDatalog(Request $request){
	if(Module::hasAccess("Logacts", "view")) {

			if ($request->ajax()) {
					$output = '';
					$query = $request->get('query');
					if ($query != '') {
							$data = DB::table('logacts as log')
							->leftjoin('departments as dept', function ($join) {
									$join->on('dept.kd_bidang','=','log.kd_bidang')
											->on('dept.kd_unit','=','log.kd_unit')
											->on('dept.kd_sub','=','log.kd_sub');
								}
							)
							->select('log.id','dept.name as deptname','log.username','log.menuname','log.act','log.idpemda',
									'log.no_reg','log.tgl_perolehan','log.harga','log.keterangan','log.created_at')
							->distinct()
							->where('log.username','LIKE','%'.$query.'%')
							->orwhere('dept.name','LIKE','%'.$query.'%')
							->orwhere('log.keterangan','LIKE','%'.$query.'%')
						->orderBy('log.created_at', 'DESC')
						->get();
					}else{
							$data = DB::table('logacts as log')
							->leftjoin('departments as dept', function ($join) {
									$join->on('dept.kd_bidang','=','log.kd_bidang')
											->on('dept.kd_unit','=','log.kd_unit')
											->on('dept.kd_sub','=','log.kd_sub');
								}
							)
							->select('log.id','dept.name as deptname','log.username','log.menuname','log.act','log.idpemda',
									'log.no_reg','log.tgl_perolehan','log.harga','log.keterangan','log.created_at')
						->distinct()
						->orderBy('log.created_at', 'DESC')
						->get();	
					}
			}
					$total_row = count($data);
			if($total_row > 0){
					   foreach($data as $row){
							   $output .= '
							<tr>
							 <td>'.$row->id.'</td>
							 <td>'.$row->deptname.'</td>
							 <td>'.$row->username.'</td>
							 <td>'.$row->menuname.'</td>
							 <td>'.($row->act == 'INSERT' ? '<i class="fa fa-arrow-right btn-primary btn-xs">' : ($row->act == 'UPDATE' ? '<i class="fa fa-edit btn-warning btn-xs">' : '<i class="fa fa-times btn-danger btn-xs">' )).'</td>
							 <td>'.$row->idpemda.'</td>
							 <td>'.$row->no_reg.'</td>
							 <td>'.$row->tgl_perolehan.'</td>
							 <td>'.$row->harga.'</td>
							 <td>'.$row->keterangan.'</td>
							 <td>'.$row->created_at.'</td>
							</tr>';
					   }
		  }else{
			   $output = '
			   <tr>
				<td align="center" colspan="5">No Data Found</td>
			   </tr>
			   ';
		  }
				  $data = array(
				   'table_data'  => $output,
				   'total_data'  => $total_row
				  );

				  echo json_encode($data);
		}else{
			return view('errors.404');
		}            
    }
	/**
	 * Display a listing of the Logacts.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Logacts');
		
		if(Module::hasAccess($module->id)) {
			return View('la.logacts.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new logact.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created logact in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Logacts", "create")) {
		
			$rules = Module::validateRules("Logacts", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Logacts", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.logacts.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified logact.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Logacts", "view")) {
			
			$logact = Logact::find($id);
			if(isset($logact->id)) {
				$module = Module::get('Logacts');
				$module->row = $logact;
				
				return view('la.logacts.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('logact', $logact);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("logact"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified logact.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Logacts", "edit")) {			
			$logact = Logact::find($id);
			if(isset($logact->id)) {	
				$module = Module::get('Logacts');
				
				$module->row = $logact;
				
				return view('la.logacts.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('logact', $logact);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("logact"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified logact in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Logacts", "edit")) {
			
			$rules = Module::validateRules("Logacts", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Logacts", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.logacts.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified logact from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Logacts", "delete")) {
			Logact::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.logacts.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax()
	{
		$values = DB::table('logacts')->select($this->listing_cols);//->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Logacts');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/logacts/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Logacts", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/logacts/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Logacts", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.logacts.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}
}
