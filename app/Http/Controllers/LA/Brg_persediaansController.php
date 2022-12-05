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

use App\Models\Brg_persediaan;

class Brg_persediaansController extends Controller
{
	public $show_action = true;
	public $view_col = 'nama_barang';
	public $listing_cols = ['id', 'nama_barang', 'ref_brg', 'satuan',  'type'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Brg_persediaans', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Brg_persediaans', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Brg_persediaans.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Brg_persediaans');
		
		if(Module::hasAccess($module->id)) {
			return View('la.brg_persediaans.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new brg_persediaan.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created brg_persediaan in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Brg_persediaans", "create")) {
		
			$rules = Module::validateRules("Brg_persediaans", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Brg_persediaans", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.brg_persediaans.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified brg_persediaan.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Brg_persediaans", "view")) {
			
			$brg_persediaan = Brg_persediaan::find($id);
			if(isset($brg_persediaan->id)) {
				$module = Module::get('Brg_persediaans');
				$module->row = $brg_persediaan;
				
				return view('la.brg_persediaans.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('brg_persediaan', $brg_persediaan);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("brg_persediaan"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified brg_persediaan.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Brg_persediaans", "edit")) {			
			$brg_persediaan = Brg_persediaan::find($id);
			if(isset($brg_persediaan->id)) {	
				$module = Module::get('Brg_persediaans');
				
				$module->row = $brg_persediaan;
				
				return view('la.brg_persediaans.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('brg_persediaan', $brg_persediaan);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("brg_persediaan"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified brg_persediaan in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Brg_persediaans", "edit")) {
			
			$rules = Module::validateRules("Brg_persediaans", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Brg_persediaans", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.brg_persediaans.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified brg_persediaan from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Brg_persediaans", "delete")) {
			Brg_persediaan::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.brg_persediaans.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	public function loadbrgpersediaan(Request $request){
		
		if(Module::hasAccess("Brg_persediaans", "view")) {
				$kdbidang = Module::kdopd()->kd_bidang;
				/* $data = Module::brg_persediaan()->get();
				dd($data); */

			if ($request->ajax()) {
					$output = '';
					$query = $request->get('query');
					if ($query != '') {
						if($kdbidang == 99 || $kdbidang == 0 ){				
							$data = Module::brg_persediaanquery($query)->take(3)->get();								
						}else{							
							return view('errors.404');
						}
					} else {				
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::brg_persediaan()->get();
						}else{
							return view('errors.404');
						}
					}
					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index=> $row){
						   $index = $index+1;
						   if(Module::hasAccess("Brg_persediaans", "edit")){
							$output .= '
							<tr>
							 <td>'.$index.'</td>
							 <td>'.$row->jenis_persediaan.'</td>
							 <td>'.$row->nama_barang.'</td>
							 <td>'.$row->uraian_barang.'</td>
							 <td>'.$row->type.'</td>
							 <td>'.$row->satuan.'</td>							 
							 <td>
							 <a href="'.url(config('laraadmin.adminRoute') . '/brg_persediaans/'.$row->id.'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>						 
							 </td>
							</tr>';
						   }else{
							   $output .= '
							<tr>
							 <td>'.$index.'</td>
							 <td>'.$row->jenis_persediaan.'</td>
							 <td>'.$row->nama_brg.'</td>
							 <td>'.$row->uraian_barang.'</td>
							 <td>'.$row->type.'</td>
							 <td>'.$row->satuan.'</td>							 
							 <td>
							 No Access					 
							 </td>
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
	public function dtajax()
	{
		$values = DB::table('brg_persediaans')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Brg_persediaans');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/brg_persediaans/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Brg_persediaans", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/brg_persediaans/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Brg_persediaans", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.brg_persediaans.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
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
