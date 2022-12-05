<?php

/* ================== Homepage ================== */
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');
Route::get('/neraca/{tahun}', 'HomeController@neraca');
Route::get('/sert/{tahun}', 'HomeController@sert');
Route::get('/sert', 'HomeController@serts');
Route::get('/gedung/{tahun}', 'HomeController@gedung');
Route::get('/check_kibb/{idpemda}', 'HomeController@check_kibb');
Route::auth();

/* ================== Access Uploaded Files ================== */
Route::get('files/{hash}/{name}', 'LA\UploadsController@get_file');

/*
|--------------------------------------------------------------------------
| Admin Application Routes
|--------------------------------------------------------------------------
*/

$as = "";
if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
	$as = config('laraadmin.adminRoute').'.';

	// Routes for Laravel 5.3
	Route::get('/logout', 'Auth\LoginController@logout');
}

Route::group(['as' => $as, 'middleware' => ['auth', 'permission:ADMIN_PANEL']], function () {

	/* ================== Dashboard ================== */

	Route::get(config('laraadmin.adminRoute'), 'LA\DashboardController@index');
	Route::get(config('laraadmin.adminRoute'). '/dashboard', 'LA\DashboardController@index');

	/* ================== Users ================== */
	Route::resource(config('laraadmin.adminRoute') . '/users', 'LA\UsersController');
	//Route::get(config('laraadmin.adminRoute') . '/user_dt_ajax', 'LA\UsersController@dtajax');
	Route::get(config('laraadmin.adminRoute') . '/user_dt_ajax', 'LA\UsersController@dtajax');

	/* ================== Uploads ================== */
	Route::resource(config('laraadmin.adminRoute') . '/uploads', 'LA\UploadsController');
	Route::post(config('laraadmin.adminRoute') . '/upload_files', 'LA\UploadsController@upload_files');
	Route::get(config('laraadmin.adminRoute') . '/uploaded_files', 'LA\UploadsController@uploaded_files');
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_caption', 'LA\UploadsController@update_caption');
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_filename', 'LA\UploadsController@update_filename');
	Route::post(config('laraadmin.adminRoute') . '/uploads_update_public', 'LA\UploadsController@update_public');
	Route::post(config('laraadmin.adminRoute') . '/uploads_delete_file', 'LA\UploadsController@delete_file');

	/* ================== Roles ================== */
	Route::resource(config('laraadmin.adminRoute') . '/roles', 'LA\RolesController');
	Route::get(config('laraadmin.adminRoute') . '/role_dt_ajax', 'LA\RolesController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/save_module_role_permissions/{id}', 'LA\RolesController@save_module_role_permissions');

	/* ================== Permissions ================== */
	Route::resource(config('laraadmin.adminRoute') . '/permissions', 'LA\PermissionsController');
	Route::get(config('laraadmin.adminRoute') . '/permission_dt_ajax', 'LA\PermissionsController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/save_permissions/{id}', 'LA\PermissionsController@save_permissions');

	/* ================== Departments ================== */
	Route::resource(config('laraadmin.adminRoute') . '/departments', 'LA\DepartmentsController');
	Route::get(config('laraadmin.adminRoute') . '/department_dt_ajax', 'LA\DepartmentsController@dtajax');

	/* ================== Employees ================== */
	Route::resource(config('laraadmin.adminRoute') . '/employees', 'LA\EmployeesController');
	//Route::get(config('laraadmin.adminRoute') . '/employee_dt_ajax', 'LA\EmployeesController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/change_password/{id}', 'LA\EmployeesController@change_password');
	Route::get(config('laraadmin.adminRoute') . '/employee_dt_ajax', 'LA\EmployeesController@dtajax');

	/* ================== Organizations ================== */
	Route::resource(config('laraadmin.adminRoute') . '/organizations', 'LA\OrganizationsController');
	Route::get(config('laraadmin.adminRoute') . '/organization_dt_ajax', 'LA\OrganizationsController@dtajax');

	/* ================== Backups ================== */
	Route::resource(config('laraadmin.adminRoute') . '/backups', 'LA\BackupsController');
	Route::get(config('laraadmin.adminRoute') . '/backup_dt_ajax', 'LA\BackupsController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/create_backup_ajax', 'LA\BackupsController@create_backup_ajax');
	Route::get(config('laraadmin.adminRoute') . '/downloadBackup/{id}', 'LA\BackupsController@downloadBackup');

		/* ================== Racks ================== */
	Route::resource(config('laraadmin.adminRoute') . '/racks', 'LA\RacksController');
	Route::get(config('laraadmin.adminRoute') . '/rack_dt_ajax', 'LA\RacksController@dtajax');
	Route::resource(config('laraadmin.adminRoute') . '/showkendaraan', 'LA\RacksController@showkendaraan');
	Route::resource(config('laraadmin.adminRoute') . '/updatekendaraan', 'LA\RacksController@updatekendaraan');
	Route::resource(config('laraadmin.adminRoute') . '/rackskendaraan', 'LA\RacksController@editkendaraan');
	Route::get(config('laraadmin.adminRoute') . '/rackss/insrack', 'LA\RacksController@insrack');
	Route::get(config('laraadmin.adminRoute') . '/rack_dt_ajax_kendaraan', 'LA\RacksController@dtajaxkendaraan');
	Route::get(config('laraadmin.adminRoute') .'/rackskendaraanscari', 'LA\RacksController@loadDataracksKendaraan');
	Route::post(config('laraadmin.adminRoute'). '/bcdsolo', 'LA\RacksController@bcdsolo');
	//Route::post(config('laraadmin.adminRoute'). '/bcdsolo', 'LA\RacksController@digsig');

		/* ================== Storages ================== */
	Route::resource(config('laraadmin.adminRoute') . '/storages', 'LA\StoragesController');
	Route::get(config('laraadmin.adminRoute') . '/storage_dt_ajax', 'LA\StoragesController@dtajax');

		/* ================== Kendaraans ================== */
	//Route::resource(config('laraadmin.adminRoute') . '/kendaraans/{kdbidang}/{kdunit}/{kdsub}', 'LA\KendaraansController');
	Route::resource(config('laraadmin.adminRoute') . '/kendaraans', 'LA\KendaraansController');
	Route::get(config('laraadmin.adminRoute') . '/kendaraan_dt_ajax', 'LA\KendaraansController@dtajax');

	Route::get(config('laraadmin.adminRoute') .'/kendaraanscari/{kdbidangs}/{kdunits}/{kdsubs}', 'LA\KendaraansController@loadDatakendaraanadmin');
	Route::get(config('laraadmin.adminRoute') .'/kendaraanspajak', 'LA\KendaraansController@loadDatapajak');
	Route::get(config('laraadmin.adminRoute'). '/prints/{id}', 'LA\KendaraansController@print');
	Route::post(config('laraadmin.adminRoute'). '/printsolo', 'LA\KendaraansController@printsolo');
	Route::get(config('laraadmin.adminRoute') . '/kendaraansload/{kdbidang}/{kdunit}/{kdsub}/', 'LA\KendaraansController@loaddatakend');
	Route::get(config('laraadmin.adminRoute') .'/kendaraansload_getunit/{id}', 'LA\KendaraansController@unit')->name('KendaraansController.unit');
	Route::get(config('laraadmin.adminRoute') .'/kendaraansload_getsubunit/{id}/{ids}', 'LA\KendaraansController@subunit')->name('KendaraansController.subunit');
	Route::get(config('laraadmin.adminRoute') . '/kendaraan_unit/{ids}', 'LA\KendaraansController@unit');
	Route::get(config('laraadmin.adminRoute') . '/kendaraan_sub/{ids}/{idss}', 'LA\KendaraansController@sub');
	Route::get(config('laraadmin.adminRoute') . '/verifkend/{id}', 'LA\KendaraansController@verifkend');
	Route::get(config('laraadmin.adminRoute') . '/verifreleasekend/{id}', 'LA\KendaraansController@verifkendrelease');
	Route::get(config('laraadmin.adminRoute'). '/csvkendall/{kdbidang}/{kdunit}/{kdsub}', 'LA\KendaraansController@csvkendall');
		/* ================== Kibbs ================== */
	Route::resource(config('laraadmin.adminRoute') . '/kibbs', 'LA\KibbsController');
	Route::get(config('laraadmin.adminRoute') . '/kibb_dt_ajax', 'LA\KibbsController@dtajax');
	Route::get(config('laraadmin.adminRoute') . '/kibbs_unit/{ids}', 'LA\KibbsController@unit');
	Route::get(config('laraadmin.adminRoute') . '/kibbs_sub/{ids}/{idss}', 'LA\KibbsController@sub');
	Route::get(config('laraadmin.adminRoute') . '/kibbs_upb/{ids}/{idss}/{idsss}', 'LA\KibbsController@upb');
	Route::get(config('laraadmin.adminRoute') . '/daftar_barang_rek1/{ids}', 'LA\KibbsController@rekening1');
	Route::get(config('laraadmin.adminRoute') . '/daftar_barang_rek2/{ids}/{idss}', 'LA\KibbsController@rekening2');
	Route::get(config('laraadmin.adminRoute') . '/daftar_barang_rek3/{ids}/{idss}/{ids3}', 'LA\KibbsController@rekening3');
	Route::get(config('laraadmin.adminRoute') . '/daftar_barang_rek4/{ids}/{idss}/{ids3}/{ids4}', 'LA\KibbsController@rekening4');
	Route::get(config('laraadmin.adminRoute') . '/loadDatakibbs/{kdbidang}/{kdunit}/{kdsub}/{ids}/{idss}/{ids3}/{ids4}/{kond}', 'LA\KibbsController@loadDatakibbs');
	Route::get(config('laraadmin.adminRoute') . '/loadDatakibbsupb/{kdbidang}/{kdunit}/{kdsub}/{kdupb}/{ids}/{idss}/{ids3}/{ids4}/{kond}', 'LA\KibbsController@loadDatakibbsupb');
	Route::post(config('laraadmin.adminRoute') . '/kibbs/upload-file', 'LA\KibbsController@imageupload');
	Route::post(config('laraadmin.adminRoute') . '/kibbs/updpemegangbrg/{id}', 'LA\KibbsController@pemegangbrg');
	Route::get(config('laraadmin.adminRoute'). '/label/{id}', 'LA\KibbsController@label');
	Route::get(config('laraadmin.adminRoute'). '/printkibball/{kdbidang}/{kdunit}/{kdsub}/{ids}/{idss}/{ids3}/{ids4}/{kond}', 'LA\KibbsController@printkibball');
	Route::get(config('laraadmin.adminRoute'). '/csvkibball/{kdbidang}/{kdunit}/{kdsub}/{ids}/{idss}/{ids3}/{ids4}/{kond}', 'LA\KibbsController@csvkibball');
	Route::get(config('laraadmin.adminRoute'). '/csvkibballupb/{kdbidang}/{kdunit}/{kdsub}/{kdupb}/{ids}/{idss}/{ids3}/{ids4}/{kond}', 'LA\KibbsController@csvkibballupb');




		/* ================== Logacts ================== */
	Route::resource(config('laraadmin.adminRoute') . '/logacts', 'LA\LogactsController');
	Route::get(config('laraadmin.adminRoute') . '/logact_dt_ajax', 'LA\LogactsController@dtajax');
	Route::get(config('laraadmin.adminRoute') . '/loaddata', 'LA\LogactsController@loadDatalog');

	/* ================== Loanings ================== */
	Route::resource(config('laraadmin.adminRoute') . '/loanings', 'LA\LoaningsController');
	Route::get(config('laraadmin.adminRoute') . '/loaning_dt_ajax', 'LA\LoaningsController@dtajax');
	Route::get(config('laraadmin.adminRoute') . '/dipinjam_dt_ajax', 'LA\LoaningsController@dtajaxdipinjam');
	Route::get(config('laraadmin.adminRoute') . '/loanings/pengembalian/{id}', 'LA\LoaningsController@pengembalian');

	/* ================== Verifikasi_kendaraans ================== */
	Route::resource(config('laraadmin.adminRoute') . '/verifikasi_kendaraans', 'LA\Verifikasi_kendaraansController');
	Route::get(config('laraadmin.adminRoute') . '/notverifikasikendaraanscari', 'LA\Verifikasi_kendaraansController@loadDataNotverif');
	Route::get(config('laraadmin.adminRoute') . '/verifikasikendaraanscari', 'LA\Verifikasi_kendaraansController@loadDataverif');
	Route::get(config('laraadmin.adminRoute') . '/verifikasi_kendaraans/verif/{id}', 'LA\Verifikasi_kendaraansController@verif');
	Route::get(config('laraadmin.adminRoute') . '/verifikasi_kendaraans/verifpajak/{id}', 'LA\Verifikasi_kendaraansController@verifpajak');


	/* ================== Pengajuan_loanings ================== */
	Route::resource(config('laraadmin.adminRoute') . '/pengajuan_loanings', 'LA\Pengajuan_loaningsController');
	Route::get(config('laraadmin.adminRoute') . '/pengajuan_loaning_dt_ajax', 'LA\Pengajuan_loaningsController@dtajax');
	Route::get(config('laraadmin.adminRoute') . '/verif_pengajuan_loan/verif_loan/{id}', 'LA\Pengajuan_loaningsController@verif_pengajuan_loan');

	/* ================== Rekonsiliasi_opds ================== */
	/* Route::resource(config('laraadmin.adminRoute') . '/rekonsiliasi_opds', 'LA\Rekonsiliasi_opdsController');
	Route::get(config('laraadmin.adminRoute') . '/rekonsiliasi_opd_dt_ajax', 'LA\Rekonsiliasi_opdsController@dtajax'); */

	/* ================== Rekonsiliasi_asets ================== */
	Route::resource(config('laraadmin.adminRoute') . '/rekonsiliasi_asets', 'LA\Rekonsiliasi_asetsController');
	Route::get(config('laraadmin.adminRoute') . '/rekonsiliasi_aset_dt_ajax', 'LA\Rekonsiliasi_asetsController@dtajax');
	//Route::get(config('laraadmin.adminRoute') . '/rekonsiliasi_aset_datarekon/{tahunp}/{kdbidang}/{kdunit}/{kdsub}', 'LA\Rekonsiliasi_asetsController@loadDatarekonaset');
	Route::get(config('laraadmin.adminRoute') . '/rekonsiliasi_aset_datarekon/{saldoawals}/{saldoakhirs}/{kdbidang}/{kdunit}/{kdsub}', 'LA\Rekonsiliasi_asetsController@loadDatarekonaset');
	Route::get(config('laraadmin.adminRoute') .'/rekonsiliasi_aset_getunit/{id}', 'LA\Rekonsiliasi_asetsController@unit')->name('rekonsiliasi_opds_unit.unit');
	Route::get(config('laraadmin.adminRoute') .'/rekonsiliasi_aset_getsubunit/{id}/{ids}', 'LA\Rekonsiliasi_asetsController@subunit')->name('rekonsiliasi_opds_subunit.subunit');
	Route::get(config('laraadmin.adminRoute') .'/rekonsiliasi_aset_getupb/{id}/{ids}/{idss}', 'LA\Rekonsiliasi_asetsController@upb')->name('rekonsiliasi_opds_upb.upb');
	Route::get(config('laraadmin.adminRoute') .'/kk_opd/{tahun}/{tglawal}/{tglakhir}/{id}/{ids}/{idss}', 'LA\Rekonsiliasi_asetsController@kkopd');
	Route::get(config('laraadmin.adminRoute') .'/kk_upb/{tahun}/{tglawal}/{tglakhir}/{id}/{ids}/{idss}/{idsss}', 'LA\Rekonsiliasi_asetsController@kkupb');
	Route::get(config('laraadmin.adminRoute') .'/kk_unit/{tahun}/{tglawal}/{tglakhir}/{id}/{ids}', 'LA\Rekonsiliasi_asetsController@kkunit');

	/* ================== Kibas ================== */
	Route::resource(config('laraadmin.adminRoute') . '/kibas', 'LA\KibasController');
	Route::get(config('laraadmin.adminRoute')  . '/charts_a', 'LA\KibasController@chart');
	Route::get(config('laraadmin.adminRoute') .'/kibascari/{kdbidangs}/{kdunits}/{kdsubs}', 'LA\KibasController@loadDataTanahadmin');
	Route::get(config('laraadmin.adminRoute'). '/print/{id}', 'LA\KibasController@print');
	Route::post(config('laraadmin.adminRoute'). '/printsolotanah', 'LA\KibasController@printsolo');
	Route::get(config('laraadmin.adminRoute'). '/printtanahanpemkab', 'LA\KibasController@printtanahanpemkab');
	Route::get(config('laraadmin.adminRoute'). '/printtanahsert', 'LA\KibasController@printtanahsert');
	Route::get(config('laraadmin.adminRoute') . '/kibas_unit/{ids}', 'LA\KibasController@unit');
	Route::get(config('laraadmin.adminRoute') . '/kibas_sub/{ids}/{idss}', 'LA\KibasController@sub');
	Route::get(config('laraadmin.adminRoute') . '/verif/{id}', 'LA\KibasController@verifgeo');
	Route::get(config('laraadmin.adminRoute') . '/verifrelease/{id}', 'LA\KibasController@verifgeorelease');
	Route::get(config('laraadmin.adminRoute'). '/csvkibaall/{kdbidang}/{kdunit}/{kdsub}', 'LA\KibasController@csvkibaall');




	/* ================== kibc_s ================== */
  Route::resource(config('laraadmin.adminRoute') . '/kibc_s', 'LA\Kibc_sController');
    Route::get(config('laraadmin.adminRoute') . '/kibc_s_dt_ajax', 'LA\Kibc_sController@dtajax');
	Route::get(config('laraadmin.adminRoute') . '/kibc_s/{id}/edit/{keterangan}', 'LA\Kibc_sController@edit');
    Route::get(config('laraadmin.adminRoute') . '/kibc_scari/{kdbidang}/{kdunit}/{kdsub}/{kdupb}', 'LA\Kibc_sController@LoadDataKibc_s');
    //Route::get(config('laraadmin.adminRoute') . '/imb_load/{kdbidang}/{kdunit}/{kdsub}', 'LA\Kibc_sController@LoadDataImbadmin');
    Route::get(config('laraadmin.adminRoute'). '/printgedung/{id}', 'LA\Kibc_sController@printgb');
    Route::post(config('laraadmin.adminRoute'). '/printsologedung', 'LA\Kibc_sController@printsologb');
    Route::get(config('laraadmin.adminRoute'). '/printimb/{id}', 'LA\Kibc_sController@prints');
    Route::post(config('laraadmin.adminRoute'). '/printsoloimb', 'LA\Kibc_sController@printsoloimb');
    Route::get(config('laraadmin.adminRoute') . '/kibc_s_unit/{ids}', 'LA\Kibc_sController@unit');
    Route::get(config('laraadmin.adminRoute') . '/kibc_s_sub/{ids}/{idss}', 'LA\Kibc_sController@sub');
	Route::get(config('laraadmin.adminRoute') . '/kibc_s_upb/{ids}/{idss}/{idsss}', 'LA\Kibc_sController@upb');
    Route::get(config('laraadmin.adminRoute') . '/tanah_rek1/{ids}', 'LA\Kibc_sController@rekening1');
    Route::get(config('laraadmin.adminRoute') . '/tanah_rek2/{ids}/{idss}', 'LA\Kibc_sController@rekening2');
    Route::get(config('laraadmin.adminRoute') . '/tanah_rek3/{ids}/{idss}/{ids3}', 'LA\Kibc_sController@rekening3');
    Route::get(config('laraadmin.adminRoute') . '/tanah_rek4/{ids}/{idss}/{ids3}/{ids4}', 'LA\Kibc_sController@rekening4');
    Route::get(config('laraadmin.adminRoute') . '/brgshow/{id}/{kdbidang}/{kdunit}/{kdsub}/{kdupb}/{ids}/{idss}/{ids3}/{ids4}',
        'LA\Kibc_sController@showtanah');
    Route::post(config('laraadmin.adminRoute') . '/updbrg/{idpemda}/{id0}/{ids}/{idss}/{ids3}/{ids4}/{tanah}',
        'LA\Kibc_sController@updbrg');
    Route::post(config('laraadmin.adminRoute') . '/kibc_s/upload-file', 'LA\Kibc_sController@imageupload');
	Route::post(config('laraadmin.adminRoute') . '/hapusfile{id}', 'LA\Kibc_sController@hapus');
    Route::get(config('laraadmin.adminRoute').'/verifgedung/{id}','LA\Kibc_sController@verifgb');
    Route::get(config('laraadmin.adminRoute').'/verifcek/{id}','LA\Kibc_sController@verifsave');
	/* ================== Ajuan_penghapusanpbps ================== */
	Route::resource(config('laraadmin.adminRoute') . '/ajuan_penghapusanpbps', 'LA\Ajuan_penghapusanpbpsController');
	Route::get(config('laraadmin.adminRoute') . '/ajuan_penghapusanpbp_dt_ajax', 'LA\Ajuan_penghapusanpbpsController@dtajax');
	Route::get(config('laraadmin.adminRoute') . '/ajuan_penghapusanpbp_rek1/{ids}', 'LA\Ajuan_penghapusanpbpsController@rekening1');
	Route::get(config('laraadmin.adminRoute') . '/ajuan_penghapusanpbp_rek2/{ids}/{idss}', 'LA\Ajuan_penghapusanpbpsController@rekening2');
	Route::get(config('laraadmin.adminRoute') . '/showbarangphppbp/{id}/{ids}/{idss}/{ids3}/{ids4}/{kond}', 'LA\Ajuan_penghapusanpbpsController@showbarang');
	Route::post(config('laraadmin.adminRoute') . '/addbrgpbp/{idajuan}/{idpemda}/{id0}/{ids}/{idss}/{ids3}/{ids4}', 'LA\Ajuan_penghapusanpbpsController@addbrg');
	Route::get(config('laraadmin.adminRoute') . '/delbrgpbp/{id}/', 'LA\Ajuan_penghapusanpbpsController@delbrg');
	Route::get(config('laraadmin.adminRoute') . '/ajuan_penghapusanpbps/ajukanpb/{id}', 'LA\Ajuan_penghapusanpbpsController@ajukanpb');
	Route::get(config('laraadmin.adminRoute') . '/ajuan_penghapusanpbps/ajukanaset/{id}', 'LA\Ajuan_penghapusanpbpsController@ajukanaset');

	/* ================== File Penghapusan Pembantu Pengurus Barang ================== */
	Route::post(config('laraadmin.adminRoute') . '/ajuan_penghapusanpbps/upload-file/{id}', 'LA\Ajuan_penghapusanpbpsController@imageupload')->name('imageupload/{id}');
	Route::post(config('laraadmin.adminRoute') . '/ajuan_penghapusanpbps/upload-pdf/{id}', 'LA\Ajuan_penghapusanpbpsController@fileupload')->name('fileupload/{id}');

	/* ================== Ajuan_penghapusanpbs ================== */
	Route::resource(config('laraadmin.adminRoute') . '/ajuan_penghapusanpbs', 'LA\Ajuan_penghapusanpbsController');
	Route::get(config('laraadmin.adminRoute') . '/ajuan_penghapusanpb_dt_ajax', 'LA\Ajuan_penghapusanpbsController@dtajax');
	Route::get(config('laraadmin.adminRoute') . '/ajuan_penghapusanpb_rek1/{ids}', 'LA\Ajuan_penghapusanpbsController@rekening1');
	Route::get(config('laraadmin.adminRoute') . '/ajuan_penghapusanpb_rek2/{ids}/{idss}', 'LA\Ajuan_penghapusanpbsController@rekening2');
	Route::get(config('laraadmin.adminRoute') . '/ajuan_penghapusanpb_rek3/{ids}/{idss}/{ids3}', 'LA\Ajuan_penghapusanpbsController@rekening3');
	Route::get(config('laraadmin.adminRoute') . '/ajuan_penghapusanpb_rek4/{ids}/{idss}/{ids3}/{ids4}', 'LA\Ajuan_penghapusanpbsController@rekening4');
	Route::get(config('laraadmin.adminRoute') . '/showbarangphppb/{id}/{ids}/{idss}/{ids3}/{ids4}/{kond}', 'LA\Ajuan_penghapusanpbsController@showbarang');
	Route::get(config('laraadmin.adminRoute') . '/addbrgpb/{idajuan}/{idpemda}/{id0}/{ids}/{idss}/{ids3}/{ids4}', 'LA\Ajuan_penghapusanpbsController@addbrg'); //ubah
	Route::get(config('laraadmin.adminRoute') . '/delbrgpb/{id}', 'LA\Ajuan_penghapusanpbsController@delbrg'); //ubah
	Route::get(config('laraadmin.adminRoute') . '/ajuan_penghapusanpbs/ajukanaset/{id}', 'LA\Ajuan_penghapusanpbsController@ajukanaset');
	Route::get(config('laraadmin.adminRoute') . '/ajuan_penghapusanpbs/batalkanaset/{id}', 'LA\Ajuan_penghapusanpbsController@batalkanaset');
	Route::get(config('laraadmin.adminRoute') . '/ajuan_penghapusanpbs/ajukanasetpb/{id}', 'LA\Ajuan_penghapusanpbsController@ajukanasetpb');
	Route::get(config('laraadmin.adminRoute') . '/ajuan_penghapusanpbs/ajukanpb2/{id}', 'LA\Ajuan_penghapusanpbsController@ajukanpb2');
	Route::get(config('laraadmin.adminRoute') . '/ajuan_penghapusanpbs/ajukanusulpbp/{id}', 'LA\Ajuan_penghapusanpbsController@ajukanasetpbusulpb');
	Route::get(config('laraadmin.adminRoute') . '/ajuan_penghapusanpbs/showpbp/{id}', 'LA\Ajuan_penghapusanpbsController@showpbp');
	Route::get(config('laraadmin.adminRoute') . '/populateidpb', 'LA\Ajuan_penghapusanpbsController@showidpbp');
	Route::get(config('laraadmin.adminRoute') . '/populateidreftable', 'LA\Ajuan_penghapusanpbsController@showidreftable');
	Route::get(config('laraadmin.adminRoute') . '/ajuan_penghapusanpb_dt_ajax2', 'LA\Ajuan_penghapusanpbsController@dtajaxpb');
	Route::get(config('laraadmin.adminRoute'). '/printlampiranpbp/{id}', 'LA\Ajuan_penghapusanpbpsController@printlampiranphp');
	Route::get(config('laraadmin.adminRoute'). '/printlampiranpbppb/{id}', 'LA\Ajuan_penghapusanpbsController@printlampiranphppbs');

	/* ================== File Penghapusan Pembantu Pengurus Barang ================== */
	Route::post(config('laraadmin.adminRoute') . '/ajuan_penghapusanpbs/upload-file/{id}', 'LA\Ajuan_penghapusanpbsController@imageupload')->name('imageupload/{id}');
	Route::post(config('laraadmin.adminRoute') . '/ajuan_penghapusanpbs/upload-pdf/{id}', 'LA\Ajuan_penghapusanpbsController@fileupload')->name('fileupload/{id}');

	/* ================== Penghapusan_items ================== */
	Route::resource(config('laraadmin.adminRoute') . '/penghapusan_items', 'LA\Penghapusan_itemsController');
	Route::get(config('laraadmin.adminRoute') . '/penghapusan_item_dt_ajax', 'LA\Penghapusan_itemsController@dtajax');
	Route::get(config('laraadmin.adminRoute') . '/dt_ajax_item', 'LA\Penghapusan_itemsController@dtajaxitem');
	Route::get(config('laraadmin.adminRoute') . '/updatelocation/{id}', 'LA\Penghapusan_itemsController@updatelocation');
	Route::get(config('laraadmin.adminRoute') . '/updatelocationopd/{id}', 'LA\Penghapusan_itemsController@updatelocationopd');
	Route::get(config('laraadmin.adminRoute') . '/penghapusan_items/item_ajuan/{id}', 'LA\Penghapusan_itemsController@itemajuan');
	Route::get(config('laraadmin.adminRoute') . '/penghapusan_items/item_ajuan_pb/{id}', 'LA\Penghapusan_itemsController@updatelocation');
	Route::get(config('laraadmin.adminRoute') . '/penghapusan_items/item_ajuan_pbp/{id}', 'LA\Penghapusan_itemsController@updatelocation');
	Route::get(config('laraadmin.adminRoute') . '/penghapusan_items/edit_ajuan/{id}', 'LA\Penghapusan_itemsController@editajuan');
	Route::get(config('laraadmin.adminRoute') . '/penghapusan_items/{id}/edit', 'LA\Penghapusan_itemsController@edit');
	Route::get(config('laraadmin.adminRoute') . '/edit_ajuan/valaset/{id}', 'LA\Penghapusan_itemsController@valaset');
	Route::get(config('laraadmin.adminRoute') . '/edit_ajuan/valtimpenilai/{id}', 'LA\Penghapusan_itemsController@valtimpenilai');
	Route::get(config('laraadmin.adminRoute') . '/edit_ajuan/updateadm/{id}', 'LA\Penghapusan_itemsController@update_adm');
	Route::get(config('laraadmin.adminRoute') . '/edit_ajuan/valasetsesuai/{id}', 'LA\Penghapusan_itemsController@valasetsesuai');
	Route::get(config('laraadmin.adminRoute') . '/edit_ajuan/valasettidak/{id}', 'LA\Penghapusan_itemsController@valasettidak');
	Route::get(config('laraadmin.adminRoute') . '/edit_ajuan/valasetalasan/{id}', 'LA\Penghapusan_itemsController@valasetalasan');

	/* ================== Adm_penghapusans ================== */
	Route::resource(config('laraadmin.adminRoute') . '/adm_penghapusans', 'LA\Adm_penghapusansController');
	Route::get(config('laraadmin.adminRoute') . '/adm_penghapusan_dt_ajax', 'LA\Adm_penghapusansController@dtajax');
	Route::post(config('laraadmin.adminRoute') . '/adm_penghapusans/uploadfile/{id}', 'LA\Adm_penghapusansController@fileupload');
	Route::post(config('laraadmin.adminRoute') . '/adm_penghapusans/uploadsk/{id}', 'LA\Adm_penghapusansController@fileuploadsk');
	Route::post(config('laraadmin.adminRoute') . '/adm_penghapusans/uploadba/{id}', 'LA\Adm_penghapusansController@fileuploadba');
	Route::get(config('laraadmin.adminRoute') . '/showbarangaadm/{id}', 'LA\Adm_penghapusansController@showbarang');
	Route::post(config('laraadmin.adminRoute') . '/updatebrgidphp/{id}/{idpemda}', 'LA\Adm_penghapusansController@updatebrgadm');
	Route::post(config('laraadmin.adminRoute') . '/delbrgidphp/{id}', 'LA\Adm_penghapusansController@delbrgadm');
	Route::get(config('laraadmin.adminRoute') . '/hapusbarangaset/{id}', 'LA\Adm_penghapusansController@hapusbarangaset');

/* ================== Daftar_pegawais ================== */
	Route::resource(config('laraadmin.adminRoute') . '/daftar_pegawais', 'LA\Daftar_pegawaisController');
	Route::get(config('laraadmin.adminRoute') . '/daftar_pegawai_dt_ajax', 'LA\Daftar_pegawaisController@dtajax');
	Route::get(config('laraadmin.adminRoute') . '/daftar_pegawai_cari/{kdbidangs}/{kdunits}/{kdsubs}', 'LA\Daftar_pegawaisController@dtajax');
	Route::get(config('laraadmin.adminRoute') . '/daftar_barang_rek1/{ids}', 'LA\Daftar_pegawaisController@rekening1');
	Route::get(config('laraadmin.adminRoute') . '/daftar_barang_rek2/{ids}/{idss}', 'LA\Daftar_pegawaisController@rekening2');
	Route::get(config('laraadmin.adminRoute') . '/daftar_barang_rek3/{ids}/{idss}/{ids3}', 'LA\Daftar_pegawaisController@rekening3');
	Route::get(config('laraadmin.adminRoute') . '/daftar_barang_rek4/{ids}/{idss}/{ids3}/{ids4}', 'LA\Daftar_pegawaisController@rekening4');
	Route::get(config('laraadmin.adminRoute') . '/showbarang/{id}/{kdbidang}/{kdunit}/{kdsub}/{kdupb}/{ids}/{idss}/{ids3}/{ids4}/{kond}', 'LA\Daftar_pegawaisController@showbarang');
	Route::get(config('laraadmin.adminRoute') . '/updbrg/{idpemda}/{id0}/{ids}/{idss}/{ids3}/{ids4}/{pemegang}', 'LA\Daftar_pegawaisController@updbrg'); //ubah
	Route::get(config('laraadmin.adminRoute') . '/delbrgpemegang/{id}', 'LA\Daftar_pegawaisController@delbrg');
	Route::post(config('laraadmin.adminRoute') . '/daftar_pegawais/upload-file/{id}/{idpemda}', 'LA\Daftar_pegawaisController@imageupload')->name('imageupload/{id}');
	Route::get(config('laraadmin.adminRoute'). '/printbrgpgw/{id}', 'LA\Daftar_pegawaisController@printbrgpgw');
});
