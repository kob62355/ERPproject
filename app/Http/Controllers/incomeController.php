<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\organization;
use App\product;
use App\partner;
use App\income;
use App\invoice;
use App\receipt;
use Carbon\Carbon;
class incomeController extends Controller
{
    public function index(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 2 && $userlevel_id !=3){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $income = new income();
        $invoice = new invoice();
        $readytoquotation = $income->getreadytoquotation($id);
        $readytoaccept = $income->getreadytoaccept($id);
        $organizations = $organization->getorganization($id);
        $readytoinvoice = $invoice->getReadyToInvoice($id);
        $receipt = new receipt();
        
        $readytoreceipt = $receipt->getReadyToReceipt($id);
        return view('income/incomemenu')->with(compact('organizations','readytoquotation','readytoaccept','readytoinvoice','readytoreceipt','userlevel_id'));
    }
    public function update(Request $request , $idincome){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 2){
            return redirect()->action('organizationController@index');
        }
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        $product = new product();
        $products = $product->select($id);
        $partner = new partner();
        $partners = $partner->select($id);
        $income = new income();
        $incomes = $income->getdata($id,$idincome);
        $income_partner = $income->getpartner($id,$idincome);
        return view('income/updateincome')->with(compact(['organizations','products','partners','incomes','income_partner','userlevel_id']));
    }
    public function list(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 2){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        $income = new income();
        $incomes = $income->select($id);
        return view('income/listincome')->with(compact(['organizations','incomes','userlevel_id']));
    }
    public function insert(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 2){
            return redirect()->action('organizationController@index');
        }
       
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        $product = new product();
        $products = $product->select($id);
        $partner = new partner();
        $partners = $partner->select($id);
        return view('income/addincome')->with(compact(['organizations','products','partners','userlevel_id']));
    }
    public function store(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 2){
            return redirect()->action('organizationController@index');
        }
        $data = request()->validate([
            'partner_id' => 'required',
            'partner_address' => 'required',
            'product_id' => 'required',
            'product_price' => 'required',
            'product_amount' => 'required'
        ]);
        
        $partner_id = request()->input('partner_id');
        $partner_address = request()->input('partner_address');
        $product_id = request()->input('product_id');
        $product_price = request()->input('product_price');
        $product_amount = request()->input('product_amount');
        $organization_id = $request->session()->get('organization_id');
        $organization = new organization();
        $organizations = $organization->getorganization($organization_id);
        $unixTimeStamp = Carbon::now()->toDateTimeString();
        $income = new income();
        $data = $income->selectlastid($organization_id);
        if($data){
            foreach($data as $id){
            $lastid = $id->income_id;
            }
        $lastid = $lastid + 1;
        }
        else{
            $lastid = 1; 
        }
        $i = 0;
        while($i < count($product_id)){
           $income = new income();
           if($product_amount[$i] > 0){
           $income->insert($lastid,$organization_id,$product_id[$i],$product_price[$i],$product_amount[$i],$partner_id,$partner_address,$unixTimeStamp);
           }
           $i++;
        }
        //return view('income/incomemenu')->with('organizations',$organizations)
        $incomes = $income->select($organization_id);
        //return view('income/listincome')->with(compact(['organizations','incomes']));
        return redirect()->action('incomeController@list');
    }

    public function getpartner(Request $request) {
        
        $partner_id = request()->input('partner_id');
        $msg = $partner_id;
        $organization_id = $request->session()->get('organization_id');
        $partner = new partner();
        $partners = $partner->selectwithid($organization_id,$partner_id);
        foreach ($partners as $partner) {
            $msg = $partner->partner_address;
        }
        return response()->json(array('msg'=> $msg), 200);
    }

    public function updatedo(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 2){   
            return redirect()->action('organizationController@index');
        }
        $data = request()->validate([
            'partner_id' => 'required',
            'partner_address' => 'required',
            'product_id' => 'required',
            'product_price' => 'required',
            'product_amount' => 'required'
        ]);
        
        $partner_id = request()->input('partner_id');
        $partner_address = request()->input('partner_address');
        $product_id = request()->input('product_id');
        $product_price = request()->input('product_price');
        $product_amount = request()->input('product_amount');
        $income_id = request()->input('income_id');
        $created_at = request()->input('created_at');
        $status_id = request()->input('status_id');
        $quotation_id = request()->input('quotation_id');
        $organization_id = $request->session()->get('organization_id');
        $oldproduct_id = request()->input('oldproduct_id');
        $organization = new organization();
        $organizations = $organization->getorganization($organization_id);
        $unixTimeStamp = Carbon::now()->toDateTimeString();
        $income = new income();
        $i = 0;
        while($i < count($product_id)){
           if($product_amount[$i] == 0){
            $income->deleteproduct($organization_id,$income_id,$product_id[$i]);
           }
           if(!isset($oldproduct_id[$i])){
            $income->insertedit($income_id,$organization_id,$product_id[$i],$product_price[$i],$product_amount[$i],$partner_id,$partner_address,$created_at,$unixTimeStamp,$status_id,$quotation_id);
           }
           else{
            $income->edit($income_id,$organization_id,$product_id[$i],$product_price[$i],$product_amount[$i],$partner_id,$partner_address,$oldproduct_id[$i],$unixTimeStamp);
           }
           $i++;
        }
        return redirect('income/list/');
    }
    
}
