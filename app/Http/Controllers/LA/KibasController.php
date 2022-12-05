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
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PHPSpreadsheet\Worksheet;

use App\Models\Kiba;

class KibasController extends Controller
{
	public $show_action = true;
	public $view_col = 'idpemda';
	public $listing_cols = ['id', 'idpemda', 'geo', 'sert_file', 'photo_tanah', 'vrf_status', 'vrf_by', 'vrf_at'];

	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Kibas', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Kibas', $this->listing_cols);
		}
	}

	public function csvkibaall($kdbidangs,$kdunits,$kdsubs){
		$kdbidang = Module::kdopd()->kd_bidang;

		/* $data = Module::kibaall($kdbidangs,$kdunits,$kdsubs);
		dd($data); */
		if(Module::hasAccess("Kibas", "view")) {

			if($kdbidang == 99 || $kdbidang == 0 ){

				$inputFileType = 'Xls'; // Xlsx - Xml - Ods - Slk - Gnumeric - Csv
				$inputFileName = public_path('storage\format\format_kiba.xls');
				$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
				$spreadsheet = new Spreadsheet();
				$spreadsheet = $reader->load($inputFileName);
				$sheet = $spreadsheet->getActiveSheet();

				$kibaitem = Module::kibaall($kdbidangs,$kdunits,$kdsubs);
				$cell = 11;
				foreach($kibaitem as $index=>$kibaitems){
					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);
					$sheet->setCellValue('B4', $kibaitems->nm_sub_unit);
					$sheet->setCellValue('B'.$cell, $kibaitems->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibaitems->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibaitems->no_reg);
					$sheet->setCellValue('E'.$cell, $kibaitems->luasm2);
					$sheet->setCellValue('F'.$cell, date('Y', strtotime($kibaitems->tgl_perolehan)));
					$sheet->setCellValue('G'.$cell, $kibaitems->alamat);
					$sheet->setCellValue('H'.$cell, $kibaitems->hak_tanah);
					//$sheet->setCellValue('I'.$cell, date('Y-m-d', strtotime($kibaitems->sertifikat_tanggal)));
					if($kibaitems->sertifikat_tanggal == NULL){
						$sheet->setCellValue('I'.$cell, '-');
					}else{
						$sheet->setCellValue('I'.$cell, date('Y-m-d', strtotime($kibaitems->sertifikat_tanggal)));
					}
					$sheet->setCellValue('J'.$cell, $kibaitems->sertifikat_nomor);
					$sheet->setCellValue('K'.$cell, $kibaitems->penggunaan);
					$sheet->setCellValue('L'.$cell, $kibaitems->Asal_usul);
					$sheet->setCellValue('M'.$cell, $kibaitems->harga);
					$sheet->setCellValue('N'.$cell, $kibaitems->keterangan);
					//$sheet->setCellValue('O'.$cell, $kibaitems->geo);
					if($kibaitems->geo != ''){
						$sheet->setCellValue('O'.$cell, '✔️');
					}else{
						$sheet->setCellValue('O'.$cell, '-');
					}
					$sheet->setCellValue('P'.$cell, $kibaitems->perubahandata);
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(100);
					$cell++;
				}
				$writer = new Xlsx($spreadsheet);
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="KIBA_export.xls"');
				$writer->save('php://output');
			}else{
				$kdunit = Module::kdopd()->kd_unit;
				$kdsub = Module::kdopd()->kd_sub;
				$inputFileType = 'Xls'; // Xlsx - Xml - Ods - Slk - Gnumeric - Csv
				$inputFileName = public_path('storage\format\format_kiba.xls');
				$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
				$spreadsheet = new Spreadsheet();
				$spreadsheet = $reader->load($inputFileName);
				$sheet = $spreadsheet->getActiveSheet();

				$kibaitem = Module::kibaall($kdbidang,$kdunit,$kdsub);
				$cell = 11;
				foreach($kibaitem as $index=>$kibaitems){

					$index = $index+1;
					$sheet->setCellValue('A'.$cell, $index);
					$sheet->setCellValue('B4', $kibaitems->nm_sub_unit);
					$sheet->setCellValue('B'.$cell, $kibaitems->Nm_Aset5);
					$sheet->setCellValue('C'.$cell, $kibaitems->kd_barang);
					$sheet->setCellValue('D'.$cell, $kibaitems->no_reg);
					$sheet->setCellValue('E'.$cell, $kibaitems->luasm2);
					$sheet->setCellValue('F'.$cell, date('Y', strtotime($kibaitems->tgl_perolehan)));
					$sheet->setCellValue('G'.$cell, $kibaitems->alamat);
					$sheet->setCellValue('H'.$cell, $kibaitems->hak_tanah);
					if($kibaitems->sertifikat_tanggal == NULL){
						$sheet->setCellValue('I'.$cell, '-');
					}else{
						$sheet->setCellValue('I'.$cell, date('Y-m-d', strtotime($kibaitems->sertifikat_tanggal)));
					}
					$sheet->setCellValue('J'.$cell, $kibaitems->sertifikat_nomor);
					$sheet->setCellValue('K'.$cell, $kibaitems->penggunaan);
					$sheet->setCellValue('L'.$cell, $kibaitems->Asal_usul);
					$sheet->setCellValue('M'.$cell, $kibaitems->harga);
					$sheet->setCellValue('N'.$cell, $kibaitems->keterangan);
					//$sheet->setCellValue('O'.$cell, $kibaitems->geo);
					if($kibaitems->geo != ''){
						$sheet->setCellValue('O'.$cell, '✔️');
					}else{
						$sheet->setCellValue('O'.$cell, '-');
					}
					$sheet->setCellValue('P'.$cell, $kibaitems->perubahandata);
					$sheet->getRowDimension(($cell-1)+1)->setRowHeight(100);
					$cell++;
				}
				$writer = new Xlsx($spreadsheet);
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="KIBA_export.xls"');
				$writer->save('php://output');
			}
		}else{
			return view(abort(403, 'Unauthorized action.'));
		}
	}
	public function verifgeo(Request $request,$id){
			$update = Kiba::find($id);
			$update->vrf_status = 1;
			$update->save();

			//return redirect(config('laraadmin.adminRoute') .'/kibas#lists');


	}

	public function verifgeorelease(Request $request,$id){
			$update = Kiba::find($id);
			$update->vrf_status = 0;
			$update->save();

			//return redirect(config('laraadmin.adminRoute') .'/kibas#lists');

	}

	/* print */
	public function print($id){
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$tanah = Kiba::findOrFail($id);
		$cekuser = Module::showtanahuser($id)->get();
		if(Module::hasAccess("Kibas", "view")) {
			if($kdbidang == 99 || $kdbidang == 0 ){
					$tanahs = Module::showtanahadmin($id)
									->get();

					$tanaharray = json_decode(json_encode($tanahs[0]), true);
				    $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'isJavascriptEnabled' , true])
							->loadView('la.report.printtanah',$tanaharray)
							->setPaper('Folio', 'portrait');
					//return $pdf->stream('KIB-Tanah_'.Module::userlogin()->dept_name.'.pdf');
					return view('la.report.printtanah',$tanaharray);
			}else{
					$tanahs = Module::showtanahuser($id)
							->get();
					$tanaharray = json_decode(json_encode($tanahs[0]), true);
				   $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'isJavascriptEnabled' , true])
							->loadView('la.report.printtanah',$tanaharray)
							->setPaper('Folio', 'portrait');
					//return $pdf->stream('KIB-Tanah'.Module::userlogin()->dept_name.'.pdf');
					return view('la.report.printtanah',['$tanahs' => $tanahs]);
			}
		}else{
			return view(abort(403, 'Unauthorized action.'));
		}
	}
	/* end */
	/* printsolotanah*/
	public function printsolo(Request $request){
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$query = explode(",", $request->get('searchsolo'));
		if(Module::hasAccess("Kibas", "view")) {
			if($kdbidang == 99 || $kdbidang == 0 ){
				if($request->get('searchsolo') == ""){
					$tanahs = Module::tanahadmin()
									->get();
					$tanaharray = json_decode(json_encode($tanahs), true);
				    $pdf = new PDF;
					$pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])

							->loadView('la.report.printsolotanah',['tanahs' => $tanahs])
							->setPaper('Letter', 'landscape');
					return $pdf->stream('KIB-Tanah_'.Module::userlogin()->dept_name.'.pdf');
				}else{
					$tanahs = Module::tanahadminquerysolo($query)
								  ->get();
					$tanaharray = json_decode(json_encode($tanahs), true);
					$pdf = new PDF;
				    $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
							->loadView('la.report.printsolotanah',['tanahs' => $tanahs])
							->setPaper('folio', 'landscape');
					return $pdf->stream('KIB-Tanah'.Module::userlogin()->dept_name.'.pdf');
				}

			}else{
				if($request->get('searchsolo') == ""){
					$tanahs = Module::tanahuser()->get();
					$tanaharray = json_decode(json_encode($tanahs), true);
					$pdf = new PDF;
				    $pdf = PDF::setOptions(['isPhpEnabled' => true, 'isRemoteEnabled' => true])
							->loadView('la.report.printsolotanah',['tanahs' => $tanahs])
							->setPaper('folio', 'landscape');

					return $pdf->stream('KIB-Tanah'.Module::userlogin()->dept_name.'.pdf');
				}else{
					$tanahs = Module::tanahuserquerysolo($query)
							->get();
					$tanaharray = json_decode(json_encode($tanahs), true);
					$pdf = new PDF;
				    $pdf = PDF::setOptions(['isPhpEnabled' => true, 'isRemoteEnabled' => true])
							->loadView('la.report.printsolotanah',['tanahs' => $tanahs])
							->setPaper('folio', 'landscape');
					return $pdf->stream('KIB-Tanah'.Module::userlogin()->dept_name.'.pdf');
				}
			}

		}else{
			return view(abort(403, 'Unauthorized action.'));
		}
	}

	public function printtanahanpemkab(){
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		//$tanah = Kiba::findOrFail($id);
		//$cekuser = Module::showtanahuser($id)->get();
		if(Module::hasAccess("Kibas", "view")) {
			if($kdbidang == 99 || $kdbidang == 0 ){
					$tanahs = Module::showtanahanpemkab()->get();

					$tanaharray = json_decode(json_encode($tanahs), true);
				    $pdf = new PDF;
					$pdf = PDF::setOptions(['isPhpEnabled' => true, 'isRemoteEnabled' => true])
							->loadView('la.report.printtanahanpemkab',['tanahs' => $tanahs])
							->setPaper('folio', 'landscape');
					return $pdf->stream('KIB-Tanah_'.Module::userlogin()->dept_name.'.pdf');
			}else{
					$tanahs = Module::showtanahanpemkabuser()->get();
					$tanaharray = json_decode(json_encode($tanahs), true);
				    $pdf = new PDF;
					$pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
							->loadView('la.report.printtanahanpemkab',['tanahs' => $tanahs])
							->setPaper('folio', 'landscape');
					return $pdf->stream('KIB-Tanah_'.Module::userlogin()->dept_name.'.pdf');
			}
		}else{
			return view(abort(403, 'Unauthorized action.'));
		}
	}

	public function printtanahsert(){
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;

		//$tanahs = Module::showtanahsert()->get();
		//dd($tanahs);
		if(Module::hasAccess("Kibas", "view")) {
			if($kdbidang == 99 || $kdbidang == 0 ){
					$tanahs = Module::showtanahsert()->get();

					$tanaharray = json_decode(json_encode($tanahs), true);
				    $pdf = new PDF;
					$pdf = PDF::setOptions(['isPhpEnabled' => true, 'isRemoteEnabled' => true])
							->loadView('la.report.printtanahsert',['tanahs' => $tanahs])
							->setPaper('folio', 'landscape');
					return $pdf->stream('KIB-Tanah_'.Module::userlogin()->dept_name.'.pdf');
			}else{
					$tanahs = Module::showtanahsertuser()->get();
					$tanaharray = json_decode(json_encode($tanahs), true);
				    $pdf = new PDF;
					$pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true])
							->loadView('la.report.printtanahsert',['tanahs' => $tanahs])
							->setPaper('folio', 'landscape');
					return $pdf->stream('KIB-Tanah_'.Module::userlogin()->dept_name.'.pdf');
			}
		}else{
			return view(abort(403, 'Unauthorized action.'));
		}
	}
	/* end*/
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
	/**
	 * Display a listing of the Kibas.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		$module = Module::get('Kibas');
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$kdsub = Module::kdopd()->kd_sub;
		$kdupb = Module::kdopd()->kd_upb;

		if($kdbidang == 99 || $kdbidang == 0 ){
			$refbidang = Module::populatebidangadmin()->get();
			$sertcount = DB::table('departments as dept')->leftjoin(Module::bmd().'.Ta_KIB_A as kiba',function ($join) {
									$join->on('dept.kd_bidang','=','kiba.kd_bidang')
											->on('dept.kd_unit','=','kiba.kd_unit')
											->on('dept.kd_sub','=','kiba.kd_sub')
											->on('dept.kd_upb','=','kiba.kd_upb');
									}
								)
					->join('kibas','kibas.idpemda','=','kiba.IDPemda')
					->leftjoin('uploads as uploadsert','uploadsert.id','=','kibas.sert_file')
					->leftjoin('uploads as uploadfoto','uploadfoto.id','=','kibas.photo_tanah')
					->leftjoin(DB::raw('(SELECT COUNT(kiba.idpemda) as tanahpemkabs,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_A as kiba
												on dept.kd_bidang = kiba.kd_bidang and
													dept.kd_unit = kiba.kd_unit and
													dept.kd_sub = kiba.kd_sub and
													dept.kd_upb = kiba.kd_upb join
													kibas on kibas.idpemda = kiba.idpemda
												WHERE
												kiba.kd_pemilik = 12 and
												kiba.kd_hapus = 0

												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)tanahpemkab'),
												function ($joins){
												$joins->on('tanahpemkab.kd_bidang','=','dept.kd_bidang')
														->on('tanahpemkab.kd_unit','=','dept.kd_unit')
														->on('tanahpemkab.kd_sub','=','dept.kd_sub')
														->on('tanahpemkab.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kiba.idpemda) as tanahnonpemkabs,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_A as kiba
												on dept.kd_bidang = kiba.kd_bidang and
													dept.kd_unit = kiba.kd_unit and
													dept.kd_sub = kiba.kd_sub and
													dept.kd_upb = kiba.kd_upb join
													kibas on kibas.idpemda = kiba.idpemda
												WHERE
												(kiba.kd_pemilik <> 12 )

												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)tanahnonpemkab'),
												function ($joins){
												$joins->on('tanahnonpemkab.kd_bidang','=','dept.kd_bidang')
														->on('tanahnonpemkab.kd_unit','=','dept.kd_unit')
														->on('tanahnonpemkab.kd_sub','=','dept.kd_sub')
														->on('tanahnonpemkab.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kiba.idpemda) as tanahhapus,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_A as kiba
												on dept.kd_bidang = kiba.kd_bidang and
													dept.kd_unit = kiba.kd_unit and
													dept.kd_sub = kiba.kd_sub and
													dept.kd_upb = kiba.kd_upb left join
													kibas on kibas.idpemda = kiba.idpemda
												WHERE
												kiba.kd_hapus = 1

												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)tanahdihapus'),
												function ($joins){
												$joins->on('tanahdihapus.kd_bidang','=','dept.kd_bidang')
														->on('tanahdihapus.kd_unit','=','dept.kd_unit')
														->on('tanahdihapus.kd_sub','=','dept.kd_sub')
														->on('tanahdihapus.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kiba.idpemda) as sertdiisi,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_A as kiba
												on dept.kd_bidang = kiba.kd_bidang and
													dept.kd_unit = kiba.kd_unit and
													dept.kd_sub = kiba.kd_sub and
													dept.kd_upb = kiba.kd_upb left join
													kibas on kibas.idpemda = kiba.idpemda
												WHERE
												kiba.sertifikat_nomor is null

												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)sertisi'),
												function ($joins){
												$joins->on('sertisi.kd_bidang','=','dept.kd_bidang')
														->on('sertisi.kd_unit','=','dept.kd_unit')
														->on('sertisi.kd_sub','=','dept.kd_sub')
														->on('sertisi.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kiba.idpemda) as sertnotdiisi,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_A as kiba
												on dept.kd_bidang = kiba.kd_bidang and
													dept.kd_unit = kiba.kd_unit and
													dept.kd_sub = kiba.kd_sub and
													dept.kd_upb = kiba.kd_upb left join
													kibas on kibas.idpemda = kiba.idpemda
												WHERE
												kiba.sertifikat_nomor is not null

												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)sertnotisi'),
												function ($joins){
												$joins->on('sertnotisi.kd_bidang','=','dept.kd_bidang')
														->on('sertnotisi.kd_unit','=','dept.kd_unit')
														->on('sertnotisi.kd_sub','=','dept.kd_sub')
														->on('sertnotisi.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kiba.idpemda) as tglsertdiisi,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_A as kiba
												on dept.kd_bidang = kiba.kd_bidang and
													dept.kd_unit = kiba.kd_unit and
													dept.kd_sub = kiba.kd_sub and
													dept.kd_upb = kiba.kd_upb left join
													kibas on kibas.idpemda = kiba.idpemda
												WHERE
												kiba.sertifikat_tanggal is not null

												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)tglsertisi'),
												function ($joins){
												$joins->on('tglsertisi.kd_bidang','=','dept.kd_bidang')
														->on('tglsertisi.kd_unit','=','dept.kd_unit')
														->on('tglsertisi.kd_sub','=','dept.kd_sub')
														->on('tglsertisi.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kiba.idpemda) as tglsertnotdiisi,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_A as kiba
												on dept.kd_bidang = kiba.kd_bidang and
													dept.kd_unit = kiba.kd_unit and
													dept.kd_sub = kiba.kd_sub and
													dept.kd_upb = kiba.kd_upb left join
													kibas on kibas.idpemda = kiba.idpemda
												WHERE
												kiba.sertifikat_tanggal is null

												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)tglsertnotisi'),
												function ($joins){
												$joins->on('tglsertnotisi.kd_bidang','=','dept.kd_bidang')
														->on('tglsertnotisi.kd_unit','=','dept.kd_unit')
														->on('tglsertnotisi.kd_sub','=','dept.kd_sub')
														->on('tglsertnotisi.kd_upb','=','dept.kd_upb');
											}
								)
					->select('dept.kd_bidang','dept.kd_unit','dept.kd_sub','dept.kd_upb','dept.name',
										//DB::raw('ISNULL(ISNULL(roda2.rodadua,0) + ISNULL(roda4.rodaempat,0) + ISNULL(roda3.rodatiga,0) + ISNULL(penumpang.pnp,0) + ISNULL(barang.brg,0) + ISNULL(khusus.kh,0) + ISNULL(lainnya.lain,0),0) as kendaraantot'),
										DB::raw('(ISNULL(tanahpemkab.tanahpemkabs,0) + ISNULL(tanahnonpemkab.tanahnonpemkabs,0))  as tanahtot'),
										DB::raw('ISNULL(tanahpemkab.tanahpemkabs,0) as tanahpemkab'),
										DB::raw('ISNULL(tanahnonpemkab.tanahnonpemkabs,0) as tanahnonpemkab'),
										DB::raw('ISNULL(tanahdihapus.tanahhapus,0) as tanahdihapus'),
										DB::raw('ISNULL(sertisi.sertdiisi,0) as sertisis'),
										DB::raw('ISNULL(sertnotisi.sertnotdiisi,0) as sertnotisis'),
										DB::raw('ISNULL(tglsertisi.tglsertdiisi,0) as tglsertisis'),
										DB::raw('ISNULL(tglsertnotisi.tglsertnotdiisi,0) as tglsertnotisis'),
										DB::raw('ISNULL(COUNT(kibas.sert_file),0) as sertdiupload'),
										DB::raw('ISNULL(COUNT(kibas.photo_tanah),0) as fotodiupload'),
										DB::raw('ISNULL(COUNT(kibas.vrf_status) ,0) as vrfgeo')
							)

					->where([
							 ['kiba.kd_aset8','=',1],
							 ['kiba.kd_aset80','=',3],
							 ['kiba.kd_aset81','=',1]
							 ])
					->groupBy('dept.kd_bidang','dept.kd_unit','dept.kd_sub','dept.kd_upb','dept.name',
								'tanahpemkab.tanahpemkabs','tanahnonpemkab.tanahnonpemkabs','tanahdihapus.tanahhapus',
								'sertisi.sertdiisi','sertnotisi.sertnotdiisi','tglsertisi.tglsertdiisi','tglsertnotisi.tglsertnotdiisi')
					->orderBy('dept.kd_bidang','ASC')
					->orderBy('dept.kd_unit','ASC')
					->orderBy('dept.kd_sub','ASC')
					->orderBy('dept.kd_upb','ASC')
					->get();
			$tanah = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
					->select('kibas.idpemda as count')
					->where([['kiba.kd_hapus','=',0],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1]
							])
					->count();
			$tanahpemkab = DB::table(Module::bmd().'.Ta_KIB_A as kiba')
							->select('kiba.idpemda as count')
							->distinct()
							->where([['kiba.kd_hapus','=',0],
									['kiba.kd_pemilik','=',12],
									['kiba.kd_aset8','=',1],
									['kiba.kd_aset80','=',3],
									['kiba.kd_aset81','=',1]
									])
							->count();
			$tanahpemkabsdhsert = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
							->select('kibas.idpemda as count')
							->where([['kiba.kd_hapus','=',0],
									['kibas.sertifikat_an','like','%Pemerintah Kabupaten Bojonegoro%'],
									['kiba.kd_pemilik','=',12],
									['kiba.kd_aset8','=',1],
									['kiba.kd_aset80','=',3],
									['kiba.kd_aset81','=',1]
									])
							//->distinct()
							->count();
			$tanahpemkabblmsert = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
							->select('kibas.idpemda as count')
							->where([['kiba.kd_hapus','=',0],
									['kibas.sertifikat_an','like','%Belum Sertifikat%'],
									['kiba.kd_pemilik','=',12],
									['kiba.kd_aset8','=',1],
									['kiba.kd_aset80','=',3],
									['kiba.kd_aset81','=',1]
									])
							->count();
			$tanahnonpemkab = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
					->select('kibas.idpemda as count')
					->where([['kiba.kd_hapus','=',0],
							['kiba.kd_pemilik','<>',12],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1]
							])
					->count();
			$tanahnilai1 = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
					->select('kibas.idpemda as count')
					->where([['kiba.kd_hapus','=',0],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1],
							['kiba.harga','=',1]
							])
					->count();
			$tanahnilai1beli = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
					->select('kibas.idpemda as count')
					->where([
							['kiba.asal_usul','=','Pembelian'],
							['kiba.kd_hapus','=',0],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1],
							['kiba.harga','=',1]
							])
					->count();
			$tanahnilai1hibah = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
					->select('kibas.idpemda as count')
					->where([
							['kiba.asal_usul','=','Hibah'],
							['kiba.kd_hapus','=',0],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1],
							['kiba.harga','=',1]
							])
					->count();
			$tanahnilai0 = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
					->select('kibas.idpemda as count')
					->where([['kiba.kd_hapus','=',0],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1],
							['kiba.harga','=',0]
							])
					->count();
			$tanahnilai0beli = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
					->select('kibas.idpemda as count')
					->where([
							['kiba.asal_usul','=','Pembelian'],
							['kiba.kd_hapus','=',0],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1],
							['kiba.harga','=',0]
							])
					->count();
			$tanahnilai0hibah = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
					->select('kibas.idpemda as count')
					->where([
							['kiba.asal_usul','=','Hibah'],
							['kiba.kd_hapus','=',0],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1],
							['kiba.harga','=',0]
							])
					->count();
			$tanahnilai0tkd = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
					->select('kibas.idpemda as count')
					->where([
							['kiba.keterangan','like','%Kas desa%'],
							['kiba.kd_hapus','=',0],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1],
							['kiba.harga','=',0]
							])
					->orwhere
							([
							['kiba.keterangan','like','%TKD%'],
							['kiba.kd_hapus','=',0],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1],
							['kiba.harga','=',0]
							])
					->orwhere
							([
							['kiba.keterangan','like','%Tanah Desa%'],
							['kiba.kd_hapus','=',0],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1],
							['kiba.harga','=',0]
							])
					->orwhere
							([
							['kiba.asal_usul','like','%yasan%'],
							['kiba.kd_hapus','=',0],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1],
							['kiba.harga','=',0]
							])
					->count();
			$tanahbeli = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
					->select('kibas.idpemda as count')
					->where([['kiba.kd_hapus','=',0],
							['kiba.Asal_usul','=','Pembelian'],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1]
							])
					->count();
			$tanahhibah = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
					->select('kibas.idpemda as count')
					->where([['kiba.kd_hapus','=',0],
							['kiba.Asal_usul','=','Hibah'],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1]
							])
					->count();
			$tanahpinjam = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
					->select('kibas.idpemda as count')
					->where([['kiba.kd_hapus','=',0],
							['kiba.Asal_usul','=','Pinjam'],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1]
							])
					->count();
			 $sertempty = DB::table(Module::bmd().'.Ta_KIB_A as kibA')
					->select('kiba.idpemda as count')
					->whereNull('kiba.Sertifikat_Nomor')
					//->whereNull('kiba.Sertifikat_Tanggal')
					->where([['kiba.kd_hapus','=',0],
							['kiba.kd_pemilik','=',12],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1]
							])
					->count();
			 $sertupload= DB::table('kibAs')->join(Module::bmd().'.Ta_KIB_A as kibA','kibas.idpemda','=','kiba.IDPemda')
					->select('kibas.idpemda as count')
					->whereNotNull('kibas.sert_file')
					->where([['kiba.kd_hapus','=',0],
							['kiba.kd_pemilik','=',12],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1]
							])
					->count();
			$sertnotupload= DB::table('kibAs')->join(Module::bmd().'.Ta_KIB_A as kibA','kibas.idpemda','=','kiba.IDPemda')
					->select('kibas.idpemda as count')
					->whereNull('kibas.sert_file')
					->where([['kiba.kd_hapus','=',0],
							['kiba.kd_pemilik','=',12],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1]
							])
					->count();
			$sertnotempty = DB::table(Module::bmd().'.Ta_KIB_A as kibA')
					->select('kiba.idpemda as count')
					->whereNotNull('kiba.Sertifikat_Nomor')
					//->whereNotNull('kiba.Sertifikat_Tanggal')
					->where([['kiba.kd_hapus','=',0],
							['kiba.kd_pemilik','=',12],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1]
							])
					->count();
			$tanahhapus = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
						->select('kibas.idpemda as count')
						->where([['kiba.kd_hapus','=',1],
								['kiba.kd_pemilik','=',12],
								['kiba.kd_aset8','=',1],
								['kiba.kd_aset80','=',3],
								['kiba.kd_aset81','=',1]
								])
						->count();
			$tanahkantor = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
						->select('kibas.idpemda as count')
						->where([
								['kiba.kd_hapus','=',0],
								['kiba.kd_pemilik','=',12],
								['kiba.kd_aset8','=',1],
								['kiba.kd_aset80','=',3],
								['kiba.kd_aset81','=',1],
								['kibas.pemanfaatan','LIKE','%Pemkab Bojonegoro%']
								])
						->count();
			$tanahidle = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
						->select('kibas.idpemda as count')
						->where([
								['kiba.kd_hapus','=',0],
								['kiba.kd_pemilik','=',12],
								['kiba.kd_aset8','=',1],
								['kiba.kd_aset80','=',3],
								['kiba.kd_aset81','=',1],
								['kibas.pemanfaatan','LIKE','%Idle%']
								])
						->count();
		}else{
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$kdsub = Module::kdopd()->kd_sub;
		$kdupb = Module::kdopd()->kd_upb;

		$refbidang = Module::populatebidanguser()->get();
					$sertcount = DB::table('departments as dept')->join(Module::bmd().'.Ta_KIB_A as kiba',function ($join) {
									$join->on('dept.kd_bidang','=','kiba.kd_bidang')
											->on('dept.kd_unit','=','kiba.kd_unit')
											->on('dept.kd_sub','=','kiba.kd_sub')
											->on('dept.kd_upb','=','kiba.kd_upb');
									}
								)
					->join('kibas','kibas.idpemda','=','kiba.IDPemda')
					->leftjoin('uploads as uploadsert','uploadsert.id','=','kibas.sert_file')
					->leftjoin('uploads as uploadfoto','uploadfoto.id','=','kibas.photo_tanah')
					->join(DB::raw('(SELECT COUNT(kiba.idpemda) as tanahpemkabs,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_A as kiba
												on dept.kd_bidang = kiba.kd_bidang and
													dept.kd_unit = kiba.kd_unit and
													dept.kd_sub = kiba.kd_sub and
													dept.kd_upb = kiba.kd_upb join
													kibas on kibas.idpemda = kiba.idpemda
												WHERE
												kiba.kd_pemilik = 12 and
												kiba.kd_hapus = 0

												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)tanahpemkab'),
												function ($joins){
												$joins->on('tanahpemkab.kd_bidang','=','dept.kd_bidang')
														->on('tanahpemkab.kd_unit','=','dept.kd_unit')
														->on('tanahpemkab.kd_sub','=','dept.kd_sub')
														->on('tanahpemkab.kd_upb','=','dept.kd_upb');
											}
								)
					->join(DB::raw('(SELECT COUNT(kiba.idpemda) as tanahnonpemkabs,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_A as kiba
												on dept.kd_bidang = kiba.kd_bidang and
													dept.kd_unit = kiba.kd_unit and
													dept.kd_sub = kiba.kd_sub and
													dept.kd_upb = kiba.kd_upb join
													kibas on kibas.idpemda = kiba.idpemda
												WHERE
												(kiba.kd_pemilik <> 12 )

												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)tanahnonpemkab'),
												function ($joins){
												$joins->on('tanahnonpemkab.kd_bidang','=','dept.kd_bidang')
														->on('tanahnonpemkab.kd_unit','=','dept.kd_unit')
														->on('tanahnonpemkab.kd_sub','=','dept.kd_sub')
														->on('tanahnonpemkab.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kiba.idpemda) as tanahhapus,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_A as kiba
												on dept.kd_bidang = kiba.kd_bidang and
													dept.kd_unit = kiba.kd_unit and
													dept.kd_sub = kiba.kd_sub and
													dept.kd_upb = kiba.kd_upb left join
													kibas on kibas.idpemda = kiba.idpemda
												WHERE
												kiba.kd_hapus = 1

												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)tanahdihapus'),
												function ($joins){
												$joins->on('tanahdihapus.kd_bidang','=','dept.kd_bidang')
														->on('tanahdihapus.kd_unit','=','dept.kd_unit')
														->on('tanahdihapus.kd_sub','=','dept.kd_sub')
														->on('tanahdihapus.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kiba.idpemda) as sertdiisi,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_A as kiba
												on dept.kd_bidang = kiba.kd_bidang and
													dept.kd_unit = kiba.kd_unit and
													dept.kd_sub = kiba.kd_sub and
													dept.kd_upb = kiba.kd_upb left join
													kibas on kibas.idpemda = kiba.idpemda
												WHERE
												kiba.sertifikat_nomor is null

												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)sertisi'),
												function ($joins){
												$joins->on('sertisi.kd_bidang','=','dept.kd_bidang')
														->on('sertisi.kd_unit','=','dept.kd_unit')
														->on('sertisi.kd_sub','=','dept.kd_sub')
														->on('sertisi.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kiba.idpemda) as sertnotdiisi,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_A as kiba
												on dept.kd_bidang = kiba.kd_bidang and
													dept.kd_unit = kiba.kd_unit and
													dept.kd_sub = kiba.kd_sub and
													dept.kd_upb = kiba.kd_upb left join
													kibas on kibas.idpemda = kiba.idpemda
												WHERE
												kiba.sertifikat_nomor is not null

												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)sertnotisi'),
												function ($joins){
												$joins->on('sertnotisi.kd_bidang','=','dept.kd_bidang')
														->on('sertnotisi.kd_unit','=','dept.kd_unit')
														->on('sertnotisi.kd_sub','=','dept.kd_sub')
														->on('sertnotisi.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kiba.idpemda) as tglsertdiisi,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_A as kiba
												on dept.kd_bidang = kiba.kd_bidang and
													dept.kd_unit = kiba.kd_unit and
													dept.kd_sub = kiba.kd_sub and
													dept.kd_upb = kiba.kd_upb left join
													kibas on kibas.idpemda = kiba.idpemda
												WHERE
												kiba.sertifikat_tanggal is not null

												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)tglsertisi'),
												function ($joins){
												$joins->on('tglsertisi.kd_bidang','=','dept.kd_bidang')
														->on('tglsertisi.kd_unit','=','dept.kd_unit')
														->on('tglsertisi.kd_sub','=','dept.kd_sub')
														->on('tglsertisi.kd_upb','=','dept.kd_upb');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kiba.idpemda) as tglsertnotdiisi,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_A as kiba
												on dept.kd_bidang = kiba.kd_bidang and
													dept.kd_unit = kiba.kd_unit and
													dept.kd_sub = kiba.kd_sub and
													dept.kd_upb = kiba.kd_upb left join
													kibas on kibas.idpemda = kiba.idpemda
												WHERE
												kiba.sertifikat_tanggal is null

												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)tglsertnotisi'),
												function ($joins){
												$joins->on('tglsertnotisi.kd_bidang','=','dept.kd_bidang')
														->on('tglsertnotisi.kd_unit','=','dept.kd_unit')
														->on('tglsertnotisi.kd_sub','=','dept.kd_sub')
														->on('tglsertnotisi.kd_upb','=','dept.kd_upb');
											}
								)
					->select('dept.kd_bidang','dept.kd_unit','dept.kd_sub','dept.kd_upb','dept.name',
										//DB::raw('ISNULL(ISNULL(roda2.rodadua,0) + ISNULL(roda4.rodaempat,0) + ISNULL(roda3.rodatiga,0) + ISNULL(penumpang.pnp,0) + ISNULL(barang.brg,0) + ISNULL(khusus.kh,0) + ISNULL(lainnya.lain,0),0) as kendaraantot'),
										DB::raw('COUNT(kiba.idpemda) as tanahtot'),
										DB::raw('ISNULL(tanahpemkab.tanahpemkabs,0) as tanahpemkab'),
										DB::raw('ISNULL(tanahnonpemkab.tanahnonpemkabs,0) as tanahnonpemkab'),
										DB::raw('ISNULL(tanahdihapus.tanahhapus,0) as tanahdihapus'),
										DB::raw('ISNULL(sertisi.sertdiisi,0) as sertisis'),
										DB::raw('ISNULL(sertnotisi.sertnotdiisi,0) as sertnotisis'),
										DB::raw('ISNULL(tglsertisi.tglsertdiisi,0) as tglsertisis'),
										DB::raw('ISNULL(tglsertnotisi.tglsertnotdiisi,0) as tglsertnotisis'),
										DB::raw('ISNULL(COUNT(kibas.sert_file),0) as sertdiupload'),
										DB::raw('ISNULL(COUNT(kibas.photo_tanah),0) as fotodiupload'),
										DB::raw('ISNULL(COUNT(kibas.vrf_status) ,0) as vrfgeo')
							)

					->where([
							 ['kiba.kd_bidang','=',$kdbidang],
							 ['kiba.kd_unit','=',$kdunit],
							 ['kiba.kd_sub','=',$kdsub],
							 //['kiba.kd_upb','=',$kdupb],
							 ['kiba.kd_aset8','=',1],
							 ['kiba.kd_aset80','=',3],
							 ['kiba.kd_aset81','=',1]
							 ])
					->groupBy('dept.kd_bidang','dept.kd_unit','dept.kd_sub','dept.kd_upb','dept.name',
								'tanahpemkab.tanahpemkabs','tanahnonpemkab.tanahnonpemkabs','tanahdihapus.tanahhapus',
								'sertisi.sertdiisi','sertnotisi.sertnotdiisi','tglsertisi.tglsertdiisi','tglsertnotisi.tglsertnotdiisi')
					->orderBy('dept.kd_bidang','ASC')
					->orderBy('dept.kd_unit','ASC')
					->orderBy('dept.kd_sub','ASC')
					->orderBy('dept.kd_upb','ASC')
					->get();
			$tanah = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
					->select('kibas.idpemda as count')
					->where([
							['kiba.kd_bidang','=',$kdbidang],
							['kiba.kd_unit','=',$kdunit],
							['kiba.kd_sub','=',$kdsub],
							//['kiba.kd_upb','=',$kdupb],
							['kiba.kd_hapus','=',0],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1]
							])
					->count();
			$tanahpemkab = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
					->select('kibas.idpemda as count')
					->where([
							['kiba.kd_bidang','=',$kdbidang],
							['kiba.kd_unit','=',$kdunit],
							['kiba.kd_sub','=',$kdsub],
							//['kiba.kd_upb','=',$kdupb],
							['kiba.kd_hapus','=',0],
							['kiba.kd_pemilik','=',12],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1]
							])
					->count();
			$tanahpemkabsdhsert = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
							->select('kibas.idpemda as count')
							->where([
									['kiba.kd_bidang','=',$kdbidang],
									['kiba.kd_unit','=',$kdunit],
									['kiba.kd_sub','=',$kdsub],
									//['kiba.kd_upb','=',$kdupb],
									['kiba.kd_hapus','=',0],
									['kibas.sertifikat_an','like','%Pemerintah Kabupaten Bojonegoro%'],
									['kiba.kd_pemilik','=',12],
									['kiba.kd_aset8','=',1],
									['kiba.kd_aset80','=',3],
									['kiba.kd_aset81','=',1]
									])
							->count();
			$tanahpemkabblmsert = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
							->select('kibas.idpemda as count')
							->where([
									['kiba.kd_bidang','=',$kdbidang],
								['kiba.kd_unit','=',$kdunit],
								['kiba.kd_sub','=',$kdsub],
								//['kiba.kd_upb','=',$kdupb],
									['kiba.kd_hapus','=',0],
									['kibas.sertifikat_an','like','%Belum Sertifikat%'],
									['kiba.kd_pemilik','=',12],
									['kiba.kd_aset8','=',1],
									['kiba.kd_aset80','=',3],
									['kiba.kd_aset81','=',1]
									])
							->count();
			$tanahnonpemkab = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
					->select('kibas.idpemda as count')
					->where([
							['kiba.kd_bidang','=',$kdbidang],
							['kiba.kd_unit','=',$kdunit],
							['kiba.kd_sub','=',$kdsub],
							//['kiba.kd_upb','=',$kdupb],
							['kiba.kd_hapus','=',0],
							['kiba.kd_pemilik','<>',12],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1]
							])
					->count();
			$tanahnilai1 = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
					->select('kibas.idpemda as count')
					->where([
							['kiba.kd_bidang','=',$kdbidang],
							['kiba.kd_unit','=',$kdunit],
							['kiba.kd_sub','=',$kdsub],
							//['kiba.kd_upb','=',$kdupb],
							['kiba.kd_hapus','=',0],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1],
							['kiba.harga','=',1]
							])
					->count();
			$tanahnilai0 = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
					->select('kibas.idpemda as count')
					->where([
							['kiba.kd_bidang','=',$kdbidang],
							['kiba.kd_unit','=',$kdunit],
							['kiba.kd_sub','=',$kdsub],
							//['kiba.kd_upb','=',$kdupb],
							['kiba.kd_hapus','=',0],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1],
							['kiba.harga','=',0]
							])
					->count();
			$tanahnilai1 = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
					->select('kibas.idpemda as count')
					->where([
							['kiba.kd_bidang','=',$kdbidang],
							['kiba.kd_unit','=',$kdunit],
							['kiba.kd_sub','=',$kdsub],
							//['kiba.kd_upb','=',$kdupb],
							['kiba.kd_hapus','=',0],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1],
							['kiba.harga','=',1]
							])
					->count();
			$tanahnilai1beli = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
					->select('kibas.idpemda as count')
					->where([
							['kiba.kd_bidang','=',$kdbidang],
							['kiba.kd_unit','=',$kdunit],
							['kiba.kd_sub','=',$kdsub],
							//['kiba.kd_upb','=',$kdupb],
							['kiba.asal_usul','=','Pembelian'],
							['kiba.kd_hapus','=',0],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1],
							['kiba.harga','=',1]
							])
					->count();
			$tanahnilai1hibah = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
					->select('kibas.idpemda as count')
					->where([
							['kiba.kd_bidang','=',$kdbidang],
							['kiba.kd_unit','=',$kdunit],
							['kiba.kd_sub','=',$kdsub],
							//['kiba.kd_upb','=',$kdupb],
							['kiba.asal_usul','=','Hibah'],
							['kiba.kd_hapus','=',0],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1],
							['kiba.harga','=',1]
							])
					->count();
			$tanahnilai0 = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
					->select('kibas.idpemda as count')
					->where([
							['kiba.kd_bidang','=',$kdbidang],
							['kiba.kd_unit','=',$kdunit],
							['kiba.kd_sub','=',$kdsub],
							//['kiba.kd_upb','=',$kdupb],
							['kiba.kd_hapus','=',0],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1],
							['kiba.harga','=',0]
							])
					->count();
			$tanahnilai0beli = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
					->select('kibas.idpemda as count')
					->where([
							['kiba.kd_bidang','=',$kdbidang],
							['kiba.kd_unit','=',$kdunit],
							['kiba.kd_sub','=',$kdsub],
							//['kiba.kd_upb','=',$kdupb],
							['kiba.asal_usul','=','Pembelian'],
							['kiba.kd_hapus','=',0],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1],
							['kiba.harga','=',0]
							])
					->count();
			$tanahnilai0hibah = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
					->select('kibas.idpemda as count')
					->where([
							['kiba.kd_bidang','=',$kdbidang],
							['kiba.kd_unit','=',$kdunit],
							['kiba.kd_sub','=',$kdsub],
							//['kiba.kd_upb','=',$kdupb],
							['kiba.asal_usul','=','Hibah'],
							['kiba.kd_hapus','=',0],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1],
							['kiba.harga','=',0]
							])
					->count();
			$tanahnilai0tkd = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
					->select('kibas.idpemda as count')
					->where([
							['kiba.kd_bidang','=',$kdbidang],
							['kiba.kd_unit','=',$kdunit],
							['kiba.kd_sub','=',$kdsub],
							//['kiba.kd_upb','=',$kdupb],
							['kiba.keterangan','like','%Kas desa%'],
							['kiba.kd_hapus','=',0],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1],
							['kiba.harga','=',0]
							])
					->orwhere
							([
							['kiba.kd_bidang','=',$kdbidang],
							['kiba.kd_unit','=',$kdunit],
							['kiba.kd_sub','=',$kdsub],
							//['kiba.kd_upb','=',$kdupb],
							['kiba.keterangan','like','%TKD%'],
							['kiba.kd_hapus','=',0],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1],
							['kiba.harga','=',0]
							])
					->orwhere
							([
							['kiba.kd_bidang','=',$kdbidang],
							['kiba.kd_unit','=',$kdunit],
							['kiba.kd_sub','=',$kdsub],
							//['kiba.kd_upb','=',$kdupb],
							['kiba.keterangan','like','%Tanah Desa%'],
							['kiba.kd_hapus','=',0],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1],
							['kiba.harga','=',0]
							])
					->orwhere
							([
							['kiba.kd_bidang','=',$kdbidang],
							['kiba.kd_unit','=',$kdunit],
							['kiba.kd_sub','=',$kdsub],
							//['kiba.kd_upb','=',$kdupb],
							['kiba.asal_usul','like','%yasan%'],
							['kiba.kd_hapus','=',0],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1],
							['kiba.harga','=',0]
							])
					->count();
			$tanahbeli = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
					->select('kibas.idpemda as count')
					->where([
							['kiba.kd_bidang','=',$kdbidang],
							['kiba.kd_unit','=',$kdunit],
							['kiba.kd_sub','=',$kdsub],
							//['kiba.kd_upb','=',$kdupb],
							['kiba.kd_hapus','=',0],
							['kiba.Asal_usul','=','Pembelian'],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1]
							])
					->count();
			$tanahhibah = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
					->select('kibas.idpemda as count')
					->where([
							['kiba.kd_bidang','=',$kdbidang],
							['kiba.kd_unit','=',$kdunit],
							['kiba.kd_sub','=',$kdsub],
							//['kiba.kd_upb','=',$kdupb],
							['kiba.kd_hapus','=',0],
							['kiba.Asal_usul','=','Hibah'],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1]
							])
					->count();
			$tanahpinjam = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
					->select('kibas.idpemda as count')
					->where([
							['kiba.kd_bidang','=',$kdbidang],
							['kiba.kd_unit','=',$kdunit],
							['kiba.kd_sub','=',$kdsub],
							//['kiba.kd_upb','=',$kdupb],
							['kiba.kd_hapus','=',0],
							['kiba.Asal_usul','=','Pinjam'],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1]
							])
					->count();
			 $sertempty = DB::table('kibAs')->join(Module::bmd().'.Ta_KIB_A as kibA','kibas.idpemda','=','kiba.IDPemda')
					->select('kibas.idpemda as count')
					->whereNull('kiba.Sertifikat_Nomor')
					//->whereNull('kiba.Sertifikat_Tanggal')
					->where([
							['kiba.kd_bidang','=',$kdbidang],
							['kiba.kd_unit','=',$kdunit],
							['kiba.kd_sub','=',$kdsub],
							//['kiba.kd_upb','=',$kdupb],
							['kiba.kd_hapus','=',0],
							['kiba.kd_pemilik','=',12],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1]
							])
					->count();
			 $sertupload= DB::table('kibAs')->join(Module::bmd().'.Ta_KIB_A as kibA','kibas.idpemda','=','kiba.IDPemda')
					->select('kibas.idpemda as count')
					->whereNotNull('kibas.sert_file')
					->where([
							['kiba.kd_bidang','=',$kdbidang],
							['kiba.kd_unit','=',$kdunit],
							['kiba.kd_sub','=',$kdsub],
							//['kiba.kd_upb','=',$kdupb],
							['kiba.kd_hapus','=',0],
							['kiba.kd_pemilik','=',12],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1]
							])
					->count();
			$sertnotupload= DB::table('kibAs')->join(Module::bmd().'.Ta_KIB_A as kibA','kibas.idpemda','=','kiba.IDPemda')
					->select('kibas.idpemda as count')
					->whereNull('kibas.sert_file')
					->where([
							['kiba.kd_bidang','=',$kdbidang],
							['kiba.kd_unit','=',$kdunit],
							['kiba.kd_sub','=',$kdsub],
							//['kiba.kd_upb','=',$kdupb],
							['kiba.kd_hapus','=',0],
							['kiba.kd_pemilik','=',12],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1]
							])
					->count();
			$sertnotempty = DB::table(Module::bmd().'.Ta_KIB_A as kibA')
					->select('kibas.idpemda as count')
					->whereNotNull('kiba.Sertifikat_Nomor')
					//->whereNotNull('kiba.Sertifikat_Tanggal')
					->where([
							['kiba.kd_bidang','=',$kdbidang],
							['kiba.kd_unit','=',$kdunit],
							['kiba.kd_sub','=',$kdsub],
							//['kiba.kd_upb','=',$kdupb],
							['kiba.kd_hapus','=',0],
							['kiba.kd_pemilik','=',12],
							['kiba.kd_aset8','=',1],
							['kiba.kd_aset80','=',3],
							['kiba.kd_aset81','=',1]
							])
					->count();
			$tanahhapus = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
						->select('kibas.idpemda as count')
						->where([
								['kiba.kd_bidang','=',$kdbidang],
								['kiba.kd_unit','=',$kdunit],
								['kiba.kd_sub','=',$kdsub],
								//['kiba.kd_upb','=',$kdupb],
								['kiba.kd_hapus','=',1],
								['kiba.kd_pemilik','=',12],
								['kiba.kd_aset8','=',1],
								['kiba.kd_aset80','=',3],
								['kiba.kd_aset81','=',1]
								])
						->count();
			$tanahkantor = DB::table('kibas')->join(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
						->select('kibas.idpemda as count')
						->where([
								['kiba.kd_bidang','=',$kdbidang],
								['kiba.kd_unit','=',$kdunit],
								['kiba.kd_sub','=',$kdsub],
								['kiba.kd_hapus','=',0],
								['kiba.kd_pemilik','=',12],
								['kiba.kd_aset8','=',1],
								['kiba.kd_aset80','=',3],
								['kiba.kd_aset81','=',1],
								['kibas.pemanfaatan','like','"%Pemkab Bojonegoro%"']
								])
						->count();
			$tanahidle = DB::table('kibas')->leftjoin(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
						->select('kibas.idpemda as count')
						->where([
								['kiba.kd_bidang','=',$kdbidang],
								['kiba.kd_unit','=',$kdunit],
								['kiba.kd_sub','=',$kdsub],
								['kiba.kd_hapus','=',0],
								['kiba.kd_pemilik','=',12],
								['kiba.kd_aset8','=',1],
								['kiba.kd_aset80','=',3],
								['kiba.kd_aset81','=',1],
								['kibas.pemanfaatan','like','%idle%']
								])
						->count();

		}

		if(Module::hasAccess($module->id)) {
				 return View('la.kibas.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module,
				'sertcount' => $sertcount,
				'tanah' => $tanah,
				'tanahpemkab' => $tanahpemkab,
				'tanahpemkabblmsert' => $tanahpemkabblmsert,
				'tanahpemkabsdhsert'=> $tanahpemkabsdhsert,
				'tanahnonpemkab' => $tanahnonpemkab,
				'tanahnilai1' => $tanahnilai1,
				'tanahnilai0' => $tanahnilai0,
				'sertempty' => $sertempty,
				'sertnotempty' => $sertnotempty,
				'tanahhapus' => $tanahhapus,
				'tanahbeli' => $tanahbeli,
				'tanahhibah' => $tanahhibah,
				'sertupload' => $sertupload,
				'sertnotupload' => $sertnotupload,
				'tanahnilai1beli' => $tanahnilai1beli,
				'tanahnilai1hibah' => $tanahnilai1hibah,
				'tanahnilai0beli' => $tanahnilai0beli,
				'tanahnilai0hibah' => $tanahnilai0hibah,
				'tanahnilai0tkd' => $tanahnilai0tkd,
				'tanahpinjam' => $tanahpinjam,
				'tanahkantor' => $tanahkantor,
				'tanahidle' => $tanahidle,
				'refbidang' => $refbidang
			]);

		} else {
           return view('errors.404');
        }
	}

	public function chart(){
		//$module = Module::get('Kibas');
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$kdsub = Module::kdopd()->kd_sub;
		$kdupb = Module::kdopd()->kd_upb;

		if($kdbidang == 99 || $kdbidang == 0 ){
			$refbidang = Module::populatebidangadmin()->get();
			$sertcount = DB::table(Module::bmd().'.Ref_Sub_Unit as dept')->leftjoin(Module::bmd().'.Ta_KIB_A as kiba',function ($join) {
									$join->on('dept.kd_bidang','=','kiba.kd_bidang')
											->on('dept.kd_unit','=','kiba.kd_unit')
											->on('dept.kd_sub','=','kiba.kd_sub');
									}
								)
					->join('kibas','kibas.idpemda','=','kiba.IDPemda')
					->leftjoin(DB::raw('(SELECT COUNT(kiba.idpemda) as tanahpemkabs,dept.kd_bidang,dept.kd_unit,dept.kd_sub FROM
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_A as kiba
												on dept.kd_bidang = kiba.kd_bidang and
													dept.kd_unit = kiba.kd_unit and
													dept.kd_sub = kiba.kd_sub join
													kibas on kibas.idpemda = kiba.idpemda
												WHERE
												kiba.kd_pemilik = 12 and
												kiba.kd_hapus = 0

												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.name)tanahpemkab'),
												function ($joins){
												$joins->on('tanahpemkab.kd_bidang','=','dept.kd_bidang')
														->on('tanahpemkab.kd_unit','=','dept.kd_unit')
														->on('tanahpemkab.kd_sub','=','dept.kd_sub');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kiba.idpemda) as tanahnonpemkabs,dept.kd_bidang,dept.kd_unit,dept.kd_sub FROM
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_A as kiba
												on dept.kd_bidang = kiba.kd_bidang and
													dept.kd_unit = kiba.kd_unit and
													dept.kd_sub = kiba.kd_sub join
													kibas on kibas.idpemda = kiba.idpemda
												WHERE
												kiba.kd_pemilik = 13 and
												kiba.kd_hapus = 0

												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.name)tanahnonpemkab'),
												function ($joins){
												$joins->on('tanahnonpemkab.kd_bidang','=','dept.kd_bidang')
														->on('tanahnonpemkab.kd_unit','=','dept.kd_unit')
														->on('tanahnonpemkab.kd_sub','=','dept.kd_sub');
											}
								)
					->select([
							'dept.nm_sub_unit as name',
										DB::raw('ISNULL(tanahpemkab.tanahpemkabs,0) as tanahpemkab'),
										DB::raw('ISNULL(tanahnonpemkab.tanahnonpemkabs,0) as tanahnonpemkab'),
							])
					->where([
							 ['kiba.kd_aset8','=',1],
							 ['kiba.kd_aset80','=',3],
							 ['kiba.kd_aset81','=',1]
							 ])
					->groupBy('dept.kd_bidang','dept.kd_unit','dept.kd_sub','dept.nm_sub_unit',
								'tanahpemkab.tanahpemkabs','tanahnonpemkab.tanahnonpemkabs')
					->orderBy('dept.kd_bidang','ASC')
					->orderBy('dept.kd_unit','ASC')
					->orderBy('dept.kd_sub','ASC')
					->get();

		}else{
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$kdsub = Module::kdopd()->kd_sub;
		$kdupb = Module::kdopd()->kd_upb;

		$refbidang = Module::populatebidanguser()->get();
					$sertcount = DB::table(Module::bmd().'.Ref_Sub_Unit as dept')->join(Module::bmd().'.Ta_KIB_A as kiba',function ($join) {
									$join->on('dept.kd_bidang','=','kiba.kd_bidang')
											->on('dept.kd_unit','=','kiba.kd_unit')
											->on('dept.kd_sub','=','kiba.kd_sub');
									}
								)
					->join('kibas','kibas.idpemda','=','kiba.IDPemda')
					->leftjoin('uploads as uploadsert','uploadsert.id','=','kibas.sert_file')
					->leftjoin('uploads as uploadfoto','uploadfoto.id','=','kibas.photo_tanah')
					->join(DB::raw('(SELECT COUNT(kiba.idpemda) as tanahpemkabs,dept.kd_bidang,dept.kd_unit,dept.kd_sub FROM
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_A as kiba
												on dept.kd_bidang = kiba.kd_bidang and
													dept.kd_unit = kiba.kd_unit and
													dept.kd_sub = kiba.kd_sub join
													kibas on kibas.idpemda = kiba.idpemda
												WHERE
												kiba.kd_pemilik = 12 and
												kiba.kd_hapus = 0

												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.name)tanahpemkab'),
												function ($joins){
												$joins->on('tanahpemkab.kd_bidang','=','dept.kd_bidang')
														->on('tanahpemkab.kd_unit','=','dept.kd_unit')
														->on('tanahpemkab.kd_sub','=','dept.kd_sub');
											}
								)
					->leftjoin(DB::raw('(SELECT COUNT(kiba.idpemda) as tanahnonpemkabs,dept.kd_bidang,dept.kd_unit,dept.kd_sub FROM
												departments as dept left join
												'.Module::bmd().'.Ta_KIB_A as kiba
												on dept.kd_bidang = kiba.kd_bidang and
													dept.kd_unit = kiba.kd_unit and
													dept.kd_sub = kiba.kd_sub join
													kibas on kibas.idpemda = kiba.idpemda
												WHERE
												kiba.kd_pemilik = 13 and
												kiba.kd_hapus = 0

												group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.name)tanahnonpemkab'),
												function ($joins){
												$joins->on('tanahnonpemkab.kd_bidang','=','dept.kd_bidang')
														->on('tanahnonpemkab.kd_unit','=','dept.kd_unit')
														->on('tanahnonpemkab.kd_sub','=','dept.kd_sub');
											}
								)

					->select([
					'dept.nm_sub_unit as name',
										DB::raw('ISNULL(tanahpemkab.tanahpemkabs,0) as tanahpemkab'),
										DB::raw('ISNULL(tanahnonpemkab.tanahnonpemkabs,0) as tanahnonpemkab'),
							])
					->where([
							 ['kiba.kd_bidang','=',$kdbidang],
							 ['kiba.kd_unit','=',$kdunit],
							 ['kiba.kd_sub','=',$kdsub],
							 ['kiba.kd_aset8','=',1],
							 ['kiba.kd_aset80','=',3],
							 ['kiba.kd_aset81','=',1]
							 ])
					->groupBy('dept.kd_bidang','dept.kd_unit','dept.kd_sub','dept.nm_sub_unit',
								'tanahpemkab.tanahpemkabs','tanahnonpemkab.tanahnonpemkabs')
					->orderBy('dept.kd_bidang','ASC')
					->orderBy('dept.kd_unit','ASC')
					->orderBy('dept.kd_sub','ASC')
					->get();
		}
		return response()->json(['data' => $sertcount]);
	}

	public function loadDataTanahadmin(Request $request,$kdbidangs,$kdunits,$kdsubs){
	if(Module::hasAccess("Kibas", "view")) {

			$kdbidang = Module::kdopd()->kd_bidang;
			//$data = Module::tanahadmin($kdbidangs,$kdunits,$kdsubs)->get();
			//dd($data);
			if ($request->ajax()) {
					$output = '';
					$query = $request->get('query');
					if ($query != '') {
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::tanahadminquery($query)->get();
						}else{
							$data = Module::tanahuserquery($query)->get();
						}
					} else {
						if($kdbidang == 99 || $kdbidang == 0 ){
							//$data = Module::tanah()->take(10)->get();
							$data = Module::tanahadmin($kdbidangs,$kdunits,$kdsubs)->get();
							//dd($data);
						}else{

							$kdunit = Module::kdopd()->kd_unit;
							$kdsub = Module::kdopd()->kd_sub;
							$kdupb = Module::kdopd()->kd_upb;
							$data = Module::tanahuser($kdbidang,$kdunit,$kdsub,$kdupb)->get();
						}
					}
					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index=> $row){
						    $index = $index+1;
						   if(Module::hasAccess("Kibas", "edit")){
							$output .= '
							<tr>
							 <td>'.$index.'</td>
							<td><a target="_blank" href="'.url(config('laraadmin.adminRoute') . '/kibas/'.$row->id).'">'.$row->Dept.'</td>
							 <td style="text-align:center;">'.$row->No_Register.'</td>
							 <td style="text-align:center;">'.$row->luas_m2.'</td>
							 <td style="text-align:center;">'.$row->hak_tanah.'</td>
							 <td style="text-align:center;">'.(($row->Sertifikat_tanggal== 'NULL' OR $row->Sertifikat_tanggal == '') ? '-' : date('d-m-Y', strtotime($row->Sertifikat_tanggal))).'</td>
							 <td style="text-align:center;">'.$row->Sertifikat_Nomor.'</td>
							 <td>'.$row->alamat.'</td>
							 <td style="text-align:center;">'.date('d-m-Y', strtotime($row->tgl_perolehan)).'</td>
							 <td style="text-align:center;">'.date('Y', strtotime($row->tgl_perolehan)).'</td>
							 <td>'.$row->penggunaan.'</td>
							 <td style="text-align:center;">'.$row->harga.'</td>
							 <td style="text-align:center;"><a href="'.url('/files/'.$row->hashsert).'/'.$row->sert_file.'">'.(($row->idsert== '' OR $row->idsert == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td style="text-align:center;"><a href="'.url('/files/'.$row->hashphoto).'/'.$row->photo_tanah.'">'.(($row->idphoto== '' OR $row->idphoto == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td style="text-align:center;">'.$row->rack_no.'</td>
							 <td style="text-align:center;">'.$row->storage_name.'</td>
							 <td>'.$row->pemanfaatan.'</td>
							 <td style="text-align:center;">'.(($row->vrf_status == ''  OR $row->vrf_status == 0) ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-primary btn-xs">').'</a></td>
							 <td style="text-align:center;">
							 <a href="'.url(config('laraadmin.adminRoute') . '/print/'.$row->id).'" class="btn btn-outline-info btn-xs" style="display:inline;padding:2px 5px 3px 5px;" target="_blank"><i class="fa fa-print"></i></a>'
							 .(($row->vrf_status == ''  OR $row->vrf_status == 0) ?
							 '<a href="'.url(config('laraadmin.adminRoute') . '/kibas/'.$row->id.'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>':
							 '<a href="#" class="btn btn-info btn-sm" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-check"></i></a>').
							  '<div class="form-check form-check-inline">
								<input id="chkbox1" type="checkbox" name="ids" value="'.$row->IDPemda.'" rel="searchsolos"/>
								<label class="form-check-label" for="inlineCheckbox2"><i class="fa fa-print"></i></label>
							  </div>
							 </td>
							 <td style="text-align:center;">
								<div class="form-check form-check-inline">'
							.(($kdbidang == 99 OR $kdbidang == 0) ?
								'<button id = "'.$row->id.'" class="btn btn-primary btn-xs" type="button" onclick = "getvrfValue(this.id);"><i class="fa fa-thumbs-up"></i></button>
								<button id = "'.$row->idkiba.'" class="btn btn-danger btn-xs" type="button" onclick = "getreleaseValue(this.id);"><i class="fa fa-thumbs-down"></i></button>'
								:
								'<label class="form-check-label" for="inlineCheckbox2">Not Authorize</label>').

								'</div>
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

	public function loadDataTanah(Request $request){
	if(Module::hasAccess("Kibas", "view")) {
				$kdbidang = Module::kdopd()->kd_bidang;
				$kdunit = Module::kdopd()->kd_unit;
				$kdsub = Module::kdopd()->kd_sub;
				$kdupb = Module::kdopd()->kd_upb;
			//dd($request->ajax());
			if ($request->ajax()) {
					$output = '';
					$query = $request->get('query');
					if ($query != '') {
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::tanahadminquery($query)->get();
						}else{
							$data = Module::tanahuserquery($query)->get();
						}
					} else {
						if($kdbidang == 99 || $kdbidang == 0 ){
							$data = Module::tanah()->take(10)->get();
							//$data = Module::tanahadmin($kdbidangss,$kdunitss,$kdsubss)->get();
						}else{
							$data = Module::tanahuser()->take(10)->get();
						}
					}
					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index=> $row){
						    $index = $index+1;
						   if(Module::hasAccess("Kibas", "edit")){
							$output .= '
							<tr>
							 <td>'.$index.'</td>
							 <td><a target="_blank" href="'.url(config('laraadmin.adminRoute') . '/kibas/'.$row->id).'">'.$row->Dept.'</td>
							 <td>'.$row->No_Register.'</td>
							 <td>'.$row->luas_m2.'</td>
							 <td>'.$row->hak_tanah.'</td>
							 <td>'.(($row->Sertifikat_tanggal== 'NULL' OR $row->Sertifikat_tanggal == '') ? '-' : date('d-m-Y', strtotime($row->Sertifikat_tanggal))).'</td>
							 <td>'.$row->Sertifikat_Nomor.'</td>
							 <td>'.$row->alamat.'</td>
							 <td>'.date('d-m-Y', strtotime($row->tgl_perolehan)).'</td>
							 <td>'.date('Y', strtotime($row->tgl_perolehan)).'</td>
							 <td>'.$row->penggunaan.'</td>
							 <td>'.$row->harga.'</td>
							 <td><a href="'.url('/files/'.$row->hashsert).'/'.$row->sert_file.'">'.(($row->idsert== '' OR $row->idsert == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td><a href="'.url('/files/'.$row->hashphoto).'/'.$row->photo_tanah.'">'.(($row->idphoto== '' OR $row->idphoto == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">').'</a></td>
							 <td>'.$row->rack_no.'</td>
							 <td>'.$row->storage_name.'</td>
							 <td>'.$row->pemanfaatan.'</td>
							 <td>'.(($row->vrf_status == ''  OR $row->vrf_status == 0) ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-primary btn-xs">').'</a></td>
							 <td>
							 <a href="'.url(config('laraadmin.adminRoute') . '/print/'.$row->id).'" class="btn btn-outline-info btn-xs" style="display:inline;padding:2px 5px 3px 5px;" target="_blank"><i class="fa fa-print"></i></a>

							 <a href="'.url(config('laraadmin.adminRoute') . '/kibas/'.$row->id.'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>
							  <div class="form-check form-check-inline">
								<input id="chkbox1" type="checkbox" name="ids" value="'.$row->IDPemda.'" rel="searchsolos"/>
								<label class="form-check-label" for="inlineCheckbox2"><i class="fa fa-print"></i></label>
							  </div>
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

	/**
	 * Show the form for creating a new kiba.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created kiba in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if(Module::hasAccess("Kibas", "create")) {

			$rules = Module::validateRules("Kibas", $request);

			$validator = Validator::make($request->all(), $rules);

			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();
			}

			$insert_id = Module::insert("Kibas", $request);

			return redirect()->route(config('laraadmin.adminRoute') . '.kibas.index');

		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Display the specified kiba.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id){
		$kdbidang = Module::kdopd()->kd_bidang;
		$kdunit = Module::kdopd()->kd_unit;
		$kiba = Kiba::findOrFail($id);
		//$cekuser = Module::showkendaraanuser($id)->get();

		try {
		  if(Module::hasAccess("Kibas", "view")) {

				if($kdbidang == 99 || $kdbidang == 0 ){
					$kibas = Module::showtanahadmin($id)->get();
				}else{
					$kibas = Module::showtanahuser($id)->get();
				}

				if(!empty($kibas)) {
					$module = Module::get('kibas');
					$module->row = $kiba;
					//dd($kendaraan->kd_bidang);
					//dd($kendaraans);
					return view('la.kibas.show', [
						'module' => $module,
						'kibas' => $kibas,
						'view_col' => $this->view_col,
						'no_header' => true,
						'no_padding' => "no-padding"
					])->with('kiba', $kiba);
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
	 * Show the form for editing the specified kiba.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		if(Module::hasAccess("Kibas", "edit")) {
			$kiba = Kiba::find($id);
			if(isset($kiba->id)) {
				$module = Module::get('Kibas');

				$module->row = $kiba;

				return view('la.kibas.edit', [
					'module' => $module,
					'view_col' => $this->view_col,
				])->with('kiba', $kiba);
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("kiba"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Update the specified kiba in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id){
		if(Module::hasAccess("Kibas", "edit")) {

			//$cek = Kiba::find($id);
			$rules = Module::validateRules("Kibas", $request, true);

			$validator = Validator::make($request->all(), $rules);
			//dd($cek->geo);
			if ($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput();;
			}

			$insert_id = Module::updateRow("Kibas", $request, $id);

			return redirect(config('laraadmin.adminRoute') .'/kibas#lists');

		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}

	/**
	 * Remove the specified kiba from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if(Module::hasAccess("Kibas", "delete")) {
			Kiba::find($id)->delete();

			// Redirecting to index() method
			return redirect()->route(config('laraadmin.adminRoute') . '.kibas.index');
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

			$values = DB::table('kibas')->leftjoin(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
				->leftjoin('racks','racks.id','=','kibas.rack_no')
				->leftjoin('storages','storages.id','=','racks.storage')
				->leftjoin('uploads as uploadsert','uploadsert.id','=','kibas.sert_file')
				->leftjoin('uploads as uploadphoto','uploadphoto.id','=','kibas.photo_tanah')
				->leftjoin('departments as dept', function ($join) {
									$join->on('dept.kd_bidang','=','kiba.kd_bidang')
											->on('dept.kd_unit','=','kiba.kd_unit')
											->on('dept.kd_sub','=','kiba.kd_sub')
											->on('dept.kd_upb','=','kiba.kd_upb');
								}
							)
				->select('kibas.id','dept.name as Dept','kibas.IDPemda','kiba.No_Register','kiba.luas_m2','kiba.Sertifikat_Nomor',
				'kiba.hak_tanah','kiba.sertifikat_tanggal','kiba.alamat','kiba.tgl_perolehan',
				'uploadsert.name as sert_file','uploadphoto.name as photoname',
				'kibas.rack_no','storages.storage_name','kibas.vrf_status','kibas.vrf_by','kibas.vrf_at')
				->where([['kiba.kd_hapus','=',0],
						['kiba.kd_pemilik','=',12]
						]);
		}else{

			$values = DB::table('kibas')->leftjoin(Module::bmd().'.Ta_KIB_A as kiba','kibas.idpemda','=','kiba.IDPemda')
				->leftjoin('racks','racks.id','=','kibas.rack_no')
				->leftjoin('storages','storages.id','=','racks.storage')
				->leftjoin('uploads as uploadsert','uploadsert.id','=','kibas.sert_file')
				->leftjoin('uploads as uploadphoto','uploadphoto.id','=','kibas.photo_tanah')
				->leftjoin('departments as dept', function ($join) {
									$join->on('dept.kd_bidang','=','kiba.kd_bidang')
											->on('dept.kd_unit','=','kiba.kd_unit')
											->on('dept.kd_sub','=','kiba.kd_sub')
											->on('dept.kd_upb','=','kiba.kd_upb');
								}
							)
				->select('kibas.id','dept.name as Dept','kibas.IDPemda','kiba.No_Register','kiba.luas_m2','kiba.Sertifikat_Nomor',
				'kiba.hak_tanah','kiba.sertifikat_tanggal','kiba.alamat','kiba.tgl_perolehan',
				'uploadsert.name as sert_file','uploadphoto.name as photoname',
				'kibas.rack_no','storages.storage_name','kibas.vrf_status','kibas.vrf_by','kibas.vrf_at')
				->where([['kiba.kd_hapus','=',0],
						['kiba.kd_pemilik','=',12],
						['kiba.kd_bidang','=',$kdbidang],
						['kiba.kd_unit','=',$kdunit]
						]);
		}
		$out = Datatables::of($values)->make();
		$data = $out->getData();

		$fields_popup = ModuleFields::getModuleFields('Kibas');

		for($i=0; $i < count($data->data); $i++) {
			for ($j=0; $j < count($this->listing_cols); $j++) {
				$col = $this->listing_cols[$j];
				if($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
					$data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
				}
				if($col == $this->view_col) {
					$data->data[$i][$j] = '<a href="'.url(config('laraadmin.adminRoute') . '/kibas/'.$data->data[$i][0]).'">'.$data->data[$i][$j].'</a>';
				}
			}

			if($this->show_action) {
				$output = '';
				if(Module::hasAccess("Kibas", "edit")) {
					$output .= '<a href="'.url(config('laraadmin.adminRoute') . '/kibas/'.$data->data[$i][0].'/edit').'" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
				}

				if(Module::hasAccess("Kibas", "delete")) {
					$output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.kibas.destroy', $data->data[$i][0]], 'method' => 'delete', 'style'=>'display:inline']);
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
