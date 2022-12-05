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

use App\Models\Rekonsiliasi_aset;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PHPSpreadsheet\Worksheet;
//use PhpOffice\PhpSpreadsheet\IOFactory;

class Rekonsiliasi_asetsController extends Controller
{
	public $show_action = true;
	public $view_col = 'id_rek_aset';
	public $listing_cols = ['id', 'id_rek_aset'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Rekonsiliasi_asets', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Rekonsiliasi_asets', $this->listing_cols);
		}
	}
			
	/**
	 * Display a listing of the Rekonsiliasi_asets.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		$module = Module::get('Rekonsiliasi_asets');
		$kdbidang = Module::kdopd()->kd_bidang;

		//dd($request->input('bidang'));
				
		if($kdbidang == 99 || $kdbidang == 0 ){
			$bidang = Module::populatebidangadmin()->get();
			if(Module::hasAccess($module->id)) {
				return View('la.rekonsiliasi_asets.index', [
					'show_actions' => $this->show_action,
					'listing_cols' => $this->listing_cols,
					'module' => $module,
					'bidang' => $bidang
				]);
			} else {
				return redirect(config('laraadmin.adminRoute')."/");
			}
			
		}else{
			$bidang = Module::populatebidanguser()->get();
			if(Module::hasAccess($module->id)) {
				return View('la.rekonsiliasi_asets.index', [
					'show_actions' => $this->show_action,
					'listing_cols' => $this->listing_cols,
					'module' => $module,
					'bidang' => $bidang
				]);
			} else {
				return redirect(config('laraadmin.adminRoute')."/");
			}
		}
	}
	
	public function unit($id){
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$kdsub = Module::kdopd()->kd_sub;
		$kdupb = Module::kdopd()->kd_upb;
						
		if($kdbidang == 99 || $kdbidang == 0 ){
			$unit = Module::populateunitadmin($id)->pluck('nm_unit', 'kd_unit');
			return json_encode($unit);
		}else{
			$unit = Module::populateunituser($kdbidang)->pluck('nm_unit', 'kd_unit');
			//dd($unit->get());
			return json_encode($unit);
		}
	}
	
	public function subunit($id,$ids){
		
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$kdsub = Module::kdopd()->kd_sub;
		$kdupb = Module::kdopd()->kd_upb;
		
		if($kdbidang == 99 || $kdbidang == 0 ){
			$subunit = Module::populatesubunit($id,$ids)->pluck('nm_sub_unit', 'kd_sub');
			return json_encode($subunit);
		}else{
			$sub = Module::populatesubunit($kdbidang,$kdunit)->pluck('nm_sub_unit', 'kd_sub');
			return json_encode($sub);
		}
	}
	public function upb($id,$ids,$idss){
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$kdsub = Module::kdopd()->kd_sub;
		$kdupb = Module::kdopd()->kd_upb;
		
		
		$upb = Module::populateupb($id,$ids,$idss)->pluck('nm_upb', 'kd_upb');
		return json_encode($upb);
		
		if($kdbidang == 99 || $kdbidang == 0 ){
			$upb = Module::populateupb($id,$ids,$idss)->pluck('nm_upb', 'kd_upb');
			return json_encode($upb);
		}else{
			$sub = Module::populateupb($kdbidang,$kdunit)->pluck('nm_sub_unit', 'kd_sub');
			return json_encode($sub);
		}
	}
	
	
	public function kkopd($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,$kdsubs){
		$kdbidang = Module::kdopd()->kd_bidang;	

		/* $data = Module::kibaall($kdbidangs,$kdunits,$kdsubs);
		dd($data); */

		if(Module::hasAccess("Rekonsiliasi_asets", "view")) {
			
				$inputFileType = 'Xlsx'; // Xlsx - Xml - Ods - Slk - Gnumeric - Csv
				$inputFileName = public_path('storage\format\DRAFT-MASTER_LAPORAN_MUTASI_BMD_2022_v02.xlsx');
				$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);		
				$spreadsheet = new Spreadsheet();
				$spreadsheet = $reader->load($inputFileName);
				
			if($kdbidang == 99 || $kdbidang == 0 ){	
																																
				$kibaitem = Module::kkopdtanah($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,$kdsubs,"'%'");
				
				$kibbitem = Module::kkopdpm($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,$kdsubs,"'%'");
				$kibbitemextra = Module::kkopdpmextra($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,$kdsubs,"'%'");
				$kibbitemrb = Module::kkopdpmrb($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,$kdsubs,"'%'");
				
				$kibcitem = Module::kkopdgb($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,$kdsubs,"'%'");
				$kibcitemextra = Module::kkopdgbextra($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,$kdsubs,"'%'");
				$kibcitemrb = Module::kkopdgbrb($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,$kdsubs,"'%'");
				
				$kibditem = Module::kkopdjij($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,$kdsubs,"'%'");
				$kibditemextra = Module::kkopdjijextra($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,$kdsubs,"'%'");
				$kibditemrb = Module::kkopdjijrb($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,$kdsubs,"'%'");
				
				$kibeitem = Module::kkopdatl($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,$kdsubs,"'%'");
				$kibeitemrb = Module::kkopdatlrb($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,$kdsubs,"'%'");
				
				$kibkdp = Module::kkopdkdp($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,$kdsubs,"'%'");
				$kiblainnya= Module::kkopdlainnya($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,$kdsubs,"'%'");
				
				$kiblainnyareg= Module::kkopdlainnyareg($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,$kdsubs,"'%'");
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-Tanah');
				foreach($kibaitem as $index=>$kibaitems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibaitems->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibaitems->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibaitems->no_reg);
					$sheet->setCellValue('E'.$cell, $kibaitems->luas);				
					$sheet->setCellValue('F'.$cell, $kibaitems->tahun_perolehan);				
					$sheet->setCellValue('G'.$cell, $kibaitems->alamat);				
					$sheet->setCellValue('H'.$cell, $kibaitems->Hak_Tanah);				
					$sheet->setCellValue('I'.$cell, $kibaitems->sertifikat_tanggal);				
					$sheet->setCellValue('J'.$cell, $kibaitems->sertifikat_nomor);				
					$sheet->setCellValue('K'.$cell, $kibaitems->penggunaan);				
					$sheet->setCellValue('L'.$cell, $kibaitems->Asal_usul);				
					$sheet->setCellValue('M'.$cell, $kibaitems->hargaperolehan);				
					$sheet->setCellValue('O'.$cell, $kibaitems->NK_tambah);				
					$sheet->setCellValue('P'.$cell, $kibaitems->bertambah);				
					$sheet->setCellValue('Q'.$cell, $kibaitems->NK_kurang);				
					$sheet->setCellValue('R'.$cell, $kibaitems->berkurang);				
					$sheet->setCellValue('T'.$cell, $kibaitems->keterangan);				
					$sheet->setCellValue('U'.$cell, $kibaitems->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				//peralatan & mesin
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-PeralatanMesin');
				foreach($kibbitem as $index=>$kibbitems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibbitems->kd_barang);
					$sheet->setCellValue('C'.$cell, $kibbitems->Nm_Aset5);
					$sheet->setCellValue('D'.$cell, $kibbitems->jml_item);
					$sheet->setCellValue('E'.$cell, $kibbitems->merk);				
					$sheet->setCellValue('H'.$cell, $kibbitems->tahun_perolehan);				
					$sheet->setCellValue('M'.$cell, $kibbitems->nomor_bpkb);				
					$sheet->setCellValue('L'.$cell, $kibbitems->nomor_polisi);										
					$sheet->setCellValue('N'.$cell, $kibbitems->Asal_usul);				
					$sheet->setCellValue('O'.$cell, $kibbitems->hargaperolehan);				
					$sheet->setCellValue('Q'.$cell, $kibbitems->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibbitems->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibbitems->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibbitems->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibbitems->keterangan);				
					$sheet->setCellValue('W'.$cell, $kibbitems->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}			
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Ekstra-PeralatanMesin');
				foreach($kibbitemextra as $index=>$kibbitemextras){
					$index = $index+1;					
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibbitemextras->kd_barang);
					$sheet->setCellValue('C'.$cell, $kibbitemextras->Nm_Aset5);
					$sheet->setCellValue('D'.$cell, $kibbitemextras->jml_item);
					$sheet->setCellValue('E'.$cell, $kibbitemextras->merk);				
					$sheet->setCellValue('H'.$cell, $kibbitemextras->tahun_perolehan);				
					$sheet->setCellValue('L'.$cell, $kibbitemextras->nomor_bpkb);				
					$sheet->setCellValue('M'.$cell, $kibbitemextras->nomor_polisi);										
					$sheet->setCellValue('N'.$cell, $kibbitemextras->Asal_usul);				
					$sheet->setCellValue('O'.$cell, $kibbitemextras->hargaperolehan);				
					$sheet->setCellValue('Q'.$cell, $kibbitemextras->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibbitemextras->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibbitemextras->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibbitemextras->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibbitemextras->keterangan);							
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-PeralatanMesinRB');
				foreach($kibbitemrb as $index=>$kibbitemrbs){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibbitemrbs->kd_barang);
					$sheet->setCellValue('C'.$cell, $kibbitemrbs->Nm_Aset5);
					$sheet->setCellValue('D'.$cell, $kibbitemrbs->jml_item);
					$sheet->setCellValue('E'.$cell, $kibbitemrbs->merk);				
					$sheet->setCellValue('H'.$cell, $kibbitemrbs->tahun_perolehan);				
					$sheet->setCellValue('L'.$cell, $kibbitemrbs->nomor_bpkb);				
					$sheet->setCellValue('M'.$cell, $kibbitemrbs->nomor_polisi);										
					$sheet->setCellValue('N'.$cell, $kibbitemrbs->Asal_usul);				
					$sheet->setCellValue('O'.$cell, $kibbitemrbs->hargaperolehan);				
					$sheet->setCellValue('Q'.$cell, $kibbitemrbs->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibbitemrbs->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibbitemrbs->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibbitemrbs->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibbitemrbs->keterangan);						
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				//end
				
				//gedung dan bangunan
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-GedungBangunan');
				foreach($kibcitem as $index=>$kibcitems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibcitems->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibcitems->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibcitems->no_reg);
					$sheet->setCellValue('E'.$cell, $kibcitems->uraian);				
					$sheet->setCellValue('F'.$cell, $kibcitems->bertingkat_tidak);				
					$sheet->setCellValue('G'.$cell, $kibcitems->beton_tidak);				
					$sheet->setCellValue('H'.$cell, $kibcitems->luas_lantai);				
					$sheet->setCellValue('I'.$cell, $kibcitems->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibcitems->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibcitems->dokumen_nomor);				
					$sheet->setCellValue('M'.$cell, $kibcitems->status_tanah);							
					$sheet->setCellValue('R'.$cell, $kibcitems->NK_tambah);				
					$sheet->setCellValue('S'.$cell, $kibcitems->bertambah);				
					$sheet->setCellValue('T'.$cell, $kibcitems->NK_kurang);				
					$sheet->setCellValue('U'.$cell, $kibcitems->berkurang);				
					$sheet->setCellValue('W'.$cell, $kibcitems->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibcitems->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Ekstra-GedungBangunan');
				foreach($kibcitemextra as $index=>$kibcitemextras){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibcitemextras->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibcitemextras->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibcitemextras->no_reg);
					$sheet->setCellValue('E'.$cell, $kibcitemextras->uraian);				
					$sheet->setCellValue('F'.$cell, $kibcitemextras->bertingkat_tidak);				
					$sheet->setCellValue('G'.$cell, $kibcitemextras->beton_tidak);				
					$sheet->setCellValue('H'.$cell, $kibcitemextras->luas_lantai);				
					$sheet->setCellValue('I'.$cell, $kibcitemextras->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibcitemextras->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibcitemextras->dokumen_nomor);				
					$sheet->setCellValue('M'.$cell, $kibcitemextras->status_tanah);							
					$sheet->setCellValue('R'.$cell, $kibcitemextras->NK_tambah);				
					$sheet->setCellValue('S'.$cell, $kibcitemextras->bertambah);				
					$sheet->setCellValue('T'.$cell, $kibcitemextras->NK_kurang);				
					$sheet->setCellValue('U'.$cell, $kibcitemextras->berkurang);				
					$sheet->setCellValue('W'.$cell, $kibcitemextras->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibcitemextras->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-GedungBangunanRB');
				foreach($kibcitemrb as $index=>$kibcitemrbs){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibcitemrbs->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibcitemrbs->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibcitemrbs->no_reg);
					$sheet->setCellValue('E'.$cell, $kibcitemrbs->uraian);				
					$sheet->setCellValue('F'.$cell, $kibcitemrbs->bertingkat_tidak);				
					$sheet->setCellValue('G'.$cell, $kibcitemrbs->beton_tidak);				
					$sheet->setCellValue('H'.$cell, $kibcitemrbs->luas_lantai);				
					$sheet->setCellValue('I'.$cell, $kibcitemrbs->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibcitemrbs->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibcitemrbs->dokumen_nomor);				
					$sheet->setCellValue('M'.$cell, $kibcitemrbs->status_tanah);							
					$sheet->setCellValue('R'.$cell, $kibcitemrbs->NK_tambah);				
					$sheet->setCellValue('S'.$cell, $kibcitemrbs->bertambah);				
					$sheet->setCellValue('T'.$cell, $kibcitemrbs->NK_kurang);				
					$sheet->setCellValue('U'.$cell, $kibcitemrbs->berkurang);				
					$sheet->setCellValue('W'.$cell, $kibcitemrbs->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibcitemrbs->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}				
				//end
				
				//jalan jaringan irigasi
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-JIJ');
				foreach($kibditem as $index=>$kibditems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibditems->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibditems->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibditems->no_reg);
					$sheet->setCellValue('E'.$cell, $kibditems->konstruksi);				
					$sheet->setCellValue('F'.$cell, $kibditems->panjang);				
					$sheet->setCellValue('G'.$cell, $kibditems->lebar);				
					$sheet->setCellValue('H'.$cell, $kibditems->luas);				
					$sheet->setCellValue('I'.$cell, $kibditems->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibditems->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibditems->dokumen_nomor);				
					$sheet->setCellValue('L'.$cell, $kibditems->status_tanah);							
					$sheet->setCellValue('O'.$cell, $kibditems->hargaperolehan);							
					$sheet->setCellValue('Q'.$cell, $kibditems->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibditems->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibditems->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibditems->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibditems->uraian);				
					$sheet->setCellValue('W'.$cell, $kibditems->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibditems->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Ekstra-JIJ');
				foreach($kibditemextra as $index=>$kibditemextras){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibditemextras->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibditemextras->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibditemextras->no_reg);
					$sheet->setCellValue('E'.$cell, $kibditemextras->konstruksi);				
					$sheet->setCellValue('F'.$cell, $kibditemextras->panjang);				
					$sheet->setCellValue('G'.$cell, $kibditemextras->lebar);				
					$sheet->setCellValue('H'.$cell, $kibditemextras->luas);				
					$sheet->setCellValue('I'.$cell, $kibditemextras->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibditemextras->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibditemextras->dokumen_nomor);				
					$sheet->setCellValue('L'.$cell, $kibditemextras->status_tanah);							
					$sheet->setCellValue('Q'.$cell, $kibditemextras->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibditemextras->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibditemextras->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibditemextras->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibditemextras->uraian);				
					$sheet->setCellValue('W'.$cell, $kibditemextras->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibditemextras->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-JIJRB');
				foreach($kibditemrb as $index=>$kibditemrbs){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibditemrbs->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibditemrbs->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibditemrbs->no_reg);
					$sheet->setCellValue('E'.$cell, $kibditemrbs->konstruksi);				
					$sheet->setCellValue('F'.$cell, $kibditemrbs->panjang);				
					$sheet->setCellValue('G'.$cell, $kibditemrbs->lebar);				
					$sheet->setCellValue('H'.$cell, $kibditemrbs->luas);				
					$sheet->setCellValue('I'.$cell, $kibditemrbs->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibditemrbs->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibditemrbs->dokumen_nomor);				
					$sheet->setCellValue('L'.$cell, $kibditemrbs->status_tanah);							
					$sheet->setCellValue('Q'.$cell, $kibditemrbs->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibditemrbs->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibditemrbs->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibditemrbs->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibditemrbs->uraian);				
					$sheet->setCellValue('W'.$cell, $kibditemrbs->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibditemrbs->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}				
				//end
				
				//aset tetap lainnya
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-ATL');
				foreach($kibeitem as $index=>$kibeitems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibeitems->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibeitems->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibeitems->jml_item);
					$sheet->setCellValue('G'.$cell, $kibeitems->asaldaerah);				
					$sheet->setCellValue('H'.$cell, $kibeitems->pencipta);				
					$sheet->setCellValue('I'.$cell, $kibeitems->bahan);				
					$sheet->setCellValue('J'.$cell, $kibeitems->jenis);				
					$sheet->setCellValue('K'.$cell, $kibeitems->ukuran);
					$sheet->setCellValue('L'.$cell, $kibeitems->jml_item);
					$sheet->setCellValue('M'.$cell, $kibeitems->uraian);						
					$sheet->setCellValue('N'.$cell, $kibeitems->tahun_perolehan);				
					$sheet->setCellValue('O'.$cell, $kibeitems->hargaperolehan);											
					$sheet->setCellValue('Q'.$cell, $kibeitems->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibeitems->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibeitems->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibeitems->berkurang);												
					$sheet->setCellValue('V'.$cell, $kibeitems->keterangan);				
					$sheet->setCellValue('W'.$cell, $kibeitems->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-ATLRB');
				foreach($kibeitemrb as $index=>$kibeitemrbs){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibeitemrbs->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibeitemrbs->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibeitemrbs->jml_item);
					$sheet->setCellValue('G'.$cell, $kibeitemrbs->asaldaerah);				
					$sheet->setCellValue('H'.$cell, $kibeitemrbs->pencipta);				
					$sheet->setCellValue('I'.$cell, $kibeitemrbs->bahan);				
					$sheet->setCellValue('J'.$cell, $kibeitemrbs->jenis);				
					$sheet->setCellValue('K'.$cell, $kibeitemrbs->ukuran);
					$sheet->setCellValue('L'.$cell, $kibeitemrbs->jml_item);
					$sheet->setCellValue('M'.$cell, $kibeitemrbs->uraian);						
					$sheet->setCellValue('N'.$cell, $kibeitemrbs->tahun_perolehan);				
					$sheet->setCellValue('O'.$cell, $kibeitemrbs->hargaperolehan);											
					$sheet->setCellValue('Q'.$cell, $kibeitemrbs->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibeitemrbs->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibeitemrbs->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibeitemrbs->berkurang);												
					$sheet->setCellValue('V'.$cell, $kibeitemrbs->keterangan);				
					$sheet->setCellValue('W'.$cell, $kibeitemrbs->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-KDP');
				foreach($kibkdp as $index=>$kibkdps){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibkdps->Nm_Aset5);
					$sheet->setCellValue('D'.$cell, $kibkdps->bertingkat);
					$sheet->setCellValue('E'.$cell, $kibkdps->beton);
					$sheet->setCellValue('F'.$cell, $kibkdps->luas);				
					$sheet->setCellValue('G'.$cell, $kibkdps->lokasi);				
					$sheet->setCellValue('H'.$cell, $kibkdps->dokumentanggal);				
					$sheet->setCellValue('I'.$cell, $kibkdps->dokumennomor);				
					$sheet->setCellValue('J'.$cell, $kibkdps->tgl_perolehan);							
					$sheet->setCellValue('K'.$cell, $kibkdps->status_tanah);							
					$sheet->setCellValue('N'.$cell, $kibkdps->harga);											
					$sheet->setCellValue('P'.$cell, $kibkdps->NK_tambah);				
					$sheet->setCellValue('Q'.$cell, $kibkdps->bertambah);				
					$sheet->setCellValue('R'.$cell, $kibkdps->NK_kurang);				
					$sheet->setCellValue('S'.$cell, $kibkdps->berkurang);												
					$sheet->setCellValue('U'.$cell, $kibkdps->keterangan);				
					$sheet->setCellValue('X'.$cell, $kibkdps->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-Lainnya');
				foreach($kiblainnya as $index=>$kiblainnyas){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kiblainnyas->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kiblainnyas->kd_barang);
					$sheet->setCellValue('D'.$cell, $kiblainnyas->jml_item);
					$sheet->setCellValue('E'.$cell, $kiblainnyas->tahun_perolehan);			
					$sheet->setCellValue('I'.$cell, $kiblainnyas->uraian);			
					$sheet->setCellValue('J'.$cell, $kiblainnyas->Asal_usul);																		
					$sheet->setCellValue('M'.$cell, $kiblainnyas->NK_tambah);				
					$sheet->setCellValue('N'.$cell, $kiblainnyas->bertambah);				
					$sheet->setCellValue('O'.$cell, $kiblainnyas->NK_kurang);				
					$sheet->setCellValue('P'.$cell, $kiblainnyas->berkurang);												
					$sheet->setCellValue('R'.$cell, $kiblainnyas->keterangan);				
					//$sheet->setCellValue('S'.$cell, $kiblainnyas->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 19;
				$sheet = $spreadsheet->getSheetByName('Rubah Kondisi Barang');
				foreach($kiblainnyareg as $index=>$kiblainnyaregs){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);										
					$sheet->setCellValue('C'.$cell, $kiblainnyaregs->kd_barang);
					$sheet->setCellValue('D'.$cell, $kiblainnyaregs->no_reg);
					$sheet->setCellValue('E'.$cell, $kiblainnyaregs->tahun_perolehan);
					$sheet->setCellValue('F'.$cell, $kiblainnyaregs->Nm_Aset5);
					$sheet->setCellValue('G'.$cell, $kiblainnyaregs->harga);
					$sheet->setCellValue('H'.$cell, 'Baik');																																	
					$sheet->setCellValue('I'.$cell, $kiblainnyaregs->uraian);																																	
					$sheet->setCellValue('R'.$cell, $kiblainnyaregs->keterangan);							
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$writer = new Xlsx($spreadsheet);
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="MASTER_LAPORAN_MUTASI_BMD_2022_v03.xlsx"');
				$writer->setPreCalculateFormulas(false);
				$writer->save('php://output');
																
			}else{
				
				$kdbidang = Module::kdopd()->kd_bidang;
				$kdunit = Module::kdopd()->kd_unit;
				$kdsub = Module::kdopd()->kd_sub;
				$kdupb = Module::kdopd()->kd_upb;
				
				
				$kibaitem = Module::kkopdtanah($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,$kdsub,"'%'");
				
				$kibbitem = Module::kkopdpm($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,$kdsub,"'%'");
				$kibbitemextra = Module::kkopdpmextra($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,$kdsub,"'%'");
				$kibbitemrb = Module::kkopdpmrb($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,$kdsub,"'%'");
				
				$kibcitem = Module::kkopdgb($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,$kdsub,"'%'");
				$kibcitemextra = Module::kkopdgbextra($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,$kdsub,"'%'");
				$kibcitemrb = Module::kkopdgbrb($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,$kdsub,"'%'");
				
				$kibditem = Module::kkopdjij($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,$kdsub,"'%'");
				$kibditemextra = Module::kkopdjijextra($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,$kdsub,"'%'");
				$kibditemrb = Module::kkopdjijrb($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,$kdsub,"'%'");
				
				$kibeitem = Module::kkopdatl($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,$kdsub,"'%'");
				$kibeitemrb = Module::kkopdatlrb($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,$kdsub,"'%'");
				
				$kibkdp = Module::kkopdkdp($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,$kdsub,"'%'");
				$kiblainnya= Module::kkopdlainnya($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,$kdsub,"'%'");
				
				$kiblainnyareg= Module::kkopdlainnyareg($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,$kdsub,"'%'");
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-Tanah');
				foreach($kibaitem as $index=>$kibaitems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibaitems->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibaitems->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibaitems->no_reg);
					$sheet->setCellValue('E'.$cell, $kibaitems->luas);				
					$sheet->setCellValue('F'.$cell, $kibaitems->tahun_perolehan);				
					$sheet->setCellValue('G'.$cell, $kibaitems->alamat);				
					$sheet->setCellValue('H'.$cell, $kibaitems->Hak_Tanah);				
					$sheet->setCellValue('I'.$cell, $kibaitems->sertifikat_tanggal);				
					$sheet->setCellValue('J'.$cell, $kibaitems->sertifikat_nomor);				
					$sheet->setCellValue('K'.$cell, $kibaitems->penggunaan);				
					$sheet->setCellValue('L'.$cell, $kibaitems->Asal_usul);				
					$sheet->setCellValue('M'.$cell, $kibaitems->hargaperolehan);				
					$sheet->setCellValue('O'.$cell, $kibaitems->NK_tambah);				
					$sheet->setCellValue('P'.$cell, $kibaitems->bertambah);				
					$sheet->setCellValue('Q'.$cell, $kibaitems->NK_kurang);				
					$sheet->setCellValue('R'.$cell, $kibaitems->berkurang);				
					$sheet->setCellValue('T'.$cell, $kibaitems->keterangan);				
					$sheet->setCellValue('U'.$cell, $kibaitems->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				//peralatan & mesin
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-PeralatanMesin');
				foreach($kibbitem as $index=>$kibbitems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibbitems->kd_barang);
					$sheet->setCellValue('C'.$cell, $kibbitems->Nm_Aset5);
					$sheet->setCellValue('D'.$cell, $kibbitems->jml_item);
					$sheet->setCellValue('E'.$cell, $kibbitems->merk);				
					$sheet->setCellValue('H'.$cell, $kibbitems->tahun_perolehan);				
					$sheet->setCellValue('M'.$cell, $kibbitems->nomor_bpkb);				
					$sheet->setCellValue('L'.$cell, $kibbitems->nomor_polisi);										
					$sheet->setCellValue('N'.$cell, $kibbitems->Asal_usul);				
					$sheet->setCellValue('O'.$cell, $kibbitems->hargaperolehan);				
					$sheet->setCellValue('Q'.$cell, $kibbitems->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibbitems->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibbitems->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibbitems->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibbitems->keterangan);				
					$sheet->setCellValue('W'.$cell, $kibbitems->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}			
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Ekstra-PeralatanMesin');
				foreach($kibbitemextra as $index=>$kibbitemextras){
					$index = $index+1;					
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibbitemextras->kd_barang);
					$sheet->setCellValue('C'.$cell, $kibbitemextras->Nm_Aset5);
					$sheet->setCellValue('D'.$cell, $kibbitemextras->jml_item);
					$sheet->setCellValue('E'.$cell, $kibbitemextras->merk);				
					$sheet->setCellValue('H'.$cell, $kibbitemextras->tahun_perolehan);				
					$sheet->setCellValue('L'.$cell, $kibbitemextras->nomor_bpkb);				
					$sheet->setCellValue('M'.$cell, $kibbitemextras->nomor_polisi);										
					$sheet->setCellValue('N'.$cell, $kibbitemextras->Asal_usul);				
					$sheet->setCellValue('O'.$cell, $kibbitemextras->hargaperolehan);				
					$sheet->setCellValue('Q'.$cell, $kibbitemextras->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibbitemextras->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibbitemextras->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibbitemextras->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibbitemextras->keterangan);							
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-PeralatanMesinRB');
				foreach($kibbitemrb as $index=>$kibbitemrbs){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibbitemrbs->kd_barang);
					$sheet->setCellValue('C'.$cell, $kibbitemrbs->Nm_Aset5);
					$sheet->setCellValue('D'.$cell, $kibbitemrbs->jml_item);
					$sheet->setCellValue('E'.$cell, $kibbitemrbs->merk);				
					$sheet->setCellValue('H'.$cell, $kibbitemrbs->tahun_perolehan);				
					$sheet->setCellValue('L'.$cell, $kibbitemrbs->nomor_bpkb);				
					$sheet->setCellValue('M'.$cell, $kibbitemrbs->nomor_polisi);										
					$sheet->setCellValue('N'.$cell, $kibbitemrbs->Asal_usul);				
					$sheet->setCellValue('O'.$cell, $kibbitemrbs->hargaperolehan);				
					$sheet->setCellValue('Q'.$cell, $kibbitemrbs->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibbitemrbs->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibbitemrbs->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibbitemrbs->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibbitemrbs->keterangan);						
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				//end
				
				//gedung dan bangunan
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-GedungBangunan');
				foreach($kibcitem as $index=>$kibcitems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibcitems->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibcitems->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibcitems->no_reg);
					$sheet->setCellValue('E'.$cell, $kibcitems->uraian);				
					$sheet->setCellValue('F'.$cell, $kibcitems->bertingkat_tidak);				
					$sheet->setCellValue('G'.$cell, $kibcitems->beton_tidak);				
					$sheet->setCellValue('H'.$cell, $kibcitems->luas_lantai);				
					$sheet->setCellValue('I'.$cell, $kibcitems->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibcitems->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibcitems->dokumen_nomor);				
					$sheet->setCellValue('M'.$cell, $kibcitems->status_tanah);							
					$sheet->setCellValue('R'.$cell, $kibcitems->NK_tambah);				
					$sheet->setCellValue('S'.$cell, $kibcitems->bertambah);				
					$sheet->setCellValue('T'.$cell, $kibcitems->NK_kurang);				
					$sheet->setCellValue('U'.$cell, $kibcitems->berkurang);				
					$sheet->setCellValue('W'.$cell, $kibcitems->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibcitems->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Ekstra-GedungBangunan');
				foreach($kibcitemextra as $index=>$kibcitemextras){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibcitemextras->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibcitemextras->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibcitemextras->no_reg);
					$sheet->setCellValue('E'.$cell, $kibcitemextras->uraian);				
					$sheet->setCellValue('F'.$cell, $kibcitemextras->bertingkat_tidak);				
					$sheet->setCellValue('G'.$cell, $kibcitemextras->beton_tidak);				
					$sheet->setCellValue('H'.$cell, $kibcitemextras->luas_lantai);				
					$sheet->setCellValue('I'.$cell, $kibcitemextras->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibcitemextras->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibcitemextras->dokumen_nomor);				
					$sheet->setCellValue('M'.$cell, $kibcitemextras->status_tanah);							
					$sheet->setCellValue('R'.$cell, $kibcitemextras->NK_tambah);				
					$sheet->setCellValue('S'.$cell, $kibcitemextras->bertambah);				
					$sheet->setCellValue('T'.$cell, $kibcitemextras->NK_kurang);				
					$sheet->setCellValue('U'.$cell, $kibcitemextras->berkurang);				
					$sheet->setCellValue('W'.$cell, $kibcitemextras->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibcitemextras->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-GedungBangunanRB');
				foreach($kibcitemrb as $index=>$kibcitemrbs){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibcitemrbs->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibcitemrbs->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibcitemrbs->no_reg);
					$sheet->setCellValue('E'.$cell, $kibcitemrbs->uraian);				
					$sheet->setCellValue('F'.$cell, $kibcitemrbs->bertingkat_tidak);				
					$sheet->setCellValue('G'.$cell, $kibcitemrbs->beton_tidak);				
					$sheet->setCellValue('H'.$cell, $kibcitemrbs->luas_lantai);				
					$sheet->setCellValue('I'.$cell, $kibcitemrbs->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibcitemrbs->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibcitemrbs->dokumen_nomor);				
					$sheet->setCellValue('M'.$cell, $kibcitemrbs->status_tanah);							
					$sheet->setCellValue('R'.$cell, $kibcitemrbs->NK_tambah);				
					$sheet->setCellValue('S'.$cell, $kibcitemrbs->bertambah);				
					$sheet->setCellValue('T'.$cell, $kibcitemrbs->NK_kurang);				
					$sheet->setCellValue('U'.$cell, $kibcitemrbs->berkurang);				
					$sheet->setCellValue('W'.$cell, $kibcitemrbs->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibcitemrbs->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}				
				//end
				
				//jalan jaringan irigasi
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-JIJ');
				foreach($kibditem as $index=>$kibditems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibditems->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibditems->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibditems->no_reg);
					$sheet->setCellValue('E'.$cell, $kibditems->konstruksi);				
					$sheet->setCellValue('F'.$cell, $kibditems->panjang);				
					$sheet->setCellValue('G'.$cell, $kibditems->lebar);				
					$sheet->setCellValue('H'.$cell, $kibditems->luas);				
					$sheet->setCellValue('I'.$cell, $kibditems->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibditems->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibditems->dokumen_nomor);				
					$sheet->setCellValue('L'.$cell, $kibditems->status_tanah);							
					$sheet->setCellValue('O'.$cell, $kibditems->hargaperolehan);							
					$sheet->setCellValue('Q'.$cell, $kibditems->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibditems->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibditems->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibditems->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibditems->uraian);				
					$sheet->setCellValue('W'.$cell, $kibditems->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibditems->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Ekstra-JIJ');
				foreach($kibditemextra as $index=>$kibditemextras){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibditemextras->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibditemextras->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibditemextras->no_reg);
					$sheet->setCellValue('E'.$cell, $kibditemextras->konstruksi);				
					$sheet->setCellValue('F'.$cell, $kibditemextras->panjang);				
					$sheet->setCellValue('G'.$cell, $kibditemextras->lebar);				
					$sheet->setCellValue('H'.$cell, $kibditemextras->luas);				
					$sheet->setCellValue('I'.$cell, $kibditemextras->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibditemextras->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibditemextras->dokumen_nomor);				
					$sheet->setCellValue('L'.$cell, $kibditemextras->status_tanah);							
					$sheet->setCellValue('Q'.$cell, $kibditemextras->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibditemextras->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibditemextras->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibditemextras->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibditemextras->uraian);				
					$sheet->setCellValue('W'.$cell, $kibditemextras->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibditemextras->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-JIJRB');
				foreach($kibditemrb as $index=>$kibditemrbs){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibditemrbs->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibditemrbs->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibditemrbs->no_reg);
					$sheet->setCellValue('E'.$cell, $kibditemrbs->konstruksi);				
					$sheet->setCellValue('F'.$cell, $kibditemrbs->panjang);				
					$sheet->setCellValue('G'.$cell, $kibditemrbs->lebar);				
					$sheet->setCellValue('H'.$cell, $kibditemrbs->luas);				
					$sheet->setCellValue('I'.$cell, $kibditemrbs->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibditemrbs->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibditemrbs->dokumen_nomor);				
					$sheet->setCellValue('L'.$cell, $kibditemrbs->status_tanah);							
					$sheet->setCellValue('Q'.$cell, $kibditemrbs->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibditemrbs->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibditemrbs->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibditemrbs->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibditemrbs->uraian);				
					$sheet->setCellValue('W'.$cell, $kibditemrbs->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibditemrbs->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}				
				//end
				
				//aset tetap lainnya
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-ATL');
				foreach($kibeitem as $index=>$kibeitems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibeitems->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibeitems->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibeitems->jml_item);
					$sheet->setCellValue('G'.$cell, $kibeitems->asaldaerah);				
					$sheet->setCellValue('H'.$cell, $kibeitems->pencipta);				
					$sheet->setCellValue('I'.$cell, $kibeitems->bahan);				
					$sheet->setCellValue('J'.$cell, $kibeitems->jenis);				
					$sheet->setCellValue('K'.$cell, $kibeitems->ukuran);
					$sheet->setCellValue('L'.$cell, $kibeitems->jml_item);
					$sheet->setCellValue('M'.$cell, $kibeitems->uraian);						
					$sheet->setCellValue('N'.$cell, $kibeitems->tahun_perolehan);				
					$sheet->setCellValue('O'.$cell, $kibeitems->hargaperolehan);											
					$sheet->setCellValue('Q'.$cell, $kibeitems->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibeitems->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibeitems->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibeitems->berkurang);												
					$sheet->setCellValue('V'.$cell, $kibeitems->keterangan);				
					$sheet->setCellValue('W'.$cell, $kibeitems->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-ATLRB');
				foreach($kibeitem as $index=>$kibeitemrbs){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibeitemrbs->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibeitemrbs->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibeitemrbs->jml_item);
					$sheet->setCellValue('G'.$cell, $kibeitemrbs->asaldaerah);				
					$sheet->setCellValue('H'.$cell, $kibeitemrbs->pencipta);				
					$sheet->setCellValue('I'.$cell, $kibeitemrbs->bahan);				
					$sheet->setCellValue('J'.$cell, $kibeitemrbs->jenis);				
					$sheet->setCellValue('K'.$cell, $kibeitemrbs->ukuran);
					$sheet->setCellValue('L'.$cell, $kibeitemrbs->jml_item);
					$sheet->setCellValue('M'.$cell, $kibeitemrbs->uraian);						
					$sheet->setCellValue('N'.$cell, $kibeitemrbs->tahun_perolehan);				
					$sheet->setCellValue('O'.$cell, $kibeitemrbs->hargaperolehan);											
					$sheet->setCellValue('Q'.$cell, $kibeitemrbs->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibeitemrbs->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibeitemrbs->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibeitemrbs->berkurang);												
					$sheet->setCellValue('V'.$cell, $kibeitemrbs->keterangan);				
					$sheet->setCellValue('W'.$cell, $kibeitemrbs->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-KDP');
				foreach($kibkdp as $index=>$kibkdps){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibkdps->Nm_Aset5);
					$sheet->setCellValue('D'.$cell, $kibkdps->bertingkat);
					$sheet->setCellValue('E'.$cell, $kibkdps->beton);
					$sheet->setCellValue('F'.$cell, $kibkdps->luas);				
					$sheet->setCellValue('G'.$cell, $kibkdps->lokasi);				
					$sheet->setCellValue('H'.$cell, $kibkdps->dokumentanggal);				
					$sheet->setCellValue('I'.$cell, $kibkdps->dokumennomor);				
					$sheet->setCellValue('J'.$cell, $kibkdps->tgl_perolehan);							
					$sheet->setCellValue('K'.$cell, $kibkdps->status_tanah);							
					$sheet->setCellValue('N'.$cell, $kibkdps->harga);											
					$sheet->setCellValue('P'.$cell, $kibkdps->NK_tambah);				
					$sheet->setCellValue('Q'.$cell, $kibkdps->bertambah);				
					$sheet->setCellValue('R'.$cell, $kibkdps->NK_kurang);				
					$sheet->setCellValue('S'.$cell, $kibkdps->berkurang);												
					$sheet->setCellValue('U'.$cell, $kibkdps->keterangan);				
					$sheet->setCellValue('X'.$cell, $kibkdps->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-Lainnya');
				foreach($kiblainnya as $index=>$kiblainnyas){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kiblainnyas->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kiblainnyas->kd_barang);
					$sheet->setCellValue('D'.$cell, $kiblainnyas->jml_item);
					$sheet->setCellValue('E'.$cell, $kiblainnyas->tahun_perolehan);			
					$sheet->setCellValue('I'.$cell, $kiblainnyas->uraian);			
					$sheet->setCellValue('J'.$cell, $kiblainnyas->Asal_usul);																		
					$sheet->setCellValue('M'.$cell, $kiblainnyas->NK_tambah);				
					$sheet->setCellValue('N'.$cell, $kiblainnyas->bertambah);				
					$sheet->setCellValue('O'.$cell, $kiblainnyas->NK_kurang);				
					$sheet->setCellValue('P'.$cell, $kiblainnyas->berkurang);												
					$sheet->setCellValue('R'.$cell, $kiblainnyas->keterangan);				
					//$sheet->setCellValue('S'.$cell, $kiblainnyas->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 19;
				$sheet = $spreadsheet->getSheetByName('Rubah Kondisi Barang');
				foreach($kiblainnyareg as $index=>$kiblainnyaregs){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);										
					$sheet->setCellValue('C'.$cell, $kiblainnyaregs->kd_barang);
					$sheet->setCellValue('D'.$cell, $kiblainnyaregs->no_reg);
					$sheet->setCellValue('E'.$cell, $kiblainnyaregs->tahun_perolehan);
					$sheet->setCellValue('F'.$cell, $kiblainnyaregs->Nm_Aset5);
					$sheet->setCellValue('G'.$cell, $kiblainnyaregs->harga);
					$sheet->setCellValue('H'.$cell, 'Baik');																																	
					$sheet->setCellValue('I'.$cell, $kiblainnyaregs->uraian);																																	
					$sheet->setCellValue('R'.$cell, $kiblainnyaregs->keterangan);							
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$writer = new Xlsx($spreadsheet);
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="MASTER_LAPORAN_MUTASI_BMD_2022_v03.xlsx"');
				$writer->setPreCalculateFormulas(false);
				$writer->save('php://output');
				
				
			}
			
			
			
			
		}else{
			return view(abort(403, 'Unauthorized action.'));
		}			 
	}
	
	public function kkupb($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,$kdsubs,$kdupbs){
		$kdbidang = Module::kdopd()->kd_bidang;	

		/* $data = Module::kibaall($kdbidangs,$kdunits,$kdsubs);
		dd($data); */

		if(Module::hasAccess("Rekonsiliasi_asets", "view")) {
			
				$inputFileType = 'Xlsx'; // Xlsx - Xml - Ods - Slk - Gnumeric - Csv
				$inputFileName = public_path('storage\format\DRAFT-MASTER_LAPORAN_MUTASI_BMD_2022_v02.xlsx');
				$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);		
				$spreadsheet = new Spreadsheet();
				$spreadsheet = $reader->load($inputFileName);
				
			if($kdbidang == 99 || $kdbidang == 0 ){	
																																
				$kibaitem = Module::kkopdtanah($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,$kdsubs,$kdupbs);
				
				$kibbitem = Module::kkopdpm($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,$kdsubs,$kdupbs);
				$kibbitemextra = Module::kkopdpmextra($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,$kdsubs,$kdupbs);
				$kibbitemrb = Module::kkopdpmrb($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,$kdsubs,$kdupbs);
				
				$kibcitem = Module::kkopdgb($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,$kdsubs,$kdupbs);
				$kibcitemextra = Module::kkopdgbextra($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,$kdsubs,$kdupbs);
				$kibcitemrb = Module::kkopdgbrb($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,$kdsubs,$kdupbs);
				
				$kibditem = Module::kkopdjij($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,$kdsubs,$kdupbs);
				$kibditemextra = Module::kkopdjijextra($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,$kdsubs,$kdupbs);
				$kibditemrb = Module::kkopdjijrb($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,$kdsubs,$kdupbs);
				
				$kibeitem = Module::kkopdatl($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,$kdsubs,$kdupbs);
				$kibeitemrb = Module::kkopdatlrb($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,$kdsubs,$kdupbs);
				
				$kibkdp = Module::kkopdkdp($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,$kdsubs,$kdupbs);
				$kiblainnya= Module::kkopdlainnya($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,$kdsubs,$kdupbs);
				
				$kiblainnyareg= Module::kkopdlainnyareg($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,$kdsubs,$kdupbs);
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-Tanah');
				foreach($kibaitem as $index=>$kibaitems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibaitems->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibaitems->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibaitems->no_reg);
					$sheet->setCellValue('E'.$cell, $kibaitems->luas);				
					$sheet->setCellValue('F'.$cell, $kibaitems->tahun_perolehan);				
					$sheet->setCellValue('G'.$cell, $kibaitems->alamat);				
					$sheet->setCellValue('H'.$cell, $kibaitems->Hak_Tanah);				
					$sheet->setCellValue('I'.$cell, $kibaitems->sertifikat_tanggal);				
					$sheet->setCellValue('J'.$cell, $kibaitems->sertifikat_nomor);				
					$sheet->setCellValue('K'.$cell, $kibaitems->penggunaan);				
					$sheet->setCellValue('L'.$cell, $kibaitems->Asal_usul);				
					$sheet->setCellValue('M'.$cell, $kibaitems->hargaperolehan);				
					$sheet->setCellValue('O'.$cell, $kibaitems->NK_tambah);				
					$sheet->setCellValue('P'.$cell, $kibaitems->bertambah);				
					$sheet->setCellValue('Q'.$cell, $kibaitems->NK_kurang);				
					$sheet->setCellValue('R'.$cell, $kibaitems->berkurang);				
					$sheet->setCellValue('T'.$cell, $kibaitems->keterangan);				
					$sheet->setCellValue('U'.$cell, $kibaitems->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				//peralatan & mesin
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-PeralatanMesin');
				foreach($kibbitem as $index=>$kibbitems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibbitems->kd_barang);
					$sheet->setCellValue('C'.$cell, $kibbitems->Nm_Aset5);
					$sheet->setCellValue('D'.$cell, $kibbitems->jml_item);
					$sheet->setCellValue('E'.$cell, $kibbitems->merk);				
					$sheet->setCellValue('H'.$cell, $kibbitems->tahun_perolehan);				
					$sheet->setCellValue('M'.$cell, $kibbitems->nomor_bpkb);				
					$sheet->setCellValue('L'.$cell, $kibbitems->nomor_polisi);										
					$sheet->setCellValue('N'.$cell, $kibbitems->Asal_usul);				
					$sheet->setCellValue('O'.$cell, $kibbitems->hargaperolehan);				
					$sheet->setCellValue('Q'.$cell, $kibbitems->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibbitems->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibbitems->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibbitems->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibbitems->keterangan);				
					$sheet->setCellValue('W'.$cell, $kibbitems->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}			
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Ekstra-PeralatanMesin');
				foreach($kibbitemextra as $index=>$kibbitemextras){
					$index = $index+1;					
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibbitemextras->kd_barang);
					$sheet->setCellValue('C'.$cell, $kibbitemextras->Nm_Aset5);
					$sheet->setCellValue('D'.$cell, $kibbitemextras->jml_item);
					$sheet->setCellValue('E'.$cell, $kibbitemextras->merk);				
					$sheet->setCellValue('H'.$cell, $kibbitemextras->tahun_perolehan);				
					$sheet->setCellValue('L'.$cell, $kibbitemextras->nomor_bpkb);				
					$sheet->setCellValue('M'.$cell, $kibbitemextras->nomor_polisi);										
					$sheet->setCellValue('N'.$cell, $kibbitemextras->Asal_usul);				
					$sheet->setCellValue('O'.$cell, $kibbitemextras->hargaperolehan);				
					$sheet->setCellValue('Q'.$cell, $kibbitemextras->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibbitemextras->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibbitemextras->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibbitemextras->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibbitemextras->keterangan);							
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-PeralatanMesinRB');
				foreach($kibbitemrb as $index=>$kibbitemrbs){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibbitemrbs->kd_barang);
					$sheet->setCellValue('C'.$cell, $kibbitemrbs->Nm_Aset5);
					$sheet->setCellValue('D'.$cell, $kibbitemrbs->jml_item);
					$sheet->setCellValue('E'.$cell, $kibbitemrbs->merk);				
					$sheet->setCellValue('H'.$cell, $kibbitemrbs->tahun_perolehan);				
					$sheet->setCellValue('L'.$cell, $kibbitemrbs->nomor_bpkb);				
					$sheet->setCellValue('M'.$cell, $kibbitemrbs->nomor_polisi);										
					$sheet->setCellValue('N'.$cell, $kibbitemrbs->Asal_usul);				
					$sheet->setCellValue('O'.$cell, $kibbitemrbs->hargaperolehan);				
					$sheet->setCellValue('Q'.$cell, $kibbitemrbs->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibbitemrbs->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibbitemrbs->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibbitemrbs->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibbitemrbs->keterangan);						
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				//end
				
				//gedung dan bangunan
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-GedungBangunan');
				foreach($kibcitem as $index=>$kibcitems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibcitems->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibcitems->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibcitems->no_reg);
					$sheet->setCellValue('E'.$cell, $kibcitems->uraian);				
					$sheet->setCellValue('F'.$cell, $kibcitems->bertingkat_tidak);				
					$sheet->setCellValue('G'.$cell, $kibcitems->beton_tidak);				
					$sheet->setCellValue('H'.$cell, $kibcitems->luas_lantai);				
					$sheet->setCellValue('I'.$cell, $kibcitems->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibcitems->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibcitems->dokumen_nomor);				
					$sheet->setCellValue('M'.$cell, $kibcitems->status_tanah);							
					$sheet->setCellValue('R'.$cell, $kibcitems->NK_tambah);				
					$sheet->setCellValue('S'.$cell, $kibcitems->bertambah);				
					$sheet->setCellValue('T'.$cell, $kibcitems->NK_kurang);				
					$sheet->setCellValue('U'.$cell, $kibcitems->berkurang);				
					$sheet->setCellValue('W'.$cell, $kibcitems->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibcitems->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Ekstra-GedungBangunan');
				foreach($kibcitemextra as $index=>$kibcitemextras){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibcitemextras->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibcitemextras->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibcitemextras->no_reg);
					$sheet->setCellValue('E'.$cell, $kibcitemextras->uraian);				
					$sheet->setCellValue('F'.$cell, $kibcitemextras->bertingkat_tidak);				
					$sheet->setCellValue('G'.$cell, $kibcitemextras->beton_tidak);				
					$sheet->setCellValue('H'.$cell, $kibcitemextras->luas_lantai);				
					$sheet->setCellValue('I'.$cell, $kibcitemextras->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibcitemextras->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibcitemextras->dokumen_nomor);				
					$sheet->setCellValue('M'.$cell, $kibcitemextras->status_tanah);							
					$sheet->setCellValue('R'.$cell, $kibcitemextras->NK_tambah);				
					$sheet->setCellValue('S'.$cell, $kibcitemextras->bertambah);				
					$sheet->setCellValue('T'.$cell, $kibcitemextras->NK_kurang);				
					$sheet->setCellValue('U'.$cell, $kibcitemextras->berkurang);				
					$sheet->setCellValue('W'.$cell, $kibcitemextras->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibcitemextras->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-GedungBangunanRB');
				foreach($kibcitemrb as $index=>$kibcitemrbs){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibcitemrbs->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibcitemrbs->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibcitemrbs->no_reg);
					$sheet->setCellValue('E'.$cell, $kibcitemrbs->uraian);				
					$sheet->setCellValue('F'.$cell, $kibcitemrbs->bertingkat_tidak);				
					$sheet->setCellValue('G'.$cell, $kibcitemrbs->beton_tidak);				
					$sheet->setCellValue('H'.$cell, $kibcitemrbs->luas_lantai);				
					$sheet->setCellValue('I'.$cell, $kibcitemrbs->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibcitemrbs->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibcitemrbs->dokumen_nomor);				
					$sheet->setCellValue('M'.$cell, $kibcitemrbs->status_tanah);							
					$sheet->setCellValue('R'.$cell, $kibcitemrbs->NK_tambah);				
					$sheet->setCellValue('S'.$cell, $kibcitemrbs->bertambah);				
					$sheet->setCellValue('T'.$cell, $kibcitemrbs->NK_kurang);				
					$sheet->setCellValue('U'.$cell, $kibcitemrbs->berkurang);				
					$sheet->setCellValue('W'.$cell, $kibcitemrbs->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibcitemrbs->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}				
				//end
				
				//jalan jaringan irigasi
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-JIJ');
				foreach($kibditem as $index=>$kibditems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibditems->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibditems->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibditems->no_reg);
					$sheet->setCellValue('E'.$cell, $kibditems->konstruksi);				
					$sheet->setCellValue('F'.$cell, $kibditems->panjang);				
					$sheet->setCellValue('G'.$cell, $kibditems->lebar);				
					$sheet->setCellValue('H'.$cell, $kibditems->luas);				
					$sheet->setCellValue('I'.$cell, $kibditems->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibditems->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibditems->dokumen_nomor);				
					$sheet->setCellValue('L'.$cell, $kibditems->status_tanah);							
					$sheet->setCellValue('O'.$cell, $kibditems->hargaperolehan);							
					$sheet->setCellValue('Q'.$cell, $kibditems->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibditems->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibditems->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibditems->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibditems->uraian);				
					$sheet->setCellValue('W'.$cell, $kibditems->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibditems->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Ekstra-JIJ');
				foreach($kibditemextra as $index=>$kibditemextras){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibditemextras->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibditemextras->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibditemextras->no_reg);
					$sheet->setCellValue('E'.$cell, $kibditemextras->konstruksi);				
					$sheet->setCellValue('F'.$cell, $kibditemextras->panjang);				
					$sheet->setCellValue('G'.$cell, $kibditemextras->lebar);				
					$sheet->setCellValue('H'.$cell, $kibditemextras->luas);				
					$sheet->setCellValue('I'.$cell, $kibditemextras->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibditemextras->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibditemextras->dokumen_nomor);				
					$sheet->setCellValue('L'.$cell, $kibditemextras->status_tanah);							
					$sheet->setCellValue('Q'.$cell, $kibditemextras->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibditemextras->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibditemextras->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibditemextras->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibditemextras->uraian);				
					$sheet->setCellValue('W'.$cell, $kibditemextras->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibditemextras->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-JIJRB');
				foreach($kibditemrb as $index=>$kibditemrbs){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibditemrbs->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibditemrbs->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibditemrbs->no_reg);
					$sheet->setCellValue('E'.$cell, $kibditemrbs->konstruksi);				
					$sheet->setCellValue('F'.$cell, $kibditemrbs->panjang);				
					$sheet->setCellValue('G'.$cell, $kibditemrbs->lebar);				
					$sheet->setCellValue('H'.$cell, $kibditemrbs->luas);				
					$sheet->setCellValue('I'.$cell, $kibditemrbs->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibditemrbs->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibditemrbs->dokumen_nomor);				
					$sheet->setCellValue('L'.$cell, $kibditemrbs->status_tanah);							
					$sheet->setCellValue('Q'.$cell, $kibditemrbs->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibditemrbs->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibditemrbs->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibditemrbs->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibditemrbs->uraian);				
					$sheet->setCellValue('W'.$cell, $kibditemrbs->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibditemrbs->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}				
				//end
				
				//aset tetap lainnya
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-ATL');
				foreach($kibeitemrb as $index=>$kibeitems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibeitems->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibeitems->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibeitems->jml_item);
					$sheet->setCellValue('G'.$cell, $kibeitems->asaldaerah);				
					$sheet->setCellValue('H'.$cell, $kibeitems->pencipta);				
					$sheet->setCellValue('I'.$cell, $kibeitems->bahan);				
					$sheet->setCellValue('J'.$cell, $kibeitems->jenis);				
					$sheet->setCellValue('K'.$cell, $kibeitems->ukuran);
					$sheet->setCellValue('L'.$cell, $kibeitems->jml_item);
					$sheet->setCellValue('M'.$cell, $kibeitems->uraian);						
					$sheet->setCellValue('N'.$cell, $kibeitems->tahun_perolehan);				
					$sheet->setCellValue('O'.$cell, $kibeitems->hargaperolehan);											
					$sheet->setCellValue('Q'.$cell, $kibeitems->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibeitems->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibeitems->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibeitems->berkurang);												
					$sheet->setCellValue('V'.$cell, $kibeitems->keterangan);				
					$sheet->setCellValue('W'.$cell, $kibeitems->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-ATLRB');
				foreach($kibeitem as $index=>$kibeitemrbs){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibeitemrbs->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibeitemrbs->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibeitemrbs->jml_item);
					$sheet->setCellValue('G'.$cell, $kibeitemrbs->asaldaerah);				
					$sheet->setCellValue('H'.$cell, $kibeitemrbs->pencipta);				
					$sheet->setCellValue('I'.$cell, $kibeitemrbs->bahan);				
					$sheet->setCellValue('J'.$cell, $kibeitemrbs->jenis);				
					$sheet->setCellValue('K'.$cell, $kibeitemrbs->ukuran);
					$sheet->setCellValue('L'.$cell, $kibeitemrbs->jml_item);
					$sheet->setCellValue('M'.$cell, $kibeitemrbs->uraian);						
					$sheet->setCellValue('N'.$cell, $kibeitemrbs->tahun_perolehan);				
					$sheet->setCellValue('O'.$cell, $kibeitemrbs->hargaperolehan);											
					$sheet->setCellValue('Q'.$cell, $kibeitemrbs->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibeitemrbs->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibeitemrbs->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibeitemrbs->berkurang);												
					$sheet->setCellValue('V'.$cell, $kibeitemrbs->keterangan);				
					$sheet->setCellValue('W'.$cell, $kibeitemrbs->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-KDP');
				foreach($kibkdp as $index=>$kibkdps){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibkdps->Nm_Aset5);
					$sheet->setCellValue('D'.$cell, $kibkdps->bertingkat);
					$sheet->setCellValue('E'.$cell, $kibkdps->beton);
					$sheet->setCellValue('F'.$cell, $kibkdps->luas);				
					$sheet->setCellValue('G'.$cell, $kibkdps->lokasi);				
					$sheet->setCellValue('H'.$cell, $kibkdps->dokumentanggal);				
					$sheet->setCellValue('I'.$cell, $kibkdps->dokumennomor);				
					$sheet->setCellValue('J'.$cell, $kibkdps->tgl_perolehan);							
					$sheet->setCellValue('K'.$cell, $kibkdps->status_tanah);							
					$sheet->setCellValue('N'.$cell, $kibkdps->harga);											
					$sheet->setCellValue('P'.$cell, $kibkdps->NK_tambah);				
					$sheet->setCellValue('Q'.$cell, $kibkdps->bertambah);				
					$sheet->setCellValue('R'.$cell, $kibkdps->NK_kurang);				
					$sheet->setCellValue('S'.$cell, $kibkdps->berkurang);												
					$sheet->setCellValue('U'.$cell, $kibkdps->keterangan);				
					$sheet->setCellValue('X'.$cell, $kibkdps->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-Lainnya');
				foreach($kiblainnya as $index=>$kiblainnyas){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kiblainnyas->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kiblainnyas->kd_barang);
					$sheet->setCellValue('D'.$cell, $kiblainnyas->jml_item);
					$sheet->setCellValue('E'.$cell, $kiblainnyas->tahun_perolehan);			
					$sheet->setCellValue('I'.$cell, $kiblainnyas->uraian);			
					$sheet->setCellValue('J'.$cell, $kiblainnyas->Asal_usul);																		
					$sheet->setCellValue('M'.$cell, $kiblainnyas->NK_tambah);				
					$sheet->setCellValue('N'.$cell, $kiblainnyas->bertambah);				
					$sheet->setCellValue('O'.$cell, $kiblainnyas->NK_kurang);				
					$sheet->setCellValue('P'.$cell, $kiblainnyas->berkurang);												
					$sheet->setCellValue('R'.$cell, $kiblainnyas->keterangan);				
					//$sheet->setCellValue('S'.$cell, $kiblainnyas->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 19;
				$sheet = $spreadsheet->getSheetByName('Rubah Kondisi Barang');
				foreach($kiblainnyareg as $index=>$kiblainnyaregs){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);										
					$sheet->setCellValue('C'.$cell, $kiblainnyaregs->kd_barang);
					$sheet->setCellValue('D'.$cell, $kiblainnyaregs->no_reg);
					$sheet->setCellValue('E'.$cell, $kiblainnyaregs->tahun_perolehan);
					$sheet->setCellValue('F'.$cell, $kiblainnyaregs->Nm_Aset5);
					$sheet->setCellValue('G'.$cell, $kiblainnyaregs->harga);
					$sheet->setCellValue('H'.$cell, 'Baik');																																	
					$sheet->setCellValue('I'.$cell, $kiblainnyaregs->uraian);																																	
					$sheet->setCellValue('R'.$cell, $kiblainnyaregs->keterangan);							
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$writer = new Xlsx($spreadsheet);
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="MASTER_LAPORAN_MUTASI_BMD_2022_v03.xlsx"');
				$writer->setPreCalculateFormulas(false);
				$writer->save('php://output');
																
			}else{
				
				$kdbidang = Module::kdopd()->kd_bidang;
				$kdunit = Module::kdopd()->kd_unit;
				$kdsub = Module::kdopd()->kd_sub;
				$kdupb = Module::kdopd()->kd_upb;
				
				
				$kibaitem = Module::kkopdtanah($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,$kdsub,$kdupb);
				
				$kibbitem = Module::kkopdpm($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,$kdsub,$kdupb);
				$kibbitemextra = Module::kkopdpmextra($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,$kdsub,$kdupb);
				$kibbitemrb = Module::kkopdpmrb($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,$kdsub,$kdupb);
				
				$kibcitem = Module::kkopdgb($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,$kdsub,$kdupb);
				$kibcitemextra = Module::kkopdgbextra($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,$kdsub,$kdupb);
				$kibcitemrb = Module::kkopdgbrb($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,$kdsub,$kdupb);
				
				$kibditem = Module::kkopdjij($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,$kdsub,$kdupb);
				$kibditemextra = Module::kkopdjijextra($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,$kdsub,$kdupb);
				$kibditemrb = Module::kkopdjijrb($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,$kdsub,$kdupb);
				
				$kibeitem = Module::kkopdatl($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,$kdsub,$kdupb);
				$kibeitemrb = Module::kkopdatlrb($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,$kdsub,$kdupb);
				
				$kibkdp = Module::kkopdkdp($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,$kdsub,$kdupb);
				$kiblainnya= Module::kkopdlainnya($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,$kdsub,$kdupb);
				
				$kiblainnyareg= Module::kkopdlainnyareg($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,$kdsub,$kdupb);
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-Tanah');
				foreach($kibaitem as $index=>$kibaitems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibaitems->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibaitems->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibaitems->no_reg);
					$sheet->setCellValue('E'.$cell, $kibaitems->luas);				
					$sheet->setCellValue('F'.$cell, $kibaitems->tahun_perolehan);				
					$sheet->setCellValue('G'.$cell, $kibaitems->alamat);				
					$sheet->setCellValue('H'.$cell, $kibaitems->Hak_Tanah);				
					$sheet->setCellValue('I'.$cell, $kibaitems->sertifikat_tanggal);				
					$sheet->setCellValue('J'.$cell, $kibaitems->sertifikat_nomor);				
					$sheet->setCellValue('K'.$cell, $kibaitems->penggunaan);				
					$sheet->setCellValue('L'.$cell, $kibaitems->Asal_usul);				
					$sheet->setCellValue('M'.$cell, $kibaitems->hargaperolehan);				
					$sheet->setCellValue('O'.$cell, $kibaitems->NK_tambah);				
					$sheet->setCellValue('P'.$cell, $kibaitems->bertambah);				
					$sheet->setCellValue('Q'.$cell, $kibaitems->NK_kurang);				
					$sheet->setCellValue('R'.$cell, $kibaitems->berkurang);				
					$sheet->setCellValue('T'.$cell, $kibaitems->keterangan);				
					$sheet->setCellValue('U'.$cell, $kibaitems->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				//peralatan & mesin
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-PeralatanMesin');
				foreach($kibbitem as $index=>$kibbitems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibbitems->kd_barang);
					$sheet->setCellValue('C'.$cell, $kibbitems->Nm_Aset5);
					$sheet->setCellValue('D'.$cell, $kibbitems->jml_item);
					$sheet->setCellValue('E'.$cell, $kibbitems->merk);				
					$sheet->setCellValue('H'.$cell, $kibbitems->tahun_perolehan);				
					$sheet->setCellValue('M'.$cell, $kibbitems->nomor_bpkb);				
					$sheet->setCellValue('L'.$cell, $kibbitems->nomor_polisi);										
					$sheet->setCellValue('N'.$cell, $kibbitems->Asal_usul);				
					$sheet->setCellValue('O'.$cell, $kibbitems->hargaperolehan);				
					$sheet->setCellValue('Q'.$cell, $kibbitems->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibbitems->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibbitems->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibbitems->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibbitems->keterangan);				
					$sheet->setCellValue('W'.$cell, $kibbitems->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}			
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Ekstra-PeralatanMesin');
				foreach($kibbitemextra as $index=>$kibbitemextras){
					$index = $index+1;					
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibbitemextras->kd_barang);
					$sheet->setCellValue('C'.$cell, $kibbitemextras->Nm_Aset5);
					$sheet->setCellValue('D'.$cell, $kibbitemextras->jml_item);
					$sheet->setCellValue('E'.$cell, $kibbitemextras->merk);				
					$sheet->setCellValue('H'.$cell, $kibbitemextras->tahun_perolehan);				
					$sheet->setCellValue('L'.$cell, $kibbitemextras->nomor_bpkb);				
					$sheet->setCellValue('M'.$cell, $kibbitemextras->nomor_polisi);										
					$sheet->setCellValue('N'.$cell, $kibbitemextras->Asal_usul);				
					$sheet->setCellValue('O'.$cell, $kibbitemextras->hargaperolehan);				
					$sheet->setCellValue('Q'.$cell, $kibbitemextras->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibbitemextras->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibbitemextras->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibbitemextras->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibbitemextras->keterangan);							
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-PeralatanMesinRB');
				foreach($kibbitemrb as $index=>$kibbitemrbs){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibbitemrbs->kd_barang);
					$sheet->setCellValue('C'.$cell, $kibbitemrbs->Nm_Aset5);
					$sheet->setCellValue('D'.$cell, $kibbitemrbs->jml_item);
					$sheet->setCellValue('E'.$cell, $kibbitemrbs->merk);				
					$sheet->setCellValue('H'.$cell, $kibbitemrbs->tahun_perolehan);				
					$sheet->setCellValue('L'.$cell, $kibbitemrbs->nomor_bpkb);				
					$sheet->setCellValue('M'.$cell, $kibbitemrbs->nomor_polisi);										
					$sheet->setCellValue('N'.$cell, $kibbitemrbs->Asal_usul);				
					$sheet->setCellValue('O'.$cell, $kibbitemrbs->hargaperolehan);				
					$sheet->setCellValue('Q'.$cell, $kibbitemrbs->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibbitemrbs->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibbitemrbs->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibbitemrbs->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibbitemrbs->keterangan);						
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				//end
				
				//gedung dan bangunan
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-GedungBangunan');
				foreach($kibcitem as $index=>$kibcitems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibcitems->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibcitems->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibcitems->no_reg);
					$sheet->setCellValue('E'.$cell, $kibcitems->uraian);				
					$sheet->setCellValue('F'.$cell, $kibcitems->bertingkat_tidak);				
					$sheet->setCellValue('G'.$cell, $kibcitems->beton_tidak);				
					$sheet->setCellValue('H'.$cell, $kibcitems->luas_lantai);				
					$sheet->setCellValue('I'.$cell, $kibcitems->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibcitems->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibcitems->dokumen_nomor);				
					$sheet->setCellValue('M'.$cell, $kibcitems->status_tanah);							
					$sheet->setCellValue('R'.$cell, $kibcitems->NK_tambah);				
					$sheet->setCellValue('S'.$cell, $kibcitems->bertambah);				
					$sheet->setCellValue('T'.$cell, $kibcitems->NK_kurang);				
					$sheet->setCellValue('U'.$cell, $kibcitems->berkurang);				
					$sheet->setCellValue('W'.$cell, $kibcitems->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibcitems->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Ekstra-GedungBangunan');
				foreach($kibcitemextra as $index=>$kibcitemextras){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibcitemextras->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibcitemextras->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibcitemextras->no_reg);
					$sheet->setCellValue('E'.$cell, $kibcitemextras->uraian);				
					$sheet->setCellValue('F'.$cell, $kibcitemextras->bertingkat_tidak);				
					$sheet->setCellValue('G'.$cell, $kibcitemextras->beton_tidak);				
					$sheet->setCellValue('H'.$cell, $kibcitemextras->luas_lantai);				
					$sheet->setCellValue('I'.$cell, $kibcitemextras->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibcitemextras->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibcitemextras->dokumen_nomor);				
					$sheet->setCellValue('M'.$cell, $kibcitemextras->status_tanah);							
					$sheet->setCellValue('R'.$cell, $kibcitemextras->NK_tambah);				
					$sheet->setCellValue('S'.$cell, $kibcitemextras->bertambah);				
					$sheet->setCellValue('T'.$cell, $kibcitemextras->NK_kurang);				
					$sheet->setCellValue('U'.$cell, $kibcitemextras->berkurang);				
					$sheet->setCellValue('W'.$cell, $kibcitemextras->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibcitemextras->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-GedungBangunanRB');
				foreach($kibcitemrb as $index=>$kibcitemrbs){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibcitemrbs->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibcitemrbs->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibcitemrbs->no_reg);
					$sheet->setCellValue('E'.$cell, $kibcitemrbs->uraian);				
					$sheet->setCellValue('F'.$cell, $kibcitemrbs->bertingkat_tidak);				
					$sheet->setCellValue('G'.$cell, $kibcitemrbs->beton_tidak);				
					$sheet->setCellValue('H'.$cell, $kibcitemrbs->luas_lantai);				
					$sheet->setCellValue('I'.$cell, $kibcitemrbs->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibcitemrbs->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibcitemrbs->dokumen_nomor);				
					$sheet->setCellValue('M'.$cell, $kibcitemrbs->status_tanah);							
					$sheet->setCellValue('R'.$cell, $kibcitemrbs->NK_tambah);				
					$sheet->setCellValue('S'.$cell, $kibcitemrbs->bertambah);				
					$sheet->setCellValue('T'.$cell, $kibcitemrbs->NK_kurang);				
					$sheet->setCellValue('U'.$cell, $kibcitemrbs->berkurang);				
					$sheet->setCellValue('W'.$cell, $kibcitemrbs->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibcitemrbs->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}				
				//end
				
				//jalan jaringan irigasi
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-JIJ');
				foreach($kibditem as $index=>$kibditems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibditems->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibditems->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibditems->no_reg);
					$sheet->setCellValue('E'.$cell, $kibditems->konstruksi);				
					$sheet->setCellValue('F'.$cell, $kibditems->panjang);				
					$sheet->setCellValue('G'.$cell, $kibditems->lebar);				
					$sheet->setCellValue('H'.$cell, $kibditems->luas);				
					$sheet->setCellValue('I'.$cell, $kibditems->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibditems->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibditems->dokumen_nomor);				
					$sheet->setCellValue('L'.$cell, $kibditems->status_tanah);							
					$sheet->setCellValue('O'.$cell, $kibditems->hargaperolehan);							
					$sheet->setCellValue('Q'.$cell, $kibditems->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibditems->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibditems->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibditems->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibditems->uraian);				
					$sheet->setCellValue('W'.$cell, $kibditems->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibditems->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Ekstra-JIJ');
				foreach($kibditemextra as $index=>$kibditemextras){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibditemextras->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibditemextras->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibditemextras->no_reg);
					$sheet->setCellValue('E'.$cell, $kibditemextras->konstruksi);				
					$sheet->setCellValue('F'.$cell, $kibditemextras->panjang);				
					$sheet->setCellValue('G'.$cell, $kibditemextras->lebar);				
					$sheet->setCellValue('H'.$cell, $kibditemextras->luas);				
					$sheet->setCellValue('I'.$cell, $kibditemextras->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibditemextras->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibditemextras->dokumen_nomor);				
					$sheet->setCellValue('L'.$cell, $kibditemextras->status_tanah);							
					$sheet->setCellValue('Q'.$cell, $kibditemextras->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibditemextras->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibditemextras->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibditemextras->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibditemextras->uraian);				
					$sheet->setCellValue('W'.$cell, $kibditemextras->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibditemextras->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-JIJRB');
				foreach($kibditemrb as $index=>$kibditemrbs){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibditemrbs->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibditemrbs->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibditemrbs->no_reg);
					$sheet->setCellValue('E'.$cell, $kibditemrbs->konstruksi);				
					$sheet->setCellValue('F'.$cell, $kibditemrbs->panjang);				
					$sheet->setCellValue('G'.$cell, $kibditemrbs->lebar);				
					$sheet->setCellValue('H'.$cell, $kibditemrbs->luas);				
					$sheet->setCellValue('I'.$cell, $kibditemrbs->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibditemrbs->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibditemrbs->dokumen_nomor);				
					$sheet->setCellValue('L'.$cell, $kibditemrbs->status_tanah);							
					$sheet->setCellValue('Q'.$cell, $kibditemrbs->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibditemrbs->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibditemrbs->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibditemrbs->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibditemrbs->uraian);				
					$sheet->setCellValue('W'.$cell, $kibditemrbs->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibditemrbs->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}				
				//end
				
				//aset tetap lainnya
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-ATL');
				foreach($kibeitem as $index=>$kibeitems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibeitems->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibeitems->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibeitems->jml_item);
					$sheet->setCellValue('G'.$cell, $kibeitems->asaldaerah);				
					$sheet->setCellValue('H'.$cell, $kibeitems->pencipta);				
					$sheet->setCellValue('I'.$cell, $kibeitems->bahan);				
					$sheet->setCellValue('J'.$cell, $kibeitems->jenis);				
					$sheet->setCellValue('K'.$cell, $kibeitems->ukuran);
					$sheet->setCellValue('L'.$cell, $kibeitems->jml_item);
					$sheet->setCellValue('M'.$cell, $kibeitems->uraian);						
					$sheet->setCellValue('N'.$cell, $kibeitems->tahun_perolehan);				
					$sheet->setCellValue('O'.$cell, $kibeitems->hargaperolehan);											
					$sheet->setCellValue('Q'.$cell, $kibeitems->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibeitems->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibeitems->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibeitems->berkurang);												
					$sheet->setCellValue('V'.$cell, $kibeitems->keterangan);				
					$sheet->setCellValue('W'.$cell, $kibeitems->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-ATLRB');
				foreach($kibeitem as $index=>$kibeitemrbs){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibeitemrbs->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibeitemrbs->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibeitemrbs->jml_item);
					$sheet->setCellValue('G'.$cell, $kibeitemrbs->asaldaerah);				
					$sheet->setCellValue('H'.$cell, $kibeitemrbs->pencipta);				
					$sheet->setCellValue('I'.$cell, $kibeitemrbs->bahan);				
					$sheet->setCellValue('J'.$cell, $kibeitemrbs->jenis);				
					$sheet->setCellValue('K'.$cell, $kibeitemrbs->ukuran);
					$sheet->setCellValue('L'.$cell, $kibeitemrbs->jml_item);
					$sheet->setCellValue('M'.$cell, $kibeitemrbs->uraian);						
					$sheet->setCellValue('N'.$cell, $kibeitemrbs->tahun_perolehan);				
					$sheet->setCellValue('O'.$cell, $kibeitemrbs->hargaperolehan);											
					$sheet->setCellValue('Q'.$cell, $kibeitemrbs->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibeitemrbs->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibeitemrbs->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibeitemrbs->berkurang);												
					$sheet->setCellValue('V'.$cell, $kibeitemrbs->keterangan);				
					$sheet->setCellValue('W'.$cell, $kibeitemrbs->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-KDP');
				foreach($kibkdp as $index=>$kibkdps){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibkdps->Nm_Aset5);
					$sheet->setCellValue('D'.$cell, $kibkdps->bertingkat);
					$sheet->setCellValue('E'.$cell, $kibkdps->beton);
					$sheet->setCellValue('F'.$cell, $kibkdps->luas);				
					$sheet->setCellValue('G'.$cell, $kibkdps->lokasi);				
					$sheet->setCellValue('H'.$cell, $kibkdps->dokumentanggal);				
					$sheet->setCellValue('I'.$cell, $kibkdps->dokumennomor);				
					$sheet->setCellValue('J'.$cell, $kibkdps->tgl_perolehan);							
					$sheet->setCellValue('K'.$cell, $kibkdps->status_tanah);							
					$sheet->setCellValue('N'.$cell, $kibkdps->harga);											
					$sheet->setCellValue('P'.$cell, $kibkdps->NK_tambah);				
					$sheet->setCellValue('Q'.$cell, $kibkdps->bertambah);				
					$sheet->setCellValue('R'.$cell, $kibkdps->NK_kurang);				
					$sheet->setCellValue('S'.$cell, $kibkdps->berkurang);												
					$sheet->setCellValue('U'.$cell, $kibkdps->keterangan);				
					$sheet->setCellValue('X'.$cell, $kibkdps->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-Lainnya');
				foreach($kiblainnya as $index=>$kiblainnyas){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kiblainnyas->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kiblainnyas->kd_barang);
					$sheet->setCellValue('D'.$cell, $kiblainnyas->jml_item);
					$sheet->setCellValue('E'.$cell, $kiblainnyas->tahun_perolehan);			
					$sheet->setCellValue('I'.$cell, $kiblainnyas->uraian);			
					$sheet->setCellValue('J'.$cell, $kiblainnyas->Asal_usul);																		
					$sheet->setCellValue('M'.$cell, $kiblainnyas->NK_tambah);				
					$sheet->setCellValue('N'.$cell, $kiblainnyas->bertambah);				
					$sheet->setCellValue('O'.$cell, $kiblainnyas->NK_kurang);				
					$sheet->setCellValue('P'.$cell, $kiblainnyas->berkurang);												
					$sheet->setCellValue('R'.$cell, $kiblainnyas->keterangan);				
					//$sheet->setCellValue('S'.$cell, $kiblainnyas->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 19;
				$sheet = $spreadsheet->getSheetByName('Rubah Kondisi Barang');
				foreach($kiblainnyareg as $index=>$kiblainnyaregs){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);										
					$sheet->setCellValue('C'.$cell, $kiblainnyaregs->kd_barang);
					$sheet->setCellValue('D'.$cell, $kiblainnyaregs->no_reg);
					$sheet->setCellValue('E'.$cell, $kiblainnyaregs->tahun_perolehan);
					$sheet->setCellValue('F'.$cell, $kiblainnyaregs->Nm_Aset5);
					$sheet->setCellValue('G'.$cell, $kiblainnyaregs->harga);
					$sheet->setCellValue('H'.$cell, 'Baik');																																	
					$sheet->setCellValue('I'.$cell, $kiblainnyaregs->uraian);																																	
					$sheet->setCellValue('R'.$cell, $kiblainnyaregs->keterangan);							
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$writer = new Xlsx($spreadsheet);
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="MASTER_LAPORAN_MUTASI_BMD_2022_v03.xlsx"');
				$writer->setPreCalculateFormulas(false);
				$writer->save('php://output');
				
				
			}
			
			
			
			
		}else{
			return view(abort(403, 'Unauthorized action.'));
		}			 
	}
		
	public function kkunit($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits){
		$kdbidang = Module::kdopd()->kd_bidang;	

		/* $data = Module::kibaall($kdbidangs,$kdunits,$kdsubs);
		dd($data); */

		if(Module::hasAccess("Rekonsiliasi_asets", "view")) {
			
				$inputFileType = 'Xlsx'; // Xlsx - Xml - Ods - Slk - Gnumeric - Csv
				$inputFileName = public_path('storage\format\DRAFT-MASTER_LAPORAN_MUTASI_BMD_2022_v02.xlsx');
				$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);		
				$spreadsheet = new Spreadsheet();
				$spreadsheet = $reader->load($inputFileName);
				
			if($kdbidang == 99 || $kdbidang == 0 ){	
																																
				$kibaitem = Module::kkopdtanah($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,"'%'","'%'");
				
				$kibbitem = Module::kkopdpm($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,"'%'","'%'");
				$kibbitemextra = Module::kkopdpmextra($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,"'%'","'%'");
				$kibbitemrb = Module::kkopdpmrb($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,"'%'","'%'");
				
				$kibcitem = Module::kkopdgb($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,"'%'","'%'");
				$kibcitemextra = Module::kkopdgbextra($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,"'%'","'%'");
				$kibcitemrb = Module::kkopdgbrb($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,"'%'","'%'");
				
				$kibditem = Module::kkopdjij($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,"'%'","'%'");
				$kibditemextra = Module::kkopdjijextra($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,"'%'","'%'");
				$kibditemrb = Module::kkopdjijrb($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,"'%'","'%'");
				
				$kibeitem = Module::kkopdatl($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,"'%'","'%'");
				$kibeitemrb = Module::kkopdatlrb($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,"'%'","'%'");
				
				$kibkdp = Module::kkopdkdp($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,"'%'","'%'");
				$kiblainnya= Module::kkopdlainnya($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,"'%'","'%'");
				
				$kiblainnyareg= Module::kkopdlainnyareg($tahun,$tglawal,$tglakhir,$kdbidangs,$kdunits,"'%'","'%'");
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-Tanah');
				foreach($kibaitem as $index=>$kibaitems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibaitems->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibaitems->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibaitems->no_reg);
					$sheet->setCellValue('E'.$cell, $kibaitems->luas);				
					$sheet->setCellValue('F'.$cell, $kibaitems->tahun_perolehan);				
					$sheet->setCellValue('G'.$cell, $kibaitems->alamat);				
					$sheet->setCellValue('H'.$cell, $kibaitems->Hak_Tanah);				
					$sheet->setCellValue('I'.$cell, $kibaitems->sertifikat_tanggal);				
					$sheet->setCellValue('J'.$cell, $kibaitems->sertifikat_nomor);				
					$sheet->setCellValue('K'.$cell, $kibaitems->penggunaan);				
					$sheet->setCellValue('L'.$cell, $kibaitems->Asal_usul);				
					$sheet->setCellValue('M'.$cell, $kibaitems->hargaperolehan);				
					$sheet->setCellValue('O'.$cell, $kibaitems->NK_tambah);				
					$sheet->setCellValue('P'.$cell, $kibaitems->bertambah);				
					$sheet->setCellValue('Q'.$cell, $kibaitems->NK_kurang);				
					$sheet->setCellValue('R'.$cell, $kibaitems->berkurang);				
					$sheet->setCellValue('T'.$cell, $kibaitems->keterangan);				
					$sheet->setCellValue('U'.$cell, $kibaitems->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				//peralatan & mesin
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-PeralatanMesin');
				foreach($kibbitem as $index=>$kibbitems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibbitems->kd_barang);
					$sheet->setCellValue('C'.$cell, $kibbitems->Nm_Aset5);
					$sheet->setCellValue('D'.$cell, $kibbitems->jml_item);
					$sheet->setCellValue('E'.$cell, $kibbitems->merk);				
					$sheet->setCellValue('H'.$cell, $kibbitems->tahun_perolehan);				
					$sheet->setCellValue('M'.$cell, $kibbitems->nomor_bpkb);				
					$sheet->setCellValue('L'.$cell, $kibbitems->nomor_polisi);										
					$sheet->setCellValue('N'.$cell, $kibbitems->Asal_usul);				
					$sheet->setCellValue('O'.$cell, $kibbitems->hargaperolehan);				
					$sheet->setCellValue('Q'.$cell, $kibbitems->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibbitems->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibbitems->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibbitems->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibbitems->keterangan);				
					$sheet->setCellValue('W'.$cell, $kibbitems->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}			
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Ekstra-PeralatanMesin');
				foreach($kibbitemextra as $index=>$kibbitemextras){
					$index = $index+1;					
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibbitemextras->kd_barang);
					$sheet->setCellValue('C'.$cell, $kibbitemextras->Nm_Aset5);
					$sheet->setCellValue('D'.$cell, $kibbitemextras->jml_item);
					$sheet->setCellValue('E'.$cell, $kibbitemextras->merk);				
					$sheet->setCellValue('H'.$cell, $kibbitemextras->tahun_perolehan);				
					$sheet->setCellValue('L'.$cell, $kibbitemextras->nomor_bpkb);				
					$sheet->setCellValue('M'.$cell, $kibbitemextras->nomor_polisi);										
					$sheet->setCellValue('N'.$cell, $kibbitemextras->Asal_usul);				
					$sheet->setCellValue('O'.$cell, $kibbitemextras->hargaperolehan);				
					$sheet->setCellValue('Q'.$cell, $kibbitemextras->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibbitemextras->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibbitemextras->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibbitemextras->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibbitemextras->keterangan);				
					$sheet->setCellValue('U'.$cell, $kibbitemextras->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-PeralatanMesinRB');
				foreach($kibbitemrb as $index=>$kibbitemrbs){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibbitemrbs->kd_barang);
					$sheet->setCellValue('C'.$cell, $kibbitemrbs->Nm_Aset5);
					$sheet->setCellValue('D'.$cell, $kibbitemrbs->jml_item);
					$sheet->setCellValue('E'.$cell, $kibbitemrbs->merk);				
					$sheet->setCellValue('H'.$cell, $kibbitemrbs->tahun_perolehan);				
					$sheet->setCellValue('L'.$cell, $kibbitemrbs->nomor_bpkb);				
					$sheet->setCellValue('M'.$cell, $kibbitemrbs->nomor_polisi);										
					$sheet->setCellValue('N'.$cell, $kibbitemrbs->Asal_usul);				
					$sheet->setCellValue('O'.$cell, $kibbitemrbs->hargaperolehan);				
					$sheet->setCellValue('Q'.$cell, $kibbitemrbs->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibbitemrbs->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibbitemrbs->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibbitemrbs->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibbitemrbs->keterangan);			
					$sheet->setCellValue('U'.$cell, $kibbitemrbs->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				//end
				
				//gedung dan bangunan
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-GedungBangunan');
				foreach($kibcitem as $index=>$kibcitems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibcitems->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibcitems->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibcitems->no_reg);
					$sheet->setCellValue('E'.$cell, $kibcitems->uraian);				
					$sheet->setCellValue('F'.$cell, $kibcitems->bertingkat_tidak);				
					$sheet->setCellValue('G'.$cell, $kibcitems->beton_tidak);				
					$sheet->setCellValue('H'.$cell, $kibcitems->luas_lantai);				
					$sheet->setCellValue('I'.$cell, $kibcitems->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibcitems->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibcitems->dokumen_nomor);				
					$sheet->setCellValue('M'.$cell, $kibcitems->status_tanah);							
					$sheet->setCellValue('O'.$cell, $kibcitems->Asal_usul);							
					$sheet->setCellValue('P'.$cell, $kibcitems->hargaperolehan);							
					$sheet->setCellValue('R'.$cell, $kibcitems->NK_tambah);				
					$sheet->setCellValue('S'.$cell, $kibcitems->bertambah);				
					$sheet->setCellValue('T'.$cell, $kibcitems->NK_kurang);				
					$sheet->setCellValue('U'.$cell, $kibcitems->berkurang);				
					$sheet->setCellValue('W'.$cell, $kibcitems->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibcitems->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Ekstra-GedungBangunan');
				foreach($kibcitemextra as $index=>$kibcitemextras){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibcitemextras->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibcitemextras->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibcitemextras->no_reg);
					$sheet->setCellValue('E'.$cell, $kibcitemextras->uraian);				
					$sheet->setCellValue('F'.$cell, $kibcitemextras->bertingkat_tidak);				
					$sheet->setCellValue('G'.$cell, $kibcitemextras->beton_tidak);				
					$sheet->setCellValue('H'.$cell, $kibcitemextras->luas_lantai);				
					$sheet->setCellValue('I'.$cell, $kibcitemextras->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibcitemextras->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibcitemextras->dokumen_nomor);				
					$sheet->setCellValue('M'.$cell, $kibcitemextras->status_tanah);
					$sheet->setCellValue('O'.$cell, $kibcitemextras->Asal_usul);							
					$sheet->setCellValue('P'.$cell, $kibcitemextras->hargaperolehan);
					$sheet->setCellValue('R'.$cell, $kibcitemextras->NK_tambah);				
					$sheet->setCellValue('S'.$cell, $kibcitemextras->bertambah);				
					$sheet->setCellValue('T'.$cell, $kibcitemextras->NK_kurang);				
					$sheet->setCellValue('U'.$cell, $kibcitemextras->berkurang);				
					$sheet->setCellValue('W'.$cell, $kibcitemextras->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibcitemextras->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-GedungBangunanRB');
				foreach($kibcitemrb as $index=>$kibcitemrbs){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibcitemrbs->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibcitemrbs->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibcitemrbs->no_reg);
					$sheet->setCellValue('E'.$cell, $kibcitemrbs->uraian);				
					$sheet->setCellValue('F'.$cell, $kibcitemrbs->bertingkat_tidak);				
					$sheet->setCellValue('G'.$cell, $kibcitemrbs->beton_tidak);				
					$sheet->setCellValue('H'.$cell, $kibcitemrbs->luas_lantai);				
					$sheet->setCellValue('I'.$cell, $kibcitemrbs->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibcitemrbs->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibcitemrbs->dokumen_nomor);				
					$sheet->setCellValue('M'.$cell, $kibcitemrbs->status_tanah);
					$sheet->setCellValue('O'.$cell, $kibcitemrbs->Asal_usul);							
					$sheet->setCellValue('P'.$cell, $kibcitemrbs->hargaperolehan);
					$sheet->setCellValue('R'.$cell, $kibcitemrbs->NK_tambah);				
					$sheet->setCellValue('S'.$cell, $kibcitemrbs->bertambah);				
					$sheet->setCellValue('T'.$cell, $kibcitemrbs->NK_kurang);				
					$sheet->setCellValue('U'.$cell, $kibcitemrbs->berkurang);				
					$sheet->setCellValue('W'.$cell, $kibcitemrbs->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibcitemrbs->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}				
				//end
				
				//jalan jaringan irigasi
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-JIJ');
				foreach($kibditem as $index=>$kibditems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibditems->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibditems->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibditems->no_reg);
					$sheet->setCellValue('E'.$cell, $kibditems->konstruksi);				
					$sheet->setCellValue('F'.$cell, $kibditems->panjang);				
					$sheet->setCellValue('G'.$cell, $kibditems->lebar);				
					$sheet->setCellValue('H'.$cell, $kibditems->luas);				
					$sheet->setCellValue('I'.$cell, $kibditems->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibditems->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibditems->dokumen_nomor);				
					$sheet->setCellValue('L'.$cell, $kibditems->status_tanah);							
					$sheet->setCellValue('O'.$cell, $kibditems->hargaperolehan);							
					$sheet->setCellValue('Q'.$cell, $kibditems->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibditems->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibditems->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibditems->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibditems->uraian);				
					$sheet->setCellValue('W'.$cell, $kibditems->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibditems->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Ekstra-JIJ');
				foreach($kibditemextra as $index=>$kibditemextras){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibditemextras->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibditemextras->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibditemextras->no_reg);
					$sheet->setCellValue('E'.$cell, $kibditemextras->konstruksi);				
					$sheet->setCellValue('F'.$cell, $kibditemextras->panjang);				
					$sheet->setCellValue('G'.$cell, $kibditemextras->lebar);				
					$sheet->setCellValue('H'.$cell, $kibditemextras->luas);				
					$sheet->setCellValue('I'.$cell, $kibditemextras->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibditemextras->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibditemextras->dokumen_nomor);				
					$sheet->setCellValue('L'.$cell, $kibditemextras->status_tanah);							
					$sheet->setCellValue('Q'.$cell, $kibditemextras->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibditemextras->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibditemextras->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibditemextras->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibditemextras->uraian);				
					$sheet->setCellValue('W'.$cell, $kibditemextras->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibditemextras->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-JIJRB');
				foreach($kibditemrb as $index=>$kibditemrbs){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibditemrbs->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibditemrbs->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibditemrbs->no_reg);
					$sheet->setCellValue('E'.$cell, $kibditemrbs->konstruksi);				
					$sheet->setCellValue('F'.$cell, $kibditemrbs->panjang);				
					$sheet->setCellValue('G'.$cell, $kibditemrbs->lebar);				
					$sheet->setCellValue('H'.$cell, $kibditemrbs->luas);				
					$sheet->setCellValue('I'.$cell, $kibditemrbs->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibditemrbs->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibditemrbs->dokumen_nomor);				
					$sheet->setCellValue('L'.$cell, $kibditemrbs->status_tanah);							
					$sheet->setCellValue('Q'.$cell, $kibditemrbs->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibditemrbs->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibditemrbs->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibditemrbs->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibditemrbs->uraian);				
					$sheet->setCellValue('W'.$cell, $kibditemrbs->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibditemrbs->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}				
				//end
				
				//aset tetap lainnya
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-ATL');
				foreach($kibeitem as $index=>$kibeitems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibeitems->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibeitems->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibeitems->jml_item);
					$sheet->setCellValue('G'.$cell, $kibeitems->asaldaerah);				
					$sheet->setCellValue('H'.$cell, $kibeitems->pencipta);				
					$sheet->setCellValue('I'.$cell, $kibeitems->bahan);				
					$sheet->setCellValue('J'.$cell, $kibeitems->jenis);				
					$sheet->setCellValue('K'.$cell, $kibeitems->ukuran);
					$sheet->setCellValue('L'.$cell, $kibeitems->jml_item);
					$sheet->setCellValue('M'.$cell, $kibeitems->uraian);						
					$sheet->setCellValue('N'.$cell, $kibeitems->tahun_perolehan);				
					$sheet->setCellValue('O'.$cell, $kibeitems->hargaperolehan);											
					$sheet->setCellValue('Q'.$cell, $kibeitems->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibeitems->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibeitems->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibeitems->berkurang);												
					$sheet->setCellValue('V'.$cell, $kibeitems->keterangan);				
					$sheet->setCellValue('W'.$cell, $kibeitems->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-ATLRB');
				foreach($kibeitemrb as $index=>$kibeitemrbs){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibeitemrbs->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibeitemrbs->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibeitemrbs->jml_item);
					$sheet->setCellValue('G'.$cell, $kibeitemrbs->asaldaerah);				
					$sheet->setCellValue('H'.$cell, $kibeitemrbs->pencipta);				
					$sheet->setCellValue('I'.$cell, $kibeitemrbs->bahan);				
					$sheet->setCellValue('J'.$cell, $kibeitemrbs->jenis);				
					$sheet->setCellValue('K'.$cell, $kibeitemrbs->ukuran);
					$sheet->setCellValue('L'.$cell, $kibeitemrbs->jml_item);
					$sheet->setCellValue('M'.$cell, $kibeitemrbs->uraian);						
					$sheet->setCellValue('N'.$cell, $kibeitemrbs->tahun_perolehan);				
					$sheet->setCellValue('O'.$cell, $kibeitemrbs->hargaperolehan);											
					$sheet->setCellValue('Q'.$cell, $kibeitemrbs->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibeitemrbs->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibeitemrbs->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibeitemrbs->berkurang);												
					$sheet->setCellValue('V'.$cell, $kibeitemrbs->keterangan);				
					$sheet->setCellValue('W'.$cell, $kibeitemrbs->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-KDP');
				foreach($kibkdp as $index=>$kibkdps){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibkdps->Nm_Aset5);
					$sheet->setCellValue('D'.$cell, $kibkdps->bertingkat);
					$sheet->setCellValue('E'.$cell, $kibkdps->beton);
					$sheet->setCellValue('F'.$cell, $kibkdps->luas);				
					$sheet->setCellValue('G'.$cell, $kibkdps->lokasi);				
					$sheet->setCellValue('H'.$cell, $kibkdps->dokumentanggal);				
					$sheet->setCellValue('I'.$cell, $kibkdps->dokumennomor);				
					$sheet->setCellValue('J'.$cell, $kibkdps->tgl_perolehan);							
					$sheet->setCellValue('K'.$cell, $kibkdps->status_tanah);							
					$sheet->setCellValue('N'.$cell, $kibkdps->harga);											
					$sheet->setCellValue('P'.$cell, $kibkdps->NK_tambah);				
					$sheet->setCellValue('Q'.$cell, $kibkdps->bertambah);				
					$sheet->setCellValue('R'.$cell, $kibkdps->NK_kurang);				
					$sheet->setCellValue('S'.$cell, $kibkdps->berkurang);												
					$sheet->setCellValue('U'.$cell, $kibkdps->keterangan);				
					$sheet->setCellValue('X'.$cell, $kibkdps->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-Lainnya');
				foreach($kiblainnya as $index=>$kiblainnyas){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kiblainnyas->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kiblainnyas->kd_barang);
					$sheet->setCellValue('D'.$cell, $kiblainnyas->jml_item);
					$sheet->setCellValue('E'.$cell, $kiblainnyas->tahun_perolehan);			
					$sheet->setCellValue('I'.$cell, $kiblainnyas->uraian);			
					$sheet->setCellValue('J'.$cell, $kiblainnyas->Asal_usul);																		
					$sheet->setCellValue('M'.$cell, $kiblainnyas->NK_tambah);				
					$sheet->setCellValue('N'.$cell, $kiblainnyas->bertambah);				
					$sheet->setCellValue('O'.$cell, $kiblainnyas->NK_kurang);				
					$sheet->setCellValue('P'.$cell, $kiblainnyas->berkurang);												
					$sheet->setCellValue('R'.$cell, $kiblainnyas->keterangan);				
					//$sheet->setCellValue('S'.$cell, $kiblainnyas->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 19;
				$sheet = $spreadsheet->getSheetByName('Rubah Kondisi Barang');
				foreach($kiblainnyareg as $index=>$kiblainnyaregs){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);										
					$sheet->setCellValue('C'.$cell, $kiblainnyaregs->kd_barang);
					$sheet->setCellValue('D'.$cell, $kiblainnyaregs->no_reg);
					$sheet->setCellValue('E'.$cell, $kiblainnyaregs->tahun_perolehan);
					$sheet->setCellValue('F'.$cell, $kiblainnyaregs->Nm_Aset5);
					$sheet->setCellValue('G'.$cell, $kiblainnyaregs->harga);
					$sheet->setCellValue('H'.$cell, 'Baik');																																	
					$sheet->setCellValue('I'.$cell, $kiblainnyaregs->uraian);																																	
					$sheet->setCellValue('R'.$cell, $kiblainnyaregs->keterangan);							
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$writer = new Xlsx($spreadsheet);
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="MASTER_LAPORAN_MUTASI_BMD_2022_v03.xlsx"');
				$writer->setPreCalculateFormulas(false);
				$writer->save('php://output');
																
			}else{
				
				$kdbidang = Module::kdopd()->kd_bidang;
				$kdunit = Module::kdopd()->kd_unit;
				$kdsub = Module::kdopd()->kd_sub;
				$kdupb = Module::kdopd()->kd_upb;
				
				
				$kibaitem = Module::kkopdtanah($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,"'%'","'%'");
				
				$kibbitem = Module::kkopdpm($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,"'%'","'%'");
				$kibbitemextra = Module::kkopdpmextra($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,"'%'","'%'");
				$kibbitemrb = Module::kkopdpmrb($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,"'%'","'%'");
				
				$kibcitem = Module::kkopdgb($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,"'%'","'%'");
				$kibcitemextra = Module::kkopdgbextra($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,"'%'","'%'");
				$kibcitemrb = Module::kkopdgbrb($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,"'%'","'%'");
				
				$kibditem = Module::kkopdjij($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,"'%'","'%'");
				$kibditemextra = Module::kkopdjijextra($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,"'%'","'%'");
				$kibditemrb = Module::kkopdjijrb($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,"'%'","'%'");
				
				$kibeitem = Module::kkopdatl($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,"'%'","'%'");
				$kibeitemrb = Module::kkopdatlrb($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,"'%'","'%'");
				
				$kibkdp = Module::kkopdkdp($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,"'%'","'%'");
				$kiblainnya= Module::kkopdlainnya($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,"'%'","'%'");
				
				$kiblainnyareg= Module::kkopdlainnyareg($tahun,$tglawal,$tglakhir,$kdbidang,$kdunit,"'%'","'%'");
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-Tanah');
				foreach($kibaitem as $index=>$kibaitems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibaitems->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibaitems->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibaitems->no_reg);
					$sheet->setCellValue('E'.$cell, $kibaitems->luas);				
					$sheet->setCellValue('F'.$cell, $kibaitems->tahun_perolehan);				
					$sheet->setCellValue('G'.$cell, $kibaitems->alamat);				
					$sheet->setCellValue('H'.$cell, $kibaitems->Hak_Tanah);				
					$sheet->setCellValue('I'.$cell, $kibaitems->sertifikat_tanggal);				
					$sheet->setCellValue('J'.$cell, $kibaitems->sertifikat_nomor);				
					$sheet->setCellValue('K'.$cell, $kibaitems->penggunaan);				
					$sheet->setCellValue('L'.$cell, $kibaitems->Asal_usul);				
					$sheet->setCellValue('M'.$cell, $kibaitems->hargaperolehan);				
					$sheet->setCellValue('O'.$cell, $kibaitems->NK_tambah);				
					$sheet->setCellValue('P'.$cell, $kibaitems->bertambah);				
					$sheet->setCellValue('Q'.$cell, $kibaitems->NK_kurang);				
					$sheet->setCellValue('R'.$cell, $kibaitems->berkurang);				
					$sheet->setCellValue('T'.$cell, $kibaitems->keterangan);				
					$sheet->setCellValue('U'.$cell, $kibaitems->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				//peralatan & mesin
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-PeralatanMesin');
				foreach($kibbitem as $index=>$kibbitems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibbitems->kd_barang);
					$sheet->setCellValue('C'.$cell, $kibbitems->Nm_Aset5);
					$sheet->setCellValue('D'.$cell, $kibbitems->jml_item);
					$sheet->setCellValue('E'.$cell, $kibbitems->merk);				
					$sheet->setCellValue('H'.$cell, $kibbitems->tahun_perolehan);				
					$sheet->setCellValue('M'.$cell, $kibbitems->nomor_bpkb);				
					$sheet->setCellValue('L'.$cell, $kibbitems->nomor_polisi);										
					$sheet->setCellValue('N'.$cell, $kibbitems->Asal_usul);				
					$sheet->setCellValue('O'.$cell, $kibbitems->hargaperolehan);				
					$sheet->setCellValue('Q'.$cell, $kibbitems->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibbitems->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibbitems->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibbitems->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibbitems->keterangan);				
					$sheet->setCellValue('W'.$cell, $kibbitems->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}			
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Ekstra-PeralatanMesin');
				foreach($kibbitemextra as $index=>$kibbitemextras){
					$index = $index+1;					
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibbitemextras->kd_barang);
					$sheet->setCellValue('C'.$cell, $kibbitemextras->Nm_Aset5);
					$sheet->setCellValue('D'.$cell, $kibbitemextras->jml_item);
					$sheet->setCellValue('E'.$cell, $kibbitemextras->merk);				
					$sheet->setCellValue('H'.$cell, $kibbitemextras->tahun_perolehan);				
					$sheet->setCellValue('L'.$cell, $kibbitemextras->nomor_bpkb);				
					$sheet->setCellValue('M'.$cell, $kibbitemextras->nomor_polisi);										
					$sheet->setCellValue('N'.$cell, $kibbitemextras->Asal_usul);				
					$sheet->setCellValue('O'.$cell, $kibbitemextras->hargaperolehan);				
					$sheet->setCellValue('Q'.$cell, $kibbitemextras->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibbitemextras->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibbitemextras->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibbitemextras->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibbitemextras->keterangan);				
					$sheet->setCellValue('U'.$cell, $kibbitemextras->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-PeralatanMesinRB');
				foreach($kibbitemrb as $index=>$kibbitemrbs){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibbitemrbs->kd_barang);
					$sheet->setCellValue('C'.$cell, $kibbitemrbs->Nm_Aset5);
					$sheet->setCellValue('D'.$cell, $kibbitemrbs->jml_item);
					$sheet->setCellValue('E'.$cell, $kibbitemrbs->merk);				
					$sheet->setCellValue('H'.$cell, $kibbitemrbs->tahun_perolehan);				
					$sheet->setCellValue('L'.$cell, $kibbitemrbs->nomor_bpkb);				
					$sheet->setCellValue('M'.$cell, $kibbitemrbs->nomor_polisi);										
					$sheet->setCellValue('N'.$cell, $kibbitemrbs->Asal_usul);				
					$sheet->setCellValue('O'.$cell, $kibbitemrbs->hargaperolehan);				
					$sheet->setCellValue('Q'.$cell, $kibbitemrbs->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibbitemrbs->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibbitemrbs->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibbitemrbs->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibbitemrbs->keterangan);			
					$sheet->setCellValue('U'.$cell, $kibbitemrbs->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				//end
				
				//gedung dan bangunan
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-GedungBangunan');
				foreach($kibcitem as $index=>$kibcitems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibcitems->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibcitems->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibcitems->no_reg);
					$sheet->setCellValue('E'.$cell, $kibcitems->uraian);				
					$sheet->setCellValue('F'.$cell, $kibcitems->bertingkat_tidak);				
					$sheet->setCellValue('G'.$cell, $kibcitems->beton_tidak);				
					$sheet->setCellValue('H'.$cell, $kibcitems->luas_lantai);				
					$sheet->setCellValue('I'.$cell, $kibcitems->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibcitems->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibcitems->dokumen_nomor);				
					$sheet->setCellValue('M'.$cell, $kibcitems->status_tanah);							
					$sheet->setCellValue('R'.$cell, $kibcitems->NK_tambah);				
					$sheet->setCellValue('S'.$cell, $kibcitems->bertambah);				
					$sheet->setCellValue('T'.$cell, $kibcitems->NK_kurang);				
					$sheet->setCellValue('U'.$cell, $kibcitems->berkurang);				
					$sheet->setCellValue('W'.$cell, $kibcitems->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibcitems->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Ekstra-GedungBangunan');
				foreach($kibcitemextra as $index=>$kibcitemextras){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibcitemextras->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibcitemextras->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibcitemextras->no_reg);
					$sheet->setCellValue('E'.$cell, $kibcitemextras->uraian);				
					$sheet->setCellValue('F'.$cell, $kibcitemextras->bertingkat_tidak);				
					$sheet->setCellValue('G'.$cell, $kibcitemextras->beton_tidak);				
					$sheet->setCellValue('H'.$cell, $kibcitemextras->luas_lantai);				
					$sheet->setCellValue('I'.$cell, $kibcitemextras->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibcitemextras->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibcitemextras->dokumen_nomor);				
					$sheet->setCellValue('M'.$cell, $kibcitemextras->status_tanah);							
					$sheet->setCellValue('R'.$cell, $kibcitemextras->NK_tambah);				
					$sheet->setCellValue('S'.$cell, $kibcitemextras->bertambah);				
					$sheet->setCellValue('T'.$cell, $kibcitemextras->NK_kurang);				
					$sheet->setCellValue('U'.$cell, $kibcitemextras->berkurang);				
					$sheet->setCellValue('W'.$cell, $kibcitemextras->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibcitemextras->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-GedungBangunanRB');
				foreach($kibcitemrb as $index=>$kibcitemrbs){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibcitemrbs->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibcitemrbs->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibcitemrbs->no_reg);
					$sheet->setCellValue('E'.$cell, $kibcitemrbs->uraian);				
					$sheet->setCellValue('F'.$cell, $kibcitemrbs->bertingkat_tidak);				
					$sheet->setCellValue('G'.$cell, $kibcitemrbs->beton_tidak);				
					$sheet->setCellValue('H'.$cell, $kibcitemrbs->luas_lantai);				
					$sheet->setCellValue('I'.$cell, $kibcitemrbs->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibcitemrbs->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibcitemrbs->dokumen_nomor);				
					$sheet->setCellValue('M'.$cell, $kibcitemrbs->status_tanah);							
					$sheet->setCellValue('R'.$cell, $kibcitemrbs->NK_tambah);				
					$sheet->setCellValue('S'.$cell, $kibcitemrbs->bertambah);				
					$sheet->setCellValue('T'.$cell, $kibcitemrbs->NK_kurang);				
					$sheet->setCellValue('U'.$cell, $kibcitemrbs->berkurang);				
					$sheet->setCellValue('W'.$cell, $kibcitemrbs->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibcitemrbs->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}				
				//end
				
				//jalan jaringan irigasi
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-JIJ');
				foreach($kibditem as $index=>$kibditems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibditems->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibditems->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibditems->no_reg);
					$sheet->setCellValue('E'.$cell, $kibditems->konstruksi);				
					$sheet->setCellValue('F'.$cell, $kibditems->panjang);				
					$sheet->setCellValue('G'.$cell, $kibditems->lebar);				
					$sheet->setCellValue('H'.$cell, $kibditems->luas);				
					$sheet->setCellValue('I'.$cell, $kibditems->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibditems->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibditems->dokumen_nomor);				
					$sheet->setCellValue('L'.$cell, $kibditems->status_tanah);							
					$sheet->setCellValue('O'.$cell, $kibditems->hargaperolehan);							
					$sheet->setCellValue('Q'.$cell, $kibditems->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibditems->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibditems->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibditems->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibditems->uraian);				
					$sheet->setCellValue('W'.$cell, $kibditems->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibditems->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Ekstra-JIJ');
				foreach($kibditemextra as $index=>$kibditemextras){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibditemextras->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibditemextras->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibditemextras->no_reg);
					$sheet->setCellValue('E'.$cell, $kibditemextras->konstruksi);				
					$sheet->setCellValue('F'.$cell, $kibditemextras->panjang);				
					$sheet->setCellValue('G'.$cell, $kibditemextras->lebar);				
					$sheet->setCellValue('H'.$cell, $kibditemextras->luas);				
					$sheet->setCellValue('I'.$cell, $kibditemextras->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibditemextras->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibditemextras->dokumen_nomor);				
					$sheet->setCellValue('L'.$cell, $kibditemextras->status_tanah);							
					$sheet->setCellValue('Q'.$cell, $kibditemextras->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibditemextras->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibditemextras->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibditemextras->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibditemextras->uraian);				
					$sheet->setCellValue('W'.$cell, $kibditemextras->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibditemextras->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-JIJRB');
				foreach($kibditemrb as $index=>$kibditemrbs){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibditemrbs->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibditemrbs->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibditemrbs->no_reg);
					$sheet->setCellValue('E'.$cell, $kibditemrbs->konstruksi);				
					$sheet->setCellValue('F'.$cell, $kibditemrbs->panjang);				
					$sheet->setCellValue('G'.$cell, $kibditemrbs->lebar);				
					$sheet->setCellValue('H'.$cell, $kibditemrbs->luas);				
					$sheet->setCellValue('I'.$cell, $kibditemrbs->lokasi);				
					$sheet->setCellValue('J'.$cell, $kibditemrbs->dokumen_tanggal);				
					$sheet->setCellValue('K'.$cell, $kibditemrbs->dokumen_nomor);				
					$sheet->setCellValue('L'.$cell, $kibditemrbs->status_tanah);							
					$sheet->setCellValue('Q'.$cell, $kibditemrbs->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibditemrbs->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibditemrbs->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibditemrbs->berkurang);				
					$sheet->setCellValue('V'.$cell, $kibditemrbs->uraian);				
					$sheet->setCellValue('W'.$cell, $kibditemrbs->keterangan);				
					$sheet->setCellValue('Y'.$cell, $kibditemrbs->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}				
				//end
				
				//aset tetap lainnya
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-ATL');
				foreach($kibeitem as $index=>$kibeitems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibeitems->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibeitems->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibeitems->jml_item);
					$sheet->setCellValue('G'.$cell, $kibeitems->asaldaerah);				
					$sheet->setCellValue('H'.$cell, $kibeitems->pencipta);				
					$sheet->setCellValue('I'.$cell, $kibeitems->bahan);				
					$sheet->setCellValue('J'.$cell, $kibeitems->jenis);				
					$sheet->setCellValue('K'.$cell, $kibeitems->ukuran);
					$sheet->setCellValue('L'.$cell, $kibeitems->jml_item);
					$sheet->setCellValue('M'.$cell, $kibeitems->uraian);						
					$sheet->setCellValue('N'.$cell, $kibeitems->tahun_perolehan);				
					$sheet->setCellValue('O'.$cell, $kibeitems->hargaperolehan);											
					$sheet->setCellValue('Q'.$cell, $kibeitems->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibeitems->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibeitems->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibeitems->berkurang);												
					$sheet->setCellValue('V'.$cell, $kibeitems->keterangan);				
					$sheet->setCellValue('W'.$cell, $kibeitems->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-ATLRB');
				foreach($kibeitem as $index=>$kibeitemrbs){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibeitemrbs->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibeitemrbs->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibeitemrbs->jml_item);
					$sheet->setCellValue('G'.$cell, $kibeitemrbs->asaldaerah);				
					$sheet->setCellValue('H'.$cell, $kibeitemrbs->pencipta);				
					$sheet->setCellValue('I'.$cell, $kibeitemrbs->bahan);				
					$sheet->setCellValue('J'.$cell, $kibeitemrbs->jenis);				
					$sheet->setCellValue('K'.$cell, $kibeitemrbs->ukuran);
					$sheet->setCellValue('L'.$cell, $kibeitemrbs->jml_item);
					$sheet->setCellValue('M'.$cell, $kibeitemrbs->uraian);						
					$sheet->setCellValue('N'.$cell, $kibeitemrbs->tahun_perolehan);				
					$sheet->setCellValue('O'.$cell, $kibeitemrbs->hargaperolehan);											
					$sheet->setCellValue('Q'.$cell, $kibeitemrbs->NK_tambah);				
					$sheet->setCellValue('R'.$cell, $kibeitemrbs->bertambah);				
					$sheet->setCellValue('S'.$cell, $kibeitemrbs->NK_kurang);				
					$sheet->setCellValue('T'.$cell, $kibeitemrbs->berkurang);												
					$sheet->setCellValue('V'.$cell, $kibeitemrbs->keterangan);				
					$sheet->setCellValue('W'.$cell, $kibeitemrbs->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-KDP');
				foreach($kibkdp as $index=>$kibkdps){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kibkdps->Nm_Aset5);
					$sheet->setCellValue('D'.$cell, $kibkdps->bertingkat);
					$sheet->setCellValue('E'.$cell, $kibkdps->beton);
					$sheet->setCellValue('F'.$cell, $kibkdps->luas);				
					$sheet->setCellValue('G'.$cell, $kibkdps->lokasi);				
					$sheet->setCellValue('H'.$cell, $kibkdps->dokumentanggal);				
					$sheet->setCellValue('I'.$cell, $kibkdps->dokumennomor);				
					$sheet->setCellValue('J'.$cell, $kibkdps->tgl_perolehan);							
					$sheet->setCellValue('K'.$cell, $kibkdps->status_tanah);							
					$sheet->setCellValue('N'.$cell, $kibkdps->harga);											
					$sheet->setCellValue('P'.$cell, $kibkdps->NK_tambah);				
					$sheet->setCellValue('Q'.$cell, $kibkdps->bertambah);				
					$sheet->setCellValue('R'.$cell, $kibkdps->NK_kurang);				
					$sheet->setCellValue('S'.$cell, $kibkdps->berkurang);												
					$sheet->setCellValue('U'.$cell, $kibkdps->keterangan);				
					$sheet->setCellValue('X'.$cell, $kibkdps->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 11;
				$sheet = $spreadsheet->getSheetByName('Intra-Lainnya');
				foreach($kiblainnya as $index=>$kiblainnyas){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);					
					$sheet->setCellValue('B'.$cell, $kiblainnyas->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kiblainnyas->kd_barang);
					$sheet->setCellValue('D'.$cell, $kiblainnyas->jml_item);
					$sheet->setCellValue('E'.$cell, $kiblainnyas->tahun_perolehan);			
					$sheet->setCellValue('I'.$cell, $kiblainnyas->uraian);			
					$sheet->setCellValue('J'.$cell, $kiblainnyas->Asal_usul);																		
					$sheet->setCellValue('M'.$cell, $kiblainnyas->NK_tambah);				
					$sheet->setCellValue('N'.$cell, $kiblainnyas->bertambah);				
					$sheet->setCellValue('O'.$cell, $kiblainnyas->NK_kurang);				
					$sheet->setCellValue('P'.$cell, $kiblainnyas->berkurang);												
					$sheet->setCellValue('R'.$cell, $kiblainnyas->keterangan);				
					//$sheet->setCellValue('S'.$cell, $kiblainnyas->OPD_asal_tujuan);				
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$cell = 19;
				$sheet = $spreadsheet->getSheetByName('Rubah Kondisi Barang');
				foreach($kiblainnyareg as $index=>$kiblainnyaregs){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);										
					$sheet->setCellValue('C'.$cell, $kiblainnyaregs->kd_barang);
					$sheet->setCellValue('D'.$cell, $kiblainnyaregs->no_reg);
					$sheet->setCellValue('E'.$cell, $kiblainnyaregs->tahun_perolehan);
					$sheet->setCellValue('F'.$cell, $kiblainnyaregs->Nm_Aset5);
					$sheet->setCellValue('G'.$cell, $kiblainnyaregs->harga);
					$sheet->setCellValue('H'.$cell, 'Baik');																																	
					$sheet->setCellValue('I'.$cell, $kiblainnyaregs->uraian);																																	
					$sheet->setCellValue('R'.$cell, $kiblainnyaregs->keterangan);							
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(40);
					$cell++;
				}
				
				$writer = new Xlsx($spreadsheet);
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="MASTER_LAPORAN_MUTASI_BMD_2022_v03.xlsx"');
				$writer->setPreCalculateFormulas(false);
				$writer->save('php://output');
				
				
			}
			
			
			
			
		}else{
			return view(abort(403, 'Unauthorized action.'));
		}			 
	}
	/**
	 * Show the form for creating a new rekonsiliasi_aset.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created rekonsiliasi_aset in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Rekonsiliasi_asets", "create")) {
		
			$rules = Module::validateRules("Rekonsiliasi_asets", $request);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}
			
			$insert_id = Module::insert("Rekonsiliasi_asets", $request);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.rekonsiliasi_asets.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified rekonsiliasi_aset.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Rekonsiliasi_asets", "view")) {
			
			$rekonsiliasi_aset = Rekonsiliasi_aset::find($id);
			if(isset($rekonsiliasi_aset->id)) {
				$module = Module::get('Rekonsiliasi_asets');
				$module->row = $rekonsiliasi_aset;
				
				return view('la.rekonsiliasi_asets.show', [
					'module' => $module,
					'view_col' => $this->view_col,
					'no_header' => true,
					'no_padding' => "no-padding"
				])->with('rekonsiliasi_aset', $rekonsiliasi_aset);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("rekonsiliasi_aset"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Show the form for editing the specified rekonsiliasi_aset.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Rekonsiliasi_asets", "edit")) {			
			$rekonsiliasi_aset = Rekonsiliasi_aset::find($id);
			if(isset($rekonsiliasi_aset->id)) {	
				$module = Module::get('Rekonsiliasi_asets');
				
				$module->row = $rekonsiliasi_aset;
				
				return view('la.rekonsiliasi_asets.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('rekonsiliasi_aset', $rekonsiliasi_aset);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("rekonsiliasi_aset"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified rekonsiliasi_aset in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		if(Module::hasAccess("Rekonsiliasi_asets", "edit")) {
			
			$rules = Module::validateRules("Rekonsiliasi_asets", $request, true);
			
			$validator = Validator::make($request->all(), $rules);
			
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}
			
			$insert_id = Module::updateRow("Rekonsiliasi_asets", $request, $id);
			
			return redirect()->route(config('laraadmin.adminRoute') . '.rekonsiliasi_asets.index');
			
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified rekonsiliasi_aset from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Rekonsiliasi_asets", "delete")) {
			Rekonsiliasi_aset::find($id)->delete();
			
			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.rekonsiliasi_asets.index');
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
/* load data rekon admin*/
//public function loadDatarekonaset(Request $request,$tahunp,$bidang,$unit,$subunit){
	public function loadDatarekonaset(Request $request,$saldoawal,$saldoakhir,$bidang,$unit,$subunit){
	if(Module::hasAccess("Rekonsiliasi_asets", "view")) {
				$kdbidang = Module::kdopd()->kd_bidang;
				$kdunit = Module::kdopd()->kd_unit;
				$kdsub = Module::kdopd()->kd_sub;
				$kdupb = Module::kdopd()->kd_upb;				
				//$tahun = $tahunp;
				//$tahunint = (int)$tahun;
				//$tahunsldawal = $tahunint-1;
				//$D2sldawal = $tahunint-1 .'-12-31';
				//$awal = $tahun .'-01-01';
				//$akhir = $tahun.'-12-31';
				$tahun = (int)date('Y', strtotime($saldoakhir));
				$tahunsldawal = (int)$tahun-1;
				$awal = date('Y-m-d', strtotime($saldoawal));
				$akhir = date('Y-m-d', strtotime($saldoakhir));

			if ($request->ajax()) {
					$output = '';
					$query = $request->get('query');

						if($kdbidang == 99 || $kdbidang == 0 ){						
							//$loadsp2d = 
						}else{
							
							
						}

					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index => $row){
						   $index = $index+1;
						   if(Module::hasAccess("Rekonsiliasi_asets", "edit")){
							$output .= '
							<tr>
							 <td>'.$index.'</td>
							 <td>'.$tahun.'</td>
							 <td>'.$bidang.'</td>
							 <td>'.$unit.'</td>
							 <td>'.$subunit.'</td>
							 <td>'.$row->Nm_Unit.'</td>
							 <td>'.$row->Nm_Sub_Unit.'</td>
							 <td>'.$row->kd_aset.'</td>
							 <td>'.$row->kd_aset0.'</td>
							 <td>'.$row->kd_Aset1.'</td>
							 <td>'.$row->kd_Aset2.'</td>
							 <td>'.$row->Nm_Aset0.'</td>
							 <td>'.$row->Nm_Aset1.'</td>
							 <td>'.$row->Nm_Aset2.'</td>
							 <td>'.$row->saldoawal.'</td>							 							 
							 <td>'.$row->pgdbaru.'</td>							 							 
							 <td>'.$row->pgdkap.'</td>							 							 
							 <td>'.$row->BOS.'</td>							 							 
							 <td>'.$row->HIBAH.'</td>							 							 
							 <td>'.$row->RB.'</td>							 							 
							 <td>'.$row->Penambahan.'</td>							 							 
							 <td>'.$row->Pengurangan.'</td>							 							 
							 <td>'.$row->koreksimsk.'</td>							 							 
							 <td>'.$row->koreksiklr.'</td>							 							 
							 <td>'.$row->extrakom.'</td>							 							 
							 <td>'.$row->saldoakhir.'</td>							 							 
							 
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
	public function dtajax()
	{
		// $values = DB::table('rekonsiliasi_asets')->select($this->listing_cols)->whereNull('deleted_at');
		// $out = Datatables::of($values)->make();
		// $data = $out->getData();

		// $fields_popup = ModuleFields::getModuleFields('Rekonsiliasi_asets');
		
		// for($i=0; $i < count($data->data); $i++) {
			// for ($j=0; $j < count($this->listing_cols); $j++) { 
				// $col = $this->listing_cols[$j];
				// if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					// $data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				// }
				// if($col == $this->view_col) {
					// $data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/rekonsiliasi_asets/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				// }
				// // else if($col == "author") {
				// //    $data->data[$i][$j];
				// // }
			// }
			
			// if($this->show_action) {
				// $output = '';
				// if(Module::hasAccess("Rekonsiliasi_asets", "edit")) {
					// $output .= '<a href="'.url(config('laraadmin.adminRoute') . '/rekonsiliasi_asets/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				// }
				
				// if(Module::hasAccess("Rekonsiliasi_asets", "delete")) {
					// $output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.rekonsiliasi_asets.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
					// $output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
					// $output .= Form::close();
				// }
				// $data->data[$i][] = (string)$output;
			// }
		// }
		// $out->setData($data);
		// return $out;
	}
}
