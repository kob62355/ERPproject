@extends('layouts.app')
@extends('layouts.checkauth')
@section('content')
@include('layouts.navmenu')
    <div class="container mt-5 shadow p-3 mb-5 bg-dark rounded">
        <div class="card text-dark bg-light mb-3">
            <h1 class="card-header"><a href = "{{url('organization/menu')}}" class="my-2 mr-4 btn btn-secondary p-3"> <i class="fa fa-arrow-left mx-2"></i></a>รายรับ</h1>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        @if($userlevel_id == 1 || $userlevel_id == 2)<a href="{{ url('income/list') }}" class="btn btn-dark py-4" style="width: 100%;font-size: 24px">รายการรายรับ</a>@endif
                        @if($userlevel_id == 1 || $userlevel_id == 2)<a href="{{ url('income/quotation/list')}}" class="btn btn-dark mt-3 py-4" style="width: 100%;font-size: 24px">ใบเสนอราคา 
                        @foreach ($readytoquotation as $amountquotation)
                            @foreach ($readytoaccept as $amountaccept)
                                @if($amountquotation->readytoquotation > 0 || $amountaccept->readytoaccept > 0)
                                    <span class="badge badge-danger"> {{$amountquotation->readytoquotation + $amountaccept->readytoaccept}} </span>
                                @endif
                            @endforeach
                        @endforeach
                       </a>
                       @endif
                       @if($userlevel_id == 1 || $userlevel_id == 2 || $userlevel_id == 3)
                       <a href="{{ url('income/invoice') }}" class="btn btn-dark py-4 mt-3" style="width: 100%;font-size: 24px">ใบวางบิล
                        @if($userlevel_id == 1 || $userlevel_id == 3)
                        @foreach ($readytoinvoice as $amount)
                            @if($amount->readytoinvoice > 0)
                                <span class="badge badge-danger"> {{$amount->readytoinvoice}} </span>
                            @endif
                        @endforeach
                        @endif
                        </a>
                        @endif
                        @if($userlevel_id == 1 || $userlevel_id == 3)
                        <a href="{{ url('income/receipt') }}" class="btn btn-dark py-4 mt-3" style="width: 100%;font-size: 24px">ใบเสร็จ
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
    </div>

@endsection
