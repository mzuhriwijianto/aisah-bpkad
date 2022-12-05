<?php
/**
 * Migration genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Dwij\Laraadmin\Models\Module;

class CreateKibcSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Module::generate("Kibc_s", 'kibc_s', 'idpemdas', 'fa-cube', [
            ["idpemdas", "IDPemdas", "String", false, "", 17, 17, false],
            ["koordx", "KoordX", "String", false, "", 0, 25, true],
            ["koordy", "KoordY", "String", false, "", 0, 25, true],
            ["tgl_perolehan", "Tgl Perolehan", "Date", false, "", 0, 0, false],
            ["dokumen_tanggal", "Tgl Dokumen", "Date", false, "", 0, 0, false],
            ["dokumen_nomor", "Nomor Dokumen", "String", false, "", 0, 256, false],
            ["lokasi_tanah", "Lokasi Tanah", "String", false, "", 0, 256, false],
            ["lokasi", "Lokasi", "Address", false, "", 0, 256, false],
            ["status_tanah", "Status Tanah", "String", false, "", 0, 256, false],
            ["kd_bidang", "Kode Bidang", "Integer", false, "", 0, 11, false],
            ["kd_sub", "Kode Sub", "Integer", false, "", 0, 11, false],
            ["kd_unit", "Kode Unit", "Integer", false, "", 0, 11, false],
            ["kd_upb", "Kode UPB", "Integer", false, "", 0, 11, false],
            ["no_register", "No Reg", "Integer", false, "", 0, 11, false],
            ["upload_dok_imb", "Dokumen IMB", "File", false, "", 0, 0, false],
            ["photo_gedung", "Foto Gedung", "File", false, "", 0, 0, false],
            ["pemanfaatan", "Pemanfaatan", "Dropdown", false, "", 0, 0, false, ["Pemkab Bojonegoro","Idle","Sewa","Pinjam Pakai","KSP","BSG","BGS","KSPI"]],
            ["tgl_awal_imb", "Tgl Terbit IMB", "Date", false, "", 0, 0, false],
            ["tgl_akhir_imb", "Tgl Akhir IMB", "Date", false, "", 0, 0, false],
            ["no_imb_baru", "Nomor IMB Baru", "TextField", false, "", 0, 256, false],
            ["no_imb_lama", "Nomor IMB Lama", "TextField", false, "", 0, 256, false],
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
        if (Schema::hasTable('kibc_s')) {
            Schema::drop('kibc_s');
        }
    }
}
