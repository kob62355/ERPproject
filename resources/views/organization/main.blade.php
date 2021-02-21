@extends('layouts.app')
@extends('layouts.checkauth')
@section('content')
@include('layouts.navmenu')

    <div class="container mt-5 shadow p-3 mb-5 bg-dark rounded">
      <div style="display: inline-block">  
      
                @if($userlevel_id == 1 || $userlevel_id == 2 || $userlevel_id == 3)
                <div class="card text-dark bg-light mb-3" style="width: 48.5%;float: left;margin-left: 5px; margin-right: 5px;">
                    <h3 class="card-header">รายรับ</h3>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                @if($userlevel_id == 1 || $userlevel_id == 2)
                                <a href="{{ url('income/list') }}" class="btn btn-dark" style="width: 100%;">รายการรายรับ</a>
                                @endif
                                @if($userlevel_id == 1 || $userlevel_id == 2)
                                <a href="{{ url('income/quotation/list')}}" class="btn btn-dark mt-2" style="width: 100%">ใบเสนอราคา 
                                    @foreach ($readytoquotation as $amountquotation)
                                    @foreach ($readytoaccept as $amountaccept)
                                    @if($amountquotation->readytoquotation > 0 || $amountaccept->readytoaccept > 0)
                                    <span class="badge badge-danger"> {{$amountquotation->readytoquotation + $amountaccept->readytoaccept}} </span>
                                    @endif
                                    @endforeach
                                @endforeach
                                @endif
                               </a>
                            @if($userlevel_id == 1 || $userlevel_id == 2 || $userlevel_id == 3)
                            <a href="{{url('income/invoice')}}"  class="btn btn-dark mt-2" style="width: 100%">ใบวางบิล
                                @foreach ($readytoinvoice as $amount)
                                @if($amount->readytoinvoice > 0)
                                  <span class="badge badge-danger"> {{$amount->readytoinvoice}} </span>
                                @endif
                                 @endforeach
                            </a>
                            @endif
                            @if($userlevel_id == 1 || $userlevel_id == 3)
                            <a href="{{ url('income/receipt') }}" class="btn btn-dark mt-2" style="width: 100%">ใบเสร็จ
                                @foreach ($readytoreceipt as $amount)
                                @if($amount->readytoreceipt > 0)
                                  <span class="badge badge-danger"> {{$amount->readytoreceipt}} </span>
                                @endif
                                 @endforeach
                            </a>
                            @endif
                            </div>
                            <div class="col">
                                <img src="{{url('/images/income.png')}}" style="width: 100%">
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            
            
            
                @if($userlevel_id == 1 || $userlevel_id == 4 || $userlevel_id == 3)
                <div class="card text-dark bg-light mb-3" style="width: 48.5%;float: left;margin-left: 5px; margin-right: 5px;">
                    <h3 class="card-header">รายจ่าย</h3>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                @if($userlevel_id == 1 || $userlevel_id == 4)<a href="{{ url('expenses/list') }}" class="btn btn-dark" style="width: 100%;">รายการรายจ่าย</a>@endif
                                @if($userlevel_id == 1 || $userlevel_id == 3)
                                <a href="{{ url('expenses/purchaseorder/list')}}" class="btn btn-dark mt-2" style="width: 100%">ใบสั่งซื้อ
                                    @foreach ($readytopurchaseorder as $amountpurchaseorder)
                                    @foreach ($readytoacceptpurchaseorder as $amountaccept)
                                    @foreach ($readytoacceptpurchaseorderpay as $amountpayaccept)
                                    @if($amountpurchaseorder->readytopurchaseorder > 0 || $amountaccept->readytoaccept > 0 || $amountpayaccept->readytoaccept > 0)
                                    <span class="badge badge-danger"> {{$amountpurchaseorder->readytopurchaseorder + $amountaccept->readytoaccept + $amountpayaccept->readytoaccept}} </span>
                                    @endif
                                    @endforeach
                                    @endforeach
                                    @endforeach
                                </a>
                                @endif
                            </div>
                            <div class="col">
                                <img src="{{url('/images/outcome.png')}}" style="width: 100%">
                            </div>
                        </div>
                    </div>
                </div>
                @endif 
            
       
     
                @if($userlevel_id == 1 || $userlevel_id == 4)
                <div class="card text-dark bg-light mb-3" style="width: 48.5%;float: left;margin-left: 5px; margin-right: 5px;">
                    <h3 class="card-header">สินค้า</h3>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <a href="{{ url('product/insert') }}" class="btn btn-dark" style="width: 100%;">เพิ่มสินค้า</a>
                                <a href="{{ url('product/stock/')}}" class="btn btn-dark mt-2" style="width: 100%;">รายการสินค้าคงเหลือ</a>
                            </div>
                            <div class="col">
                                <img src="{{url('/images/product.png')}}" style="width: 100%">
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            
                @if($userlevel_id == 1 || $userlevel_id == 2 || $userlevel_id == 4)
                <div class="card text-dark bg-light mb-3" style="width: 48.5%;float: left;margin-left: 5px; margin-right: 5px;">
                    <h3 class="card-header">ผู้ติดต่อ</h3>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <a href="{{ url('partner/insert') }}" class="btn btn-dark" style="width: 100%;">เพิ่มผู้ติดต่อ</a>
                                <a href="{{ url('partner/list/')}}" class="btn btn-dark mt-2" style="width: 100%;">รายชื่อผู้ติดต่อ</a>
                            </div>
                            <div class="col">
                                <img src="{{url('/images/partner.png')}}" style="width: 100%">
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            
        
                @if($userlevel_id == 1 || $userlevel_id == 3 || $userlevel_id == 5)
                <div class="card text-dark bg-light mb-3" style="width: 48.5%;float: left;margin-left: 5px; margin-right: 5px;">
                    <h3 class="card-header">รายงาน</h3>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <a href="{{ url('report/profit') }}" class="btn btn-dark" style="width: 100%;">งบกำไร - ขาดทุน</a>
                                <a href="{{ url('report/profit') }}" class="btn btn-dark mt-2" style="width: 100%;">รายการภาษี</a>
                            </div>
                            <div class="col">
                                <img src="{{url('/images/report.png')}}" style="width: 100%">
                            </div>
                        </div>
                    </div>
                </div>
                @endif
           
                @if($userlevel_id == 1)
                <div class="card text-dark bg-light mb-3" style="width: 48.5%;float: left;margin-left: 5px; margin-right: 5px;">
                    <h3 class="card-header">จัดการ</h3>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <a href="{{url('user/list') }}" class="btn btn-dark" style="width: 100%;">จัดการผู้ใช้งาน</a>
                                <a href="{{url('organization/settings') }}" class="btn btn-dark mt-2" style="width: 100%;">จัดการองค์กร</a>
                            </div>
                            <div class="col">
                                <img src="{{url('/images/user.png')}}" style="width: 100%">
                            </div>
                        </div>
                    </div>
                </div>
                @endif
      </div>   
    </div>
    
    
           
           <!-- <a href="{{ url('income/quotation/list')}}" style="color: black" class="list-group-item list-group-item-action">ใบเสนอราคา</a></li>
            <a href="" style="color: black" class="list-group-item list-group-item-action">ใบวางบิล</a></li>
            <a href="" style="color: black" class="list-group-item list-group-item-action">ใบเสร็จ/กำกับภาษี</a></li>!-->
 

@endsection

    
