<?php
/**
 * Model genrated using LaraAdmin
 * Help: http://laraadmin.com
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image_kib extends Model
{
    use SoftDeletes;
	
	protected $table = 'image_kibs';
	
	protected $hidden = [
        
    ];

	protected $guarded = [];

	//protected $dates = ['deleted_at'];
}
