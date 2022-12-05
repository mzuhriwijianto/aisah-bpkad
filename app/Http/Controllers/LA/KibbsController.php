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
use App\Models\Kibb;
use PDF;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PHPSpreadsheet\Worksheet;


class KibbsController extends Controller
{
	public $show_action = true;
	public $view_col = 'idpemda';
	public $listing_cols = ['id', 'idpemda', 'merk', 'type', 'cc', 'tgl_perolehan', 'nomor_rangka', 'nomor_mesin', 'nomor_polisi', 'nomor_bpkb','harga','kd_bidang', 'kd_unit', 'kd_sub', 'kd_upb', 'bpkb_file','rack_no', 'storage_no','stnk_file','photo'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Kibbs', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Kibbs', $this->listing_cols);
		}
	}
		/* print */
	public function label($id){
		$kdbidang = Module::kdopd()->kd_bidang;

		if(Module::hasAccess("Kibbs", "view")) {		
			if($kdbidang == 99 || $kdbidang == 0 ){			
					$kibbitem = Module::kibbitemadmin($id);	
					$kibbitemarray = json_decode(json_encode($kibbitem[0]), true);
					
				    $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'isJavascriptEnabled' , true])
							->loadView('la.report.label',['kibbitem' => $kibbitem])
							->setPaper('Folio', 'landscape');
					return $pdf->stream('Label_'.Module::userlogin()->dept_name.'.pdf');
					//return view('la.report.label',['kibbitem' => $kibbitem]);
			}else{
					$kibbitem = Module::kibbitem($id);
					$kibbitemarray = json_decode(json_encode($kibbitem[0]), true);
				   $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'isJavascriptEnabled' , true])
							->loadView('la.report.label',['kibbitem' => $kibbitem])
							->setPaper('Folio', 'landscape');
					return $pdf->stream('Label_',Module::userlogin()->dept_name.'.pdf');
					//return view('la.report.label',['kibbitem' => $kibbitem]);
			}
		}else{
			return view(abort(403, 'Unauthorized action.'));
		}		 
	}
	/* end */
	public function printkibball($kdbidangs,$kdunits,$kdsubs,$ids,$idss,$ids3,$ids4,$kond){
		$kdbidang = Module::kdopd()->kd_bidang;		
		$idrek0  = (int)$ids;
		$idrek1  = (int)$idss;
		$idrek3  = (int)$ids3;
		$idrek4  = (int)$ids4;
		$konds  = (int)$kond;
		
		if(Module::hasAccess("Kibbs", "view")) {
				
			if($kdbidang == 99 || $kdbidang == 0 ){			
					$kibbitem = Module::kibball($kdbidangs,$kdunits,$kdsubs,$ids,$idss,$ids3,$ids4,$kond);	
					$kibbitemarray = json_decode(json_encode($kibbitem[0]), true);
					//dd($kibbitem);
				    $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'isJavascriptEnabled' , true])
							->loadView('la.report.printkibball',['kibbitem' => $kibbitem])
							->setPaper('folio', 'landscape');
					return $pdf->download('KIB-PM'.Module::userlogin()->dept_name.'.pdf');
					//return view('la.report.printkibball',['kibbitem' => $kibbitem]);
			}else{
					$kdunit = Module::kdopd()->kd_unit;
					$kdsub = Module::kdopd()->kd_sub;
					$kibbitem = Module::kibball($kdbidang,$kdunit,$kdsub,$ids,$idss,$ids3,$ids4,$kond);
					$kibbitemarray = json_decode(json_encode($kibbitem[0]), true);
				   $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'isJavascriptEnabled' , true])
							->loadView('la.report.printkibball',['kibbitem' => $kibbitem])
							->setPaper('folio', 'landscape');
					return $pdf->download('KIB-PM'.Module::userlogin()->dept_name.'.pdf');
					//return view('la.report.printkibball',['kibbitem' => $kibbitem]);
			}
		}else{
			return view(abort(403, 'Unauthorized action.'));
		}			 
	}
	public function csvkibball($kdbidangs,$kdunits,$kdsubs,$ids,$idss,$ids3,$ids4,$kond){
		$kdbidang = Module::kdopd()->kd_bidang;		
		$idrek0  = (int)$ids;
		$idrek1  = (int)$idss;
		$idrek3  = (int)$ids3;
		$idrek4  = (int)$ids4;
		$konds  = (int)$kond;
		
		if(Module::hasAccess("Kibbs", "view")) {
				
			if($kdbidang == 99 || $kdbidang == 0 ){			
											
				$inputFileType = 'Xls'; // Xlsx - Xml - Ods - Slk - Gnumeric - Csv
				$inputFileName = public_path('storage\format\format_kibb.xls');
				$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);				
				$spreadsheet = new Spreadsheet();
				$spreadsheet = $reader->load($inputFileName);
				$sheet = $spreadsheet->getActiveSheet();
				
				$kibbitem = Module::kibball($kdbidangs,$kdunits,$kdsubs,$ids,$idss,$ids3,$ids4,$kond);
				$cell = 10;
				foreach($kibbitem as $index=>$kibbitems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);
					$sheet->setCellValue('B3', $kibbitems->nm_sub_unit);
					$sheet->setCellValue('B'.$cell, $kibbitems->kd_barang);				
					$sheet->setCellValue('C'.$cell, $kibbitems->Nm_Aset5);
					$sheet->setCellValue('D'.$cell, $kibbitems->no_reg);
					$sheet->setCellValue('E'.$cell, $kibbitems->merk.'/'.$kibbitems->type);
					$sheet->setCellValue('F'.$cell, $kibbitems->cc);
					$sheet->setCellValue('G'.$cell, $kibbitems->bahan);					
					$sheet->setCellValue('H'.$cell, date('Y', strtotime($kibbitems->tgl_perolehan)));
					$sheet->setCellValue('I'.$cell, $kibbitems->nomor_pabrik);
					$sheet->setCellValue('J'.$cell, $kibbitems->nomor_rangka);
					$sheet->setCellValue('K'.$cell, $kibbitems->nomor_mesin);
					$sheet->setCellValue('L'.$cell, $kibbitems->nomor_polisi);
					$sheet->setCellValue('M'.$cell, $kibbitems->nomor_bpkb);
					$sheet->setCellValue('N'.$cell, $kibbitems->Asal_usul);
					$sheet->setCellValue('O'.$cell, $kibbitems->kondisi);
					$sheet->setCellValue('P'.$cell, $kibbitems->harga);
					$sheet->setCellValue('Q'.$cell, $kibbitems->keterangan);
					$sheet->setCellValue('T'.$cell, $kibbitems->kondisi);
					$sheet->setCellValue('U'.$cell, $kibbitems->kondisi_akhir);

					if($kibbitems->imgname != ''){
						$drawing = new Drawing();
						$drawing->setName('Logo');
						$drawing->setDescription('This is my logo');					
						$drawing->setPath(public_path('storage\imgkib\Image\\'.$kibbitems->imgname));
						$drawing->setHeight(100);
						$drawing->setWidth(100);
						$drawing->setCoordinates('W'.$cell);
						$drawing->setWorksheet($spreadsheet->getActiveSheet());
						$sheet->setCellValue('R'.$cell, 'Ada');
						$sheet->setCellValue('S'.$cell, '-');
					}else{
						$sheet->setCellValue('W'.$cell, 'No Pic');
						$sheet->setCellValue('R'.$cell, '-');
						$sheet->setCellValue('S'.$cell, 'Tidak Ada');
					}
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(100);
					$cell++;
				}
				$writer = new Xlsx($spreadsheet);        
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="KIBB_export.xlsx"');
				$writer->save('php://output');
			}else{
				$kdunit = Module::kdopd()->kd_unit;
				$kdsub = Module::kdopd()->kd_sub;
				$inputFileType = 'Xls'; // Xlsx - Xml - Ods - Slk - Gnumeric - Csv
				$inputFileName = public_path('storage\format\format_kibb.xls');
				$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);				
				$spreadsheet = new Spreadsheet();
				$spreadsheet = $reader->load($inputFileName);
				$sheet = $spreadsheet->getActiveSheet();
												
				$kibbitem = Module::kibball($kdbidang,$kdunit,$kdsub,$ids,$idss,$ids3,$ids4,$kond);
				$cell = 10;
				foreach($kibbitem as $index=>$kibbitems){
					
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);
					$sheet->setCellValue('B3', $kibbitems->nm_sub_unit);
					$sheet->setCellValue('B'.$cell, $kibbitems->kd_barang);
					$sheet->setCellValue('C'.$cell, $kibbitems->Nm_Aset5);
					$sheet->setCellValue('D'.$cell, $kibbitems->no_reg);
					$sheet->setCellValue('E'.$cell, $kibbitems->merk.'/'.$kibbitems->type);
					$sheet->setCellValue('F'.$cell, $kibbitems->cc);
					$sheet->setCellValue('G'.$cell, $kibbitems->bahan);					
					$sheet->setCellValue('H'.$cell, date('Y', strtotime($kibbitems->tgl_perolehan)));
					$sheet->setCellValue('I'.$cell, $kibbitems->nomor_pabrik);
					$sheet->setCellValue('J'.$cell, $kibbitems->nomor_rangka);
					$sheet->setCellValue('K'.$cell, $kibbitems->nomor_mesin);
					$sheet->setCellValue('L'.$cell, $kibbitems->nomor_polisi);
					$sheet->setCellValue('M'.$cell, $kibbitems->nomor_bpkb);
					$sheet->setCellValue('N'.$cell, $kibbitems->Asal_usul);
					$sheet->setCellValue('O'.$cell, $kibbitems->kondisi);
					$sheet->setCellValue('P'.$cell, $kibbitems->harga);
					$sheet->setCellValue('Q'.$cell, $kibbitems->keterangan);
					$sheet->setCellValue('T'.$cell, $kibbitems->kondisi);
					$sheet->setCellValue('U'.$cell, $kibbitems->kondisi_akhir);
					
					if($kibbitems->imgname != ''){
						$drawing = new Drawing();
						$drawing->setName('Logo');
						$drawing->setDescription('This is my logo');					
						$drawing->setPath(public_path('storage\imgkib\Image\\'.$kibbitems->imgname));
						$drawing->setHeight(100);
						$drawing->setWidth(100);
						$drawing->setCoordinates('W'.$cell);
						$drawing->setWorksheet($spreadsheet->getActiveSheet());
						$sheet->setCellValue('R'.$cell, 'Ada');
						$sheet->setCellValue('S'.$cell, '-');
					}else{
						$sheet->setCellValue('W'.$cell, 'No Pic');
						$sheet->setCellValue('R'.$cell, '-');
						$sheet->setCellValue('S'.$cell, 'Tidak Ada');
					}
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(100);
					$cell++;
				}
				$writer = new Xlsx($spreadsheet);        
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="KIBB_export.xlsx"');
				$writer->save('php://output');
			}
		}else{
			return view(abort(403, 'Unauthorized action.'));
		}			 
	}
	
	public function csvkibballupb($kdbidangs,$kdunits,$kdsubs,$kdupb,$ids,$idss,$ids3,$ids4,$kond){
		$kdbidang = Module::kdopd()->kd_bidang;		
		$idrek0  = (int)$ids;
		$idrek1  = (int)$idss;
		$idrek3  = (int)$ids3;
		$idrek4  = (int)$ids4;
		$konds  = (int)$kond;
		
		if(Module::hasAccess("Kibbs", "view")) {
				
			if($kdbidang == 99 || $kdbidang == 0 ){			
											
				$inputFileType = 'Xls'; // Xlsx - Xml - Ods - Slk - Gnumeric - Csv
				$inputFileName = public_path('storage\format\format_kibb.xls');
				$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);				
				$spreadsheet = new Spreadsheet();
				$spreadsheet = $reader->load($inputFileName);
				$sheet = $spreadsheet->getActiveSheet();
				
				$kibbitem = Module::kibballupb($kdbidangs,$kdunits,$kdsubs,$kdupb,$ids,$idss,$ids3,$ids4,$kond);
				$cell = 10;
				foreach($kibbitem as $index=>$kibbitems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);
					$sheet->setCellValue('B3', $kibbitems->nm_sub_unit);
					$sheet->setCellValue('B'.$cell, $kibbitems->kd_barang);				
					$sheet->setCellValue('C'.$cell, $kibbitems->Nm_Aset5);
					$sheet->setCellValue('D'.$cell, $kibbitems->no_reg);
					$sheet->setCellValue('E'.$cell, $kibbitems->merk.'/'.$kibbitems->type);
					$sheet->setCellValue('F'.$cell, $kibbitems->cc);
					$sheet->setCellValue('G'.$cell, $kibbitems->bahan);					
					$sheet->setCellValue('H'.$cell, date('Y', strtotime($kibbitems->tgl_perolehan)));
					$sheet->setCellValue('I'.$cell, $kibbitems->nomor_pabrik);
					$sheet->setCellValue('J'.$cell, $kibbitems->nomor_rangka);
					$sheet->setCellValue('K'.$cell, $kibbitems->nomor_mesin);
					$sheet->setCellValue('L'.$cell, $kibbitems->nomor_polisi);
					$sheet->setCellValue('M'.$cell, $kibbitems->nomor_bpkb);
					$sheet->setCellValue('N'.$cell, $kibbitems->Asal_usul);
					$sheet->setCellValue('O'.$cell, $kibbitems->kondisi);
					$sheet->setCellValue('P'.$cell, $kibbitems->harga);
					$sheet->setCellValue('Q'.$cell, $kibbitems->keterangan);
					$sheet->setCellValue('T'.$cell, $kibbitems->kondisi);
					$sheet->setCellValue('U'.$cell, $kibbitems->kondisi_akhir);

					if($kibbitems->imgname != ''){
						$drawing = new Drawing();
						$drawing->setName('Logo');
						$drawing->setDescription('This is my logo');					
						$drawing->setPath(public_path('storage\imgkib\Image\\'.$kibbitems->imgname));
						$drawing->setHeight(100);
						$drawing->setWidth(100);
						$drawing->setCoordinates('W'.$cell);
						$drawing->setWorksheet($spreadsheet->getActiveSheet());
						$sheet->setCellValue('R'.$cell, 'Ada');
						$sheet->setCellValue('S'.$cell, '-');
					}else{
						$sheet->setCellValue('W'.$cell, 'No Pic');
						$sheet->setCellValue('R'.$cell, '-');
						$sheet->setCellValue('S'.$cell, 'Tidak Ada');
					}
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(100);
					$cell++;
				}
				$writer = new Xlsx($spreadsheet);        
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="KIBB_export.xlsx"');
				$writer->save('php://output');
			}else{
				$kdunit = Module::kdopd()->kd_unit;
				$kdsub = Module::kdopd()->kd_sub;
				$inputFileType = 'Xls'; // Xlsx - Xml - Ods - Slk - Gnumeric - Csv
				$inputFileName = public_path('storage\format\format_kibb.xls');
				$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);				
				$spreadsheet = new Spreadsheet();
				$spreadsheet = $reader->load($inputFileName);
				$sheet = $spreadsheet->getActiveSheet();
												
				$kibbitem = Module::kibballupb($kdbidang,$kdunit,$kdsub,$kdupb,$ids,$idss,$ids3,$ids4,$kond);
				$cell = 10;
				foreach($kibbitem as $index=>$kibbitems){
					
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);
					$sheet->setCellValue('B3', $kibbitems->nm_sub_unit);
					$sheet->setCellValue('B'.$cell, $kibbitems->kd_barang);
					$sheet->setCellValue('C'.$cell, $kibbitems->Nm_Aset5);
					$sheet->setCellValue('D'.$cell, $kibbitems->no_reg);
					$sheet->setCellValue('E'.$cell, $kibbitems->merk.'/'.$kibbitems->type);
					$sheet->setCellValue('F'.$cell, $kibbitems->cc);
					$sheet->setCellValue('G'.$cell, $kibbitems->bahan);					
					$sheet->setCellValue('H'.$cell, date('Y', strtotime($kibbitems->tgl_perolehan)));
					$sheet->setCellValue('I'.$cell, $kibbitems->nomor_pabrik);
					$sheet->setCellValue('J'.$cell, $kibbitems->nomor_rangka);
					$sheet->setCellValue('K'.$cell, $kibbitems->nomor_mesin);
					$sheet->setCellValue('L'.$cell, $kibbitems->nomor_polisi);
					$sheet->setCellValue('M'.$cell, $kibbitems->nomor_bpkb);
					$sheet->setCellValue('N'.$cell, $kibbitems->Asal_usul);
					$sheet->setCellValue('O'.$cell, $kibbitems->kondisi);
					$sheet->setCellValue('P'.$cell, $kibbitems->harga);
					$sheet->setCellValue('Q'.$cell, $kibbitems->keterangan);
					$sheet->setCellValue('T'.$cell, $kibbitems->kondisi);
					$sheet->setCellValue('U'.$cell, $kibbitems->kondisi_akhir);
					
					if($kibbitems->imgname != ''){
						$drawing = new Drawing();
						$drawing->setName('Logo');
						$drawing->setDescription('This is my logo');					
						$drawing->setPath(public_path('storage\imgkib\Image\\'.$kibbitems->imgname));
						$drawing->setHeight(100);
						$drawing->setWidth(100);
						$drawing->setCoordinates('W'.$cell);
						$drawing->setWorksheet($spreadsheet->getActiveSheet());
						$sheet->setCellValue('R'.$cell, 'Ada');
						$sheet->setCellValue('S'.$cell, '-');
					}else{
						$sheet->setCellValue('W'.$cell, 'No Pic');
						$sheet->setCellValue('R'.$cell, '-');
						$sheet->setCellValue('S'.$cell, 'Tidak Ada');
					}
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(100);
					$cell++;
				}
				$writer = new Xlsx($spreadsheet);        
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="KIBB_export.xlsx"');
				$writer->save('php://output');
			}
		}else{
			return view(abort(403, 'Unauthorized action.'));
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
	
	public function upb($ids,$idss,$idsss){
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$kdsub = Module::kdopd()->kd_sub;
		$kdupb = Module::kdopd()->kd_upb;
		
		if($kdbidang == 99 || $kdbidang == 0 ){
			$upb = Module::populateupbadmin($ids,$idss,$idsss)->pluck('Nm_UPB', 'kd_upb');
			return json_encode($upb);
		}else{
			$upb = Module::populateupbuser($kdbidang,$kdunit,$kdsub)->pluck('Nm_UPB', 'kd_upb');
			return json_encode($upb);
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
	
	public function imageupload(Request $request){
		  $this->validate($request,[
			'file' => 'mimes:jpeg,jpg,png,bmp,tiff |max:2000',
		  ],
			$messages = [
				'required' => 'The :attribute field is required.',
				'mimes' => 'Only jpeg,jpeg, png, bmp,tiff are allowed.'
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
				
				/* $data = " update kibbs set imgid = '".$fileModel->id."',pemegang_brg = '".$request->input('pgw')."'			
								WHERE
									idpemda = '".$request->input('inputidpemda')."'
								"
								;
				DB::statement($data); */
				$update = Kibb::find($request->input('inputidpemda'));
				$update->imgid 	= $fileModel->id;			
				$update->pemegang_brg 	= $request->input('pgw');
				$update->save();
				//dd($data);
				/* return back()
				->with('success','File has been uploaded.')
				->with('file', $fileName); */
				//session()->flash('message', 'success');
				//return url(config('laraadmin.adminRoute') .'/kibbs#lists');
				return redirect(config('laraadmin.adminRoute') .'/kibbs#lists');
				//->with('success','File has been uploaded.')
				//->with('file', $fileName); */
				//return redirect()->route(config('laraadmin.adminRoute') . '.kibbs#lists');
			}
	   }
	   
	
public function loadDatakibbs(Request $request,$kdbidangs,$kdunits,$kdsubs,$ids,$idss,$ids3,$ids4,$kond){
	if(Module::hasAccess("kibbs", "view")) {
				$kdbidang = Module::kdopd()->kd_bidang;
				$idrek0  = (int)$ids;
				$idrek1  = (int)$idss;
				$idrek3  = (int)$ids3;
				$idrek4  = (int)$ids4;
				$konds  = (int)$kond;
				
				//$data = Module::pmuser($kdbidangs,$kdunits,$kdsubs,$idrek0,$idrek1,$idrek3,$idrek4,$konds)->get();
				//dd($data,$kdbidangs,$kdunits,$kdsubs,$idrek0,$idrek1,$idrek3,$idrek4,$konds);
			if ($request->ajax()) {
					$output = '';
					$query = $request->get('query');
					if ($query != '') {
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::pmadminquery($kdbidangs,$kdunits,$kdsubs,$query)->get();
						}else{
							$data = Module::pmuserquery($kdbidangs,$kdunits,$kdsubs,$query)->get();	
						}
					} else {
						if($kdbidang == 99 || $kdbidang == 0 ){
							
							$data = Module::pmadmin($kdbidangs,$kdunits,$kdsubs,$idrek0,$idrek1,$idrek3,$idrek4,$konds)->get();	
							
						}else{
							$kdunit = Module::kdopd()->kd_unit;
							$kdsub = Module::kdopd()->kd_sub;
							$kdupb = Module::kdopd()->kd_upb;
							$data = Module::pmuser($kdbidangs,$kdunits,$kdsubs,$idrek0,$idrek1,$idrek3,$idrek4,$konds)->get();
						}
					}
					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index=> $row){
						   $index = $index+1;
						   if(Module::hasAccess("kibbs", "edit")){
							$output .= '
							<tr>
							 <td>'.$index.'</td>
							 <td>'.$row->kd_barang.'</td>
							 <td>'.$row->IDPemda.'</td>						 
							 <td>'.$row->Dept.'</td>						 
							 <td>'.$row->Nm_Aset5.'</td>
							 <td>'.$row->no_register.'</td>
							 <td>'.date('Y', strtotime($row->tgl_perolehan)).'</td>									 						 					 
							 <td>'.date('d-m-Y', strtotime($row->tgl_perolehan)).'</td>
							 <td>'.$row->merk.'/'.$row->type.'</td>
							 <td>'.$row->nomor_polisi.'</td>
							 <td>'.$row->nomor_rangka.'</td>
							 <td>'.$row->nomor_mesin.'</td>
							 <td>'.$row->hargainduk.'</td>
							 <td>'.$row->hargakap.'</td>
							 <td>'.$row->keterangan.'</td>
							 <td>'.$row->nama.'</td>
							 <td>'.(($row->imgname == ''  OR $row->imgname == 0) ? 
							 '<i> no pic </i>' : '<img src="'.url('/storage/imgkib/Image/'.$row->imgname).'"alt="gambar" width = "190" height = "160"/> '
							 ).'</td>
							 <td>							
							 <button id = "getidbutton" value = '.$row->idkibb.' class="btn btn-warning" data-toggle="modal"  onclick = "getInputValue(this);" >Edit Barang</button>							 						 							 
							 <td>
							 <a href="'.url(config('laraadmin.adminRoute') . '/label/'.$row->idkibb).'" target="_blank"><button  class="btn btn-info">Print Label</button></a>	
							 </td>
							</tr>';
						   }else{
							   $output .= '
							<tr>
							 <td>'.$index.'</td>
							 <td>'.$row->IDPemda.'</td>						 
							 <td>'.$row->Dept.'</td>						 
							 <td>'.$row->Nm_Aset5.'</td>
							 <td>'.$row->no_register.'</td>
							 <td>'.date('Y', strtotime($row->tgl_perolehan)).'</td>									 						 					 
							 <td>'.date('d-m-Y', strtotime($row->tgl_perolehan)).'</td>
							 <td>'.$row->merk.'/'.$row->type.'</td>
							 <td>'.$row->nomor_polisi.'</td>
							 <td>'.$row->nomor_rangka.'</td>
							 <td>'.$row->nomor_mesin.'</td>
							 <td>'.$row->hargainduk.'</td>
							 <td>'.$row->hargakap.'</td>
							 <td>'.$row->keterangan.'</td>
							 <td>'.$row->nama.'</td>
							 <td>'.(($row->imgname == ''  OR $row->imgname == 0) ? 
							 '<i> no pic </i>' : '<img src="'.url('/storage/imgkib/Image/'.$row->imgname).'"alt="gambar" width = "190" height = "160"/> '
							 ).'</td>>
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

				  echo json_encode($data);
			}
		}else{
			return view('errors.404');
		}            
    }

public function loadDatakibbsupb(Request $request,$kdbidangs,$kdunits,$kdsubs,$kdupbs,$ids,$idss,$ids3,$ids4,$kond){
	if(Module::hasAccess("kibbs", "view")) {
				$kdbidang = Module::kdopd()->kd_bidang;
				$idrek0  = (int)$ids;
				$idrek1  = (int)$idss;
				$idrek3  = (int)$ids3;
				$idrek4  = (int)$ids4;
				$konds  = (int)$kond;
				
				//$data = Module::pmadminupb($kdbidangs,$kdunits,$kdsubs,$kdupbs,$idrek0,$idrek1,$idrek3,$idrek4,$konds)->get();
				//dd($data,$kdbidangs,$kdunits,$kdsubs,$kdupbs,$idrek0,$idrek1,$idrek3,$idrek4,$konds);
			if ($request->ajax()) {
					$output = '';
					$query = $request->get('query');
					if ($query != '') {
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::pmadminquery($kdbidangs,$kdunits,$kdsubs,$query)->get();
						}else{
							$data = Module::pmuserquery($kdbidangs,$kdunits,$kdsubs,$query)->get();	
						}
					} else {
						if($kdbidang == 99 || $kdbidang == 0 ){
							
							$data = Module::pmadminupb($kdbidangs,$kdunits,$kdsubs,$kdupbs,$idrek0,$idrek1,$idrek3,$idrek4,$konds)->get();	
							
						}else{
							//$kdunit = Module::kdopd()->kd_unit;
							//$kdsub = Module::kdopd()->kd_sub;
							//$kdupb = Module::kdopd()->kd_upb;
							$data = Module::pmuserupb($kdbidangs,$kdunits,$kdsubs,$kdupbs,$idrek0,$idrek1,$idrek3,$idrek4,$konds)->get();
						}
					}
					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index=> $row){
						   $index = $index+1;
						   if(Module::hasAccess("kibbs", "edit")){
							$output .= '
							<tr>
							 <td>'.$index.'</td>
							 <td>'.$row->kd_barang.'</td>
							 <td>'.$row->IDPemda.'</td>						 
							 <td>'.$row->Dept.'</td>						 
							 <td>'.$row->Nm_Aset5.'</td>
							 <td>'.$row->no_register.'</td>
							 <td>'.date('Y', strtotime($row->tgl_perolehan)).'</td>									 						 					 
							 <td>'.date('d-m-Y', strtotime($row->tgl_perolehan)).'</td>
							 <td>'.$row->merk.'/'.$row->type.'</td>
							 <td>'.$row->nomor_polisi.'</td>
							 <td>'.$row->nomor_rangka.'</td>
							 <td>'.$row->nomor_mesin.'</td>
							 <td>'.$row->hargainduk.'</td>
							 <td>'.$row->hargakap.'</td>
							 <td>'.$row->keterangan.'</td>
							 <td>'.$row->nama.'</td>
							 <td>'.(($row->imgname == ''  OR $row->imgname == 0) ? 
							 '<i> no pic </i>' : '<img src="'.url('/storage/imgkib/Image/'.$row->imgname).'"alt="gambar" width = "190" height = "160"/> '
							 ).'</td>
							 <td>							
							 <button id = "getidbutton" value = '.$row->idkibb.' class="btn btn-warning" data-toggle="modal"  onclick = "getInputValue(this);" >Edit Barang</button>							 						 							 
							 <td>
							 <a href="'.url(config('laraadmin.adminRoute') . '/label/'.$row->idkibb).'" target="_blank"><button  class="btn btn-info">Print Label</button></a>	
							 </td>
							</tr>';
						   }else{
							   $output .= '
							<tr>
							 <td>'.$index.'</td>
							 <td>'.$row->IDPemda.'</td>						 
							 <td>'.$row->Dept.'</td>						 
							 <td>'.$row->Nm_Aset5.'</td>
							 <td>'.$row->no_register.'</td>
							 <td>'.date('Y', strtotime($row->tgl_perolehan)).'</td>									 						 					 
							 <td>'.date('d-m-Y', strtotime($row->tgl_perolehan)).'</td>
							 <td>'.$row->merk.'/'.$row->type.'</td>
							 <td>'.$row->nomor_polisi.'</td>
							 <td>'.$row->nomor_rangka.'</td>
							 <td>'.$row->nomor_mesin.'</td>
							 <td>'.$row->hargainduk.'</td>
							 <td>'.$row->hargakap.'</td>
							 <td>'.$row->keterangan.'</td>
							 <td>'.$row->nama.'</td>
							 <td>'.(($row->imgname == ''  OR $row->imgname == 0) ? 
							 '<i> no pic </i>' : '<img src="'.url('/storage/imgkib/Image/'.$row->imgname).'"alt="gambar" width = "190" height = "160"/> '
							 ).'</td>>
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

				  echo json_encode($data);
			}
		}else{
			return view('errors.404');
		}            
    }    
	/**
	 * Display a listing of the Kibbs.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){		
		$module = Module::get('Kibbs');
		$kdbidang = Module::kdopd()->kd_bidang;
		$refrek0 = Module::populaterefbrg0()->where('rek0.kd_aset0','=',3)->get();
		$kond = Module::populaterefkondisi()->get();

		/* $values = DB::table('Kibbs')->leftjoin(Module::bmd().'.Ta_KIB_B as kibb','kibbs.idpemda','=','kibb.IDPemda')
				->leftjoin('dbo.racks','racks.id','=','Kibbs.rack_no')
				->select('kibbs.id','kibbs.IDPemda','kibb.merk','kibb.type','kibb.cc','kibb.bahan','kibb.kondisi',
				'kibb.tgl_perolehan','kibb.nomor_rangka',
				'kibb.nomor_mesin','kibb.nomor_polisi','kibb.nomor_bpkb','kibb.harga',
				'kibb.kd_bidang','kibb.kd_unit','kibb.kd_sub','kibb.kd_upb','kibbs.bpkb_file',
				'racks.rack_name','kibbs.storage_no','kibbs.stnk_file','kibbs.photo','kibbs.updated_at')
				->whereNull('deleted_at'); */
		if($kdbidang == 99 || $kdbidang == 0 ){
			$pgw = Module::pegawaiadminall()->get();
			
			$refbidang = Module::populatebidangadmin()->get();
			$brgcount = DB::table(Module::bmd().'.Ref_UPB as dept')->leftjoin(Module::bmd().'.Ta_KIB_B as kibb',function ($join) {
									$join->on('dept.kd_bidang','=','kibb.kd_bidang')
											->on('dept.kd_unit','=','kibb.kd_unit')
											->on('dept.kd_sub','=','kibb.kd_sub')
											->on('dept.kd_upb','=','kibb.kd_upb');
									}
								)
					->leftjoin('kibbs','kibbs.idpemda','=','kibb.IDPemda')
					->leftjoin('image_kibs as imgkib','imgkib.id','=','kibbs.imgid')
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as totbrgs,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)totbrg'), 
												function ($joins){
												$joins->on('totbrg.kd_bidang','=','dept.kd_bidang')
														->on('totbrg.kd_unit','=','dept.kd_unit')
														->on('totbrg.kd_sub','=','dept.kd_sub')
														->on('totbrg.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as abesars,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 1
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)abesar'), 
												function ($joins){
												$joins->on('abesar.kd_bidang','=','dept.kd_bidang')
														->on('abesar.kd_unit','=','dept.kd_unit')
														->on('abesar.kd_sub','=','dept.kd_sub')
														->on('abesar.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as angkutans,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 2
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)angkutan'), 
												function ($joins){
												$joins->on('angkutan.kd_bidang','=','dept.kd_bidang')
														->on('angkutan.kd_unit','=','dept.kd_unit')
														->on('angkutan.kd_sub','=','dept.kd_sub')
														->on('angkutan.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as bengkels,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 3
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)bengkel'), 
												function ($joins){
												$joins->on('bengkel.kd_bidang','=','dept.kd_bidang')
														->on('bengkel.kd_unit','=','dept.kd_unit')
														->on('bengkel.kd_sub','=','dept.kd_sub')
														->on('bengkel.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as pertanians,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 4
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)pertanian'), 
												function ($joins){
												$joins->on('pertanian.kd_bidang','=','dept.kd_bidang')
														->on('pertanian.kd_unit','=','dept.kd_unit')
														->on('pertanian.kd_sub','=','dept.kd_sub')
														->on('pertanian.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as kantors,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 5
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)kantor'), 
												function ($joins){
												$joins->on('kantor.kd_bidang','=','dept.kd_bidang')
														->on('kantor.kd_unit','=','dept.kd_unit')
														->on('kantor.kd_sub','=','dept.kd_sub')
														->on('kantor.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as studios,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 6
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)studio'), 
												function ($joins){
												$joins->on('studio.kd_bidang','=','dept.kd_bidang')
														->on('studio.kd_unit','=','dept.kd_unit')
														->on('studio.kd_sub','=','dept.kd_sub')
														->on('studio.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as kedokterans,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 7
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)kedokteran'), 
												function ($joins){
												$joins->on('kedokteran.kd_bidang','=','dept.kd_bidang')
														->on('kedokteran.kd_unit','=','dept.kd_unit')
														->on('kedokteran.kd_sub','=','dept.kd_sub')
														->on('kedokteran.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as labs,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 8
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)lab'), 
												function ($joins){
												$joins->on('lab.kd_bidang','=','dept.kd_bidang')
														->on('lab.kd_unit','=','dept.kd_unit')
														->on('lab.kd_sub','=','dept.kd_sub')
														->on('lab.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as senjatas,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 9
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)senjata'), 
												function ($joins){
												$joins->on('senjata.kd_bidang','=','dept.kd_bidang')
														->on('senjata.kd_unit','=','dept.kd_unit')
														->on('senjata.kd_sub','=','dept.kd_sub')
														->on('senjata.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as komputers,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 10
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)komputer'), 
												function ($joins){
												$joins->on('komputer.kd_bidang','=','dept.kd_bidang')
														->on('komputer.kd_unit','=','dept.kd_unit')
														->on('komputer.kd_sub','=','dept.kd_sub')
														->on('komputer.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as eksplors,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 11
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)eksplor'), 
												function ($joins){
												$joins->on('eksplor.kd_bidang','=','dept.kd_bidang')
														->on('eksplor.kd_unit','=','dept.kd_unit')
														->on('eksplor.kd_sub','=','dept.kd_sub')
														->on('eksplor.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) bors,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 12
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)bor'), 
												function ($joins){
												$joins->on('bor.kd_bidang','=','dept.kd_bidang')
														->on('bor.kd_unit','=','dept.kd_unit')
														->on('bor.kd_sub','=','dept.kd_sub')
														->on('bor.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) prods,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 13
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)prod'), 
												function ($joins){
												$joins->on('prod.kd_bidang','=','dept.kd_bidang')
														->on('prod.kd_unit','=','dept.kd_unit')
														->on('prod.kd_sub','=','dept.kd_sub')
														->on('prod.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) bantuexplors,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 14
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)bantuexplor'), 
												function ($joins){
												$joins->on('bantuexplor.kd_bidang','=','dept.kd_bidang')
														->on('bantuexplor.kd_unit','=','dept.kd_unit')
														->on('bantuexplor.kd_sub','=','dept.kd_sub')
														->on('bantuexplor.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) k3s,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 15
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)k3'), 
												function ($joins){
												$joins->on('k3.kd_bidang','=','dept.kd_bidang')
														->on('k3.kd_unit','=','dept.kd_unit')
														->on('k3.kd_sub','=','dept.kd_sub')
														->on('k3.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) peragas,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 16
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)peraga'), 
												function ($joins){
												$joins->on('peraga.kd_bidang','=','dept.kd_bidang')
														->on('peraga.kd_unit','=','dept.kd_unit')
														->on('peraga.kd_sub','=','dept.kd_sub')
														->on('peraga.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) prosess,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 17
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)proses'), 
												function ($joins){
												$joins->on('proses.kd_bidang','=','dept.kd_bidang')
														->on('proses.kd_unit','=','dept.kd_unit')
														->on('proses.kd_sub','=','dept.kd_sub')
														->on('proses.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) rambus,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 18
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)rambu'), 
												function ($joins){
												$joins->on('rambu.kd_bidang','=','dept.kd_bidang')
														->on('rambu.kd_unit','=','dept.kd_unit')
														->on('rambu.kd_sub','=','dept.kd_sub')
														->on('rambu.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) olahs,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 19
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)olah'), 
												function ($joins){
												$joins->on('olah.kd_bidang','=','dept.kd_bidang')
														->on('olah.kd_unit','=','dept.kd_unit')
														->on('olah.kd_sub','=','dept.kd_sub')
														->on('olah.kd_upb','=','dept.kd_upb');
											}
								)
					->select('dept.kd_bidang','dept.kd_unit','dept.kd_sub','dept.kd_upb','dept.Nm_UPB',
										DB::raw('ISNULL(totbrg.totbrgs,0) as brgtot'),
										DB::raw('ISNULL(abesar.abesars,0) as abesartot'),
										DB::raw('ISNULL(angkutan.angkutans,0) as angkutantot'),
										DB::raw('ISNULL(bengkel.bengkels,0) as bengkeltot'),
										DB::raw('ISNULL(pertanian.pertanians,0) as pertaniantot'),
										DB::raw('ISNULL(kantor.kantors,0) as kantortot'),
										DB::raw('ISNULL(studio.studios,0) as studiotot'),
										DB::raw('ISNULL(kedokteran.kedokterans,0) as kedokterantot'),
										DB::raw('ISNULL(lab.labs,0) as labtot'),
										DB::raw('ISNULL(senjata.senjatas,0) as senjatatot'),
										DB::raw('ISNULL(komputer.komputers,0) as komputertot'),
										DB::raw('ISNULL(eksplor.eksplors,0) as eksplortot'),
										DB::raw('ISNULL(bor.bors,0) as bortot'),
										DB::raw('ISNULL(prod.prods,0) as prodtot'),
										DB::raw('ISNULL(bantuexplor.bantuexplors,0) as bantuexplortot'),
										DB::raw('ISNULL(k3.k3s,0) as k3tot'),
										DB::raw('ISNULL(peraga.peragas,0) as peragatot'),
										DB::raw('ISNULL(proses.prosess,0) as prosestot'),
										DB::raw('ISNULL(rambu.rambus,0) as rambutot'),
										DB::raw('ISNULL(olah.olahs,0) as olahtot')
							)
					->groupBy('dept.kd_bidang','dept.kd_unit','dept.kd_sub','dept.kd_upb','dept.nm_upb'
								,'abesar.abesars','totbrg.totbrgs','angkutan.angkutans','bengkel.bengkels','pertanian.pertanians'
								,'kantor.kantors','studio.studios','kedokteran.kedokterans','lab.labs','senjata.senjatas','komputer.komputers'
								,'eksplor.eksplors','bor.bors','prod.prods','bantuexplor.bantuexplors','k3.k3s','peraga.peragas','proses.prosess'
								,'rambu.rambus','olah.olahs'
								)
					->orderBy('dept.kd_bidang','ASC')
					->orderBy('dept.kd_unit','ASC')
					->orderBy('dept.kd_sub','ASC')
					->orderBy('dept.kd_upb','ASC')
					->get();
			
			
		}else{
			$kdbidang = Module::kdopd()->kd_bidang;
			$kdunit = Module::kdopd()->kd_unit;
			$kdsub = Module::kdopd()->kd_sub;
			$kdupb = Module::kdopd()->kd_upb;
			$refbidang = Module::populatebidanguser()->get();
			$pgw = Module::pegawaiuser($kdbidang,$kdunit,$kdsub,$kdupb)->get();
			$brgcount = DB::table(Module::bmd().'.Ref_UPB as dept')->leftjoin(Module::bmd().'.Ta_KIB_B as kibb',function ($join) {
									$join->on('dept.kd_bidang','=','kibb.kd_bidang')
											->on('dept.kd_unit','=','kibb.kd_unit')
											->on('dept.kd_sub','=','kibb.kd_sub')
											->on('dept.kd_upb','=','kibb.kd_upb');
									}
								)
					->leftjoin('kibbs','kibbs.idpemda','=','kibb.IDPemda')
					->leftjoin('image_kibs as imgkib','imgkib.id','=','kibbs.imgid')
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as totbrgs,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)totbrg'), 
												function ($joins){
												$joins->on('totbrg.kd_bidang','=','dept.kd_bidang')
														->on('totbrg.kd_unit','=','dept.kd_unit')
														->on('totbrg.kd_sub','=','dept.kd_sub')
														->on('totbrg.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as abesars,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 1
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)abesar'), 
												function ($joins){
												$joins->on('abesar.kd_bidang','=','dept.kd_bidang')
														->on('abesar.kd_unit','=','dept.kd_unit')
														->on('abesar.kd_sub','=','dept.kd_sub')
														->on('abesar.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as angkutans,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 2
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)angkutan'), 
												function ($joins){
												$joins->on('angkutan.kd_bidang','=','dept.kd_bidang')
														->on('angkutan.kd_unit','=','dept.kd_unit')
														->on('angkutan.kd_sub','=','dept.kd_sub')
														->on('angkutan.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as bengkels,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 3
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)bengkel'), 
												function ($joins){
												$joins->on('bengkel.kd_bidang','=','dept.kd_bidang')
														->on('bengkel.kd_unit','=','dept.kd_unit')
														->on('bengkel.kd_sub','=','dept.kd_sub')
														->on('bengkel.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as pertanians,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 4
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)pertanian'), 
												function ($joins){
												$joins->on('pertanian.kd_bidang','=','dept.kd_bidang')
														->on('pertanian.kd_unit','=','dept.kd_unit')
														->on('pertanian.kd_sub','=','dept.kd_sub')
														->on('pertanian.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as kantors,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 5
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)kantor'), 
												function ($joins){
												$joins->on('kantor.kd_bidang','=','dept.kd_bidang')
														->on('kantor.kd_unit','=','dept.kd_unit')
														->on('kantor.kd_sub','=','dept.kd_sub')
														->on('kantor.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as studios,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 6
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)studio'), 
												function ($joins){
												$joins->on('studio.kd_bidang','=','dept.kd_bidang')
														->on('studio.kd_unit','=','dept.kd_unit')
														->on('studio.kd_sub','=','dept.kd_sub')
														->on('studio.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as kedokterans,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 7
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)kedokteran'), 
												function ($joins){
												$joins->on('kedokteran.kd_bidang','=','dept.kd_bidang')
														->on('kedokteran.kd_unit','=','dept.kd_unit')
														->on('kedokteran.kd_sub','=','dept.kd_sub')
														->on('kedokteran.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as labs,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 8
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)lab'), 
												function ($joins){
												$joins->on('lab.kd_bidang','=','dept.kd_bidang')
														->on('lab.kd_unit','=','dept.kd_unit')
														->on('lab.kd_sub','=','dept.kd_sub')
														->on('lab.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as senjatas,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 9
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)senjata'), 
												function ($joins){
												$joins->on('senjata.kd_bidang','=','dept.kd_bidang')
														->on('senjata.kd_unit','=','dept.kd_unit')
														->on('senjata.kd_sub','=','dept.kd_sub')
														->on('senjata.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as komputers,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 10
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)komputer'), 
												function ($joins){
												$joins->on('komputer.kd_bidang','=','dept.kd_bidang')
														->on('komputer.kd_unit','=','dept.kd_unit')
														->on('komputer.kd_sub','=','dept.kd_sub')
														->on('komputer.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) as eksplors,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 11
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)eksplor'), 
												function ($joins){
												$joins->on('eksplor.kd_bidang','=','dept.kd_bidang')
														->on('eksplor.kd_unit','=','dept.kd_unit')
														->on('eksplor.kd_sub','=','dept.kd_sub')
														->on('eksplor.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) bors,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 12
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)bor'), 
												function ($joins){
												$joins->on('bor.kd_bidang','=','dept.kd_bidang')
														->on('bor.kd_unit','=','dept.kd_unit')
														->on('bor.kd_sub','=','dept.kd_sub')
														->on('bor.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) prods,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 13
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)prod'), 
												function ($joins){
												$joins->on('prod.kd_bidang','=','dept.kd_bidang')
														->on('prod.kd_unit','=','dept.kd_unit')
														->on('prod.kd_sub','=','dept.kd_sub')
														->on('prod.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) bantuexplors,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 14
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)bantuexplor'), 
												function ($joins){
												$joins->on('bantuexplor.kd_bidang','=','dept.kd_bidang')
														->on('bantuexplor.kd_unit','=','dept.kd_unit')
														->on('bantuexplor.kd_sub','=','dept.kd_sub')
														->on('bantuexplor.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) k3s,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 15
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)k3'), 
												function ($joins){
												$joins->on('k3.kd_bidang','=','dept.kd_bidang')
														->on('k3.kd_unit','=','dept.kd_unit')
														->on('k3.kd_sub','=','dept.kd_sub')
														->on('k3.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) peragas,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 16
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)peraga'), 
												function ($joins){
												$joins->on('peraga.kd_bidang','=','dept.kd_bidang')
														->on('peraga.kd_unit','=','dept.kd_unit')
														->on('peraga.kd_sub','=','dept.kd_sub')
														->on('peraga.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) prosess,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 17
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)proses'), 
												function ($joins){
												$joins->on('proses.kd_bidang','=','dept.kd_bidang')
														->on('proses.kd_unit','=','dept.kd_unit')
														->on('proses.kd_sub','=','dept.kd_sub')
														->on('proses.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) rambus,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 18
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)rambu'), 
												function ($joins){
												$joins->on('rambu.kd_bidang','=','dept.kd_bidang')
														->on('rambu.kd_unit','=','dept.kd_unit')
														->on('rambu.kd_sub','=','dept.kd_sub')
														->on('rambu.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kibb.idpemda) olahs,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_B as kibb 
												on dept.kd_bidang = kibb.kd_bidang and
													dept.kd_unit = kibb.kd_unit and
													dept.kd_sub = kibb.kd_sub and
													dept.kd_upb = kibb.kd_upb left join
													kibbs on kibbs.idpemda = kibb.idpemda
												WHERE 
												kibb.kd_pemilik = 12 and
												kibb.kd_hapus = 0 and
												kibb.kd_aset8 = 1 and
												kibb.kd_aset80 = 3 and
												kibb.kd_aset81 = 2 and
												kibb.kd_aset82 = 19
												
												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb)olah'), 
												function ($joins){
												$joins->on('olah.kd_bidang','=','dept.kd_bidang')
														->on('olah.kd_unit','=','dept.kd_unit')
														->on('olah.kd_sub','=','dept.kd_sub')
														->on('olah.kd_upb','=','dept.kd_upb');
											}
								)
					->select('dept.kd_bidang','dept.kd_unit','dept.kd_sub','dept.kd_upb','dept.Nm_UPB',
										DB::raw('ISNULL(totbrg.totbrgs,0) as brgtot'),
										DB::raw('ISNULL(abesar.abesars,0) as abesartot'),
										DB::raw('ISNULL(angkutan.angkutans,0) as angkutantot'),
										DB::raw('ISNULL(bengkel.bengkels,0) as bengkeltot'),
										DB::raw('ISNULL(pertanian.pertanians,0) as pertaniantot'),
										DB::raw('ISNULL(kantor.kantors,0) as kantortot'),
										DB::raw('ISNULL(studio.studios,0) as studiotot'),
										DB::raw('ISNULL(kedokteran.kedokterans,0) as kedokterantot'),
										DB::raw('ISNULL(lab.labs,0) as labtot'),
										DB::raw('ISNULL(senjata.senjatas,0) as senjatatot'),
										DB::raw('ISNULL(komputer.komputers,0) as komputertot'),
										DB::raw('ISNULL(eksplor.eksplors,0) as eksplortot'),
										DB::raw('ISNULL(bor.bors,0) as bortot'),
										DB::raw('ISNULL(prod.prods,0) as prodtot'),
										DB::raw('ISNULL(bantuexplor.bantuexplors,0) as bantuexplortot'),
										DB::raw('ISNULL(k3.k3s,0) as k3tot'),
										DB::raw('ISNULL(peraga.peragas,0) as peragatot'),
										DB::raw('ISNULL(proses.prosess,0) as prosestot'),
										DB::raw('ISNULL(rambu.rambus,0) as rambutot'),
										DB::raw('ISNULL(olah.olahs,0) as olahtot')
							)
					->where([
							 ['kibb.kd_bidang','=',$kdbidang],
							 ['kibb.kd_unit','=',$kdunit],
							 ['kibb.kd_sub','=',$kdsub],				
							 ['kibb.kd_aset8','=',1],
							 ['kibb.kd_aset80','=',3],
							 ['kibb.kd_aset81','=',2]
							 ])
					->groupBy('dept.kd_bidang','dept.kd_unit','dept.kd_sub','dept.kd_upb','dept.nm_upb'
								,'abesar.abesars','totbrg.totbrgs','angkutan.angkutans','bengkel.bengkels','pertanian.pertanians'
								,'kantor.kantors','studio.studios','kedokteran.kedokterans','lab.labs','senjata.senjatas','komputer.komputers'
								,'eksplor.eksplors','bor.bors','prod.prods','bantuexplor.bantuexplors','k3.k3s','peraga.peragas','proses.prosess'
								,'rambu.rambus','olah.olahs'
								)
					->orderBy('dept.kd_bidang','ASC')
					->orderBy('dept.kd_unit','ASC')
					->orderBy('dept.kd_sub','ASC')
					->orderBy('dept.kd_upb','ASC')
					->get();
			
		}
		
		if(Module::hasAccess($module->id)) {
			return View('la.kibbs.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module,
				'refbidang' => $refbidang,
				'brgcount' => $brgcount,
				'refrek0' => $refrek0,
				'kond' => $kond,
				'pgw' => $pgw
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Show the form for creating a new kibb.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created kibb in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Kibbs", "create")) {
		
			$rules = Module::validateRules("Kibbs", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Kibbs", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.kibbs.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified kibb.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Kibbs", "view")) {
				$kdbidang = Module::kdopd()->kd_bidang;
				$kdunit = Module::kdopd()->kd_unit;
				$kibb = Kibb::findorfail($id);
				if($kdbidang == 99 || $kdbidang == 0 ){
					$kibbs = DB::table('kibbs')
					->leftjoin(Module::bmd().'.Ta_KIB_B as kibb','kibbs.idpemda','=','kibb.IDPemda')
					->leftjoin('racks','racks.id','=','kibbs.rack_no')
					->leftjoin('storages','storages.id','=','racks.storage')
					->leftjoin('uploads as uploadbpkb','uploadbpkb.id','=','kibbs.bpkb_file')
					->leftjoin('uploads as uploadstnk','uploadstnk.id','=','kibbs.stnk_file')
					->leftjoin('uploads as uploadphoto','uploadphoto.id','=','kibbs.photo')
					->leftjoin('users','users.id','=','kibbs.update_by')
					->select('kibbs.id','kibbs.IDPemda','kibb.merk','kibb.type','kibb.cc','kibb.bahan','kibb.kondisi',
					'kibb.tgl_perolehan','kibb.nomor_rangka',
					'kibb.nomor_mesin','kibb.nomor_polisi','kibb.nomor_bpkb','uploadbpkb.name as bpkb_file',
					'kibbs.rack_no','storages.storage_name','uploadstnk.name as stnk_file','kibbs.photo','kibbs.updated_at','users.name as update_by')
					->where([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibbs.id','=',$id]
							])
					->get();
				}else{
					$kibbs = DB::table('kibbs')
					->leftjoin(Module::bmd().'.Ta_KIB_B as kibb','kibbs.idpemda','=','kibb.IDPemda')
					->leftjoin('racks','racks.id','=','kibbs.rack_no')
					->leftjoin('storages','storages.id','=','racks.storage')
					->leftjoin('uploads as uploadbpkb','uploadbpkb.id','=','kibbs.bpkb_file')
					->leftjoin('uploads as uploadstnk','uploadstnk.id','=','kibbs.stnk_file')
					->leftjoin('uploads as uploadphoto','uploadphoto.id','=','kibbs.photo')
					->leftjoin('users','users.id','=','kibbs.update_by')
					->select('kibbs.id','kibbs.IDPemda','kibb.merk','kibb.type','kibb.cc','kibb.bahan','kibb.kondisi',
					'kibb.tgl_perolehan','kibb.nomor_rangka',
					'kibb.nomor_mesin','kibb.nomor_polisi','kibb.nomor_bpkb','uploadbpkb.name as bpkb_file',
					'kibbs.rack_no','storages.storage_name','uploadstnk.name as stnk_file','kibbs.photo','kibbs.updated_at','users.name as update_by')
					->where([['kibb.kd_hapus','=',0],
							['kibb.kd_pemilik','=',12],
							['kibb.kd_bidang','=',$kdbidang],
							['kibb.kd_unit','=',$kdunit],
							['kibbs.id','=',$id]							
							])
					->get();
				}
			
			 
			if(isset($kibb->id)) {
				$module = Module::get('Kibbs');
				$module->row = $kibb;
				
				return view('la.kibbs.show', [
					'module' => $module,
					'kibbs' => $kibbs,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('kibb', $kibb);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("kibb"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified kibb.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id){
		if(Module::hasAccess("Kibbs", "edit")) {			

			$kdbidang = Module::kdopd()->kd_bidang;
			$kdunit = Module::kdopd()->kd_unit;
			$kdsub = Module::kdopd()->kd_sub;
			$kdupb = Module::kdopd()->kd_upb;
			$kibb = Kibb::find($id);
			
			if(isset($kibb->id)) {
						
				$module = Module::get('Kibbs');				
				$module->row = $kibb;
				
				if($kdbidang == 99 || $kdbidang == 0 ){
					$pgw = Module::pegawaiadminall()->get();
					$kibbsuserbrg = Module::kibbadminbrg($id);					
					return view('la.kibbs.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
					'kdbidang' => $kdbidang,
					'kdunit' => $kdunit,
					'kdsub' => $kdsub,
					'kdupb' => $kdupb,
					'kibbsuserbrg' => $kibbsuserbrg,
					'pgw' => $pgw
				])->with('kibb', $kibb);							
				}else{
					$kibbsuserbrg = Module::kibbuserbrg($id);
					return view('la.kibbs.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
					'kdbidang' => $kdbidang,
					'kdunit' => $kdunit,
					'kdsub' => $kdsub,
					'kdupb' => $kdupb,
					'kibbsuserbrg' => $kibbsuserbrg,
					'pgw' => $pgw
				])->with('kibb', $kibb);	
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
	 * Update the specified kibb in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Kibbs", "edit")) {
			
			$rules = Module::validateRules("Kibbs", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Kibbs", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.kibbs.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified kibb from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Kibbs", "delete")) {
			Kibb::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.kibbs.index');
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
				->leftjoin('uploads as uploadbpkb','uploadbpkb.id','=','kibbs.bpkb_file')
				->leftjoin('uploads as uploadstnk','uploadstnk.id','=','kibbs.stnk_file')
				->leftjoin('uploads as uploadphoto','uploadphoto.id','=','kibbs.photo')
				->leftjoin('users','users.id','=','kibbs.update_by')
				->select('kibbs.id','kibbs.IDPemda','kibb.merk','kibb.type','kibb.cc',
				'kibb.tgl_perolehan','kibb.nomor_rangka',
				'kibb.nomor_mesin','kibb.nomor_polisi','kibb.nomor_bpkb','kibb.harga',
				'kibb.kd_bidang','kibb.kd_unit','kibb.kd_sub','kibb.kd_upb','uploadbpkb.name as bpkb_file',
				'kibbs.rack_no','storages.storage_name as storage_no','uploadstnk.name as stnk_file','uploadphoto.name as photo')
				->where([['kibb.kd_hapus','=',0],
						['kibb.kd_pemilik','=',12]
						]);
				}else{
				$values = DB::table('kibbs')->leftjoin(Module::bmd().'.Ta_KIB_B as kibb','kibbs.idpemda','=','kibb.IDPemda')
				->leftjoin('racks','racks.id','=','kibbs.rack_no')
				->leftjoin('storages','storages.id','=','racks.storage')
				->leftjoin('uploads as uploadbpkb','uploadbpkb.id','=','kibbs.bpkb_file')
				->leftjoin('uploads as uploadstnk','uploadstnk.id','=','kibbs.stnk_file')
				->leftjoin('uploads as uploadphoto','uploadphoto.id','=','kibbs.photo')
				->leftjoin('users','users.id','=','kibbs.update_by')
				->select('kibbs.id','kibbs.IDPemda','kibb.merk','kibb.type','kibb.cc',
				'kibb.tgl_perolehan','kibb.nomor_rangka',
				'kibb.nomor_mesin','kibb.nomor_polisi','kibb.nomor_bpkb','kibb.harga',
				'kibb.kd_bidang','kibb.kd_unit','kibb.kd_sub','kibb.kd_upb','uploadbpkb.name as bpkb_file',
				'kibbs.merk as rack_no','kibbs.type as storage_no as storage_no','uploadstnk.name as stnk_file','uploadphoto.name as photo')
				->where([['kibb.kd_hapus','=',0],
						['kibb.kd_pemilik','=',12],
						['kibb.kd_bidang','=',$kdbidang],
						['kibb.kd_unit','=',$kdunit],
						]);
				}

		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Kibbs');
		
		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) { 
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/kibbs/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}

			}
			
			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Kibbs", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/kibbs/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}
				
				if(Module::hasAccess("Kibbs", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.kibbs.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
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
