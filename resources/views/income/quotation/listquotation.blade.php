@extends('layouts.app')
@extends('layouts.checkauth')
@section('content')
@include('layouts.navmenu')

<script>
  function alertshow(){
    alert("ไม่สามารถแก้ไขได้เนื่องจากอนุมัติไปแล้ว");
  }
</script>
    <div class="container mt-5 shadow p-3 mb-5 bg-white rounded">
    
        <div class="jumbotron text-center bg-dark text-white">
            <h1>ใบเสนอราคา</h1>
        </div>

        
                @foreach ($readytoquotation as $amount)
                    @if($amount->readytoquotation > 0)
                    <div class="alert alert-primary" role="alert">
                    <p>มีเอกสารที่ยังไม่ได้ออกใบเสนอราคาทั้งหมด {{$amount->readytoquotation}} รายการ</p>
                    </div> 
                    @endif
                @endforeach

        
        <div class="my-2">
          <a href = "{{url('income')}}" class="mr-2 btn btn-secondary"> <i class="fa fa-arrow-left mx-2"></i> ย้อนกลับ</a>
            <a href="{{url('income/quotation/create')}}" style="color: white" class="btn btn-primary mr-2">+ สร้างใบเสนอราคา  
              @foreach ($readytoquotation as $amount)
                @if($amount->readytoquotation > 0)
                  <span class="badge badge-danger"> {{$amount->readytoquotation}} </span>
                @endif
              @endforeach
            </a> 
            <a href="{{url('income/quotation/accept')}}" class="btn btn-success mr-2">+ อนุมัติใบเสนอราคา 
              @foreach ($readytoaccept as $amountaccept)
              @if($amountaccept->readytoaccept > 0)
              <span class="badge badge-danger"> {{$amountaccept->readytoaccept}} </span>
              @endif
              @endforeach  
            </a>
        </div>

        <div class="my-2">
            <table id="example" class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th scope="col">วันที่สร้าง</th>
                    <th scope="col">รหัสใบเสนอราคา</th>
                    <th scope="col">ชื่อลูกค้า</th>
                    <th scope="col">ยอดสุทธิ</th>
                    <th scope="col">สถานะ</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                    
                    @foreach($quotations as $quotation)
                    <tr>
                    <th scope="row">{{$quotation->created_at}}</th>
                    <td>{{$quotation->qt_id}}</td>
                    <td>{{$quotation->partner_name}}</td>
                    <td>{{number_format($quotation->sum,2)}}</td>
                    @if ($quotation->status_id == 1)
                        <td><span class="badge badge-danger py-2" style="padding: 5px;font-size: 12px;width: 100%">ยังไม่ได้อนุมัติ</span></td>
                    @endif
                    @if ($quotation->status_id >= 2)
                        <td><span class="badge badge-success py-2"  style="padding: 5px;font-size: 12px;width: 100%">อนุมัติแล้ว</span></td>
                    @endif
                    <td><button class="btn btn-secondary mr-2 @if($quotation->status_id >= 2)disabled @endif" @if($quotation->status_id == 1)onclick="location.href='{{url('income/update/'.$quotation->income_id.'')}}'"@endif @if($quotation->status_id >= 2) onclick="alertshow()" @endif @if($quotation->status_id >= 2) aria-disabled="true" tabindex="-1" @endif>แก้ไขรายการ</button><button class="btn btn-primary mr-2" onclick="location.href='{{url('income/quotation/show/'.$quotation->quotation_id.'')}}'">ดูใบเสนอราคา</button></td>
                    </tr>
                    @endforeach 
                   
                  
                 
                </tbody>
              </table>
        </div>

        

        
    </div>

        <!-- Modal_Add_quotation -->
        <div class="modal fade bd-example-modal-lg" id="ModalMakeQuotation" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">รายการรายรับ</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">ID</th>
                            <th scope="col">วันที่สร้าง</th>
                            <th scope="col">ชื่อลูกค้า</th>
                            <th scope="col">ยอดสุทธิ</th>
                            <th scope="col"></th>
                          </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($incomes as $income)
                            
                            <tr>
                            <th scope="row">{{$income->income_id}}</th>
                            <td>{{$income->created_at}}</td>
                            <td>{{$income->partner_name}}</td>
                            <td>{{number_format($income->sum,2)}}</td>
                            <td><a href="{{url('income/quotation/'.$income->income_id)}}" class="btn btn-secondary mr-2">สร้างใบเสนอราคา</a></td>
                            </tr>
                            
                            @endforeach 
                           
                        </tbody>
                      </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                </form>
                </div>
              </div>
            </div>
          </div>
          <!-- End_Modal_Add_product -->

          <script>
            $(document).ready(function() {
              $('#example').DataTable({
                "ordering": false 
              });
            } );
            </script>

@endsection
