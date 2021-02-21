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
        return view('report/profit')->with(compact('organizations','incomes','expensess','userlevel_id'));
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
        $incomes = $report->sumincome3month($id);
        $expensess = $report->sumexpenses3month($id);
        $Begin = Carbon::now()->startOfMonth()->subMonth(3)->toDateString();
        $End = Carbon::now()->subMonth(1)->EndofMonth()->toDateString();
        return view('report/profit3month')->with(compact('organizations','incomes','expensess','userlevel_id','Begin','End'));
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
        return view('report/profitcustomshow')->with(compact('organizations','incomes','expensess','userlevel_id','fromDate','toDate'));
    }

    public function lineReport(Request $request)
    {
        $userlevel_id = $request->session()->get('userlevel_id');
        $id = $request->session()->get('organization_id');
        if($userlevel_id != 1 && $userlevel_id != 5){
            return redirect()->action('organizationController@index');
        }
        $organization = new organization();
        $organizations = $organization->getorganization($id);
      
        return view('report/linereport')->with(compact('organizations','userlevel_id'));
    }
}
