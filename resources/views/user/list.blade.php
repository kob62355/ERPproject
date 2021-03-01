@extends('layouts.app')
@extends('layouts.checkauth')
@section('content')
@include('layouts.navmenu')


    <div class="container mt-5 shadow p-3 mb-5 bg-white rounded">
    
        <div class="jumbotron text-center bg-dark text-white">
            <h1>รายชื่อผู้ใช้งาน</h1>
        </div>
        
        <div class="my-2">
            <a href = "{{url('settings/')}}" class="my-2 mr-2 btn btn-secondary"> <i class="fa fa-arrow-left mx-2"></i> ย้อนกลับ</a>
            <a href="{{url('user/insert')}}" style="color: white" class="btn btn-primary mr-2">+ เพิ่มผู้ใช้งาน</a> 
            
        </div>

        <div class="my-2">
            <table id="example" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    
                    <th scope="col-auto">ชื่อ - นามสกุล</th>
                    <th scope="col-auto">อีเมล</th>
                    <th scope="col-auto">เบอร์โทร</th>
                    <th scope="col-auto">ตำแหน่ง</th>
                  
                  </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->tel}}</td>
                    <td><div class="row"><div class="col">{{$user->level_name}} </div>
                      <div class="col">
                        @if($user->userlevel_id != 1)
                        <button type="button" class="btn btn-secondary ml-4" onclick="edit({{$user->user_id}},{{$user->level_id}})" data-toggle="modal" data-target="#ModalEdit"><i class="fa fa-edit mr-2" aria-hidden="true"></i>แก้ไข</button>
                        <button type="button" class="btn btn-danger ml-2" onclick="location.href='{{url('user/delete/'.$user->user_id.'')}}'" >
                        <i class="fa fa-trash mr-2" aria-hidden="true"></i>ลบ</button>
                        @endif
                    </div>
                  </td>
                    
                    </tr>
                    @endforeach 
                </tbody>
              </table>
        </div>
    </div>
<!-- Modal -->
<div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <form action="{{url("user/editrole")}}" method="POST" onsubmit="return accept()">
    @csrf
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขตำแหน่ง</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <input type="hidden" value="" name="user_id" id="user_id">
       <select name="level_id" id="level_id" class="form-control">
          @foreach ($levels as $level)
           <option value="{{$level->id}}">{{$level->level_name}}</option>
          @endforeach
       </select>
      </div>
      <div class="modal-footer" id="modalfooter">
        
      </div>
    </div>
  </div>
</form>
</div>

  
    <script>
        $(document).ready(function() {
          $('#example').DataTable({
                "ordering": false 
              });
        
        });
        function edit(user_id,level_id){
          $('#user_id').val(user_id);
          $('#level_id').val(level_id);
          $('#modalfooter').empty();
          $("#modalfooter").append("<input class=\"btn btn-primary\" type=\"submit\" name=\"submit\"  value=\"ยืนยัน\" ><button type=\"button\" class=\"btn btn-secondary cancel\" data-dismiss=\"modal\">ยกเลิก</button>");
        }
    </script>
@endsection
