@extends('layouts.app')
@extends('layouts.checkauth')
@section('content')
@include('layouts.navmenu')


    <div class="container mt-5 shadow p-3 mb-5 bg-white rounded">
        <div class="jumbotron text-center bg-dark text-white">
            <h1>งบกำไร - ขาดทุน</h1>
            
        </div>
        
        <div class="my-2">
          <a href = "{{url('organization/menu')}}" class="my-2 btn btn-secondary"> <i class="fa fa-arrow-left mx-2"></i> ย้อนกลับ</a>
        </div>
        <ul class="nav nav-tabs">
            <li class="nav-item">
              <a class="nav-link" href="{{url('report/profit/')}}">ทั้งหมด</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('report/profit/1month')}}">เดือนที่ผ่านมา</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="{{url('report/profit/3month')}}">ไตรมาส</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('report/profit/custom')}}">กำหนดเอง</a>
            </li>
          </ul>
        <div class="mx-5 mt-5">
      
       
        <div class="mx-5 my-3 card">
          <div class="card-header">
              <h5>กำหนดไตรมาส</h2>
          </div>
          <div class="card-body">
          <form method="POST" action="{{url('report/profit/quarter')}}" class="mx-5">
              @csrf
            <div class="row">
              <div class="col">
              <label>ไตรมาส </label>
         
              <input class="ml-2" type="radio" value="1" name="quarter"><label class="ml-2">1</label>
              <input class="ml-2" type="radio" value="2" name="quarter"><label class="ml-2">2</label>
              <input class="ml-2" type="radio" value="3" name="quarter"><label class="ml-2">3</label>
              <input class="ml-2" type="radio" value="4" name="quarter"><label class="ml-2">4</label>
              </div>
              <div class="col">
              <div class="form-group row">
              <label class="ml-2 col-form-label">ปี</label>
              <div class="col">
              <input class="ml-2 form-control" type="number" name="year">
              </div>
              </div>
              </div>
            </div>
          </div>
          <div class="card-footer">
              <input type="submit" name="submit" style="float: right" value="ยืนยัน" class="btn btn-primary">
          </div>
      </form>
      </div>
        </div>
        
        

    </div>

     
    <script>
        $(document).ready(function(){
          $('#example').DataTable();
          
        });
     
    </script>
@endsection
