@extends('layouts.app')
@extends('layouts.checkauth')
@section('content')
@include('layouts.navmenu')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
 
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['เดือน', 'รายได้','รายจ่าย'],
     @foreach($incomeline as $line)
     
      ['{{$line->Month}}',{{$line->sum}},null],
     @endforeach

     @foreach($expensesline as $lineex)
      ['{{$lineex->Month}}',null,{{$lineex->sum}}],
     @endforeach
      
    ]);

    var options = {
      title: 'รายได้ - รายจ่าย',
      curveType: 'function',
      slegend: { position: 'bottom' }
    };

    var chart = new google.visualization.BarChart(document.getElementById('curve_chart'));

    chart.draw(data, options);
  }


</script>

    <div class="container mt-5 shadow p-3 mb-5 bg-white rounded">
        <div class="jumbotron text-center bg-dark text-white">
            <h1>งบกำไร - ขาดทุน</h1>
            
        </div>
        
        <div class="my-2">
          <a href = "{{url('organization/menu')}}" class="my-2 btn btn-secondary"> <i class="fa fa-arrow-left mx-2"></i> ย้อนกลับ</a>
        </div>
        <ul class="nav nav-tabs">
            <li class="nav-item">
              <a class="nav-link" href="{{url('report/profit/')}}">ทั้งหมด</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('report/profit/1month')}}">เดือนที่ผ่านมา</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="{{url('report/profit/3month')}}">ไตรมาส</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="{{url('report/profit/custom')}}">กำหนดเอง</a>
            </li>
          </ul>

        @if($incomes && $expensess)
        <div class="mx-5 mt-5">
        <h1 style="text-align: center">งบกำไรขาดทุน</h1>
        <p style="text-align: center;font-size: 18px;">@foreach ($organizations as $organization){{$organization->organization_name}} @endforeach</p>
        <p style="text-align: center;font-size: 18px;">เดือน {{$Begin}} ถึง {{$End}} ปี {{$year}}</p>
        <p style="text-align: left;font-size: 18px;" ><b>รายได้</b></p>
        <div class="row">
            <div class="col-6"><label style="text-align: left;font-size: 18px;" class="ml-5" >รายได้จากการขาย</label></div><div class="col-3"></div><div class="col-3"><label style="text-align: right;font-size: 18px;float: right; ">@foreach ($incomes as $income){{number_format($income->sumincome)}}@endforeach</label></div>
        </div>
        <p style="text-align: left;font-size: 18px;" ><b>ค่าใช้จ่าย</b></p>
        <div class="row">
            <div class="col-6"><label style="text-align: left;font-size: 18px;" class="ml-5" >ต้นทุนขาย</label></div><div class="col-3"><label style="text-align: right;font-size: 18px;float: right; ">@foreach ($expensess as $expenses){{number_format($expenses->sumexpenses)}}@endforeach</label></div><div class="col-3"></div>
        </div>
        <div class="row">
          <div class="col-6">@foreach ($incomes as $income) @foreach ($expensess as $expenses) @if(($income->sumincome - $expenses->sumexpenses) >= 0)<label style="text-align: left;font-size: 18px;" ><b>กำไรสุทธิ</b></label> @else <label style="text-align: left;font-size: 18px;" ><b>ขาดทุนสุทธิ</b></label> @endif @endforeach @endforeach</div><div class="col-3"></div><div class="col-3"><label style="text-align: right;font-size: 18px;float: right; ">@foreach ($incomes as $income) @foreach ($expensess as $expenses){{number_format($income->sumincome - $expenses->sumexpenses)}}@endforeach @endforeach</label></div>
        </div>

        </div>
        
        @endif
        <div class="row">
        @if($incomeline)
        <div class="col" id="curve_chart" style="width: 500px; height: 400px;"></div>
        @endif
        
        </div>
    </div>

     

    <script>
        $(document).ready(function(){
          $('#example').DataTable();
       
        });
     
    </script>
@endsection
