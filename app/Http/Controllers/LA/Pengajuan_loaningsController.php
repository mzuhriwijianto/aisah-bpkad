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

use App\Models\Pengajuan_loaning;

class Pengajuan_loaningsController extends Controller
{
	public $show_action = true;
	public $view_col = 'idpemda';
	public $listing_cols = ['id', 'idpemda', 'alasan_peminjaman', 'peminjam', 'tgl_peminjaman', 'tgl_pengembalian', 'status', 'dept'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Pengajuan_loanings', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Pengajuan_loanings', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Pengajuan_loanings.
	 *
	 * @return \Illuminate\Http\Response
	 */
public function index(){
		$module = Module::get('Pengajuan_loanings');
		/* $kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$kdsub = Module::kdopd()->kd_sub;
		$kdupb = Module::kdopd()->kd_upb; */
		$kddept = Module::kddept()->id;
		$username = \Auth::user()->name;
		
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$kdsub = Module::kdopd()->kd_sub;
		$kdupb = Module::kdopd()->kd_upb;

		if($kdbidang == 99 || $kdbidang == 0 ){
			$notin = DB::select(DB::raw("SELECT pl.idpemda FROM pengajuan_loanings pl left join ".module::bmd().
							'.Ta_KIB_B as kibb'." on pl.idpemda = kibb.idpemda 
							WHERE (kibb.kd_hapus = 0 and 
							kibb.kd_pemilik = 12 and 
							kibb.kd_aset81 = 2 and 
							kibb.kd_aset82 = 2 and 
							kibb.kd_aset83 = 1 and
							pl.status = 1 ) OR
							(kibb.kd_hapus = 0 and 
							kibb.kd_pemilik = 12 and 
							kibb.kd_aset81 = 2 and 
							kibb.kd_aset82 = 2 and 
							kibb.kd_aset83 = 1 and
							pl.status = 0 )
							"));
		
					if(count($notin)>0){
						foreach ($notin as $notins) {
									$datanotin[] = $notins->idpemda;
								}
								$data = Module::kendaraanuser()
									->where([['kibb.kd_hapus','=',0],
											['kibb.kd_pemilik','=',12],
											['kibb.kd_aset81','=',2],
											['kibb.kd_aset82','=',2],
											['kibb.kd_aset83','=',1]
											])
									->whereNotIn('kibb.idpemda', $datanotin)
									->get();
					}else{
						$data = Module::kendaraanuser()
									->where([['kibb.kd_hapus','=',0],
											['kibb.kd_pemilik','=',12],
											['kibb.kd_aset81','=',2],
											['kibb.kd_aset82','=',2],
											['kibb.kd_aset83','=',1]
											])
									->get();
					}	
		 
		//dd(count($notin));
		}else{
			$notin = DB::select(DB::raw("SELECT pl.idpemda FROM pengajuan_loanings pl left join ".module::bmd().
							'.Ta_KIB_B as kibb'." on pl.idpemda = kibb.idpemda 
							WHERE (
							kibb.kd_bidang = ".$kdbidang." and
							kibb.kd_unit = ".$kdunit." and 
							kibb.kd_sub = ".$kdsub." and
							--kibb.kd_upb = ".$kdupb."
							kibb.kd_hapus = 0 and 
							kibb.kd_pemilik = 12 and 
							kibb.kd_aset81 = 2 and 
							kibb.kd_aset82 = 2 and 
							kibb.kd_aset83 = 1 and
							pl.status = 1 
							
							) 
							OR
							(
							kibb.kd_bidang = ".$kdbidang." and
							kibb.kd_unit = ".$kdunit." and 
							kibb.kd_sub = ".$kdsub." and
							--kibb.kd_upb = ".$kdupb." 
							kibb.kd_hapus = 0 and 
							kibb.kd_pemilik = 12 and 
							kibb.kd_aset81 = 2 and 
							kibb.kd_aset82 = 2 and 
							kibb.kd_aset83 = 1 and
							pl.status = 0 
							
							)
							"));
if(count($notin)>0){
	foreach ($notin as $notins) {
                $datanotin[] = $notins->idpemda;
            }
			$data = Module::kendaraanuser()
				->where([
						['kibb.kd_bidang','=',$kdbidang],
						['kibb.kd_unit','=',$kdunit],
						['kibb.kd_sub','=',$kdsub],
						//['kibb.kd_upb','=',$kdupb]
						['kibb.kd_hapus','=',0],
						['kibb.kd_pemilik','=',12],
						['kibb.kd_aset81','=',2],
						['kibb.kd_aset82','=',2],
						['kibb.kd_aset83','=',1]
						
						])
				->whereNotIn('kibb.idpemda', $datanotin)
				->get();
}else{
	foreach ($notin as $notins) {
                $datanotin[] = $notins->idpemda;
            }
			$data = Module::kendaraanuser()
				->where([
						['kibb.kd_bidang','=',$kdbidang],
						['kibb.kd_unit','=',$kdunit],
						['kibb.kd_sub','=',$kdsub],
						//['kibb.kd_upb','=',$kdupb]
						['kibb.kd_hapus','=',0],
						['kibb.kd_pemilik','=',12],
						['kibb.kd_aset81','=',2],
						['kibb.kd_aset82','=',2],
						['kibb.kd_aset83','=',1]
						])
				->get();
}
		 
		}
		if(Module::hasAccess($module->id)) {
			return View('la.pengajuan_loanings.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module,
				'username' => $username,
				'data' => $data
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new pengajuan_loaning.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created pengajuan_loaning in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request){
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$kdsub = Module::kdopd()->kd_sub;
		$kdupb = Module::kdopd()->kd_upb;
		$kddept = Module::kddept()->id;
		$userid = \Auth::user()->id;
		//$data = Module::kendaraanuserquery($query)->get();	
		if(Module::hasAccess("Pengajuan_loanings", "create")) {
						
			 $tglpengembalian = strtr($request->tgl_pengembalian, '/', '-');
			 $tglpeminjaman = strtr($request->tgl_peminjaman, '/', '-');
			 
			$pengajuan = new Pengajuan_loaning;
			$pengajuan->peminjam = $userid;
			$pengajuan->dept = $kddept;
			$pengajuan->idpemda = $request->idpemda;
			$pengajuan->alasan_peminjaman = $request->alasan_peminjaman;
			$pengajuan->tgl_peminjaman = date('Y-m-d', strtotime($tglpeminjaman));
			$pengajuan->tgl_pengembalian =  date('Y-m-d', strtotime($tglpengembalian));
			$pengajuan->status = 0;
			$pengajuan->save();
			
			return redirect()->route(config('laraadmin.adminRoute') . '.pengajuan_loanings.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified pengajuan_loaning.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Pengajuan_loanings", "view")) {
			
			$pengajuan_loaning = Pengajuan_loaning::find($id);
			if(isset($pengajuan_loaning->id)) {
				$module = Module::get('Pengajuan_loanings');
				$module->row = $pengajuan_loaning;
				
				return view('la.pengajuan_loanings.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('pengajuan_loaning', $pengajuan_loaning);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("pengajuan_loaning"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified pengajuan_loaning.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id){
		if(Module::hasAccess("Pengajuan_loanings", "edit")) {
				$kdbidang = Module::kdopd()->kd_bidang;
				$kdunit = Module::kdopd()->kd_unit;
				$kdsub = Module::kdopd()->kd_sub;
				$kdupb = Module::kdopd()->kd_upb;			
			$pengajuan_loaning = Pengajuan_loaning::find($id);
			$data = Module::kendaraanuser()
							->where([['kibb.kd_hapus','=',0],
								['kibb.kd_pemilik','=',12],
								['kibb.kd_aset81','=',2],
								['kibb.kd_aset82','=',2],
								['kibb.kd_aset83','=',1],
								['kibb.kd_bidang','=',$kdbidang],
								['kibb.kd_unit','=',$kdunit],
								['kibb.kd_sub','=',$kdsub]//,
								//['kibb.kd_upb','=',$kdupb]
								])
							->get();
			if(isset($pengajuan_loaning->id)) {	
				$module = Module::get('Pengajuan_loanings');
				
				$module->row = $pengajuan_loaning;
				
				return view('la.pengajuan_loanings.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
					'data' => $data
				])->with('pengajuan_loaning', $pengajuan_loaning);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("pengajuan_loaning"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified pengajuan_loaning in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id){
		if(Module::hasAccess("Pengajuan_loanings", "edit")) {
					 
			$tglpengembalian = strtr($request->tgl_pengembalian, '/', '-');
			$tglpeminjaman = strtr($request->tgl_peminjaman, '/', '-');
			 
			$pengajuan = Pengajuan_loaning::find($id);	
			$pengajuan->idpemda = $request->idpemda;
			$pengajuan->alasan_peminjaman = $request->alasan_peminjaman;
			$pengajuan->tgl_peminjaman = date('Y-m-d', strtotime($tglpeminjaman));
			$pengajuan->tgl_pengembalian =  date('Y-m-d', strtotime($tglpengembalian));
			$pengajuan->status = 0;
			$pengajuan->save();
			//dd($pengajuan->alasan_peminjaman,$pengajuan->tgl_peminjaman,$tglpengembalian);
			return redirect()->route(config('laraadmin.adminRoute') . '.pengajuan_loanings.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	public function verif_pengajuan_loan(Request $request, $id){
		if(Module::hasAccess("Pengajuan_loanings", "edit")) {
			
			$rules = Module::validateRules("Pengajuan_loanings", $request, true);			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Pengajuan_loanings", $request, $id);
			$update = Pengajuan_loaning::find($id);
			$update->status = 1;				
			$update->save();
			return redirect(config('laraadmin.adminRoute') .'/pengajuan_loanings');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	/**
	 * Remove the specified pengajuan_loaning from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Pengajuan_loanings", "delete")) {
			Pengajuan_loaning::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.pengajuan_loanings.index');
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
		if(Module::hasAccess("Pengajuan_loanings", "view")) {
				$kdbidang = Module::kdopd()->kd_bidang;
				$kdunit = Module::kdopd()->kd_unit;
				$kdsub = Module::kdopd()->kd_sub;
				$kdupb = Module::kdopd()->kd_upb;
				$kddept = Module::kddept()->id;

			if ($request->ajax()) {
					$output = '';
					$query = $request->get('query');
					if ($query != '') {							
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::pengajuanpinjam()
								->take(20)
								->get();
								
						}else{
							$data = Module::pengajuanpinjamuser()
								->take(20)
								->get();	
						}
					} else {						
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::pengajuanpinjamquery($query)
								->get();
						}else{
							$data = Module::pengajuanpinjamuserquery($query)
								->get();	
						}	
					}
					
					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index=>$row){
						    $index = $index+1;
						   if(Module::hasAccess("Pengajuan_loanings", "edit")){
							$output .= '
							<tr>
							 <td>'.$index.'</td>
							 <td>'.$row->dept.'</td>
							 <td>'.$row->user.'</td>
							 <td>'.$row->merk.'</td>
							 <td>'.$row->type.'</td>
							 <td><a href="'.url(config('laraadmin.adminRoute') . '/kendaraans/'.$row->id).'">'.$row->nomor_polisi.'</a></td>
							 <td>'.$row->nomor_bpkb.'</td>					 
							 <td>'.date('d-m-Y', strtotime($row->tax_date)).'</td>						 
							 <td>'.date('d-m-Y', strtotime($row->tgl_peminjaman)).'</td>						 
							 <td>'.date('d-m-Y', strtotime($row->tgl_pengembalian)).'</td>						 
							 <td>'.$row->owner.'</td>							 
							 <td><a href="'.url(config('laraadmin.adminRoute') . '/verif_pengajuan_loan/verif_loan/'.$row->id).'"'.(($row->status == 0) ? '<button type="button" class="btn btn-warning">Menunggu Verifikasi</button>' : (($row->status == 1) ? '<button type="button" class="btn btn-success">Telah Verifikasi</button>' :  '<button type="button" class="btn btn-primary">Telah Dikembalikan</button>')).'</a></td>	
							 <td>
							 <a href="'.url(config('laraadmin.adminRoute') . '/print/'.$row->id).'" class="btn btn-outline-info btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-print"></i></a>
							 <a href="'.url(config('laraadmin.adminRoute') . '/pengajuan_loanings/'.$row->id.'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>							 
							 </td>
							</tr>';
						   }else{
							   $output .= '
							<tr>
							 <td>'.$index.'</td>
							 <td>'.$row->dept.'</td>
							 <td>'.$row->user.'</td>
							 <td>'.$row->merk.'</td>
							 <td>'.$row->type.'</td>
							 <td><a href="'.url(config('laraadmin.adminRoute') . '/kendaraans/'.$row->id).'">'.$row->nomor_polisi.'</a></td>
							 <td>'.$row->nomor_bpkb.'</td>					 
							 <td>'.date('d-m-Y', strtotime($row->tax_date)).'</td>
							 <td>'.date('d-m-Y', strtotime($row->tgl_peminjaman)).'</td>						 
							 <td>'.date('d-m-Y', strtotime($row->tgl_pengembalian)).'</td>							 
							 <td>'.$row->owner.'</td>
							<td><a href="'.url(config('laraadmin.adminRoute') . '/verif_pengajuan_loan/verif_loan/'.$row->id).'"'.(($row->status == 0) ? '<button type="button" class="btn btn-warning" disabled>Menunggu Verifikasi</button>' : (($row->status == 1) ? '<button type="button" class="btn btn-success" disabled>Telah Verifikasi</button>' :  '<button type="button" class="btn btn-primary" disabled>Telah Dikembalikan</button>')).'</a></td>							 
							 <td>
							<a href="'.url(config('laraadmin.adminRoute') . '/pengajuan_loanings/'.$row->id.'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>
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
}
