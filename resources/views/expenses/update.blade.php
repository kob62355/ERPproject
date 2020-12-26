@extends('layouts.app')
@extends('layouts.checkauth')
@section('content')
@include('layouts.navmenu')

<<script>
  var number = 0;
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
  });
  $("#productamount1,#productprice1").change(function(){
    var productamount = $("#productamount1").val();
    var productprice = $("#productprice1").val();
    var total = parseFloat(productamount) * parseFloat(productprice);
    $("#sum1").text(numberWithCommas(total));
  });
  $("#add").click(function(e){
        e.preventDefault();
        number++;
        var newIn = "<tr id=\"myTableRow"+number+"\"><td style=\"width: 40%\"><div class=\"row\"><div class=\"col-8\" ><select name=\"product_id[]\" class=\"form-control product-select selectpicker\" data-live-search=\"true\" title=\"กรุณาเลือกสินค้า\" id=\"product"+number+"\" data-size=\"5\"><option value=\"\" disabled selected hidden>กรุณาเลือกสินค้า</option> @foreach($products as $product)<option value=\"{{$product->product_id}}\">{{$product->product_name}}</option>@endforeach </select></div><div class=\"col-4\"><a href=\"\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\"#ModalAddProduct\">+ เพิ่มสินค้า</a> </div></div></td><td><input type=\"number\" name=\"product_amount[]\" class=\"form-control productamount"+number+"\" id=\"productamount"+number+"\"></td><td><input type=\"number\" name=\"product_price[]\"  class=\"form-control productprice"+number+"\" id=\"productprice"+number+"\"></td><td><a clas =\"sum"+number+"\" id=\"sum"+number+"\" class=\"mt-2\"></a><button type=\"button\" class=\"btn btn-danger btn-remove ml-4\" id=\"buttondel"+number+"\"><i class=\"fa fa-trash mx-2\"></i></button></td></tr>";
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
});

