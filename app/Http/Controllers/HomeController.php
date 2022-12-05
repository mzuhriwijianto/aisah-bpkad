<?php
/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use DB;
use Validator;
use Datatables;
use Collective\Html\FormFacade as Form;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;
use Illuminate\Support\Facades\Response;
use PDF;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        $roleCount = \App\Role::count();
		if($roleCount != 0) {
			if($roleCount != 0) {
				return view('home');
			}
		} else {
			return view('errors.error', [
				'title' => 'Migration not completed',
				'message' => 'Please run command <code>php artisan db:seed</code> to generate required table data.',
			]);
		}
    }
	public function neraca(Request $request,$tahun){
		$data = DB::table('temp108')->where('tahun','like','%'.$tahun.'%')->get();
		$neraca = json_encode($data,true);
		$cektahun  = json_decode($neraca);
		$object = collect($data);
		$list = $object->pluck("tahun");
		//dd($cektahun);
		if(count($data) > 0){
			return response()->json($data); 
		}else{
			return Response::json(array(
                    'message'   =>  'Data Belum Dapat Ditampilkan'
                ), 401);
		}		
	}
		public function sert(Request $request,$tahun){
		//$data = DB::table('sertipikat_progress')->where('tahun','like','%'.$tahun.'%')->get();
		$data = DB::select(DB::raw(
				"
				select judul,keterangan,jml_bidang from sertipikat_prog where tahun = '".$tahun."' order by id
				"
		));
		$sertipikat = json_encode($data,true);
		$cektahun  = json_decode($sertipikat);
		$object = collect($data);
		$list = $object->pluck("tahun");
		//dd($cektahun);
		if(count($data) > 0){
			return response()->json($data); 
		}else{
			return Response::json(array(
                    'message'   =>  'Data Belum Dapat Ditampilkan'
                ), 401);
		}		
	}
	public function serts(Request $request){
		//$data = DB::table('sertipikat_progress')->where('tahun','like','%'.$tahun.'%')->get();
		$data = DB::select(DB::raw(
				"
				select judul,keterangan,jml_bidang from sertipikat_prog order by id
				"
		));
		$sertipikat = json_encode($data,true);
		$cektahun  = json_decode($sertipikat);
		$object = collect($data);
		
		//dd($cektahun);
		if(count($data) > 0){
			return response()->json($data); 
		}else{
			return Response::json(array(
                    'message'   =>  'Data Belum Dapat Ditampilkan'
                ), 401);
		}		
	}
	public function gedung(Request $request,$tahun){
		//$data = DB::table('sertipikat_progress')->where('tahun','like','%'.$tahun.'%')->get();
		$data = DB::select(DB::raw(
				"
				SELECT top(100) percent COUNT(kibc.IDPemda) AS Jumlah, kibc.Kd_Aset8, kibc.Kd_Aset80, kibc.Kd_Aset81, kibc.Kd_Aset82, 
					  rek2.Nm_Aset2, kibc.Kd_Aset83, kibc.Kd_Aset84, kibc.Kd_Aset85, rek5.Nm_Aset5, SUM(fnkibc.Harga) AS TotalHarga, 
					  YEAR(kibc.Tgl_Perolehan) AS TahunPerolehan
				FROM         ".Module::bmd().".ta_kib_c kibc LEFT OUTER JOIN
							 ".Module::bmd().".Ref_Rek5_108 rek5 ON kibc.Kd_Aset8 = rek5.Kd_Aset AND kibc.Kd_Aset80 = rek5.Kd_Aset0 AND 
																  kibc.Kd_Aset81 = rek5.Kd_Aset1 AND kibc.Kd_Aset82 = rek5.Kd_Aset2 AND kibc.Kd_Aset83 = rek5.Kd_Aset3 AND 
																  kibc.Kd_Aset84 = rek5.Kd_Aset4 AND kibc.Kd_Aset85 = rek5.Kd_Aset5 LEFT OUTER JOIN
							 ".Module::bmd().".Ref_Rek2_108 rek2 ON kibc.Kd_Aset8 = rek2.Kd_Aset AND kibc.Kd_Aset80 = rek2.Kd_Aset0 AND 
							 kibc.Kd_Aset81 = rek2.Kd_Aset1 AND kibc.Kd_Aset82 = rek2.Kd_Aset2 LEFT OUTER JOIN
							 ".Module::bmd().".Ref_UPB refupb ON kibc.Kd_Bidang = refupb.Kd_Bidang AND kibc.Kd_Unit = refupb.Kd_Unit AND kibc.Kd_Sub = refupb.Kd_Sub AND 
							 kibc.Kd_UPB = refupb.Kd_UPB LEFT OUTER JOIN
							 ".Module::bmd().".Ref_Unit refunit ON kibc.Kd_Bidang = refunit.Kd_Bidang AND kibc.Kd_Unit = refunit.Kd_Unit left join
							 ".Module::bmd().".Ta_Fn_KIB_C fnkibc on fnkibc.IDPemda = kibc.idpemda
				WHERE     (kibc.Kondisi <> '3') AND (kibc.Kd_Data <> 3) AND (kibc.Kd_Pemilik = 12) and (Kd_Hapus = 0) and fnkibc.Tahun = '".$tahun."'
				GROUP BY kibc.Kd_Bidang, kibc.Kd_Unit, refunit.Nm_Unit, kibc.Kd_Sub, kibc.Kd_UPB, refupb.Nm_UPB, kibc.Kd_Aset8, 
									  kibc.Kd_Aset80, kibc.Kd_Aset81, kibc.Kd_Aset82, rek2.Nm_Aset2, kibc.Kd_Aset83, kibc.Kd_Aset84, kibc.Kd_Aset85, 
									  rek5.Nm_Aset5, YEAR(kibc.Tgl_Perolehan)
				HAVING      (kibc.Kd_Aset80 = 3) AND (kibc.Kd_Aset81 = 3) AND (kibc.Kd_Aset82 = 1) AND (kibc.Kd_Aset8 = 1) 
				ORDER BY TahunPerolehan
				"
		));
		
		$sertipikat = json_encode($data,true);
		$cektahun  = json_decode($sertipikat);
		$object = collect($data);
		
		//dd($cektahun);
		if(count($data) > 0){
			return response()->json($data); 
		}else{
			return Response::json(array(
                    'message'   =>  'Data Belum Dapat Ditampilkan'
                ), 401);
		}		
	}
	
	public function check_kibb($idpemda){
			
			$count = Module::kibbcheck($idpemda);
			//dd($count);
			if(isset($count[0]->idpemda)) {				
					$check = $count;					
					return view('kibbcheck', [
					'check' => $check
				]);								
			} else {
				return redirect(config('laraadmin.adminRoute')."/");
			}

	}
}