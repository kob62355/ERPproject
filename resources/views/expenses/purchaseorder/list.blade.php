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
            <h1>ใบสั่งซื้อ</h1>
        </div>
                @foreach ($readytopurchaseorder as $amount)
                    @if($amount->readytopurchaseorder > 0)
                    <div class="alert alert-primary" role="alert">
                    <p>มีเอกสารที่ยังไม่ได้ออกใบสั่งซื้อทั้งหมด {{$amount->readytopurchaseorder}} รายการ</p>
                    </div> 
                    @endif
                @endforeach
        <div class="my-2">
          <a href = "{{url('expenses')}}" class="mr-2 btn btn-secondary"> <i class="fa fa-arrow-left mx-2"></i> ย้อนกลับ</a>
          @if($userlevel_id == 1|| $userlevel_id == 4)  
          <a href="{{url('expenses/purchaseorder/create')}}" style="color: white" class="btn btn-primary mr-2">+ สร้างใบสั่งซื้อ  
              @foreach ($readytopurchaseorder as $amount)
                @if($amount->readytopurchaseorder > 0)
                  <span class="badge badge-danger"> {{$amount->readytopurchaseorder}} </span>
                @endif
              @endforeach
            </a> 
          @endif
          @if($userlevel_id == 1 || $userlevel_id == 3)
            <a href="{{url('expenses/purchaseorder/accept')}}" class="btn btn-success mr-2">อนุมัติใบสั่งซื้อ
              @foreach ($readytoaccept as $amount)
                @if($amount->readytoaccept > 0)
                  <span class="badge badge-danger"> {{$amount->readytoaccept}} </span>
                @endif
              @endforeach
            </a>
          @endif
          @if($userlevel_id == 1 || $userlevel_id == 4)
            <a href="{{url('expenses/purchaseorder/acceptpay')}}" class="btn btn-success mr-2">อนุมัติการชำระเงิน
              @foreach ($readytoacceptpay as $amount)
                @if($amount->readytoaccept > 0)
                  <span class="badge badge-danger"> {{$amount->readytoaccept}} </span>
                @endif
              @endforeach
            </a>
            @endif
        </div>

        <div class="my-2">
            <table id="example" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th scope="col">วันที่สร้าง</th>
                    <th scope="col">รหัสใบสั่งซื้อ</th>
                    <th scope="col">ชื่อผู้ติดต่อ</th>
                    <th scope="col">ยอดสุทธิ</th>
                    <th scope="col">สถานะ</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                    
                  @foreach($purchaseorders as $purchaseorder)
                  <tr>
                  <th scope="row">{{$purchaseorder->created_at}}</th>
                  <td>{{$purchaseorder->po_id}}</td>
                  <td>{{$purchaseorder->partner_name}}</td>
                  <td>{{number_format($purchaseorder->sum,2)}}</td>
                  
                  @if ($purchaseorder->status_id == 1)
                      <td><span class="badge badge-danger py-2" style="padding: 5px;font-size: 12px;width: 100%">ยังไม่ได้อนุมัติ</span></td>
                  @endif
                  @if ($purchaseorder->status_id == 2)
                      <td><span class="badge badge-danger py-2"  style="padding: 5px;font-size: 12px;width: 100%">รอการชำระเงิน</span></td>
                  @endif
                  @if ($purchaseorder->status_id == 3)
                      <td><span class="badge badge-success py-2"  style="padding: 5px;font-size: 12px;width: 100%">เสร็จสิ้น</span></td>
                  @endif
                  <td><button class="btn btn-secondary mr-2 @if($purchaseorder->status_id >= 2)disabled @endif" @if($purchaseorder->status_id == 1)onclick="location.href='{{url('expenses/update/'.$purchaseorder->expenses_id.'')}}'"@endif @if($purchaseorder->status_id >= 2) onclick="alertshow()" @endif @if($purchaseorder->status_id >= 2) aria-disabled="true" tabindex="-1" @endif>แก้ไขรายการ</button><button class="btn btn-primary mr-2" onclick="location.href='{{url('expenses/purchaseorder/show/'.$purchaseorder->purchaseorder_id.'')}}'">ดูใบสั่งซื้อ</button></td>
                  </tr>
                  @endforeach 
                   
                  
                 
                </tbody>
              </table>
        </div>

        

        
    </div>

    <script>
      $(document).ready(function() {
        $('#example').DataTable({
                "ordering": false 
              });
      } );
      </script>

@endsection
