@foreach($organizations as $organization)
<style>
 .navbar-brand:hover{
   text-decoration: underline;
 }
</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<a class="navbar-brand" href="{{url('organization')}}">{{$organization->organization_name}}</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
        <a href="{{url('organization/menu')}}" class="nav-link">หน้าแรก</a>
        </li>
        @if($userlevel_id == 1 || $userlevel_id == 2 || $userlevel_id == 3)
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
              รายรับ
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              @if($userlevel_id == 1 || $userlevel_id == 2)<a class="dropdown-item" href="{{url("income/list")}}">รายการรายรับ</a>@endif
              @if($userlevel_id == 1 || $userlevel_id == 2)<a class="dropdown-item" href="{{url("income/quotation/list")}}">ใบเสนอราคา</a>@endif
              @if($userlevel_id == 1 || $userlevel_id == 2 || $userlevel_id == 3)<a class="dropdown-item" href="{{url("income/invoice/")}}">ใบวางบิล</a>@endif
              @if($userlevel_id == 1 || $userlevel_id == 3)<a class="dropdown-item" href="{{url("income/receipt/")}}">ใบเสร็จ</a>@endif
          
        </li>
        @endif
        
          @if($userlevel_id == 1 || $userlevel_id == 4 || $userlevel_id == 3)
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
              รายจ่าย
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              @if($userlevel_id == 1 || $userlevel_id == 4)<a class="dropdown-item" href="{{url("expenses/list")}}">รายการรายจ่าย</a>@endif
              @if($userlevel_id == 1 || $userlevel_id == 3)<a class="dropdown-item" href="{{url("expenses/purchaseorder/list")}}">ใบสั่งซื้อ</a>@endif
          </li>
          @endif

          @if($userlevel_id == 1 || $userlevel_id == 3 || $userlevel_id == 5)
          <li class="nav-item dropdown">
       
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                รายงาน
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{url("report/profit")}}">งบกำไรขาดทุน</a>
          </li>
          @endif

          @if($userlevel_id == 1 || $userlevel_id == 4)
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                สินค้า
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{url("product/insert")}}"><i class="fa fa-plus mr-2" aria-hidden="true"></i>เพิ่มสินค้า</a>
                <a class="dropdown-item" href="{{url("product/stock")}}">รายการสินค้า</a>
          </li>
          @endif
         
          @if($userlevel_id == 1 || $userlevel_id == 2 || $userlevel_id == 4)
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                  ผู้ติดต่อ
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="{{url("partner/insert")}}"><i class="fa fa-plus mr-2" aria-hidden="true"></i>เพิ่มผู้ติดต่อ</a>
                  <a class="dropdown-item" href="{{url("partner/list")}}">รายชื่อผู้ติดต่อ</a>
          </li>
          @endif

          @if($userlevel_id == 1 || $userlevel_id == 5)
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" >
                จัดการ
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{url("user/list")}}">จัดการผู้ใช้งาน</a>
                <a class="dropdown-item" href="{{url("organization/settings")}}">จัดการองค์กร</a>
          </li>
          @endif
      </ul>
    </div>
  </nav>
@endforeach