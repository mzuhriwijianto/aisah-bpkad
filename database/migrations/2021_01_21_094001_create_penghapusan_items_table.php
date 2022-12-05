<?php
/**
 * Migration genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Dwij\Laraadmin\Models\Module;

class CreatePenghapusanItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Module::generate("Penghapusan_items", 'penghapusan_items', 'no_ajuan', 'fa-eraser', [
            ["no_ajuan", "no_ajuan", "String", false, "", 0, 256, false],
            ["Idpemda", "Idpemda", "String", false, "", 0, 256, false],
            ["validation_img", "Validation_img", "String", false, "", 0, 256, false],
            ["validation_by", "Validation_by", "Integer", false, "", 0, 11, false],
            ["validation_at", "Validation_at", "Datetime", false, "", 0, 0, false],
            ["kd_aset8", "kd_aset8", "Integer", false, "", 0, 11, false],
            ["kd_aset80", "kd_aset80", "Integer", false, "", 0, 11, false],
            ["kd_aset81", "kd_aset81", "Integer", false, "", 0, 11, false],
            ["kd_aset82", "kd_aset82", "Integer", false, "", 0, 11, false],
            ["kd_aset83", "kd_aset83", "Integer", false, "", 0, 11, false],
            ["kd_aset84", "kd_aset84", "Integer", false, "", 0, 11, false],
            ["kd_aset85", "kd_aset85", "Integer", false, "", 0, 11, false],
            ["jenis_ajuan", "Jenis_ajuan", "String", false, "", 0, 256, false],
            ["location", "location", "Integer", false, "", 0, 11, false],
            ["rekom_jenis_ajuan", "rekom_jenis_ajuan", "Dropdown", false, "", 0, 0, false, ["Pemindahtanganan","Putusan Pengadilan","Menjalankan ketentuan undang-undang","Pemusnahan","Sebab lain"]],
            ["adm_php_id", "adm_php_id", "Integer", false, "", 0, 11, false],
            ["status_hapus", "status_hapus", "Integer", false, "", 0, 11, false],
            ["validation_aset", "validation_aset", "Integer", false, "", 0, 11, false],
            ["alasan", "alasan", "Dropdown", false, "", 0, 0, false, ["lengkap","Tidak Sesuai KIB","Barang Tidak Ada","Proses Administrasi"]],
        ]);
		
		/*
		Row Format:
		["field_name_db", "Label", "UI Type", "Unique", "Default_Value", "min_length", "max_length", "Required", "Pop_values"]
        Module::generate("Module_Name", "Table_Name", "view_column_name" "Fields_Array");
        
		Module::generate("Books", 'books', 'name', [
            ["address",     "Address",      "Address",  false, "",          0,  1000,   true],
            ["restricted",  "Restricted",   "Checkbox", false, false,       0,  0,      false],
            ["price",       "Price",        "Currency", false, 0.0,         0,  0,      true],
            ["date_release", "Date of Release", "Date", false, "date('Y-m-d')", 0, 0,   false],
            ["time_started", "Start Time",  "Datetime", false, "date('Y-m-d H:i:s')", 0, 0, false],
            ["weight",      "Weight",       "Decimal",  false, 0.0,         0,  20,     true],
            ["publisher",   "Publisher",    "Dropdown", false, "Marvel",    0,  0,      false, ["Bloomsbury","Marvel","Universal"]],
            ["publisher",   "Publisher",    "Dropdown", false, 3,           0,  0,      false, "@publishers"],
            ["email",       "Email",        "Email",    false, "",          0,  0,      false],
            ["file",        "File",         "File",     false, "",          0,  1,      false],
            ["files",       "Files",        "Files",    false, "",          0,  10,     false],
            ["weight",      "Weight",       "Float",    false, 0.0,         0,  20.00,  true],
            ["biography",   "Biography",    "HTML",     false, "<p>This is description</p>", 0, 0, true],
            ["profile_image", "Profile Image", "Image", false, "img_path.jpg", 0, 250,  false],
            ["pages",       "Pages",        "Integer",  false, 0,           0,  5000,   false],
            ["mobile",      "Mobile",       "Mobile",   false, "+91  8888888888", 0, 20,false],
            ["media_type",  "Media Type",   "Multiselect", false, ["Audiobook"], 0, 0,  false, ["Print","Audiobook","E-book"]],
            ["media_type",  "Media Type",   "Multiselect", false, [2,3],    0,  0,      false, "@media_types"],
            ["name",        "Name",         "Name",     false, "John Doe",  5,  250,    true],
            ["password",    "Password",     "Password", false, "",          6,  250,    true],
            ["status",      "Status",       "Radio",    false, "Published", 0,  0,      false, ["Draft","Published","Unpublished"]],
            ["author",      "Author",       "String",   false, "JRR Tolkien", 0, 250,   true],
            ["genre",       "Genre",        "Taginput", false, ["Fantacy","Adventure"], 0, 0, false],
            ["description", "Description",  "Textarea", false, "",          0,  1000,   false],
            ["short_intro", "Introduction", "TextField",false, "",          5,  250,    true],
            ["website",     "Website",      "URL",      false, "http://dwij.in", 0, 0,  false],
        ]);
		*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('penghapusan_items')) {
            Schema::drop('penghapusan_items');
        }
    }
}
