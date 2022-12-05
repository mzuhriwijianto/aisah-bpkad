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
use App\Models\Image_kib;
use PDF;

use App\Models\Daftar_pegawai;

class Daftar_pegawaisController extends Controller
{
	public $show_action = true;
	public $view_col = 'nama';
	public $listing_cols = ['id', 'nama', 'nip', 'jabatan', 'instansi', 'telp'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Daftar_pegawais', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Daftar_pegawais', $this->listing_cols);
		}
	}
	
	/* print */
	public function printbrgpgw($id){
		$daftar_pegawai = Daftar_pegawai::find($id);
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$kdsub = Module::kdopd()->kd_sub;
		$kdupb = Module::kdopd()->kd_upb;
		
		$data = DB::table('daftar_pegawais as dp')->join('departments as dept','dp.instansi','=','dept.id')
							->select('dp.id','dept.name as depts','dp.instansi','dp.nip','dp.nama','dp.jabatan','dp.telp')
							->distinct()
							->where([
								['dept.kd_bidang','=',$kdbidang],
								['dept.kd_unit','=',$kdunit],
								['dept.kd_sub','=',$kdsub],
								['dept.kd_upb','=',$kdupb],
								['dp.id','=',$id]
								])->get()						
							;
		
		if(Module::hasAccess("Daftar_pegawais", "view")) {		
					
					
					$kibbsuserbrg = Module::kibbuserbrg($id);
					$kibbsuserbrg_array = json_decode(json_encode($kibbsuserbrg), true);
				    $pdf = new PDF;
					$pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
							->loadView('la.report.printbrgpgw',
										[
										'kibbsuserbrg' => $kibbsuserbrg,
										'data' => $data
										])
							->setPaper('folio', 'landscape');
					
					return $pdf->stream('Lampiran_brg_pegawai'.Module::userlogin()->dept_name.'.pdf');	
				
					/* return view('la.report.printbrgpgw',[
										'kibbsuserbrg' => $kibbsuserbrg,
										'data' => $data
										]); */
		}else{
			return view(abort(403, 'Unauthorized action.'));
		}		 
	}
	
	/**
	 * Display a listing of the Daftar_pegawais.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		$module = Module::get('Daftar_pegawais');
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$kdsub = Module::kdopd()->kd_sub;
		$kdupb = Module::kdopd()->kd_upb;
		
		
		//dd($gunapegawaiuser);
		if($kdbidang == 99 || $kdbidang == 0 ){
			$totpegawaiuser = DB::table('daftar_pegawais as dpgw')
					->leftjoin('departments as dept','dpgw.instansi','=','dept.id')
					->select('dpgw.id as count')
					->where([
							['dept.kd_bidang','=',$kdbidang],
							['dept.kd_unit','=',$kdunit],
							['dept.kd_sub','=',$kdsub]
							])
					->count();
		$gunapegawaiuser = DB::table('daftar_pegawais as dpgw')
					->join('kibbs','kibbs.pemegang_brg','=','dpgw.id')
					->join(Module::bmd().'.Ta_KIB_B as kibb','kibbs.idpemda','=','kibb.IDPemda')
					->select('kibbs.idpemda as count')
					->where([
							['kibb.kd_bidang','=',$kdbidang],
							['kibb.kd_unit','=',$kdunit],
							['kibb.kd_sub','=',$kdsub]
							])
					->count();
		$totbarang = DB::table(Module::bmd().'.Ta_KIB_B as kibb','kibbs.idpemda','=','kibb.IDPemda')
					->select('kibbs.idpemda as count')
					->where([							
							['kibb.kd_bidang','=',$kdbidang],
							['kibb.kd_unit','=',$kdunit],
							['kibb.kd_sub','=',$kdsub],
							['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_KA','=',1]
							])
					->count();
		$kendaraanr2 = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->join('kibbs as kibbs','kibbs.idpemda','=','kibb.IDPemda')
					->join('daftar_pegawais as dpgw','kibbs.pemegang_brg','=','dpgw.id')
					->select('kibb.idpemda as count')
					->where([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset8','=',1],
							['kibb.kd_aset80','=',3],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',2],
							['kibb.kd_aset83','=',1],
							['kibb.kd_aset84','=',4],
							['kibb.kd_bidang','=',$kdbidang],
							['kibb.kd_unit','=',$kdunit],
							['kibb.kd_sub','=',$kdsub]
							])
					->count();
		$kendaraanr4 = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->join('kibbs as kibbs','kibbs.idpemda','=','kibb.IDPemda')
					->join('daftar_pegawais as dpgw','kibbs.pemegang_brg','=','dpgw.id')
					->select('kibb.idpemda as count')
					->where([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset8','=',1],
							['kibb.kd_aset80','=',3],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',2],
							['kibb.kd_aset83','=',1],
							['kibb.kd_aset84','=',1],
							['kibb.kd_bidang','=',$kdbidang],
							['kibb.kd_unit','=',$kdunit],
							['kibb.kd_sub','=',$kdsub]
							])
					->count();
		$laptop = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->join('kibbs as kibbs','kibbs.idpemda','=','kibb.IDPemda')
					->join('daftar_pegawais as dpgw','kibbs.pemegang_brg','=','dpgw.id')
					->select('kibb.idpemda as count')
					->where([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset8','=',1],
							['kibb.kd_aset80','=',3],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',10],
							['kibb.kd_aset83','=',1],
							['kibb.kd_aset84','=',2],
							['kibb.kd_aset85','=',2],
							['kibb.kd_bidang','=',$kdbidang],
							['kibb.kd_unit','=',$kdunit],
							['kibb.kd_sub','=',$kdsub]
							])
					->count();
		$pc = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->join('kibbs as kibbs','kibbs.idpemda','=','kibb.IDPemda')
					->join('daftar_pegawais as dpgw','kibbs.pemegang_brg','=','dpgw.id')
					->select('kibb.idpemda as count')
					->where([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset8','=',1],
							['kibb.kd_aset80','=',3],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',10],
							['kibb.kd_aset83','=',1],
							['kibb.kd_aset84','=',2],
							['kibb.kd_aset85','=',1],
							['kibb.kd_bidang','=',$kdbidang],
							['kibb.kd_unit','=',$kdunit],
							['kibb.kd_sub','=',$kdsub]
							])
					->count();
		$printer = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->join('kibbs as kibbs','kibbs.idpemda','=','kibb.IDPemda')
					->join('daftar_pegawais as dpgw','kibbs.pemegang_brg','=','dpgw.id')
					->select('kibb.idpemda as count')
					->where([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset8','=',1],
							['kibb.kd_aset80','=',3],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',10],
							['kibb.kd_aset83','=',2],
							['kibb.kd_aset84','=',3],
							['kibb.kd_aset85','=',3],
							['kibb.kd_bidang','=',$kdbidang],
							['kibb.kd_unit','=',$kdunit],
							['kibb.kd_sub','=',$kdsub]
							])
					->count();
		$meubel = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->join('kibbs as kibbs','kibbs.idpemda','=','kibb.IDPemda')
					->join('daftar_pegawais as dpgw','kibbs.pemegang_brg','=','dpgw.id')
					->select('kibb.idpemda as count')
					->where([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset8','=',1],
							['kibb.kd_aset80','=',3],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',5],
							['kibb.kd_aset83','=',2],
							['kibb.kd_aset84','=',1],
							['kibb.kd_bidang','=',$kdbidang],
							['kibb.kd_unit','=',$kdunit],
							['kibb.kd_sub','=',$kdsub]
							])
					->count();
		$mejakursi = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->join('kibbs as kibbs','kibbs.idpemda','=','kibb.IDPemda')
					->join('daftar_pegawais as dpgw','kibbs.pemegang_brg','=','dpgw.id')
					->select('kibb.idpemda as count')
					->where([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset8','=',1],
							['kibb.kd_aset80','=',3],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',5],
							['kibb.kd_aset83','=',2],
							['kibb.kd_aset84','=',3],
							['kibb.kd_bidang','=',$kdbidang],
							['kibb.kd_unit','=',$kdunit],
							['kibb.kd_sub','=',$kdsub]
							])
					->orwhere([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset8','=',1],
							['kibb.kd_aset80','=',3],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',5],
							['kibb.kd_aset83','=',3],
							['kibb.kd_aset84','=',1],
							['kibb.kd_bidang','=',$kdbidang],
							['kibb.kd_unit','=',$kdunit],
							['kibb.kd_sub','=',$kdsub]
							])
					->count();
			$refbidang = Module::populatebidangadmin()->get();
		}else{
			$totpegawaiuser = DB::table('daftar_pegawais as dpgw')
					->leftjoin('departments as dept','dpgw.instansi','=','dept.id')
					->select('dpgw.id as count')
					->count();
		$gunapegawaiuser = DB::table('daftar_pegawais as dpgw')
					->join('kibbs','kibbs.pemegang_brg','=','dpgw.id')
					->join(Module::bmd().'.Ta_KIB_B as kibb','kibbs.idpemda','=','kibb.IDPemda')
					->select('kibbs.idpemda as count')
					->count();
		$totbarang = DB::table(Module::bmd().'.Ta_KIB_B as kibb','kibbs.idpemda','=','kibb.IDPemda')
					->select('kibbs.idpemda as count')
					->where([							
							['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_KA','=',1]
							])
					->count();
		$kendaraanr2 = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->join('kibbs as kibbs','kibbs.idpemda','=','kibb.IDPemda')
					->join('daftar_pegawais as dpgw','kibbs.pemegang_brg','=','dpgw.id')
					->select('kibb.idpemda as count')
					->where([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset8','=',1],
							['kibb.kd_aset80','=',3],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',2],
							['kibb.kd_aset83','=',1],
							['kibb.kd_aset84','=',4]
							])
					->count();
		$kendaraanr4 = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->join('kibbs as kibbs','kibbs.idpemda','=','kibb.IDPemda')
					->join('daftar_pegawais as dpgw','kibbs.pemegang_brg','=','dpgw.id')
					->select('kibb.idpemda as count')
					->where([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset8','=',1],
							['kibb.kd_aset80','=',3],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',2],
							['kibb.kd_aset83','=',1],
							['kibb.kd_aset84','=',1]
							])
					->count();
		$laptop = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->join('kibbs as kibbs','kibbs.idpemda','=','kibb.IDPemda')
					->join('daftar_pegawais as dpgw','kibbs.pemegang_brg','=','dpgw.id')
					->select('kibb.idpemda as count')
					->where([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset8','=',1],
							['kibb.kd_aset80','=',3],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',10],
							['kibb.kd_aset83','=',1],
							['kibb.kd_aset84','=',2],
							['kibb.kd_aset85','=',2]
							])
					->count();
		$pc = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->join('kibbs as kibbs','kibbs.idpemda','=','kibb.IDPemda')
					->join('daftar_pegawais as dpgw','kibbs.pemegang_brg','=','dpgw.id')
					->select('kibb.idpemda as count')
					->where([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset8','=',1],
							['kibb.kd_aset80','=',3],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',10],
							['kibb.kd_aset83','=',1],
							['kibb.kd_aset84','=',2],
							['kibb.kd_aset85','=',1]
							])
					->count();
		$printer = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->join('kibbs as kibbs','kibbs.idpemda','=','kibb.IDPemda')
					->join('daftar_pegawais as dpgw','kibbs.pemegang_brg','=','dpgw.id')
					->select('kibb.idpemda as count')
					->where([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset8','=',1],
							['kibb.kd_aset80','=',3],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',10],
							['kibb.kd_aset83','=',2],
							['kibb.kd_aset84','=',3],
							['kibb.kd_aset85','=',3]
							])
					->count();
		$meubel = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->join('kibbs as kibbs','kibbs.idpemda','=','kibb.IDPemda')
					->join('daftar_pegawais as dpgw','kibbs.pemegang_brg','=','dpgw.id')
					->select('kibb.idpemda as count')
					->where([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset8','=',1],
							['kibb.kd_aset80','=',3],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',5],
							['kibb.kd_aset83','=',2],
							['kibb.kd_aset84','=',1]
							])
					->count();
		$mejakursi = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->join('kibbs as kibbs','kibbs.idpemda','=','kibb.IDPemda')
					->join('daftar_pegawais as dpgw','kibbs.pemegang_brg','=','dpgw.id')
					->select('kibb.idpemda as count')
					->where([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset8','=',1],
							['kibb.kd_aset80','=',3],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',5],
							['kibb.kd_aset83','=',2],
							['kibb.kd_aset84','=',3]
							])
					->orwhere([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset8','=',1],
							['kibb.kd_aset80','=',3],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',5],
							['kibb.kd_aset83','=',3],
							['kibb.kd_aset84','=',1]
							])
					->count();
			$refbidang = Module::populatebidanguser()->get();
		}
		
		if(Module::hasAccess($module->id)) {
			return View('la.daftar_pegawais.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module,
				'kdbidang' => $kdbidang,
				'kdunit' => $kdunit,
				'kdsub' => $kdsub,
				'kdupb' => $kdupb,				
				'refbidang' => $refbidang,
				'totpegawaiuser' => $totpegawaiuser,
				'gunapegawaiuser' => $gunapegawaiuser,
				'totbarang' => $totbarang,
				'kendaraanr2' => $kendaraanr2,
				'kendaraanr4' => $kendaraanr4,
				'laptop' => $laptop,
				'pc' => $pc,
				'printer' => $printer,
				'meubel' => $meubel,
				'mejakursi' => $mejakursi
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}
	
	public function rekening1($ids){
		$rek1 = Module::populaterefbrg1($ids)->where('rek1.kd_aset1','=',2)->pluck('nm_aset1', 'kd_aset1');
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

	/**
	 * Show the form for creating a new daftar_pegawai.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created daftar_pegawai in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Daftar_pegawais", "create")) {
		
			$rules = Module::validateRules("Daftar_pegawais", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Daftar_pegawais", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.daftar_pegawais.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified daftar_pegawai.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Daftar_pegawais", "view")) {
			
			$daftar_pegawai = Daftar_pegawai::find($id);
			$kdbidang = Module::kdopd()->kd_bidang;
			$kdunit = Module::kdopd()->kd_unit;
			$kdsub = Module::kdopd()->kd_sub;
			$kdupb = Module::kdopd()->kd_upb;
			//$kibbsuserbrg = Module::kibbuserbrg($id);
			//dd($kibbsuserbrg);
			if(isset($daftar_pegawai->id)) {
				$module = Module::get('Daftar_pegawais');
				$module->row = $daftar_pegawai;
				
				
				
				if($kdbidang == 99 || $kdbidang == 0 ){
						$kibbsuserbrg = Module::kibbadminbrg($id);
						return view('la.daftar_pegawais.show', [
						'module' => $module,
						'view_col' => $this->view_col,
						'no_header' => true,
						'kibbsuserbrg' => $kibbsuserbrg,
						'no_padding' => "no-padding"
					])->with('daftar_pegawai', $daftar_pegawai);
				}else{
						$kibbsuserbrg = Module::kibbuserbrg($id);
						return view('la.daftar_pegawais.show', [
						'module' => $module,
						'view_col' => $this->view_col,
						'no_header' => true,
						'kibbsuserbrg' => $kibbsuserbrg,
						'no_padding' => "no-padding"
					])->with('daftar_pegawai', $daftar_pegawai);
				}
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("daftar_pegawai"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified daftar_pegawai.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Daftar_pegawais", "edit")) {			
			$daftar_pegawai = Daftar_pegawai::find($id);
			$refrek0 = Module::populaterefbrg0()->where('rek0.kd_aset0','=',3)->get();
			$kond = Module::populaterefkondisi()->get();
			$kdbidang = Module::kdopd()->kd_bidang;
			$kdunit = Module::kdopd()->kd_unit;
			$kdsub = Module::kdopd()->kd_sub;
			$kdupb = Module::kdopd()->kd_upb;
			//$kibbsuserbrg = Module::kibbuserbrg($id);
			
			//dd($kibbsuserbrg);
			if(isset($daftar_pegawai->id)) {
						
				$module = Module::get('Daftar_pegawais');				
				$module->row = $daftar_pegawai;
				
				if($kdbidang == 99 || $kdbidang == 0 ){
					//$data = Module::kibbadmin($kdbidang,$kdunit,$kdsub,$kdupb,$idrek0,$idrek1,$idrek3,$idrek4,$kond);
					$kibbsuserbrg = Module::kibbadminbrg($id);					
					return view('la.daftar_pegawais.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
					'refrek0' => $refrek0,
					'kond' => $kond,
					'kdbidang' => $kdbidang,
					'kdunit' => $kdunit,
					'kdsub' => $kdsub,
					'kdupb' => $kdupb,
					'kibbsuserbrg' => $kibbsuserbrg
				])->with('daftar_pegawai', $daftar_pegawai);							
				}else{
					//$data = Module::kibbuserquery($kdbidang,$kdunit,$kdsub,$kdupb,$idrek0,$idrek1,$idrek3,$idrek4,$kond,$query);
					$kibbsuserbrg = Module::kibbuserbrg($id);
					return view('la.daftar_pegawais.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
					'refrek0' => $refrek0,
					'kond' => $kond,
					'kdbidang' => $kdbidang,
					'kdunit' => $kdunit,
					'kdsub' => $kdsub,
					'kdupb' => $kdupb,
					'kibbsuserbrg' => $kibbsuserbrg
				])->with('daftar_pegawai', $daftar_pegawai);	
				}
				
				
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("daftar_pegawai"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	public function imageupload(Request $request,$id,$idpemda){
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
	    $filePath = $request->file('file')->move('storage/imgkib/Image/', $fileName, 'public');
			
			$fileModel = new Image_kib;
            $fileModel->name = time().'_'.$request->file->getClientOriginalName();
            $fileModel->file_path = $filePath;
            $fileModel->nama_kib = "KIBB";
            $fileModel->save();
			
			/* $fileid = $idpemda;
			$fileid->imgid = $fileModel->id;
			$fileid->save(); */
			
			$data = " update kibbs set imgid = '".$fileModel->id."'					
							WHERE
								idpemda = '".$idpemda."'
							"
							;
			DB::statement($data);
            return back()
            ->with('success','File has been uploaded.')
            ->with('file', $fileName);
        }
   }
   
   
	public function updbrg($idpemda,$id0,$ids,$idss,$ids3,$ids4,$pemegang){
		$data = Module::updtbrg($idpemda,$id0,$ids,$idss,$ids3,$ids4,$pemegang);		
		return json_encode($data);	
	}
	public function delbrg(Request $request,$id){
		$data = Module::delbrg_pemegang($id);
		return json_encode($data);
	}
	
	public function showbarang(Request $request,$id,$kdbidang,$kdunit,$kdsub,$kdupb,$ids,$idss,$ids3,$ids4,$kond){

		$daftar_pegawai = Daftar_pegawai::find($id);
		//dd($ajuan_penghapusanpbp->id);
			
		if(Module::hasAccess("Daftar_pegawais", "view")) {
			$kdbidang = Module::kdopd()->kd_bidang;
			$kdunit = Module::kdopd()->kd_unit;
			$kdsub = Module::kdopd()->kd_sub;
			$kdupb = Module::kdopd()->kd_upb;
			$idrek0  = (int)$ids;
			$idrek1  = (int)$idss;
			$idrek3  = (int)$ids3;
			$idrek4  = (int)$ids4;
			//$kond = Module::populaterefkondisi()->get();
			//$tahun = (int)$thn;
			//$query = $request->get('query');
			//$data = Module::kibbuserquery($kdbidang,$kdunit,$kdsub,$kdupb,$idrek0,$idrek1,$idrek3,$idrek4,$kond,$query);
			//dd($kdbidang,$kdunit,$kdsub,$kdupb,$idrek0,$idrek1,$idrek3,$idrek4,$data,$query);
			//$data = Module::kibbuser($kdbidang,$kdunit,$kdsub,$kdupb,$idrek0,$idrek1,$idrek3,$idrek4,$kond);
			//$data = Module::kibbadmin($kdbidang,$kdunit,$kdsub,$kdupb,$idrek0,$idrek1,$idrek3,$idrek4,$kond);	
			//dd($daftar_pegawai->id);
			if ($request->ajax()) {
					//dd('0');				
					$output = '';
					$query = $request->get('query');
					if ($query != '') {							
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::kibbadmin($kdbidang,$kdunit,$kdsub,$kdupb,$idrek0,$idrek1,$idrek3,$idrek4,$kond);					
							//dd('1');							
						}else{
							$data = Module::kibbuserquery($kdbidang,$kdunit,$kdsub,$kdupb,$idrek0,$idrek1,$idrek3,$idrek4,$kond,$query);
							//dd('2');	
						}
					} else {						
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::kibbadmin($kdbidang,$kdunit,$kdsub,$kdupb,$idrek0,$idrek1,$idrek3,$idrek4,$kond);	
							//dd('3');	
							//dd($idrek0,$idrek1);
						}else{
							$data = Module::kibbuser($kdbidang,$kdunit,$kdsub,$kdupb,$idrek0,$idrek1,$idrek3,$idrek4,$kond);
							//dd('4');			
						}	
					}
					
					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index=>$row){
						    $index = $index+1;
						   if(Module::hasAccess("Daftar_pegawais", "edit")){
							$output .= '
							<tr>
							 <td>'.$index.'</td>
							  <div class="form-check form-check-inline">
							   <td>
							   <button id = "'.$row->idpemda.'" 
							   href="'.url(config('laraadmin.adminRoute') . '/updbrg/'.$row->idpemda.'/'.$idrek0.'/'.$idrek1.'/'.$idrek3.'/'.$idrek4.'/'.$daftar_pegawai->id).'" 
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
							 <td>'.$row -> Keterangan.'</td>							 
							</tr>';
						   }else{
							   $output .= '
							<tr>
							 <td>'.$index.'</td>
							 <td>'.$row -> dept.'</td>
							 <td>'.$row -> Uraian.'</td>							 
							 <td>'.$row -> Uraian_akhir.'</td>							 
							 <td>'.date('d-m-Y', strtotime($row->tgl_perolehan)).'</td>
							 <td>'.$row -> no_register.'</td>
							 <td>'.$row -> harga.'</td>
							 <td>'.$row -> nomor_polisi.'</td>
							 <td>'.$row -> merk.'</td>
							 <td>'.$row -> type.'</td>
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

	/**
	 * Update the specified daftar_pegawai in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Daftar_pegawais", "edit")) {
			
			$rules = Module::validateRules("Daftar_pegawais", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Daftar_pegawais", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.daftar_pegawais.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified daftar_pegawai from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Daftar_pegawais", "delete")) {
			Daftar_pegawai::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.daftar_pegawais.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax(Request $request,$kdbidangs,$kdunits,$kdsubs){
		if(Module::hasAccess("Daftar_pegawais", "view")) {
				
				$kdbidang = Module::kdopd()->kd_bidang;

			if ($request->ajax()) {
					$output = '';
					$query = $request->get('query');
					if ($query != '') {
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::pegawaiadminquery($query)->take(1)->get();
						}else{
							$data = Module::pegawaiuserquery($query)->take(1)->get();	
						}
					} else {
						if($kdbidang == 99 || $kdbidang == 0 ){
							//$data = Module::tanah()->take(10)->get();
							$data = Module::pegawaiadmin($kdbidangs,$kdunits,$kdsubs)->get();
							//dd($data);
						}else{
							
							$kdunit = Module::kdopd()->kd_unit;
							$kdsub = Module::kdopd()->kd_sub;
							$kdupb = Module::kdopd()->kd_upb;
							$data = Module::pegawaiuser($kdbidang,$kdunit,$kdsub,$kdupb)->get();
						}
					}
					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index=> $row){
						    $index = $index+1;
						   if(Module::hasAccess("Daftar_pegawais", "edit")){
							$output .= '
							<tr>
							 <td style="text-align:left;">'.$index.'</td>
							 <td>'.$row->depts.'</td>			
							 <td style="text-align:left;">'.$row->nip.'</td>
							 <td style="text-align:left;"><a target="_blank" href="'.url(config('laraadmin.adminRoute') . '/daftar_pegawais/'.$row->id).'">'.$row->nama.'</td>
							 <td style="text-align:left;">'.$row->jabatan.'</td>							
							 <td style="text-align:center;">
							 <a href="'.url(config('laraadmin.adminRoute') . '/printbrgpgw/'.$row->id).'" class="btn btn-outline-info btn-xs" style="display:inline;padding:2px 5px 3px 5px;" target="_blank"><i class="fa fa-print"></i></a>
							
							 <a href="'.url(config('laraadmin.adminRoute') . '/daftar_pegawais/'.$row->id.'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>							 
							 </td>
							</tr>';
						   }else{
							  
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
}