function docWrite(variable) {
    document.write(variable);
  }
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
              alert("Add partner is succes.");
              $("#partnerid").append("<option selected value='"+ data.msg +"'>"+partnername+"</option>");
              $('.modal').modal('hide');
              $('body').removeClass('modal-open');
              $('.modal-backdrop').remove();
              $('#partnerid').selectpicker('refresh');
           }
        });
} 
function addproduct(productname,productdescription){
      $.ajax({
           type:'POST',
           url:"{{ url('income/product') }}" ,
           data: {'product_name': productname , 'product_description' : productdescription},
           success:function(data) {
              alert("Add product is succes.");
              $(".product").append("<option value='"+ data.msg +"'>"+productname+"</option>");
              $('.modal').modal('hide');
              $('body').removeClass('modal-open');
              $('.modal-backdrop').remove();
              $('.product').selectpicker('refresh');
           }
        });
} 
</script>

    <div class="container mt-5 shadow p-3 mb-5 bg-white rounded">
        <div class="jumbotron text-center bg-dark text-white">
            <h1>แก้ไขรายการรายจ่าย</h1>
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
      <form class="mx-5 my-5" method="POST" action="{{url('expenses/update')}}">
        @csrf
        
          <div class="row my-2">
              <div class="col"><h5>ชื่อผู้ติดต่อ</h5></div><div class="col"></div>
          </div>
          <div class="row my-2">
              <div class="col-5">
                <select name="partner_id" class="form-control" id="partnerid">
                  <option value="0">-- รายชื่อผู้ติดต่อ --</option>
                  @foreach($partners as $partner)
                    @foreach ($expenses_partner as $expenses_partnerdetail)
                        @if ($partner->partner_id == $expenses_partnerdetail->partner_id)
                            <option value="{{$partner->partner_id}}" selected>{{$partner->partner_name}}</option>
                        @else
                            <option value="{{$partner->partner_id}}">{{$partner->partner_name}}</option>
                        @endif
                    @endforeach
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
            @foreach ($expenses_partner as $detail)
          <div class="col"><textarea class="form-control" id="address" rows="8" name="partner_address">{{$detail->address}}</textarea></div><div class="col"></div>
          <input type="hidden" name="expenses_id" value="{{$detail->expenses_id}}">
          <input type="hidden" name="created_at" value="{{$detail->created_at}}">
          <input type="hidden" name="status_id" value="{{$detail->status_id}}">
            @endforeach
          </div>
          
          <div class="row my-2">
            <table class="table">
              <thead>
                <tr>
                  
                  <th scope="col">รายการ</th>
                  <th scope="col">จำนวน</th>
                  <th scope="col">ราคา/หน่วย</th>
                  <th scope="col">ราคารวม</th>
                </tr>
              </thead>
              <tbody>
                <?php $number = 0;?>
                @foreach ($expensess as $expenses)
                <?php $number++ ?>
                  <tr id="myTableRow{{$number}}">
                  
                  <script>number++</script>
                  
                  
                  <td style="width: 40%">
                    <div class="row">
                      <div class="col-8" >
                     
                      <select name="product_id[]" class="form-control product-select selectpicker" data-live-search="true" title="กรุณาเลือกสินค้า" id="product1" data-size="5">
                      
                      @foreach($products as $product)
                        @if($product->product_id == $expenses->product_id)
                          <option value="{{$product->product_id}}" selected>{{$product->product_name}}</option>
                          
                        @else
                          <option value="{{$product->product_id}}">{{$product->product_name}}</option>
                        @endif
                      @endforeach 
                      </select>
                      @foreach($products as $product)
                      @if($product->product_id == $expenses->product_id)
                        <input value="{{$product->product_id}}" type="hidden" name="oldproduct_id[]">
                      @endif
                      @endforeach 

                      </div>
                      <div class="col-4">
                      <a href="" class="btn btn-primary" data-toggle="modal" data-target="#ModalAddProduct">+ เพิ่มสินค้า</a> 
                      </div>
                    </div>
                  </td>
                <td style="width: 15%"><input type="number" name="product_amount[]" class="form-control" id="productamount{{$number}}" value="{{$expenses->amount}}"></td>
                <td style="width: 15%"><input type="number" name="product_price[]"  class="form-control" id="productprice{{$number}}" value="{{$expenses->saleprice}}"></td>
                <td style="width: 20%"><a id="sum{{$number}}">{{number_format($expenses->amount * $expenses->saleprice,2)}}</a><button type="button" class="btn btn-danger btn-remove ml-4" id="buttondel{{$number}}"><i class="fa fa-trash mx-2"></i></button></td>
                </tr>
                
                @endforeach
              </tbody>
             
            </table>
            <button id="add" type="button" class="btn btn-dark btn-lg btn-block">เพิ่มรายการ</button>
            </div>
            <div class="d-flex justify-content-end">
              <input type="submit" name="submit" class="my-2 btn btn-success" value="ยืนยัน">
              <a href = "{{url('expenses/list')}}" class="my-2 btn btn-danger ml-3">ยกเลิก</a>
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
            <form action="{{ url('expenses/partner') }}" method="POST">
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
              <form action="{{ url('expenses/product') }}" method="POST">
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
  
   var x = 0;
      while(x < number){
      x++;
      console.log(x);
      var total = 0;
      $("#productamount"+x+",#productprice"+x).change(function(e){
        e.preventDefault();
        var fieldNum = this.id.charAt(this.id.length-1);
        var productamount = $("#productamount"+fieldNum).val();
        var productprice = $("#productprice"+fieldNum).val();
        total = parseFloat(productamount) * parseFloat(productprice);
        $("#sum"+fieldNum).text(numberWithCommas(total));
            
       });
      }
    $(".btn-remove").click(function(e){
    e.preventDefault();
    var fieldNum = this.id.charAt(this.id.length-1);
    $("#myTableRow"+fieldNum).hide();
    $("#productamount"+fieldNum).val(0);
    });
  </script>
   

@endsection
