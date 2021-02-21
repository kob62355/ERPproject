<?php

namespace App\Http\Controllers;
use App\organization;
use App\product;
use App\partner;
use App\invoice;
use App\receipt;
use App\expenses;
use App\purchaseorder;
use Carbon\Carbon;
use Illuminate\Http\Request;

class expensesController extends Controller
{
    public function index(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id !=3 && $userlevel_id != 4){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        $purchaseorder = new purchaseorder();
        $readytopurchaseorder = $purchaseorder->getreadytopurchaseorder($id);
        $readytoacceptpurchaseorder = $purchaseorder->getreadytoaccept($id);
        $readytoacceptpurchaseorderpay = $purchaseorder->getreadytoacceptpay($id);
        return view('expenses/menu')->with(compact('organizations','readytopurchaseorder','readytoacceptpurchaseorder','readytoacceptpurchaseorderpay','userlevel_id'));
    }
    public function insert(Request $request){
        
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 4){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        $product = new product();
        $products = $product->select($id);
        $partner = new partner();
        $partners = $partner->select($id);
        return view('expenses/addexpenses')->with(compact(['organizations','products','partners','userlevel_id']));
    }
    public function list(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 4){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        $expenses = new expenses();
        $expensess = $expenses->select($id);
        return view('expenses/list')->with(compact(['organizations','expensess','userlevel_id']));
    }
    public function store(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 4){
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
        $expenses = new expenses();
        $data = $expenses->selectlastid($organization_id);
        if($data){
            foreach($data as $id){
            $lastid = $id->expenses_id;
            }
        $lastid = $lastid + 1;
        }
        else{
            $lastid = 1; 
        }
        $i = 0;
        while($i < count($product_id)){
           if($product_amount[$i] > 0){
           $expenses->insert($lastid,$organization_id,$product_id[$i],$product_price[$i],$product_amount[$i],$partner_id,$partner_address,$unixTimeStamp);
           }
           $i++;
        }
        $expensess = $expenses->select($organization_id);
        return redirect()->action('expensesController@list');
    }

    public function update(Request $request , $idexpenses){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 4){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        $product = new product();
        $products = $product->select($id);
        $partner = new partner();
        $partners = $partner->select($id);
        $expenses = new expenses();
        $expensess = $expenses->getdata($id,$idexpenses);
        $expenses_partner = $expenses->getpartner($id,$idexpenses);
        return view('expenses/update')->with(compact(['organizations','products','partners','expensess','expenses_partner','userlevel_id']));
    }

    public function updatedo(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 4){
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
        $expenses_id = request()->input('expenses_id');
        $created_at = request()->input('created_at');
        $status_id = request()->input('status_id');
        $organization_id = $request->session()->get('organization_id');
        $oldproduct_id = request()->input('oldproduct_id');
        $organization = new organization();
        $organizations = $organization->getorganization($organization_id);
        $unixTimeStamp = Carbon::now()->toDateTimeString();
        $expenses = new expenses();
        $i = 0;
        while($i < count($product_id)){
           if($product_amount[$i] == 0){
            $expenses->deleteproduct($organization_id,$expenses_id,$product_id[$i]);
           }
           if(!isset($oldproduct_id[$i])){
            $expenses->insertedit($expenses_id,$organization_id,$product_id[$i],$product_price[$i],$product_amount[$i],$partner_id,$partner_address,$created_at,$unixTimeStamp,$status_id);
           }
           else{
            $expenses->edit($expenses_id,$organization_id,$product_id[$i],$product_price[$i],$product_amount[$i],$partner_id,$partner_address,$oldproduct_id[$i],$unixTimeStamp);
           }
           $i++;
        }
        return redirect('expenses/list/');
    }
}
