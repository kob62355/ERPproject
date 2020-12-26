@extends('layouts.app')
@extends('layouts.checkauth')
@section('content')
@include('layouts.navmenu')

<script>
  function alertshow(){
    alert("ไม่สามารถแก้ไขได้เนื่องจากอนุมัติไปแล้ว");
  }
</script>
    <div class="container mt-5 shadow p-3 mb-5 bg-white rounded">
        <div class="jumbotron text-center bg-dark text-white">
            <h1>รายรับ</h1>
            
        </div>
        
        <div class="my-2">
          <a href = "{{url('income')}}" class="mr-2 btn btn-secondary"> <i class="fa fa-arrow-left mx-2"></i> ย้อนกลับ</a> <a href="{{url('income/insert')}}" class="btn btn-primary mr-2">+ เพิ่มรายการรายรับ</a> 
        </div>

        <table id="example" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th scope="col">วันที่สร้าง</th>
                <th scope="col">รหัสรายรับ</th>
                <th scope="col">ชื่อลูกค้า</th>
                <th scope="col">ยอดสุทธิ</th>
                <th scope="col">สถานะ</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
                
                @foreach($incomes as $income)
                <tr>
                <th scope="row">{{$income->created_at}}</th>
                <td>{{$income->income_id}}</td>
                <td>{{$income->partner_name}}</td>
                <td>{{number_format($income->sum,2)}}</td>
                @if($income->status_id <= 3)
                <td><span class="badge badge-danger py-2" style="padding: 5px;font-size: 12px;width: 100%">{{$income->status_name}}</span></td>
                @endif
                @if($income->status_id == 4)
                <td><span class="badge badge-success py-2"  style="padding: 5px;font-size: 12px;width: 100%">{{$income->status_name}}</span></td>
                @endif
                <td><button class="btn btn-secondary mr-2 @if($income->status_id >= 2)disabled @endif" @if($income->status_id <= 1)onclick="location.href='{{url('income/update/'.$income->income_id.'')}}'"@endif @if($income->status_id >= 2) onclick="alertshow()" @endif>แก้ไข</button></td>
                </tr>
                @endforeach 
               
              
             
            </tbody>
          </table>

    </div>
    <script>
    $(document).ready(function() {
      $('#example').DataTable({
            "ordering": false 
          });
    } );
    </script>
@endsection
