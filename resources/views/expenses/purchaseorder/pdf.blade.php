<!doctype html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<style>
@font-face{
    font-family:  'THSarabunNew';
    font-style: normal;
    font-weight: normal;
    src: url("{{ public_path('fonts/THSarabunNew.ttf') }}") format('truetype');
   }
   @font-face{
    font-family:  'THSarabunNew';
    font-style: normal;
    font-weight: bold;
    src: url("{{ public_path('fonts/THSarabunNew Bold.ttf') }}") format('truetype');
   }
   @font-face{
    font-family:  'THSarabunNew';
    font-style: italic;
    font-weight: normal;
    src: url("{{ public_path('fonts/THSarabunNew Italic.ttf') }}") format('truetype');
   }
   @font-face{
    font-family:  'THSarabunNew';
    font-style: italic;
    font-weight: bold;
    src: url("{{ public_path('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
   }
   body{
        font-family: "THSarabunNew";
        line-height: 15px;
   }
   .number{
     text-align: right;
   }
</style>
<body>
    @foreach ($organizations as $organization)
    <p style="text-align: center; font-size:24px;" class="mt-5">{{$organization->organization_name}}</p>
    <p style="text-align: center; font-size:18px" class="mt-2">{{$organization->organization_address}}</p>
    @endforeach
    <p class="mt-5" style="text-align: center; font-size: 20px">ใบสั่งซื้อ</p>
    <table class="table table-bordered mt-4">
        <tr>
            <td>
                @foreach ($details as $detail)
                    <p style="font-size: 16px">ชื่อผู้ติดต่อ : {{$detail->partner_name}} </p>
                    <p style="font-size: 16px">ที่อยู่ : {{$detail->address}}</p>
                    <p style="font-size: 16px">เบอร์โทร : {{$detail->partner_tel}} </p>
                    <p style="font-size: 16px">อีเมล : {{$detail->partner_email}}</p>
                @endforeach
            </td>
            <td>
                @foreach ($details as $detail)
                <p style="font-size: 16px">หมายเลขใบเสนอราคา : {{$detail->po_id}} </p>
                <p style="font-size: 16px">วันที่ : {{date('d-m-Y', strtotime($detail->created_at))}} </p>
                @endforeach
            </td>
        </tr>
    
    </table>
           
    
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
        @foreach ($purchaseorders as $purchaseorder)
        <?php $i++?>
          <tr>
            <th class="number" scope="row" style="width: 10%">{{$i}}</th>
            <td style="width: 40%">{{$purchaseorder->product_name}}</td>
            <td class="number">{{$purchaseorder->amount}}</td>
            <td class="number">{{number_format($purchaseorder->saleprice)}}</td>
            <td class="number">{{number_format($purchaseorder->saleprice * $purchaseorder->amount)}}</td>
          </tr>
          @endforeach
          @foreach ($sums as $sum)
          <tr>
            <td rowspan="3" colspan="3">หมายเหตุ : </td><td>VATABLE</td><td class="number">{{number_format($sum->sum - ($sum->sum * 7/100))}}</td>
            </tr>
            <tr>
                <td>VAT 7%</td><td class="number">{{number_format($sum->sum * 7/100)}}</td>
            </tr>
            <tr>
              <td>ราคารวมทั้งสิ้น</td><td class="number">{{number_format($sum->sum)}}</td>
        </tr>
          @endforeach
        </tbody>
       
      </table>
      <div style="float: right;width: 40%;">
        <div style="width: 40%;margin-right: 5px;float: left;">
            <p class="text-center">ผู้อนุมัติ</p>
            <p width="100%" style="border-bottom: 1px dotted;margin-top: 2cm;"></p>
            <p width="100%" style="border-bottom: 1px dotted;">วันที่</p>
        </div>
        <div style="width: 40%;float: left;margin-left: 55%">
            <p class="text-center">ผู้ยอมรับใบสั่งซื้อ</p>
            <p width="100%" style="border-bottom: 1px dotted;margin-top: 2cm;"></p>
            <p width="100%" style="border-bottom: 1px dotted;">วันที่</p>
        </div>
      </div>
    </div>
    </body>
</html>




   


