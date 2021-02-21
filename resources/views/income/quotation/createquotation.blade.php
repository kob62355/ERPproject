@extends('layouts.app')
@extends('layouts.checkauth')
@section('content')
@include('layouts.navmenu')

<meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="container mt-5 shadow p-3 mb-5 bg-white rounded">
    
        <div class="jumbotron text-center bg-dark text-white">
            <h1>รายการที่ยังไม่ได้สร้างใบเสนอราคา</h1>
            
        </div>
               

        
        <div class="my-2">
            <a href = "{{url('income/quotation/list')}}" class=" btn btn-secondary"> <i class="fa fa-arrow-left mx-2"></i> ย้อนกลับ</a>
        </div>

        <div class="my-2">
            <table id="example" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th scope="col">วันที่สร้าง</th>
                    <th scope="col">รหัสรายรับ</th>
                    <th scope="col">ชื่อลูกค้า</th>
                    <th scope="col">ยอดสุทธิ</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                    
                    @foreach($incomeslist as $income)
                    
                    <tr>
                    <th scope="row">{{$income->created_at}}</th>
                    <td>{{$income->income_id}}</td>
                    <td>{{$income->partner_name}}</td>
                    <td>{{number_format($income->sum,2)}}</td>
                    <td><a style="color: white" class="btn btn-secondary mr-2"  data-toggle="modal" data-target="#ModalMakeQuotation" onclick="preview({{$income->income_id}})">สร้างใบเสนอราคา</a><button class="btn btn-danger" >ยกเลิก</button></td>
                    </tr>
                    
                    @endforeach 
                   
                </tbody>
              </table>
        </div>

        

        
    </div>

        <!-- Modal_Add_quotation -->
        <div class="modal fade bd-example-modal-lg" id="ModalMakeQuotation" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
          <form action="{{url("income/quotation")}}" method="POST" onsubmit="return accept()">
            @csrf
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">ตัวอย่างใบเสนอราคา</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    @foreach ($organizations as $organization)
                    <h1 style="text-align: center;" class="mt-5">{{$organization->organization_name}}</h1>
                    <p style="text-align: center;font-size: 18px" >{{$organization->organization_address}}</p>
                    @endforeach
                    <h2 class="mt-5" style="text-align: center">ใบเสนอราคา</h2>
                    <div class="row" class="mx-3 mt-2" >
                        <div class="col-9 border border-dark">
                            <div class="ml-2 my-4">
                        
                                    <p style="font-size: 16px" id="partnername">ชื่อลูกค้า : </p>
                                    <p style="font-size: 16px" id="partneraddress">ที่อยู่ : </p>
                                    <p style="font-size: 16px" id="partnertel">เบอร์โทร : </p>
                                    <p style="font-size: 16px" id="partneremail">อีเมล : </p>
                     
                            </div>
                        </div>
                        <div class="col-3 border border-dark ">
                            <div class="ml-2 my-4">
                                <p style="font-size: 16px">หมายเลขใบเสนอราคา :  ## </p>
                                <p style="font-size: 16px">วันที่ : {{date('d-m-Y', time())}} </p>
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
                        <tbody id="tbody">
                       
                        
                       
        
                         
                         
                          
                        </tbody>
                       
                      </table>
                    
                </div>
                <div class="modal-footer" id="modalfooter">
                    
                
                </div>
              
              </div>
            </div>
          </form>
          </div>
        
          <!-- End_Modal -->
<script>
$(document).ready(function(){
  
        $('#example').DataTable({
            "ordering": false 
          });
        
        $.ajaxSetup({
            headers:
            { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
});
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
function preview(income_id){
            $("#tbody").empty();
            $("#modalfooter").empty();
            $.ajax({
               type:'POST',
               url:"{{ url('income/quotation/create') }}" ,
               data: {'income_id': income_id},
               success:function(data) {
                var jsonlength = Object.keys(data).length;
                var i = 0;
                var netprice = 0;
                console.log(data);
                
                $("#partnername").text("ชื่อลูกค้า : " + data[0].partner_name);
                $("#partneraddress").text("ที่อยู่ : " + data[0].partner_address);
                $("#partnertel").text("เบอร์โทร : " + data[0].partner_tel);
                $("#partneremail").text("อีเมล : " + data[0].partner_email);
                while(i < jsonlength){
                    var x = i + 1; 
                    var sum = data[i].amount * data[i].saleprice;
                    netprice = netprice + sum;
                    $("#tbody").append("<tr><th scope=\"row\" style=\"width: 10%\">"+ x +"</th><td style=\"width: 40%\" id=\"productname\">"+ data[i].product_name + "</td><td id=\"productamount\">" + data[i].amount+ "</td><td id=\"saleprice\">"+ numberWithCommas(data[i].saleprice)+ "</td><td id=\"sum\">"+numberWithCommas(sum)+"</td></tr>");
                    i++;
                }
                var vat = netprice * 7 /100;
                var vatable = netprice;
                $("#tbody").append("<tr><td rowspan=\"3\" colspan=\"3\">หมายเหตุ <br> <textarea class=\"form-control\" rows=\"5\" id=\"detail\" style=\"width: 100%\" name=\"detail\"></textarea></td><td>VATABLE</td><td>"+numberWithCommas(vatable)+"</td></tr><tr><td>VAT 7%</td><td>"+ numberWithCommas(vat) +"</td></tr><tr><td>ราคารวมทั้งสิ้น</td><td>"+numberWithCommas(netprice + vat)+"</td></tr>");
                $("#tbody").append("<input type=\"hidden\" name=\"income_id\" value="+income_id+">");
                //$("#modalfooter").append("<a onclick=\"return accept()\" href=\"{{url('income/quotation/')}}/"+income_id+"\" class=\"btn btn-primary mr-2\">สร้างใบเสนอราคา</a><button type=\"button\" class=\"btn btn-secondary cancel\" data-dismiss=\"modal\">ยกเลิก</button>");
                $("#modalfooter").append("<input class=\"btn btn-primary\" type=\"submit\" name=\"submit\"  value=\"ยืนยัน\" ><button type=\"button\" class=\"btn btn-secondary cancel\" data-dismiss=\"modal\">ยกเลิก</button>");
                
              }
            });
}
function accept(){
  var txt;
  var r = confirm("ยืนยันการสร้างใบเสนอราคา");
  if (r == true) {
    txt = "ยืนยัน";
    return true;
  } else {
    txt = "ยกเลิก";
    return false;
  }
  document.getElementById("demo").innerHTML = txt;
}

</script>
@endsection
