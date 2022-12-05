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

use App\Models\Ref_persediaan;

class Ref_persediaansController extends Controller
{
	public $show_action = true;
	public $view_col = 'jenis_persediaan';
	public $listing_cols = ['id', 'jenis_persediaan'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Ref_persediaans', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Ref_persediaans', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Ref_persediaans.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Ref_persediaans');
		
		if(Module::hasAccess($module->id)) {
			return View('la.ref_persediaans.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new ref_persediaan.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created ref_persediaan in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Ref_persediaans", "create")) {
		
			$rules = Module::validateRules("Ref_persediaans", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Ref_persediaans", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.ref_persediaans.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified ref_persediaan.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Ref_persediaans", "view")) {
			
			$ref_persediaan = Ref_persediaan::find($id);
			if(isset($ref_persediaan->id)) {
				$module = Module::get('Ref_persediaans');
				$module->row = $ref_persediaan;
				
				return view('la.ref_persediaans.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('ref_persediaan', $ref_persediaan);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("ref_persediaan"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified ref_persediaan.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Ref_persediaans", "edit")) {			
			$ref_persediaan = Ref_persediaan::find($id);
			if(isset($ref_persediaan->id)) {	
				$module = Module::get('Ref_persediaans');
				
				$module->row = $ref_persediaan;
				
				return view('la.ref_persediaans.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('ref_persediaan', $ref_persediaan);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("ref_persediaan"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified ref_persediaan in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Ref_persediaans", "edit")) {
			
			$rules = Module::validateRules("Ref_persediaans", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Ref_persediaans", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.ref_persediaans.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified ref_persediaan from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Ref_persediaans", "delete")) {
			Ref_persediaan::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.ref_persediaans.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	public function loaddatapersediaan(Request $request){
		
		if(Module::hasAccess("Ref_persediaans", "view")) {
				$kdbidang = Module::kdopd()->kd_bidang;

			if ($request->ajax()) {
					$output = '';
					$query = $request->get('query');
					if ($query != '') {
						if($kdbidang == 99 || $kdbidang == 0 ){				
							$data = Module::ref_persediaanquery($query)->take(3)->get();								
						}else{							
							return view('errors.404');
						}
					} else {
						
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::ref_persediaan()->get();
						}else{
							return view('errors.404');
						}
					}
					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index=> $row){
						   $index = $index+1;
						   if(Module::hasAccess("Ref_persediaans", "edit")){
							$output .= '
							<tr>
							 <td>'.$index.'</td>
							 <td>'.$row->jenis_persediaan.'</td>
							 <td>
							 <a href="'.url(config('laraadmin.adminRoute') . '/ref_persediaans/'.$row->id.'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>						 
							 </td>
							</tr>';
						   }else{
							   $output .= '
							<tr>
							 <td>'.$index.'</td>
							 <td>'.$row->jenis_persediaan.'</td>						 						
							</tr>';
						   }
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
			}
		}else{
			return view('errors.404');
		} 
		
	}
	
	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax(){

	}
}
