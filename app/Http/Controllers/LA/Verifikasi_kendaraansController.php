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

use App\Models\Verifikasi_kendaraan;
use App\Models\Kibb;

class Verifikasi_kendaraansController extends Controller
{
	public $show_action = true;
	/* public $view_col = 'idpemda';
	public $listing_cols = ['id', 'idpemda']; */
	public $view_col = 'idpemda';
	public $listing_cols = ['id', 'idpemda', 'merk', 'type', 'cc', 'tgl_perolehan', 'no_rangka', 'no_mesin', 'nomor_polisi', 'nomor_bpkb', 'bpkb_file','stnk_file','photo'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Kendaraans', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Kendaraans', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Verifikasi_kendaraans.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
	if(Module::hasAccess("Verifikasi_kendaraans", "view")) {
		$module = Module::get('Verifikasi_kendaraans');
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$kdsub = Module::kdopd()->kd_sub;
		$kdupb = Module::kdopd()->kd_upb;
		/* dd($kdsub = Module::kdopd()->kd_sub); */
		if($kdbidang == 99 || $kdbidang == 0 ){
			$bpkbcount = DB::table('departments as dept')->leftjoin(Module::bmd().'.Ta_KIB_B as kibb',function ($join) {
									$join->on('dept.kd_bidang','=','kibb.kd_bidang')
											->on('dept.kd_unit','=','kibb.kd_unit')
											->on('dept.kd_sub','=','kibb.kd_sub')
											->on('dept.kd_upb','=','kibb.kd_upb');
									}
								)
					->leftjoin('kibbs','kibbs.idpemda','=','kibb.IDPemda')
					->leftjoin(DB::raw('(SELECT COUNT(kibb.kondisi) as kondisi,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb
												WHERE 
												kibb.kd_hapus = 0 and
												kibb.kd_pemilik = 12 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 2 and
												kibb.kd_aset83 = 1 and
												kibb.kondisi=3 
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)rusakberat'), 
												function ($joins){
												$joins->on('rusakberat.kd_bidang','=','dept.kd_bidang')
														->on('rusakberat.kd_unit','=','dept.kd_unit')
														->on('rusakberat.kd_sub','=','dept.kd_sub')
														->on('rusakberat.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibbs.verification_status) as verifdok,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_hapus = 0 and
												kibb.kd_pemilik = 12 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 2 and
												kibb.kd_aset83 = 1 and
												kibbs.verification_status = 1
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)verifikasidok'), 
												function ($joins){
												$joins->on('verifikasidok.kd_bidang','=','dept.kd_bidang')
														->on('verifikasidok.kd_unit','=','dept.kd_unit')
														->on('verifikasidok.kd_sub','=','dept.kd_sub')
														->on('verifikasidok.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibbs.verification_tax_status) as veriftax,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_hapus = 0 and
												kibb.kd_pemilik = 12 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 2 and
												kibb.kd_aset83 = 1 and
												kibbs.verification_tax_status = 1
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)verifikasitax'), 
												function ($joins){
												$joins->on('verifikasitax.kd_bidang','=','dept.kd_bidang')
														->on('verifikasitax.kd_unit','=','dept.kd_unit')
														->on('verifikasitax.kd_sub','=','dept.kd_sub')
														->on('verifikasitax.kd_upb','=','dept.kd_upb');
											}
								)
					->select('dept.kd_bidang','dept.kd_unit','dept.kd_sub','dept.kd_upb','dept.name',
										DB::raw('COUNT(kibbs.idpemda) as kendaraantot'),
										DB::raw('COUNT(kibb.nomor_bpkb) as nobpkbdiisi'),
										DB::raw('COUNT(kibb.nomor_rangka) as norangkadiisi'),
										DB::raw('COUNT(kibb.nomor_mesin) as nomesindiisi'),
										DB::raw('COUNT(kibbs.bpkb_file) as bpkbdiupload'),
										DB::raw('COUNT(kibbs.stnk_file) as stnkdiupload'),
										DB::raw('ISNULL(rusakberat.kondisi, 0 ) as rusakberat'),
										DB::raw('ISNULL(verifikasidok.verifdok, 0 ) as verifdok'),
										DB::raw('ISNULL(verifikasitax.veriftax, 0 ) as veriftax')
							)
					->where([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',2],
							['kibb.kd_aset83','=',1]
							])
					->groupBy('dept.kd_bidang','dept.kd_unit','dept.kd_sub','dept.kd_upb','dept.name',
								'rusakberat.kondisi','verifikasidok.verifdok','verifikasitax.veriftax')
					->orderBy('dept.kd_bidang','ASC')
					->orderBy('dept.kd_unit','ASC')
					->orderBy('dept.kd_sub','ASC')
					->orderBy('dept.kd_upb','ASC')
					->get();				
			$kendaraan = DB::table('kibbs')->leftjoin(Module::bmd().'.Ta_KIB_B as kibb','kibbs.idpemda','=','kibb.IDPemda')
					->select('kibbs.idpemda as count')
					->where([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',2],
							['kibb.kd_aset83','=',1]
							])				
					->count();
			 $bpkbempty = DB::table('kibbs')->leftjoin(Module::bmd().'.Ta_KIB_B as kibb','kibbs.idpemda','=','kibb.IDPemda')
					->select('kibbs.idpemda as count')			
					->whereNull('kibb.nomor_bpkb')				
					->where([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',2],
							['kibb.kd_aset83','=',1]
							])	
					->count();	
			$bpkbnotempty = DB::table('kibbs')->leftjoin(Module::bmd().'.Ta_KIB_B as kibb','kibbs.idpemda','=','kibb.IDPemda')
					->select('kibbs.idpemda as count')
					->whereNotNull('kibb.nomor_bpkb')
					->where([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',2],
							['kibb.kd_aset83','=',1]
							])
					->count();
			$kendaraanhapus = DB::table('kibbs')->leftjoin(Module::bmd().'.Ta_KIB_B as kibb','kibbs.idpemda','=','kibb.IDPemda')
						->select('kibbs.idpemda as count')
						->where([['kibb.kd_hapus','=',1],
								['kibb.kd_pemilik','=',12],
								['kibb.kd_aset81','=',2],
								['kibb.kd_aset82','=',2],
								['kibb.kd_aset83','=',1]
								])
						->count();									
		}else{
			$bpkbcount = DB::table('departments as dept')->leftjoin(Module::bmd().'.Ta_KIB_B as kibb',function ($join) {
									$join->on('dept.kd_bidang','=','kibb.kd_bidang')
											->on('dept.kd_unit','=','kibb.kd_unit')
											->on('dept.kd_sub','=','kibb.kd_sub')
											->on('dept.kd_upb','=','kibb.kd_upb');
									}
								)
					->leftjoin('kibbs','kibbs.idpemda','=','kibb.IDPemda')
					->leftjoin(DB::raw('(SELECT COUNT(kibb.kondisi) as kondisi,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb
												WHERE 
												kibb.kd_hapus = 0 and
												kibb.kd_pemilik = 12 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 2 and
												kibb.kd_aset83 = 1 and
												kibb.kondisi=3 
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)rusakberat'), 
												function ($joins){
												$joins->on('rusakberat.kd_bidang','=','dept.kd_bidang')
														->on('rusakberat.kd_unit','=','dept.kd_unit')
														->on('rusakberat.kd_sub','=','dept.kd_sub')
														->on('rusakberat.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibbs.verification_status) as verifdok,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_hapus = 0 and
												kibb.kd_pemilik = 12 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 2 and
												kibb.kd_aset83 = 1 and
												kibbs.verification_status = 1
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)verifikasidok'), 
												function ($joins){
												$joins->on('verifikasidok.kd_bidang','=','dept.kd_bidang')
														->on('verifikasidok.kd_unit','=','dept.kd_unit')
														->on('verifikasidok.kd_sub','=','dept.kd_sub')
														->on('verifikasidok.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibbs.verification_tax_status) as veriftax,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_hapus = 0 and
												kibb.kd_pemilik = 12 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 2 and
												kibb.kd_aset83 = 1 and
												kibbs.verification_tax_status = 1
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)verifikasitax'), 
												function ($joins){
												$joins->on('verifikasitax.kd_bidang','=','dept.kd_bidang')
														->on('verifikasitax.kd_unit','=','dept.kd_unit')
														->on('verifikasitax.kd_sub','=','dept.kd_sub')
														->on('verifikasitax.kd_upb','=','dept.kd_upb');
											}
								)
					->select('dept.kd_bidang','dept.kd_unit','dept.kd_sub','dept.kd_upb','dept.name',
										DB::raw('COUNT(kibbs.idpemda) as kendaraantot'),
										DB::raw('COUNT(kibb.nomor_bpkb) as nobpkbdiisi'),
										DB::raw('COUNT(kibb.nomor_rangka) as norangkadiisi'),
										DB::raw('COUNT(kibb.nomor_mesin) as nomesindiisi'),
										DB::raw('COUNT(kibbs.bpkb_file) as bpkbdiupload'),
										DB::raw('COUNT(kibbs.stnk_file) as stnkdiupload'),
										DB::raw('ISNULL(rusakberat.kondisi, 0 ) as rusakberat'),
										DB::raw('ISNULL(verifikasidok.verifdok, 0 ) as verifdok'),
										DB::raw('ISNULL(verifikasitax.veriftax, 0 ) as veriftax')
							)
					->where([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',2],
							['kibb.kd_aset83','=',1],
							['kibb.kd_bidang','=',$kdbidang],
							['kibb.kd_unit','=',$kdunit],
							['kibb.kd_sub','=',$kdsub],
							['kibb.kd_upb','=',$kdupb]
							])
					->groupBy('dept.kd_bidang','dept.kd_unit','dept.kd_sub','dept.kd_upb','dept.name',
								'rusakberat.kondisi','verifikasidok.verifdok','verifikasitax.veriftax')
					->get();
			$kendaraan = DB::table('kibbs')->leftjoin(Module::bmd().'.Ta_KIB_B as kibb','kibbs.idpemda','=','kibb.IDPemda')
				->select('kibbs.idpemda as count')			
				->where([['kibb.kd_hapus','=',0],
						['kibb.kd_pemilik','=',12],
						['kibb.kd_aset81','=',2],
						['kibb.kd_aset82','=',2],
						['kibb.kd_aset83','=',1],
						['kibb.kd_bidang','=',$kdbidang],
						['kibb.kd_unit','=',$kdunit],
						['kibb.kd_sub','=',$kdsub],
						['kibb.kd_upb','=',$kdupb]
						])				
				->count();
			 $bpkbempty = DB::table('kibbs')->leftjoin(Module::bmd().'.Ta_KIB_B as kibb','kibbs.idpemda','=','kibb.IDPemda')
					->select('kibbs.idpemda as count')			
					->whereNull('kibb.nomor_bpkb')				
					->where([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',2],
							['kibb.kd_aset83','=',1],
							['kibb.kd_bidang','=',$kdbidang],
							['kibb.kd_unit','=',$kdunit],
							['kibb.kd_sub','=',$kdsub],
							['kibb.kd_upb','=',$kdupb]
							])	
					->count();	
			$bpkbnotempty = DB::table('kibbs')->leftjoin(Module::bmd().'.Ta_KIB_B as kibb','kibbs.idpemda','=','kibb.IDPemda')
					->select('kibbs.idpemda as count')
					->whereNotNull('kibb.nomor_bpkb')				
					->where([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',2],
							['kibb.kd_aset83','=',1],
							['kibb.kd_bidang','=',$kdbidang],
							['kibb.kd_unit','=',$kdunit],
							['kibb.kd_sub','=',$kdsub],
							['kibb.kd_upb','=',$kdupb]
							])
					->count();
			$kendaraanhapus = DB::table('kibbs')->leftjoin(Module::bmd().'.Ta_KIB_B as kibb','kibbs.idpemda','=','kibb.IDPemda')
						->select('kibbs.idpemda as count')
						->where([['kibb.kd_hapus','=',1],
								['kibb.kd_pemilik','=',12],
								['kibb.kd_aset81','=',2],
								['kibb.kd_aset82','=',2],
								['kibb.kd_aset83','=',1],
								['kibb.kd_bidang','=',$kdbidang],
								['kibb.kd_unit','=',$kdunit],
								['kibb.kd_sub','=',$kdsub],
								['kibb.kd_upb','=',$kdupb]
								])
						->count();	
			
		}
			//dd($bpkbcount);
		if(Module::hasAccess($module->id)) {
			 return View('la.Verifikasi_kendaraans.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module,
				'bpkbcount' => $bpkbcount,
				'bpkbempty' => $bpkbempty,
				'bpkbnotempty' => $bpkbnotempty,
				'kendaraan' => $kendaraan,
				'kendaraanhapus' => $kendaraanhapus
			]);

		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}else{
		return view('errors.404');
	}
		
	}

	/**
	 * Show the form for creating a new verifikasi_kendaraan.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created verifikasi_kendaraan in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Verifikasi_kendaraans", "create")) {
		
			$rules = Module::validateRules("Verifikasi_kendaraans", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Verifikasi_kendaraans", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.verifikasi_kendaraans.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified verifikasi_kendaraan.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id){
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$kendaraan = Kibb::findOrFail($id);
		$cekuser = Module::showkendaraanuser($id)->get();		
		try {
		  if(Module::hasAccess("Verifikasi_kendaraans", "view")) {
			
				if($kdbidang == 99 || $kdbidang == 0 ){			
					$kendaraans = Module::showkendaraanadmin($id)->get();
				}else{
					$kendaraans = Module::showkendaraanuser($id)->get();
				}

				if(!empty($kendaraans)) {
					$module = Module::get('kendaraans');
					$module->row = $kendaraan;
					//dd($kendaraan->kd_bidang);
					//dd($kendaraans);
					return view('la.verifikasi_kendaraans.show', [
						'module' => $module,
						'kendaraans' => $kendaraans,
						'view_col' => $this->view_col,
						'no_header' => true,
						'no_padding' => "no-padding"
					])->with('kendaraan', $kendaraan);
				} else {
					return view(abort(403, 'Unauthorized action.'));
				}
			} else {
				return redirect(config('laraadmin.adminRoute')."/");
			}

		} catch (Illuminate\Database\QueryException $e) {
		  return view(abort(403, 'Unauthorized action.'));

		} catch (PDOException $e) {
		  return view(abort(403, 'Unauthorized action.'));
		}
	}

	/**
	 * Show the form for editing the specified verifikasi_kendaraan.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Verifikasi_kendaraans", "edit")) {			
			$verifikasi_kendaraan = Verifikasi_kendaraan::find($id);
			if(isset($verifikasi_kendaraan->id)) {	
				$module = Module::get('Verifikasi_kendaraans');
				
				$module->row = $verifikasi_kendaraan;
				
				return view('la.verifikasi_kendaraans.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('verifikasi_kendaraan', $verifikasi_kendaraan);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("verifikasi_kendaraan"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified verifikasi_kendaraan in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Verifikasi_kendaraans", "edit")) {
			
			$rules = Module::validateRules("Verifikasi_kendaraans", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Verifikasi_kendaraans", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.verifikasi_kendaraans.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified verifikasi_kendaraan from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Verifikasi_kendaraans", "delete")) {
			Verifikasi_kendaraan::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.verifikasi_kendaraans.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
/*Verif*/
public function verif($id){
		if(Module::hasAccess("Verifikasi_kendaraans", "edit")) {								
			$update = Kibb::find($id);			
            $update->verification_status	= 1;
            $update->verification_by   	 	= \Auth::user()->id;
            $update->verification_at    	= DB::raw("CONVERT (datetime, SYSDATETIME()) ");			
            $update->save();
			return redirect(config('laraadmin.adminRoute') .'/verifikasi_kendaraans#listsver');
			//dd($update);
		} else {
			//dd($update);
			return redirect(config('laraadmin.adminRoute').'/verifikasi_kendaraans#lists');
		}
	}
/*end*/

/*Verif Pajak*/
public function verifpajak($id){
		if(Module::hasAccess("Verifikasi_kendaraans", "edit")) {								
			$update = Kibb::find($id);			
            $update->verification_tax_status	= 1;
            $update->verification_tax_by   	 	= \Auth::user()->id;
            $update->verification_tax_at    	= DB::raw("CONVERT (datetime, SYSDATETIME()) ");			
            $update->save();
			return redirect(config('laraadmin.adminRoute') .'/verifikasi_kendaraans#listsver');
			//dd($update);
		} else {
			//dd($update);
			return redirect(config('laraadmin.adminRoute').'/verifikasi_kendaraans#lists');
		}
	}
/*end*/

/* load data kendaraan belum verif*/
public function loadDataNotverif(Request $request){
	if(Module::hasAccess("verifikasi_kendaraans", "view")) {
				$kdbidang = Module::kdopd()->kd_bidang;
				$kdunit = Module::kdopd()->kd_unit;
				$kdsub = Module::kdopd()->kd_sub;
				$kdupb = Module::kdopd()->kd_upb;

			if ($request->ajax()) {
					$output = '';
					$query = $request->get('query');
					if ($query != '') {
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::kendaraanadminquery($query)
									->whereNull('kibbs.verification_status')
									->WhereNotNull('kibbs.bpkb_file')																				
									->WhereNotNull('kibbs.stnk_file')																				
									->WhereNotNull('kibbs.photo')
									->orwhere([['kibbs.verification_status','=',0],
											['kibb.kd_hapus','=',0],
											['kibb.kd_pemilik','=',12],
											['kibb.kd_aset81','=',2],
											['kibb.kd_aset82','=',2],
											['kibb.kd_aset83','=',1]											
											])									
									->get();
						}
					} else {
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::kendaraan()
									->WhereNull('kibbs.verification_status')
									->WhereNotNull('kibbs.bpkb_file')																				
									->WhereNotNull('kibbs.stnk_file')																				
									->WhereNotNull('kibbs.photo')																				
									->orwhere([['kibbs.verification_status','=',0],
											['kibb.kd_hapus','=',0],
											['kibb.kd_pemilik','=',12],
											['kibb.kd_aset81','=',2],
											['kibb.kd_aset82','=',2],
											['kibb.kd_aset83','=',1]
											])
									->get();
						}
					}
					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index => $row){
						   $index = $index+1;
						   if(Module::hasAccess("verifikasi_kendaraans", "edit")){
							$output .= '
							<tr>
							 <td>'.$index.'</td>
							 <td>'.$row->Dept.'</td>
							 <td>'.$row->IDPemda.'</td>
							 <td>'.$row->merk.'</td>
							 <td>'.$row->type.'</td>
							 <td>'.$row->cc.'</td>
							 <td>'.$row->nomor_rangka.'</td>
							 <td>'.$row->nomor_mesin.'</td>
							 <td><a href="'.url(config('laraadmin.adminRoute') . '/verifikasi_kendaraans/'.$row->id).'">'.$row->nomor_polisi.'</a></td>
							 <td>'.$row->nomor_bpkb.'</td>
							 <td><a href="'.url('/files/'.$row->hashbpkb).'/'.$row->bpkb_file.'" target="_blank">'.(($row->idbpkb == '' OR $row->idbpkb == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>						 
							 <td><a href="'.url('/files/'.$row->hashstnk).'/'.$row->stnk_file.'" target="_blank">'.(($row->idstnk == ''  OR $row->idstnk == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td>'.date('d-m-Y', strtotime($row->tax_date)).'</td>
							 <td><a href="'.url('/files/'.$row->hashphoto).'/'.$row->photo.'" target="_blank">'.(($row->idphoto == ''  OR $row->idphoto == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td><a href="'.url('/files/'.$row->hashbast).'/'.$row->bast_pinjam.'" target="_blank">'.(($row->idbast == ''  OR $row->idbast == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td>'.$row->owner.'</td>
							 <td>'.(($row->verification_status == ''  OR $row->verification_status == 0) ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-primary btn-xs">').'</a></td>
							 <td>'.(($row->verification_tax_status == ''  OR $row->verification_tax_status == 0) ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-primary btn-xs">').'</a></td>
							 <td>
							 <a href="'.url(config('laraadmin.adminRoute') . '/verifikasi_kendaraans/verif/'.$row->id).'" class="btn btn-success btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-refresh"></i></a>
							 </td>
							 <td>
							 <a href="'.url(config('laraadmin.adminRoute') . '/verifikasi_kendaraans/verifpajak/'.$row->id).'" class="btn btn-success btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-refresh"></i></a>
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
/*end*/	
/* load data kendaraan sudah verif*/
public function loadDataverif(Request $request){
	if(Module::hasAccess("verifikasi_kendaraans", "view")) {
				$kdbidang = Module::kdopd()->kd_bidang;
				$kdunit = Module::kdopd()->kd_unit;
				$kdsub = Module::kdopd()->kd_sub;
				$kdupb = Module::kdopd()->kd_upb;

			if ($request->ajax()) {
					$output = '';
					$query = $request->get('query');
					if ($query != '') {
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::kendaraanadminquery($query)
									->WhereNotNull('kibbs.bpkb_file')																				
									->WhereNotNull('kibbs.stnk_file')																				
									->WhereNotNull('kibbs.photo')
									->where([['kibbs.verification_status','=',1],
											['kibb.kd_hapus','=',0],
											['kibb.kd_pemilik','=',12],
											['kibb.kd_aset81','=',2],
											['kibb.kd_aset82','=',2],
											['kibb.kd_aset83','=',1]
											])
									->take(10)
									->get();
						}
					} else {
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::kendaraan()
									->WhereNotNull('kibbs.bpkb_file')																				
									->WhereNotNull('kibbs.stnk_file')																				
									->WhereNotNull('kibbs.photo')
									->where([['kibbs.verification_status','=',1],
											['kibb.kd_hapus','=',0],
											['kibb.kd_pemilik','=',12],
											['kibb.kd_aset81','=',2],
											['kibb.kd_aset82','=',2],
											['kibb.kd_aset83','=',1]
											])
									->get();
						}
					}
					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index => $row){
						   $index = $index+1;
						   if(Module::hasAccess("verifikasi_kendaraans", "edit")){
							$output .= '
							<tr>
							 <td>'.$index.'</td>
							 <td>'.$row->Dept.'</td>
							 <td>'.$row->IDPemda.'</td>
							 <td>'.$row->merk.'</td>
							 <td>'.$row->type.'</td>
							 <td>'.$row->cc.'</td>
							 <td>'.$row->nomor_rangka.'</td>
							 <td>'.$row->nomor_mesin.'</td>
							 <td><a href="'.url(config('laraadmin.adminRoute') . '/verifikasi_kendaraans/'.$row->id).'">'.$row->nomor_polisi.'</a></td>
							 <td>'.$row->nomor_bpkb.'</td>
							 <td><a href="'.url('/files/'.$row->hashbpkb).'/'.$row->bpkb_file.'" target="_blank">'.(($row->idbpkb == '' OR $row->idbpkb == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>						 
							 <td><a href="'.url('/files/'.$row->hashstnk).'/'.$row->stnk_file.'" target="_blank">'.(($row->idstnk == ''  OR $row->idstnk == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td>'.date('d-m-Y', strtotime($row->tax_date)).'</td>
							 <td><a href="'.url('/files/'.$row->hashphoto).'/'.$row->photo.'" target="_blank">'.(($row->idphoto == ''  OR $row->idphoto == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							  <td><a href="'.url('/files/'.$row->hashbast).'/'.$row->bast_pinjam.'">'.(($row->idbast == ''  OR $row->idbast == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td>'.$row->owner.'</td>
							 <td>'.(($row->verification_status == ''  OR $row->verification_status == 0) ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-primary btn-xs">').'</a></td>
							 <td>'.(($row->verification_tax_status == ''  OR $row->verification_tax_status == 0) ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-primary btn-xs">').'</a></td>
							 <td>
							 <a href="'.url(config('laraadmin.adminRoute') . '/verifikasi_kendaraans/verif/'.$row->id).'" class="btn btn-success btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-refresh"></i></a>
							 </td>
							 <td>
							 <a href="'.url(config('laraadmin.adminRoute') . '/verifikasi_kendaraans/verifpajak/'.$row->id).'" class="btn btn-success btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-refresh"></i></a>
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
/*end*/	
	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
public function dtajax(){			

	}
}
