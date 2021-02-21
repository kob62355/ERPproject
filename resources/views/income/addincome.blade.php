@extends('layouts.app')
@extends('layouts.checkauth')
@section('content')
@include('layouts.navmenu')
<meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="container mt-5 shadow p-3 mb-5 bg-white rounded">
        <div class="jumbotron text-center bg-dark text-white">
            <h1>เพิ่มรายการรายรับ</h1>
        </div>
        
      <a href = "{{url()->previous()}}" class="my-2 ml-5 btn btn-secondary"> <i class="fa fa-arrow-left mx-2"></i> ย้อนกลับ</a>
      @if ($errors->any())
        <div class="alert alert-danger mx-5 mt-5">  
          <ol>  
          @foreach ($errors->all() as $error)  
            <li>{{ $error }}</li>
        @endforeach
          </ol>
        </div>
      @endif
      <form class="mx-5 my-5" method="POST" action="{{url('income/insert')}}" id="accept" enctype="multipart/form-data">
        @csrf

          <div class="row my-2">
              <div class="col"><h5>ชื่อผู้ติดต่อ</h5></div><div class="col"></div>
          </div>
          <div class="row my-2">
              <div class="col-5">
                <select name="partner_id" class="form-control selectpicker" data-live-search="true" title="กรุณาเลือกผู้ติดต่อ" id="partnerid" data-size="5">
                  @foreach($partners as $partner)
                  <option value="{{$partner->partner_id}}">{{$partner->partner_name}}</option>
                  @endforeach 
                </select>
              </div>
              <div class="col-2">
                <button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#ModalAddPartner">+ เพิ่มผู้ติดต่อ</a> 
              </div>
            <div class="col-6">

            </div>
          </div>
          <div class="row my-2">
            <div class="col"><h5>ที่อยู่</h5></div><div class="col"></div>
          </div>
          <div class="row my-2">
            <div class="col"><textarea class="form-control" id="address" rows="8" name="partner_address" id="address"></textarea></div><div class="col"></div>
          </div>
          
          <div class="row my-2">
            <table class="table" id="table">
              <thead>
                <tr>
                  
                  <th scope="col">รายการ</th>
                  <th scope="col">จำนวน</th>
                  <th scope="col">ราคา/หน่วย</th>
                  <th scope="col">ราคารวม</th>
                </tr>
              </thead>
              <tbody class="section" id="section">
                
                <tr id="myTableRow1" >
                 
                  <td style="width: 40%">
                    <div class="row">
                      <div class="col-8" >
                      <select name="product_id[]"  class="form-control product-select selectpicker" data-live-search="true" title="กรุณาเลือกสินค้า" id="product1" data-size="5">
                        @foreach($products as $product)
                        <option value="{{$product->product_id}}">{{$product->product_name}}</option>
                        @endforeach 
                      </select>
                      </div>
                      <div class="col-4">
                      <a href="" class="btn btn-primary" data-toggle="modal" data-target="#ModalAddProduct">+ เพิ่มสินค้า</a> 
                      </div>
                    </div>
                  </td>
                  <td style="width: 15%"><input type="number" name="product_amount[]" class="form-control" id="productamount1"></td>
                  <td style="width: 15%"><input type="number" name="product_price[]"  class="form-control" id="productprice1"></td>
                  <td style="width: 20%"><a id="sum1" class="mt-2"></a><button type="button" class="btn btn-danger ml-4 btn-remove" id="buttondel1"><i class="fa fa-trash mx-2"></i></button></td>
                </tr>
                <tr id="myTableRow2" >
                 
                </tr>
                
              </tbody>
             
            </table>
            

            
            

            <button id="add" type="button" class="btn btn-dark btn-lg btn-block btn-add" id="btn-add">เพิ่มรายการ</button>
            </div>
            <div class="d-flex justify-content-end">
              <input type="submit" name="submit" class="my-2 btn btn-success" value="ยืนยัน">
              <a href = "{{url('income/list')}}" class="my-2 btn btn-danger ml-3">ยกเลิก</a>
              </div>
          </div>
        </form>

    </div>

 
    <!-- Modal_Add_Partner -->
    <div class="modal fade" id="ModalAddPartner" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">รายชื่อผู้ติดต่อ</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="form-group">
              <form action="{{ url('income/partner') }}" method="POST">
                @csrf
                  <input type="hidden" name="page" value="insert">
                  <label>ชื่อผู้ติดต่อ</label>
                  <input type="text" class="form-control" name="partner_name" id="partnername">
                  <label>ที่อยู่</label>
                  <textarea class="form-control" rows="8" name="partner_address" id="partneraddress"></textarea>
                  <label>เบอร์โทร</label>
                  <input type="text" class="form-control" name="partner_tel" id="partnertel">
                  <label>อีเมล์ติดต่อ</label>
                  <input type="text" class="form-control" name="partner_email" id="partneremail">
                
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
            <button type="button" class="btn btn-primary" id="addpartner">เพิ่มผู้ติดต่อ</button>
          </form>
          </div>
        </div>
      </div>
    </div>
    <!-- End_Modal_Add_partner -->
  
    <!-- Modal_Add_product -->
    <div class="modal fade" id="ModalAddProduct" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">รายการสินค้า</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="form-group">
                <form action="{{ url('income/product') }}" method="POST">
                  @csrf
                  <input type="hidden" name="page" value="insert">
                  <label for="exampleInputEmail1">ชื่อสินค้า</label>
                  <input type="text" class="form-control" name="product_name" id="productname">
                  <label for="exampleInputEmail1">รายละเอียด</label>
                  <textarea class="form-control" rows="8" name="product_description" id="productdescription"></textarea>
                
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="exitmodal">ยกเลิก</button>
            <button type="button" class="btn btn-primary" id="addproduct">เพิ่มรายการสินค้า</button>
          </form>
          </div>
        </div>
      </div>
    </div>
    <!-- End_Modal_Add_product -->

    


    <script>
      var number = 1;
      $(document).ready(function(){
        $.ajaxSetup({
            headers:
            { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
      $("#partnerid").change(function(){
        var partner_id = $("#partnerid").val();
        getaddress(partner_id);
      });
      $("#addpartner").click(function(){
        
        if($("#partnername").val() != '' && $("#partneraddress").val() != ''){
        var partnername = $("#partnername").val();
        var partneraddress = $("#partneraddress").val();
        var partnertel = $("#partnertel").val();
        var partneremail = $("#partneremail").val();
        if ($('#partnertel').val() == ''){
            partnertel = '-';
        }
        if ($('#partneremail').val() == ''){
            partneremail = '-';
        }
        addpartner(partnername,partneraddress,partnertel,partneremail);
        $("#partnername").val("");
        $("#partneraddress").val("");
        $("#partnertel").val("");
        $("#partneremail").val("");
      }
      else{
        alert("กรุณากรอกชื่อ - ที่อยู่");
      }     
      });
      $("#addproduct").click(function(){
        var productname = $("#productname").val();
        var productdescription = $("#productdescription").val();
        if ($('#productdescription').val() == ''){
            productdescription = '-';
        }
        addproduct(productname,productdescription);
        $("#productname").val("");
        $("#productdescription").val("")
      });
      $("#productamount1,#productprice1").change(function(){
        var productamount = $("#productamount1").val();
        var productprice = $("#productprice1").val();
        var total = parseFloat(productamount) * parseFloat(productprice);
        $("#sum1").text(numberWithCommas(total));
      });
      
      $("#buttondel1").click(function(){
       $("#myTableRow1").remove();
       $(this).remove();
      });
      $("#add").click(function(e){
        e.preventDefault();
        number++;
        var newIn = "<tr id=\"myTableRow"+number+"\"><td style=\"width: 40%\"><div class=\"row\"><div class=\"col-8\" ><select name=\"product_id[]\" class=\"form-control product-select selectpicker\" data-live-search=\"true\" title=\"กรุณาเลือกสินค้า\" id=\"product"+number+"\" data-size=\"5\"><option value=\"\" disabled selected hidden>กรุณาเลือกสินค้า</option> @foreach($products as $product)<option value=\"{{$product->product_id}}\">{{$product->product_name}}</option>@endforeach </select></div><div class=\"col-4\"><a href=\"\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\"#ModalAddProduct\">+ เพิ่มสินค้า</a> </div></div></td><td><input type=\"number\" name=\"product_amount[]\" class=\"form-control\" id=\"productamount"+number+"\"></td><td><input type=\"number\" name=\"product_price[]\"  class=\"form-control\" id=\"productprice"+number+"\"></td><td><a id=\"sum"+number+"\" class=\"mt-2\"></a><button type=\"button\" class=\"btn btn-danger btn-remove ml-4\" id=\"buttondel"+number+"\"><i class=\"fa fa-trash mx-2\"></i></button></td></tr>";
        var newInput = $(newIn);
        $("#myTableRow"+(number-1)).after(newInput);
        $("#myTableRow"+number).attr('data-source',$("#myTableRow"+(number-1)).attr('data-source'));
        $('.product-select').selectpicker('render');
        
        var total = 0;
        $("#productamount"+number+",#productprice"+number).change(function(e){
        e.preventDefault();
        var fieldNum = this.id.charAt(this.id.length-1);
        var productamount = $("#productamount"+fieldNum).val();
        var productprice = $("#productprice"+fieldNum).val();
        total = parseFloat(productamount) * parseFloat(productprice);
        $("#sum"+fieldNum).text(numberWithCommas(total));
            
       });
       $(".btn-remove").click(function(e){
          e.preventDefault();
          var fieldNum = this.id.charAt(this.id.length-1);
          $("#myTableRow"+fieldNum).remove();
          
        });
         
      
     }); 
     $("#accept").submit(function(){
        return accept();
      }); 
     
    
    function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    function getaddress(partner_id) {
           
            $.ajax({
               type:'POST',
               url:'{{url("getpartner")}}',
               data: {'partner_id': partner_id},
               success:function(data) {
                  $("#address").val(data.msg);
               }
            });
         }
    function addpartner(partnername,partneraddress,partnertel,partneremail){
          $.ajax({
               type:'POST',
               url:'{{ url("income/partner") }}',
               data: {'partner_name': partnername , 'partner_address' : partneraddress ,'partner_tel' : partnertel, 'partner_email' : partneremail},
               success:function(data) {
              
                  $("#partnerid").append("<option value='"+ data.msg +"' >"+partnername+"</option>");
                  $("#partnerid").val(data.msg);
                  $('#ModalAddPartner').modal('hide');
                  $('body').removeClass('modal-open');
                  $('.modal-backdrop').remove();
                  $("#partnerid").selectpicker("refresh");
                  $('#partnerid').selectpicker('val',data.msg);
                  $("#address").val(partneraddress);

               }
            });
    } 
     function addproduct(productname,productdescription){
           $.ajax({
                type:'POST',
                url:"{{ url('income/product') }}" ,
                data: {'product_name': productname , 'product_description' : productdescription},
                success:function(data) {
                  var a = 0;
                  
                  while(a <= number){
                   $("#product"+a).append("<option value='"+ data.msg +"' >"+productname+"</option>");
                   $('#product'+a).selectpicker('refresh');
                   a++
                  }
                   $('.modal').modal('hide');
                   $('body').removeClass('modal-open');
                   $('.modal-backdrop').remove();
                  
                }
             });
     } 
     function accept(income_id){
      var txt;
      var r = confirm("ยืนยันการสร้างรายการรายรับ");
      if (r == true) {
        txt = "ยืนยัน";
        return true;
      } else {
       txt = "ยกเลิก";
        return false;
      }
      document.getElementById("demo").innerHTML = txt;
    }
  });
    </script>

@endsection

