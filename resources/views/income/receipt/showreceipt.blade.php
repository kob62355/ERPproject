@extends('layouts.app')
@extends('layouts.checkauth')
@section('content')
@include('layouts.navmenu')
<div class="container mt-5 shadow p-5 mb-5 bg-white rounded">
    @foreach ($details as $detail)
    <a href = "{{url()->previous()}}" class="my-2 mr-2 btn btn-secondary"> <i class="fa fa-arrow-left mx-2"></i> ย้อนกลับ</a>
    <a href="{{url('income/receipt/show/pdf/'.$detail->receipt_id)}}" class="btn btn-primary" style="float: right">สร้างเอกสาร PDF</a>
    @endforeach
    
    @foreach ($organizations as $organization)
    <h1 style="text-align: center;" class="mt-5">{{$organization->organization_name}}</h1>
    <p style="text-align: center;font-size: 18px" >{{$organization->organization_address}}</p>
    <p style="text-align: center;font-size: 18px">
        @if ($organization->organization_tel != null)
           <span style="mr-3">โทร. {{$organization->organization_tel}} </span>
        @endif
        @if ($organization->organization_taxid != null)
            <span style="mr-3">เลขประจำตัวผู้เสียภาษี {{$organization->organization_taxid}}</span>
        @endif
    </p>
    @endforeach
    <h2 class="mt-5" style="text-align: center">ใบเสร็จ</h2>
    <div class="row" class="mx-3 mt-2" >
        <div class="col-8 border border-dark">
            <div class="ml-2 my-4">
                @foreach ($details as $detail)
                    <p style="font-size: 16px">ชื่อลูกค้า : {{$detail->partner_name}} </p>
                    <p style="font-size: 16px">ที่อยู่ : {{$detail->address}}</p>
                    @if ($detail->partner_tel != '-')
                    <p style="font-size: 16px">เบอร์โทร : {{$detail->partner_tel}} </p>
                    @endif
                    @if ($detail->partner_email != '-')
                    <p style="font-size: 16px">อีเมล : {{$detail->partner_email}} </p>
                    @endif
                    
                    
                @endforeach
            </div>
        </div>
        <div class="col-4 border border-dark ">
            <div class="ml-2 my-4">
                @foreach ($details as $detail)
                <p style="font-size: 16px">หมายเลขใบเสร็จ : {{$detail->rt_id}} </p>
                <p style="font-size: 16px">วันที่ : {{date('d-m-Y', strtotime($detail->created_at))}} </p>
                @endforeach
            </div>
        </div>
    </div>
    
    <table class="table table-bordered mt-5" style="font-size: 16px">
        <thead>
          <tr>
            <th scope="col">ลำดับ</th>
            <th scope="col">รายการ</th>
            <th scope="col">จำนวน</th>
            <th scope="col">ราคา/หน่วย</th>
            <th scope="col">ราคารวม</th>
          </tr>
        </thead>
        <tbody>
        <?php $i = 0; ?>
        @foreach ($receipts as $receipt)
        <?php $i++?>
          <tr>
          <th scope="row" style="width: 10%">{{$i}}</th>
          <td style="width: 40%">{{$receipt->product_name}}</td>
          <td style="text-align: right">{{$receipt->amount}}</td>
          <td style="text-align: right">{{number_format($receipt->saleprice,2)}}</td>
          <td style="text-align: right">{{number_format($receipt->saleprice * $receipt->amount,2)}}</td>
          </tr>
          @endforeach
          @foreach ($sums as $sum)
          <tr>
          <td rowspan="3" colspan="3"><p>ชำระผ่านทาง</p>
            <p style="width: 600px; display: table;">
                <span style="display: table-cell; width: 30px;"><input type="checkbox" name="getmoney" class="radio" value="cash" disabled></span>
                <span style="display: table-cell; width: 120px;"><label> เงินสด</label><label style="margin-left: 5px">จำนวน</label></span>
                  <span style="display: table-cell; border-bottom: 1px solid black;margin-top: -4mm"></span>
                  <span style="display: table-cell; width: 50px;"><label style="margin-left: 5px">บาท</label></span>
              </p>
              <p style="width: 600px; display: table;">
                <span style="display: table-cell; width: 30px;"><input type="checkbox" name="getmoney" class="radio" value="transfer" disabled></span>
                <span style="display: table-cell; width: 120px;"><label> เงินโอน</label><label style="margin-left: 5px">จำนวน</label></span>
                  <span style="display: table-cell; border-bottom: 1px solid black;margin-top: -4mm"></span>
                  <span style="display: table-cell; width: 50px;"><label style="margin-left: 5px">บาท</label></span>
              </p>
              <p style="width: 600px; display: table;">
                <span style="display: table-cell; width: 30px;"><input type="checkbox" name="getmoney" class="radio" value="check" disabled></span>
                <span style="display: table-cell; width: 120px;"><label> เช็ค</label><label style="margin-left: 5px">จำนวน</label></span>
                  <span style="display: table-cell; border-bottom: 1px solid black;margin-top: -4mm"></span>
                  <span style="display: table-cell; width: 50px;"><label style="margin-left: 5px">บาท</label></span>
              </p>
          </td><td>VATABLE</td><td style="text-align: right">{{number_format($sum->sum,2)}}</td>
          </tr>
          <tr>
              <td>VAT 7%</td><td style="text-align: right">{{number_format($sum->sum * 7/100,2)}}</td>
          </tr>
          <tr>
            <td>ราคารวมทั้งสิ้น</td><td style="text-align: right">{{number_format($sum->sum + + ($sum->sum * 7/100),2)}}</td>
        </tr>
          @endforeach
        </tbody>
       
      </table>
</div>
    
@endsection




   


