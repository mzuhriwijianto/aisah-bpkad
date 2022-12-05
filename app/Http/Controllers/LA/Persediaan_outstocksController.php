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

use App\Models\Persediaan_outstock;

class Persediaan_outstocksController extends Controller
{
	public $show_action = true;
	public $view_col = 'ref_persediaan';
	public $listing_cols = ['id', 'ref_persediaan', 'ref_brg', 'kd_bidang', 'kd_unit', 'kd_sub', 'kd_upb', 'jml_outstock', 'tgl_outstock'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Persediaan_outstocks', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Persediaan_outstocks', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Persediaan_outstocks.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		$module = Module::get('Persediaan_outstocks');
		$kdbidang = Module::kdopd()->kd_bidang;
		$refpersediaan = Module::ref_persediaan()->get();
		
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$kdsub = Module::kdopd()->kd_sub;
		
		
		//$upbuser = Module::populateupbuser2($kdbidang,$kdunit,$kdsub)->get();
		//dd($upbuser);
		if($kdbidang == 99 || $kdbidang == 0 ){			
			$refbidang = Module::populatebidangadmin()->get();
			$upbuser = Module::populateupball()->get();			
		}else{
			$kdbidang = Module::kdopd()->kd_bidang;
			$kdunit = Module::kdopd()->kd_unit;
			$kdsub = Module::kdopd()->kd_sub;
			$kdupb = Module::kdopd()->kd_upb;
			$refbidang = Module::populatebidanguser()->get();
			$upbuser = Module::populateupbuser2($kdbidang,$kdunit,$kdsub)->get();
		}
		
		if(Module::hasAccess($module->id)) {
			return View('la.persediaan_outstocks.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module,
				'refbidang' => $refbidang,
				'refpersediaan' => $refpersediaan,
				'upbuser' => $upbuser
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}
	public function unit($ids){
					
			$kdbidang = Module::kdopd()->kd_bidang;
			$kdunit = Module::kdopd()->kd_unit;
			$kdsub = Module::kdopd()->kd_sub;
			$kdupb = Module::kdopd()->kd_upb;
			
			if($kdbidang == 99 || $kdbidang == 0 ){
				$unit = Module::populateunitadmin($ids)->pluck('nm_unit', 'kd_unit');
				return json_encode($unit);
			}else{
				$unit = Module::populateunituser($kdbidang)->pluck('nm_unit', 'kd_unit');
				//dd($unit->get());
				return json_encode($unit);
			}
		}
	public function sub($ids,$idss){
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$kdsub = Module::kdopd()->kd_sub;
		$kdupb = Module::kdopd()->kd_upb;
		
		if($kdbidang == 99 || $kdbidang == 0 ){
			$sub = Module::populatesubadmin($ids,$idss)->pluck('nm_sub_unit', 'kd_sub');
			return json_encode($sub);
		}else{
			$sub = Module::populatesubuser($kdbidang,$kdunit)->pluck('nm_sub_unit', 'kd_sub');
			return json_encode($sub);
		}
	}
	public function upb($ids,$idss,$idsss){
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$kdsub = Module::kdopd()->kd_sub;
		$kdupb = Module::kdopd()->kd_upb;
		
		if($kdbidang == 99 || $kdbidang == 0 ){
			$upb = Module::populateupbadmin($ids,$idss,$idsss)->pluck('Nm_UPB', 'kd_upb');
			return json_encode($upb);
		}else{
			$upb = Module::populateupbuser($kdbidang,$kdunit,$kdsub)->pluck('Nm_UPB', 'kd_upb');
			return json_encode($upb);
		}
	}
	
	public function upbuser($ids,$idss,$idsss){
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$kdsub = Module::kdopd()->kd_sub;
		
		if($kdbidang == 99 || $kdbidang == 0 ){
			$upb = Module::populateupbadmin($ids,$idss,$idsss)->pluck('Nm_UPB', 'kd_upb');
			return json_encode($upb);
		}else{
			$upb = Module::populateupbuser($kdbidang,$kdunit,$kdsub)->pluck('Nm_UPB', 'kd_upb');
			return json_encode($upb);
		}
	}
	
	public function persediaangroup($id){
			$group = Module::brg_persediaangroup($id)->pluck('uraian_barang');
			return json_encode($group);
	}
	/**
	 * Show the form for creating a new persediaan_outstock.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created persediaan_outstock in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Persediaan_outstocks", "create")) {
		
			$rules = Module::validateRules("Persediaan_outstocks", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Persediaan_outstocks", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.persediaan_outstocks.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified persediaan_outstock.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Persediaan_outstocks", "view")) {
			
			$persediaan_outstock = Persediaan_outstock::find($id);
			if(isset($persediaan_outstock->id)) {
				$module = Module::get('Persediaan_outstocks');
				$module->row = $persediaan_outstock;
				
				return view('la.persediaan_outstocks.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('persediaan_outstock', $persediaan_outstock);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("persediaan_outstock"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified persediaan_outstock.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Persediaan_outstocks", "edit")) {			
			$persediaan_outstock = Persediaan_outstock::find($id);
			if(isset($persediaan_outstock->id)) {	
				$module = Module::get('Persediaan_outstocks');
				
				$module->row = $persediaan_outstock;
				
				return view('la.persediaan_outstocks.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('persediaan_outstock', $persediaan_outstock);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("persediaan_outstock"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified persediaan_outstock in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Persediaan_outstocks", "edit")) {
			
			$rules = Module::validateRules("Persediaan_outstocks", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Persediaan_outstocks", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.persediaan_outstocks.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified persediaan_outstock from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Persediaan_outstocks", "delete")) {
			Persediaan_outstock::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.persediaan_outstocks.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	public function rekapinstock(Request $request,$kdbidangs,$kdunits,$kdsubs,$kdupbs){
	if(Module::hasAccess("Persediaan_outstocks", "view")) {
				$kdbidang = Module::kdopd()->kd_bidang;
				
				//$data = Module::rekapinstock($kdbidangs,$kdunits,$kdsubs,$kdupbs,$tglawal,$tglakhir)->get();
				//dd($data);
				//$data = Module::loadinstock_out($kdbidangs,$kdunits,$kdsubs,$kdupbs)->get();
				//dd($data);
			if ($request->ajax()) {
					$output = '';
					$query = $request->get('query');
					if ($query != '') {
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::loadinstock_outquery($kdbidangs,$kdunits,$kdsubs,$kdupbs,$query)->get();
						}else{
							$data = Module::loadinstock_outquery($kdbidangs,$kdunits,$kdsubs,$kdupbs,$query)->get();	
						}
					} else {
						if($kdbidang == 99 || $kdbidang == 0 ){							
							$data = Module::loadinstock_out($kdbidangs,$kdunits,$kdsubs,$kdupbs)->get();	
							
						}else{
							/* $kdunit = Module::kdopd()->kd_unit;
							$kdsub = Module::kdopd()->kd_sub;
							$kdupb = Module::kdopd()->kd_upb; */
							$data = Module::loadinstock_out($kdbidangs,$kdunits,$kdsubs,$kdupbs)->get();
						}
					}
					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index=> $row){
						   $index = $index+1;
						   if(Module::hasAccess("Persediaan_outstocks", "edit")){
							$output .= '
							<tr  name = "pilihanbarang">
							 <td>'.$index.'</td>
							 <td>'.$row->jenis_persediaan.'</td>					 
							 <td id = "barangx">'.$row->nama_barang.'</td>						 
							 <td id = "uraianx">'.$row->uraian_barang.'</td>						 
							 <td id = "typex">'.$row->type.'</td>
							 <td id = "satuanx">'.$row->satuan.'</td>
							 <td id = "jumlahx">'.$row->jmlinstock.'</td>
							 <td id = "jumlahx">'.$row->jmloutstock.'</td>
							 <td id = "hargax">'.$row->hrginstock.'</td>
							 <td id = "hargax">'.$row->hrgoutstock.'</td>
							</tr>';
						   }else{
							   $output .= '
							<tr>
							 <td>'.$index.'</td>
							 <td>'.$row->jenis_persediaan.'</td>					 
							 <td id = "barangx">'.$row->nama_barang.'</td>						 
							 <td id = "uraianx">'.$row->uraian_barang.'</td>						 
							 <td id = "typex">'.$row->type.'</td>
							 <td id = "satuanx">'.$row->satuan.'</td>
							 <td id = "jumlahx">'.$row->jmlinstock.'</td>
							 <td id = "jumlahx">'.$row->jmloutstock.'</td>
							 <td id = "hargax">'.$row->hrginstock.'</td>
							 <td id = "hargax">'.$row->hrgoutstock.'</td>
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
		$values = DB::table('persediaan_outstocks')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Persediaan_outstocks');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/persediaan_outstocks/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Persediaan_outstocks", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/persediaan_outstocks/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Persediaan_outstocks", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.persediaan_outstocks.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
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
