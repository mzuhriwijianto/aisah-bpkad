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
use PDF;
use App\Models\Rack;
use App\Models\Kendaraan;
use App\Models\Kibb;
//use DIGSIG;


class RacksController extends Controller
{
	public $show_action = true;
	public $view_col = 'rack_name';
	public $view_col_kendaraan = 'idpemda';
	public $listing_cols = ['id', 'rack_code', 'rack_name', 'storage'];
	public $listing_cols_kendaraan = ['id', 'idpemda', 'merk', 'type', 'cc', 'tgl_perolehan', 'nomor_rangka', 'nomor_mesin', 'nomor_polisi', 'nomor_bpkb', 'bpkb_file','rack_no', 'storage_no','stnk_file','photo'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Racks', $this->listing_cols);
				$this->listing_cols_kendaraan = ModuleFields::listingColumnAccessScan('Kibbs', $this->listing_cols_kendaraan);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Racks', $this->listing_cols);
			$this->listing_cols_kendaraan = ModuleFields::listingColumnAccessScan('Kibbs', $this->listing_cols_kendaraan);
		}
	}
	public function digsig(Request $request){
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$query = explode(",", $request->get('searchsolo'));

		if(Module::hasAccess("Kendaraans", "view")) {		
			if($kdbidang == 99 || $kdbidang == 0 ){	
				if($request->get('searchsolo') == ""){
					$kendaraans = Module::kendaraanadmin()
								->get();					
					$kendaraanarray = json_decode(json_encode($kendaraans), true);
				    $pdf = new PDF;
					$pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
							->loadView('la.report.bcdsolo',['kendaraans' => $kendaraans])
							->setPaper('folio', 'potrait');
					return $pdf->stream('KIB-Kendaraan_'.Module::userlogin()->dept_name.'.pdf');
				}else{
					$kendaraans = Module::kendaraanadmin($query)
								->get();				
					$kendaraanarray = json_decode(json_encode($kendaraans), true);
					$pdf = new PDF;
					$pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
							->loadView('la.report.bcdsolo',['kendaraans' => $kendaraans])
							->setPaper('folio', 'potrait');
					return $pdf->stream('KIB-Kendaraan_'.Module::userlogin()->dept_name.'.pdf');														
				}	
					
			}else{
				if($request->get('searchsolo') == ""){					
					$kendaraans = Module::kendaraanuser()->get();
					$kendaraanarray = json_decode(json_encode($kendaraans), true);
					$pdf = new PDF;
				    $pdf = PDF::setOptions(['isPhpEnabled' => true, 'isRemoteEnabled' => true])
							->loadView('la.report.bcdsolo',['kendaraans' => $kendaraans])
							->setPaper('folio', 'potrait');
					
					return $pdf->stream('KIB-Kendaraan_'.Module::userlogin()->dept_name.'.pdf');
				}else{
					$kendaraans = Module::kendaraanuserquerysolo($query)
							->get();
					$kendaraanarray = json_decode(json_encode($kendaraans), true);
					$pdf = new PDF;
				    $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
							->loadView('la.report.bcdsolo',['kendaraans' => $kendaraans])
							->setPaper('folio', 'potrait');
					return $pdf->stream('KIB-Kendaraan_'.Module::userlogin()->dept_name.'.pdf');			
				}
			}
		}else{
			return view(abort(403, 'Unauthorized action.'));
		}		 
	}

	/* public function digsig(Request $request){
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$query = explode(",", $request->get('searchsolo'));

		if(Module::hasAccess("Kendaraans", "view")) {		
			if($kdbidang == 99 || $kdbidang == 0 ){	
				if($request->get('searchsolo') == ""){
					$kendaraans = Module::kendaraanadmin()
								->get();					
					$kendaraanarray = json_decode(json_encode($kendaraans), true);
				    $pdf = new PDF;
					$pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
							->loadView('la.report.bcdsolo',['kendaraans' => $kendaraans])
							->setPaper('folio', 'potrait');
					return $pdf->stream('KIB-Kendaraan_'.Module::userlogin()->dept_name.'.pdf');
				}else{
					$kendaraans = Module::kendaraanadmin($query)
							->get();
					$kendaraanarray = json_decode(json_encode($kendaraans), true);
					$pdf = new PDF;
				    $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
							->loadView('la.report.bcdsolo',['kendaraans' => $kendaraans])
							->setPaper('folio', 'potrait');
					return $pdf->stream('KIB-Kendaraan_'.Module::userlogin()->dept_name.'.pdf');
					/* // set certificate file
						$certificate = 'file:/'.base_path().'/public/cert/gilang-java.pfx';
						//$certificate = 'file:///C:/xampp/htdocs/AISAH6/public/cert/gilang-java.crt';
						
						//dd(base_path());
					// set additional information in the signature
						$info = array(
							'Name' => 'Gilang',
							'Location' => 'Office',
							'Reason' => 'Testing TCPDF',
							'ContactInfo' => 'http://www.tcpdf.org',
						);

						// set document signature
						DIGSIG::setSignature($certificate, $certificate, '123456', '', 2, $info);
						//setSignature($signing_cert='', $private_key='', $private_key_password='', $extracerts='', $cert_type=2, $info=array(), $approval='') {

						DIGSIG::SetFont('helvetica', '', 12);
						DIGSIG::SetTitle('Hello World');
						DIGSIG::AddPage();

						// print a line of text
						$text = view('la.report.digitalsignature');

						// add view content
						DIGSIG::writeHTML($text, true, 0, true, 0);

						// add image for signature
						DIGSIG::Image('tcpdf.png', 180, 60, 15, 15, 'PNG');

						// define active area for signature appearance
						DIGSIG::setSignatureAppearance(180, 60, 15, 15);

						// save pdf file
						DIGSIG::Output(public_path('hello_world.pdf'), 'F');

						DIGSIG::reset();

						dd('pdf created'); */
