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

use App\Models\Persediaan_instock;

class Persediaan_instocksController extends Controller
{
	public $show_action = true;
	public $view_col = 'ref_persediaan';
	public $listing_cols = ['id', 'ref_persediaan', 'ref_brg', 'kd_bidang', 'kd_unit', 'kd_sub', 'kd_upb', 'jml_instock', 'tgl_instock', 'tahun_instock'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Persediaan_instocks', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Persediaan_instocks', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Persediaan_instocks.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		$module = Module::get('Persediaan_instocks');
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
			return View('la.persediaan_instocks.index', [
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
	public function barang(Request $request,$isi){			
		/* $data = Module::brg_persediaan($id)->get();	
		dd($data); */
		
		if ($request->ajax()) {
					$output = '';
					$query = $request->get('query');
					if ($query != '') {
						$data = Module::brg_persediaan($query)->take(5)->get();
					} else {					
						$data = Module::brg_persediaan($isi)->get();							
					}
					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index=> $row){
						   $index = $index+1;
						   if(Module::hasAccess("Persediaan_instocks", "edit")){
							$output .= '
							<tr id = "'.$row->id.'">
							 <td>'.$index.'</td>
							 <td> 
								<button type="button" class = "btn btn-info" id= "'.$row->id.'" onclick = "pilihbarang(this.id)">
								PILIH
								</button>
							 </td>							
							 <td id = "barangz">'.$row->nama_barang.'</td>
							 <td id = "uraianz">'.$row->uraian_barang.'</td>						 
							 <td id = "satuanz">'.$row->satuan.'</td>						 
							 <td id = "typez">'.$row->type.'</td>
							</tr>';
						   }else{
							   $output .= '
							<tr id ="'.$row->id.'" name = "pilihanbarang">
							 <td>'.$index.'</td>
							 <td> 
								<button type="button" class = "btn btn-info" id= "'.$row->id.'" onclick = "pilihbarang(this.id)">
								PILIH
								</button>
							 </td>	
							 <td id = "barangz">'.$row->nama_barang.'</td>
							 <td id = "uraianz">'.$row->uraian_barang.'</td>						 
							 <td id = "satuanz">'.$row->satuan.'</td>						 
							 <td id = "typez">'.$row->type.'</td>
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
		
	}
	/**
	 * Show the form for creating a new persediaan_instock.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created persediaan_instock in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request){
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$kdsub = Module::kdopd()->kd_sub;
		
		if(Module::hasAccess("Persediaan_instocks", "create")) {
			
			$tglinstock= str_replace('/', '-', $request->tgl_instock);
			//$thninstock= strtr(date('Y', strtotime($request->tgl_instock)));
			 
			$instock = new Persediaan_instock;
			$instock->kd_bidang = $kdbidang;
			$instock->kd_unit = $kdunit;
			$instock->kd_sub = $kdsub;
			$instock->kd_upb = $request->upbuser;
			$instock->ref_persediaan = $request->persediaans;
			$instock->ref_brg = $request->dipilih;
			$instock->tgl_instock = date('Y-m-d', strtotime($tglinstock));
			$instock->tahun_instock = date('Y', strtotime($tglinstock));
			$instock->jml_instock = $request->jml_instock;
			$instock->harga = $request->harga;
			$instock->save();			
					
			return back()
            ->with('success','Success');
					
		} else {
			return back()->withErrors(['Update Error' => ['Silahkan ulangi']]);
			//return redirect(config('laraadmin.adminRoute')."/");
		}
		
		
	}

	/**
	 * Display the specified persediaan_instock.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Persediaan_instocks", "view")) {
			
			$persediaan_instock = Persediaan_instock::find($id);
			if(isset($persediaan_instock->id)) {
				$module = Module::get('Persediaan_instocks');
				$module->row = $persediaan_instock;
				
				return view('la.persediaan_instocks.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('persediaan_instock', $persediaan_instock);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("persediaan_instock"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified persediaan_instock.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id){
		if(Module::hasAccess("Persediaan_instocks", "edit")) {			
			$persediaan_instock = Persediaan_instock::find($id);
			if(isset($persediaan_instock->id)) {	
				$module = Module::get('Persediaan_instocks');
				
				$module->row = $persediaan_instock;
				
				return view('la.persediaan_instocks.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('persediaan_instock', $persediaan_instock);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("persediaan_instock"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	

	/**
	 * Update the specified persediaan_instock in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id){
		if(Module::hasAccess("Persediaan_instocks", "edit")) {
			
			$rules = Module::validateRules("Persediaan_instocks", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Persediaan_instocks", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.persediaan_instocks.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
public function updateitempersediaan(Request $request){
	$kdbidang = Module::kdopd()->kd_bidang;
	$kdunit = Module::kdopd()->kd_unit;
	$kdsub = Module::kdopd()->kd_sub;
	
		if($request){
			$dipilih = (int)$request->dipilihs;
			$iditem = (int)$request->iditem; 
			$tglinstock = str_replace('/', '-', $request->tgl_instock);
			$data = "update persediaan_instocks 
					set ref_persediaan = ".$request->persediaansedit.",
						ref_brg = ".$dipilih.",
						kd_upb = ".$request->upbuser.",
						jml_instock = ".$request->jumlahs.",tgl_instock = '".date('Y-m-d', strtotime($tglinstock))."',
						tahun_instock = '".date('Y', strtotime($tglinstock))."',
						harga = ".$request->hargas."							
					where id = ".$iditem." ";
	
			DB::statement($data);
			return back()->with('success','update berhasil');			
		}		
   }
   
   public function updateitempersediaans(Request $request,$id){
	$kdbidang = Module::kdopd()->kd_bidang;
	$kdunit = Module::kdopd()->kd_unit;
	$kdsub = Module::kdopd()->kd_sub;
	$dipilih = (int)$request->dipilihs;
	$iditem = (int)$request->iditem; 
	$tglinstock = str_replace('/', '-', $request->tgl_instock);
	
			$fileid = Persediaan_instock::find($id);
			$fileid->ref_persediaan = $request->persediaansedit;
			$fileid->ref_brg = $dipilih;
			$fileid->kd_upb = $request->upbuser;
			$fileid->jml_instock = $request->jumlahs;
			$fileid->tgl_instock = date('Y-m-d', strtotime($tglinstock));
			$fileid->tahun_instock = date('Y', strtotime($tglinstock));
			$fileid->harga = $request->hargas;
			$fileid->save();
			return back()->with('success','Update Berhasil.');			
   }
   
   public function delitempersediaans($id){
		$data = "delete from persediaan_instocks where id = ".$id." ";
	
			DB::statement($data);
			return back()->with('success','Delete berhasil');			
   }

	/**
	 * Remove the specified persediaan_instock from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Persediaan_instocks", "delete")) {
			Persediaan_instock::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.persediaan_instocks.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	public function loadinstock(Request $request,$kdbidangs,$kdunits,$kdsubs,$kdupbs,$tahun){
	if(Module::hasAccess("Persediaan_instocks", "view")) {
				$kdbidang = Module::kdopd()->kd_bidang;
				
				//$data = Module::brginstock($kdbidangs,$kdunits,$kdsubs,$kdupbs,$tahun)->get();
				//dd($data);
			if ($request->ajax()) {
					$output = '';
					$query = $request->get('query');
					if ($query != '') {
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::brginstockquery($kdbidangs,$kdunits,$kdsubs,$kdupbs,$tahun,$query)->get();
						}else{
							$data = Module::brginstockquery($kdbidang,$kdunit,$kdsub,$kdupb,$tahun,$query)->get();	
						}
					} else {
						if($kdbidang == 99 || $kdbidang == 0 ){							
							$data = Module::brginstock($kdbidangs,$kdunits,$kdsubs,$kdupbs,$tahun)->get();	
							
						}else{
							$kdunit = Module::kdopd()->kd_unit;
							$kdsub = Module::kdopd()->kd_sub;
							$kdupb = Module::kdopd()->kd_upb;
							$data = Module::brginstock($kdbidang,$kdunit,$kdsub,$kdupbs,$tahun)->get();
						}
					}
					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index=> $row){
						   $index = $index+1;
						   if(Module::hasAccess("Persediaan_instocks", "edit")){
							$output .= '
							<tr id = "'.$row->id.'" name = "pilihanbarang">
							 <td>'.$index.'</td>
							 <td>'.date('Y', strtotime($row->tgl_instock)).'</td>									 						 					 
							 <td id = "tglinstockx">'.date('d-m-Y', strtotime($row->tgl_instock)).'</td>
							 <td>'.$row->jenis_persediaan.'</td>
							 <td id = "idbrgx">'.$row->idbrg.'</td>						 
							 <td id = "barangx">'.$row->nama_barang.'</td>						 
							 <td id = "uraianx">'.$row->uraian_barang.'</td>						 
							 <td id = "typex">'.$row->type.'</td>
							 <td id = "satuanx">'.$row->satuan.'</td>
							 <td id = "jumlahx">'.$row->jml_instock.'</td>
							 <td id = "hargax">'.$row->harga.'</td>
							 <td>
							
							<button id = "getidbutton" value = '.$row->id.' class="btn btn-warning" data-toggle="modal"  onclick = "getInputValue(this);" >Edit</button>									
							<a href="'.url(config('laraadmin.adminRoute') . '/delitempersediaans/'.$row->id).'"><button class="btn btn-danger">Delete</button>									
							 <td>
							</tr>';
						   }else{
							   $output .= '
							<tr>
							 <td>'.$index.'</td>
							 <td>'.date('Y', strtotime($row->tgl_instock)).'</td>									 						 					 
							 <td>'.date('d-m-Y', strtotime($row->tgl_instock)).'</td>
							 <td>'.$row->jenis_persediaan.'</td>
							 <td>'.$row->idbrg.'</td>
							 <td>'.$row->nama_barang.'</td>						 
							 <td>'.$row->uraian_barang.'</td>						 
							 <td>'.$row->type.'</td>
							 <td>'.$row->satuan.'</td>
							 <td>'.$row->jml_instock.'</td>
							 <td>'.$row->harga.'</td>
							 <td>
							 <button id = "getidbutton" class="btn btn-warning">Not Authorize</button>							 						 							 
							 <td>
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
	
	public function rekapinstock(Request $request,$kdbidangs,$kdunits,$kdsubs,$kdupbs,$tglawal,$tglakhir){
	if(Module::hasAccess("Persediaan_instocks", "view")) {
				$kdbidang = Module::kdopd()->kd_bidang;
				
				//$data = Module::rekapinstock($kdbidangs,$kdunits,$kdsubs,$kdupbs,$tglawal,$tglakhir)->get();
				//dd($data);
				
			if ($request->ajax()) {
					$output = '';
					$query = $request->get('query');
					if ($query != '') {
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::rekapinstockquery($kdbidangs,$kdunits,$kdsubs,$kdupbs,$tglawal,$tglakhir,$query)->get();
						}else{
							$data = Module::rekapinstockquery($kdbidangs,$kdunits,$kdsubs,$kdupbs,$tglawal,$tglakhir,$query)->get();	
						}
					} else {
						if($kdbidang == 99 || $kdbidang == 0 ){							
							$data = Module::rekapinstock($kdbidangs,$kdunits,$kdsubs,$kdupbs,$tglawal,$tglakhir)->get();	
							
						}else{
							/* $kdunit = Module::kdopd()->kd_unit;
							$kdsub = Module::kdopd()->kd_sub;
							$kdupb = Module::kdopd()->kd_upb; */
							$data = Module::rekapinstock($kdbidangs,$kdunits,$kdsubs,$kdupbs,$tglawal,$tglakhir)->get();
						}
					}
					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index=> $row){
						   $index = $index+1;
						   if(Module::hasAccess("Persediaan_instocks", "edit")){
							$output .= '
							<tr  name = "pilihanbarang">
							 <td>'.$index.'</td>
							 <td>'.$row->jenis_persediaan.'</td>					 
							 <td id = "barangx">'.$row->nama_barang.'</td>						 
							 <td id = "uraianx">'.$row->uraian_barang.'</td>						 
							 <td id = "typex">'.$row->type.'</td>
							 <td id = "satuanx">'.$row->satuan.'</td>
							 <td id = "jumlahx">'.$row->jmlinstock.'</td>
							 <td id = "hargax">'.$row->hrginstock.'</td>
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
							 <td id = "hargax">'.$row->hrginstock.'</td>
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
