<?php

namespace App\Http\Controllers;
use App\organization;
use App\income;
use App\product;
use App\quotation;
use App\invoice;
use Carbon\Carbon;
use PDF;
use Illuminate\Http\Request;

class invoiceController extends Controller
{
    public function index(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 2 && $userlevel_id != 3){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $invoice = new invoice();
        $invoices = $invoice->selectInvoice($id);
        $readytoinvoice = $invoice->getReadyToInvoice($id);
        $organizations = $organization->getorganization($id);
        return view('income/invoice/listinvoice')->with(compact(['organizations','invoices','readytoinvoice','userlevel_id']));
    }
    public function create(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 3){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $invoice = new invoice();
        $ReadyToInvoice = $invoice->selectReadyToInvoice($id);
        $organizations = $organization->getorganization($id);
        return view('income/invoice/createinvoice')->with(compact(['organizations','ReadyToInvoice','userlevel_id']));
    }

    public function createinvoice(Request $request, $income_id){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 2){
            return redirect()->action('organizationController@index');
        }
        $organization_id = $request->session()->get('organization_id');
        $invoice = new invoice();
        $income = new income();
        $product = new product();
        $incomelist = $income->getdata($organization_id,$income_id);
        foreach ($incomelist as $listproduct) {
           $product->updatesalestock($organization_id,$listproduct->product_id,$listproduct->amount);
        }
        $data = $invoice->selectlastid($organization_id);
        if($data){
            foreach($data as $id){
            $lastid = $id->invoice_id;
            }
        $lastid = $lastid + 1;
        }
        else{
            $lastid = 1; 
        }
        $INV = str_pad($lastid, 8, 0, STR_PAD_LEFT);
        $INVID = "INV-" . $INV;
        $invoice->createInvoice($organization_id,$income_id,$lastid,$INVID);
        
        return redirect()->action('invoiceController@index');
    }

    public function show(Request $request, $invoice_id){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 2 && $userlevel_id != 3){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        $invoice = new invoice();
        $invoices = $invoice->selectInvoiceAll($id,$invoice_id);
        $details = $invoice->selectInvoiceRow($id,$invoice_id);
        $sums = $invoice->selectSum($id,$invoice_id);
        return view('income/invoice/showinvoice')->with(compact(['organizations','invoices','details','sums','userlevel_id']));
        
    }

    public function createpdf(Request $request, $invoice_id){
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        $invoice = new invoice();
        $invoices = $invoice->selectInvoiceAll($id,$invoice_id);
        $details = $invoice->selectInvoiceRow($id,$invoice_id);
        $sums = $invoice->selectSum($id,$invoice_id);
        // share data to view
        $pdf = PDF::loadView('income/invoice/invoicepdf', compact('organizations','invoices','details','sums'));

        // download PDF file with download method
        return $pdf->download('invoice.pdf');
        
    }
}
