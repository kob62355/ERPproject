<?php

namespace App\Http\Controllers;
use App\organization;
use App\report;
use Illuminate\Http\Request;
use Carbon\Carbon;

class reportController extends Controller
{
    public function profit(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 3 && $userlevel_id != 5){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        $report = new report();
        $incomes = $report->sumincome($id);
        $expensess = $report->sumexpenses($id);
        $incomeline = $report->sumLineIncomeAll($id);
        $expensesline = $report->sumLineexepensesAll($id);
        return view('report/profit')->with(compact('organizations','incomes','expensess','userlevel_id','incomeline','expensesline'));
    }
    public function profit1month(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 3 && $userlevel_id != 5){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        $report = new report();
        $incomes = $report->sumincome1month($id);
        $expensess = $report->sumexpenses1month($id);
        //$LastMonthBegin = Carbon::now()->startOfMonth()->subMonth()->toDateString();
        $LastMonthBegin = new Carbon('first day of last month');
        //$LastMonthEnd = Carbon::now()->EndofMonth()->subMonth()->toDateString();
        $LastMonthEnd = new Carbon('last day of last month');
        return view('report/profit1month')->with(compact('organizations','incomes','expensess','userlevel_id','LastMonthBegin','LastMonthEnd'));
    }
    public function profit3month(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 3 && $userlevel_id != 5){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        $report = new report();
        //$incomes = $report->sumincome3month($id);
        //$expensess = $report->sumexpenses3month($id);
        //$Begin = Carbon::now()->startOfMonth()->subMonth(3)->toDateString();
        //$End = Carbon::now()->subMonth(1)->EndofMonth()->toDateString();
        return view('report/profit3month')->with(compact('organizations','userlevel_id'));
    }

    public function showprofit3month(Request $request){
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 3 && $userlevel_id != 5){
            return redirect()->action('organizationController@index');
        }
        $id = $request->session()->get('organization_id');
        $quarter = request()->input('quarter');
        $beginMonth = 0;
        $endMonth = 0;
        if($quarter == 1)
        {
            $beginMonth = 1;
            $endMonth = 3;
        }
        if($quarter == 2)
        {
            $beginMonth = 4;
            $endMonth = 6;
        }
        if($quarter == 3)
        {
            $beginMonth = 7;
            $endMonth = 9;
        }
        if($quarter == 4)
        {
            $beginMonth = 10;
            $endMonth = 12;
        }
        $year = request()->input('year');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        $report = new report();
        $incomes = $report->sumincome3month($id,$quarter,$year);
        $expensess = $report->sumexpenses3month($id,$quarter,$year);
        $incomeline = $report->sumLineIncome3Month($id,$quarter,$year);
        $expensesline = $report->sumLineexepenses3Month($id,$quarter,$year);
        $Begin = $beginMonth;
        $End = $endMonth;
        
        return view('report/profitquartorshow')->with(compact('organizations','incomes','expensess','userlevel_id','Begin','End','year','incomeline','expensesline'));
    }

    public function profitcustom(Request $request)
    {
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 3 && $userlevel_id != 5){
            return redirect()->action('organizationController@index');
        }
        $fromDate = request()->input('fromDate');
        $toDate = request()->input('toDate');
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        return view('report/profitcustom')->with(compact('organizations','userlevel_id'));
    }

    public function profitcustomshow(Request $request)
    {
        $userlevel_id = $request->session()->get('userlevel_id');
        if($userlevel_id != 1 && $userlevel_id != 3 && $userlevel_id != 5){
            return redirect()->action('organizationController@index');
        }
        $fromDate = request()->input('fromDate');
        $toDate = request()->input('toDate');
        $id = $request->session()->get('organization_id');
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        $report = new report();
        $incomes = $report->sumincomecustom($id,$fromDate,$toDate);
        $expensess = $report->sumexpensescustom($id,$fromDate,$toDate);
        $incomeline = $report->sumLineincomecustom($id,$fromDate,$toDate);
        $expensesline = $report->sumLineexpensescustom($id,$fromDate,$toDate);
        return view('report/profitcustomshow')->with(compact('organizations','incomes','expensess','userlevel_id','fromDate','toDate','incomeline','expensesline'));
    }

    /*public function lineReport(Request $request)
    {
        $userlevel_id = $request->session()->get('userlevel_id');
        $id = $request->session()->get('organization_id');
        if($userlevel_id != 1 && $userlevel_id != 5){
            return redirect()->action('organizationController@index');
        }
        $organization = new organization();
        $organizations = $organization->getorganization($id);
        $report = new report();
        //$incomeline = $report->sumLineIncomeAll($id);
        //$expensesline = $report->sumLineExepensesAll($id);
        
      
       //dd($sumsGroup);
        return view('report/linereport')->with(compact('organizations','userlevel_id','incomeline','expensesline'));
    }*/
}
