<?php

/**
 * Controller genrated using LaraAdmin
 * Help: http://laraadmin.com.
 */

namespace App\Http\Controllers\LA;

use App\Http\Controllers\Controller;
use Collective\Html\FormFacade as Form;
use Datatables;
use DB;
use Dwij\Laraadmin\Models\Module;
use Dwij\Laraadmin\Models\ModuleFields;
use App\Models\Image_kib;
use Illuminate\Http\Request;
use PDF;
use Validator;
use Auth;
use App\Models\Kibc_;

class Kibc_sController extends Controller
{
    public $show_action = true;
    public $view_col = 'idpemdas';
    public $listing_cols = [
        'id', 'idpemdas', 'koordx', 'koordy', 'tgl_perolehan', 'dokumen_tanggal', 'dokumen_nomor', 'lokasi_tanah', 'lokasi', 'status_tanah', 'kd_bidang', 'kd_sub', 'kd_unit', 'kd_upb', 'no_register', 'upload_dok_imb', 'photo_gedung', 'pemanfaatan',
        'tgl_awal_imb', 'tgl_akhir_imb', 'no_imb_baru', 'no_imb_lama', 'imgid', 'tanah'
    ];

    public function __construct()
    {
        /* Field Access of Listing Columns /* //-------^^^^-------\\ */
        if (\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
            $this->middleware(function ($request, $next) {
                $this->listing_cols = ModuleFields::listingColumnAccessScan('Kibc_s', $this->listing_cols);

                return $next($request);
            });
        } else {
            $this->listing_cols = ModuleFields::listingColumnAccessScan('Kibc_s', $this->listing_cols);
        }
    }
    /*Print Kiball*/
    public function printkibball($kdbidangs, $kdunits, $kdsubs)
    {
        $kdbidang = Module::kdopd()->kd_bidang;
        //$idrek0  = (int)$ids;
        //$idrek1  = (int)$idss;
        //$idrek3  = (int)$ids3;
        //$idrek4  = (int)$ids4;
        //$konds  = (int)$kond;

        if (Module::hasAccess("Kibc_s", "view")) {

            if ($kdbidang == 99 || $kdbidang == 0) {
                $kibcitem = Module::kibcall($kdbidangs, $kdunits, $kdsubs, $ids, $idss, $ids3, $ids4, $kond);
                $kibcitemarray = json_decode(json_encode($kibcitem[0]), true);
                //dd($kibbitem);
                $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'isJavascriptEnabled', true])
                    ->loadView('la.report.printkibcall', ['kibcitem' => $kibcitem])
                    ->setPaper('folio', 'landscape');
                return $pdf->download('KIB-PM' . Module::userlogin()->dept_name . '.pdf');
                //return view('la.report.printkibball',['kibbitem' => $kibbitem]);
            } else {
                $kdunit = Module::kdopd()->kd_unit;
                $kdsub = Module::kdopd()->kd_sub;
                $kibcitem = Module::kibball($kdbidang, $kdunit, $kdsub, $ids, $idss, $ids3, $ids4, $kond);
                $kibcitemarray = json_decode(json_encode($kibcitem[0]), true);
                $pdf = PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true, 'isJavascriptEnabled', true])
                    ->loadView('la.report.printkibball', ['kibcitem' => $kibcitem])
                    ->setPaper('folio', 'landscape');
                return $pdf->download('KIB-PM' . Module::userlogin()->dept_name . '.pdf');
                //return view('la.report.printkibball',['kibbitem' => $kibbitem]);
            }
        } else {
            return view(abort(403, 'Unauthorized action.'));
        }
    }
    /*end print kiball*/
    /* end print*/
    /*Pilihan 09/09/2021*/
    public function unit($ids)
    {

        $kdbidang = Module::kdopd()->kd_bidang;
        $kdunit = Module::kdopd()->kd_unit;
        $kdsub = Module::kdopd()->kd_sub;
        $kdupb = Module::kdopd()->kd_upb;

        if ($kdbidang == 99 || $kdbidang == 0) {
            $unit = Module::populateunitadmin($ids)->pluck('nm_unit', 'kd_unit');
            return json_encode($unit);
        } else {
            $unit = Module::populateunituser($kdbidang)->pluck('nm_unit', 'kd_unit');
            //dd($unit->get());
            return json_encode($unit);
        }
    }
    public function sub($ids, $idss)
    {
        $kdbidang = Module::kdopd()->kd_bidang;
        $kdunit = Module::kdopd()->kd_unit;
        $kdsub = Module::kdopd()->kd_sub;
        $kdupb = Module::kdopd()->kd_upb;

        if ($kdbidang == 99 || $kdbidang == 0) {
            $sub = Module::populatesubadmin($ids, $idss)->pluck('nm_sub_unit', 'kd_sub');
            return json_encode($sub);
        } else {
            $sub = Module::populatesubuser($kdbidang, $kdunit)->pluck('nm_sub_unit', 'kd_sub');
            return json_encode($sub);
        }
    }
    public function upb($ids, $idss, $idsss)
    {
        $kdbidang = Module::kdopd()->kd_bidang;
        $kdunit = Module::kdopd()->kd_unit;
        $kdsub = Module::kdopd()->kd_sub;
        $kdupb = Module::kdopd()->kd_upb;

        if ($kdbidang == 99 || $kdbidang == 0) {
            $upb = Module::populateupbadmin($ids, $idss, $idsss)->pluck('Nm_UPB', 'kd_upb');
            return json_encode($upb);
        } else {
            $upb = Module::populateupbuser($kdbidang, $kdunit, $kdsub)->pluck('Nm_UPB', 'kd_upb');
            return json_encode($upb);
        }
    }
    /*End pilihan*/

    /**
     * Display a listing of the Kibcs.
     * By Ihsn.
     *
     * @return \Illuminate\Http\Response
     */

    ///index kibc\
    public function index()
    {
        //index untuk count data gedung

        $module = Module::get('Kibc_s');
        $kdbidang = Module::kdopd()->kd_bidang;
        $kdunit = Module::kdopd()->kd_unit;
        $kdsub = Module::kdopd()->kd_sub;
        $kdupb = Module::kdopd()->kd_upb;
        ///Untuk Admin
        if ($kdbidang == 99 || $kdbidang == 0) {
            $gambar = Module::kibcadminall()->get();
            $refbidang = Module::populatebidangadmin()->get();
            $gedungcount = DB::table('departments as dept')
                ->leftjoin(
                    Module::bmd() . '.Ta_KIB_C as kibc',
                    function ($join) {
                        $join->on('dept.kd_bidang', '=', 'kibc.kd_bidang')
                            ->on('dept.kd_unit', '=', 'kibc.kd_unit')
                            ->on('dept.kd_sub', '=', 'kibc.kd_sub')
                            ->on('dept.kd_upb', '=', 'kibc.kd_upb');
                    }
                )
                ->leftjoin('kibc_s', 'kibc_s.idpemdas', '=', 'kibc.idpemda')
                //->leftjoin('uploads as uploaddokumen', 'uploaddokumen.id', '=', 'kibc_s.upload_dok_imb')
                ->leftjoin('image_kibs as uploadphoto', 'kibc_s.imgid', '=', 'uploadphoto.id')
                ->leftjoin(
                    DB::raw('(SELECT COUNT(kibc.idpemda) as gedungs,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
        departments as dept left join
        ' . Module::bmd() . '.Ta_KIB_C as kibc
        on dept.kd_bidang = kibc.kd_bidang and
        dept.kd_unit = kibc.kd_unit and
        dept.kd_sub = kibc.kd_sub and
        dept.kd_upb = kibc.kd_upb left join
        kibc_s on kibc_s.idpemdas = kibc.idpemda
        WHERE 
        kibc.kd_pemilik = 12 and
        kibc.kd_hapus = 0 

        group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name) gedung'),
                    function ($joins) {
                        $joins->on('gedung.kd_bidang', '=', 'dept.kd_bidang')
                            ->on('gedung.kd_unit', '=', 'dept.kd_unit')
                            ->on('gedung.kd_sub', '=', 'dept.kd_sub')
                            ->on('gedung.kd_upb', '=', 'dept.kd_upb');
                    }
                )
                ->leftjoin(
                    DB::raw('(SELECT COUNT(kibc.idpemda) as dokumendiisi,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
        departments as dept left join
        ' . Module::bmd() . '.Ta_KIB_C as kibc 
        on dept.kd_bidang = kibc.kd_bidang and
        dept.kd_unit = kibc.kd_unit and
        dept.kd_sub = kibc.kd_sub and
        dept.kd_upb = kibc.kd_upb left join
        kibc_s on kibc_s.idpemdas = kibc.idpemda
        WHERE 
        kibc.dokumen_nomor is not null

        group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)dokumenisi'),
                    function ($joins) {
                        $joins->on('dokumenisi.kd_bidang', '=', 'dept.kd_bidang')
                            ->on('dokumenisi.kd_unit', '=', 'dept.kd_unit')
                            ->on('dokumenisi.kd_sub', '=', 'dept.kd_sub')
                            ->on('dokumenisi.kd_upb', '=', 'dept.kd_upb');
                    }
                )

                ->leftjoin(
                    DB::raw('(SELECT COUNT(kibc.idpemda) as dokumennotdiisi,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
        departments as dept left join
        ' . Module::bmd() . '.Ta_KIB_C as kibc 
        on dept.kd_bidang = kibc.kd_bidang and
        dept.kd_unit = kibc.kd_unit and
        dept.kd_sub = kibc.kd_sub and
        dept.kd_upb = kibc.kd_upb left join
        kibc_s on kibc_s.idpemdas = kibc.idpemda
        WHERE 
        kibc.dokumen_nomor is  null

        group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)dokumennotisi'),
                    function ($joins) {
                        $joins->on('dokumennotisi.kd_bidang', '=', 'dept.kd_bidang')
                            ->on('dokumennotisi.kd_unit', '=', 'dept.kd_unit')
                            ->on('dokumennotisi.kd_sub', '=', 'dept.kd_sub')
                            ->on('dokumennotisi.kd_upb', '=', 'dept.kd_upb');
                    }
                )
                ->leftjoin(
                    DB::raw('(SELECT COUNT(kibc.idpemda) as tgldokdiisi,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
        departments as dept left join
        ' . Module::bmd() . '.Ta_KIB_C as kibc 
        on dept.kd_bidang = kibc.kd_bidang and
        dept.kd_unit = kibc.kd_unit and
        dept.kd_sub = kibc.kd_sub and
        dept.kd_upb = kibc.kd_upb left join
        kibc_s on kibc_s.idpemdas = kibc.idpemda
        WHERE 
        kibc.dokumen_tanggal is not null

        group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)tgldokisi'),
                    function ($joins) {
                        $joins->on('tgldokisi.kd_bidang', '=', 'dept.kd_bidang')
                            ->on('tgldokisi.kd_unit', '=', 'dept.kd_unit')
                            ->on('tgldokisi.kd_sub', '=', 'dept.kd_sub')
                            ->on('tgldokisi.kd_upb', '=', 'dept.kd_upb');
                    }
                )
                ->leftjoin(
                    DB::raw('(SELECT COUNT(kibc.idpemda) as tgldoknotdiisi,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
        departments as dept left join
        ' . Module::bmd() . '.Ta_KIB_C as kibc 
        on dept.kd_bidang = kibc.kd_bidang and
        dept.kd_unit = kibc.kd_unit and
        dept.kd_sub = kibc.kd_sub and
        dept.kd_upb = kibc.kd_upb left join
        kibc_s on kibc_s.idpemdas = kibc.idpemda
        WHERE 
        kibc.dokumen_tanggal is null

        group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)tgldoknotisi'),
                    function ($joins) {
                        $joins->on('tgldoknotisi.kd_bidang', '=', 'dept.kd_bidang')
                            ->on('tgldoknotisi.kd_unit', '=', 'dept.kd_unit')
                            ->on('tgldoknotisi.kd_sub', '=', 'dept.kd_sub')
                            ->on('tgldoknotisi.kd_upb', '=', 'dept.kd_upb');
                    }
                )
                ->leftjoin(
                    DB::raw('(SELECT COUNT(kibc.idpemda) as imbdiisi,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
        departments as dept left join
        ' . Module::bmd() . '.Ta_KIB_C as kibc 
        on dept.kd_bidang = kibc.kd_bidang and
        dept.kd_unit = kibc.kd_unit and
        dept.kd_sub = kibc.kd_sub and
        dept.kd_upb = kibc.kd_upb left join
        kibc_s on kibc_s.idpemdas = kibc.idpemda
        WHERE 
        kibc_s.upload_dok_imb is not null

        group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)imbisi'),
                    function ($joins) {
                        $joins->on('imbisi.kd_bidang', '=', 'dept.kd_bidang')
                            ->on('imbisi.kd_unit', '=', 'dept.kd_unit')
                            ->on('imbisi.kd_sub', '=', 'dept.kd_sub')
                            ->on('imbisi.kd_upb', '=', 'dept.kd_upb');
                    }
                )
                ->leftjoin(
                    DB::raw('(SELECT COUNT(kibc.idpemda) as fotodiisi,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
        departments as dept left join
        ' . Module::bmd() . '.Ta_KIB_C as kibc 
        on dept.kd_bidang = kibc.kd_bidang and
        dept.kd_unit = kibc.kd_unit and
        dept.kd_sub = kibc.kd_sub and
        dept.kd_upb = kibc.kd_upb left join
        kibc_s on kibc_s.idpemdas = kibc.idpemda
        WHERE 
        kibc_s.imgid is not null

        group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)fotoisi'),
                    function ($joins) {
                        $joins->on('fotoisi.kd_bidang', '=', 'dept.kd_bidang')
                            ->on('fotoisi.kd_unit', '=', 'dept.kd_unit')
                            ->on('fotoisi.kd_sub', '=', 'dept.kd_sub')
                            ->on('fotoisi.kd_upb', '=', 'dept.kd_upb');
                    }
                )
                ->select(
                    'dept.kd_bidang',
                    'dept.kd_unit',
                    'dept.kd_sub',
                    'dept.kd_upb',
                    'dept.name',
                    //DB::raw('ISNULL(ISNULL(roda2.rodadua,0) + ISNULL(roda4.rodaempat,0) + ISNULL(roda3.rodatiga,0) + ISNULL(penumpang.pnp,0) + ISNULL(barang.brg,0) + ISNULL(khusus.kh,0) + ISNULL(lainnya.lain,0),0) as kendaraantot'),
                    DB::raw('COUNT(kibc.idpemda) as gedungtot'),
                    DB::raw('ISNULL(gedung.gedungs,0) as gedung'),
                    DB::raw('ISNULL(dokumenisi.dokumendiisi,0) as dokumenisi'),
                    DB::raw('ISNULL(dokumennotisi.dokumennotdiisi,0) as dokumennotisi'),
                    DB::raw('ISNULL(tgldokisi.tgldokdiisi,0) as tgldokisi'),
                    DB::raw('ISNULL(tgldoknotisi.tgldoknotdiisi,0) as tgldoknotisi'),
                    DB::raw('ISNULL(COUNT(kibc_s.upload_dok_imb),0) as imbisi'),
                    DB::raw('ISNULL(COUNT(kibc_s.imgid),0) as fotoisi')
                    //DB::raw('ISNULL(COUNT(kibcs.vrf_status) ,0) as vrfgeo')
                )
                ->where([
                    // ['kibc.kd_pemilik', '=', 12],
                    ['kibc.kd_aset8', '=', 1],
                    ['kibc.kd_aset80', '=', 3],
                    ['kibc.kd_aset81', '=', 3]
                ])
                ->groupBy(
                    'dept.kd_bidang',
                    'dept.kd_unit',
                    'dept.kd_sub',
                    'dept.kd_upb',
                    'dept.name',
                    'gedung.gedungs',
                    'dokumenisi.dokumendiisi',
                    'dokumennotisi.dokumennotdiisi',
                    'tgldokisi.tgldokdiisi',
                    'tgldoknotisi.tgldoknotdiisi'
                )
                ->orderBy('dept.kd_bidang', 'ASC')
                ->orderBy('dept.kd_unit', 'ASC')
                ->orderBy('dept.kd_sub', 'ASC')
                ->orderBy('dept.kd_upb', 'ASC')
                ->get();
            $gedung = DB::table('kibc_s')->leftjoin(Module::bmd() . '.Ta_KIB_C as kibc', 'kibc_s.idpemdas', '=', 'kibc.idpemda')
                ->select('kibc_s.idpemdas as count')
                ->where([
                    ['kibc.kd_kab_kota', '=', 16],
                    ['kibc.kd_aset8', '=', 1],
                    ['kibc.kd_aset80', '=', 3],
                    ['kibc.kd_aset81', '=', 3]
                ])
                ->count();
            $gedungbeli = DB::table('kibc_s')->leftjoin(Module::bmd() . '.Ta_KIB_C as kibc', 'kibc_s.idpemdas', '=', 'kibc.idpemda')
                ->select('kibc_s.idpemdas as count')
                ->where([
                    ['kibc.kd_kab_kota', '=', 16],
                    ['kibc.Asal_usul', '=', 'Pembelian'],
                    ['kibc.kd_aset8', '=', 1],
                    ['kibc.kd_aset80', '=', 3],
                    ['kibc.kd_aset81', '=', 3]
                ])
                ->count();
            $gedunghibah = DB::table('kibc_s')->leftjoin(Module::bmd() . '.Ta_KIB_C as kibc', 'kibc_s.idpemdas', '=', 'kibc.idpemda')
                ->select('kibc_s.idpemdas as count')
                ->where([
                    ['kibc.kd_kab_kota', '=', 16],
                    ['kibc.Asal_usul', '=', 'Hibah'],
                    ['kibc.kd_aset8', '=', 1],
                    ['kibc.kd_aset80', '=', 3],
                    ['kibc.kd_aset81', '=', 3]
                ])
                ->count();
            $gedungpinjam = DB::table('kibc_s')->leftjoin(Module::bmd() . '.Ta_KIB_C as kibc', 'kibc_s.idpemdas', '=', 'kibc.idpemda')
                ->select('kibc_s.idpemdas as count')
                ->where([
                    ['kibc.kd_kab_kota', '=', 16],
                    ['kibc.Asal_usul', '=', 'Pinjam'],
                    ['kibc.kd_aset8', '=', 1],
                    ['kibc.kd_aset80', '=', 3],
                    ['kibc.kd_aset81', '=', 3]
                ])
                ->count();
            $dokumenempty = DB::table('kibC_s')->leftjoin(Module::bmd() . '.Ta_KIB_C as kibC', 'kibc_s.idpemdas', '=', 'kibc.idpemda')
                ->select('kibc_s.idpemdas as count')
                ->whereNull('kibc.dokumen_nomor')
                //->whereNull('kibc.Sertifikat_Tanggal')
                ->where([
                    ['kibc.kd_kab_kota', '=', 16],
                    //['kibc.kd_pemilik','=',12],
                    ['kibc.kd_aset8', '=', 1],
                    ['kibc.kd_aset80', '=', 3],
                    ['kibc.kd_aset81', '=', 3]
                ])
                ->count();
            $dokumenupload = DB::table('kibC_s')->leftjoin(Module::bmd() . '.Ta_KIB_C as kibC', 'kibc_s.idpemdas', '=', 'kibc.idpemda')
                ->select('kibc_s.idpemdas as count')
                ->whereNotNull('kibc_s.upload_dok_imb')
                ->where([
                    ['kibc.kd_kab_kota', '=', 16],
                    //['kibc.kd_pemilik','=',12],
                    ['kibc.kd_aset8', '=', 1],
                    ['kibc.kd_aset80', '=', 3],
                    ['kibc.kd_aset81', '=', 3]
                ])
                ->count();
            $fotoupload = DB::table('kibC_s')->join(Module::bmd() . '.Ta_KIB_C as kibC', 'kibc_s.idpemdas', '=', 'kibc.idpemda')
                ->select('kibc_s.idpemda as count')
                ->whereNotNull('kibc_s.imgid')
                ->where([
                    ['kibc.kd_kab_kota', '=', 16],
                    ['kibc.kd_pemilik', '=', 12],
                    ['kibc.kd_aset8', '=', 1],
                    ['kibc.kd_aset80', '=', 3],
                    ['kibc.kd_aset81', '=', 3],
                    ['kibc.kd_bidang', '=', $kdbidang],
                    ['kibc.kd_unit', '=', $kdunit],
                    ['kibc.kd_sub', '=', $kdsub]
                ])
                ->count();
            $dokumennotempty = DB::table('kibC_s')->leftjoin(Module::bmd() . '.Ta_KIB_C as kibC', 'kibc_s.idpemdas', '=', 'kibc.IDPemda')
                ->select('kibc_s.idpemdas as count')
                ->whereNotNull('kibc.dokumen_nomor')
                //->whereNotNull('kibc.Sertifikat_Tanggal')
                ->where([
                    ['kibc.kd_kab_kota', '=', 16],
                    //['kibc.kd_pemilik','=',12],
                    ['kibc.kd_aset8', '=', 1],
                    ['kibc.kd_aset80', '=', 3],
                    ['kibc.kd_aset81', '=', 3]
                ])
                ->count();
            $gedungkantor = DB::table('kibc_s')->leftjoin(Module::bmd() . '.Ta_KIB_C as kibc', 'kibc_s.idpemdas', '=', 'kibc.idpemda')
                ->select('kibc_s.idpemdas as count')
                ->where([
                    ['kibc.kd_kab_kota', '=', 16],
                    ['kibc.kd_pemilik', '=', 12],
                    ['kibc.kd_aset8', '=', 1],
                    ['kibc.kd_aset80', '=', 3],
                    ['kibc.kd_aset81', '=', 3],
                    ['kibc.kd_aset84', '=', 1]
                ])
                ->count();
            $gedungidle = DB::table('kibc_s')->leftjoin(Module::bmd() . '.Ta_KIB_C as kibc', 'kibc_s.idpemdas', '=', 'kibc.idpemda')
                ->select('kibc_s.idpemdas as count')
                ->where([
                    ['kibc.kd_kab_kota', '=', 16],
                    ['kibc.kd_pemilik', '=', 12],
                    ['kibc.kd_aset8', '=', 1],
                    ['kibc.kd_aset80', '=', 3],
                    ['kibc.kd_aset81', '=', 3],
                    ['kibc_s.pemanfaatan', 'LIKE', '%Idle%']
                ])
                ->count();
            $gedungbaik = DB::table('kibc_s')->leftjoin(Module::bmd() . '.Ta_KIB_C as kibc', 'kibc_s.idpemdas', '=', 'kibc.idpemda')
                ->select('kibc_s.idpemdas as count')
                ->where([
                    //['kibc.kd_kab_kota', '=', 16],
                    ['kibc.kd_pemilik', '=', 12],
                    ['kibc.kondisi', '=', 1]
                ])
                ->count();
            $gedungrusak = DB::table('kibc_s')->leftjoin(Module::bmd() . '.Ta_KIB_C as kibc', 'kibc_s.idpemdas', '=', 'kibc.idpemda')
                ->select('kibc_s.idpemdas as count')
                ->where([
                    ['kibc.kd_kab_kota', '=', 16],
                    ['kibc.kd_pemilik', '=', 12],
                    ['kibc.kd_aset8', '=', 1],
                    ['kibc.kd_aset80', '=', 3],
                    ['kibc.kd_aset81', '=', 3],
                    ['kibc.kondisi', '=', 3]
                ])
                ->count();
        }
        //User non Admin
        else { //for User 
            $kdbidang = Module::kdopd()->kd_bidang;
            $kdsub = Module::kdopd()->kd_sub;
            $kdunit = Module::kdopd()->kd_unit;
            //$kdupb = Module::kdopd()->kd_upb;
            $refbidang = Module::populatebidanguser()->get();
            $gambar = Module::gbuser($kdbidang, $kdunit, $kdsub, $kdupb)->get();
            $gedungcount = DB::table('departments as dept')->leftjoin(
                Module::bmd() . '.Ta_KIB_C as kibc',
                function ($join) {
                    $join->on('dept.kd_bidang', '=', 'kibc.kd_bidang')
                        ->on('dept.kd_unit', '=', 'kibc.kd_unit')
                        ->on('dept.kd_sub', '=', 'kibc.kd_sub')
                        ->on('dept.kd_upb', '=', 'kibc.kd_upb');
                } //27.05.2021
            )
                ->leftjoin('kibc_s', 'kibc_s.idpemdas', '=', 'kibc.idpemda')
                //->leftjoin('uploads as uploaddokumen', 'uploaddokumen.id', '=', 'kibc_s.upload_dok_imb')
                ->leftjoin('image_kibs as uploadphoto', 'uploadphoto.id', '=', 'kibc_s.imgid')
                ->leftjoin(
                    DB::raw('(SELECT COUNT(kibc.idpemda) as gedungs,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
        departments as dept left join
        ' . Module::bmd() . '.Ta_KIB_C as kibc
        on dept.kd_bidang = kibc.kd_bidang and
        dept.kd_unit = kibc.kd_unit and
        dept.kd_sub = kibc.kd_sub and
        dept.kd_upb = kibc.kd_upb left join
        kibc_s on kibc_s.idpemdas = kibc.idpemda
        WHERE 
        kibc.kd_pemilik = 12 and
        kibc.kd_kab_kota = 16

        group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name) gedung'),
                    function ($joins) {
                        $joins->on('gedung.kd_bidang', '=', 'dept.kd_bidang')
                            ->on('gedung.kd_unit', '=', 'dept.kd_unit')
                            ->on('gedung.kd_sub', '=', 'dept.kd_sub')
                            ->on('gedung.kd_upb', '=', 'dept.kd_upb');
                    }
                )
                ->leftjoin(
                    DB::raw('(SELECT COUNT(kibc.idpemda) as dokumendiisi,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
        departments as dept left join
        ' . Module::bmd() . '.Ta_KIB_C as kibc 
        on dept.kd_bidang = kibc.kd_bidang and
        dept.kd_unit = kibc.kd_unit and
        dept.kd_sub = kibc.kd_sub and
        dept.kd_upb = kibc.kd_upb left join
        kibc_s on kibc_s.idpemdas = kibc.idpemda
        WHERE 
        kibc.dokumen_nomor is not null

        group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)dokumenisi'),
                    function ($joins) {
                        $joins->on('dokumenisi.kd_bidang', '=', 'dept.kd_bidang')
                            ->on('dokumenisi.kd_unit', '=', 'dept.kd_unit')
                            ->on('dokumenisi.kd_sub', '=', 'dept.kd_sub')
                            ->on('dokumenisi.kd_upb', '=', 'dept.kd_upb');
                    }
                )

                ->leftjoin(
                    DB::raw('(SELECT COUNT(kibc.idpemda) as dokumennotdiisi,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
        departments as dept left join
        ' . Module::bmd() . '.Ta_KIB_C as kibc 
        on dept.kd_bidang = kibc.kd_bidang and
        dept.kd_unit = kibc.kd_unit and
        dept.kd_sub = kibc.kd_sub and
        dept.kd_upb = kibc.kd_upb left join
        kibc_s on kibc_s.idpemdas = kibc.idpemda
        WHERE 
        kibc.dokumen_nomor is null

        group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)dokumennotisi'),
                    function ($joins) {
                        $joins->on('dokumennotisi.kd_bidang', '=', 'dept.kd_bidang')
                            ->on('dokumennotisi.kd_unit', '=', 'dept.kd_unit')
                            ->on('dokumennotisi.kd_sub', '=', 'dept.kd_sub')
                            ->on('dokumennotisi.kd_upb', '=', 'dept.kd_upb');
                    }
                )
                ->leftjoin(
                    DB::raw('(SELECT COUNT(kibc.idpemda) as tgldokdiisi,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
        departments as dept left join
        ' . Module::bmd() . '.Ta_KIB_C as kibc 
        on dept.kd_bidang = kibc.kd_bidang and
        dept.kd_unit = kibc.kd_unit and
        dept.kd_sub = kibc.kd_sub and
        dept.kd_upb = kibc.kd_upb left join
        kibc_s on kibc_s.idpemdas = kibc.idpemda
        WHERE 
        kibc.dokumen_tanggal is not null

        group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)tgldokisi'),
                    function ($joins) {
                        $joins->on('tgldokisi.kd_bidang', '=', 'dept.kd_bidang')
                            ->on('tgldokisi.kd_unit', '=', 'dept.kd_unit')
                            ->on('tgldokisi.kd_sub', '=', 'dept.kd_sub')
                            ->on('tgldokisi.kd_upb', '=', 'dept.kd_upb');
                    }
                )
                ->leftjoin(
                    DB::raw('(SELECT COUNT(kibc.idpemda) as tgldoknotdiisi,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
        departments as dept left join
        ' . Module::bmd() . '.Ta_KIB_C as kibc 
        on dept.kd_bidang = kibc.kd_bidang and
        dept.kd_unit = kibc.kd_unit and
        dept.kd_sub = kibc.kd_sub and
        dept.kd_upb = kibc.kd_upb left join
        kibc_s on kibc_s.idpemdas = kibc.idpemda
        WHERE 
        kibc.dokumen_tanggal is null

        group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)tgldoknotisi'),
                    function ($joins) {
                        $joins->on('tgldoknotisi.kd_bidang', '=', 'dept.kd_bidang')
                            ->on('tgldoknotisi.kd_unit', '=', 'dept.kd_unit')
                            ->on('tgldoknotisi.kd_sub', '=', 'dept.kd_sub')
                            ->on('tgldoknotisi.kd_upb', '=', 'dept.kd_upb');
                    }
                )
                ->leftjoin(
                    DB::raw('(SELECT COUNT(kibc.idpemda) as imbdiisi,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
        departments as dept left join
        ' . Module::bmd() . '.Ta_KIB_C as kibc 
        on dept.kd_bidang = kibc.kd_bidang and
        dept.kd_unit = kibc.kd_unit and
        dept.kd_sub = kibc.kd_sub and
        dept.kd_upb = kibc.kd_upb left join
        kibc_s on kibc_s.idpemdas = kibc.idpemda
        WHERE 
        kibc_s.upload_dok_imb is not null

        group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)imbisi'),
                    function ($joins) {
                        $joins->on('imbisi.kd_bidang', '=', 'dept.kd_bidang')
                            ->on('imbisi.kd_unit', '=', 'dept.kd_unit')
                            ->on('imbisi.kd_sub', '=', 'dept.kd_sub')
                            ->on('imbisi.kd_upb', '=', 'dept.kd_upb');
                    }
                )
                ->leftjoin(
                    DB::raw('(SELECT COUNT(kibc.idpemda) as fotodiisi,dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb FROM 
        departments as dept left join
        ' . Module::bmd() . '.Ta_KIB_C as kibc 
        on dept.kd_bidang = kibc.kd_bidang and
        dept.kd_unit = kibc.kd_unit and
        dept.kd_sub = kibc.kd_sub and
        dept.kd_upb = kibc.kd_upb left join
        kibc_s on kibc_s.idpemdas = kibc.idpemda
        WHERE 
        kibc_s.imgid is not null

        group by dept.kd_bidang,dept.kd_unit,dept.kd_sub,dept.kd_upb,dept.name)fotoisi'),
                    function ($joins) {
                        $joins->on('fotoisi.kd_bidang', '=', 'dept.kd_bidang')
                            ->on('fotoisi.kd_unit', '=', 'dept.kd_unit')
                            ->on('fotoisi.kd_sub', '=', 'dept.kd_sub')
                            ->on('fotoisi.kd_upb', '=', 'dept.kd_upb');
                    }
                )
                ->select(
                    'dept.kd_bidang',
                    'dept.kd_unit',
                    'dept.kd_sub',
                    'dept.kd_upb',
                    'dept.name',
                    //DB::raw('ISNULL(ISNULL(roda2.rodadua,0) + ISNULL(roda4.rodaempat,0) + ISNULL(roda3.rodatiga,0) + ISNULL(penumpang.pnp,0) + ISNULL(barang.brg,0) + ISNULL(khusus.kh,0) + ISNULL(lainnya.lain,0),0) as kendaraantot'),
                    DB::raw('COUNT(kibc.idpemda) as gedungtot'),
                    DB::raw('ISNULL(gedung.gedungs,0) as gedung'),
                    DB::raw('ISNULL(dokumenisi.dokumendiisi,0) as dokumenisi'),
                    DB::raw('ISNULL(dokumennotisi.dokumennotdiisi,0) as dokumennotisi'),
                    DB::raw('ISNULL(tgldokisi.tgldokdiisi,0) as tgldokisi'),
                    DB::raw('ISNULL(tgldoknotisi.tgldoknotdiisi,0) as tgldoknotisi'),
                    DB::raw('ISNULL(COUNT(kibc_s.upload_dok_imb),0) as imbisi'),
                    DB::raw('ISNULL(COUNT(kibc_s.imgid),0) as fotoisi')
                    //DB::raw('ISNULL(COUNT(kibcs.vrf_status) ,0) as vrfgeo')
                )
                ->where([
                    ['kibc.kd_bidang', '=', $kdbidang],
                    ['kibc.kd_unit', '=', $kdunit],
                    ['kibc.kd_sub', '=', $kdsub],
                    //['kibc.kd_upb', '=', $kdupb],
                    ['kibc.kd_aset8', '=', 1],
                    ['kibc.kd_aset80', '=', 3],
                    ['kibc.kd_aset81', '=', 3]
                ])
                ->groupBy(
                    'dept.kd_bidang',
                    'dept.kd_unit',
                    'dept.kd_sub',
                    'dept.kd_upb',
                    'dept.name',
                    'gedung.gedungs',
                    'dokumenisi.dokumendiisi',
                    'dokumennotisi.dokumennotdiisi',
                    'tgldokisi.tgldokdiisi',
                    'tgldoknotisi.tgldoknotdiisi'
                )
                ->orderBy('dept.kd_bidang', 'ASC')
                ->orderBy('dept.kd_unit', 'ASC')
                ->orderBy('dept.kd_sub', 'ASC')
                ->orderBy('dept.kd_upb', 'ASC')
                ->get();
            $gedung = DB::table('kibc_s')->leftjoin(Module::bmd() . '.Ta_KIB_C as kibc', 'kibc_s.idpemdas', '=', 'kibc.idpemda')
                ->select('kibc.idpemda as count')
                ->where([
                    ['kibc.kd_bidang', '=', $kdbidang],
                    ['kibc.kd_unit', '=', $kdunit],
                    ['kibc.kd_sub', '=', $kdsub],
                    //['kibc.kd_upb', '=', $kdupb],
                    ['kibc.kd_hapus', '=', 0],
                    ['kibc.kd_pemilik', '=', 12],
                    ['kibc.kd_aset8', '=', 1],
                    ['kibc.kd_aset80', '=', 3],
                    ['kibc.kd_aset81', '=', 3]
                ])
                ->count();
            $gedungbeli = DB::table('kibc_s')->leftjoin(Module::bmd() . '.Ta_KIB_C as kibc', 'kibc_s.idpemdas', '=', 'kibc.idpemda')
                ->select('kibc_s.idpemdas as count')
                ->where([
                    ['kibc.kd_bidang', '=', $kdbidang],
                    ['kibc.kd_unit', '=', $kdunit],
                    ['kibc.kd_sub', '=', $kdsub],
                    // ['kibc.kd_upb', '=', $kdupb],
                    ['kibc.kd_hapus', '=', 0],
                    ['kibc.Asal_usul', '=', 'Pembelian'],
                    ['kibc.kd_pemilik', '=', 12],
                    ['kibc.kd_aset8', '=', 1],
                    ['kibc.kd_aset80', '=', 3],
                    ['kibc.kd_aset81', '=', 3]
                ])
                ->count();
            $gedunghibah = DB::table('kibc_s')->leftjoin(Module::bmd() . '.Ta_KIB_C as kibc', 'kibc_s.idpemdas', '=', 'kibc.idpemda')
                ->select('kibc_s.idpemdas as count')
                ->where([
                    ['kibc.kd_bidang', '=', $kdbidang],
                    ['kibc.kd_unit', '=', $kdunit],
                    ['kibc.kd_sub', '=', $kdsub],
                    //['kibc.kd_upb', '=', $kdupb],
                    ['kibc.kd_hapus', '=', 0],
                    ['kibc.Asal_usul', '=', 'Hibah'],
                    ['kibc.kd_pemilik', '=', 12],
                    ['kibc.kd_aset8', '=', 1],
                    ['kibc.kd_aset80', '=', 3],
                    ['kibc.kd_aset81', '=', 3]
                ])
                ->count();
            $gedungpinjam = DB::table('kibc_s')->leftjoin(Module::bmd() . '.Ta_KIB_C as kibc', 'kibc_s.idpemdas', '=', 'kibc.idpemda')
                ->select('kibc_s.idpemdas as count')
                ->where([
                    ['kibc.kd_bidang', '=', $kdbidang],
                    ['kibc.kd_unit', '=', $kdunit],
                    ['kibc.kd_sub', '=', $kdsub],
                    //['kibc.kd_upb', '=', $kdupb],
                    ['kibc.kd_hapus', '=', 0],
                    ['kibc.Asal_usul', '=', 'Pinjam'],
                    ['kibc.kd_pemilik', '=', 12],
                    ['kibc.kd_aset8', '=', 1],
                    ['kibc.kd_aset80', '=', 3],
                    ['kibc.kd_aset81', '=', 3]
                ])
                ->count();
            $dokumenempty = DB::table('kibC_s')->leftjoin(Module::bmd() . '.Ta_KIB_C as kibC', 'kibc_s.idpemdas', '=', 'kibc.idpemda')
                ->select('kibc_s.idpemdas as count')
                ->whereNull('kibc.dokumen_nomor')
                //->whereNull('kibc.Sertifikat_Tanggal')
                ->where([
                    ['kibc.kd_bidang', '=', $kdbidang],
                    ['kibc.kd_unit', '=', $kdunit],
                    ['kibc.kd_sub', '=', $kdsub],
                    //['kibc.kd_upb', '=', $kdupb],
                    ['kibc.kd_hapus', '=', 0],
                    ['kibc.kd_pemilik', '=', 12],
                    ['kibc.kd_aset8', '=', 1],
                    ['kibc.kd_aset80', '=', 3],
                    ['kibc.kd_aset81', '=', 3]
                ])
                ->count();
            $dokumennotempty = DB::table('kibC_s')->leftjoin(Module::bmd() . '.Ta_KIB_C as kibC', 'kibc_s.idpemdas', '=', 'kibc.IDPemda')
                ->select('kibc_s.idpemdas as count')
                ->whereNotNull('kibc.dokumen_nomor')
                //->whereNotNull('kibc.Sertifikat_Tanggal')
                ->where([
                    ['kibc.kd_bidang', '=', $kdbidang],
                    ['kibc.kd_unit', '=', $kdunit],
                    ['kibc.kd_sub', '=', $kdsub],
                    // ['kibc.kd_upb', '=', $kdupb],
                    ['kibc.kd_hapus', '=', 0],
                    ['kibc.kd_pemilik', '=', 12],
                    ['kibc.kd_aset8', '=', 1],
                    ['kibc.kd_aset80', '=', 3],
                    ['kibc.kd_aset81', '=', 3]
                ])
                ->count();
            $dokumenupload = DB::table('kibC_s')->leftjoin(Module::bmd() . '.Ta_KIB_C as kibC', 'kibc_s.idpemdas', '=', 'kibc.idpemda')
                ->select('kibc_s.idpemdas as count')
                ->whereNotNull('kibc_s.upload_dok_imb')
                ->where([
                    ['kibc.kd_bidang', '=', $kdbidang],
                    ['kibc.kd_unit', '=', $kdunit],
                    ['kibc.kd_sub', '=', $kdsub],
                    //['kibc.kd_upb', '=', $kdupb],
                    ['kibc.kd_hapus', '=', 0],
                    ['kibc.kd_pemilik', '=', 12],
                    ['kibc.kd_aset8', '=', 1],
                    ['kibc.kd_aset80', '=', 3],
                    ['kibc.kd_aset81', '=', 3]
                ])
                ->count();
            $fotoupload = DB::table('kibC_s')->leftjoin(Module::bmd() . '.Ta_KIB_C as kibC', 'kibc_s.idpemdas', '=', 'kibc.idpemda')
                ->select('kibc_s.idpemdas as count')
                ->whereNotNull('kibc_s.imgid ')
                ->where([
                    ['kibc.kd_bidang', '=', $kdbidang],
                    ['kibc.kd_unit', '=', $kdunit],
                    ['kibc.kd_sub', '=', $kdsub],
                    //['kibc.kd_upb', '=', $kdupb],
                    ['kibc.kd_hapus', '=', 0],
                    ['kibc.kd_pemilik', '=', 12],
                    ['kibc.kd_aset8', '=', 1],
                    ['kibc.kd_aset80', '=', 3],
                    ['kibc.kd_aset81', '=', 3]
                ])
                ->count();
            $gedungkantor = DB::table('kibc_s')->leftjoin(Module::bmd() . '.Ta_KIB_C as kibc', 'kibc_s.idpemdas', '=', 'kibc.idpemda')
                ->select('kibc_s.idpemdas as count')
                ->where([
                    ['kibc.kd_bidang', '=', $kdbidang],
                    ['kibc.kd_unit', '=', $kdunit],
                    ['kibc.kd_sub', '=', $kdsub],
                    //['kibc.kd_upb', '=', $kdupb],
                    ['kibc.kd_hapus', '=', 0],
                    ['kibc.kd_pemilik', '=', 12],
                    ['kibc.kd_aset8', '=', 1],
                    ['kibc.kd_aset80', '=', 3],
                    ['kibc.kd_aset81', '=', 3],
                    ['kibc.kd_aset84', '=', 1]
                ])
                ->count();
            $gedungidle = DB::table('kibc_s')->leftjoin(Module::bmd() . '.Ta_KIB_C as kibc', 'kibc_s.idpemdas', '=', 'kibc.idpemda')
                ->select('kibc_s.idpemdas as count')
                ->where([
                    ['kibc.kd_bidang', '=', $kdbidang],
                    ['kibc.kd_unit', '=', $kdunit],
                    ['kibc.kd_sub', '=', $kdsub],
                    // ['kibc.kd_upb', '=', $kdupb],
                    ['kibc.kd_hapus', '=', 0],
                    ['kibc.kd_pemilik', '=', 12],
                    ['kibc.kd_aset8', '=', 1],
                    ['kibc.kd_aset80', '=', 3],
                    ['kibc.kd_aset81', '=', 3],
                    ['kibc_s.pemanfaatan', 'LIKE', '%Idle%']
                ])
                ->count();
            $gedungbaik = DB::table('kibc_s')->leftjoin(Module::bmd() . '.Ta_KIB_C as kibc', 'kibc_s.idpemdas', '=', 'kibc.idpemda')
                ->select('kibc_s.idpemdas as count')
                ->where([
                    //['kibc.kd_kab_kota', '=', 16],
                    ['kibc.kd_bidang', '=', $kdbidang],
                    ['kibc.kd_unit', '=', $kdunit],
                    ['kibc.kd_sub', '=', $kdsub],
                    //['kibc.kd_upb', '=', $kdupb],
                    ['kibc.kd_pemilik', '=', 12],
                    ['kibc.kondisi', '=', 1]
                ])
                ->count();
            $gedungrusak = DB::table('kibc_s')->leftjoin(Module::bmd() . '.Ta_KIB_C as kibc', 'kibc_s.idpemdas', '=', 'kibc.idpemda')
                ->select('kibc_s.idpemdas as count')
                ->where([
                    ['kibc.kd_bidang', '=', $kdbidang],
                    ['kibc.kd_unit', '=', $kdunit],
                    ['kibc.kd_sub', '=', $kdsub],
                    //['kibc.kd_upb', '=', $kdupb],
                    ['kibc.kd_kab_kota', '=', 16],
                    ['kibc.kd_pemilik', '=', 12],
                    ['kibc.kondisi', '=', 3]
                ])
                ->count();
        }
        if (Module::hasAccess($module->id)) {
            return view(
                'la.kibc_s.index',
                [
                    'show_actions' => $this->show_action,
                    'listing_cols' => $this->listing_cols,
                    'module' => $module,
                    'gedungcount' => $gedungcount,
                    'gedung' => $gedung,
                    'dokumenempty' => $dokumenempty,
                    'dokumennotempty' => $dokumennotempty,
                    'gedungbeli' => $gedungbeli,
                    'gedunghibah' => $gedunghibah,
                    'dokumenupload' => $dokumenupload,
                    'fotoupload' => $fotoupload,
                    'gedungpinjam' => $gedungpinjam,
                    'gedungkantor' => $gedungkantor,
                    'gedungidle' => $gedungidle,
                    'refbidang' => $refbidang,
                    'gambar' => $gambar,
                    'gedungbaik' => $gedungbaik,
                    'gedungrusak' => $gedungrusak
                ]
            );
        } else {
            return view('errors.404');
        }
    }

    //end upload file controller
    /*Ref Rek.Kibc start. at 14-09-2021*/
    public function rekening1($ids)
    {
        $rek1 = Module::populaterefbrg1($ids)->where('rek1.kd_aset1', '=', 1)->pluck('nm_aset1', 'kd_aset1');
        return json_encode($rek1);
    }
    public function rekening2($ids, $idss)
    {
        $rek2 = Module::populaterefbrg2($ids, $idss)->pluck('nm_aset2', 'kd_aset2');
        return json_encode($rek2);
    }
    public function rekening3($ids, $idss, $ids3)
    {
        $rek3 = Module::populaterefbrg3($ids, $idss, $ids3)->pluck('nm_aset3', 'kd_aset3');
        return json_encode($rek3);
    }
    public function rekening4($ids, $idss, $ids3, $ids4)
    {
        $rek4 = Module::populaterefbrg4($ids, $idss, $ids3, $ids4)->pluck('nm_aset4', 'kd_aset4');
        return json_encode($rek4);
    }

    /*end of ref rek*/
    /*
Verifikasi aset Gedung dan Bangunan*/
    public function verifgb(Request $request, $id)
    {
        $update = Kibc_::find($id);
        $update->verif_gb = 1;
        $update->save();

        return redirect(config('laraadmin.adminRoute') . '/kibc_s#listdatagedung');
    }
    public function verifsave(Request $request, $id)
    {
        $update = Kibc_::find($id);
        $update->verif_gb = 0;
        $update->save();

        return redirect(config('laraadmin.adminRoute') . '/kibc_s#listdatagedung');
    }
    /*End of verif*/

    public function LoadDataKibc_s(Request $request, $kdbidangs, $kdunits, $kdsubs, $kdupbs)
    {
        if (Module::hasAccess('Kibc_s', 'view')) {
            $kdbidang = Module::kdopd()->kd_bidang;
            /* $kdunit = Module::kdopd()->kd_unit;
    $kdsub = Module::kdopd()->kd_sub; */
            //$idrek0  = (int)$ids;
            //$idrek1  = (int)$idss;
            //$idrek3  = (int)$ids3;
            //$idrek4  = (int)$ids4;
            //$konds  = (int)$kond;
            //dd($kdbidangs,$kdunits,$kdsubs);
            /* $data = Module::gbadmin($kdbidangs,$kdunits,$kdsubs)->get();
    dd($data); */
            if ($request->ajax()) {
                $output = '';
                $query = $request->get('query');
                if ($query != '') {
                    if ($kdbidang == 99 || $kdbidang == 0) {
                        $data = Module::gbadminquery($kdbidangs, $kdunits, $kdsubs, $query)->get();
                    } else {
                        $data = Module::gbuserquery($kdbidangs, $kdunits, $kdsubs, $query)->get();
                    }
                } else {
                    if ($kdbidang == 99 || $kdbidang == 0) {
                        $data = Module::gbadmin($kdbidangs, $kdunits, $kdsubs,$kdupbs)->get();
                        $data = Module::gbadminupb($kdbidangs, $kdunits, $kdsubs, $kdupbs)->get();
                    } else {

                        $kdunit = Module::kdopd()->kd_unit;
                        $kdsub = Module::kdopd()->kd_sub;
                        $kdupb = Module::kdopd()->kd_upb;
                        $data = Module::gbuser($kdbidangs, $kdunits, $kdsubs, $kdupbs)->get();
                        $data = Module::gbuserupb($kdbidangs, $kdunits, $kdsubs, $kdupbs)->get();
                    }
                }
                $total_row = count($data);
                if ($total_row > 0) {
                    foreach ($data as $index => $row) {
                        $index = $index + 1;
                        if (Module::hasAccess('Kibc_s', 'edit')) {
                            $output .= '
                    <tr>
                    <td>' . $index . '</td>
                    <td>' . $row->Dept . '</td>
                    <td><a href="' . url(config('laraadmin.adminRoute') . '/kibc_s/' . $row->id) . '">' . $row->idpemda . '</a></td>
                    <td>' . $row->koordx . '</td>
                    <td>' . $row->koordy . '</td>
                    <td>' . date('d-m-Y', strtotime($row->tgl_perolehan)) . '</td>
                    <td>' . date('d-m-Y', strtotime($row->dokumen_tanggal)) . '</td>
                    <td>' . $row->dokumen_nomor . '</td>
                    <td>' . $row->lokasi . '</td>
                    <td>' . $row->status_tanah . '</td>
                    <td>' . $row->keterangan . '</td>
                    <td style="width:10%">Rp. ' . number_format($row->harga, 2, ',', '.') . '</td>
                    <td>' . $row->kondisi . '</td>
                    <td>' . $row->pemanfaatan . '</td>
                    <td>' . (($row->imgname == ''  or $row->imgname == 0) ?
                                '<i>Belum Upload</i>' : '<img src="' . url('/storage/imgkib/Image/' . $row->imgname) . '"alt="gambar" width = "190" height = "160"/> '
                            ) . '</td>
                    <td>
                    <a href="' . url(config('laraadmin.adminRoute') . '/printgedung/' . $row->id) . '" class="btn btn-outline-info btn-xs" style="display:inline;padding:2px 5px 3px 5px;" target="_blank"><i class="fa fa-print"></i></a>

                    <a href="' . url(config('laraadmin.adminRoute') . '/kibc_s/' . $row->id . '/edit') . '" class="btn btn-warning" style="display:inline;padding:2px 5px 2px 5px;"><i class="fa fa-edit" title="Edit"></i></a>                       

                        <button id = "getidbutton" value = ' . $row->id . ' class="fa fa-camera" style="display:inline; padding:2px 5px 3px 5px;" data-toggle="modal"  onclick = "getInputValue(this);" title="Upload Foto" ></button
                    <div class="form-check form-check-inline">
                    <input id="chkbox1" type="checkbox" name="ids" value="' . $row->idpemda . '" rel="searchsolos"/>
                    <label class="form-check-label" for="inlineCheckbox2"><i class="fa fa-print"></i></label>
                    </div>
                    </td>
                    <td style="text-align:center;"> <i class="fa-regular fa-file-pen"></i>
                    <div class="form-check form-check-inline">'
                                . (($kdbidang == 99 or $kdbidang == 0) ?
                                    '<a href="' . url(config('laraadmin.adminRoute') . '/verifgedung/' . $row->id) . '" class="btn btn-primary btn-sm" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-check"></i></a>
                        <a href="' . url(config('laraadmin.adminRoute') . '/verifcek/' . $row->id) . '" class="btn btn-danger btn-sm" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-close"></i></a>'
                                    :
                                    '<label class="form-check-label" for="inlineCheckbox2">Not Authorize</label>') .

                                '</div>
                    </td>
                    </tr>';
                        } else {
                            $output .= '
                        <tr>
                    <td>' . $index . '</td>
                    <td>' . $row->Dept . '</td>
                    <td><a href="' . url(config('laraadmin.adminRoute') . '/kibc_s/' . $row->id) . '">' . $row->idpemda . '</a></td>
                    <td>' . $row->koordx . '</td>
                    <td>' . $row->koordy . '</td>
                    <td>' . date('d-m-Y', strtotime($row->tgl_perolehan)) . '</td>
                    <td>' . date('d-m-Y', strtotime($row->dokumen_tanggal)) . '</td>
                    <td>' . $row->dokumen_nomor . '</td>
                    <td>' . $row->lokasi . '</td>
                    <td>' . $row->status_tanah . '</td>
                    <td>' . $row->keterangan . '</td>
                    <td style="width:10%">Rp. ' . number_format($row->harga, 2, ',', '.') . '</td>
                    <td>' . $row->kondisi . '</td>
                    <td>' . $row->pemanfaatan . '</td>
                    <td>' . (($row->imgname == ''  or $row->imgname == 0) ?
                                '<i>Belum Upload</i>' : '<img src="' . url('/storage/imgkib/Image/' . $row->imgname) . '"alt="gambar" width = "190" height = "160"/> '
                            ) . '</td>
                    <td>
                    <a href="' . url(config('laraadmin.adminRoute') . '/printgedung/' . $row->id) . '" class="btn btn-outline-info btn-xs" style="display:inline;padding:2px 5px 3px 5px;" target="_blank"><i class="fa fa-print"></i></a>

                    <a href="' . url(config('laraadmin.adminRoute') . '/kibc_s/' . $row->id . '/edit') . '" class="btn btn-warning" style="display:inline;padding:2px 5px 2px 5px;"><i class="fa fa-edit" title="Edit"></i></a>                       

                        <button id = "getidbutton" value = ' . $row->id . ' class="fa fa-camera" style="display:inline; padding:2px 5px 3px 5px;" data-toggle="modal"  onclick = "getInputValue(this);" title="Upload Foto" ></button>
                    <div class="form-check form-check-inline">
                    <input id="chkbox1" type="checkbox" name="ids" value="' . $row->idpemda . '" rel="searchsolos"/>
                    <label class="form-check-label" for="inlineCheckbox2"><i class="fa fa-print"></i></label>
                    </div>
                    </td>
                    </tr>';
                        }
                    }
                } else {
                    $output = '
            <tr>
            <td align="center" colspan="5"> No Data Found</td>
            </tr>';
                }
                $data = [
                    'table_data' => $output,
                    'total_data' => $total_row,
                ];
                echo json_encode($data);
            }
        } else {
            return view('errors.404');
        }
    }
    public function LoadDataImbadmin(Request $request, $kdbidangs, $kdunits, $kdsubs)
    {
        if (Module::hasAccess('Kibc_s', 'view')) {
            $kdbidang = Module::kdopd()->kd_bidang;
            $kdunit = Module::kdopd()->kd_unit;
            $kdsub = Module::kdopd()->kd_sub;
            //$idrek0  = (int)$ids;
            //$idrek1  = (int)$idss;
            //$idrek3  = (int)$ids3;
            //$idrek4  = (int)$ids4;

            if ($request->ajax()) {
                $output = '';
                $query = $request->get('query');
                if ($query != '') {
                    if ($kdbidang == 99 || $kdbidang == 0) {
                        $data = Module::gbadminquery($kdbidangs, $kdunits, $kdsubs, $query)->get();
                    } else {
                        $data = Module::gbuserquery($kdbidangs, $kdunits, $kdsubs, $query)->get();
                    }
                } else {
                    if ($kdbidang == 99 || $kdbidang == 0) {
                        $data = Module::gbadmin($kdbidangs, $kdunits, $kdsubs)->get();
                    } else {
                        $kdunit = Module::kdopd()->kd_unit;
                        $kdsub = Module::kdopd()->kd_sub;
                        $kdupb = Module::kdopd()->kd_upb;
                        $data = Module::gbuser($kdbidangs, $kdunits, $kdsubs)->get();
                    }
                }
                $total_raw = count($data);
                if ($total_raw > 0) {
                    foreach ($data as $index => $row) {
                        $index = $index + 1;
                        if (Module::hasAccess('Kibc_s', 'edit')) {
                            $output .= '
                    <tr>
                    <td>' . $index . '</td>
                    <td>' . $row->Dept . '</td>
                    <td><a href="' . url(config('laraadmin.adminRoute') . '/kibc_s/' . $row->id) . '">' . $row->idpemda . '</a></td>
                    <td>' . $row->no_imb_lama . '</td>
                    <td>' . $row->no_imb_baru . '</td>
                    <td>' . date('d-m-Y', strtotime($row->tgl_perolehan)) . '</td>
                    <td>' . $row->lokasi . '</td>
                    <td>' . $row->asal_usul . '</td>
                    <td>' . $row->kondisi . '</td>
                    <td>' . $row->keterangan . '</td>
                    <td>' . $row->pemanfaatan . '</td>
                    <td>' . $row->tgl_awal_imb . '</td>
                    <td>' . $row->tgl_akhir_imb . '</td>
                    <td style="text-align:center;><a href="' . url('/files/' . $row->hashfile) . '/' . $row->upload_dok_imb . '">' . (($row->dokumen == '' or $row->dokumen == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">') . '</a></td>
                    <td>
                    <a href="' . url(config('laraadmin.adminRoute') . '/printimb/' . $row->id) . '" class="btn btn-outline-info btn-xs" style="display:inline;padding:2px 5px 3px 5px;" target="_blank"><i class="fa fa-print"></i></a>
                    <div class="form-check form-check-inline">
                    <input id="chkbox1" type="checkbox" name="ids" value="' . $row->idpemda . '" rel="searchsolos"/>
                    <label class="form-check-label" for="inlineCheckbox2"><i class="fa fa-print"></i></label>
                    </div>
                    </td>
                    </tr>';
                        } else {
                            $output .= '
                    <tr>
                    <td>' . $index . '</td>
                    <td>' . $row->Dept . '</td>
                    <td><a href="' . url(config('laraadmin.adminRoute') . '/kibc_s/' . $row->id) . '">' . $row->idpemda . '</a></td>
                    <td>' . $row->koordx . '</td>
                    <td>' . $row->koordy . '</td>
                    <td>' . date('d-m-Y', strtotime($row->tgl_perolehan)) . '</td>
                    <td>' . $row->lokasi . '</td>
                    <td>' . $row->asal_usul . '</td>
                    <td>' . $row->kondisi . '</td>
                    <td>' . $row->keterangan . '</td>
                    <td>' . $row->pemanfaatan . '</td>
                    <td>' . $row->tgl_awal_imb . '</td>
                    <td>' . $row->tgl_akhir_imb . '</td>
                    <td style="text-align:center;><a href="' . url('/files/' . $row->hashfile) . '/' . $row->upload_dok_imb . '">' . (($row->dokumen == '' or $row->dokumen == '0') ? '<i class="fa fa-times btn-danger btn-xs">' : '<i class="fa fa-check btn-success btn-xs">') . '</a></td>
                    <td>
                    <a href="' . url(config('laraadmin.adminRoute') . '/printimb' . $row->id) . '" class="btn btn-outline-info btn-xs" style="display:inline;padding:2px 5px 3px 5px;" target="_blank"><i class="fa fa-print"></i></a>                      
                    <div class="form-check form-check-inline">
                    <input id="chkbox1" type="checkbox" name="ids" value="' . $row->idpemda . '" rel="searchsolos"/>
                    <label class="form-check-label" for="inlineCheckbox2"><i class="fa fa-print"></i></label>
                    </div>
                    </td>
                    </tr>';
                        }
                    }
                } else {
                    $output = '
            <tr>
            <td align="center" colspan="5">No Data Found</td>
            </tr>';
                }
                $data = [
                    'table_data' => $output,
                    'total_data' => $total_raw,
                ];
                echo  json_encode($data);
            }
        } else {
            return view('errors.404');
        }
    }
    /*Load Data Tanah */

    /*end Load Data Tanah*/
    /**
     * Show the form for creating a new kibc.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created kibc in database.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Module::hasAccess('Kibc_s', 'create')) {
            $rules = Module::validateRules('Kibc_s', $request);

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $insert_id = Module::insert('Kibc_s', $request);

            return redirect()->route(config('laraadmin.adminRoute') . '.kibc_s.index');
        } else {
            return redirect(config('laraadmin.adminRoute') . '/');
        }
    }

    /**
     * Display the specified kibc.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kdbidang = Module::kdopd()->kd_bidang;
        $kdunit = Module::kdopd()->kd_unit;
        $kdsub = Module::kdopd()->kd_sub;
        //dd($kdbidang);
        if (Module::hasAccess("Kibc_s", "view")) {

            $kibc_s = Kibc_::find($id);
            if (isset($kibc_s->id)) {
                $module = Module::get('Kibc_s');
                $module->row = $kibc_s;
                //dd($module->row['idpemdas']);

                //gilang
                $valueskap = DB::table(Module::bmd() . '.Ta_KIB_C as kibc')->leftjoin(Module::bmd() . '.Ta_KIBCR as kibcr', 'kibcr.IDPemda', '=', 'kibc.IDPemda')
                    ->select(
                        'kibcr.IDPemda',
                        'kibcr.no_register',
                        'kibc.tgl_perolehan',
                        'kibcr.tgl_perolehan',
                        'kibcr.harga',
                        'kibcr.tgl_dokumen',
                        'kibcr.no_dokumen',
                        'kibcr.masa_manfaat',
                        'kibcr.luas_lantai',
                        'kibcr.kondisi',
                        'kibcr.Kd_Riwayat'
                    )
                    ->where('kibcr.IDPemda', '=', $module->row['idpemda'])
                    ->where('kibcr.Kd_Riwayat', '=', 2)
                    ->get();
                $valuesmut = DB::table(Module::bmd() . '.Ta_KIB_C as kibc')->leftjoin(Module::bmd() . '.Ta_KIBCR as kibcr', 'kibcr.IDPemda', '=', 'kibc.IDPemda')
                    ->select(
                        'kibcr.IDPemda',
                        'kibcr.no_register',
                        'kibc.tgl_perolehan',
                        'kibcr.tgl_perolehan',
                        'kibcr.harga',
                        'kibcr.tgl_dokumen',
                        'kibcr.no_dokumen',
                        'kibcr.masa_manfaat',
                        'kibcr.luas_lantai',
                        'kibcr.kondisi',
                        'kibcr.Kd_Riwayat'
                    )
                    ->where('kibcr.IDPemda', '=', $module->row['idpemda'])
                    ->where('kibcr.Kd_Riwayat', '=', 3)
                    ->get();
                $valuespeny = DB::table(Module::bmd() . '.Ta_KIBCR as kibcr')->distinct()->join('bmd_20711R7.dbo.ta_susutc as susutc', 'kibcr.IDPemda', '=', 'susutc.IDPemda')
                    ->select(
                        'susutc.tahun',
                        'susutc.harga',
                        'susutc.nilai_susut1',
                        'susutc.nilai_susut2',
                        'susutc.akum_susut',
                        'susutc.nilai_sisa',
                        'susutc.sisa_umur'
                    )
                    ->where('susutc.IDPemda', '=', $module->row['idpemda'])
                    ->get();
                //dd($valuespeny);
                /*Tanah Value
        $tanah = DB::table(Module::bmd().'.Ta_KIB_A as kiba')
                    //->leftjoin('kibcs','kiba.idpemda','=','kibcs.idpemda')
                    ->select('kiba.idpemda','kiba.no_register','kiba.tgl_perolehan',
                    'kiba.tgl_perolehan','kiba.harga','kiba.sertifikat_tanggal','kiba.sertifikat_nomor',
                    'kiba.luas_m2','kiba.alamat','kiba.penggunaan','kiba.keterangan')
                    ->where('kiba.IDPemda','=',$module->row['idpemda'])
                
                    ->get();
                    /*End of tanah value*/
                //dd($tanah);
                return view('la.kibc_s.show', [
                    'module' => $module,
                    'view_col' => $this->view_col,
                    'no_header' => true,
                    'no_padding' => "no-padding",
                    'valueskap' => $valueskap,
                    'valuesmut' => $valuesmut,
                    'valuespeny' => $valuespeny
                ])->with('kibc_s', $kibc_s);
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("kibc_s"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/");
        }
    }
    /*Barang show tanah tel*/
    public function updbrg(Request $request, $idpemda, $id0, $ids, $idss, $ids3, $ids4, $tanah)
    {
        $data = Module::updttanah($idpemda, $id0, $ids, $idss, $ids3, $ids4, $tanah);
        return json_encode($data);
    }
    public function hapusbrg($value = '')
    {
        $data = Module::hapustanah($id);
        return json_encode($data);
    }
    public function showtanah(Request $request, $id, $kdbidang, $kdunit, $kdsub, $kdupb, $ids, $idss, $ids3, $ids4)
    {
        $kibc_s = Kibc_::find($id);
        //dd($kibcs->id);
        if (Module::hasAccess("Kibc_s", "view")) {
            $kdbidang = Module::kdopd()->kd_bidang;
            $kdunit = Module::kdopd()->kd_unit;
            $kdsub = Module::kdopd()->kd_sub;
            $kdupb = Module::kdopd()->kd_upb;
            $idrek0  = (int)$ids;
            $idrek1  = (int)$idss;
            $idrek3  = (int)$ids3;
            $idrek4  = (int)$ids4;
            if ($request->ajax()) {
                $output = '';
                $query = $request->get('query');
                if ($query != '') {
                    if ($kdbidang == 99 || $kdbidang == 0) {
                        $data = Module::kibaadminquery($kdbidang, $kdunit, $kdsub, $kdupb, $idrek0, $idrek1, $idrek3, $idrek4, $query);
                    } else {
                        $data = Module::kibauserquery($kdbidang, $kdunit, $kdsub, $kdupb, $ids, $idss, $ids3, $ids4, $query);
                    }
                } else {
                    if ($kdbidang == 99 || $kdbidang == 0) {
                        $data = Module::kibaadmin($kdbidang, $kdunit, $kdsub, $kdupb, $idrek0, $idrek1, $idrek3, $idrek4);
                    } else {
                        $data = Module::kibauser($kdbidang, $kdunit, $kdsub, $kdupb, $ids, $idss, $ids3, $ids4);
                    }
                }
                $total_row = count($data);
                if ($total_row > 0) {
                    foreach ($data as $index => $isi) {
                        $index = $index + 1;
                        if (Module::hasAccess("Kibc_s", "edit")) {
                            $output .= '
                <tr>
                <td>' . $index . '</td>
                <div class="form-check form-check-inline">
                <td>
                <button id = "' . $isi->idpemda . '" 
                href="' . url(config('laraadmin.adminRoute') . '/updbrg/' . $isi->idpemda . '/' . $idrek0 . '/' . $idrek1 . '/' . $idrek3 . '/' . $idrek4 . '/' . $kibc_s->id) . '" 
                class="btn btn-primary" type="button" onclick = "getidpemda(this.id)" 
                value = "' . $isi->idpemda . '" enabled>Add</button>
                </td>
                </div>
                <td>' . $isi->dept . '</td>
                <td>' . $isi->no_register . '</td>
                <td>' . $isi->tgl_perolehan . '</td>
                <td>' . $isi->luas_m2 . '</td>
                <td>' . $isi->Sertifikat_tanggal . '</td>
                <td>' . $isi->sertifikat_nomor . '</td>
                <td>' . $isi->penggunaan . '</td>
                <td>' . $isi->alamat . '</td>
                <td>' . $isi->harga . '</td>
                <td>' . $isi->harga . '</td>
                </tr>';
                        } else {
                            $output = '
                <tr>
                <td>' . $index . '</td>
                <td>' . $isi->dept . '</td>
                <td>' . $isi->no_register . '</td>
                <td>' . $isi->tgl_perolehan . '</td>
                <td>' . $isi->luas_m2 . '</td>
                <td>' . $isi->dokumen_tanggal . '</td>
                <td>' . $isi->dokumen_nomor . '</td>
                <td>' . $isi->status_tanah . '</td>
                <td>' . $isi->lokasi . '</td>
                <td>' . $isi->harga . '</td>
                <td>
                <div class="form-check form-check-inline">
                Not Authorize
                </div>                       
                </td>  
                </tr>
                ';
                        }
                    }
                } else {
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
                echo json_encode($data);
            }
        } else {
            return view('errors.404');
        }
    }
    /*End of tanah show cek*/
    //new edit code 14-09-2021
    /**
     * Show the form for editing the specified kibc.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Module::hasAccess('Kibc_s', 'edit')) {
            $kibc_s = Kibc_::find($id);
            $refrek0 = Module::populaterefbrg0()->where('rek0.kd_aset0', '=', 3)->get();
            $kond = Module::populaterefkondisi()->get();
            $kdbidang = Module::kdopd()->kd_bidang;
            $kdunit = Module::kdopd()->kd_unit;
            $kdsub = Module::kdopd()->kd_sub;
            $kdupb = Module::kdopd()->kd_upb;
            if (isset($kibc_s->id)) {
                $module = Module::get('Kibc_s');
                $module->row = $kibc_s;
                if ($kdbidang == 99 || $kdbidang == 0) {
                    $gambar = Module::kibcadminall($id);
                    $kibcadminbrg = Module::kibcadminbrg($id);
                    return view('la.kibc_s.edit', [
                        'module' => $module,
                        'view_col' => $this->view_col,
                        'refrek0' => $refrek0,
                        'kond' => $kond,
                        'kdbidang' => $kdbidang,
                        'kdunit' => $kdunit,
                        'kdsub' => $kdsub,
                        'kdupb' => $kdupb,
                        'kibcuserbrg' => $kibcadminbrg
                    ])->with('kibc_s', $kibc_s);
                } else {
                    $kibcuserbrg = Module::kibcuserbrg($id);
                    return view('la.kibc_s.edit', [
                        'module' => $module,
                        'view_col' => $this->view_col,
                        'refrek0' => $refrek0,
                        'kond' => $kond,
                        'kdbidang' => $kdbidang,
                        'kdunit' => $kdunit,
                        'kdsub' => $kdsub,
                        'kdupb' => $kdupb,
                        'kibcuserbrg' => $kibcuserbrg
                    ])->with('kibc_s', $kibc_s);
                }
            } else {
                return view('errors.404', [
                    'record_id' => $id,
                    'record_name' => ucfirst("kibc_s"),
                ]);
            }
        } else {
            return redirect(config('laraadmin.adminRoute') . "/kibc_s#listdatagedung");
        }
    }
    //end new edit write

    /**
     * Update the specified kibc in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Module::hasAccess('Kibc_s', 'edit')) {
            $rules = Module::validateRules('Kibc_s', $request, true);

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $insert_id = Module::updateRow('Kibc_s', $request, $id);

            return redirect(config('laraadmin.adminRoute') . '/kibc_s#listdatagedung');
        } else {
            return redirect(config('laraadmin.adminRoute') . '/kibc_s#listdatagedung');
        }
    }
    /*start of upload image by i am 17-09-2021*/
    public function imageupload(Request $request)
    {
        //dd('tai');
        $this->validate(
            $request,
            [
                'file' => 'mimes:jpg,jpeg,png,bmp,tiff,pdf |max:2000',
            ],
            $messages = [
                'required' => 'The :attribute field is required.',
                'mimes' => 'Hanya file jpg,jpeg, png, bmp,tiff yang dapat kami terima!.'
            ]
        );

        if ($request->file()) {
            $fileName = time() . '_' . $request->file->getClientOriginalName();
            $filePath = $request->file('file')->move('storage/imgkib/Image/', $fileName, 'public');

            $fileModel = new Image_kib;
            $fileModel->name = time() . '_' . $request->file->getClientOriginalName();
            $fileModel->file_path = $filePath;
            $fileModel->nama_kib = "KIBC";
            $fileModel->save();

            $update = Kibc_::find($request->input('inputidpemda'));
            $update->imgid     = $fileModel->id;
            $update->save();

            return redirect(config('laraadmin.adminRoute') . '/kibc_s#listdatagedung');
        }
    }
    /////hapus update
    public function hapus(Request $request, $id)
    {
        $data = Module::hapusfoto($id);
        return json_encode($data);
    }

    /* /////////////////----------------------
public function addbrg(Request $request,$idpemda,$id0,$ids,$idss,$ids3,$ids4){
//dd($noajuan,$idpemda);
$data = Module::insertbrgpb($noajuan,$idpemda,$id0,$ids,$idss,$ids3,$ids4);
return json_encode($data);

}


end of rout kibas

/**
 * Remove the specified kibc from storage.
 *
 * @param int $id
 *
 * @return \Illuminate\Http\Response
 */
    public function destroy($id)
    {
        if (Module::hasAccess('Kibc_s', 'delete')) {
            Image_kib::find($id)->delete();

            // Redirecting to index() method
            return redirect()->route(config('laraadmin.adminRoute') . '.kibc_s.index');
        } else {
            return redirect(config('laraadmin.adminRoute') . '/');
        }
    }

    /*public function ExportCsv(Request $request,$kdbidangs,$kdunits,$kdsubs)
{
$filename = 'task/csv';
$tasks = Task::all();
$headers = array(
    "Content-Type" => "text/csv",
    "Content-Disposition" => "attachment;filename=$filename",
    "Pragma" => "no-cache",
    "Chache-Control" => "must-revalidate, post-check=0, pre-check=0",
    "Expires" => "0"
);
$columns = array($listing_cols);
$callback = function()use($tasks,$columns){
    $file = fopen('php://output','w');
    fputcsv($file,$columns);
    foreach($tasks as $isi){
        $row['idpemda'] = $isi->idpemda;
        fputcsv($file, array($row['$listing_cols']));
    }
    fclose($file);

};
return response()->stream($callbackl,200,$headers);
}*/

    /**  06-05-21
     * Datatable Ajax fetch.
     *
     * @return
     */
    public function dtajax()
    {
        $kdbidang = Module::kdopd()->kd_bidang;
        $kdunit = Module::kdopd()->kd_unit;
        //$values = DB::table('kibcs')->select($this->listing_cols)->whereNull('deleted_at');
        if (Module::sadmin()->kd_bidang == 0 || Module::admin()->kd_bidang == 99 || Module::aset()->kd_bidang == 98) {
            $values = DB::table('kibc_s')->leftjoin(Module::bmd() . '.Ta_KIB_C as kibc', 'kibc_s.idpemdas', '=', 'kibc.IDPemda')
                ->leftjoin(
                    'departments as dept',
                    function ($join) {
                        $join->on('dept.kd_bidang', '=', 'kibc.kd_bidang')
                            ->on('dept.kd_unit', '=', 'kibc.kd_unit')
                            ->on('dept.kd_sub', '=', 'kibc.kd_sub')
                            ->on('dept.kd_upb', '=', 'kibc.kd_upb');
                    }
                )
                ->select(
                    'kibc_s.id',
                    'kibc.IDPemda',
                    'kibc_s.koordx',
                    'kibc_s.koordy',
                    'kibc.no_register',
                    'kibc.tgl_perolehan',
                    'kibc.dokumen_tanggal',
                    'kibc.dokumen_nomor',
                    'kibc.lokasi',
                    'kibc.status_tanah',
                    'kibc.kd_bidang',
                    'kibc.kd_unit',
                    'kibc.kd_sub',
                    'kibc.kd_upb',
                    'kibc_s.imgid',
                    'uploadphoto.name as imgname'
                )
                ->where([
                    ['kibc.kd_hapus', '=', 0],
                    ['kibc.kd_pemilik', '=', 12]
                ]);
        } else {
            $values = DB::table('kibc_s')->leftjoin(Module::bmd() . '.Ta_KIB_C as kibc', 'kibc_s.idpemdas', '=', 'kibc.IDPemda')
                ->leftjoin(
                    'departments as dept',
                    function ($join) {
                        $join->on('dept.kd_bidang', '=', 'kibc.kd_bidang')
                            ->on('dept.kd_unit', '=', 'kibc.kd_unit')
                            ->on('dept.kd_sub', '=', 'kibc.kd_sub')
                            ->on('dept.kd_upb', '=', 'kibc.kd_upb');
                    }
                )
                ->select(
                    'kibc_s.id',
                    'kibc.IDPemda',
                    'kibc_s.koordx',
                    'kibc_s.koordy',
                    'kibc.no_register',
                    'kibc.tgl_perolehan',
                    'kibc.dokumen_tanggal',
                    'kibc.dokumen_nomor',
                    'kibc.lokasi',
                    'kibc.status_tanah',
                    'kibc.kd_bidang',
                    'kibc.kd_unit',
                    'kibc.kd_sub',
                    'kibc.kd_upb',
                    'kibc_s.imgid',
                    'uploadphoto.name as imgname'
                )
                ->where([
                    ['kibc.kd_hapus', '=', 0],
                    ['kibc.kd_pemilik', '=', 12],
                    ['kibc.kd_bidang', '=', $kdbidang],
                    ['kibc.kd_unit', '=', $kdunit]
                ]);
        }
        $out = Datatables::of($values)->make();
        $data = $out->getData();

        $fields_popup = ModuleFields::getModuleFields('Kibc_s');

        for ($i = 0; $i < count($data->data); $i++) {
            for ($j = 0; $j < count($this->listing_cols); $j++) {
                $col = $this->listing_cols[$j];
                if ($fields_popup[$col] != null && starts_with($fields_popup[$col]->popup_vals, "@")) {
                    $data->data[$i][$j] = ModuleFields::getFieldValue($fields_popup[$col], $data->data[$i][$j]);
                }
                if ($col == $this->view_col) {
                    $data->data[$i][$j] = '<a href="' . url(config('laraadmin.adminRoute') . '/kibc_s/' . $data->data[$i][0]) . '">' . $data->data[$i][$j] . '</a>';
                }
                // else if($col == "author") {
                //    $data->data[$i][$j];
                // }
            }

            if ($this->show_action) {
                $output = '';
                if (Module::hasAccess("Kibc_s", "edit")) {
                    $output .= '<a href="' . url(config('laraadmin.adminRoute') . '/kibc_s/' . $data->data[$i][0] . '/edit') . '" class="btn btn-warning btn-xs" style="display:inline;padding:2px 5px 3px 5px;"><i class="fa fa-edit"></i></a>';
                }

                if (Module::hasAccess("Kibc_s", "delete")) {
                    $output .= Form::open(['route' => [config('laraadmin.adminRoute') . '.kibc_s.destroy', $data->data[$i][0]], 'method' => 'delete', 'style' => 'display:inline']);
                    $output .= ' <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-times"></i></button>';
                    $output .= Form::close();
                }
                $data->data[$i][] = (string)$output;
            }
        }
        $out->setData($data);
        return $out;
    }

    //controller export to csv 20-09-2021

}
