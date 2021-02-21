@extends('layouts.app')
@extends('layouts.checkauth')
@section('content')
@include('layouts.navmenu')


    <div class="container mt-5 shadow p-3 mb-5 bg-white rounded">
        <div class="jumbotron text-center bg-dark text-white">
            <h1>เพิ่มผู้ติดต่อ</h1>
            
        </div>
        
        <div class="my-2">
            <a href = "{{url()->previous()}}" class="my-2 ml-5 btn btn-secondary"> <i class="fa fa-arrow-left mx-2"></i> ย้อนกลับ</a> 
        </div>

        <form method="POST" action="{{url('partner/insert')}}" class="mx-5"  id="accept">
        @csrf
        
        <input type="hidden" name="partner_id">
        <label>ชื่อ-นามสกุล</label>
        <input type="text" name="partner_name" class="form-control my-2 col-5"> 
        <label>ที่อยู่</label>
        <textarea name="partner_address" class="form-control my-2 col-5" rows="5"></textarea> 
        <label>เบอร์โทร</label>
        <input type="text" name="partner_tel" class="form-control my-2 col-5"> 
        <label>อีเมล</label>
        <input type="text" name="partner_email" class="form-control my-2 col-5"> 
        <input type="submit"  value="ยืนยัน" class="btn btn-primary my-3" ><a href = "{{url()->previous()}}" class="my-2 ml-2 btn btn-secondary">ยกเลิก</a>
        </form>

    </div>
    <script>
      $(document).ready(function(){
        $("#accept").submit(function(){
        return accept();
      }); 
      function accept(){
      var txt;
      var r = confirm("ยืนยันการเพิ่มผู้ติดต่อ");
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
