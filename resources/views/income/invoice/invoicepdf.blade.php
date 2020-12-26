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
    <p style="text-align: center; font-size:24px;" class="mt-5"><b>{{$organization->organization_name}}</b></p>
    <p style="text-align: center; font-size:18px" class="mt-2">{{$organization->organization_address}}</p>
    @endforeach
    <p class="mt-5" style="text-align: center; font-size: 20px"><b>ใบวางบิล</b></p>
    <table class="table table-bordered mt-4">
        <tr>
            <td>
                @foreach ($details as $detail)
                    <p style="font-size: 16px">ชื่อลูกค้า : {{$detail->partner_name}} </p>
                    <p style="font-size: 16px">ที่อยู่ : {{$detail->address}}</p>
                    <p style="font-size: 16px">เบอร์โทร : {{$detail->partner_tel}} </p>
                    <p style="font-size: 16px">อีเมล : {{$detail->partner_email}}</p>
                @endforeach
            </td>
            <td>
                @foreach ($details as $detail)
                <p style="font-size: 16px">หมายเลขใบวางบิล : {{$detail->inv_id}} </p>
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
        @foreach ($invoices as $invoice)
        <?php $i++?>
          <tr>
            <th class="number" scope="row" style="width: 10%">{{$i}}</th>
            <td style="width: 40%">{{$invoice->product_name}}</td>
            <td class="number">{{$invoice->amount}}</td>
            <td class="number">{{number_format($invoice->saleprice,2)}}</td>
            <td class="number">{{number_format($invoice->saleprice * $invoice->amount,2)}}</td>
          </tr>
          @endforeach
          @foreach ($sums as $sum)
          <tr>
            <td rowspan="3" colspan="3">ช่องทางการชำระเงิน </td><td>VATABLE</td><td class="number">{{number_format($sum->sum - ($sum->sum * 7/100),2)}}</td>
            </tr>
            <tr>
                <td>VAT 7%</td><td class="number">{{number_format($sum->sum * 7/100,2)}}</td>
            </tr>
            <tr>
              <td>ราคารวมทั้งสิ้น</td><td class="number">{{number_format($sum->sum,2)}}</td>
        </tr>
          @endforeach
        </tbody>
       
      </table>
      
      <table class="table table-bordered mt-4" style="width: 100%;">
        <tr>
            <td style="width: 30%">
              <div class="mx-1 my-1">
                <p class="text-center">ผู้รับวางบิล</p>
                <p width="100%" style="border-bottom: 1px dotted;margin-top: 1.5cm;"></p>
                <p width="100%" style="border-bottom: 1px dotted;">วันที่รับวางบิล</p>
                
              </div>
            </td>
            <td style="width: 30%">
              <div class="mx-1 my-1">
                <p class="text-center">ผู้วางบิล</p>
                <p width="100%" style="border-bottom: 1px dotted;margin-top: 1.5cm;"></p>
                <p width="100%" style="border-bottom: 1px dotted;">วันที่</p>
              </div>
            </td>
            <td style="width: 30%">
              <div class="mx-1 my-1">
                <p class="text-center">วันครบกำหนดชำระ</p>
                <p width="100%" style="border-bottom: 1px dotted;margin-top: 1.5cm;"></p>
                
              </div>
            </td>
            
        </tr>
    
    </table>
      </div>
    </body>
</html>




   


