<?php

namespace App\Http\Controllers;
use App\product;
use App\organization;
use Carbon\Carbon;
use Illuminate\Http\Request;

class productController extends Controller
{
    public function index(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 2 && $userlevel_id != 4 && $userlevel_id != 5){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        return view('product/menu')->with(compact('organizations','userlevel_id'));
    }

    public function insertform(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 2 && $userlevel_id != 4){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        return view('product/insert')->with(compact('organizations','userlevel_id'));
    }

    public function stock(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 2 && $userlevel_id != 4 && $userlevel_id != 5){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        $product = new product();
        $products = $product->select($id);
        return view('product/stock')->with(compact('organizations','products','userlevel_id'));
    }
    public function insert(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 2 && $userlevel_id != 4){
            return redirect()->action('organizationController@index');
        }
        request()->validate([
            'product_name' => 'required',
            'product_description' => 'required'
        ]);
        $product_name = request()->input('product_name');
        $product_description = request()->input('product_description');
        $organization_id = $request->session()->get('organization_id');
        $product = new product();
        $data = $product->selectlastid($organization_id);
        if($data){
            foreach($data as $id){
            $lastid = $id->product_id;
            }
        $lastid = $lastid + 1;
        }
        else{
            $lastid = 1; 
        }
        $product->insert($lastid,$organization_id,$product_name,$product_description);
        return redirect('product/stock/');
    }
    public function store(Request $request){
        request()->validate([
            'product_name' => 'required',
                
        ]);
        $product_name = request()->input('product_name');
        $product_description = request()->input('product_description');
        $organization_id = $request->session()->get('organization_id');
        $product = new product();
        $data = $product->selectlastid($organization_id);
        if($data){
            foreach($data as $id){
            $lastid = $id->product_id;
            }
        $lastid = $lastid + 1;
        }
        else{
            $lastid = 1; 
        }
        $product->insert($lastid,$organization_id,$product_name,$product_description);
        $msg = $lastid;
        
        return response()->json(array('msg'=> $msg), 200);
    }

    public function edit(Request $request , $idproduct){
        
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 2 && $userlevel_id != 4){
            return redirect()->action('productController@index');
        }
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        $product = new product();
        $products = $product->selectedit($id,$idproduct);
        return view('product/update')->with(compact(['organizations','products','userlevel_id']));
    }

    public function updatedo(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 2 && $userlevel_id != 4){
            return redirect()->action('organizationController@index');
        }
        $organization_id = $request->session()->get('organization_id');
        $product_id = request()->input('product_id');
        $product_name = request()->input('product_name');
        $product_description = request()->input('product_description');
        $organization = new organization();
        $organizations = $organization->getorganization($organization_id);
        $unixTimeStamp = Carbon::now()->toDateTimeString();
        $product = new product();
        $product->updatedo($organization_id,$product_id,$product_name,$product_description,$unixTimeStamp);
        return redirect('product/stock/');
    }
}
