<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;

class report extends Model
{
    public function sumincome($organization_id){
        return DB::connection('mysql')->select("SELECT SUM(saleprice * amount)AS 'sumincome' FROM `income` WHERE status_id >= 3 AND organization_id = ?",[$organization_id]);
    }
    public function sumexpenses($organization_id){
        return DB::connection('mysql')->select("SELECT SUM(saleprice * amount)AS 'sumexpenses' FROM `expenses` WHERE status_id >= 1 AND organization_id = ?",[$organization_id]);
    }

    public function sumincome1month($organization_id){
        return DB::connection('mysql')->select("SELECT SUM(saleprice * amount)AS 'sumincome' FROM `income` 
        INNER JOIN `invoice` ON `income`.`organization_id` = `invoice`.organization_id 
        AND `income`.invoice_id = `invoice`.invoice_id 
        AND `income`.income_id = `invoice`.income_id 
        WHERE income.status_id >= 3 
        AND income.organization_id = ? 
        AND YEAR(invoice.created_at) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH) 
        AND MONTH(invoice.created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)",[$organization_id]);
    }
    public function sumexpenses1month($organization_id){
        return DB::connection('mysql')->select("SELECT SUM(saleprice * amount)AS 'sumexpenses' FROM `expenses` 
        INNER JOIN `purchaseorder` ON `expenses`.`organization_id` = `purchaseorder`.organization_id 
        AND `expenses`.purchaseorder_id = `purchaseorder`.purchaseorder_id 
        AND `expenses`.expenses_id = `purchaseorder`.expenses_id 
        WHERE expenses.status_id >= 1 AND expenses.organization_id = ? 
        AND YEAR(purchaseorder.created_at) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)
        AND MONTH(purchaseorder.created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH)",[$organization_id]);
    }

    public function sumincome3month($organization_id,$quarter,$year){
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
        return DB::connection('mysql')->select("SELECT SUM(saleprice * amount) AS 'sumincome' FROM `income` 
        INNER JOIN `invoice` ON `income`.`organization_id` = `invoice`.organization_id 
        AND `income`.invoice_id = `invoice`.invoice_id AND `income`.income_id = `invoice`.income_id 
        WHERE income.status_id >= 3 AND income.organization_id = ? 
        AND YEAR(invoice.created_at) = ?
        AND MONTH(invoice.created_at) >= ?
        AND MONTH(invoice.created_at) <= ?"
        ,[$organization_id,$year,$beginMonth,$endMonth]);
    }
    public function sumexpenses3month($organization_id,$quarter,$year){
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
        return DB::connection('mysql')->select("SELECT SUM(saleprice * amount) AS 'sumexpenses' FROM `expenses` 
        INNER JOIN `purchaseorder` ON `expenses`.`organization_id` = `purchaseorder`.organization_id 
        AND `expenses`.purchaseorder_id = `purchaseorder`.purchaseorder_id 
        AND `expenses`.expenses_id = `purchaseorder`.expenses_id 
        WHERE expenses.status_id >= 1 
        AND expenses.organization_id = ? 
        AND YEAR(purchaseorder.created_at) = ?
        AND MONTH(purchaseorder.created_at) >= ?
        AND MONTH(purchaseorder.created_at) <= ?"
        ,[$organization_id,$year,$beginMonth,$endMonth]);

    }

