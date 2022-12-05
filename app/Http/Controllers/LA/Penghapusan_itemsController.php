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

use App\Models\Penghapusan_item;
use App\Models\Ajuan_penghapusanpb;

class Penghapusan_itemsController extends Controller
{
	public $show_action = true;
	public $view_col = 'id_ajuan';
	public $listing_cols = ['id', 'no_ajuan', 'idpemda', 'Validation_img', 'validation_by', 'validation_at', 'kd_aset8', 'kd_aset80', 'kd_aset81', 'kd_aset82', 'kd_aset83', 'kd_aset84', 'kd_aset85'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Penghapusan_items', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Penghapusan_items', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Penghapusan_items.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		$module = Module::get('Penghapusan_items');
		$adm = Module::getadmphp()->get();
		if(Module::hasAccess($module->id)) {
			return View('la.penghapusan_items.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'adm' => $adm,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new penghapusan_item.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created penghapusan_item in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Penghapusan_items", "create")) {
		
			$rules = Module::validateRules("Penghapusan_items", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Penghapusan_items", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.penghapusan_items.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified penghapusan_item.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Penghapusan_items", "view")) {
			
			$penghapusan_item = Penghapusan_item::find($id);
			if(isset($penghapusan_item->id)) {
				$module = Module::get('Penghapusan_items');
				$module->row = $penghapusan_item;
				
				return view('la.penghapusan_items.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('penghapusan_item', $penghapusan_item);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("penghapusan_item"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified penghapusan_item.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id){
		
		if(Module::hasAccess("Penghapusan_items", "edit")) {			
			$Ajuan_penghapusanpb = Ajuan_penghapusanpb::find($id);
			//$Penghapusan_item = Penghapusan_item::find($id);
			if(isset($Ajuan_penghapusanpb->id)) {	
				$module = Module::get('Penghapusan_items');
				
				$module->row = $Ajuan_penghapusanpb;
				//$module->row = $Penghapusan_item;
				
				return view('la.penghapusan_items.edit', [
					'module' => $module,
					'view_col' => $this->view_col
				])->with('Ajuan_penghapusanpb', $Ajuan_penghapusanpb);
				//])->with('Penghapusan_item', $Penghapusan_item);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("penghapusan_item"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified penghapusan_item in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Penghapusan_items", "edit")) {
			
			$rules = Module::validateRules("Penghapusan_items", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Penghapusan_items", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.penghapusan_items.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified penghapusan_item from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Penghapusan_items", "delete")) {
			Penghapusan_item::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.penghapusan_items.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax(Request $request){
		if(Module::hasAccess("Penghapusan_items", "view")) {
			$kdbidang = Module::kdopd()->kd_bidang;
				/* $kdunit = Module::kdopd()->kd_unit;
				$kdsub = Module::kdopd()->kd_sub;
				$kdupb = Module::kdopd()->kd_upb; */
			/* $data = Module::getdataphppbadminitems()->get();
			dd($data); */
			if ($request->ajax()) {
					$output = '';
					$query = $request->get('query');
					if ($query != '') {							
							$data = Module::getdataphppbadminitemsquery($query)
								->take(1)
								->get();
							//dd($data);
								
					} else {						
							$data = Module::getdataphppbadminitems()
								->get();
							//dd($data);
					}
					
					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index=>$row){
						    $index = $index+1;
						   if(Module::hasAccess("Penghapusan_items", "edit")){
							$output .= '
							<tr>
							 <td>'.$index.'</td>
							 <td>'.$row -> deptname.'</td>
							 <td><a href="'.url(config('laraadmin.adminRoute') . '/penghapusan_items/item_ajuan/'.$row->id).'">'.$row->no_ajuan.'</a></td>							 
							 <td>'.date('d-m-Y', strtotime($row->tgl_ajuan)).'</td>
							 <td>'.$row->jenis_ajuan.'</td>
							  <td><a href="'.url('storage' . '/php_pb/file/'.$row->filepdf).'" target = "_blank">'.$row->no_surat_pb.'</a></td>	
							<td>'.date('d-m-Y', strtotime($row->tgl_surat)).'</td>	
							<td><a href="'.url('storage' . '/php_ppb/file/'.$row->filepdf2).'" target = "_blank">'.$row->no_surat_pbp.'</a></td>
							<td>'.date('d-m-Y', strtotime($row->tgl_surat_pbp)).'</td>	
							 <td>'.(($row->validation_aset == 0 OR $row->validation_aset == 1 OR $row->validation_aset == 2 OR $row->validation_aset == 3) ? '<i class="fa fa-check btn-primary btn-xs">Proses' : '<i class="fa fa-times btn-danger btn-xs">Ditolak').'</a></td>
							  <td>'.$row->nameaset.'</td>
							 <td>'.$row->validation_aset_at.'</td>
							 <td>'.$row->komentar.'</td>
							 <td>
							 <a href="'.url(config('laraadmin.adminRoute') . '/printphppbs/'.$row->id).'" class="btn btn-outline-info btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-print"></i></a>
							 <a href="'.url(config('laraadmin.adminRoute') . '/penghapusan_items/edit_ajuan/'.$row->id).'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>							 
							 </td>
							</tr>';
						   }else{
							   $output .= '
							<tr>
							<td>'.$index.'</td>
							 <td>'.$row -> deptname.'</td>
							  <td><a href="'.url(config('laraadmin.adminRoute') . '/penghapusan_items/item_ajuan/'.$row->id).'">'.$row->no_ajuan.'</a></td>							 
							 <td>'.date('d-m-Y', strtotime($row->tgl_ajuan)).'</td>
							 <td>'.$row->jenis_ajuan.'</td>	
							   <td><a href="'.url('storage' . '/php_pb/file/'.$row->filepdf).'" target = "_blank">'.$row->no_surat_pb.'</a></td>	
							 <td>'.date('d-m-Y', strtotime($row->tgl_surat)).'</td>
							 <td><a href="'.url('storage' . '/php_ppb/file/'.$row->filepdf2).'" target = "_blank">'.$row->no_surat_pbp.'</a></td>
							<td>'.date('d-m-Y', strtotime($row->tgl_surat_pbp)).'</td>	
							 <td>'.(($row->validation_aset == 0  OR $row->validation_aset == 1 OR $row->validation_aset == 2 OR $row->validation_aset == 3) ? '<i class="fa fa-check btn-primary btn-xs">Proses' : '<i class="fa fa-times btn-danger btn-xs">Ditolak').'</a></td>
							 <td>'.$row->nameaset.'</td>
							 <td>'.$row->validation_aset_at.'</td>
							 <td>'.$row->komentar.'</td>
							 <td>
							 <a href="'.url(config('laraadmin.adminRoute') . '/printphppbs/'.$row->id).'" class="btn btn-outline-info btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-print"></i></a>
							 Not Authorize							 
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
				return response()->json($data);
				 //echo json_encode($data);
				 //dd($data);
			}
				
		}else{
			return view('errors.404');
		}
	}
	public function dtajaxitem(Request $request){
		
		if(Module::hasAccess("Penghapusan_items", "view")) {
				
			if ($request->ajax()) {
					$output = '';
					$query = $request->get('query');
					if ($query != '') {							
							$data = Module::getadminitemsquery($query)->take(1)->get();	
							
					} else {						
							$data = Module::getadminitems()->get();
					}
					
					$total_row = count($data);
					  if($total_row > 0){						  
							/* foreach($adm as $adms){
								$outputadm = '<option value ="'.$adms->admid.'">'.$adms->no_surat.'</option>';	
							}
						$val = unset($outputadm); */	
					   foreach($data as $index=>$row){
						    $index = $index+1;
						   if(Module::hasAccess("Penghapusan_items", "edit")){
							$output .= '
							<tr>
							 <td>'.$index.'</td>							 
							 <td>'.$row->idpemda.'</td>
							 <td>'.$row->nm_aset5.'</td>
							 <td>'.$row->deptname.'</td>
							 <td>'.$row->no_ajuan.'</td>
							 <td>'.date('d-m-Y', strtotime($row->tgl_ajuan)).'</td>
							 <td>'.$row->jenis_ajuan.'</td>
							 <td>'.$row->tipeajuan.'</td>
							 <td>'.$row->no_surat_pb.'</td>
							 <td>'.date('d-m-Y', strtotime($row->tgl_surat)).'</td>
							 <td>'.$row->no_surat_pbp.'</td>
							 <td>'.date('d-m-Y', strtotime($row->tgl_surat_pbp)).'</td>
							 <td>'.(($row->validation_aset == ''  OR $row->validation_aset == 0) ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-primary btn-xs">Proses').'</a></td>
							 <td>'.$row->valasetby.'</td>
							 <td>'.$row->validation_aset_at.'</td>
							 <td>'.(($row->location == ''  OR $row->location == 0) ? '<i class="btn-warning btn-xs">OPD' : '<i class="btn-primary btn-xs">Gudang').'</a></td>
							 <td>'.$row->nosuratadmphp.'</td>
							 <td>'.$row->jenissuratadmphp.'</td>
							 <td>'.$row->tglsuratadmphp.'</td>
							 <td align = "center"><a href="'.url(config('laraadmin.adminRoute') . '/updatelocation/'.$row->iditems).'" class="btn btn-success btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-home"></i></a> </td>													 
							 <td align = "center"><a href="'.url(config('laraadmin.adminRoute') . '/updatelocationopd/'.$row->iditems).'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-home"></i></a> </td>													 
							 <td align = "center"><a href="'.url(config('laraadmin.adminRoute') . '/printgudang/'.$row->iditems).'" class="btn btn-success btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-barcode"></i></a></td>								  															  
							</tr>';
						   }else{
							   $output .= '
							<tr>
							  <td>													 
								  <div class="form-check form-check-inline">
									Not Authorize
								  </div>
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
				return response()->json($data);
				 //echo json_encode($data);
				 //dd($data);
			}
				
		}else{
			return view('errors.404');
		}
	}
	public function updatelocation($id){
		if(Module::hasAccess("Penghapusan_items", "edit")) {			
			$penghapusan_item = Penghapusan_item::find($id);
			if(isset($penghapusan_item->id)) {	
 				$module = Module::get('Penghapusan_items');				
				//$module->row = $penghapusan_item;
				$update = DB::table('Penghapusan_items')->where('id', $id)->update(['location' => 1]);
				
				return redirect(config('laraadmin.adminRoute') .'/penghapusan_items#Entry');
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("penghapusan_item"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	public function updatelocationopd($id){
		if(Module::hasAccess("Penghapusan_items", "edit")) {			
			$penghapusan_item = Penghapusan_item::find($id);
			if(isset($penghapusan_item->id)) {	
 				$module = Module::get('Penghapusan_items');				
				//$module->row = $penghapusan_item;
				$update = DB::table('Penghapusan_items')->where('id', $id)->update(['location' => 0]);
				
				return redirect(config('laraadmin.adminRoute') .'/penghapusan_items#Entry');
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("penghapusan_item"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	public function itemajuan($id){
			if(Module::hasAccess("Penghapusan_items", "view")) {
			$ajuan_penghapusanpb = Ajuan_penghapusanpb::find($id);
			$data = Module::getadminitemsid($id)->get();
			$ajnphp =
					DB::table('ajuan_penghapusanpbs as pbp')
					->leftjoin('departments as dept','dept.id','=','pbp.dept')
					->leftjoin('file_phpppbs as filephpppbs','filephpppbs.id','=','pbp.surat_persetujuan')					
					->select('pbp.id','dept.name as deptname','pbp.no_ajuan','pbp.tgl_ajuan',
					'pbp.validation_aset','pbp.validation_aset_by','pbp.validation_aset_at','filephpppbs.name as filepdf','pbp.komentar')
					->where('pbp.id','=',$id)
					->get();
			$ajnphpkey = key($ajnphp);
			$ajnphpval = $ajnphp[$ajnphpkey];
			//dd($data);
			//dd(count($ajnphpval));
				if(isset($ajuan_penghapusanpb->id)) {
					$module = Module::get('Ajuan_penghapusanpbs');
					$module->row = $ajuan_penghapusanpb;
					
					return view('la.penghapusan_items.itemajuan', [
						'module' => $module,					
						'data' => $data,
						'ajuan_penghapusanpb' => $ajuan_penghapusanpb,
						'ajnphpkey' => $ajnphpkey,
						'ajnphp' => $ajnphp,
						'ajnphpval' => $ajnphpval
					])->with('ajuan_penghapusanpbp', $ajuan_penghapusanpb);
				} else {
					return view('errors.404', [
						'record_id' => $id,
						'record_name' => ucfirst("penghapusan_item"),
					]);
				}
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	public function editajuan($id){
			if(Module::hasAccess("Penghapusan_items", "view")) {
			$ajuan_penghapusanpb = Ajuan_penghapusanpb::find($id);
			$data = Module::getadminitemsid($id)->get();
			//dd($data);
			/* left join
		image_phpppbs imgphpppbs on imgphpppbs.id = pitems.validation_img */
			$ajnphp =
					DB::table('ajuan_penghapusanpbs as pbp')
					->leftjoin('departments as dept','dept.id','=','pbp.dept')
					->leftjoin('file_phpppbs as filephpppbs','filephpppbs.id','=','pbp.surat_persetujuan')					
					->select('pbp.id','dept.name as deptname','pbp.no_ajuan','pbp.tgl_ajuan',
					'pbp.validation_aset','pbp.validation_aset_by','pbp.validation_aset_at','filephpppbs.name as filepdf')
					->where('pbp.id','=',$id)
					->get();
			$ajnphpkey = key($ajnphp);
			$ajnphpval = $ajnphp[$ajnphpkey];
			//dd(count($ajnphpval));
				if(isset($ajuan_penghapusanpb->id)) {
					$module = Module::get('Ajuan_penghapusanpbs');
					$module->row = $ajuan_penghapusanpb;
					
					return view('la.penghapusan_items.editajuan', [
						'module' => $module,					
						'data' => $data,
						'ajuan_penghapusanpb' => $ajuan_penghapusanpb,
						'ajnphpkey' => $ajnphpkey,
						'ajnphp' => $ajnphp,
						'ajnphpval' => $ajnphpval
					])->with('ajuan_penghapusanpbp', $ajuan_penghapusanpb);
				} else {
					return view('errors.404', [
						'record_id' => $id,
						'record_name' => ucfirst("penghapusan_item"),
					]);
				}
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	public function valaset(Request $request,$id){
			if(Module::hasAccess("Penghapusan_items", "edit")) {			
			$penghapusan_item = Ajuan_penghapusanpb::find($id);
			if(isset($penghapusan_item->id)) {	
 				$module = Module::get('ajuan_penghapusanpbs');				
				//$module->row = $penghapusan_item;
				$update = DB::table('ajuan_penghapusanpbs')
							->where('id', $id)
							->update(['validation_aset' => $request->valterm,
									'validation_aset_at' => date('Y-m-d H:i:s'),
									'komentar' => $request->komen
									]);
				//dd($request->komen);
				return redirect(config('laraadmin.adminRoute') .'/penghapusan_items/edit_ajuan/'.$id);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("penghapusan_item"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	public function valasetsesuai($id){
			if(Module::hasAccess("Penghapusan_items", "edit")) {			
			$penghapusan_item = Penghapusan_item::find($id);
			if(isset($penghapusan_item->id)) {	
 				$module = Module::get('penghapusan_items');				
				//$module->row = $penghapusan_item;
				$update = DB::table('penghapusan_items')->where('id', $id)->update(['validation_aset' => 1,'validation_at' => date('Y-m-d H:i:s')]);
				
				//return redirect(config('laraadmin.adminRoute') .'/penghapusan_items/edit_ajuan/'.$id);
				return back()
				->with('success','Validation Aset done.');
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("penghapusan_item"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	public function valasettidak($id){
			if(Module::hasAccess("Penghapusan_items", "edit")) {			
			$penghapusan_item = Penghapusan_item::find($id);
			if(isset($penghapusan_item->id)) {	
 				$module = Module::get('penghapusan_items');				
				//$module->row = $penghapusan_item;
				$update = DB::table('penghapusan_items')->where('id', $id)->update(['validation_aset' => 0,'validation_at' => date('Y-m-d H:i:s')]);
				
				return back()
				->with('success','Validation Aset done.');
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("penghapusan_item"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	public function valasetalasan(Request $request,$id){
			if(Module::hasAccess("Penghapusan_items", "edit")) {			
			$penghapusan_item = Penghapusan_item::find($id);
			if(isset($penghapusan_item->id)) {	
 				$module = Module::get('penghapusan_items');				
				$update = DB::table('penghapusan_items')->where('id', $id)->update(['alasan' => $request->alasan]);
				
				return back()
				->with('success','Validation Aset done.');
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("penghapusan_item"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	public function valtimpenilai(Request $request,$id){
			if(Module::hasAccess("Penghapusan_items", "edit")) {			
			$penghapusan_item = Ajuan_penghapusanpb::find($id);
			if(isset($penghapusan_item->id)) {	
 				$module = Module::get('ajuan_penghapusanpbs');				
				//$module->row = $penghapusan_item;
				$rekompenilai = 
				$update = DB::table('ajuan_penghapusanpbs')->where('id', $id)->update(['validation_aset' => 3,'rekom_jenis_ajuan' => $request->rekom_jenis_ajuan]);
				
				return redirect(config('laraadmin.adminRoute') .'/penghapusan_items/edit_ajuan/'.$id);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("penghapusan_item"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	public function update_adm(Request $request,$id){
			$fileid = Penghapusan_item::findOrFail($id);
			$fileid->adm_php_id = $request->idm;		
			$fileid->save();
			
			return back()
            ->with('success','Nomor Surat telah diisi.')
            ->with('file', $fileid->no_surat);
	}
}
