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
    <p class="mt-5" style="text-align: center; font-size: 20px">ใบเสร็จ</p>
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
                <p style="font-size: 16px">หมายเลขใบเสร็จ : {{$detail->rt_id}} </p>
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
        @foreach ($receipts as $receipt)
        <?php $i++?>
          <tr>
            <th class="number" scope="row" style="width: 10%">{{$i}}</th>
            <td style="width: 40%">{{$receipt->product_name}}</td>
            <td class="number">{{$receipt->amount}}</td>
            <td class="number">{{number_format($receipt->saleprice,2)}}</td>
            <td class="number">{{number_format($receipt->saleprice * $receipt->amount,2)}}</td>
          </tr>
          @endforeach
          @foreach ($sums as $sum)
          <tr>
            <td rowspan="3" colspan="3">
              ชำระผ่านทาง<br>
               
              <p style="width: 400px; display: table;">
                <span style="display: table-cell; width: 100px;"><input type="checkbox" name="getmoney" class="radio" value="cash" >
                  <label> เงินสด</label><label style="margin-left: 5px">จำนวน</label></span>
                  <span style="display: table-cell; border-bottom: 1px solid black;margin-top: -4mm"></span>
                  <span style="display: table-cell; width: 50px;"><label style="margin-left: 5px">บาท</label></span>
              </p>
              <p style="width: 400px; display: table;">
                <span style="display: table-cell; width: 100px;"><input type="checkbox" name="getmoney" class="radio" value="transfer" >
                  <label> เงินโอน</label><label style="margin-left: 5px">จำนวน</label></span>
                  <span style="display: table-cell; border-bottom: 1px solid black;margin-top: -4mm"></span>
                  <span style="display: table-cell; width: 50px;"><label style="margin-left: 5px">บาท</label></span>
              </p>
              <p style="width: 400px; display: table;">
                <span style="display: table-cell; width: 100px;"><input type="checkbox" name="getmoney" class="radio" value="check" >
                  <label>เช็ค</label><label style="margin-left: 5px">จำนวน</label></span>
                  <span style="display: table-cell; border-bottom: 1px solid black;margin-top: -4mm"></span>
                  <span style="display: table-cell; width: 50px;"><label style="margin-left: 5px">บาท</label></span>
              </p>
            
            </td>
            <td>VATABLE</td><td class="number">{{number_format($sum->sum - ($sum->sum * 7/100),2)}}</td>
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
      <div style="float: right;width: 40%;">
        
        <div style="width: 40%;float: left;margin-left: 55%">
            <p class="text-center">ผู้รับเงิน</p>
            <p width="100%" style="border-bottom: 1px dotted;margin-top: 2cm;"></p>
            <p width="100%" style="border-bottom: 1px dotted;">วันที่</p>
        </div>
      </div>
    </div>
    </body>
</html>




   


