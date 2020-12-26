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
            <h1>รายจ่าย</h1>
            
        </div>
        
        <div class="my-2">
          <a href = "{{url('expenses')}}" class="mr-2 btn btn-secondary"> <i class="fa fa-arrow-left mx-2"></i> ย้อนกลับ</a> <a href="{{url('expenses/insert')}}" class="btn btn-primary mr-2">+ เพิ่มรายการรายจ่าย</a> 
        </div>

        <table id="example" class="table table-striped table-bordered">
            <thead>
              <tr>
               
                <th scope="col">วันที่สร้าง</th>
                <th scope="col">รหัสรายจ่าย</th>
                <th scope="col">ชื่อลูกค้า</th>
                <th scope="col">ยอดสุทธิ</th>
                <th scope="col">สถานะ</th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
                
                @foreach($expensess as $expenses)
                <tr>
                <th scope="row">{{$expenses->created_at}}</th>
                <td>{{$expenses->expenses_id}}</td>
                <td>{{$expenses->partner_name}}</td>
                <td>{{number_format($expenses->sum,2)}}</td>
                @if($expenses->status_id <= 1)
                <td><span class="badge badge-danger py-2" style="padding: 5px;font-size: 12px;width: 100%">{{$expenses->status_name}}</span></td>
                @endif
                @if($expenses->status_id == 2)
                <td><span class="badge badge-danger py-2"  style="padding: 5px;font-size: 12px;width: 100%">{{$expenses->status_name}}</span></td>
                @endif
                @if($expenses->status_id == 3)
                <td><span class="badge badge-success py-2"  style="padding: 5px;font-size: 12px;width: 100%">{{$expenses->status_name}}</span></td>
                @endif
                <td><button class="btn btn-secondary mr-2 @if($expenses->status_id >= 2)disabled @endif" @if($expenses->status_id <= 1)onclick="location.href='{{url('expenses/update/'.$expenses->expenses_id.'')}}'"@endif @if($expenses->status_id >= 2) onclick="alertshow()" @endif>แก้ไข</button></td>
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
