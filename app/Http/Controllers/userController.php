<?php

namespace App\Http\Controllers;
use App\user_organization;
use App\organization;
use App\User;
use Illuminate\Http\Request;

class userController extends Controller
{
    public function index(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        return view('user/menu')->with(compact('organizations','userlevel_id'));
    }

    public function userlist(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        $user = new user_organization();
        $users = $user->selectlistuser($id);
        $levels = $user->getalllevel();
        return view('user/list')->with(compact('organizations','users','levels','userlevel_id'));
    }
    public function insertform(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        $level = new user_organization();
        $levels = $level->getalllevel();
        return view('user/insert')->with(compact('organizations','levels','userlevel_id'));
    }
    public function insert(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1){
            return redirect()->action('organizationController@index');
        }
        $user_email = request()->input('user_email');
        $userlevel_id = request()->input('userlevel_id');
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        $level = new user_organization();
        $check = $level->insertuser($id,$user_email,$userlevel_id);
        
        if($check != 0){
        return redirect()->action('userController@userlist');
        }
        else{
        return "<script>alert('ไม่พบอีเมลดังกล่าว');window.history.back();</script>";
        }
    }
    public function editform(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        
        return view('user/list')->with(compact('organizations','users','userlevel_id'));
    } 
    public function editprocess(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $user_id = request()->input('user_id');
        $level_id = request()->input('level_id');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        $level = new user_organization();
        $level->edit($id,$user_id,$level_id);
        return redirect()->action('userController@userlist');
        
    }   

    public function userdata(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        $user = new User();
        $users = $user-we>selectuserauth();
        return view('user/userdata')->with(compact('users','userlevel_id'));
    }

    public function editdata(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1){
            return redirect()->action('organizationController@index');
        }
        request()->validate([
            'user_id' => 'required',
            'user_name' => 'required',
     
        ]);
        $user_id = request()->input('user_id');
        $user_name = request()->input('user_name');
        $user_email = request()->input('user_email');
        $user_tel = request()->input('user_tel');
        $user = new User();
        $user->updatedo($user_id,$user_name,$user_email,$user_tel);
        return redirect()->action('userController@userdata');

    }

    public function delete(Request $request,$user_id){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1){
            return redirect()->action('organizationController@index');
        }
        $organization_id = $request->session()->get('organization_id');
        $user = new User();
        $user->deleterole($organization_id,$user_id);
        return redirect()->action('userController@userlist');

    }

}
