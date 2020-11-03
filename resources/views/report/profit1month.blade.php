@extends('layouts.app')
@extends('layouts.checkauth')
@section('content')
@include('layouts.navmenu')


    <div class="container mt-5 shadow p-3 mb-5 bg-white rounded">
        <div class="jumbotron text-center bg-dark text-white">
            <h1>งบกำไร - ขาดทุน</h1>
            
        </div>
        
        <div class="my-2">
          <a href = "{{url('report')}}" class="mr-2 btn btn-secondary"> <i class="fa fa-arrow-left mx-2"></i> ย้อนกลับ</a> 
        </div>
        <ul class="nav nav-tabs">
            <li class="nav-item">
              <a class="nav-link" href="{{url('report/profit/')}}">ทั้งหมด</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="{{url('report/profit/1month')}}">เดือนที่ผ่านมา</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('report/profit/3month')}}">3 เดือน</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">กำหนดเอง</a>
            </li>
          </ul>
        <div class="mx-5 mt-5">
        <h1 style="text-align: center">งบกำไรขาดทุน</h1>
        <p style="text-align: left;font-size: 18px;" ><b>รายได้</b></p>
        <div class="row">
            <div class="col-6"><label style="text-align: left;font-size: 18px;" class="ml-5" >รายได้จากการขาย</label></div><div class="col-3"></div><div class="col-3"><label style="text-align: right;font-size: 18px;float: right; ">@foreach ($incomes as $income){{number_format($income->sumincome)}}@endforeach</label></div>
        </div>
        <p style="text-align: left;font-size: 18px;" ><b>ค่าใช้จ่าย</b></p>
        <div class="row">
            <div class="col-6"><label style="text-align: left;font-size: 18px;" class="ml-5" >ต้นทุนขาย</label></div><div class="col-3"><label style="text-align: right;font-size: 18px;float: right; ">@foreach ($expensess as $expenses){{number_format($expenses->sumexpenses)}}@endforeach</label></div><div class="col-3"></div>
        </div>
        <div class="row">
            <div class="col-6"><label style="text-align: left;font-size: 18px;" ><b>กำไรสุทธิ</b></label></div><div class="col-3"></div><div class="col-3"><label style="text-align: right;font-size: 18px;float: right; ">@foreach ($incomes as $income) @foreach ($expensess as $expenses){{number_format($income->sumincome - $expenses->sumexpenses)}}@endforeach @endforeach</label></div>
        </div>

        </div>
        
        

    </div>

     

    <script>
        $(document).ready(function(){
          $('#example').DataTable();
       
        });
     
    </script>
@endsection
