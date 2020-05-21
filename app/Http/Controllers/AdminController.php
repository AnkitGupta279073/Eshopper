<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Session;
use App\User;
use App\Admin;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login(Request $request){
    	if($request->isMethod('post')){
    		$data = $request->input();
            
            $adminCount = Admin::where(['username' => $data['username'],'password'=>md5($data['password']),'status'=>1])->count(); 
           
            if($adminCount > 0){
                //echo "Success"; die;
                Session::put('adminSession', $data['username']);
                return redirect('/admin/dashboard');
        	}else{
                //echo "failed"; die;
                return redirect('/admin')->with('flash_message_error','Invalid Username or Password');
        	}
    	}
    	return view('admin.admin_login');
    }

    public function dashboard(){
        /*if(Session::has('adminSession')){
            // Perform all actions
        }else{
            //return redirect()->action('AdminController@login')->with('flash_message_error', 'Please Login');
            return redirect('/admin')->with('flash_message_error','Please Login');
        }*/
        return view('admin.dashboard');
    }

    public function settings(){

        $adminDetails = Admin::where(['username'=>Session::get('adminSession')])->first();

        //echo "<pre>"; print_r($adminDetails); die;

        return view('admin.settings')->with(compact('adminDetails'));
    }

    public function chkPassword(Request $request){
        $data = $request->all();
        //echo "<pre>"; print_r($data); die;
        $adminCount = Admin::where(['username' => Session::get('adminSession'),'password'=>md5($data['current_pwd'])])->count(); 
            if ($adminCount == 1) {
                //echo '{"valid":true}';die;
                echo "true"; die;
            } else {
                //echo '{"valid":false}';die;
                echo "false"; die;
            }

    }

    public function updatePassword(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $adminCount = Admin::where(['username' => Session::get('adminSession'),'password'=>md5($data['current_pwd'])])->count();

            if ($adminCount == 1) {
                // here you know data is valid
                $password = md5($data['new_pwd']);
                Admin::where('username',Session::get('adminSession'))->update(['password'=>$password]);
                return redirect('/admin/settings')->with('flash_message_success', 'Password updated successfully.');
            }else{
                return redirect('/admin/settings')->with('flash_message_error', 'Current Password entered is incorrect.');
            }

            
        }
    }

    public function logout(){
        Session::flush();
        return redirect('/admin')->with('flash_message_success', 'Logged out successfully.');
       
    }

    public function viewAdmin()
    {
        $admins = Admin::get();
        return view('admin.admins.view_admins')->with(compact('admins'));
    }

    public function addAdmin(Request $request)
    {
        if($request->isMethod('post'))
        {
             $validatedData = $request->validate([
            'username' => 'required|unique:admins',
            'password' => 'required',
            ]);
            $data = $request->all(); 

            if($data['type'] == "Admin")
            {
                $Admin = new Admin;
                $Admin->type = $data['type'];
                $Admin->username = $data['username'];
                $Admin->password = md5($data['password']);
                $Admin->status = empty($data['status']) ? 0:1;
                $Admin->save();
                return redirect()->back()->with('flash_message_success', 'Admin Create Successfully.');
            }
            else if($data['type'] == 'Sub Admin')
            {

                $Admin = new Admin;
                $Admin->type = $data['type'];
                $Admin->categories_access = empty($data['categories_access']) ?0:1;
                $Admin->products_access = empty($data['products_access'])? 0:1;
                $Admin->orders_access = empty($data['orders_access'])?0:1;
                $Admin->users_access = empty($data['users_access']) ? 0:1;
                $Admin->username = $data['username'];
                $Admin->password = md5($data['password']);
                $Admin->status = empty($data['status']) ? 0:1;
                $Admin->save();
                return redirect()->back()->with('flash_message_success', 'Sub Admin Create Successfully.');
            }
            
        }
        return view('admin.admins.add_admin');
    }

    public function editAdmin(Request $request,$id)
    {
        $adminDetails = Admin::where('id',$id)->first();

        if($request->isMethod('post'))
        {
            $validatedData = $request->validate([
            'password' => 'required'
            ]);

            $data = $request->all(); 

            if($data['type'] == "Admin")
            {
                $Admin = Admin::find($id);
                $Admin->password = md5($data['password']);
                $Admin->status = empty($data['status']) ? 0:1;
                $Admin->save();
                return redirect()->back()->with('flash_message_success', 'Admin Updated Successfully.');
            }
            else if($data['type'] == 'Sub Admin')
            {

                $Admin = Admin::find($id);
                $Admin->categories_access = empty($data['categories_access']) ?0:1;
                $Admin->products_access = empty($data['products_access'])? 0:1;
                $Admin->orders_access = empty($data['orders_access'])?0:1;
                $Admin->users_access = empty($data['users_access']) ? 0:1;
                $Admin->password = md5($data['password']);
                $Admin->status = empty($data['status']) ? 0:1;
                $Admin->save();
                return redirect()->back()->with('flash_message_success', 'Sub Admin Updated Successfully.');
            }

        }
        return view('admin.admins.edit_admin')->with(compact('adminDetails'));
    }
}
