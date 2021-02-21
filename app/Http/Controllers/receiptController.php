<?php

namespace App\Http\Controllers;
use App\organization;
use App\income;
use App\quotation;
use App\invoice;
use App\receipt;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;

class receiptController extends Controller
{
    public function index(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id = 3){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $income = new income();
        $receipt = new receipt();
        $organizations = $organization->getorganization($id);
        $receipts = $receipt->selectReceipt($id);
        $readytoreceipt = $receipt->getReadyToReceipt($id);
        return view('income/receipt/listreceipt')->with(compact(['organizations','receipts','readytoreceipt','readytoreceipt','userlevel_id']));
    }
    public function create(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id = 3){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $receipt = new receipt();
        $ReadyToReceipt = $receipt->selectReadyToReceipt($id);
        $organizations = $organization->getorganization($id);
        return view('income/receipt/createreceipt')->with(compact(['organizations','ReadyToReceipt','userlevel_id']));
    }
    public function createreceipt(Request $request, $income_id){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id = 3){
            return redirect()->action('organizationController@index');
        }
        $organization_id = $request->session()->get('organization_id');
        $receipt = new receipt();
        $data = $receipt->selectlastid($organization_id);
        if($data){
            foreach($data as $id){
            $lastid = $id->receipt_id;
            }
        $lastid = $lastid + 1;
        }
        else{
            $lastid = 1; 
        }
        $RT = str_pad($lastid, 8, 0, STR_PAD_LEFT);
        $RTID = "RT-" . $RT;
        $receipt->createReceipt($organization_id,$income_id,$lastid,$RTID);
        return redirect()->action('receiptController@index');
    }
    public function show(Request $request, $receipt_id){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id = 3){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        $receipt = new receipt();
        $receipts = $receipt->selectReceiptAll($id,$receipt_id);
        $details = $receipt->selectReceiptRow($id,$receipt_id);
        $sums = $receipt->selectSum($id,$receipt_id);
        return view('income/receipt/showreceipt')->with(compact(['organizations','receipts','details','sums','userlevel_id']));
    }
    
    public function createpdf(Request $request, $receipt_id){
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        $receipt = new receipt();
        $receipts = $receipt->selectReceiptAll($id,$receipt_id);
        $details = $receipt->selectReceiptRow($id,$receipt_id);
        $sums = $receipt->selectSum($id,$receipt_id);
        // share data to view
        $pdf = PDF::loadView('income/receipt/receiptpdf', compact('organizations','receipts','details','sums'));

        // download PDF file with download method
        return $pdf->download('receipt.pdf');
        
    }
}
