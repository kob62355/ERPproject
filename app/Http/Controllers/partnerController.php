<?php

namespace App\Http\Controllers;
use App\partner;
use Illuminate\Http\Request;

class partnerController extends Controller
{
    
    public function store(Request $reqeust){
        request()->validate([
            'partner_name' => 'required',
            'partner_address' => 'required'
        ]);
        $partner_name = request()->input('partner_name');
        $partner_address = request()->input('partner_address');
        $organization_id = $reqeust->session()->get('organization_id');
        $partner = new partner();
        $data = $partner->selectlastid();
        foreach($data as $id){
            $lastid = $id->lastid;
        }
        if($lastid == null){
            $lastid = 1;
        }
        else{
            $lastid = $lastid + 1;
        }
        $partner->insert($lastid,$organization_id,$partner_name,$partner_address);
        return redirect()->action('incomeController@insert');
    }
}