/* 				}	
					
			}else{
				if($request->get('searchsolo') == ""){					
					$kendaraans = Module::kendaraanuser()->get();
					$kendaraanarray = json_decode(json_encode($kendaraans), true);
					$pdf = new PDF;
				    $pdf = PDF::setOptions(['isPhpEnabled' => true, 'isRemoteEnabled' => true])
							->loadView('la.report.bcdsolo',['kendaraans' => $kendaraans])
							->setPaper('folio', 'potrait');
					
					return $pdf->stream('KIB-Kendaraan_'.Module::userlogin()->dept_name.'.pdf');
				}else{
					$kendaraans = Module::kendaraanuserquerysolo($query)
							->get();
					$kendaraanarray = json_decode(json_encode($kendaraans), true);
					$pdf = new PDF;
				    $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
							->loadView('la.report.bcdsolo',['kendaraans' => $kendaraans])
							->setPaper('folio', 'potrait');
					return $pdf->stream('KIB-Kendaraan_'.Module::userlogin()->dept_name.'.pdf');			
				}
			}
		}else{
			return view(abort(403, 'Unauthorized action.'));
		}		 
	}  */

	public function bcdsolo(Request $request){
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$query = explode(",", $request->get('searchsolo'));

		if(Module::hasAccess("Kendaraans", "view")) {		
			if($kdbidang == 99 || $kdbidang == 0 ){	
				if($request->get('searchsolo') == ""){
					$kendaraans = Module::kendaraanadmin()
								->get();					
					$kendaraanarray = json_decode(json_encode($kendaraans), true);
				    $pdf = new PDF;
					$pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
							->loadView('la.report.bcdsolo',['kendaraans' => $kendaraans])
							->setPaper('folio', 'potrait');
					return $pdf->stream('KIB-Kendaraan_'.Module::userlogin()->dept_name.'.pdf');
				}else{
					$kendaraans = Module::kendaraanadminquerysolo($query)
								  ->get();
					$kendaraanarray = json_decode(json_encode($kendaraans), true);
					$pdf = new PDF;
				    $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
							->loadView('la.report.bcdsolo',['kendaraans' => $kendaraans])
							->setPaper('folio', 'potrait');
					return $pdf->stream('KIB-Kendaraan_'.Module::userlogin()->dept_name.'.pdf');
				}	
					
			}else{
				if($request->get('searchsolo') == ""){					
					$kendaraans = Module::kendaraanuser()->get();
					$kendaraanarray = json_decode(json_encode($kendaraans), true);
					$pdf = new PDF;
				    $pdf = PDF::setOptions(['isPhpEnabled' => true, 'isRemoteEnabled' => true])
							->loadView('la.report.bcdsolo',['kendaraans' => $kendaraans])
							->setPaper('folio', 'potrait');
					
					return $pdf->stream('KIB-Kendaraan_'.Module::userlogin()->dept_name.'.pdf');
				}else{
					$kendaraans = Module::kendaraanuserquerysolo($query)
							->get();
					$kendaraanarray = json_decode(json_encode($kendaraans), true);
					$pdf = new PDF;
				    $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
							->loadView('la.report.bcdsolo',['kendaraans' => $kendaraans])
							->setPaper('folio', 'potrait');
					return $pdf->stream('KIB-Kendaraan_'.Module::userlogin()->dept_name.'.pdf');			
				}
			}
		}else{
			return view(abort(403, 'Unauthorized action.'));
		}		 
	}
	public function loadDataracksKendaraan(Request $request){
	if(Module::hasAccess("Racks", "view")) {
				$kdbidang = Module::kdopd()->kd_bidang;
				$kdunit = Module::kdopd()->kd_unit;
				$kdsub = Module::kdopd()->kd_sub;
				$kdupb = Module::kdopd()->kd_upb;

			if ($request->ajax()) {
					$output = '';
					$query = $request->get('query');
					if ($query != '') {
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = DB::table('kibbs')->leftjoin(Module::bmd().'.Ta_KIB_B as kibb','kibbs.idpemda','=','kibb.IDPemda')
							->leftjoin('racks','racks.id','=','kibbs.rack_no')
							->leftjoin('storages','storages.id','=','racks.storage')
							->leftjoin('uploads as uploadstnk','uploadstnk.id','=','kibbs.stnk_file')
							->leftjoin('uploads as uploadphoto','uploadphoto.id','=','kibbs.photo')
							->leftjoin('uploads as uploadbpkb','uploadbpkb.id','=','kibbs.photo')
							->leftjoin('departments as dept', function ($join) {
									$join->on('dept.kd_bidang','=','kibb.kd_bidang')
											->on('dept.kd_unit','=','kibb.kd_unit')
											->on('dept.kd_sub','=','kibb.kd_sub')
											->on('dept.kd_upb','=','kibb.kd_upb');
								}
							)
							->leftjoin(Module::bmd().'.ref_kondisi as kond','kond.kd_kondisi','=','kibb.kondisi')
							->select('kibbs.id','dept.name as Dept','kibbs.IDPemda','kibb.merk','kibb.type','kibb.cc','kibb.bahan','kond.Uraian as kondisi',
							'kibb.tgl_perolehan','kibb.nomor_rangka',
							'kibb.nomor_mesin','kibb.nomor_polisi',
							'kibb.nomor_bpkb','uploadbpkb.name as bpkb_file','uploadbpkb.hash as hashbpkb','kibbs.bpkb_file as idbpkb',
							'kibbs.rack_no','storages.storage_name',
							'uploadstnk.name as stnk_file','uploadstnk.hash as hashstnk','kibbs.stnk_file as idstnk',
							'uploadphoto.name as photo','uploadphoto.hash as hashphoto','kibbs.photo as idphoto','kibbs.owner')
							->where([['kibb.kd_hapus','=',0],
								['kibb.kd_pemilik','=',12],
								['kibb.kd_aset81','=',2],
								['kibb.kd_aset82','=',2],
								['kibb.kd_aset83','=',1],
								['kibb.nomor_polisi','LIKE','%'.$query.'%']
								])
							->orwhere([['kibb.kd_hapus','=',0],
								['kibb.kd_pemilik','=',12],
								['kibb.kd_aset81','=',2],
								['kibb.kd_aset82','=',2],
								['kibb.kd_aset83','=',1],
								['kibb.nomor_bpkb','LIKE','%'.$query.'%']
								])
						->take(1)
						->get();
						}else{
							$data = DB::table('kibbs')->leftjoin(Module::bmd().'.Ta_KIB_B as kibb','kibbs.idpemda','=','kibb.IDPemda')
							->leftjoin('racks','racks.id','=','kibbs.rack_no')
							->leftjoin('storages','storages.id','=','racks.storage')
							->leftjoin('uploads as uploadstnk','uploadstnk.id','=','kibbs.stnk_file')
							->leftjoin('uploads as uploadphoto','uploadphoto.id','=','kibbs.photo')
							->leftjoin('uploads as uploadbpkb','uploadbpkb.id','=','kibbs.photo')
							->leftjoin('departments as dept', function ($join) {
									$join->on('dept.kd_bidang','=','kibb.kd_bidang')
											->on('dept.kd_unit','=','kibb.kd_unit')
											->on('dept.kd_sub','=','kibb.kd_sub')
											->on('dept.kd_upb','=','kibb.kd_upb');
								}
							)
							->leftjoin(Module::bmd().'.ref_kondisi as kond','kond.kd_kondisi','=','kibb.kondisi')
							->select('kibbs.id','dept.name as Dept','kibbs.IDPemda','kibb.merk','kibb.type','kibb.cc','kibb.bahan','kond.Uraian as kondisi',
							'kibb.tgl_perolehan','kibb.nomor_rangka',
							'kibb.nomor_mesin','kibb.nomor_polisi',
							'kibb.nomor_bpkb','uploadbpkb.name as bpkb_file','uploadbpkb.hash as hashbpkb','kibbs.bpkb_file as idbpkb',
							'kibbs.rack_no','storages.storage_name',
							'uploadstnk.name as stnk_file','uploadstnk.hash as hashstnk','kibbs.stnk_file as idstnk',
							'uploadphoto.name as photo','uploadphoto.hash as hashphoto','kibbs.photo as idphoto','kibbs.owner')
							->where([['kibb.kd_hapus','=',0],
								['kibb.kd_pemilik','=',12],
								['kibb.kd_aset81','=',2],
								['kibb.kd_aset82','=',2],
								['kibb.kd_aset83','=',1],
								['kibb.nomor_polisi','LIKE','%'.$query.'%']
								])
							->orwhere([['kibb.kd_hapus','=',0],
								['kibb.kd_pemilik','=',12],
								['kibb.kd_aset81','=',2],
								['kibb.kd_aset82','=',2],
								['kibb.kd_aset83','=',1],
								['kibb.nomor_bpkb','LIKE','%'.$query.'%']
								])
						->take(1)
						->get();	
						}
					} else {
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = DB::table('kibbs')->leftjoin(Module::bmd().'.Ta_KIB_B as kibb','kibbs.idpemda','=','kibb.IDPemda')
							->leftjoin('racks','racks.id','=','kibbs.rack_no')
							->leftjoin('storages','storages.id','=','racks.storage')
							->leftjoin('uploads as uploadstnk','uploadstnk.id','=','kibbs.stnk_file')
							->leftjoin('uploads as uploadphoto','uploadphoto.id','=','kibbs.photo')
							->leftjoin('uploads as uploadbpkb','uploadbpkb.id','=','kibbs.photo')
							->leftjoin('departments as dept', function ($join) {
									$join->on('dept.kd_bidang','=','kibb.kd_bidang')
											->on('dept.kd_unit','=','kibb.kd_unit')
											->on('dept.kd_sub','=','kibb.kd_sub')
											->on('dept.kd_upb','=','kibb.kd_upb');
								}
							)
							->leftjoin(Module::bmd().'.ref_kondisi as kond','kond.kd_kondisi','=','kibb.kondisi')
							->select('kibbs.id','dept.name as Dept','kibbs.IDPemda','kibb.merk','kibb.type','kibb.cc','kibb.bahan','kond.Uraian as kondisi',
							'kibb.tgl_perolehan','kibb.nomor_rangka',
							'kibb.nomor_mesin','kibb.nomor_polisi',
							'kibb.nomor_bpkb','uploadbpkb.name as bpkb_file','uploadbpkb.hash as hashbpkb','kibbs.bpkb_file as idbpkb',
							'kibbs.rack_no','storages.storage_name',
							'uploadstnk.name as stnk_file','uploadstnk.hash as hashstnk','kibbs.stnk_file as idstnk',
							'uploadphoto.name as photo','uploadphoto.hash as hashphoto','kibbs.photo as idphoto','kibbs.owner')
							->where([['kibb.kd_hapus','=',0],
								['kibb.kd_pemilik','=',12],
								['kibb.kd_aset81','=',2],
								['kibb.kd_aset82','=',2],
								['kibb.kd_aset83','=',1]
								])
						->take(10)
						->get();
						}else{
							$data = DB::table('kibbs')->leftjoin(Module::bmd().'.Ta_KIB_B as kibb','kibbs.idpemda','=','kibb.IDPemda')
							->leftjoin('racks','racks.id','=','kibbs.rack_no')
							->leftjoin('storages','storages.id','=','racks.storage')
							->leftjoin('uploads as uploadstnk','uploadstnk.id','=','kibbs.stnk_file')
							->leftjoin('uploads as uploadphoto','uploadphoto.id','=','kibbs.photo')
							->leftjoin('uploads as uploadbpkb','uploadbpkb.id','=','kibbs.photo')
							->leftjoin('departments as dept', function ($join) {
									$join->on('dept.kd_bidang','=','kibb.kd_bidang')
											->on('dept.kd_unit','=','kibb.kd_unit')
											->on('dept.kd_sub','=','kibb.kd_sub')
											->on('dept.kd_upb','=','kibb.kd_upb');
								}
							)
							->leftjoin(Module::bmd().'.ref_kondisi as kond','kond.kd_kondisi','=','kibb.kondisi')
							->select('kibbs.id','dept.name as Dept','kibbs.IDPemda','kibb.merk','kibb.type','kibb.cc','kibb.bahan','kond.Uraian as kondisi',
							'kibb.tgl_perolehan','kibb.nomor_rangka',
							'kibb.nomor_mesin','kibb.nomor_polisi',
							'kibb.nomor_bpkb','uploadbpkb.name as bpkb_file','uploadbpkb.hash as hashbpkb','kibbs.bpkb_file as idbpkb',
							'kibbs.rack_no','storages.storage_name',
							'uploadstnk.name as stnk_file','uploadstnk.hash as hashstnk','kibbs.stnk_file as idstnk',
							'uploadphoto.name as photo','uploadphoto.hash as hashphoto','kibbs.photo as idphoto','kibbs.owner')
							->where([['kibb.kd_hapus','=',0],
								['kibb.kd_pemilik','=',12],
								['kibb.kd_aset81','=',2],
								['kibb.kd_aset82','=',2],
								['kibb.kd_aset83','=',1],
								['kibb.kd_bidang','=',$kdbidang],
								['kibb.kd_unit','=',$kdunit],
								['kibb.kd_sub','=',$kdsub],
								['kibb.kd_upb','=',$kdupb],
								])
						->take(10)
						->get();	
						}
					}
					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index=> $row){
						   $index = $index+1;
						   if(Module::hasAccess("Racks", "edit")){
							$output .= '
							<tr>
							 <td>'.$index.'</td>
							 <td>'.$row->Dept.'</td>
							 <td>'.$row->IDPemda.'</td>
							 <td>'.$row->merk.'</td>
							 <td>'.$row->type.'</td>
							 <td>'.$row->cc.'</td>
							 <td>'.$row->bahan.'</td>
							 <td>'.$row->kondisi.'</td>
							 <td>'.date('d-m-Y', strtotime($row->tgl_perolehan)).'</td>
							 <td>'.$row->nomor_rangka.'</td>
							 <td>'.$row->nomor_mesin.'</td>
							 <td><a href="'.url(config('laraadmin.adminRoute') . '/showkendaraans/'.$row->id).'">'.$row->nomor_polisi.'</a></td>
							 <td>'.$row->nomor_bpkb.'</td>
														 <td><a href="'.url('/files/'.$row->hashbpkb).'/'.$row->bpkb_file.'">'.(($row->idbpkb == '' OR $row->idbpkb == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td>'.$row->rack_no.'</td>
							 <td>'.$row->storage_name.'</td>						 
							 <td><a href="'.url('/files/'.$row->hashstnk).'/'.$row->stnk_file.'">'.(($row->idbpkb == '' OR $row->idstnk == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td>'.$row->owner.'</td>
							 <td><a href="'.url('/files/'.$row->hashphoto).'/'.$row->photo.'">'.(($row->idbpkb == '' OR $row->idphoto == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td>
							 <a href="'.url(config('laraadmin.adminRoute') . '/rackskendaraan/'.$row->id.'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>
							 <div class="form-check form-check-inline">
								<input id="chkbox1" type="checkbox" name="ids" value="'.$row->nomor_polisi.'" rel="searchsolos"/>
								<label class="form-check-label" for="inlineCheckbox2"><i class="fa fa-barcode"></i></label>
							  </div>
							 </td>
							</tr>';
						   }else{
							   $output .= '
							<tr>
							 <td>'.$index.'</td>
							 <td>'.$row->IDPemda.'</td>
							 <td>'.$row->Dept.'</td>
							 <td>'.$row->merk.'</td>
							 <td>'.$row->type.'</td>
							 <td>'.$row->cc.'</td>
							 <td>'.$row->bahan.'</td>
							 <td>'.$row->kondisi.'</td>
							 <td>'.date('d-m-Y', strtotime($row->tgl_perolehan)).'</td>
							 <td>'.$row->nomor_rangka.'</td>
							 <td>'.$row->nomor_mesin.'</td>
							 <td><a href="'.url(config('laraadmin.adminRoute') . '/showkendaraans/'.$row->id).'">'.$row->nomor_polisi.'</a></td>
							 <td>'.$row->nomor_bpkb.'</td>
							 <td><a href="'.url('/files/'.$row->hashbpkb).'/'.$row->bpkb_file.'">'.(($row->idbpkb == '' OR $row->idbpkb == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td>'.$row->rack_no.'</td>
							 <td>'.$row->storage_name.'</td>						 
							 <td><a href="'.url('/files/'.$row->hashstnk).'/'.$row->stnk_file.'">'.(($row->idbpkb == '' OR $row->idstnk == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td>'.$row->owner.'</td>
							 <td><a href="'.url('/files/'.$row->hashphoto).'/'.$row->photo.'">'.(($row->idbpkb == '' OR $row->idphoto == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td>
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
	
	/**
	 * Display a listing of the Racks.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Racks');
		$storagerack = DB::table('racks')
					->leftjoin('kibbs','racks.id','=','kibbs.rack_no')
					->leftjoin('storages','racks.storage','=','storages.id')
					->select('storages.storage_name','racks.id','racks.rack_name',DB::raw('COUNT(kibbs.rack_no) as Count'))
					->groupBy('storages.storage_name','racks.id','racks.rack_name')
					->get();
		$kendaraan = DB::table('Kibbs')->leftjoin(Module::bmd().'.Ta_KIB_B as kibb','kibbs.idpemda','=','kibb.IDPemda')
				->leftjoin('dbo.racks','racks.id','=','Kibbs.rack_no')
				// ->leftjoin('storages','storages.id','=','racks.storage')
				->select('kibbs.id','kibbs.IDPemda','kibb.merk','kibb.type','kibb.cc',
				'kibb.tgl_perolehan','kibb.nomor_rangka',
				'kibb.nomor_mesin','kibb.nomor_polisi','kibb.nomor_bpkb','kibb.harga',
				'kibb.kd_bidang','kibb.kd_unit','kibb.kd_sub','kibb.kd_upb','kibbs.bpkb_file',
				'racks.rack_name','kibbs.storage_no','kibbs.stnk_file','kibbs.photo')
				->whereNull('deleted_at');
		//dd($values);
				
		if(Module::hasAccess($module->id)) {
			return View('la.racks.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'listing_cols_kendaraan' => $this->listing_cols_kendaraan,
				'storagerack' => $storagerack,
				'kendaraan' => $kendaraan,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	public function insrack(Request $request){					
			 $cek = DB::table('Kibbs')
					->where('idpemda', '=', $request->input('idpemda'))
					->count();
			if($cek != 0){
				$update = DB::table('Kibbs')
						->where('idpemda', '=',  $request->input('idpemda'))
						->update(['rack_no' => $request->input('rackid'),
									'lend_estimation' => null,
									'lend_verificator' => null
								]);
				$res['status'] = "Berhasil!";
				return $res;
			 }else{
				$res['status'] = "Data Not Found!";
				return $res;
			}           
			//dd($cek);			
		}
	/**
	 * Show the form for creating a new rack.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created rack in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Racks", "create")) {
		
			$rules = Module::validateRules("Racks", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Racks", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.racks.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified rack.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id){
		if(Module::hasAccess("Racks", "view")) {
			
			$rack = Rack::find($id);
			if(isset($rack->id)) {
				$module = Module::get('Racks');
				$module->row = $rack;
				$daftar = DB::table('kibbs')->leftjoin(Module::bmd().'.Ta_KIB_B as kibb','kibbs.idpemda','=','kibb.IDPemda')
				->leftjoin('racks','racks.id','=','kibbs.rack_no')
				->leftjoin('storages','storages.id','=','racks.storage')
				->select('kibbs.idpemda','kibb.merk','kibb.type','kibb.cc','racks.id','racks.rack_name',
				'kibb.tgl_perolehan','kibb.nomor_rangka',
				'kibb.nomor_mesin','kibb.nomor_polisi','kibb.nomor_bpkb','kibbs.bpkb_file',
				'kibbs.rack_no','storages.storage_name')
				->where('racks.id','=',$id /* $request->input('rackid') */)
				->get();
				//dd($daftar);
				return view('la.racks.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'daftar' => $daftar,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('rack', $rack);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("rack"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	public function showkendaraan($id){
		if(Module::hasAccess("Racks", "view")) {
			
			$kendaraan = Kibb::findOrFail($id);
			$kendaraans = DB::table('kibbs')
				->leftjoin(Module::bmd().'.Ta_KIB_B as kibb','kibbs.idpemda','=','kibb.IDPemda')
				->leftjoin('racks','racks.id','=','kibbs.rack_no')
				->leftjoin('storages','storages.id','=','racks.storage')
				->leftjoin('uploads as uploadbpkb','uploadbpkb.id','=','kibbs.bpkb_file')
				->leftjoin('uploads as uploadstnk','uploadstnk.id','=','kibbs.stnk_file')
				->leftjoin('uploads as uploadphoto','uploadphoto.id','=','kibbs.photo')
				->leftjoin('users','users.id','=','kibbs.update_by')
				->select('kibbs.id','kibbs.IDPemda','kibb.merk','kibb.type','kibb.cc',
				'kibb.tgl_perolehan','kibb.nomor_rangka',
				'kibb.nomor_mesin','kibb.nomor_polisi','kibb.nomor_bpkb','uploadbpkb.name as bpkb_file',
				'kibbs.rack_no','storages.storage_name','uploadstnk.name as stnk_file','kibbs.photo','kibbs.updated_at','users.name as update_by')
				->where([['kibb.kd_hapus','=',0],
						['kibb.kd_pemilik','=',12],
						['kibb.kd_aset81','=',2],
						['kibb.kd_aset82','=',2],
						['kibb.kd_aset83','=',1],						
						['kibbs.id','=',$id]
						])
				->get();
			if(isset($kendaraan->id)) {
				$module = Module::get('kendaraans');
				$module->row = $kendaraan;
				return view('la.racks.showkendaraan', [
					'module' => $module,
					'kendaraans' => $kendaraans,
					'view_col_kendaraan' => $this->view_col_kendaraan,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('kendaraan', $kendaraan);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("kendaraan"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified rack.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id){
		if(Module::hasAccess("Racks", "edit")) {			
			$rack = Rack::find($id);
			if(isset($rack->id)) {	
				$module = Module::get('Racks');				
				$module->row = $rack;
				
				return view('la.racks.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('rack', $rack);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("rack"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	public function editkendaraan($id){
		if(Module::hasAccess("Racks", "edit")) {			
			$kendaraan = Kendaraan::find($id);
			if(isset($kendaraan->id)) {	
				$module = Module::get('Kendaraans');				
				$module->row = $kendaraan;
				
				return view('la.racks.editkendaraan', [
					'module' => $module,
					'view_col_kendaraan' => $this->view_col_kendaraan,
				])->with('kendaraan', $kendaraan);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("racks"),
				]);
			}
		 } else {
			return redirect(config('laraadmin.adminRoute')."/racks");
		}
	}

	/**
	 * Update the specified rack in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id){
		if(Module::hasAccess("Racks", "edit")) {
			
			$rules = Module::validateRules("Racks", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Racks", $request, $id);

			return redirect()->route(config('laraadmin.adminRoute') . '.racks.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	public function updatekendaraan(Request $request, $id){
			if(Module::hasAccess("Racks", "edit")) {
				
				if(Module::hasAccess("Racks", "edit")) {
				
				$rules = Module::validateRules("Racks", $request, true);			
				$validator = Validator::make($request->all(), $rules);
				
				if ($validator->fails()) {
					return redirect()->back()->withErrors($validator)->withInput();;
				}
				
				$insert_id = Module::updateRow("Kendaraans", $request, $id);			
				$update = DB::table('Kibbs')
						->where('id', '=',  $id)
						->update(['update_by' => \Auth::user()->id]);
				return redirect(config('laraadmin.adminRoute') .'/racks#lists');
				
			} else {
				return redirect(config('laraadmin.adminRoute')."/");
			}
		}
	}

	/**
	 * Remove the specified rack from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Racks", "delete")) {
			Rack::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.racks.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax(){
		$values = DB::table('racks')->select($this->listing_cols)->whereNull('deleted_at');
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Racks');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/racks/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Racks", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/racks/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Racks", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.racks.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}
	public function dtajaxkendaraan(){
		//$values = DB::table('kibbs')->select($this->listing_cols)->whereNull('deleted_at');
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		
		if($kdbidang == 99 || $kdbidang == 0 ){
						
			$values = DB::table('kibbs')->leftjoin(Module::bmd().'.Ta_KIB_B as kibb','kibbs.idpemda','=','kibb.IDPemda')
				->leftjoin('racks','racks.id','=','kibbs.rack_no')
				->leftjoin('storages','storages.id','=','racks.storage')
				->leftjoin('uploads as uploadbpkb','uploadbpkb.id','=','kibbs.bpkb_file')
				->leftjoin('uploads as uploadstnk','uploadstnk.id','=','kibbs.stnk_file')
				->leftjoin('uploads as uploadphoto','uploadphoto.id','=','kibbs.photo')
				->select('kibbs.id','kibbs.IDPemda','kibb.merk','kibb.type','kibb.cc',
				'kibb.tgl_perolehan','kibb.nomor_rangka',
				'kibb.nomor_mesin','kibb.nomor_polisi','kibb.nomor_bpkb','uploadbpkb.name as bpkb_file',
				'kibbs.rack_no','storages.storage_name','uploadstnk.name','uploadphoto.name as photo')
				//->whereNotNull('kibb.nomor_polisi')
				->where([['kibb.kd_hapus','=',0],
						['kibb.kd_pemilik','=',12],
						['kibb.kd_aset81','=',2],
						['kibb.kd_aset82','=',2],
						]);	
		}else{

			$values = DB::table('kibbs')->leftjoin(Module::bmd().'.Ta_KIB_B as kibb','kibbs.idpemda','=','kibb.IDPemda')
				->leftjoin('racks','racks.id','=','kibbs.rack_no')
				->leftjoin('storages','storages.id','=','racks.storage')
				->leftjoin('uploads as uploadbpkb','uploadbpkb.id','=','kibbs.bpkb_file')
				->leftjoin('uploads as uploadstnk','uploadstnk.id','=','kibbs.stnk_file')
				->leftjoin('uploads as uploadphoto','uploadphoto.id','=','kibbs.photo')
				->select('kibbs.id','kibbs.IDPemda','kibb.merk','kibb.type','kibb.cc',
				'kibb.tgl_perolehan','kibb.nomor_rangka',
				'kibb.nomor_mesin','kibb.nomor_polisi','kibb.nomor_bpkb','uploadbpkb.name as bpkb_file',
				'kibbs.rack_no','storages.storage_name','uploadstnk.name','uploadphoto.name as photo')
				//->whereNotNull('kibb.nomor_polisi')
				->where([['kibb.kd_hapus','=',0],
						['kibb.kd_pemilik','=',12],
						['kibb.kd_aset81','=',2],
						['kibb.kd_aset82','=',2],
						['kibb.kd_bidang','=',$kdbidang],
						['kibb.kd_unit','=',$kdunit],
						]);
		}
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Kibbs');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols_kendaraan); $j++) { 
				$col = $this->listing_cols_kendaraan[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col_kendaraan) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/showkendaraan/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
				// else if($col == "author") {
				//    $data->data[$i][$j];
				// }
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Racks", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/rackskendaraan/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				/*if(Module::hasAccess("Racks", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.rackskendaraan.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				} */
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}
}
