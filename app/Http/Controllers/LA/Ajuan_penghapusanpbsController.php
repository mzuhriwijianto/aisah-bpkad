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

use App\Models\Ajuan_penghapusanpb;
use App\Models\Ajuan_penghapusanpbp;
use App\Models\Image_phpppb;
use App\Models\File_phpppb;
use App\Models\Penghapusan_item;
use PDF;

class Ajuan_penghapusanpbsController extends Controller
{
	public $show_action = true;
	public $view_col = 'no_ajuan';
	public $listing_cols = ['id', 'no_ajuan', 'opd', 'dept', 'tgl_ajuan', 'surat_persetujuan', 'kd_bidang', 'kd_unit', 'kd_sub', 'validation_aset', 'validation_aset_by', 'validation_aset_at', 'jenis_ajuan'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Ajuan_penghapusanpbs', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Ajuan_penghapusanpbs', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Ajuan_penghapusanpbs.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		$module = Module::get('Ajuan_penghapusanpbs');
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$kdsub = Module::kdopd()->kd_sub;
		$kdupb = Module::kdopd()->kd_upb;
		$refrek0 = Module::populaterefbrg0()->get();
		//dd($kdbidang,$kdunit,$kdsub,$kdupb);
		//$data = Module::populateidpengajuanpb(2,$kdbidang,$kdunit);
		//dd($data);
		//dd(Module::userkaopd()->Nm_Pimpinan);

		if(Module::hasAccess($module->id)) {
			return View('la.ajuan_penghapusanpbs.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module,
				'refrek0' => $refrek0,
				'kdbidang' => $kdbidang,
				'kdunit' => $kdunit,
				'kdsub'=> $kdsub//,
				//'data' => $data
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}
	public function idajuan($id){
		$fileid = ajuan_penghapusanpb::findorfail($id);
		$idajuan = $fileid->id;
		return $idajuan;
	}

/* print */
	public function printlampiranphppb($id){
		$ajuan_penghapusanpb = Ajuan_penghapusanpb::find($id);
		$kdbidang = $ajuan_penghapusanpb->kd_bidang;
		$kdunit = $ajuan_penghapusanpb->kd_unit;
		$kdsub = $ajuan_penghapusanpb->kd_sub;
		$kdupb = Module::kdopd()->kd_upb;
			/* $data_b = Module::selectbrg_pm($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
			dd($data_b); */
		if(Module::hasAccess("Ajuan_penghapusanpbs", "view")) {		
					$data_a = Module::selectbrg_tanah($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);
					$data_a_sum = Module::selectbrg_tanah_sum($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);
					$data_b = Module::selectbrg_pm($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);
					$data_b_sum = Module::selectbrg_pm_sum($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);
					$data_c = Module::selectbrg_gb($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);
					$data_c_sum = Module::selectbrg_gb_sum($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);
					$data_d = Module::selectbrg_jj($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);
					$data_d_sum = Module::selectbrg_jj_sum($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);
					$data_e = Module::selectbrg_atl($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);
					$data_e_sum = Module::selectbrg_atl_sum($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);
					$data_f = Module::selectbrg_kdp($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);	
					$ajnphp =
				DB::table('ajuan_penghapusanpbs as pbp')
				->leftjoin('departments as dept','dept.id','=','pbp.dept')
				->leftjoin('file_phpppbs as filephpppbs','filephpppbs.id','=','pbp.surat_persetujuan')
				->select('pbp.id','dept.name as deptname','pbp.no_ajuan','pbp.tgl_ajuan','pbp.no_surat','pbp.tgl_surat','pbp.jenis_ajuan',
				'pbp.validation_aset','pbp.validation_aset_by','pbp.validation_aset_at','filephpppbs.name as filepdf',
				'pbp.jbt_pimpinan','pbp.nip_pimpinan','pbp.nm_pimpinan')
				->where('pbp.id','=',$ajuan_penghapusanpb->id)
				->get();
					
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
							->loadView('la.report.printlampiranphppb',
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
							->setPaper('Letter', 'landscape');
					
					return $pdf->stream('Lampiran_penghapusan_'.Module::userlogin()->dept_name.'.pdf');	
				
					/* return view('la.report.printlampiranphppb',[
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
/* print */
	public function printlampiranphppbs($id){
		$ajuan_penghapusanpb = Ajuan_penghapusanpb::find($id);
			// $kdbidang = $ajuan_penghapusanpbp->kd_bidang;
			// $kdunit = $ajuan_penghapusanpbp->kd_unit;
			// $kdsub = $ajuan_penghapusanpbp->kd_sub;
			// $kdupb = Module::kdopd()->kd_upb;
			$kdbidang = Module::kdopd()->kd_bidang;
			$kdunit = Module::kdopd()->kd_unit;
			$kdsub = Module::kdopd()->kd_sub;
			$kdupb = Module::kdopd()->kd_upb;
			//dd($ajuan_penghapusanpb->id);
			//dd($ajnphp);
		if(Module::hasAccess("Ajuan_penghapusanpbs", "view")) {		
					$data_a = Module::selectbrg_tanah($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
					$data_b = Module::selectbrg_pm($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
					$data_c = Module::selectbrg_gb($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
					$data_d = Module::selectbrg_jj($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
					$data_e = Module::selectbrg_atl($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
					$data_f = Module::selectbrg_kdp($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);	
					$data_a_sum = Module::selectbrg_tanah_sum($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
					$data_b_sum = Module::selectbrg_pm_sum($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
					$data_c_sum = Module::selectbrg_gb_sum($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
					$data_d_sum = Module::selectbrg_jj_sum($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
					$data_e_sum = Module::selectbrg_atl_sum($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);

				$ajnphp =
				DB::table('ajuan_penghapusanpbps as pbp')
				->leftjoin('departments as dept','dept.id','=','pbp.dept')
				->leftjoin('file_phpppbs as filephpppbs','filephpppbs.id','=','pbp.surat_persetujuan')
				->leftjoin('ajuan_penghapusanpbs as pbs',function ($join) {
								$join->on('pbs.kd_bidang','=','pbp.kd_bidang')
										->on('pbs.kd_unit','=','pbp.kd_unit');
								}
							)
				->select('pbp.id','dept.name as deptname','pbp.no_ajuan','pbp.tgl_ajuan',
				'pbp.validation_pb','pbp.validation_pb_by','pbp.validation_pb_at','pbp.validation_pb_at','pbp.tgl_surat','pbp.jenis_ajuan','pbp.no_surat',
				'pbp.validation_aset','pbp.validation_aset_by','pbp.validation_aset_at','filephpppbs.name as filepdf','pbp.komentar',
				'pbs.jbt_pimpinan','pbs.nip_pimpinan','pbs.nm_pimpinan','pbp.jbt_pimpinan as jbt_pimpinans','pbp.nip_pimpinan as nip_pimpinans','pbp.nm_pimpinan as nm_pimpinans')
				->where('pbp.id','=',$ajuan_penghapusanpb->id)
				->get();
			
					
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
							->setPaper('Letter', 'landscape');
					
					//return $pdf->stream('Lampiran_penghapusan_'.Module::userlogin()->dept_name.'.pdf');	
				
					return view('la.report.printlampiranphppbs',[
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
										]);
		}else{
			return view(abort(403, 'Unauthorized action.'));
		}		 
	}
	/* end */
	/**
	 * Store a newly created ajuan_penghapusanpb in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request){
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$kdsub = Module::kdopd()->kd_sub;
		$kddept = Module::kddept()->id;
		
		if(Module::hasAccess("Ajuan_penghapusanpbs", "create")) {
		
				$pengajuan = new Ajuan_penghapusanpb;		
				$pengajuan->kd_bidang = $kdbidang;
				$pengajuan->kd_unit = $kdunit;
				$pengajuan->kd_sub = $kdsub;
				$pengajuan->dept = $kddept;
				$pengajuan->tgl_ajuan = date('Y-m-d');
				$pengajuan->jenis_ajuan = $request->jenis_ajuan;
				$pengajuan->save();
								
				return redirect()->route(config('laraadmin.adminRoute') . '.ajuan_penghapusanpbs.index');
			
		} else {
			return back()->withErrors(['Jenis Ajuan' => ['Silahkan isi jenis ajuan']]);
			//return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified ajuan_penghapusanpb.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id){
		if(Module::hasAccess("Ajuan_penghapusanpbs", "view")) {
			
			$ajuan_penghapusanpb = Ajuan_penghapusanpb::find($id);
			$kdbidang = $ajuan_penghapusanpb->kd_bidang;
			$kdunit = $ajuan_penghapusanpb->kd_unit;
			$kdsub = $ajuan_penghapusanpb->kd_sub;
			$kdupb = Module::kdopd()->kd_upb;
			
			$data_a = Module::selectbrg_tanah($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);
			$data_as = Module::selectbrg_tanah($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
			$data_b = Module::selectbrg_pm($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);
			
			$data_c = Module::selectbrg_gb($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);
			$data_d = Module::selectbrg_jj($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);
			$data_e = Module::selectbrg_atl($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);
			$data_f = Module::selectbrg_kdp($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);
			$data_a_sum = Module::selectbrg_tanah_sum($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);
			$data_b_sum = Module::selectbrg_pm_sum($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);
			$data_c_sum = Module::selectbrg_gb_sum($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);
			$data_d_sum = Module::selectbrg_jj_sum($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);
			$data_e_sum = Module::selectbrg_atl_sum($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);
			$data = Module::populateidrefpengajuanppb(2,$kdbidang,$kdunit,$id)->get();
			//dd($data_bx,$data_b);
			
			$ajnphp =
				DB::table('ajuan_penghapusanpbs as pbp')
				->leftjoin('departments as dept','dept.id','=','pbp.dept')
				->leftjoin('file_phpppbs as filephpppbs','filephpppbs.id','=','pbp.surat_persetujuan')
				->select('pbp.id','dept.name as deptname','pbp.no_ajuan','pbp.tgl_ajuan','pbp.no_surat','pbp.tgl_surat','pbp.jenis_ajuan',
				'pbp.validation_aset','pbp.validation_aset_by','pbp.validation_aset_at','filephpppbs.name as filepdf',
				'pbp.jbt_pimpinan','pbp.nip_pimpinan','pbp.nm_pimpinan')
				->where('pbp.id','=',$ajuan_penghapusanpb->id)
				->get();

			if(isset($ajuan_penghapusanpb->id)) {
				$module = Module::get('Ajuan_penghapusanpbs');
				$module->row = $ajuan_penghapusanpb;
				
				return view('la.ajuan_penghapusanpbs.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding",
					'kdbidang' => $kdbidang,
					'kdunit' => $kdunit,
				    'kdsub' => $kdsub,
				    'kdupb' => $kdupb,
					'data' => $data,
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
				])->with('ajuan_penghapusanpb', $ajuan_penghapusanpb);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("ajuan_penghapusanpb"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	public function showpbp($id){
			
			
			$ajuan_penghapusanpbp = Ajuan_penghapusanpbp::find($id);
			$kdbidang = $ajuan_penghapusanpbp->kd_bidang;
			$kdunit = $ajuan_penghapusanpbp->kd_unit;
			$kdsub = $ajuan_penghapusanpbp->kd_sub;
			$kdupb = Module::kdopd()->kd_upb;
			
			$data_a = Module::selectbrg_tanah($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
			$data_b = Module::selectbrg_pm($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
			$data_c = Module::selectbrg_gb($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
			$data_d = Module::selectbrg_jj($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
			$data_e = Module::selectbrg_atl($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
			$data_f = Module::selectbrg_kdp($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);	
			$data_a_sum = Module::selectbrg_tanah_sum($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
			$data_b_sum = Module::selectbrg_pm_sum($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
			$data_c_sum = Module::selectbrg_gb_sum($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
			$data_d_sum = Module::selectbrg_jj_sum($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
			$data_e_sum = Module::selectbrg_atl_sum($id,"PPB",$kdbidang,$kdunit,$kdsub,$kdupb);
			
			$ajnphp =
				DB::table('ajuan_penghapusanpbps as pbp')
				->leftjoin('departments as dept','dept.id','=','pbp.dept')
				->leftjoin('file_phpppbs as filephpppbs','filephpppbs.id','=','pbp.surat_persetujuan')
				->leftjoin('ajuan_penghapusanpbs as pbs',function ($join) {
								$join->on('pbs.kd_bidang','=','pbp.kd_bidang')
										->on('pbs.kd_unit','=','pbp.kd_unit');
								}
							)
				->select('pbp.id','dept.name as deptname','pbp.no_ajuan','pbp.tgl_ajuan',
				'pbp.validation_pb','pbp.validation_pb_by','pbp.validation_pb_at','pbp.validation_pb_at','pbp.tgl_surat','pbp.jenis_ajuan',
				'pbp.validation_aset','pbp.validation_aset_by','pbp.validation_aset_at','filephpppbs.name as filepdf','pbp.komentar',
				'pbs.jbt_pimpinan','pbs.nip_pimpinan','pbs.nm_pimpinan')
				->where('pbp.id','=',$ajuan_penghapusanpbp->id)
				->get();
			//dd($ajnphp);
			
			if(isset($ajuan_penghapusanpbp->id)) {
				$module = Module::get('Ajuan_penghapusanpbps');
				$module->row = $ajuan_penghapusanpbp;
				
				return view('la.ajuan_penghapusanpbs.showpbp', [
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
					'record_name' => ucfirst("ajuan_penghapusanpb"),
				]);
			}

	}

	/**
	 * Show the form for editing the specified ajuan_penghapusanpb.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id){
		if(Module::hasAccess("Ajuan_penghapusanpbs", "edit")) {	
			
			
			$ajuan_penghapusanpb = Ajuan_penghapusanpb::find($id);
			$refrek0 = Module::populaterefbrg0()->get();
			$kdbidang = Module::kdopd()->kd_bidang;
			$kdunit = Module::kdopd()->kd_unit;
			$kdsub = Module::kdopd()->kd_sub;
			$kdupb = Module::kdopd()->kd_upb;
			//$idajuan = Ajuan_penghapusanpb::find($id);
			$kond = Module::populaterefkondisi()->get();
			$dataref = Module::populateidrefpengajuanppb(2,$kdbidang,$kdunit,$id)->get();
			//dd($dataref);
			$ajnphp =
				DB::table('ajuan_penghapusanpbs as pbp')
				->leftjoin('departments as dept','dept.id','=','pbp.dept')
				->leftjoin('file_phpppbs as filephpppbs','filephpppbs.id','=','pbp.surat_persetujuan')
				->select('pbp.id','dept.name as deptname','pbp.no_ajuan','pbp.tgl_ajuan',
				'pbp.validation_aset','pbp.validation_aset_by','pbp.validation_aset_at','filephpppbs.name as filepdf')
				->where('pbp.id','=',$ajuan_penghapusanpb->id)
				->get();
				
			
			/* $data = Module::showbrgpb(7,1,5,1,$ids,$idss)
					->get(); */
			//dd($data);
			
			if(isset($ajuan_penghapusanpb->id)) {	
				$module = Module::get('Ajuan_penghapusanpbs');				
				$module->row = $ajuan_penghapusanpb;
				
				$data_a = Module::selectbrg_tanah($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);
				$data_b = Module::selectbrg_pm($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);
				$data_c = Module::selectbrg_gb($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);
				$data_d = Module::selectbrg_jj($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);
				$data_e = Module::selectbrg_atl($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);
				$data_f = Module::selectbrg_kdp($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);
				$data_a_sum = Module::selectbrg_tanah_sum($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);
				$data_b_sum = Module::selectbrg_pm_sum($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);
				$data_c_sum = Module::selectbrg_gb_sum($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);
				$data_d_sum = Module::selectbrg_jj_sum($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);
				$data_e_sum = Module::selectbrg_atl_sum($id,"PB",$kdbidang,$kdunit,$kdsub,$kdupb);
				
				return view('la.ajuan_penghapusanpbs.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
					'refrek0' => $refrek0,
					'kond' => $kond,
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
					'ajnphp' => $ajnphp,
					'dataref' => $dataref
				])->with('ajuan_penghapusanpb', $ajuan_penghapusanpb);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("ajuan_penghapusanpb"),
					
					
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

		$ajuan_penghapusanpb = Ajuan_penghapusanpb::find($id);
		//dd($ajuan_penghapusanpbp->id);
			
		if(Module::hasAccess("Ajuan_penghapusanpbs", "view")) {
			$kdbidang = Module::kdopd()->kd_bidang;
			$kdunit = Module::kdopd()->kd_unit;
			$kdsub = Module::kdopd()->kd_sub;
			$kdupb = Module::kdopd()->kd_upb;
			$idrek0  = (int)$ids;
			$idrek1  = (int)$idss;
			$idrek3  = (int)$ids3;
			$idrek4  = (int)$ids4;
			//$tahun = (int)$thn;
			//$data = Module::showbrgpb($kdbidang,$kdunit,$kdsub,$kdupb,$idrek0,$idrek1,$idrek3,$idrek4,$kond);
			//dd($data);
			if ($request->ajax()) {
					//dd('0');				
					$output = '';
					$query = $request->get('query');
					if ($query != '') {							
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::showbrgpbadminquery($idrek0,$idrek1,$idrek3,$idrek4,$kond,$query);							
							//dd('1');							
						}else{
							$data = Module::showbrgpbquery($kdbidang,$kdunit,$kdsub,$kdupb,$idrek0,$idrek1,$idrek3,$idrek4,$kond,$query);
							//dd('2');	
						}
					} else {						
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::showbrgpbadmin($idrek0,$idrek1,$idrek3,$idrek4,$kond);	
							//dd('3');	
							//dd($idrek0,$idrek1);
						}else{
							$data = Module::showbrgpb($kdbidang,$kdunit,$kdsub,$kdupb,$idrek0,$idrek1,$idrek3,$idrek4,$kond);
							//dd('4');			
						}	
					}
					
					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index=>$row){
						    $index = $index+1;
						   if(Module::hasAccess("Ajuan_penghapusanpbs", "edit")){
							$output .= '
							<tr>
							 <td>'.$index.'</td>
							  <div class="form-check form-check-inline">
							   <td>
							   <button id = "'.$row->idpemda.'" 
							   href="'.url(config('laraadmin.adminRoute') . '/addbrgpb/'.$ajuan_penghapusanpb->id.'/'.$row->idpemda).'" 
							   class="btn btn-primary" type="button" onclick = "getidpemda(this.id)" 
							   value = "'.$row->idpemda.'" enabled>Add</button>
								</td>						   
							   </td>								
							  </div>
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
							</tr>';
						   }else{
							   $output .= '
							<tr>
							 <td>'.$index.'</td>
							 <td>'.$row -> dept.'</td>
							 <td>'.$row -> Uraian.'</td>							 
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
		$data = Module::insertbrgpb($noajuan,$idpemda,$id0,$ids,$idss,$ids3,$ids4);
		return json_encode($data);
		
	}
	public function delbrg(Request $request,$id){
		$data = Module::delbrg($id);
		return json_encode($data);
	}

	/**
	 * Update the specified ajuan_penghapusanpb in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id){
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$kdsub = Module::kdopd()->kd_sub;
		if(Module::hasAccess("Ajuan_penghapusanpbs", "edit")) {
			
			$rules = Module::validateRules("Ajuan_penghapusanpbs", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Ajuan_penghapusanpbs", $request, $id);
			$update = Ajuan_penghapusanpbs::find($id);
			$update->kd_bidang 	= $kdbidang;			
			$update->kd_unit 	= $kdunit;
			$update->kd_sub 	= $kdsub;
			$update->save();
			
			return redirect()->route(config('laraadmin.adminRoute') . '.ajuan_penghapusanpbs#lists');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified ajuan_penghapusanpb from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Ajuan_penghapusanpbs", "delete")) {
			Ajuan_penghapusanpb::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.ajuan_penghapusanpbs.index');
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
		if(Module::hasAccess("Ajuan_penghapusanpbs", "view")) {
			$kdbidang = Module::kdopd()->kd_bidang;
			//$data = Module::getdataphppbuser()->get();	
			//dd($data);
			if ($request->ajax()) {
					$output = '';
					$query = $request->get('query');
					if ($query != '') {							
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::getdataphppbadminquery($query)
								->take(1)
								->get();
								
						}else{
							$data = Module::getdataphppbuserquery($query)
								->take(1)
								->get();	
						}
					} else {						
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::getdataphppbadmin()
								->get();
						}else{
							$data = Module::getdataphppbuser()->get();							
						}	
					}
					
					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index=>$row){
						    $index = $index+1;
						   if(Module::hasAccess("Ajuan_penghapusanpbs", "edit")){
							$output .= '
							<tr>
							 <td>'.$index.'</td>
							 <td>'.$row -> deptname.'</td>
							 <td><a href="'.url(config('laraadmin.adminRoute') . '/ajuan_penghapusanpbs/'.$row->id).'">'.$row->no_ajuan.'</a></td>							 
							 <td>'.date('d-m-Y', strtotime($row->tgl_ajuan)).'</td>
							 <td>'.$row->jenis_ajuan.'</td>
							 <td><a href="'.url('storage' . '/php_pb/file/'.$row->filepdf).'" target = "_blank">'.$row->no_surat.'</a></td>	
							  <td>'.(($row->validation_aset == 0 OR $row->validation_aset == 1 OR $row->validation_aset == 2 OR $row->validation_aset == 3) ? '<i class="fa fa-check btn-primary btn-xs">Proses' : '<i class="fa fa-times btn-danger btn-xs">Ditolak').'</a></td>
							  <td>'.$row->nameaset.'</td>
							 <td>'.$row->validation_aset_at.'</td>
							 <td>'.$row->komentar.'</td>
							 <td>
							 <a href="'.url(config('laraadmin.adminRoute') . '/printphppbs/'.$row->id).'" class="btn btn-outline-info btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-print"></i></a>
							 <a href="'.url(config('laraadmin.adminRoute') . '/ajuan_penghapusanpbs/'.$row->id.'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>							 
							 </td>
							</tr>';
						   }else{
							   $output .= '
							<tr>
							<td>'.$index.'</td>
							 <td>'.$row -> deptname.'</td>
							 <td><a href="'.url(config('laraadmin.adminRoute') . '/ajuan_penghapusanpbs/'.$row->id).'">'.$row->no_ajuan.'</a></td>							 
							 <td>'.date('d-m-Y', strtotime($row->tgl_ajuan)).'</td>
							 <td>'.$row->jenis_ajuan.'</td>	
							<td><a href="'.url('storage' . '/php_pb/file/'.$row->filepdf).'" target = "_blank">'.$row->no_surat.'</a></td>								 
							  <td>'.(($row->validation_aset == 0 OR $row->validation_aset == 1 OR $row->validation_aset == 2 OR $row->validation_aset == 3) ? '<i class="fa fa-check btn-primary btn-xs">Proses' : '<i class="fa fa-times btn-danger btn-xs">Ditolak').'</a></td>
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
	public function dtajaxpb(Request $request){
		if(Module::hasAccess("Ajuan_penghapusanpbs", "view")) {
			$kdbidang = Module::kdopd()->kd_bidang;

			if ($request->ajax()) {
					$output = '';
					$query = $request->get('query');
					if ($query != '') {							
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::getdataphppbaksesadminquery($query)
								->take(20)
								->get();
								
						}else{
							$data = Module::getdataphppbaksesuserquery($query)
								->take(1)
								->get();	
						}
					} else {						
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::getdataphppbaksesadmin()
								->get();
						}else{
							$data = Module::getdataphppbaksesuser()->get();							
						}	
					}
					
					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index=>$row){
						    $index = $index+1;
						   
							$output .= '
							<tr>
							 <td>'.$index.'</td>
							 <td>'.$row -> deptname.'</td>
							 <td><a href="'.url(config('laraadmin.adminRoute') . '/ajuan_penghapusanpbs/showpbp/'.$row->id).'">'.$row->no_ajuan.'</a></td>							 
							 <td>'.date('d-m-Y', strtotime($row->tgl_ajuan)).'</td>
							 <td>'.$row->jenis_ajuan.'</td>
							 <td><a href="/storage/php_ppb/file/'.$row->surat.'" target = "_blank">'.$row->no_surat.'</a></td>	
							 <td>'.(($row->validation_pb == '' OR $row->validation_pb == 0 OR $row->validation_pb == 1 OR $row->validation_pb == 2 OR $row->validation_pb == 3) ? '<i class="fa fa-check btn-primary btn-xs">Proses' : '<i class="fa fa-times btn-danger btn-xs">Ditolak').'</a></td>
							 <td>'.$row->namepb.'</td>
							 <td>'.$row->validation_pb_at.'</td>
							<td>'.(($row->validation_aset == '' OR $row->validation_aset == 0 OR $row->validation_aset == 1 OR $row->validation_aset == 2 OR $row->validation_aset == 3) ? '<i class="fa fa-check btn-primary btn-xs">Proses' : '<i class="fa fa-times btn-danger btn-xs">Ditolak').'</a></td>
							 <td>'.$row->nameaset.'</td>
							 <td>'.$row->validation_aset_at.'</td>
							 <td>'.$row->komentar.'</td>
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
				return response()->json($data);
				 //echo json_encode($data);
			}
				
		}else{
			return view('errors.404');
		}		
	}
	public function imageupload(Request $request,$id){
	  $this->validate($request,[
        'file' => 'mimes:jpg,jpeg,png,bmp,tiff |max:5000',
      ],
        $messages = [
            'required' => 'The :attribute field is required.',
            'mimes' => 'Only jpg,jpeg,png, bmp,tiff are allowed.'
        ]
	  ); 
      
        if($request->file()) {
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->move('storage/php_pb/Image/', $fileName, 'public');
			
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
        'file' => 'required|mimes:pdf|max:5000',
      ],
        $messages = [
            'required' => 'The :attribute field is required.',
            'mimes' => 'Only PDF are allowed.'
        ]
	  ); 
      
        if($request->file()) {
			$tglsurat = str_replace('/', '-', $request->tgl_surat);
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->move('storage/php_pb/file/', $fileName, 'public');
			
			$fileModel = new File_phpppb;
            $fileModel->name = time().'_'.$request->file->getClientOriginalName();
            $fileModel->file_path = $filePath;
            $fileModel->save();
			
			$fileid = Ajuan_penghapusanpb::findOrFail($id);
			$fileid->surat_persetujuan = $fileModel->id;
			$fileid->no_surat = $request->no_surat;
			$fileid->perihal = $request->perihal;
			$fileid->tgl_surat = date('Y-m-d', strtotime($tglsurat));			
			$fileid->save();
			//dd($tglsurat->date->format('Y-m-d'));
            return back()
            ->with('success','File has been uploaded.')
            ->with('file', $fileName);
        }
   }
   public function ajukanaset(Request $request,$id){
		$nmsub = Module::usersubunit()->nm_sub;
		$nmpim = Module::userkaopd()->Nm_Pimpinan;
		$nippim = Module::userkaopd()->Nip_pimpinan;
		$jbtpim = Module::userkaopd()->Jbt_Pimpinan;	   
		if($request){
			$fileid = ajuan_penghapusanpb::findorfail($id);
			$fileid->validation_aset = 1;
			$fileid->nm_opd = $nmsub;
			$fileid->nm_pimpinan = $nmpim;
			$fileid->nip_pimpinan = $nippim;
			$fileid->jbt_pimpinan = $jbtpim;
			$fileid->save();
			
			return back()->with('success','telah diajukan ke bidang aset.');
			//return redirect()->route(config('laraadmin.adminRoute') . '.ajuan_penghapusanpbps.index');
		}			
   }
    public function batalkanaset(Request $request,$id){   
		if($request){
			$fileid = ajuan_penghapusanpb::findorfail($id);
			$fileid->validation_aset = 0;
			$fileid->save();
			$data = DB::update(DB::raw("
									update ajuan_penghapusanpbps 
									set validation_aset = 0,id_pengajuanpb = 0,validation_pb = 0
									where id_pengajuanpb = ".$id."
									"
									)		
								);
			
			return back()->with('success','telah dibatalkan ke Bidang aset.');
			//return redirect()->route(config('laraadmin.adminRoute') . '.ajuan_penghapusanpbps.index');
		}			
   }
   public function ajukanasetpb(Request $request,$id){	   
		if($request){
			$fileid = ajuan_penghapusanpbp::findorfail($id);
			$fileid->validation_aset = 1;			
			$fileid->save();			
			return back()->with('success','telah diajukan ke Bidang Aset.');
			//return redirect()->route(config('laraadmin.adminRoute') . '.ajuan_penghapusanpbps.index');
		}			
   }
    public function ajukanasetpbusulpb(Request $request,$id){
			$nmsub = Module::usersubunit()->nm_sub;
			$nmpim = Module::userkaopd()->Nm_Pimpinan;
			$nippim = Module::userkaopd()->Nip_pimpinan;
			$jbtpim = Module::userkaopd()->Jbt_Pimpinan;
		if($request){
			$valaset = 1;
			$data = DB::update(DB::raw("
									update ajuan_penghapusanpbps 
									set validation_aset = ".$valaset.",id_pengajuanpb = ".$id."
									where id in (".$request->getidajuanpbp.")
									"
									)		
								);
			/* $data2 = DB::update(DB::raw("
									update ajuan_penghapusanpbs 
									set validation_aset = ".$valaset.",nm_opd = ".$nmsub.",nm_pimpinan = ".$nmpim.",nip_pimpinan = ".$nmpim.",nip_pimpinan = ".$nippim.",jbt_pimp = ".$jbtpim."
									where id = ".$id."
									"
									)		
								); */
			$fileid = ajuan_penghapusanpb::findorfail($id);
			$fileid->validation_aset = 1;
			$fileid->nm_opd = $nmsub;
			$fileid->nm_pimpinan = $nmpim;
			$fileid->nip_pimpinan = $nippim;
			$fileid->jbt_pimpinan = $jbtpim;
			$fileid->save();
			return back()->with('success','telah diajukan ke Bidang Aset.');
		}			
   }
    public function ajukanpb2(Request $request,$id){	   
		if($request){
			$fileid = ajuan_penghapusanpbp::findorfail($id);
			$fileid->validation_pb = $request->valterm;
			$fileid->komentar = $request->komen;
			$fileid->validation_pb_by = \Auth::user()->id;
			$fileid->validation_pb_at = date('Y-m-d H:i:s');
			$fileid->save();			
			//dd($fileid);
			return back()->with('success','telah divalidasi oleh Pengurus Barang.');
		}			
   }
   
   	public function showidpbp(Request $request){
			$module = Module::get('Ajuan_penghapusanpbs');
			
			if(Module::hasAccess("Ajuan_penghapusanpbs", "view")) {
			$id = 2;
			$kdbidang = Module::kdopd()->kd_bidang;
			$kdunit = Module::kdopd()->kd_unit;
			/* $data = Module::populateidpengajuanpb($id,$kdbidang,$kdunit);
			dd($data,$kdbidang,$kdunit); */
			
			if ($request->ajax()) {
					$output = '';
					$query = $request->get('query');
					$data = Module::populateidpengajuanpb($id,$kdbidang,$kdunit)
							->take(20)
							->get();
										
					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index=>$row){
						    $index = $index+1;
						   
							$output .= '
							<tr>
							 <td>'.$index.'</td>
							 <td>'.$row -> deptname.'</td>
							 <td><a href="'.url(config('laraadmin.adminRoute') . '/ajuan_penghapusanpbs/showpbp/'.$row->id).'">'.$row->no_ajuan.'</a></td>							 
							 <td>'.date('d-m-Y', strtotime($row->tgl_ajuan)).'</td>
							 <td>'.$row->jenis_ajuan.'</td>							
							 <td>'.$row->no_surat.'</td>
							 <td>'.date('d-m-Y', strtotime($row->tgl_surat)).'</td>							 
							 <td>'.$row->perihal.'</td>
							 <td>
							 <div class="form-check form-check-inline">
								<input id="chkbox1" type="checkbox" name="ids" value="'.$row->id.'" rel="searchsolos" onclick = "validate1()"/>
							  </div>
							 </td>
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
				return response()->json($data);
				echo json_encode($data);
			}
				
		}else{
			return view('errors.404');
		}

	}
	
	/* public function showidreftable(Request $request){
			//$idajuan = Ajuan_penghapusanpbs::idajuan($id);
			$module = Module::get('Ajuan_penghapusanpbs');
			$ajuan_penghapusanpb = Ajuan_penghapusanpb::find($id);
			$idajuan = Ajuan_penghapusanpb::find($id);
			//dd($idajuan->id);
			
			if(Module::hasAccess("Ajuan_penghapusanpbs", "view")) {
			$idval = 2;
			$kdbidang = Module::kdopd()->kd_bidang;
			$kdunit = Module::kdopd()->kd_unit;

			if ($request->ajax()) {
					$output = '';
					$query = $request->get('query');
					$data = Module::populateidrefpengajuanppb(2,$kdbidang,$kdunit,$idajuan->id)
					//$data = Module::populateidpengajuanpb($idval,$kdbidang,$kdunit)
							//->take(20)
							->get();
										
					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index=>$row){
						    $index = $index+1;
						   
							$output .= '
							<tr>
							 <td>'.$index.'</td>
							 <td>'.$row -> deptname.'</td>
							 <td><a href="'.url(config('laraadmin.adminRoute') . '/ajuan_penghapusanpbs/showpbp/'.$row->id).'">'.$row->no_ajuan.'</a></td>							 
							 <td>'.date('d-m-Y', strtotime($row->tgl_ajuan)).'</td>
							 <td>'.$row->jenis_ajuan.'</td>							
							 <td>'.$row->no_surat.'</td>
							 <td>'.date('d-m-Y', strtotime($row->tgl_surat)).'</td>							 
							 <td>'.$row->perihal.'</td>
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
				return response()->json($data);
				echo json_encode($data);
			}
				
		}else{
			return view('errors.404');
		}

	} */
	 public function inputbcd(Request $request,$noajuan,$idpemda){					
			$data = Module::insertbrg($noajuan,$idpemda);
			return json_encode($data);		
	}
	

}
