<style>
    body{
        background-image: url({{url("images/wallpaper.jpg")}});
        width: 100%;   
        
    }
</style>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

    <!-- Scripts -->
    <!--<script src="{{ asset('js/app.js') }}" defer></script>!-->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    
    <script src="http://maxkostinevich.github.io/jquery-multifield/jquery.multifield.min.js"></script>
    
    
    
    
   
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">

  
    

</head>

<body class="d-flex flex-column" style="min-height: 100vh">
    <main class="flex-fill">
    <div id="app" >
        <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
            
                <a class="navbar-brand" href="{{ url('/') }}">
                    ระบบบริหารบัญชีงบกำไร - ขาดทุนสำหรับธุรกิจพาณิชยกรรม
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent" >
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">เข้าสู่ระบบ</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">ลงทะเบียน</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ url('user/data') }}" >
                                        ข้อมูลส่วนตัว
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        ออกจากระบบ
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
           
        </nav>

        <main>
            @yield('content')
        </main>

        
    </div>
    </main>
    <footer class="page-footer font-small bg-dark pt-4" style="color: white;">

        <!-- Footer Links -->
        <div class="container-fluid text-center text-md-left">
      
          <!-- Grid row -->
          <div class="row">
      
            <!-- Grid column -->
            <div class="col-md-6 mt-md-0 mt-3">
      
              <!-- Content -->
              <h5 class="text-uppercase">ระบบบริหารบัญชีงบกำไร - ขาดทุนสำหรับธุรกิจพาณิชยกรรม</h5>
              <p>เว็ปไซต์นี้เป็นส่วนหนึ่งของวิชา Project มหาวิทยาลัยเทคโนโลยีราชมงคลตะวันออกวิทยาเขตจักรพงษภูวนารถ</p>
      
            </div>
            <!-- Grid column -->
      
            <hr class="clearfix w-100 d-md-none pb-3">
      
            <!-- Grid column -->
            <div class="col-md-3 mb-md-0 mb-3">
      
              <!-- Links -->
              <h5>อาจารย์ที่ปรึกษา</h5>
              <ul class="list-unstyled">
                  <li><a href="https://chumpolm.wordpress.com/04-06-325-%E0%B8%A7%E0%B8%B4%E0%B8%A8%E0%B8%A7%E0%B8%81%E0%B8%A3%E0%B8%A3%E0%B8%A1%E0%B8%8B%E0%B8%AD%E0%B8%9F%E0%B8%95%E0%B9%8C%E0%B9%81%E0%B8%A7%E0%B8%A3%E0%B9%8C-software-engineering/about/" style="color: white">อ.ชุมพล โมฆรัตน์ </a></li>
              </ul>
      
            </div>
            <!-- Grid column -->
      
            <!-- Grid column -->
            <div class="col-md-3 mb-md-0 mb-3">
                <h5>จัดทำโดย</h5>
                <ul class="list-unstyled">
                    <li><a href="https://www.facebook.com/Flogzpipa" style="color: white">นายพรศักดิ์ ซื่อตรงจิตติ</a></li>
                    <li><a href="https://www.facebook.com/natawe.sangthong" style="color: white">นายนรรฆวี แสงทอง</a></li>
                </ul>
      
            </div>
            <!-- Grid column -->
      
          </div>
          <!-- Grid row -->
      
        </div>
        <!-- Footer Links -->
      
        <!-- Copyright -->
        <div class="footer-copyright text-center py-3">© 2020 Copyright:
          <a href="https://mdbootstrap.com/"> MDBootstrap.com</a>
        </div>
        <!-- Copyright -->
      
      </footer>
</body>
</html>