    public function sumincomecustom($organization_id, $fromDate, $toDate){
        $fromDate = Carbon::createFromFormat('Y-m-d', $fromDate)->StartOfDay()->toDateTimeString();
        $toDate = Carbon::createFromFormat('Y-m-d', $toDate)->EndOfDay()->toDateTimeString();
        if($fromDate && $toDate)
        {
            return DB::connection('mysql')->select("SELECT SUM(saleprice * amount) AS 'sumincome' 
            FROM `income` INNER JOIN `invoice` ON `income`.`organization_id` = `invoice`.organization_id 
            AND `income`.invoice_id = `invoice`.invoice_id AND `income`.income_id = `invoice`.income_id 
            WHERE income.status_id >= 3 
            AND income.organization_id = ? 
            AND invoice.created_at >= ? 
            AND invoice.created_at <= ?",[$organization_id,$fromDate,$toDate]);
        }
        else 
        {
            return;
        }
    }

    public function sumexpensescustom($organization_id,$fromDate, $toDate){
        $fromDate = Carbon::createFromFormat('Y-m-d', $fromDate)->StartOfDay()->toDateTimeString();
        $toDate = Carbon::createFromFormat('Y-m-d', $toDate)->EndOfDay()->toDateTimeString();
        if($fromDate && $toDate)
        {
        return DB::connection('mysql')->select("SELECT SUM(saleprice * amount) AS 'sumexpenses' FROM `expenses` 
        INNER JOIN `purchaseorder` ON `expenses`.`organization_id` = `purchaseorder`.organization_id 
        AND `expenses`.purchaseorder_id = `purchaseorder`.purchaseorder_id 
        AND `expenses`.expenses_id = `purchaseorder`.expenses_id 
        WHERE expenses.status_id >= 1 AND expenses.organization_id = ? 
        AND purchaseorder.created_at >= ?
        AND purchaseorder.created_at <= ?",[$organization_id,$fromDate,$toDate]);
        }
        else 
        {
            return;
        }
    }

    public function sumLineIncome3Month($organization_id,$quarter,$year)
    {
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
        return DB::connection('mysql')->select("
        select Month(invoice.created_at) as 'Month',YEAR(invoice.created_at) as 'Year',sum(income.saleprice * income.amount) as 'sum',
        income.organization_id,invoice.created_at from income
        INNER JOIN invoice ON income.invoice_id = invoice.invoice_id
        AND income.income_id = invoice.income_id
        AND income.organization_id = invoice.organization_id
        Group BY  Month(invoice.created_at),YEAR(invoice.created_at),income.organization_id
        HAVING income.organization_id = ?
        AND Month(invoice.created_at) >= ?
        AND Month(invoice.created_at) <= ?
        AND YEAR(invoice.created_at) = ?
        ORDER BY invoice.created_at DESC",[$organization_id,$beginMonth,$endMonth,$year]);
    }

    public function sumLineexepenses3Month($organization_id,$quarter,$year)
    {
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
        return DB::connection('mysql')->select("
        select Month(purchaseorder.created_at) as 'Month',YEAR(purchaseorder.created_at) as 'Year',sum(expenses.saleprice * expenses.amount) as 'sum',
        expenses.organization_id,purchaseorder.created_at from expenses
        INNER JOIN purchaseorder ON expenses.purchaseorder_id = purchaseorder.purchaseorder_id
        AND expenses.expenses_id = purchaseorder.expenses_id
        AND expenses.organization_id = purchaseorder.organization_id
        Group BY  Month(purchaseorder.created_at),YEAR(purchaseorder.created_at),expenses.organization_id
        HAVING expenses.organization_id = ?
        AND Month(purchaseorder.created_at) >= ?
        AND Month(purchaseorder.created_at) <= ?
        AND YEAR(purchaseorder.created_at) = ?
        ORDER BY purchaseorder.created_at DESC",[$organization_id,$beginMonth,$endMonth,$year]);
    }

    public function sumLineIncomeAll($organization_id)
    {
      
        return DB::connection('mysql')->select("
        select YEAR(invoice.created_at) as 'Year',sum(income.saleprice * income.amount) as 'sum',
        income.organization_id,invoice.created_at from income
        INNER JOIN invoice ON income.invoice_id = invoice.invoice_id
        AND income.income_id = invoice.income_id
        AND income.organization_id = invoice.organization_id
        Group BY  YEAR(invoice.created_at),income.organization_id
        HAVING income.organization_id = ?
        ORDER BY invoice.created_at DESC",[$organization_id]);
    }

    public function sumLineexepensesAll($organization_id)
    {
        
        return DB::connection('mysql')->select("
        select YEAR(purchaseorder.created_at) as 'Year',sum(expenses.saleprice * expenses.amount) as 'sum',
        expenses.organization_id,purchaseorder.created_at from expenses
        INNER JOIN purchaseorder ON expenses.purchaseorder_id = purchaseorder.purchaseorder_id
        AND expenses.expenses_id = purchaseorder.expenses_id
        AND expenses.organization_id = purchaseorder.organization_id
        Group BY YEAR(purchaseorder.created_at),expenses.organization_id
        HAVING expenses.organization_id = ?
        ORDER BY purchaseorder.created_at DESC",[$organization_id]);
    }

    public function sumLineincomecustom($organization_id, $fromDate, $toDate){
        $fromDate = Carbon::createFromFormat('Y-m-d', $fromDate)->StartOfDay()->toDateTimeString();
        $toDate = Carbon::createFromFormat('Y-m-d', $toDate)->EndOfDay()->toDateTimeString();
        if($fromDate && $toDate)
        {
            return DB::connection('mysql')->select("
        select Month(invoice.created_at) as 'Month',YEAR(invoice.created_at) as 'Year',sum(income.saleprice * income.amount) as 'sum',
        income.organization_id,invoice.created_at from income
        INNER JOIN invoice ON income.invoice_id = invoice.invoice_id
        AND income.income_id = invoice.income_id
        AND income.organization_id = invoice.organization_id
        Group BY  Month(invoice.created_at),YEAR(invoice.created_at),income.organization_id
        HAVING income.organization_id = ?
        AND invoice.created_at >= ?
        AND invoice.created_at <= ?
        ORDER BY invoice.created_at DESC",[$organization_id,$fromDate,$toDate]);
        }
        else 
        {
            return;
        }
    }

    public function sumLineexpensescustom($organization_id,$fromDate, $toDate){
        $fromDate = Carbon::createFromFormat('Y-m-d', $fromDate)->StartOfDay()->toDateTimeString();
        $toDate = Carbon::createFromFormat('Y-m-d', $toDate)->EndOfDay()->toDateTimeString();
        if($fromDate && $toDate)
        {
            return DB::connection('mysql')->select("
        select MONTH(purchaseorder.created_at) as 'Month',YEAR(purchaseorder.created_at) as 'Year',sum(expenses.saleprice * expenses.amount) as 'sum',
        expenses.organization_id,purchaseorder.created_at from expenses
        INNER JOIN purchaseorder ON expenses.purchaseorder_id = purchaseorder.purchaseorder_id
        AND expenses.expenses_id = purchaseorder.expenses_id
        AND expenses.organization_id = purchaseorder.organization_id
        Group BY YEAR(purchaseorder.created_at),MONTH(purchaseorder.created_at),expenses.organization_id
        HAVING expenses.organization_id = ?
        AND purchaseorder.created_at >= ?
        AND purchaseorder.created_at <= ?
        ORDER BY purchaseorder.created_at DESC",[$organization_id,$fromDate,$toDate]);
        }
        else 
        {
            return;
        }
    }

}
