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

use App\User;

class UsersController extends Controller
{
	public $show_action = false;
	public $view_col = 'name';
	public $listing_cols = ['id', 'name', 'email', 'type'];
	
	public function __construct() {
		// Field Access of Listing Columns
		if(\Dwij\Laraadmin\Helpers\LAHelper::laravel_ver() == 5.3) {
			$this->middleware(function ($request, $next) {
				$this->listing_cols = ModuleFields::listingColumnAccessScan('Users', $this->listing_cols);
				return $next($request);
			});
		} else {
			$this->listing_cols = ModuleFields::listingColumnAccessScan('Users', $this->listing_cols);
		}
	}
	
	/**
	 * Display a listing of the Users.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$module = Module::get('Users');
		
		if(Module::hasAccess($module->id)) {
			return View('la.users.index', [
				'show_actions' => $this->show_action,
				'listing_cols' => $this->listing_cols,
				'module' => $module
			]);
		} else {
            return redirect(config('laraadmin.adminRoute')."/");
        }
	}

	/**
	 * Display the specified user.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		if(Module::hasAccess("Users", "view")) {
			$user = User::findOrFail($id);
			if(isset($user->id)) {
				if($user['type'] == "Employee") {
					return redirect(config('laraadmin.adminRoute') . '/employees/'.$user->id);
				} else if($user['type'] == "Client") {
					return redirect(config('laraadmin.adminRoute') . '/clients/'.$user->id);
				}
			} else {
				return view('errors.404', [
					'record_id' => $id,
					'record_name' => ucfirst("user"),
				]);
			}
		} else {
			return redirect(config('laraadmin.adminRoute')."/");
		}
	}
	
	/**
	 * Datatable Ajax fetch
	 *
	 * @return
	 */
	public function dtajax(Request $request){
		if(Module::hasAccess("Users", "view")) {
			if ($request->ajax()) {
					$output = '';
					$query = $request->get('query');
					if ($query != '') {
						$data = DB::table('employees as e')
								->leftjoin('departments as dept','e.dept','=','dept.id')
								->leftjoin('users as u','e.id','=','u.id')
								->select('u.id','u.name','u.email','dept.name as department')
								->where('u.name','like','%'.$query.'%')
								->get();
					}else {
						$data =DB::table('employees as e')
								->leftjoin('departments as dept','e.dept','=','dept.id')
								->leftjoin('users as u','e.id','=','u.id')
								->select('u.id','u.name','u.email','dept.name as department')
								->get();	
					} 
					$total_row = count($data);
					  if($total_row > 0){
					   foreach($data as $index=>$row){
						    $index = $index+1;
						   if(Module::hasAccess("Loanings", "edit")){
							$output .= '
							<tr>
							 <td>'.$index.'</td>
							 <td><a href="'.url(config('laraadmin.adminRoute') . '/employees/'.$row->id).'">'.$row->name.'</a></td>
							 <td>'.$row->name.'</td>
							 <td>'.$row->email.'</td>
							 <td>'.$row->department.'</td>
							</tr>';
						   }else{
							   $output .= '
							<tr>
							 <td>'.$index.'</td>
							 <td><a href="'.url(config('laraadmin.adminRoute') . '/employees/'.$row->id).'">'.$row->name.'</a></td>
							 <td>'.$row->name.'</td>
							 <td>'.$row->email.'</td>
							 <td>'.$row->department.'</td>
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
}
