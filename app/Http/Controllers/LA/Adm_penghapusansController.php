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

use App\Models\Adm_penghapusan;
use App\Models\File_admphp;
class Adm_penghapusansController extends Controller
{
	public $show_action = true;
	public $view_col = 'no_surat';
	public $listing_cols = ['id', 'no_surat', 'tanggal_surat', 'pejabat', 'jenis_surat', 'surat'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Adm_penghapusans', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Adm_penghapusans', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Adm_penghapusans.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		$module = Module::get('Adm_penghapusans');
		$alasan = Module::populaterefalasan()->get();
		if(Module::hasAccess($module->id)) {
			return View('la.adm_penghapusans.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'alasan' => $alasan,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new adm_penghapusan.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created adm_penghapusan in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request){
		//dd($request->no_surat);
		if(Module::hasAccess("Adm_penghapusans", "create")) {
			$tglsurat = str_replace('/', '-', $request->tanggal_surat);
			$adm = new Adm_penghapusan;
			$adm->no_surat = $request->no_surat;
			$adm->tanggal_surat = date('Y-m-d', strtotime($tglsurat));
			$adm->pejabat = $request->pejabat;
			$adm->jenis_surat = $request->jenis_surat;
			$adm->kd_alasan = $request->kd_alasan;
			$adm->save();
			return redirect()->route(config('laraadmin.adminRoute') . '.adm_penghapusans.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified adm_penghapusan.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id){
		if(Module::hasAccess("Adm_penghapusans", "view")) {
			
			$adm_penghapusan = Adm_penghapusan::find($id);
			if(isset($adm_penghapusan->id)) {
				$module = Module::get('Adm_penghapusans');
				$module->row = $adm_penghapusan;
				
				return view('la.adm_penghapusans.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('adm_penghapusan', $adm_penghapusan);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("adm_penghapusan"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified adm_penghapusan.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id){
			
		if(Module::hasAccess("Adm_penghapusans", "edit")) {			
			$adm_penghapusan = Adm_penghapusan::find($id);
			
				
			if(isset($adm_penghapusan->id)) {	
				$module = Module::get('Adm_penghapusans');
				$data = Module::showbrgpbadminadmid($id);
				$datasum = Module::sumbrgpbadminadmid($id);
				$alasan = Module::populaterefalasan()->get();
				$module->row = $adm_penghapusan;
								
				//dd($data);
				return view('la.adm_penghapusans.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
					'data' => $data,
					'alasan' => $alasan,
					'datasum' => $datasum
				])->with('adm_penghapusan', $adm_penghapusan);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("adm_penghapusan"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified adm_penghapusan in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id){

		if(Module::hasAccess("Adm_penghapusans", "edit")) {
				$tglsurat = str_replace('/', '-', $request->tanggal_surat);
				
				$adm = $adm_penghapusan = Adm_penghapusan::find($id);
				$adm->no_surat = $request->no_surat;
				$adm->tanggal_surat = date('Y-m-d', strtotime($tglsurat));
				$adm->pejabat = $request->pejabat;
				$adm->jenis_surat = $request->jenis_surat;
				$adm->kd_alasan = $request->kd_alasan;
				$adm->save();
			
			$insert_id = Module::updateRow("Adm_penghapusans", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.adm_penghapusans.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified adm_penghapusan from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Adm_penghapusans", "delete")) {
			Adm_penghapusan::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.adm_penghapusans.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	public function fileupload(Request $request,$id){
	  $this->validate($request,[
        'file' => 'required|mimes:pdf|max:10000',
      ],
        $messages = [
            'required' => 'The :attribute field is required.',
            'mimes' => 'Only PDF are allowed.'
        ]
	  ); 
      
        if($request->file()) {
			$tglsurat = str_replace('/', '-', $request->tgl_surat);
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->move('storage/adm_php/file/', $fileName, 'public');
			
			$fileModel = new File_admphp;
			$fileModel->created_at = $tglsurat;
            $fileModel->name = time().'_'.$request->file->getClientOriginalName();
            $fileModel->file_path = $filePath;
            $fileModel->save();
			
			$fileid = Adm_penghapusan::findOrFail($id);
			$fileid->surat = $fileModel->id;		
			$fileid->save();
			
			return back()
            ->with('success','File has been uploaded.')
            ->with('file', $fileid->no_surat);
			
        }
   }
   public function fileuploadsk(Request $request,$id){
	  $this->validate($request,[
        'file' => 'required|mimes:pdf|max:10000',
      ],
        $messages = [
            'required' => 'The :attribute field is required.',
            'mimes' => 'Only PDF are allowed.'
        ]
	  ); 
      
        if($request->file()) {
			$tglsk = str_replace('/', '-', $request->tgl_sk_penghapusan);
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->move('storage/adm_php/sk/', $fileName, 'public');
			
			$executeupdate = DB::statement(DB::raw("
									  update fileadm set fileadm.name_sk = '".$fileName."',fileadm.file_path_sk = '".$filePath."'
									  from  
									  adm_penghapusans adm left join file_admphp fileadm on fileadm.id = adm.surat where adm.id = ".$id."
									"
									));			
			return back()
            ->with('success','File has been uploaded.')
            ->with('file', $fileName);
			
        }
   }
   
   public function fileuploadba(Request $request,$id){
	  $this->validate($request,[
        'file' => 'required|mimes:pdf|max:10000',
      ],
        $messages = [
            'required' => 'The :attribute field is required.',
            'mimes' => 'Only PDF are allowed.'
        ]
	  ); 
      
        if($request->file()) {
			$tglsk = str_replace('/', '-', $request->tgl_berita_acara);
            $fileName = time().'_'.$request->file->getClientOriginalName();
            $filePath = $request->file('file')->move('storage/adm_php/ba/', $fileName, 'public');
			
			$executeupdate = DB::statement(DB::raw("
									  update fileadm set fileadm.name_ba = '".$fileName."',fileadm.file_path_ba = '".$filePath."'
									  from  
									  adm_penghapusans adm left join file_admphp fileadm on fileadm.id = adm.surat where adm.id = ".$id."
									"
									));			
			return back()
            ->with('success','File has been uploaded.')
            ->with('file', $fileName);
			
        }
   }
	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax(Request $request){
		
		if(Module::hasAccess("Adm_penghapusans", "view")) {
			if ($request->ajax()) {
					$output = '';
					$query = $request->get('query');
					if ($query != '') {							
						$data = Module::getadmphpquery($query)
								->take(1)
								->get();
					} else {						
						$data = Module::getadmphp()
								->get();	
					}
					
					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index=>$row){
						    $index = $index+1;
							$output .= '
							<tr class="text-center">
							 <td>'.$index.'</td>
							 <td>'.$row->ur_alasan.'</td>
							 <td>'.$row->jenis_surat.'</td>
							 <td><a href="'.url(config('laraadmin.adminRoute') . '/adm_penghapusans/'.$row->admid).'">'.$row->no_surat.'</a></td>							 
							 <td>'.date('d-m-Y', strtotime($row->tanggal_surat)).'</td>
							 <td>'.$row->pejabat.'</td>
							 
							<td>
								<a target="_blank" href="'.url('/storage/adm_php/file/'.$row->name).'">'.(($row->surat == ''  OR $row->surat == 0) ? '<i class="fa fa-times btn-danger btn-sm" alt = "Preview"></i>': '<i class="fa fa-check btn-success btn-sm"></i>').'</a>
							</td>
							 <td>
							 <form action="/admin/adm_penghapusans/uploadfile/'.$row->admid.'" method="post" enctype="multipart/form-data">																					
							 <input name="_token" type="hidden" value="'.csrf_token().'">
								<div class="custom-file">
									<input type="file" name="file" class="custom-image-input" id="chooseFile">
								</div>
								<button type="submit" name="update" class="btn btn-primary btn-block mt-4">
									Update Files
								</button>
							 </form>
							 </td>
								
								 <td>'.$row->no_sk_penghapusan.'</td>
								<td>'.((($row->tgl_sk_penghapusan == '')  OR ($row->tgl_sk_penghapusan == '1970-01-01')) ? '<i class="fa fa-times btn-danger btn-sm" alt = "Blank"></i>': date('d-m-Y', strtotime($row->tgl_sk_penghapusan))).'</td>
								<td>
								 <form action="/admin/adm_penghapusans/uploadsk/'.$row->admid.'" method="post" enctype="multipart/form-data">																					
								 <input name="_token" type="hidden" value="'.csrf_token().'">
									<div class="custom-file">
										<input type="file" name="file" class="custom-image-input" id="chooseFile">
									</div>
									<button type="submit" name="update" class="btn btn-primary btn-block mt-4">
										Update Files
									</button>
								 </form>
								</td>
								<td>
									<a target="_blank" href="'.url('/storage/adm_php/sk/'.$row->name_sk).'">'.(($row->name_sk == ''  OR $row->name_sk == 0) ? '<i class="fa fa-times btn-danger btn-sm" alt = "Preview"></i>': '<i class="fa fa-check btn-success btn-sm"></i>').'</a>
								</td>
								 <td>'.$row->no_berita_acara.'</td>
								 <td>'.((($row->tgl_berita_acara == '')  OR ($row->tgl_berita_acara == '1970-01-01')) ? '<i class="fa fa-times btn-danger btn-sm" alt = "Blank"></i>': date('d-m-Y', strtotime($row->tgl_berita_acara))).'</td>
								 <td>
								 <form action="/admin/adm_penghapusans/uploadba/'.$row->admid.'" method="post" enctype="multipart/form-data">																					
								 <input name="_token" type="hidden" value="'.csrf_token().'">
									<div class="custom-file">
										<input type="file" name="file" class="custom-image-input" id="chooseFile">
									</div>
									<button type="submit" name="update" class="btn btn-primary btn-block mt-4">
										Update Files
									</button>
								 </form>
								</td>
								<td>
									<a target="_blank" href="'.url('/storage/adm_php/ba/'.$row->name_ba).'">'.(($row->name_ba == ''  OR $row->name_ba == 0) ? '<i class="fa fa-times btn-danger btn-sm" alt = "Preview"></i>': '<i class="fa fa-check btn-success btn-sm"></i>').'</a>
								</td>
								<td><a href="'.url(config('laraadmin.adminRoute') . '/adm_penghapusans/'.$row->admid.'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a></td>
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

	public function updatebrgadm(Request $request,$id,$idpemda){
		$adm_penghapusan = Adm_penghapusan::find($id);		
		$data = Module::updatebrgidphp($adm_penghapusan->id,$idpemda);
		return json_encode($data);
		
	}
	
	public function delbrgadm(Request $request,$idpemda){
		//$adm_penghapusan = Adm_penghapusan::find($id);		
		$data = Module::delbrgidphp($idpemda);
		return json_encode($data);
		
	}
	public function showbarang(Request $request,$id){
		$adm_penghapusan = Adm_penghapusan::find($id);
		//$data = Module::showbrgpbadminadm($adm_penghapusan->id);
		//dd($data);
		if(Module::hasAccess("Adm_penghapusans", "view")) {
			if ($request->ajax()) {
					$output = '';
					$query = $request->get('query');
					if ($query != '') {							
						$data = Module::showbrgpbadminadmquery($query)->take(1);
						//dd($data->get());
					} else {						
						$data = Module::showbrgpbadminadm($adm_penghapusan->id);	
					}
					
					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index=>$row){
						    $index = $index+1;
							$output .= '
							<tr class="text-center">
							 <td>'.$index.'</td>
							 <td>
								<div class="form-check form-check-inline">
								   <button id = "'.$row->idpemda.'" 
								   href="'.url(config('laraadmin.adminRoute') . '/updatebrgidphp/'.$adm_penghapusan->id.'/'.$row->idpemda).'" 
								   class="btn btn-primary" type="button" onclick = "getidpemda(this.id)" 
								   value = "'.$row->idpemda.'" enabled>Add</button>
								 </div>
							 </td>
							 <td>'.$row->idpemda.'</td>
							 <td>'.$row->dept.'</td>
							 <td>'.$row->Jenis_aset.'</td>
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
	
	/* public function alasan(){
		$al1 = Module::populaterefalasan()->pluck('kd_alasan', 'ur_alasan');
		return json_encode($al1);
	} */
	
	public function hapusbrgadm(Request $request,$id,$idpemda){
		$adm_penghapusan = Adm_penghapusan::find($id);		
		$data = Module::delbrgidphp($idpemda);
		return json_encode($data);
		
	}
	
	public function hapusbarangaset(Request $request,$id){
		$adm_penghapusan = Adm_penghapusan::find($id);		
		$data = Module::hapusbrg($id);
		return json_encode($data);
		
	}
}
