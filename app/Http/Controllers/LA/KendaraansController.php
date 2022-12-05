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
use Illuminate\Support\Facades\Response;
use PDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PHPSpreadsheet\Worksheet;
use App\Models\Kendaraan;
use App\Models\Kibb;

class KendaraansController extends Controller
{
	public $show_action = true;
	public $view_col = 'idpemda';
	public $listing_cols = ['id', 'idpemda', 'merk', 'type', 'cc', 'tgl_perolehan', 'no_rangka', 'no_mesin', 'nomor_polisi', 'nomor_bpkb', 'bpkb_file','rack_no', 'storage_no','stnk_file','photo'];
	
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

	public function print($id){
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$kendaraan = Kibb::findOrFail($id);
		$cekuser = Module::showkendaraanuser($id)->get();
		if(Module::hasAccess("Kendaraans", "view")) {		
			if($kdbidang == 99 || $kdbidang == 0 ){			
					$kendaraans = Module::showkendaraanadmin($id)
									->get();
	
					$kendaraanarray = json_decode(json_encode($kendaraans[0]), true);
				    $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
							->loadView('la.report.print',$kendaraanarray)
							->setPaper('Folio', 'portrait');
					return $pdf->stream('KIB-Kendaraan_'.Module::userlogin()->dept_name.'.pdf');
					//return view('la.report.print',$kendaraanarray);
					//dd($kendaraanarray);
			}else{
					$kendaraans = Module::showkendaraanadmin($id)
							->get();
					$kendaraanarray = json_decode(json_encode($kendaraans), true);
				   $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
							->loadView('la.report.print',$kendaraanarray)
							->setPaper('Folio', 'portrait');
					return $pdf->stream('KIB-Kendaraan_'.Module::userlogin()->dept_name.'.pdf');					
					//return view('la.report.print',['kendaraans' => $kendaraans]);
					//dd($kendaraans);
			}
		}else{
			return view(abort(403, 'Unauthorized action.'));
		}		 
	}
	public function printsolo(Request $request){
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
							->loadView('la.report.printsolo',['kendaraans' => $kendaraans])
							->setPaper('Letter', 'landscape');
					return $pdf->stream('KIB-Kendaraan_'.Module::userlogin()->dept_name.'.pdf');
				}else{
					$kendaraans = Module::kendaraanadminquerysolo($query)
								  ->get();
					$kendaraanarray = json_decode(json_encode($kendaraans), true);
					$pdf = new PDF;
				    $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
							->loadView('la.report.printsolo',['kendaraans' => $kendaraans])
							->setPaper('folio', 'landscape');
					return $pdf->stream('KIB-Kendaraan_'.Module::userlogin()->dept_name.'.pdf');
				}	
					
			}else{
				if($request->get('searchsolo') == ""){					
					$kendaraans = Module::kendaraanuser()->get();
					$kendaraanarray = json_decode(json_encode($kendaraans), true);
					$pdf = new PDF;
				    $pdf = PDF::setOptions(['isPhpEnabled' => true, 'isRemoteEnabled' => true])
							->loadView('la.report.printsolo',['kendaraans' => $kendaraans])
							->setPaper('folio', 'landscape');
					
					return $pdf->stream('KIB-Kendaraan_'.Module::userlogin()->dept_name.'.pdf');
				}else{
					$kendaraans = Module::kendaraanuserquerysolo($query)
							->get();
					$kendaraanarray = json_decode(json_encode($kendaraans), true);
					$pdf = new PDF;
				    $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
							->loadView('la.report.printsolo',['kendaraans' => $kendaraans])
							->setPaper('folio', 'landscape');
					return $pdf->stream('KIB-Kendaraan_'.Module::userlogin()->dept_name.'.pdf');			
				}
			}
		}else{
			return view(abort(403, 'Unauthorized action.'));
		}		 
	}
	
	public function csvkendall($kdbidangs,$kdunits,$kdsubs){
		$kdbidang = Module::kdopd()->kd_bidang;		
		//$data = Module::kendall($kdbidangs,$kdunits,$kdsubs);
		//dd($data);
		if(Module::hasAccess("Kendaraans", "view")) {
				
			if($kdbidang == 99 || $kdbidang == 0 ){			
											
				$inputFileType = 'Xls'; // Xlsx - Xml - Ods - Slk - Gnumeric - Csv
				$inputFileName = public_path('storage\format\format_kendaraan.xls');
				$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);				
				$spreadsheet = new Spreadsheet();
				$spreadsheet = $reader->load($inputFileName);
				$sheet = $spreadsheet->getActiveSheet();
				
				$kibbitem = Module::kendall($kdbidangs,$kdunits,$kdsubs);
				$cell = 9;
				foreach($kibbitem as $index=>$kibbitems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);
					$sheet->setCellValue('C4'.$cell, $kibbitems->Nm_Aset5);
					$sheet->setCellValue('B4', $kibbitems->nm_sub_unit);
					$sheet->setCellValue('C'.$cell, $kibbitems->merk);
					$sheet->setCellValue('D'.$cell, $kibbitems->type);
					$sheet->setCellValue('E'.$cell, $kibbitems->nomor_mesin);
					$sheet->setCellValue('F'.$cell, $kibbitems->nomor_rangka);
					$sheet->setCellValue('G'.$cell, $kibbitems->nomor_polisi);
					$sheet->setCellValue('H'.$cell, $kibbitems->nomor_bpkb);
					$sheet->setCellValue('I'.$cell, date('Y', strtotime($kibbitems->tgl_perolehan)));
					$sheet->setCellValue('J'.$cell, $kibbitems->Asal_usul);
					if($kibbitems->Kd_Kondisi == 1){
						$sheet->setCellValue('K'.$cell, '✔️');
						$sheet->setCellValue('L'.$cell,'-');
						$sheet->setCellValue('M'.$cell, '-');
					}elseif($kibbitems->kd_kondisiakhir == 2){
						$sheet->setCellValue('K'.$cell, '-');
						$sheet->setCellValue('L'.$cell,'✔️');
						$sheet->setCellValue('M'.$cell, '-');
					}elseif($kibbitems->kd_kondisiakhir == 3){
						$sheet->setCellValue('K'.$cell, '-');
						$sheet->setCellValue('L'.$cell,'-');
						$sheet->setCellValue('M'.$cell, '✔');
					}else{
						$sheet->setCellValue('K'.$cell, '-');
						$sheet->setCellValue('L'.$cell,'-');
						$sheet->setCellValue('M'.$cell, '✔');
					}
					$sheet->setCellValue('N'.$cell, '');
					$sheet->setCellValue('O'.$cell, $kibbitems->pemegang_brg);
					$sheet->setCellValue('P'.$cell, $kibbitems->keterangan);
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(100);
					$sheet->setCellValue('Q'.$cell, $kibbitems->harga);
					$cell++;
				}
				$writer = new Xlsx($spreadsheet);        
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="KIBB_Kendaraan_export.xlsx"');
				$writer->save('php://output');
			}else{
				$kdunit = Module::kdopd()->kd_unit;
				$kdsub = Module::kdopd()->kd_sub;
				$inputFileType = 'Xls'; // Xlsx - Xml - Ods - Slk - Gnumeric - Csv
				$inputFileName = public_path('storage\format\format_kendaraan.xls');
				$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);				
				$spreadsheet = new Spreadsheet();
				$spreadsheet = $reader->load($inputFileName);
				$sheet = $spreadsheet->getActiveSheet();
												
				$kibbitem = Module::kendall($kdbidang,$kdunit,$kdsub);
				$cell = 10;
				foreach($kibbitem as $index=>$kibbitems){
					
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);
					$sheet->setCellValue('A2', $kibbitems->nm_sub_unit);
					$sheet->setCellValue('C4'.$cell, $kibbitems->Nm_Aset5);
					$sheet->setCellValue('B4', $kibbitems->nm_sub_unit);
					$sheet->setCellValue('C'.$cell, $kibbitems->merk);
					$sheet->setCellValue('D'.$cell, $kibbitems->type);
					$sheet->setCellValue('E'.$cell, $kibbitems->nomor_mesin);
					$sheet->setCellValue('F'.$cell, $kibbitems->nomor_rangka);
					$sheet->setCellValue('G'.$cell, $kibbitems->nomor_polisi);
					$sheet->setCellValue('H'.$cell, $kibbitems->nomor_bpkb);
					$sheet->setCellValue('I'.$cell, date('Y', strtotime($kibbitems->tgl_perolehan)));
					$sheet->setCellValue('J'.$cell, $kibbitems->Asal_usul);
					if($kibbitems->Kd_Kondisi == 1){
						$sheet->setCellValue('K'.$cell, '✔️');
						$sheet->setCellValue('L'.$cell,'-');
						$sheet->setCellValue('M'.$cell, '-');
					}elseif($kibbitems->kd_kondisiakhir == 2){
						$sheet->setCellValue('K'.$cell, '-');
						$sheet->setCellValue('L'.$cell,'✔️');
						$sheet->setCellValue('M'.$cell, '-');
					}elseif($kibbitems->kd_kondisiakhir == 3){
						$sheet->setCellValue('K'.$cell, '-');
						$sheet->setCellValue('L'.$cell,'-');
						$sheet->setCellValue('M'.$cell, '✔');
					}else{
						$sheet->setCellValue('K'.$cell, '-');
						$sheet->setCellValue('L'.$cell,'-');
						$sheet->setCellValue('M'.$cell, '✔');
					}
					$sheet->setCellValue('N'.$cell, '');
					$sheet->setCellValue('O'.$cell, $kibbitems->pemegang_brg);
					$sheet->setCellValue('P'.$cell, $kibbitems->keterangan);										
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(100);
					
					$sheet->setCellValue('Q'.$cell, $kibbitems->harga);
					$cell++;
				}
				$writer = new Xlsx($spreadsheet);        
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="KIBB_Kendaraan_export.xlsx"');
				$writer->save('php://output');
			}
		}else{
			return view(abort(403, 'Unauthorized action.'));
		}			 
	}
	
	public function loadDataKendaraanadmin(Request $request,$kdbidangs,$kdunits,$kdsubs){
	if(Module::hasAccess("Kendaraans", "view")) {
				$kdbidang = Module::kdopd()->kd_bidang;
				//$data = Module::kendaraanusers($kdbidangs,$kdunits,$kdsubs)->get();
				//dd($data);
			if ($request->ajax()) {
					$output = '';
					$query = $request->get('query');
					if ($query != '') {
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::kendaraanadminquery($query)->take(3)->get();
						}else{
							$data = Module::kendaraanuserquery($query)->take(3)->get();	
						}
					} else {
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::kendaraanadmins($kdbidangs,$kdunits,$kdsubs)->get();
						}else{
							$kdunit = Module::kdopd()->kd_unit;
							$kdsub = Module::kdopd()->kd_sub;
							$kdupb = Module::kdopd()->kd_upb;
							$data = Module::kendaraanusers($kdbidang,$kdunit,$kdsub)->distinct()->get();
						}
					}
					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index=> $row){
						    $index = $index+1;
						   if(Module::hasAccess("Kendaraans", "edit")){
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
							 <td><a target="_blank" href="'.url(config('laraadmin.adminRoute') . '/kendaraans/'.$row->id).'">'.$row->nomor_polisi.'</a></td>
							 <td>'.$row->nomor_bpkb.'</td>
							 <td><a target="_blank" href="'.url('/files/'.$row->hashbpkb).'/'.$row->bpkb_file.'">'.(($row->idbpkb == '' OR $row->idbpkb == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td>'.$row->rack_no.'</td>
							 <td>'.$row->storage_name.'</td>						 
							 <td><a target="_blank" href="'.url('/files/'.$row->hashstnk).'/'.$row->stnk_file.'">'.(($row->idstnk == ''  OR $row->idstnk == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td>'.date('d-m-Y', strtotime($row->tax_date)).'</td>
							 <td><a target="_blank" href="'.url('/files/'.$row->hashphoto).'/'.$row->photo.'">'.(($row->idphoto == ''  OR $row->idphoto == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td><a target="_blank" href="'.url('/files/'.$row->hashbast).'/'.$row->bast_pinjam.'">'.(($row->idbast == ''  OR $row->idbast == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td>'.$row->owner.'</td>
							 <td>'.(($row->vrf_status == ''  OR $row->vrf_status == 0) ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-primary btn-xs">').'</a></td>
							 <td>
							 <a target="_blank" href="'.url(config('laraadmin.adminRoute') . '/prints/'.$row->id).'" class="btn btn-outline-info btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-print"></i></a>
							 '.(($row->vrf_status == ''  OR $row->vrf_status == 0) ? 
							 '<a target="_blank" href="'.url(config('laraadmin.adminRoute') . '/kendaraans/'.$row->id.'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>							 
							 ':'<i class="fa fa-check btn-primary btn-xs"></i>').'
							 <div class="form-check form-check-inline">
								<input id="chkbox1" type="checkbox" name="ids" value="'.$row->nomor_polisi.'" rel="searchsolos"/>
								<label class="form-check-label" for="inlineCheckbox2"><i class="fa fa-print"></i></label>
							  </div>
							 </td>
							 <td style="text-align:center;">
								<div class="form-check form-check-inline">'
							.(($kdbidang == 99 OR $kdbidang == 0) ?									
									'<button id = "'.$row->id.'" class="btn btn-primary btn-xs" type="button" onclick = "getvrfValue(this.id);"><i class="fa fa-thumbs-up"></i></button>
									<button id = "'.$row->idkibb.'" class="btn btn-danger btn-xs" type="button" onclick = "getreleaseValue(this.id);"><i class="fa fa-thumbs-down"></i></button>'								
								:
								'<label class="form-check-label" for="inlineCheckbox2">Not Authorize</label>').
								'</div>
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
							 <td><a target="_blank" href="'.url(config('laraadmin.adminRoute') . '/kendaraans/'.$row->id).'">'.$row->nomor_polisi.'</a></td>
							 <td>'.$row->nomor_bpkb.'</td>
							 <td><a target="_blank" href="'.url('/files/'.$row->hashbpkb).'/'.$row->bpkb_file.'">'.(($row->idbpkb == ''  OR $row->idbpkb == 0) ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td> Not Authorize</td>
							 <td> Not Authorize</td>						 
							 <td><a target="_blank" href="'.url('/files/'.$row->hashstnk).'/'.$row->stnk_file.'">'.(($row->idstnk == ''  OR $row->idstnk == 0) ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td>'.date('d-m-Y', strtotime($row->tax_date)).'</td>
							 <td><a target="_blank" href="'.url('/files/'.$row->hashphoto).'/'.$row->photo.'">'.(($row->idphoto == ''  OR $row->idphoto == 0) ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td><a target="_blank" href="'.url('/files/'.$row->hashbast).'/'.$row->bast_pinjam.'">'.(($row->idbast == ''  OR $row->idbast == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td>'.$row->owner.'</td>
							 <td>'.(($row->verification_status == ''  OR $row->verification_status == 0) ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-primary btn-xs">').'</a></td>
							 <td>
							 <a target="_blank" href="'.url(config('laraadmin.adminRoute') . '/prints/'.$row->id).'" class="btn btn-outline-info btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-print"></i></a>
							  <a target="_blank" href="'.url(config('laraadmin.adminRoute') . '/kendaraans/'.$row->id.'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>							 
							  <div class="form-check form-check-inline">
								<input id="chkbox1" type="checkbox" name="ids" value="'.$row->nomor_polisi.'" rel="searchsolos"/>
								<label class="form-check-label" for="inlineCheckbox2"><i class="fa fa-print"></i></label>
							  </div>
							 </td>
							 <td style="text-align:center;">
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

				  echo json_encode($data);
			}
		}else{
			return view('errors.404');
		}            
    }
    public function verifkend(Request $request,$id){
			$update = Kibb::find($id);
			$update->vrf_status = 1;			
			$update->save();
			
			//return redirect(config('laraadmin.adminRoute') .'/kendaraans#lists');					
	}
	
	public function verifkendrelease(Request $request,$id){
			$update = Kibb::find($id);
			$update->vrf_status = 0;			
			$update->save();
			
			//return redirect(config('laraadmin.adminRoute') .'/kendaraans#lists');		
	}
	
	/* public function loadDataKendaraan(Request $request){
	if(Module::hasAccess("Kendaraans", "view")) {
				$kdbidang = Module::kdopd()->kd_bidang;
				$kdunit = Module::kdopd()->kd_unit;
				$kdsub = Module::kdopd()->kd_sub;
				$kdupb = Module::kdopd()->kd_upb;

			if ($request->ajax()) {
					$output = '';
					$query = $request->get('query');
					if ($query != '') {
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::kendaraanadminquery($query)->take(3)->get();
						}else{
							$data = Module::kendaraanuserquery($query)->take(3)->get();	
						}
					} else {
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::kendaraan()->take(10)->get();
						}else{
							$data = Module::kendaraanuser()->take(10)->get();
						}
					}
					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index=> $row){
						    $index = $index+1;
						   if(Module::hasAccess("Kendaraans", "edit")){
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
							 <td><a target="_blank" href="'.url(config('laraadmin.adminRoute') . '/kendaraans/'.$row->id).'">'.$row->nomor_polisi.'</a></td>
							 <td>'.$row->nomor_bpkb.'</td>
							 <td><a target="_blank" href="'.url('/files/'.$row->hashbpkb).'/'.$row->bpkb_file.'">'.(($row->idbpkb == '' OR $row->idbpkb == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td>'.$row->rack_no.'</td>
							 <td>'.$row->storage_name.'</td>						 
							 <td><a target="_blank" href="'.url('/files/'.$row->hashstnk).'/'.$row->stnk_file.'">'.(($row->idstnk == ''  OR $row->idstnk == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td>'.date('d-m-Y', strtotime($row->tax_date)).'</td>
							 <td><a target="_blank" href="'.url('/files/'.$row->hashphoto).'/'.$row->photo.'">'.(($row->idphoto == ''  OR $row->idphoto == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td><a target="_blank" href="'.url('/files/'.$row->hashbast).'/'.$row->bast_pinjam.'">'.(($row->idbast == ''  OR $row->idbast == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td>'.$row->owner.'</td>
							 <td>'.(($row->verification_status == ''  OR $row->verification_status == 0) ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-primary btn-xs">').'</a></td>
							 <td>
							 <a target="_blank" href="'.url(config('laraadmin.adminRoute') . '/prints/'.$row->id).'" class="btn btn-outline-info btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-print"></i></a>
							 <a target="_blank" href="'.url(config('laraadmin.adminRoute') . '/kendaraans/'.$row->id.'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>							 
							  <div class="form-check form-check-inline">
								<input id="chkbox1" type="checkbox" name="ids" value="'.$row->nomor_polisi.'" rel="searchsolos"/>
								<label class="form-check-label" for="inlineCheckbox2"><i class="fa fa-print"></i></label>
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
							 <td><a target="_blank" href="'.url(config('laraadmin.adminRoute') . '/kendaraans/'.$row->id).'">'.$row->nomor_polisi.'</a></td>
							 <td>'.$row->nomor_bpkb.'</td>
							 <td><a target="_blank" href="'.url('/files/'.$row->hashbpkb).'/'.$row->bpkb_file.'">'.(($row->idbpkb == ''  OR $row->idbpkb == 0) ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td> Not Authorize</td>
							 <td> Not Authorize</td>						 
							 <td><a target="_blank" href="'.url('/files/'.$row->hashstnk).'/'.$row->stnk_file.'">'.(($row->idstnk == ''  OR $row->idstnk == 0) ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td>'.date('d-m-Y', strtotime($row->tax_date)).'</td>
							 <td><a target="_blank" href="'.url('/files/'.$row->hashphoto).'/'.$row->photo.'">'.(($row->idphoto == ''  OR $row->idphoto == 0) ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td><a target="_blank" href="'.url('/files/'.$row->hashbast).'/'.$row->bast_pinjam.'">'.(($row->idbast == ''  OR $row->idbast == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td>'.$row->owner.'</td>
							 <td>'.(($row->verification_status == ''  OR $row->verification_status == 0) ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-primary btn-xs">').'</a></td>
							 <td>
							 <a target="_blank" href="'.url(config('laraadmin.adminRoute') . '/prints/'.$row->id).'" class="btn btn-outline-info btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-print"></i></a>
							  <a target="_blank" href="'.url(config('laraadmin.adminRoute') . '/kendaraans/'.$row->id.'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>							 
							  <div class="form-check form-check-inline">
								<input id="chkbox1" type="checkbox" name="ids" value="'.$row->nomor_polisi.'" rel="searchsolos"/>
								<label class="form-check-label" for="inlineCheckbox2"><i class="fa fa-print"></i></label>
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

				  echo json_encode($data);
			}
		}else{
			return view('errors.404');
		}            
    } */
	
public function loadDatapajak(Request $request){
	if(Module::hasAccess("Kendaraans", "view")) {
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
									->whereRaw('kibbs.tax_date <= DATEADD(month, -1, GETDATE())')
									->Where('kibbs.verification_status','=',1)
									->WhereNotNull('kibbs.bpkb_file')																				
									->WhereNotNull('kibbs.stnk_file')																				
									->WhereNotNull('kibbs.photo')
									->WhereNull('kibbs.verification_tax_status')									
									->orWhere('kibbs.verification_tax_status','=',0)
									->take(3)
									->get();
						}else{
							$data = Module::kendaraanuserquery($query)
									->whereRaw('kibbs.tax_date <= DATEADD(month, -1, GETDATE())')
									->Where([['kibbs.verification_status','=',1],
												['kibb.kd_bidang','=',$kdbidang],
												['kibb.kd_unit','=',$kdunit],
												['kibb.kd_sub','=',$kdsub],
												['kibb.kd_upb','=',$kdupb]
											])
									->WhereNotNull('kibbs.bpkb_file')																				
									->WhereNotNull('kibbs.stnk_file')																				
									->WhereNotNull('kibbs.photo')
									->WhereNull('kibbs.verification_tax_status')									
									//->orWhere('kibbs.verification_tax_status','=',0)
									->take(3)
									->get();	
						}
					} else {
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::kendaraan() //date('d-m-Y', strtotime('kibbs.tax_date'))
									//->where('kibbs.tax_date','<','DATEADD(month, -1, GETDATE())')
									->whereRaw('kibbs.tax_date <= DATEADD(month, -1, GETDATE())')
									->Where('kibbs.verification_status','=',1)
									->WhereNotNull('kibbs.bpkb_file')																				
									->WhereNotNull('kibbs.stnk_file')																				
									->WhereNotNull('kibbs.photo')
									->WhereNull('kibbs.verification_tax_status')									
									->orWhere('kibbs.verification_tax_status','=',0)
									->get();
						}else{
							$data = Module::kendaraanuser()
									->whereRaw('kibbs.tax_date <= DATEADD(month, -1, GETDATE())')
									->Where([['kibbs.verification_status','=',1],
												['kibb.kd_bidang','=',$kdbidang],
												['kibb.kd_unit','=',$kdunit],
												['kibb.kd_sub','=',$kdsub]//,
												//['kibb.kd_upb','=',$kdupb]
											])
									->WhereNotNull('kibbs.bpkb_file')																				
									->WhereNotNull('kibbs.stnk_file')																				
									->WhereNotNull('kibbs.photo')
									->WhereNull('kibbs.verification_tax_status')									
									//->orWhere('kibbs.verification_tax_status','=',0)
									->get();
						}
					}
					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index=> $row){
						    $index = $index+1;
						   if(Module::hasAccess("Kendaraans", "edit")){
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
							 <td><a href="'.url(config('laraadmin.adminRoute') . '/kendaraans/'.$row->id).'">'.$row->nomor_polisi.'</a></td>
							 <td>'.$row->nomor_bpkb.'</td>
							 <td><a href="'.url('/files/'.$row->hashbpkb).'/'.$row->bpkb_file.'">'.(($row->idbpkb == '' OR $row->idbpkb == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td>'.$row->rack_no.'</td>
							 <td>'.$row->storage_name.'</td>						 
							 <td><a target="_blank" href="'.url('/files/'.$row->hashstnk).'/'.$row->stnk_file.'">'.(($row->idstnk == ''  OR $row->idstnk == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td>'.date('d-m-Y', strtotime($row->tax_date)).'</td>
							 <td><a target="_blank" href="'.url('/files/'.$row->hashphoto).'/'.$row->photo.'">'.(($row->idphoto == ''  OR $row->idphoto == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td><a target="_blank" href="'.url('/files/'.$row->hashbast).'/'.$row->bast_pinjam.'">'.(($row->idbast == ''  OR $row->idbast == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td>'.$row->owner.'</td>
							 <td>'.(($row->verification_status == ''  OR $row->verification_status == 0) ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-primary btn-xs">').'</a></td>
							 <td>
							 <a target="_blank" href="'.url(config('laraadmin.adminRoute') . '/print/'.$row->id).'" class="btn btn-outline-info btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-print"></i></a>
							 <a target="_blank" href="'.url(config('laraadmin.adminRoute') . '/kendaraans/'.$row->id.'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>							 
							  <div class="form-check form-check-inline">
								<input id="chkbox1" type="checkbox" name="ids" value="'.$row->nomor_polisi.'" rel="searchsolos"/>
								<label class="form-check-label" for="inlineCheckbox2"><i class="fa fa-print"></i></label>
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
							 <td><a href="'.url(config('laraadmin.adminRoute') . '/kendaraans/'.$row->id).'">'.$row->nomor_polisi.'</a></td>
							 <td>'.$row->nomor_bpkb.'</td>
							 <td><a href="'.url('/files/'.$row->hashbpkb).'/'.$row->bpkb_file.'">'.(($row->idbpkb == ''  OR $row->idbpkb == 0) ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td> Not Authorize</td>
							 <td> Not Authorize</td>						 
							 <td><a href="'.url('/files/'.$row->hashstnk).'/'.$row->stnk_file.'">'.(($row->idstnk == ''  OR $row->idstnk == 0) ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td>'.(($row->tax_date == '1970-01-01'  OR $row->tax_date == '01-01-1970') ? '<i class="fa fa-times btn-danger btn-xs">' : date('d-m-Y', strtotime($row->tax_date))).'</td>
							 <td><a target="_blank" href="'.url('/files/'.$row->hashphoto).'/'.$row->photo.'">'.(($row->idphoto == ''  OR $row->idphoto == 0) ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td><a target="_blank" href="'.url('/files/'.$row->hashbast).'/'.$row->bast_pinjam.'">'.(($row->idbast == ''  OR $row->idbast == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td>'.$row->owner.'</td>
							 <td>'.(($row->verification_status == ''  OR $row->verification_status == 0) ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-primary btn-xs">').'</a></td>
							 <td>
							<a target="_blank" href="'.url(config('laraadmin.adminRoute') . '/print/'.$row->id).'" class="btn btn-outline-info btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-print"></i></a>
							  <a target="_blank" href="'.url(config('laraadmin.adminRoute') . '/kendaraans/'.$row->id.'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>							 
							  <div class="form-check form-check-inline">
								<input id="chkbox1" type="checkbox" name="ids" value="'.$row->nomor_polisi.'" rel="searchsolos"/>
								<label class="form-check-label" for="inlineCheckbox2"><i class="fa fa-print"></i></label>
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

				  echo json_encode($data);
			}
		}else{
			return view('errors.404');
		}
}	
	/**
	 * Display a listing of the Kendaraans.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
	if(Module::hasAccess("Kendaraans", "view")) {
		$module = Module::get('Kendaraans');
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$kdsub = Module::kdopd()->kd_sub;
		$kdupb = Module::kdopd()->kd_upb;
		/* dd($kdsub = Module::kdopd()->kd_sub); */
		if($kdbidang == 99 || $kdbidang == 0 ){
			$refbidang = Module::populatebidangadmin()->get();
			$bpkbcount = DB::table('departments as dept')->leftjoin(Module::bmd().'.Ta_KIB_B as kibb',function ($join) {
									$join->on('dept.kd_bidang','=','kibb.kd_bidang')
											->on('dept.kd_unit','=','kibb.kd_unit')
											->on('dept.kd_sub','=','kibb.kd_sub')
											->on('dept.kd_upb','=','kibb.kd_upb');
									}
								)
					->join('kibbs','kibbs.idpemda','=','kibb.IDPemda')
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as kendaraantotal,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												 departments as dept left join
												 '.Module::bmd().'.Ta_KIB_B as kibb 
												 on dept.kd_bidang = kibb.kd_bidang and
													 dept.kd_unit = kibb.kd_unit and
													 dept.kd_sub = kibb.kd_sub and
													 dept.kd_upb = kibb.kd_upb
												 WHERE 
												 kibb.kd_hapus = 0 and
												 kibb.kd_pemilik = 12 and
												 kibb.kd_aset8 = 1 and
												 kibb.kd_aset80 = 3 and
												 kibb.kd_aset81 = 2 and
												 kibb.kd_aset82 = 2 and
												 kibb.kd_aset83 = 1 
												 group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)kendaraantot'), 
												 function ($joins){
												 $joins->on('kendaraantot.kd_bidang','=','dept.kd_bidang')
														 ->on('kendaraantot.kd_unit','=','dept.kd_unit')
														 ->on('kendaraantot.kd_sub','=','dept.kd_sub')
														 ->on('kendaraantot.kd_upb','=','dept.kd_upb');
											 }
								 )
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
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
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
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
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
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
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
					 ->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as rodadua,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												 departments as dept left join
												 '.Module::bmd().'.Ta_KIB_B as kibb 
												 on dept.kd_bidang = kibb.kd_bidang and
													 dept.kd_unit = kibb.kd_unit and
													 dept.kd_sub = kibb.kd_sub and
													 dept.kd_upb = kibb.kd_upb
												 WHERE 
												 kibb.kd_hapus = 0 and
												 kibb.kd_pemilik = 12 and
												 kibb.kd_aset8 = 1 and
												 kibb.kd_aset80 = 3 and
												 kibb.kd_aset81 = 2 and
												 kibb.kd_aset82 = 2 and
												 kibb.kd_aset83 = 1 and
												 kibb.kd_aset84 = 4
												 group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)roda2'), 
												 function ($joins){
												 $joins->on('roda2.kd_bidang','=','dept.kd_bidang')
														 ->on('roda2.kd_unit','=','dept.kd_unit')
														 ->on('roda2.kd_sub','=','dept.kd_sub')
														 ->on('roda2.kd_upb','=','dept.kd_upb');
											 }
								 )
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as rodaempat,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												 departments as dept left join
												 '.Module::bmd().'.Ta_KIB_B as kibb 
												 on dept.kd_bidang = kibb.kd_bidang and
													 dept.kd_unit = kibb.kd_unit and
													 dept.kd_sub = kibb.kd_sub and
													 dept.kd_upb = kibb.kd_upb
												 WHERE 
												 kibb.kd_hapus = 0 and
												 kibb.kd_pemilik = 12 and
												 kibb.kd_aset8 = 1 and
												 kibb.kd_aset80 = 3 and
												 kibb.kd_aset81 = 2 and
												 kibb.kd_aset82 = 2 and
												 kibb.kd_aset83 = 1 and
												 kibb.kd_aset84 = 1
												 group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)roda4'), 
												 function ($joins){
												 $joins->on('roda4.kd_bidang','=','dept.kd_bidang')
														 ->on('roda4.kd_unit','=','dept.kd_unit')
														 ->on('roda4.kd_sub','=','dept.kd_sub')
														 ->on('roda4.kd_upb','=','dept.kd_upb');
											 }
								 )
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as rodatiga,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												 departments as dept left join
												 '.Module::bmd().'.Ta_KIB_B as kibb 
												 on dept.kd_bidang = kibb.kd_bidang and
													 dept.kd_unit = kibb.kd_unit and
													 dept.kd_sub = kibb.kd_sub and
													 dept.kd_upb = kibb.kd_upb 
												 WHERE 
												 kibb.kd_hapus = 0 and
												 kibb.kd_pemilik = 12 and
												 kibb.kd_aset8 = 1 and
												 kibb.kd_aset80 = 3 and
												 kibb.kd_aset81 = 2 and
												 kibb.kd_aset82 = 2 and
												 kibb.kd_aset83 = 1 and
												 kibb.kd_aset84 = 5
												 group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)roda3'), 
												 function ($joins){
												 $joins->on('roda3.kd_bidang','=','dept.kd_bidang')
														 ->on('roda3.kd_unit','=','dept.kd_unit')
														 ->on('roda3.kd_sub','=','dept.kd_sub')
														 ->on('roda3.kd_upb','=','dept.kd_upb');
											 }
								 )
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as pnp,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
											 departments as dept left join
											 '.Module::bmd().'.Ta_KIB_B as kibb 
											 on dept.kd_bidang = kibb.kd_bidang and
												 dept.kd_unit = kibb.kd_unit and
												 dept.kd_sub = kibb.kd_sub and
												 dept.kd_upb = kibb.kd_upb
											 WHERE 
											 kibb.kd_hapus = 0 and
											 kibb.kd_pemilik = 12 and
											 kibb.kd_aset8 = 1 and
											 kibb.kd_aset80 = 3 and
											 kibb.kd_aset81 = 2 and
											 kibb.kd_aset82 = 2 and
											 kibb.kd_aset83 = 1 and
											 kibb.kd_aset84 = 2
											 group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)penumpang'), 
											 function ($joins){
											 $joins->on('penumpang.kd_bidang','=','dept.kd_bidang')
													 ->on('penumpang.kd_unit','=','dept.kd_unit')
													 ->on('penumpang.kd_sub','=','dept.kd_sub')
													 ->on('penumpang.kd_upb','=','dept.kd_upb');
										 }
							 )
					/* ->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as brg,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												 departments as dept left join
												 '.Module::bmd().'.Ta_KIB_B as kibb 
												 on dept.kd_bidang = kibb.kd_bidang and
													 dept.kd_unit = kibb.kd_unit and
													 dept.kd_sub = kibb.kd_sub and
													 dept.kd_upb = kibb.kd_upb
												 WHERE 
												 kibb.kd_hapus = 0 and
												 kibb.kd_pemilik = 12 and
												 kibb.kd_aset8 = 1 and
												 kibb.kd_aset80 = 3 and
												 kibb.kd_aset81 = 2 and
												 kibb.kd_aset82 = 2 and
												 kibb.kd_aset83 = 1 and
												 kibb.kd_aset84 = 3
												 group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)barang'), 
												 function ($joins){
												 $joins->on('barang.kd_bidang','=','dept.kd_bidang')
														 ->on('barang.kd_unit','=','dept.kd_unit')
														 ->on('barang.kd_sub','=','dept.kd_sub')
														 ->on('barang.kd_upb','=','dept.kd_upb');
											 }
								 ) */
					/* ->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as kh,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												 departments as dept left join
												 '.Module::bmd().'.Ta_KIB_B as kibb 
												 on dept.kd_bidang = kibb.kd_bidang and
													 dept.kd_unit = kibb.kd_unit and
													 dept.kd_sub = kibb.kd_sub and
													 dept.kd_upb = kibb.kd_upb
												 WHERE 
												 kibb.kd_hapus = 0 and
												 kibb.kd_pemilik = 12 and
												 kibb.kd_aset8 = 1 and
												 kibb.kd_aset80 = 3 and
												 kibb.kd_aset81 = 2 and
												 kibb.kd_aset82 = 2 and
												 kibb.kd_aset83 = 1 and
												 kibb.kd_aset84 = 6
												 group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)khusus'), 
												 function ($joins){
												 $joins->on('khusus.kd_bidang','=','dept.kd_bidang')
														 ->on('khusus.kd_unit','=','dept.kd_unit')
														 ->on('khusus.kd_sub','=','dept.kd_sub')
														 ->on('khusus.kd_upb','=','dept.kd_upb');
											 }
								 ) 
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as lain,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												 departments as dept left join
												 '.Module::bmd().'.Ta_KIB_B as kibb 
												 on dept.kd_bidang = kibb.kd_bidang and
													 dept.kd_unit = kibb.kd_unit and
													 dept.kd_sub = kibb.kd_sub and
													 dept.kd_upb = kibb.kd_upb
												 WHERE 
												 kibb.kd_hapus = 0 and
												 kibb.kd_pemilik = 12 and
												 kibb.kd_aset8 = 1 and
												 kibb.kd_aset80 = 3 and
												 kibb.kd_aset81 = 2 and
												 kibb.kd_aset82 = 2 and
												 kibb.kd_aset83 = 1 and
												 kibb.kd_aset84 = 9
												 group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)lainnya'), 
												 function ($joins){
												 $joins->on('lainnya.kd_bidang','=','dept.kd_bidang')
														 ->on('lainnya.kd_unit','=','dept.kd_unit')
														 ->on('lainnya.kd_sub','=','dept.kd_sub')
														 ->on('lainnya.kd_upb','=','dept.kd_upb');
											 }
								 )*/
					->select('dept.kd_bidang','dept.kd_unit','dept.kd_sub','dept.kd_upb','dept.name',
										//DB::raw('COUNT(kibb.idpemda) as kendaraantot '),
										DB::raw('ISNULL(kendaraantot.kendaraantotal,0) as kendaraantot '),										
										DB::raw('ISNULL(roda2.rodadua,0) as roda2'),
										DB::raw('ISNULL(roda4.rodaempat,0) as roda4'),
										DB::raw('ISNULL(roda3.rodatiga,0) as roda3'),
										DB::raw('ISNULL(penumpang.pnp,0) as penumpang'),
										//DB::raw('ISNULL(barang.brg,0) as barangs'),
										//DB::raw('ISNULL(khusus.kh,0) as khusus'),
										//DB::raw('ISNULL(lainnya.lain,0) as lainnya'),										
										DB::raw('COUNT(kibb.nomor_bpkb) as nobpkbdiisi'),
										DB::raw('COUNT(kibb.nomor_rangka) as norangkadiisi'),
										DB::raw('COUNT(kibb.nomor_mesin) as nomesindiisi'),
										DB::raw('COUNT(kibbs.bpkb_file) as bpkbdiupload'),
										DB::raw('COUNT(kibbs.stnk_file) as stnkdiupload'),
										DB::raw('ISNULL(rusakberat.kondisi, 0 ) as rusakberat'),
										DB::raw('ISNULL(verifikasidok.verifdok, 0 ) as verifdok'),
										DB::raw('ISNULL(verifikasitax.veriftax, 0 ) as veriftax')
							)
					->distinct()
					->where([
							//['kibb.kd_bidang','=',13],
							//['kibb.kd_unit','=',1],
							//['kibb.kd_sub','=',1],
							//['kibb.kd_upb','=',1],
							['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',2],
							['kibb.kd_aset83','=',1]							
							])					
					->groupBy('dept.kd_bidang','dept.kd_unit','dept.kd_sub','dept.kd_upb','dept.name','kendaraantot.kendaraantotal',
								'roda2.rodadua','roda4.rodaempat','roda3.rodatiga','penumpang.pnp',//'barang.brg',//'khusus.kh','lainnya.lain',
								'rusakberat.kondisi','verifikasidok.verifdok','verifikasitax.veriftax')
					->orderBy('dept.kd_bidang','ASC')
					->orderBy('dept.kd_unit','ASC')
					->orderBy('dept.kd_sub','ASC')
					->orderBy('dept.kd_upb','ASC')
					->get();
			$kendaraan = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->select('kibb.idpemda as count')
					->where([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset8','=',1],
							['kibb.kd_aset80','=',3],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',2],
							['kibb.kd_aset83','=',1]
							])
					->count();
			$kendaraanr2 = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
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
			$kendaraanr3 = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->select('kibb.idpemda as count')
					->where([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset8','=',1],
							['kibb.kd_aset80','=',3],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',2],
							['kibb.kd_aset83','=',1],
							['kibb.kd_aset84','=',5]
							])
					->count();
			$kendaraanr4 = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
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
			$kendaraanrpenumpang = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->select('kibb.idpemda as count')
					->where([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset8','=',1],
							['kibb.kd_aset80','=',3],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',2],
							['kibb.kd_aset83','=',1],
							['kibb.kd_aset84','=',2]
							])
					->count();
			$kendaraanrangkbrg = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->select('kibb.idpemda as count')
					->where([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset8','=',1],
							['kibb.kd_aset80','=',3],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',2],
							['kibb.kd_aset83','=',1],
							['kibb.kd_aset84','=',3]
							])
					->count();
			$kendaraankh = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->select('kibb.idpemda as count')
					->where([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset8','=',1],
							['kibb.kd_aset80','=',3],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',2],
							['kibb.kd_aset83','=',1],
							['kibb.kd_aset84','=',6]
							])
					->count();
			$kendaraanlainnya= DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->select('kibb.idpemda as count')
					->where([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset8','=',1],
							['kibb.kd_aset80','=',3],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',2],
							['kibb.kd_aset83','=',1],
							['kibb.kd_aset84','=',9]
							])				
					->count();
			 $bpkbempty = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->select('kibb.idpemda as count')			
					->whereNull('kibb.nomor_bpkb')				
					->where([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',2],
							['kibb.kd_aset83','=',1]
							])	
					->count();	
			$bpkbnotempty = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->select('kibb.idpemda as count')
					->whereNotNull('kibb.nomor_bpkb')
					->where([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',2],
							['kibb.kd_aset83','=',1]
							])
					->distinct()
					->count();
			$kendaraanhapus = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->select('kibb.idpemda as count')
						->where([['kibb.kd_hapus','=',1],
								['kibb.kd_pemilik','=',12],
								['kibb.kd_aset81','=',2],
								['kibb.kd_aset82','=',2],
								['kibb.kd_aset83','=',1]
								])
						->distinct()
						->count();									
		}else{
			$kdbidang = Module::kdopd()->kd_bidang;
			$kdunit = Module::kdopd()->kd_unit;
			$kdsub = Module::kdopd()->kd_sub;
			$kdupb = Module::kdopd()->kd_upb;
			$refbidang = Module::populatebidanguser()->get();
			$bpkbcount = DB::table('departments as dept')->leftjoin(Module::bmd().'.Ta_KIB_B as kibb',function ($join) {
									$join->on('dept.kd_bidang','=','kibb.kd_bidang')
											->on('dept.kd_unit','=','kibb.kd_unit')
											->on('dept.kd_sub','=','kibb.kd_sub')
											->on('dept.kd_upb','=','kibb.kd_upb');
									}
								)
					->leftjoin('kibbs','kibbs.idpemda','=','kibb.IDPemda')
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as kendaraantotal,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												 departments as dept left join
												 '.Module::bmd().'.Ta_KIB_B as kibb 
												 on dept.kd_bidang = kibb.kd_bidang and
													 dept.kd_unit = kibb.kd_unit and
													 dept.kd_sub = kibb.kd_sub and
													 dept.kd_upb = kibb.kd_upb
												 WHERE 
												 kibb.kd_hapus = 0 and
												 kibb.kd_pemilik = 12 and
												 kibb.kd_aset8 = 1 and
												 kibb.kd_aset80 = 3 and
												 kibb.kd_aset81 = 2 and
												 kibb.kd_aset82 = 2 and
												 kibb.kd_aset83 = 1 
												 group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)kendaraantot'), 
												 function ($joins){
												 $joins->on('kendaraantot.kd_bidang','=','dept.kd_bidang')
														 ->on('kendaraantot.kd_unit','=','dept.kd_unit')
														 ->on('kendaraantot.kd_sub','=','dept.kd_sub')
														 ->on('kendaraantot.kd_upb','=','dept.kd_upb');
											 }
								 )
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
					 ->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as rodadua,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												 departments as dept left join
												 '.Module::bmd().'.Ta_KIB_B as kibb 
												 on dept.kd_bidang = kibb.kd_bidang and
													 dept.kd_unit = kibb.kd_unit and
													 dept.kd_sub = kibb.kd_sub and
													 dept.kd_upb = kibb.kd_upb
												 WHERE 
												 kibb.kd_hapus = 0 and
												 kibb.kd_pemilik = 12 and
												 kibb.kd_aset8 = 1 and
												 kibb.kd_aset80 = 3 and
												 kibb.kd_aset81 = 2 and
												 kibb.kd_aset82 = 2 and
												 kibb.kd_aset83 = 1 and
												 kibb.kd_aset84 = 4
												 group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)roda2'), 
												 function ($joins){
												 $joins->on('roda2.kd_bidang','=','dept.kd_bidang')
														 ->on('roda2.kd_unit','=','dept.kd_unit')
														 ->on('roda2.kd_sub','=','dept.kd_sub')
														 ->on('roda2.kd_upb','=','dept.kd_upb');
											 }
								 )							 
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as rodaempat,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												 departments as dept left join
												 '.Module::bmd().'.Ta_KIB_B as kibb 
												 on dept.kd_bidang = kibb.kd_bidang and
													 dept.kd_unit = kibb.kd_unit and
													 dept.kd_sub = kibb.kd_sub and
													 dept.kd_upb = kibb.kd_upb
												 WHERE 
												 kibb.kd_hapus = 0 and
												 kibb.kd_pemilik = 12 and
												 kibb.kd_aset8 = 1 and
												 kibb.kd_aset80 = 3 and
												 kibb.kd_aset81 = 2 and
												 kibb.kd_aset82 = 2 and
												 kibb.kd_aset83 = 1 and
												 kibb.kd_aset84 = 1
												 group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)roda4'), 
												 function ($joins){
												 $joins->on('roda4.kd_bidang','=','dept.kd_bidang')
														 ->on('roda4.kd_unit','=','dept.kd_unit')
														 ->on('roda4.kd_sub','=','dept.kd_sub')
														 ->on('roda4.kd_upb','=','dept.kd_upb');
											 }
								 )	
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as rodatiga,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												 departments as dept left join
												 '.Module::bmd().'.Ta_KIB_B as kibb 
												 on dept.kd_bidang = kibb.kd_bidang and
													 dept.kd_unit = kibb.kd_unit and
													 dept.kd_sub = kibb.kd_sub and
													 dept.kd_upb = kibb.kd_upb
												 WHERE 
												 kibb.kd_hapus = 0 and
												 kibb.kd_pemilik = 12 and
												 kibb.kd_aset8 = 1 and
												 kibb.kd_aset80 = 3 and
												 kibb.kd_aset81 = 2 and
												 kibb.kd_aset82 = 2 and
												 kibb.kd_aset83 = 1 and
												 kibb.kd_aset84 = 5
												 group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)roda3'), 
												 function ($joins){
												 $joins->on('roda3.kd_bidang','=','dept.kd_bidang')
														 ->on('roda3.kd_unit','=','dept.kd_unit')
														 ->on('roda3.kd_sub','=','dept.kd_sub')
														 ->on('roda3.kd_upb','=','dept.kd_upb');
											 }
								 )
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as pnp,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
											 departments as dept left join
											 '.Module::bmd().'.Ta_KIB_B as kibb 
											 on dept.kd_bidang = kibb.kd_bidang and
												 dept.kd_unit = kibb.kd_unit and
												 dept.kd_sub = kibb.kd_sub and
												 dept.kd_upb = kibb.kd_upb
											 WHERE 
											 kibb.kd_hapus = 0 and
											 kibb.kd_pemilik = 12 and
											 kibb.kd_aset8 = 1 and
											 kibb.kd_aset80 = 3 and
											 kibb.kd_aset81 = 2 and
											 kibb.kd_aset82 = 2 and
											 kibb.kd_aset83 = 1 and
											 kibb.kd_aset84 = 2
											 group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)penumpang'), 
											 function ($joins){
											 $joins->on('penumpang.kd_bidang','=','dept.kd_bidang')
													 ->on('penumpang.kd_unit','=','dept.kd_unit')
													 ->on('penumpang.kd_sub','=','dept.kd_sub')
													 ->on('penumpang.kd_upb','=','dept.kd_upb');
										 }
							 )
					/* ->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as brg,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												 departments as dept left join
												 '.Module::bmd().'.Ta_KIB_B as kibb 
												 on dept.kd_bidang = kibb.kd_bidang and
													 dept.kd_unit = kibb.kd_unit and
													 dept.kd_sub = kibb.kd_sub and
													 dept.kd_upb = kibb.kd_upb
												 WHERE 
												 kibb.kd_hapus = 0 and
												 kibb.kd_pemilik = 12 and
												 kibb.kd_aset8 = 1 and
												 kibb.kd_aset80 = 3 and
												 kibb.kd_aset81 = 2 and
												 kibb.kd_aset82 = 2 and
												 kibb.kd_aset83 = 1 and
												 kibb.kd_aset84 = 3
												 group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)barang'), 
												 function ($joins){
												 $joins->on('barang.kd_bidang','=','dept.kd_bidang')
														 ->on('barang.kd_unit','=','dept.kd_unit')
														 ->on('barang.kd_sub','=','dept.kd_sub')
														 ->on('barang.kd_upb','=','dept.kd_upb');
											 }
								 ) */
					/* ->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as kh,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												 departments as dept left join
												 '.Module::bmd().'.Ta_KIB_B as kibb 
												 on dept.kd_bidang = kibb.kd_bidang and
													 dept.kd_unit = kibb.kd_unit and
													 dept.kd_sub = kibb.kd_sub and
													 dept.kd_upb = kibb.kd_upb
												 WHERE 
												 kibb.kd_hapus = 0 and
												 kibb.kd_pemilik = 12 and
												 kibb.kd_aset8 = 1 and
												 kibb.kd_aset80 = 3 and
												 kibb.kd_aset81 = 2 and
												 kibb.kd_aset82 = 2 and
												 kibb.kd_aset83 = 1 and
												 kibb.kd_aset84 = 6
												 group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)khusus'), 
												 function ($joins){
												 $joins->on('khusus.kd_bidang','=','dept.kd_bidang')
														 ->on('khusus.kd_unit','=','dept.kd_unit')
														 ->on('khusus.kd_sub','=','dept.kd_sub')
														 ->on('khusus.kd_upb','=','dept.kd_upb');
											 }
								 )
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as lain,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												 departments as dept left join
												 '.Module::bmd().'.Ta_KIB_B as kibb 
												 on dept.kd_bidang = kibb.kd_bidang and
													 dept.kd_unit = kibb.kd_unit and
													 dept.kd_sub = kibb.kd_sub and
													 dept.kd_upb = kibb.kd_upb
												 WHERE 
												 kibb.kd_hapus = 0 and
												 kibb.kd_pemilik = 12 and
												 kibb.kd_aset8 = 1 and
												 kibb.kd_aset80 = 3 and
												 kibb.kd_aset81 = 2 and
												 kibb.kd_aset82 = 2 and
												 kibb.kd_aset83 = 1 and
												 kibb.kd_aset84 = 9
												 group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)lainnya'), 
												 function ($joins){
												 $joins->on('lainnya.kd_bidang','=','dept.kd_bidang')
														 ->on('lainnya.kd_unit','=','dept.kd_unit')
														 ->on('lainnya.kd_sub','=','dept.kd_sub')
														 ->on('lainnya.kd_upb','=','dept.kd_upb');
											 }
								 )*/
					->select('dept.kd_bidang','dept.kd_unit','dept.kd_sub','dept.kd_upb','dept.name',										
										//DB::raw('COUNT(kibb.idpemda) as kendaraantot '),
										DB::raw('ISNULL(kendaraantot.kendaraantotal,0) as kendaraantot '),
										DB::raw('ISNULL(roda2.rodadua,0) as roda2'),
										DB::raw('ISNULL(roda4.rodaempat,0) as roda4'),
										DB::raw('ISNULL(roda3.rodatiga,0) as roda3'),
										DB::raw('ISNULL(penumpang.pnp,0) as penumpang'),
										//DB::raw('ISNULL(barang.brg,0) as barangs'),
										//DB::raw('ISNULL(khusus.kh,0) as khusus'),
										//DB::raw('ISNULL(lainnya.lain,0) as lainnya'),
										DB::raw('COUNT(kibb.nomor_bpkb) as nobpkbdiisi'),
										DB::raw('COUNT(kibb.nomor_rangka) as norangkadiisi'),
										DB::raw('COUNT(kibb.nomor_mesin) as nomesindiisi'),
										DB::raw('COUNT(kibbs.bpkb_file) as bpkbdiupload'),
										DB::raw('COUNT(kibbs.stnk_file) as stnkdiupload'),
										DB::raw('ISNULL(rusakberat.kondisi, 0 ) as rusakberat'),
										DB::raw('ISNULL(verifikasidok.verifdok, 0 ) as verifdok'),
										DB::raw('ISNULL(verifikasitax.veriftax, 0 ) as veriftax')									
							)
					->distinct()
					->where([['kibb.kd_bidang','=',$kdbidang],
							['kibb.kd_unit','=',$kdunit],
							['kibb.kd_sub','=',$kdsub],
							//['kibb.kd_upb','=',$kdupb],
							['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',2],
							['kibb.kd_aset83','=',1]
							])
					->groupBy('dept.kd_bidang','dept.kd_unit','dept.kd_sub','dept.kd_upb','dept.name','kendaraantot.kendaraantotal',
								'roda2.rodadua','roda4.rodaempat','roda3.rodatiga','penumpang.pnp',//'barang.brg',//'khusus.kh' ,'lainnya.lain',
								'rusakberat.kondisi','verifikasidok.verifdok','verifikasitax.veriftax')
					->get();
			$kendaraan = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->select('kibb.idpemda as count')			
				->where([
						['kibb.kd_bidang','=',$kdbidang],
						['kibb.kd_unit','=',$kdunit],
						['kibb.kd_sub','=',$kdsub],
						//['kibb.kd_upb','=',$kdupb],
						['kibb.kd_hapus','=',0],
						['kibb.kd_pemilik','=',12],
						['kibb.kd_aset81','=',2],
						['kibb.kd_aset82','=',2],
						['kibb.kd_aset83','=',1]
						])
				->count();
			$kendaraanr2 = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->select('kibb.idpemda as count')
					->where([['kibb.kd_bidang','=',$kdbidang],
							['kibb.kd_unit','=',$kdunit],
							['kibb.kd_sub','=',$kdsub],
							//['kibb.kd_upb','=',$kdupb],
							['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset8','=',1],
							['kibb.kd_aset80','=',3],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',2],
							['kibb.kd_aset83','=',1],
							['kibb.kd_aset84','=',4]
							])				
					->count();
			$kendaraanr3 = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->select('kibb.idpemda as count')
					->where([['kibb.kd_bidang','=',$kdbidang],
							['kibb.kd_unit','=',$kdunit],
							['kibb.kd_sub','=',$kdsub],
							//['kibb.kd_upb','=',$kdupb],
							['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset8','=',1],
							['kibb.kd_aset80','=',3],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',2],
							['kibb.kd_aset83','=',1],
							['kibb.kd_aset84','=',5]
							])				
					->count();
			$kendaraanr4 = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->select('kibb.idpemda as count')
					->where([['kibb.kd_bidang','=',$kdbidang],
							['kibb.kd_unit','=',$kdunit],
							['kibb.kd_sub','=',$kdsub],
							//['kibb.kd_upb','=',$kdupb],					
							['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset8','=',1],
							['kibb.kd_aset80','=',3],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',2],
							['kibb.kd_aset83','=',1],
							['kibb.kd_aset84','=',1]
							])				
					->count();
			$kendaraanrpenumpang = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->select('kibb.idpemda as count')
					->where([['kibb.kd_bidang','=',$kdbidang],
							['kibb.kd_unit','=',$kdunit],
							['kibb.kd_sub','=',$kdsub],
							//['kibb.kd_upb','=',$kdupb],
							['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset8','=',1],
							['kibb.kd_aset80','=',3],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',2],
							['kibb.kd_aset83','=',1],
							['kibb.kd_aset84','=',2]
							])				
					->count();
			$kendaraanrangkbrg = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->select('kibb.idpemda as count')
					->where([['kibb.kd_bidang','=',$kdbidang],
							['kibb.kd_unit','=',$kdunit],
							['kibb.kd_sub','=',$kdsub],
							//['kibb.kd_upb','=',$kdupb],
							['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset8','=',1],
							['kibb.kd_aset80','=',3],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',2],
							['kibb.kd_aset83','=',1],
							['kibb.kd_aset84','=',3]
							])				

					->count();
			$kendaraankh = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->select('kibb.idpemda as count')
					->where([['kibb.kd_bidang','=',$kdbidang],
							['kibb.kd_unit','=',$kdunit],
							['kibb.kd_sub','=',$kdsub],
							//['kibb.kd_upb','=',$kdupb],
							['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset8','=',1],
							['kibb.kd_aset80','=',3],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',2],
							['kibb.kd_aset83','=',1],
							['kibb.kd_aset84','=',6]
							])				
					->count();
			$kendaraanlainnya= DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->select('kibb.idpemda as count')
					->where([['kibb.kd_bidang','=',$kdbidang],
							['kibb.kd_unit','=',$kdunit],
							['kibb.kd_sub','=',$kdsub],
							//['kibb.kd_upb','=',$kdupb],
							['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset8','=',1],
							['kibb.kd_aset80','=',3],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',2],
							['kibb.kd_aset83','=',1],
							['kibb.kd_aset84','=',9]
							])				
					->count();
			 $bpkbempty = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->select('kibb.idpemda as count')		
					->whereNull('kibb.nomor_bpkb')				
					->where([
							['kibb.kd_bidang','=',$kdbidang],
							['kibb.kd_unit','=',$kdunit],
							['kibb.kd_sub','=',$kdsub],
							//['kibb.kd_upb','=',$kdupb],
							['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',2],
							['kibb.kd_aset83','=',1]
							])	
					->count();	
			$bpkbnotempty = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->select('kibb.idpemda as count')
					->whereNotNull('kibb.nomor_bpkb')				
					->where([
							['kibb.kd_bidang','=',$kdbidang],
							['kibb.kd_unit','=',$kdunit],
							['kibb.kd_sub','=',$kdsub],
							//['kibb.kd_upb','=',$kdupb],
							['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_aset81','=',2],
							['kibb.kd_aset82','=',2],
							['kibb.kd_aset83','=',1]
							])
					->count();
			$kendaraanhapus = DB::table(Module::bmd().'.Ta_KIB_B as kibb')
					->select('kibb.idpemda as count')
						->where([
								['kibb.kd_bidang','=',$kdbidang],
								['kibb.kd_unit','=',$kdunit],
								['kibb.kd_sub','=',$kdsub],
								//['kibb.kd_upb','=',$kdupb],
								['kibb.kd_hapus','=',1],
								['kibb.kd_pemilik','=',12],
								['kibb.kd_aset81','=',2],
								['kibb.kd_aset82','=',2],
								['kibb.kd_aset83','=',1]
								])
						->count();	
			
		}
			//dd($bpkbcount);
		if(Module::hasAccess($module->id)) {
			 return View('la.kendaraans.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module,
				'bpkbcount' => $bpkbcount,
				'bpkbempty' => $bpkbempty,
				'bpkbnotempty' => $bpkbnotempty,
				'kendaraan' => $kendaraan,
				'kendaraanr2' => $kendaraanr2,
				'kendaraanr3' => $kendaraanr3,
				'kendaraanr4' => $kendaraanr4,
				'kendaraanrpenumpang' => $kendaraanrpenumpang,
				'kendaraanrangkbrg' => $kendaraanrangkbrg,
				'kendaraankh' => $kendaraankh,
				'kendaraanlainnya' => $kendaraanlainnya,
				'kendaraanhapus' => $kendaraanhapus,
				'refbidang' => $refbidang
			]);

		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}else{
		return view('errors.404');
	}
		
	}
	/**
	 * Show the form for creating a new kendaraan.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(){
		//
	}

	/**
	 * Store a newly created kendaraan in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request){
		if(Module::hasAccess("Kendaraans", "create")) {
		
			$rules = Module::validateRules("Kendaraans", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Kendaraans", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.kendaraans.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified kendaraan.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id){
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$kendaraan = Kibb::findOrFail($id);
		//$cekuser = Module::showkendaraanuser($id)->get();
		
		try {
		  if(Module::hasAccess("Kendaraans", "view")) {
			
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
					return view('la.kendaraans.show', [
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
	 * Show the form for editing the specified kendaraan.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id){
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$cekuser = Module::showkendaraanuser($id)->get();
		try {
			if(Module::hasAccess("Kendaraans", "edit")) {			
				$kendaraan = Kibb::findOrFail($id);
				if($kdbidang == 99 || $kdbidang == 0 ){			
					$kendaraans = Module::showkendaraanadmin($id)->get();
				}else{
					$kendaraans = Module::showkendaraanuser($id)->get();
				}
				if(isset($kendaraans[0]->id)) {		
					$module = Module::get('Kendaraans');				
					$module->row = $kendaraan;

					return view('la.kendaraans.edit', [
						'module' => $module,
						'view_col' => $this->view_col,
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
	 * Update the specified kendaraan in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id){
		if(Module::hasAccess("Kendaraans", "edit")) {
			
			$rules = Module::validateRules("Kendaraans", $request, true);			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Kendaraans", $request, $id);
			$update = Kibb::find($id);
			$update->verification_status 	= 0;			
			$update->verification_by 	= 0;			
			$update->verification_tax_status = 0;	
			$update->save();
			//return redirect()->route(config('laraadmin.adminRoute') . '.kendaraans#lists');
			return redirect(config('laraadmin.adminRoute') .'/kendaraans#lists');
			
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
						->update(['rack_no' => $request->input('rackid')]);
				$res['status'] = "Berhasil!";
				return $res;
			 }else{
				$res['status'] = "Data Not Found!";
				return $res;
			}		
		}
	/**
	 * Remove the specified kendaraan from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id){
		if(Module::hasAccess("Kendaraans", "delete")) {
			Kendaraan::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.kendaraans.index');
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
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		
		 if($kdbidang == 99 || $kdbidang == 0 ){
						
			$values = DB::table('kibbs')->leftjoin(Module::bmd().'.Ta_KIB_B as kibb','kibbs.idpemda','=','kibb.IDPemda')
				->leftjoin('racks','racks.id','=','kibbs.rack_no')
				->leftjoin('storages','storages.id','=','racks.storage')
				->leftjoin('uploads as uploadstnk','uploadstnk.id','=','kibbs.stnk_file')
				->leftjoin('uploads as uploadphoto','uploadphoto.id','=','kibbs.photo')
				->leftjoin('uploads as uploadbpkb','uploadbpkb.id','=','kibbs.photo')
				->select('kibbs.id','kibbs.IDPemda','kibb.merk','kibb.type','kibb.cc',
				'kibb.tgl_perolehan','kibb.nomor_rangka',
				'kibb.nomor_mesin','kibb.nomor_polisi','kibb.nomor_bpkb','uploadbpkb.name as bpkb_file',
				'kibbs.rack_no','storages.storage_name','uploadstnk.name','uploadphoto.name as photo','kibbs.verification_status')
				->where([['kibb.kd_hapus','=',0],
						['kibb.kd_pemilik','=',12],
						['kibb.kd_aset81','=',2],
						['kibb.kd_aset82','=',2]
						]);	
		}else{

			$values = DB::table('kibbs')->leftjoin(Module::bmd().'.Ta_KIB_B as kibb','kibbs.idpemda','=','kibb.IDPemda')
				->leftjoin('racks','racks.id','=','kibbs.rack_no')
				->leftjoin('storages','storages.id','=','racks.storage')
				->leftjoin('uploads as uploadstnk','uploadstnk.id','=','kibbs.stnk_file')
				->leftjoin('uploads as uploadphoto','uploadphoto.id','=','kibbs.photo')
				->leftjoin('uploads as uploadbpkb','uploadbpkb.id','=','kibbs.photo')
				->select('kibbs.id','kibbs.IDPemda','kibb.merk','kibb.type','kibb.cc',
				'kibb.tgl_perolehan','kibb.nomor_rangka',
				'kibb.nomor_mesin','kibb.nomor_polisi','kibb.nomor_bpkb','uploadbpkb.name as bpkb_file',
				'kibbs.rack_no as rack_no','kibbs.type as storage_name','uploadstnk.name','uploadphoto.name as photo','kibbs.verification_status')
				->where([['kibb.kd_hapus','=',0],
						['kibb.kd_pemilik','=',12],
						['kibb.kd_aset81','=',2],
						['kibb.kd_aset82','=',2],
						['kibb.kd_bidang','=',$kdbidang],
						['kibb.kd_unit','=',$kdunit]
						]);
		}		
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Kendaraans');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/kendaraans/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Kendaraans", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/kendaraans/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Kendaraans", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.kendaraans.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					$output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
					$output .= Form::close();
				}
				$data->data[$i][] = (string)$output;
			}
		}
		$out->setData($data);
		return $out;
	}
}
