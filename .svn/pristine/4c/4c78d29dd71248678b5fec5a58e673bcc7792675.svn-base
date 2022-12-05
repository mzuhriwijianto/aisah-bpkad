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

use App\Models\Loaning;
use App\Models\Pengajuan_loaning;
use App\Models\Kibb;

class LoaningsController extends Controller
{
	public $show_action = true;
	public $view_col = 'loan_code';
	public $listing_cols = ['id', 'loan_code', 'idpemda'];
	//public $listing_cols = ['id', 'idpemda','nomor_polisi', 'nomor_bpkb','lend_date','lend_by','lend_phone','lend_verificator','lend_status'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Loanings', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Loanings', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Loanings.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Kibbs');
		
		if(Module::hasAccess($module->id)) {
			return View('la.loanings.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new loaning.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created loaning in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Loanings", "create")) {
		
			$rules = Module::validateRules("Loanings", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Loanings", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.loanings.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified loaning.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Loanings", "view")) {
			
			$loaning = Loaning::find($id);
			if(isset($loaning->id)) {
				$module = Module::get('Loanings');
				$module->row = $loaning;
				
				return view('la.loanings.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('loaning', $loaning);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("loaning"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified loaning.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id){
		if(Module::hasAccess("Loanings", "edit")) {			
			$loaning = Kibb::find($id);
				
			if(isset($loaning->id)) {	
				$module = Module::get('Kibbs');
				
				$module->row = $loaning;
				$data = DB::table('pengajuan_loanings as pl')->leftjoin('users as u','pl.peminjam','=','u.id')
									->join('departments as dept','pl.dept','=','dept.id')
									->join(module::bmd().'.Ta_KIB_B as kibb','pl.idpemda','=','kibb.idpemda')
									->join('kibbs','kibbs.idpemda','=','kibb.idpemda')
									->select('pl.id','dept.name as dept','u.name as user','kibb.merk',
											'kibb.type','kibb.idpemda','kibb.cc','kibb.nomor_polisi','kibb.nomor_bpkb',
											'kibbs.tax_date','kibbs.owner','pl.status','pl.tgl_peminjaman','pl.tgl_pengembalian')
									->where([['kibb.kd_hapus','=',0],
										['kibb.kd_pemilik','=',12],
										['kibb.kd_aset81','=',2],
										['kibb.kd_aset82','=',2],
										['kibb.kd_aset83','=',1],
										['kibb.idpemda','=',$loaning->idpemda]
										])
									->take(1)
									->get();
				//dd($data);
				return view('la.loanings.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
					'data' => $data
				])->with('loaning', $loaning);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("loaning"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	public function pengembalian($id){
		if(Module::hasAccess("Loanings", "edit")) {
			
			/* $rules = Module::validateRules("Loanings", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			} */
			$data = DB::table('kibbs')->leftjoin('pengajuan_loanings as pl','kibbs.idpemda','=','pl.IDPemda')
							->select('pl.idpemda')
							->where([['kibbs.lend_status','=','DIPINJAM'],['kibbs.id','=',$id]
								])->get();
			

			$update = Kibb::find($id);			
            $update->rack_no   			= null;
            $update->lend_by   			= null;
            $update->lend_phone   		= null;
            $update->lend_date 			= null;
            $update->lend_verificator 	= \Auth::user()->id;
            $update->lend_status 		= null;
            $update->lend_estimation 	=  DB::raw("GETDATE()");
			
			$pengajuan = DB::table('pengajuan_loanings')->where('idpemda', $data[0]->idpemda)->update(['status' => 2]);
			//dd($pengajuan);
			//$pengajuan->save();				
            $update->save();
			return redirect(config('laraadmin.adminRoute') .'/loanings#listspeminjaman');
			//dd($update);
		} else {
			//dd($update);
			return redirect(config('laraadmin.adminRoute').'/loanings#listspeminjaman');
		}
	}

	/**
	 * Update the specified loaning in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Loanings", "edit")) {
			
			$rules = Module::validateRules("Loanings", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
								
			$update = Kibb::find($id);			
            $update->rack_no   			=  null;
            $update->lend_by   			= $request->input('lend_by');
            $update->lend_phone   		= $request->input('lend_phone');
            $update->lend_date 			= date('Y-m-d');
            $update->lend_verificator 	= \Auth::user()->id;
            $update->lend_status 		= 'DIPINJAM';
            $update->lend_estimation 	=  date('Y-m-d', strtotime($request->input('lend_estimation')));
			
            $update->save();
			
			
			return redirect(config('laraadmin.adminRoute') .'/loanings#lists');
			
		} else {
			return redirect(config('laraadmin.adminRoute').'/loanings#lists');
		}
	}

	/**
	 * Remove the specified loaning from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Loanings", "delete")) {
			Loaning::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.loanings.index');
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
		if(Module::hasAccess("Loanings", "view")) {
				$kdbidang = Module::kdopd()->kd_bidang;
				$kdunit = Module::kdopd()->kd_unit;
				$kdsub = Module::kdopd()->kd_sub;
				$kdupb = Module::kdopd()->kd_upb;

			if ($request->ajax()) {
					$output = '';
					$query = $request->get('query');
					if ($query != '') {
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::peminjamanbpkbadminquery($query)
								->take(3)
								->get();
						}else{
							$data = Module::peminjamanbpkbuserquery($query)
								->take(3)
								->get();	
						}
					} else {
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::peminjamanbpkb()
								->take(10)
								->get();
						}else{
							$data = Module::peminjamanbpkbuser()
								->take(10)
								->get();	
						}
					}
					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index=>$row){
						    $index = $index+1;
						   if(Module::hasAccess("Loanings", "edit")){
							$output .= '
							<tr>
							 <td>'.$index.'</td>
							 <td>'.$row->Dept.'</td>
							 <td>'.$row->IDPemda.'</td>
							 <td>'.$row->merk.'</td>
							 <td>'.$row->type.'</td>
							 <td>'.$row->cc.'</td>
							 <td>'.$row->kondisi.'</td>
							 <td><a href="'.url(config('laraadmin.adminRoute') . '/kendaraans/'.$row->id).'">'.$row->nomor_polisi.'</a></td>
							 <td>'.$row->nomor_bpkb.'</td>
							 <td>'.$row->rack_no.'</td>
							 <td>'.$row->storage_name.'</td>						 
							 <td>'.date('d-m-Y', strtotime($row->tax_date)).'</td>						 
							 <td>'.$row->owner.'</td>						 
							 <td>'.date('d-m-Y', strtotime($row->lend_date)).'</td>							 
							 <td>'.$row->peminjam.'</td>						 
							 <td>'.$row->lend_phone.'</td>						 
							 <td>'.$row->lend_verificator.'</td>						 
							 <td>'.$row->lend_status.'</td>						 							 
							 <td>'.date('d-m-Y', strtotime($row->tgl_pengembalian)).'</td>						 							 
							 <td>
							 <a href="'.url(config('laraadmin.adminRoute') . '/print/'.$row->id).'" class="btn btn-outline-info btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-print"></i></a>
							 <a href="'.url(config('laraadmin.adminRoute') . '/loanings/'.$row->id.'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>							 
							 </td>
							</tr>';
						   }else{
							   $output .= '
							<tr>
							 <td>'.$index.'</td>
							 <td>'.$row->Dept.'</td>
							 <td>'.$row->IDPemda.'</td>
							 <td>'.$row->merk.'</td>
							 <td>'.$row->type.'</td>
							 <td>'.$row->cc.'</td>
							 <td>'.$row->kondisi.'</td>
							 <td><a href="'.url(config('laraadmin.adminRoute') . '/loanings/'.$row->id).'">'.$row->nomor_polisi.'</a></td>
							 <td>'.$row->nomor_bpkb.'</td>
							 <td>'.$row->rack_no.'</td>
							 <td>'.$row->storage_name.'</td>						 
							 <td>'.date('d-m-Y', strtotime($row->tax_date)).'</td>						 
							 <td>'.$row->owner.'</td>						 
							 <td>'.date('d-m-Y', strtotime($row->lend_date)).'</td>						 
							 <td>'.$row->lend_by.'</td>						 
							 <td>'.$row->lend_phone.'</td>						 
							 <td>'.$row->lend_verificator.'</td>						 
							 <td>'.$row->lend_status.'</td>
							<td>'.date('d-m-Y', strtotime($row->tgl_pengembalian)).'</td>							 
							 <td>
							<a href="'.url(config('laraadmin.adminRoute') . '/print/'.$row->id).'" class="btn btn-outline-info btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-print"></i></a>
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

				  echo json_encode($data);
			}
		}else{
			return view('errors.404');
		}
	}
	
	public function dtajaxdipinjam(Request $request){
		if(Module::hasAccess("Loanings", "view")) {
				$kdbidang = Module::kdopd()->kd_bidang;
				$kdunit = Module::kdopd()->kd_unit;
				$kdsub = Module::kdopd()->kd_sub;
				$kdupb = Module::kdopd()->kd_upb;

			if ($request->ajax()) {
					$output = '';
					$query = $request->get('query');
					if ($query != '') {
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::dipinjambpkbquery($query)
								->take(3)
								->get();
						}else{
							return view('errors.404');	
						}
					} else {
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::dipinjambpkb()
								->take(20)								
								->get();
								//dd($data);
						}else{
							return view('errors.404');	
						}
					}
					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index=>$row){
						    $index = $index+1;
						   if(Module::hasAccess("Loanings", "edit")){
							$output .= '
							<tr>
							 <td>'.$index.'</td>
							 <td>'.$row->Dept.'</td>
							 <td>'.$row->IDPemda.'</td>
							 <td>'.$row->merk.'</td>
							 <td>'.$row->type.'</td>
							 <td>'.$row->cc.'</td>
							 <td>'.$row->kondisi.'</td>
							 <td><a href="'.url(config('laraadmin.adminRoute') . '/kendaraans/'.$row->id).'">'.$row->nomor_polisi.'</a></td>
							 <td>'.$row->nomor_bpkb.'</td>
							 <td>'.$row->rack_no.'</td>
							 <td>'.$row->storage_name.'</td>						 
							 <td>'.date('d-m-Y', strtotime($row->tax_date)).'</td>						 
							 <td>'.$row->owner.'</td>						 
							 <td>'.$row->lend_date.'</td>						 
							 <td>'.$row->lend_by.'</td>						 
							 <td>'.$row->lend_phone.'</td>						 
							 <td>'.$row->lend_verificator.'</td>						 
							 <td>'.$row->lend_status.'</td>						 							 
							 <td>'.$row->lend_estimation.'</td>						 							 
							 <td>
							 <a href="'.url(config('laraadmin.adminRoute') . '/print/'.$row->id).'" class="btn btn-outline-info btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-print"></i></a>
							 <a href="'.url(config('laraadmin.adminRoute') . '/loanings/pengembalian/'.$row->id).'" class="btn btn-success btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-refresh"></i></a>							 
							 </td>
							</tr>';
						   }else{
							   $output .= '
							<tr>
							 <td>'.$index.'</td>
							 <td>'.$row->Dept.'</td>
							 <td>'.$row->IDPemda.'</td>
							 <td>'.$row->merk.'</td>
							 <td>'.$row->type.'</td>
							 <td>'.$row->cc.'</td>
							 <td>'.$row->kondisi.'</td>
							 <td><a href="'.url(config('laraadmin.adminRoute') . '/loanings/'.$row->id).'">'.$row->nomor_polisi.'</a></td>
							 <td>'.$row->nomor_bpkb.'</td>
							 <td>'.$row->rack_no.'</td>
							 <td>'.$row->storage_name.'</td>						 
							 <td>'.date('d-m-Y', strtotime($row->tax_date)).'</td>						 
							 <td>'.$row->owner.'</td>						 
							 <td>'.$row->lend_date.'</td>						 
							 <td>'.$row->lend_by.'</td>						 
							 <td>'.$row->lend_phone.'</td>						 
							 <td>'.$row->lend_verificator.'</td>						 
							 <td>'.$row->lend_status.'</td>
							 <td>'.$row->lend_estimation.'</td>								 
							 <td>
							<a href="'.url(config('laraadmin.adminRoute') . '/print/'.$row->id).'" class="btn btn-outline-info btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-print"></i></a>
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
					//dd($data);
				  echo json_encode($data);
			}
		}else{
			return view('errors.404');
		}
	}
}
