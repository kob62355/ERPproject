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

    public function sumincome3month($organization_id){
        return DB::connection('mysql')->select("SELECT SUM(saleprice * amount) AS 'sumincome' FROM `income` 
        INNER JOIN `invoice` ON `income`.`organization_id` = `invoice`.organization_id 
        AND `income`.invoice_id = `invoice`.invoice_id AND `income`.income_id = `invoice`.income_id 
        WHERE income.status_id >= 3 AND income.organization_id = ? AND YEAR(invoice.created_at) >= YEAR(CURRENT_DATE - INTERVAL 3 MONTH) 
        AND invoice.created_at >= DATE_ADD(LAST_DAY(DATE_SUB(NOW(), INTERVAL 4 MONTH)), INTERVAL 1 DAY)
        AND invoice.created_at <= DATE_SUB(NOW(), INTERVAL 1 MONTH)",[$organization_id]);
    }
    public function sumexpenses3month($organization_id){
        
        return DB::connection('mysql')->select("SELECT SUM(saleprice * amount) AS 'sumexpenses' FROM `expenses` 
        INNER JOIN `purchaseorder` ON `expenses`.`organization_id` = `purchaseorder`.organization_id 
        AND `expenses`.purchaseorder_id = `purchaseorder`.purchaseorder_id 
        AND `expenses`.expenses_id = `purchaseorder`.expenses_id 
        WHERE expenses.status_id >= 1 
        AND expenses.organization_id = ? 
        AND purchaseorder.created_at >= DATE_ADD(LAST_DAY(DATE_SUB(NOW(), INTERVAL 4 MONTH)), INTERVAL 1 DAY)
        AND purchaseorder.created_at <= DATE_SUB(NOW(), INTERVAL 1 MONTH)",[$organization_id]);

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
}
