<?php
/**
 * Migration genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Dwij\Laraadmin\Models\Module;

class CreateAjuanPenghapusanpbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Module::generate("Ajuan_penghapusanpbs", 'ajuan_penghapusanpbs', 'no_ajuan', 'fa-trash', [
            ["no_ajuan", "No_ajuan", "String", false, "", 0, 256, false],
            ["opd", "Opd", "Integer", false, "", 0, 11, false],
            ["dept", "Dept", "Integer", false, "", 0, 11, false],
            ["tgl_ajuan", "Tgl_ajuan", "Date", false, "", 0, 0, false],
            ["surat_persetujuan", "Surat_persetujuan", "File", false, "", 0, 0, false],
            ["kd_bidang", "Kd_bidang", "Integer", false, "", 0, 11, false],
            ["kd_unit", "Kd_unit", "Integer", false, "", 0, 11, false],
            ["kd_sub", "Kd_sub", "Integer", false, "", 0, 11, false],
            ["validation_aset", "Validation_aset", "Integer", false, "", 0, 11, false],
            ["validation_aset_by", "Validation_aset_by", "Integer", false, "", 0, 11, false],
            ["validation_aset_at", "Validation_aset_at", "Datetime", false, "", 0, 0, false],
            ["jenis_ajuan", "Jenis_ajuan", "Dropdown", false, "", 0, 0, false, ["Putusan Pengadilan","Menjalankan ketentuan undang-undang","Pemusnahan","Sebab lain","Pemindahtanganan (Dalam bentuk Penjualan)","Pemindahtanganan (Dalam bentuk Hibah)"]],
            ["nm_opd", "Nm_OPD", "String", false, "", 0, 256, false],
            ["nm_pimpinan", "Nm_Pimpinan", "String", false, "", 0, 256, false],
            ["nip_pimpinan", "NIP_Pimpinan", "String", false, "", 0, 256, false],
            ["jbt_pimpinan", "Jbt_Pimpinan", "String", false, "", 0, 256, false],
            ["no_surat", "No_Surat", "String", false, "", 0, 256, false],
            ["perihal", "Perihal", "String", false, "", 0, 256, false],
            ["tgl_surat", "Tgl_Surat", "Date", false, "", 0, 0, false],
            ["rekom_jenis_ajuan", "rekom_jenis_ajuan", "Dropdown", false, "", 0, 0, false, ["Putusan Pengadilan","Menjalankan ketentuan undang-undang","Pemusnahan","Sebab lain","Pemindahtanganan (Dalam bentuk Penjualan)","Pemindahtanganan (Dalam bentuk Hibah)"]],
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
        if (Schema::hasTable('ajuan_penghapusanpbs')) {
            Schema::drop('ajuan_penghapusanpbs');
        }
    }
}
