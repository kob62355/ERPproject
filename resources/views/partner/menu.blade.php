@extends('layouts.app')
@extends('layouts.checkauth')
@section('content')
@include('layouts.navmenu')
    <div class="container mt-5 shadow p-3 mb-5 bg-dark rounded">
        <div class="card text-dark bg-light mb-3">
            <h1 class="card-header"><a href = "{{url('organization/menu')}}" class="my-2 mr-4 btn btn-secondary p-3"> <i class="fa fa-arrow-left mx-2"></i></a>ผู้ติดต่อ</h1>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        @if($userlevel_id == 1 || $userlevel_id == 2 || $userlevel_id == 4)
                        <a href="{{ url('partner/insert') }}" class="btn btn-dark py-4" style="width: 100%;font-size: 24px">เพิ่มผู้ติดต่อ</a>
                        @endif
                        @if($userlevel_id == 1 || $userlevel_id == 2 || $userlevel_id == 4 || $userlevel_id == 5)
                        <a href="{{ url('partner/list/')}}" class="btn btn-dark mt-3 py-4" style="width: 100%;font-size: 24px">รายชื่อผู้ติดต่อ</a>
                        @endif
                    </div>
                    <div class="col">
                        <img src="{{url('/images/partner.png')}}" style="width: 100%">
                    </div>
                </div>
            </div>
        </div> 
    </div>
@endsection
