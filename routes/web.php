<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/organization/add', function () {
    return view('organization/addorganization');
});*/
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('organization', 'organizationController@index');
Route::get('organization/add','organizationController@add');
Route::get('organization/main/{id}','organizationController@main');
Route::get('organization/menu/','organizationController@menu');
Route::get('organization/status','organizationController@status');
Route::post('organization','organizationController@store');

//Income
Route::get('income', 'incomeController@index');
Route::get('income/list','incomeController@list');
Route::get('income/insert', 'incomeController@insert');
Route::post('income/insert', 'incomeController@store');
Route::get('income/update/{idincome}','incomeController@update');
Route::post('income/update', 'incomeController@updatedo');
Route::post('getpartner','incomeController@getpartner');
Route::get('income/quotation/list','quotationController@index');
Route::get('income/quotation/create','quotationController@create');
Route::post('income/quotation/create','quotationController@preview');
Route::get('income/quotation/accept','quotationController@acceptlist');
Route::get('income/invoice/','invoiceController@index');
Route::get('income/invoice/create','invoiceController@create');
Route::get('income/receipt/','receiptController@index');
Route::get('income/receipt/create','receiptController@create');
Route::get('income/receipt/{idincome}','receiptController@createreceipt');
Route::get('income/receipt/show/pdf/{idreceipt}','receiptController@createpdf');
Route::get('income/invoice/{idincome}','invoiceController@createinvoice');
Route::get('income/receipt/show/{idreceipt}','receiptController@show');
Route::get('income/invoice/show/{idinvoice}','invoiceController@show');
Route::get('income/invoice/show/pdf/{idinvoice}','invoiceController@createpdf');
Route::post('income/quotation/','quotationController@createQuotation');
Route::get('income/quotation/accept/{idincome}','quotationController@acceptprocess');
Route::get('income/quotation/show/{idquotation}','quotationController@show');
Route::get('income/quotation/show/pdf/{idquotation}','quotationController@createpdf');

//expenses
Route::get('expenses', 'expensesController@index');
Route::get('expenses/list', 'expensesController@list');
Route::get('expenses/insert', 'expensesController@insert');
Route::get('expenses/purchaseorder/list', 'purchaseorderController@index');
Route::get('expenses/purchaseorder/create', 'purchaseorderController@create');
Route::get('expenses/purchaseorder/accept', 'purchaseorderController@acceptlist');
Route::get('expenses/purchaseorder/acceptpay', 'purchaseorderController@acceptpaylist');
Route::post('expenses/purchaseorder/create', 'purchaseorderController@preview');
Route::post('expenses/insert', 'expensesController@store');

Route::get('expenses/update/{idexpenses}','expensesController@update');
Route::post('expenses/update', 'expensesController@updatedo');
Route::get('expenses/purchaseorder/show/{idexpenses}','purchaseorderController@show');
Route::get('expenses/purchaseorder/show/pdf/{idpurchaseorder}','purchaseorderController@createpdf');
Route::post('expenses/purchaseorder/','purchaseorderController@createPurchaseorder');
Route::get('expenses/purchaseorder/accept/{idexpenses}','purchaseorderController@acceptprocess');
Route::get('expenses/purchaseorder/acceptpay/{idexpenses}','purchaseorderController@acceptpayprocess');


//เพิ่มข้อมูลPartner
Route::get('partner','partnerController@index');
Route::get('partner/list','partnerController@list');
Route::get('partner/insert','partnerController@insertform');
Route::get('partner/update/{idpartner}','partnerController@edit');
Route::post('partner/insert','partnerController@insert');
Route::post('partner/update/','partnerController@updatedo');
Route::post('income/partner','partnerController@store');
//เพิมข้อมูลProduct
Route::get('product','productController@index');
Route::get('product/stock','productController@stock');
Route::get('product/insert','productController@insertform');
Route::get('product/update/{idproduct}','productController@edit');
Route::post('product/insert','productController@insert');
Route::post('product/update/','productController@updatedo');
Route::post('income/product','productController@store');

Route::get('settings','userController@index');

Route::get('user/list','userController@userlist');
Route::get('user/data','userController@userdata');
Route::get('user/insert','userController@insertform');
Route::post('user/insert','userController@insert');
Route::post('user/edit','userController@editdata');
Route::post('user/editrole','userController@editprocess');
Route::get('user/delete/{iduser}','userController@delete');

Route::get('organization/settings','organizationController@edit');
Route::post('organization/settings/edit','organizationController@editdo');


Route::get('report/profit','reportController@profit');
Route::get('report/line','reportController@lineReport');
Route::get('report/profit/1month','reportController@profit1month');
Route::get('report/profit/3month','reportController@profit3month');
Route::post('report/profit/quarter','reportController@showprofit3month');
Route::get('report/profit/custom','reportController@profitcustom');
Route::get('report/tax','reportController@tax');
Route::post('report/profit/custom','reportController@profitcustomshow');
Route::get('sale','saleController@index');






