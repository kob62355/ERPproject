<?php

namespace App\Http\Controllers;
use App\organization;
use App\income;
use App\quotation;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;

class quotationController extends Controller
{
    public function index(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 2){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $quotation = new quotation();
        $income = new income();
        $organizations = $organization->getorganization($id);
        $readytoquotation = $income->getreadytoquotation($id);
        $readytoaccept = $income->getreadytoaccept($id);
        $incomes = $income->selectReadyToQuotation($id);
        $quotations = $quotation->selectQuotation($id);
        return view('income/quotation/listquotation')->with(compact(['organizations','readytoquotation','incomes','quotations','readytoaccept','userlevel_id']));
    }

    public function acceptlist(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 2){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $quotation = new quotation();
        $organizations = $organization->getorganization($id);
        $quotations = $quotation->listtoaccept($id);
        return view('income/quotation/acceptquotation')->with(compact(['organizations','quotations','userlevel_id']));
    }

    public function acceptprocess(Request $request,$idincome){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 2){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $quotation = new quotation();
        $unixTimeStamp = Carbon::now()->toDateTimeString();
        $quotations = $quotation->QuotationAccept($id,$idincome,$unixTimeStamp);
        return redirect()->action('quotationController@acceptlist');
    }

    public function create(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 2){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $income = new income();
        $organizations = $organization->getorganization($id);
        $incomeslist = $income->selectReadyToQuotation($id);
        
        return view('income/quotation/createquotation')->with(compact(['organizations','incomeslist','userlevel_id']));
    }
    
    public function preview(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 2){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $income_id = request()->input('income_id'); 
        $income = new income();
        $incomes = $income->preview($id,$income_id);
        return response()->json($incomes, 200);
    }

    public function show(Request $request, $quotation_id){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 2){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        $quotation = new quotation();
        $quotations = $quotation->selectQuotationAll($id,$quotation_id);
        $details = $quotation->selectQuotationRow($id,$quotation_id);
        $sums = $quotation->selectSum($id,$quotation_id);
        return view('income/quotation/showquotation')->with(compact(['organizations','quotations','details','sums','userlevel_id']));
        
    }

   
    
    public function createQuotation(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 2){
            return redirect()->action('organizationController@index');
        }
        $organization_id = $request->session()->get('organization_id');
        $quotation = new quotation();
        $income_id = request()->input('income_id');
        $detail = request()->input('detail');
        $data = $quotation->selectlastid($organization_id);
        if($data){
            foreach($data as $id){
            $lastid = $id->quotation_id;
            }
        $lastid = $lastid + 1;
        }
        else{
            $lastid = 1; 
        }
        $QT = str_pad($lastid, 8, 0, STR_PAD_LEFT);
        $QTID = "QT-" . $QT;
        $quotation->createQuotation($organization_id,$income_id,$lastid,$QTID,$detail);
        return redirect()->action('quotationController@index');
    }

    public function createpdf(Request $request, $quotation_id){
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        $quotation = new quotation();
        $quotations = $quotation->selectQuotationAll($id,$quotation_id);
        $details = $quotation->selectQuotationRow($id,$quotation_id);
        $sums = $quotation->selectSum($id,$quotation_id);
        // share data to view
        $pdf = PDF::loadView('income/quotation/quotationpdf', compact('organizations','quotations','details','sums'));

        // download PDF file with download method
        return $pdf->download('quotation.pdf');
        
    }
    
}
