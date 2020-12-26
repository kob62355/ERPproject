@extends('layouts.app')
@extends('layouts.checkauth')
@section('content')
@include('layouts.navmenu')


    <div class="container mt-5 shadow p-3 mb-5 bg-white rounded">
    
        <div class="jumbotron text-center bg-dark text-white">
            <h1>ใบวางบิล</h1>
        </div>


        
        <div class="my-2">
            <a href = "{{url('income/')}}" class="my-2 mr-2 btn btn-secondary"> <i class="fa fa-arrow-left mx-2"></i> ย้อนกลับ</a>
            <a href="{{url('income/invoice/create')}}" style="color: white" class="btn btn-primary mr-2">+ สร้างใบวางบิล 
                @foreach ($readytoinvoice as $amount)
                @if($amount->readytoinvoice > 0)
                  <span class="badge badge-danger"> {{$amount->readytoinvoice}} </span>
                @endif
              @endforeach
            </a> 
            
        </div>

        <div class="my-2">
            <table id="example" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th scope="col">วันที่สร้าง</th>
                    <th scope="col">รหัสใบวางบิล</th>
                    <th scope="col">ชื่อลูกค้า</th>
                    <th scope="col">ยอดสุทธิ</th>
                    <th scope="col">สถานะ</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                    <tr>
                    <th scope="row">{{$invoice->created_at}}</th>
                    <td>{{$invoice->inv_id}}</td>
                    <td>{{$invoice->partner_name}}</td>
                    <td>{{number_format($invoice->sum,2)}}</td>
                    @if ($invoice->status_id <= 3)
                        <td><span class="badge badge-danger py-2" style="padding: 5px;font-size: 12px;width: 100%">ยังไม่ได้ชำระเงิน</span></td>
                    @endif
                    @if ($invoice->status_id >= 4)
                        <td><span class="badge badge-success py-2"  style="padding: 5px;font-size: 12px;width: 100%">ชำระเงินแล้ว</span></td>
                    @endif
                    <td><button class="btn btn-primary mr-2" onclick="location.href='{{url('income/invoice/show/'.$invoice->invoice_id.'')}}'">ดูใบวางบิล</button></td>
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
