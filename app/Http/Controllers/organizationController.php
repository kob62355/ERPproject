<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\organization;
use App\user_organization;
use App\income;
use App\quotation;
use App\purchaseorder;
use App\invoice;
use App\receipt;
use Illuminate\Support\Facades\Auth;

class organizationController extends Controller
{
    public function index(Request $request){
        $organization = new organization();
        $organizations = $organization->select();
        return view('organization/home')->with(compact(['organizations']));
    }
    public function menu(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        // if($userlevel_id != 1){
        //     return redirect()->action('organizationController@index');
        // }
        $id = $request->session()->get('organization_id');
        $income = new income();
        $quotation = new quotation();
        $organization = new organization();
        $invoice = new invoice();
        
        $organizations = $organization->getorganization($id);
        $readytoquotation = $income->getreadytoquotation($id);
        $readytoaccept = $income->getreadytoaccept($id);
        $readytoinvoice = $invoice->getReadyToInvoice($id);
        $receipt = new receipt();
        $readytoreceipt = $receipt->getReadyToReceipt($id);
        $purchaseorder = new purchaseorder();
        $readytopurchaseorder = $purchaseorder->getreadytopurchaseorder($id);
        $readytoacceptpurchaseorder = $purchaseorder->getreadytoaccept($id);
        $readytoacceptpurchaseorderpay = $purchaseorder->getreadytoacceptpay($id);
        return view('organization/main')->with(compact(['organizations','readytoquotation','readytoaccept','readytoinvoice','readytoreceipt','readytopurchaseorder','readytoacceptpurchaseorder','readytoacceptpurchaseorderpay','userlevel_id']));
    }

    public function main(Request $request,$id)
    {
        $userlevel_id = $request->session()->get('userlevel_id');
        $request->session()->put('organization_id',$id);
        $user_organization = new user_organization();
        $user_levels = $user_organization->selectlevel($id);
        foreach ($user_levels as $user_level) {
            $level = $user_level->userlevel_id;
        }
        $request->session()->put('userlevel_id',$level);
        return redirect()->action('organizationController@menu');
        
       
        
       
    }

    public function add(){
        return view('organization/addorganization');
    }
    public function status(){
        return view('organization/status');
    }
    public function store(){
        request()->validate([
            'organization_name' => 'required',
            'organization_address' => 'required',  
        ]);
        $organization_name = request()->input('organization_name');
        $organization_address = request()->input('organization_address');
        $organization_tel = request()->input('organization_tel');
        $organization_email = request()->input('organization_email');
        $organization_taxid = request()->input('organization_taxid');
        $organization = new organization();
        $user_organization = new user_organization();
        $data = $organization->selectlastid();
        foreach($data as $id){
            $lastid = $id->lastid;
        }
        if($lastid == null){
            $lastid = 1;
        }
        else{
            $lastid = $lastid + 1;
        }
        $organization->insert($lastid,$organization_name,$organization_address,$organization_tel,$organization_email,$organization_taxid);
        $user_organization->insert($lastid);
        $data = $organization->select();
        return redirect()->action('organizationController@index');

    }

    public function edit(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        return view('organization/settings/edit')->with(compact(['organizations','userlevel_id']));
    }

    public function editdo(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1){
            return redirect()->action('organizationController@index');
        }
        request()->validate([
            'organization_id' => 'required',
            'organization_name' => 'required',
            'organization_address' => 'required',  
        ]);
        
        $organization_id = request()->input('organization_id');
        $organization_name = request()->input('organization_name');
        $organization_address = request()->input('organization_address');
        $organization_tel = request()->input('organization_tel');
        $organization_email = request()->input('organization_email');
        $organization_taxid = request()->input('organization_taxid');
        $organization = new organization();
        $organization->updatedo($organization_id,$organization_name,$organization_address,$organization_tel,$organization_email,$organization_taxid);
        return redirect()->action('organizationController@edit');

    }

}
