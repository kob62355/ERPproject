<?php

namespace App\Http\Controllers;
use App\partner;
use App\organization;
use Carbon\Carbon;
use Illuminate\Http\Request;

class partnerController extends Controller
{
    public function index(Request $request){
        $id = $request->session()->get('organization_id');
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 2 && $userlevel_id != 4 && $userlevel_id != 5){
            return redirect()->action('organizationController@index');
        }
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        return view('partner/menu')->with(compact('organizations','userlevel_id'));
    }

    public function list(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 2 && $userlevel_id != 4 && $userlevel_id != 5){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        $partner = new partner();
        $partners = $partner->select($id);
        return view('partner/list')->with(compact('organizations','partners','userlevel_id'));
    }

    public function insertform(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 2 && $userlevel_id != 4 ){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        return view('partner/insert')->with(compact('organizations','userlevel_id'));
    }

   
    public function insert(Request $request){
        
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 2 && $userlevel_id != 4 ){
           
            return redirect()->action('organizationController@index');
        }
        request()->validate([
            'partner_name' => 'required',
            'partner_address' => 'required'
        ]);
        $partner_name = request()->input('partner_name');
        
        $partner_address = request()->input('partner_address');
        $partner_tel = request()->input('partner_tel');
        $partner_email = request()->input('partner_email');
        $organization_id = $request->session()->get('organization_id','userlevel_id');
        $partner = new partner();
        $data = $partner->selectlastid($organization_id);
        if($data){
            foreach($data as $id){
            $lastid = $id->partner_id;
            }
        $lastid = $lastid + 1;
        }
        else{
            $lastid = 1; 
        }
        $partner->insert($lastid,$organization_id,$partner_name,$partner_address ,$partner_tel,$partner_email);
        return redirect('partner/list/');
    }
    public function edit(Request $request , $idpartner){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 2 && $userlevel_id != 4 ){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        $partner = new partner();
        $partners = $partner->selectwithid($id,$idpartner);
        return view('partner/update')->with(compact(['organizations','partners','userlevel_id']));
    }
    public function updatedo(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 2 && $userlevel_id != 4 ){
            return redirect()->action('organizationController@index');
        }
        $organization_id = $request->session()->get('organization_id');
        $partner_id = request()->input('partner_id');
        $partner_name = request()->input('partner_name');
        $partner_address = request()->input('partner_address');
        $partner_tel = request()->input('partner_tel');
        $partner_email = request()->input('partner_email');
        $organization = new organization();
        $organizations = $organization->getorganization($organization_id);
        $unixTimeStamp = Carbon::now()->toDateTimeString();
        $partner = new partner();
        $partner->updatedo($organization_id,$partner_id,$partner_name,$partner_address,$partner_tel,$partner_email,$unixTimeStamp);
        return redirect('partner/list/');
    }
    public function store(Request $request){    
        request()->validate([
            'partner_name' => 'required',
            'partner_address' => 'required'
        ]);
        $partner_name = request()->input('partner_name');
        $partner_address = request()->input('partner_address');
        $partner_tel = request()->input('partner_tel');
        $partner_email = request()->input('partner_email');
        $organization_id = $request->session()->get('organization_id');
        $partner = new partner();
        $data = $partner->selectlastid($organization_id);
        if($data){
            foreach($data as $id){
            $lastid = $id->partner_id;
            }
        $lastid = $lastid + 1;
        }
        else{
            $lastid = 1; 
        }
        $partner->insert($lastid,$organization_id,$partner_name,$partner_address,$partner_tel,$partner_email );
        $msg = $lastid;
        return response()->json(array('msg'=> $msg), 200);;
       
    }
}
