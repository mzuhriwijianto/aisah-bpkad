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

use App\Models\Ajuan_penghapusanpbp;
use App\Models\Image_phpppb;
use App\Models\File_phpppb;
use App\Models\Penghapusan_item;
use PDF;

class Ajuan_penghapusanpbpsController extends Controller
{
	public $show_action = true;
	public $view_col = 'no_ajuan';
	public $listing_cols = ['id', 'no_ajuan', 'opd', 'dept', 'tgl_ajuan', 'validation_pb', 'validation_pb_by', 'validation_pb_at', 'surat_persetujuan', 'kd_bidang', 'kd_unit', 'kd_sub'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Ajuan_penghapusanpbps', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Ajuan_penghapusanpbps', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Ajuan_penghapusanpbps.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		$module = Module::get('Ajuan_penghapusanpbps');
		//$cek= Module::getdataphppbpadmin()->get();
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$kdsub = Module::kdopd()->kd_sub;
		$kdupb = Module::kdopd()->kd_upb;
		$refrek0 = Module::populaterefbrg0()->get();
		//dd($kdbidang,$kdunit,$kdsub,$refrek0);

		if(Module::hasAccess($module->id)) {
			return View('la.ajuan_penghapusanpbps.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module,
				'refrek0' => $refrek0
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}
/* print */
	public function printlampiranphp($id){
		$ajuan_penghapusanpbp = Ajuan_penghapusanpbp::find($id);
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$kdsub = Module::kdopd()->kd_sub;
		$kdupb = Module::kdopd()->kd_upb;
			/* $data_b = Module::selectbrg_pm($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
			dd($data_b); */
		if(Module::hasAccess("Ajuan_penghapusanpbps", "view")) {		
					$data_a = Module::selectbrg_tanah($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
					$data_a_sum = Module::selectbrg_tanah_sum($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
					$data_b = Module::selectbrg_pm($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
					$data_b_sum = Module::selectbrg_pm_sum($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
					$data_c = Module::selectbrg_gb($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
					$data_c_sum = Module::selectbrg_gb_sum($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
					$data_d = Module::selectbrg_jj($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
					$data_d_sum = Module::selectbrg_jj_sum($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
					$data_e = Module::selectbrg_atl($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
					$data_e_sum = Module::selectbrg_atl_sum($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
					$data_f = Module::selectbrg_kdp($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);	
					$ajnphp =
							DB::table('ajuan_penghapusanpbps as pbp')
							->leftjoin('departments as dept','dept.id','=','pbp.dept')
							->leftjoin('file_phpppbs as filephpppbs','filephpppbs.id','=','pbp.surat_persetujuan')
							->select('pbp.id','dept.name as deptname','pbp.no_ajuan','pbp.tgl_ajuan','pbp.no_surat','pbp.tgl_surat','pbp.jenis_ajuan',
							'pbp.validation_pb','pbp.validation_pb_by','pbp.validation_pb_at','pbp.validation_pb_at',
							'pbp.validation_aset','pbp.validation_aset_by','pbp.validation_aset_at','filephpppbs.name as filepdf',
							'pbp.jbt_pimpinan','pbp.nip_pimpinan','pbp.nm_pimpinan')
					->where('pbp.id','=',$id)->get();
					
					$data_a_array = json_decode(json_encode($data_a), true);
					$data_a_sum_array = json_decode(json_encode($data_a_sum), true);
					$data_b_array = json_decode(json_encode($data_b), true);
					$data_b_sum_array = json_decode(json_encode($data_b_sum), true);
					$data_c_array = json_decode(json_encode($data_c), true);
					$data_c_sum_array = json_decode(json_encode($data_c_sum), true);
					$data_d_array = json_decode(json_encode($data_d), true);
					$data_d_sum_array = json_decode(json_encode($data_d_sum), true);
					$data_e_array = json_decode(json_encode($data_e), true);
					$data_e_sum_array = json_decode(json_encode($data_e_sum), true);
					$data_f_array = json_decode(json_encode($data_f), true);

				    $pdf = new PDF;
					$pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
							->loadView('la.report.printlampiranphppbs',
										[
										'data_a' => $data_a,
										'data_a_sum' => $data_a_sum,
										'data_b' => $data_b,
										'data_b_sum' => $data_b_sum,
										'data_c' => $data_c,
										'data_c_sum' => $data_c_sum,
										'data_d' => $data_d,
										'data_d_sum' => $data_d_sum,
										'data_e' => $data_e,
										'data_e_sum' => $data_e_sum,
										'data_f' => $data_f,
										'ajnphp' => $ajnphp
										])
							->setPaper('folio', 'landscape');
					
					return $pdf->stream('Lampiran_penghapusan_'.Module::userlogin()->dept_name.'.pdf');	
					//dd($data_b_array);
					/* return view('la.report.printlampiranphppbs',[
										'data_a' => $data_a,
										'data_a_sum' => $data_a_sum,
										'data_b' => $data_b,
										'data_b_sum' => $data_b_sum,
										'data_c' => $data_c,
										'data_c_sum' => $data_c_sum,
										'data_d' => $data_d,
										'data_d_sum' => $data_d_sum,
										'data_e' => $data_e,
										'data_e_sum' => $data_e_sum,
										'data_f' => $data_f,
										'ajnphp' => $ajnphp
										]); */
		}else{
			return view(abort(403, 'Unauthorized action.'));
		}		 
	}
	/* end */
	/**
	 * Show the form for creating a new ajuan_penghapusanpbp.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created ajuan_penghapusanpbp in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request){
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$kdsub = Module::kdopd()->kd_sub;
		$kddept = Module::kddept()->id;
		
		if(Module::hasAccess("Ajuan_penghapusanpbps", "create")) {
			
			//$tglajuan = strtr(date('Y-m-d'));
			 
			$pengajuan = new Ajuan_penghapusanpbp;
			$pengajuan->kd_bidang = $kdbidang;
			$pengajuan->kd_unit = $kdunit;
			$pengajuan->kd_sub = $kdsub;
			$pengajuan->dept = $kddept;
			$pengajuan->tgl_ajuan = date('Y-m-d');
			$pengajuan->jenis_ajuan = $request->jenis_ajuan;
			$pengajuan->save();
			
			//$insert_id = Module::insert("Ajuan_penghapusanpbps", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.ajuan_penghapusanpbps.index');
			
		} else {
			return back()->withErrors(['Jenis Ajuan' => ['Silahkan isi jenis ajuan']]);
			//return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified ajuan_penghapusanpbp.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id){
	
		if(Module::hasAccess("Ajuan_penghapusanpbps", "view")) {			
			$ajuan_penghapusanpbp = Ajuan_penghapusanpbp::find($id);
			$kdbidang = $ajuan_penghapusanpbp->kd_bidang;
			$kdunit = $ajuan_penghapusanpbp->kd_unit;
			$kdsub = $ajuan_penghapusanpbp->kd_sub;
			$kdupb = Module::kdopd()->kd_upb;
				
				$data_a = Module::selectbrg_tanah($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
				$data_a_sum = Module::selectbrg_tanah_sum($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
				$data_b = Module::selectbrg_pm($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
				$data_b_sum = Module::selectbrg_pm_sum($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
				$data_c = Module::selectbrg_gb($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
				$data_c_sum = Module::selectbrg_gb_sum($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
				$data_d = Module::selectbrg_jj($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
				$data_d_sum = Module::selectbrg_jj_sum($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
				$data_e = Module::selectbrg_atl($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
				$data_e_sum = Module::selectbrg_atl_sum($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
				$data_f = Module::selectbrg_kdp($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);	
				
			$ajnphp =
				DB::table('ajuan_penghapusanpbps as pbp')
				->leftjoin('departments as dept','dept.id','=','pbp.dept')
				->leftjoin('file_phpppbs as filephpppbs','filephpppbs.id','=','pbp.surat_persetujuan')
				->select('pbp.id','dept.name as deptname','pbp.no_ajuan','pbp.tgl_ajuan',
				'pbp.validation_pb','pbp.validation_pb_by','pbp.validation_pb_at','pbp.validation_pb_at',
				'pbp.validation_aset','pbp.validation_aset_by','pbp.validation_aset_at','filephpppbs.name as filepdf',
				'pbp.jbt_pimpinan','pbp.nip_pimpinan','pbp.nm_pimpinan')
				->where('pbp.id','=',$ajuan_penghapusanpbp->id)
				->get();
			//dd($ajnphp);	
			if(isset($ajuan_penghapusanpbp->id)) {
				$module = Module::get('Ajuan_penghapusanpbps');
				$module->row = $ajuan_penghapusanpbp;
				
				return view('la.ajuan_penghapusanpbps.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding",
					'kdbidang' => $kdbidang,
					'kdunit' => $kdunit,
				    'kdsub' => $kdsub,
				    'kdupb' => $kdupb,
					'data_a' => $data_a,
					'data_b' => $data_b,
					'data_c' => $data_c,
					'data_d' => $data_d,
					'data_e' => $data_e,
					'data_f' => $data_f,
					'data_a_sum' => $data_a_sum,
					'data_b_sum' => $data_b_sum,
					'data_c_sum' => $data_c_sum,
					'data_d_sum' => $data_d_sum,
					'data_e_sum' => $data_e_sum,
					'ajnphp' => $ajnphp
				])->with('ajuan_penghapusanpbp', $ajuan_penghapusanpbp);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("ajuan_penghapusanpbp"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	

	/**
	 * Show the form for editing the specified ajuan_penghapusanpbp.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id){
		if(Module::hasAccess("Ajuan_penghapusanpbps", "edit")) {			
			$ajuan_penghapusanpbp = Ajuan_penghapusanpbp::find($id);
			$ajnphp =
				DB::table('ajuan_penghapusanpbps as pbp')
				->leftjoin('departments as dept','dept.id','=','pbp.dept')
				->leftjoin('file_phpppbs as filephpppbs','filephpppbs.id','=','pbp.surat_persetujuan')
				->select('pbp.id','dept.name as deptname','pbp.no_ajuan','pbp.tgl_ajuan',
				'pbp.validation_pb','pbp.validation_pb_by','pbp.validation_pb_at','pbp.validation_pb_at',
				'pbp.validation_aset','pbp.validation_aset_by','pbp.validation_aset_at','filephpppbs.name as filepdf')
				->where('pbp.id','=',$ajuan_penghapusanpbp->id)
				->get();
			$kond = Module::populaterefkondisi()->get();	
			$refrek0 = Module::populaterefbrg0()->get();
			$kdbidang = Module::kdopd()->kd_bidang;
			$kdunit = Module::kdopd()->kd_unit;
			$kdsub = Module::kdopd()->kd_sub;
			$kdupb = Module::kdopd()->kd_upb;
			/* $data = Module::showbrgpb(7,1,5,1,$ids,$idss)
					->get(); */
			//dd($data);
			
			if(isset($ajuan_penghapusanpbp->id)) {	
				$module = Module::get('Ajuan_penghapusanpbps');				
				$module->row = $ajuan_penghapusanpbp;
				
				$data_a = Module::selectbrg_tanah($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
				$data_a_sum = Module::selectbrg_tanah_sum($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
				$data_b = Module::selectbrg_pm($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
				$data_b_sum = Module::selectbrg_pm_sum($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
				$data_c = Module::selectbrg_gb($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
				$data_c_sum = Module::selectbrg_gb_sum($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
				$data_d = Module::selectbrg_jj($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
				$data_d_sum = Module::selectbrg_jj_sum($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
				$data_e = Module::selectbrg_atl($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
				$data_e_sum = Module::selectbrg_atl_sum($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
				$data_f = Module::selectbrg_kdp($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
				//$data_f_sum = Module::selectbrg_kdp_sum($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
				
				return view('la.ajuan_penghapusanpbps.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
					'refrek0' => $refrek0,
					'kond' => $kond,
					'kdbidang' => $kdbidang,
					'kdunit' => $kdunit,
				    'kdsub' => $kdsub,
				    'kdupb' => $kdupb,
					'data_a' => $data_a,
					'data_a_sum' => $data_a_sum,
					'data_b_sum' => $data_b_sum,
					'data_c_sum' => $data_c_sum,
					'data_d_sum' => $data_d_sum,
					'data_e_sum' => $data_e_sum,
					//'data_f_sum' => $data_f_sum,
					'data_b' => $data_b,
					'data_c' => $data_c,
					'data_d' => $data_d,
					'data_e' => $data_e,
					'data_f' => $data_f,
					'ajnphp' => $ajnphp
				])->with('ajuan_penghapusanpbp', $ajuan_penghapusanpbp);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("ajuan_penghapusanpbp"),
					
					
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	public function rekening1($ids){
		$rek1 = Module::populaterefbrg1($ids)->pluck('nm_aset1', 'kd_aset1');
		return json_encode($rek1);
	}
	public function rekening2($ids,$idss){
		$rek2 = Module::populaterefbrg2($ids,$idss)->pluck('nm_aset2', 'kd_aset2');
		return json_encode($rek2);
	}
	public function rekening3($ids,$idss,$ids3){
		$rek3 = Module::populaterefbrg3($ids,$idss,$ids3)->pluck('nm_aset3', 'kd_aset3');
		return json_encode($rek3);
	}
	public function rekening4($ids,$idss,$ids3,$ids4){
		$rek4 = Module::populaterefbrg4($ids,$idss,$ids3,$ids4)->pluck('nm_aset4', 'kd_aset4');
		return json_encode($rek4);
	}
	public function kondisi(){
		$kond = Module::populaterefkondisi()->pluck('kd_kondisi', 'uraian');
		return json_encode($kond);
	}
	public function showbarang(Request $request,$id,$ids,$idss,$ids3,$ids4,$kond){

		$ajuan_penghapusanpbp = Ajuan_penghapusanpbp::find($id);
		//dd($ajuan_penghapusanpbp->id);
		$kdbidang = $ajuan_penghapusanpbp->kd_bidang;
		$kdunit = $ajuan_penghapusanpbp->kd_unit;
		$kdsub = $ajuan_penghapusanpbp->kd_sub;
		$kdupb = Module::kdopd()->kd_upb;
		//$data = Module::showbrgpbp($kdbidang,$kdunit,$kdsub,$kdupb,$id,$ids,$idss,$ids3,$ids4,$kond)->get();
		//$data = Module::showbrgpb($kdbidang,$kdunit,$kdsub,$kdupb,$ids,$idss,$ids3,$ids4,$kond);
		//dd($kdbidang,$kdunit,$kdsub,$kdupb,$id,$ids,$idss,$ids3,$ids4,$kond);
		//dd($id,$ids,$idss,$ids3,$ids4,$kond);
		//dd($data)
		if(Module::hasAccess("Ajuan_penghapusanpbps", "view")) {
			$kdbidang = $ajuan_penghapusanpbp->kd_bidang;
			$kdunit = $ajuan_penghapusanpbp->kd_unit;
			$kdsub = $ajuan_penghapusanpbp->kd_sub;
			$kdupb = Module::kdopd()->kd_upb;
			$idrek0  = (int)$ids;
			$idrek1  = (int)$idss;
			$idrek3  = (int)$ids3;
			$idrek4  = (int)$ids4;
			/* $query = $request->get('query');*/
			
			if ($request->ajax()) {
					//dd('0');				
					$output = '';
					$query = $request->get('query');
					if ($query != '') {							
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::showbrgpbadminquery($idrek0,$idrek1,$idrek3,$idrek4,$kond,$query);							
							//dd('1');							
						}else{
							$data = Module::showbrgpbpquery($kdbidang,$kdunit,$kdsub,$kdupb,$idrek0,$idrek1,$idrek3,$idrek4,$kond,$query);
							//dd('2');	
						}
					} else {						
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::showbrgpbadmin($idrek0,$idrek1,$idrek3,$idrek4,$kond);	
							//dd('3');	
							//dd($idrek0,$idrek1);
						}else{
							$data = Module::showbrgpbp($kdbidang,$kdunit,$kdsub,$kdupb,$idrek0,$idrek1,$idrek3,$idrek4,$kond);
							//dd('4');			
						}	
					}
					
					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index=>$row){
						    $index = $index+1;
						   if(Module::hasAccess("Ajuan_penghapusanpbps", "edit")){
							$output .= '
							<tr>
							 <td>'.$index.'</td>
							 <div class="form-check form-check-inline">
							   <td>
							   <button id = "'.$row->idpemda.'" 
							   href="'.url(config('laraadmin.adminRoute') . '/addbrgpbp/'.$ajuan_penghapusanpbp->id.'/'.$row->idpemda).'" 
							   class="btn btn-primary" type="button" onclick = "getidpemda(this.id)" 
							   value = "'.$row->idpemda.'" enabled>Add</button>
								</td>						   
							   </td>								
							  </div>
							  <td>'.$row -> dept.'</td>
							 <td>'.$row -> Uraian.'</td>							 
							 <td>'.$row -> Uraian_akhir.'</td>							 
							 <td>'.date('d-m-Y', strtotime($row->tgl_perolehan)).'</td>
							 <td>'.$row -> no_register.'</td>
							 <td>'.$row -> harga.'</td>
							 <td>'.$row -> nomor_polisi.'</td>
							 <td>'.$row -> merk.'</td>
							 <td>'.$row -> type.'</td>
							 <td>'.$row -> luas.'</td>
							 <td>'.$row -> Luas_Lantai.'</td>
							 <td>'.$row -> Konstruksi.'</td>
							 <td>'.$row -> lokasi.'</td>
							 <td>'.$row -> Judul.'</td>
							 <td>'.$row -> Keterangan.'</td>
							 
							</tr>';
						   }else{
							   $output .= '
							<tr>
							  <td>'.$row -> dept.'</td>
							 <td>'.$row -> Uraian.'</td>							 
							 <td>'.$row -> Uraian_akhir.'</td>							 
							 <td>'.date('d-m-Y', strtotime($row->tgl_pembukuan)).'</td>
							 <td>'.$row -> no_register.'</td>
							 <td>'.$row -> harga.'</td>
							 <td>'.$row -> nomor_polisi.'</td>
							 <td>'.$row -> merk.'</td>
							 <td>'.$row -> type.'</td>
							 <td>'.$row -> luas.'</td>
							 <td>'.$row -> Luas_Lantai.'</td>
							 <td>'.$row -> Konstruksi.'</td>
							 <td>'.$row -> lokasi.'</td>
							 <td>'.$row -> Judul.'</td>
							 <td>'.$row -> Keterangan.'</td>
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
				echo json_encode($data);
			}
		}else{
			return view('errors.404');
		}
	}
	
	public function addbrg(Request $request,$noajuan,$idpemda,$id0,$ids,$idss,$ids3,$ids4){
		//dd($noajuan,$idpemda);
		$data = Module::insertbrg($noajuan,$idpemda,$id0,$ids,$idss,$ids3,$ids4);
		return json_encode($data);
		
	}
	public function delbrg(Request $request,$id){
		$data = Module::delbrg($id);
		return json_encode($data);
	}

	/**
	 * Update the specified ajuan_penghapusanpbp in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id){
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$kdsub = Module::kdopd()->kd_sub;
		if(Module::hasAccess("Ajuan_penghapusanpbps", "edit")) {
			
			$rules = Module::validateRules("Ajuan_penghapusanpbps", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Ajuan_penghapusanpbps", $request, $id);
			$update = Ajuan_penghapusanpbps::find($id);
			$update->kd_bidang 	= $kdbidang;			
			$update->kd_unit 	= $kdunit;
			$update->kd_sub 	= $kdsub;
			$update->save();
			
			return redirect()->route(config('laraadmin.adminRoute') . '.ajuan_penghapusanpbps#lists');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified ajuan_penghapusanpbp from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Ajuan_penghapusanpbps", "delete")) {
			Ajuan_penghapusanpbp::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.ajuan_penghapusanpbps.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
		
	public function dtajax(Request $request){
		if(Module::hasAccess("Ajuan_penghapusanpbps", "view")) {
				$kdbidang = Module::kdopd()->kd_bidang;
				//$data = Module::getdataphppbpadmin()->get();
				//dd($data);
			if ($request->ajax()) {
					$output = '';
					$query = $request->get('query');
					if ($query != '') {							
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::getdataphppbpadminquery($query)
									->take(20)
									->get();
								
						}else{
							$data = Module::getdataphppbpuserquery($query)
								->take(1)
								->get();	
						}
					} else {						
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::getdataphppbpadmin()->get();
							//dd($data);
						}else{
							$data = Module::getdataphppbpuser()->get();							
						}	
					}
					
					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index=>$row){
						    $index = $index+1;
						   if(Module::hasAccess("Ajuan_penghapusanpbps", "edit")){
							$output .= '
							<tr>
							 <td>'.$index.'</td>
							 <td>'.$row -> deptname.'</td>
							 <td><a href="'.url(config('laraadmin.adminRoute') . '/ajuan_penghapusanpbps/'.$row->id).'">'.$row->no_ajuan.'</a></td>							 
							 <td>'.date('d-m-Y', strtotime($row->tgl_ajuan)).'</td>
							 <td>'.$row->jenis_ajuan.'</td>
							 <td><a href="'.url('storage' . '/php_ppb/file/'.$row->filepdf).'" target = "_blank">'.$row->no_surat.'</a></td>	
							 <td>'.(($row->validation_pb == ''  OR $row->validation_pb == 0 OR $row->validation_pb == 1 OR $row->validation_pb == 2 OR $row->validation_pb == 3) ? '<i class="fa fa-check btn-primary btn-xs">Proses' : '<i class="fa fa-times btn-danger btn-xs"> Ditolak').'</a></td>
							 <td>'.$row->namepb.'</td>
							 <td>'.$row->validation_pb_at.'</td>
							 <td>'.(($row->validation_aset == ''  OR $row->validation_aset == 0) ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-primary btn-xs">Proses').'</a></td>
							 <td>'.$row->nameaset.'</td>
							 <td>'.$row->validation_aset_at.'</td>
							 <td>'.$row->komentar.'</td>
							 <td>
							 <a href="'.url(config('laraadmin.adminRoute') . '/printphppbs/'.$row->id).'" class="btn btn-outline-info btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-print"></i></a>
							 <a href="'.url(config('laraadmin.adminRoute') . '/ajuan_penghapusanpbps/'.$row->id.'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>							 
							 </td>
							</tr>';
						   }else{
							   $output .= '
							<tr>
							<td>'.$index.'</td>
							 <td>'.$row -> deptname.'</td>
							 <td><a href="'.url(config('laraadmin.adminRoute') . '/ajuan_penghapusanpbps/'.$row->id).'">'.$row->no_ajuan.'</a></td>							 
							 <td>'.date('d-m-Y', strtotime($row->tgl_ajuan)).'</td>
							 <td>'.$row->jenis_ajuan.'</td>
							 <td><a href="'.url('storage' . '/php_ppb/file/'.$row->filepdf).'" target = "_blank">'.$row->no_surat.'</a></td>
							 <td>'.(($row->validation_pb == ''  OR $row->validation_pb == 0 OR $row->validation_pb == 1 OR $row->validation_pb == 2 OR $row->validation_pb == 3) ? '<i class="fa fa-check btn-primary btn-xs">Proses' : '<i class="fa fa-times btn-danger btn-xs"> Ditolak').'</a></td>
							 <td>'.$row->namepb.'</td>
							 <td>'.$row->validation_pb_at.'</td>
							 <td>'.(($row->validation_aset == ''  OR $row->validation_aset == 0) ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-primary btn-xs">').'</a></td>
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
			}
		}else{
			return view('errors.404');
		}
		
	}
	
	public function imageupload(Request $request,$id){
	  $this->validate($request,[
        'file' => 'mimes:jpeg,png,bmp,tiff |max:200',
      ],
        $messages = [
            'required' => 'The :attribute field is required.',
            'mimes' => 'Only jpeg, png, bmp,tiff are allowed.'
        ]
	  ); 
      
        if($request->file()) {
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->move('storage/php_ppb/Image/', $fileName, 'public');
			
			$fileModel = new Image_phpppb;
            $fileModel->name = time().'_'.$request->file->getClientOriginalName();
            $fileModel->file_path = $filePath;
            $fileModel->save();
			
			$fileid = Penghapusan_item::findOrFail($id);
			$fileid->validation_img = $fileModel->id;
			$fileid->save();
			
            return back()
            ->with('success','File has been uploaded.')
            ->with('file', $fileName);
        }
   }
   
   public function fileupload(Request $request,$id){
	  $this->validate($request,[
        'file' => 'required|mimes:pdf|max:2000',
      ],
        $messages = [
            'required' => 'The :attribute field is required.',
            'mimes' => 'Only PDF are allowed.'
        ]
	  ); 
      
        if($request->file()) {
			$tglsurat = str_replace('/', '-', $request->tgl_surat);
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->move('storage/php_ppb/file/', $fileName, 'public');
			
			$fileModel = new File_phpppb;
            $fileModel->name = time().'_'.$request->file->getClientOriginalName();
            $fileModel->file_path = $filePath;
            $fileModel->save();
			
			$fileid = Ajuan_penghapusanpbp::findOrFail($id);
			$fileid->surat_persetujuan = $fileModel->id;
			$fileid->no_surat = $request->no_surat;
			$fileid->perihal = $request->perihal;
			$fileid->tgl_surat = date('Y-m-d', strtotime($tglsurat));			
			$fileid->save();
			//dd(date('Y-m-d', strtotime($tglsurat)));
            return back()
            ->with('success','File has been uploaded.')
            ->with('file', $fileid->tgl_surat);
        }
   }
   public function ajukanpb(Request $request,$id){
		$nmsub = Module::usersubunit()->nm_sub;
		$nmpim = Module::userkaopd()->Nm_Pimpinan;
		$nippim = Module::userkaopd()->Nip_pimpinan;
		$jbtpim = Module::userkaopd()->Jbt_Pimpinan;
		if($request){
			$fileid = ajuan_penghapusanpbp::findorfail($id);
			$fileid->validation_pb = 1;
			$fileid->nm_opd = $nmsub;
			$fileid->nm_pimpinan = $nmpim;
			$fileid->nip_pimpinan = $nippim;
			$fileid->jbt_pimpinan = $jbtpim;
			$fileid->save();
			//dd($file_id);
			return back()->with('success','telah diajukan ke pengurus barang.');
			
		}			
   }
   public function ajukanaset(Request $request,$id){
	   
		if($request){
			$fileid = ajuan_penghapusanpbp::findorfail($id);
			$fileid->validation_aset = 1;
			$fileid->save();
			
			return back()->with('success','telah diajukan ke bidang aset.');
			//return redirect()->route(config('laraadmin.adminRoute') . '.ajuan_penghapusanpbps.index');
		}			
   }
   public function inputbcd(Request $request,$noajuan,$idpemda){					
			$data = Module::insertbrg($noajuan,$idpemda);
			return json_encode($data);		
	}
	
	
   
}


	
