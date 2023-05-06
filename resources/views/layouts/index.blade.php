
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>@yield('title',$title?? env('APP_NAME','TOKOKU'))</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <link href="{{ asset('') }}assets/img/favicon.png" rel="icon">
  <link href="{{ asset('') }}assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <link href="{{ asset('') }}assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('') }}assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="{{ asset('') }}assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="{{ asset('') }}assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="{{ asset('') }}assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="{{ asset('') }}assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="{{ asset('') }}assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <link href="{{ asset('') }}assets/css/style.css" rel="stylesheet">

  @stack('style')

  <script>
    window.ENV = {
        URL: "{{ env('APP_URL') }}",
        API_URL: "{{ env('API_URL') }}"
    }
  </script>

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="" class="logo d-flex align-items-center">
        <span class="d-none d-lg-block">{{ env('APP_NAME') }}</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    @include('layouts.navbar')

  </header><!-- End Header -->

  @include('layouts.sidebar')

  <main id="main" class="main">

    @yield('content')

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>2023</span></strong>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/jquery/jquery-3.6.1.min.js') }}"></script>
  <script src="{{ asset('') }}assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="{{ asset('') }}assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('') }}assets/vendor/chart.js/chart.min.js"></script>
  <script src="{{ asset('') }}assets/vendor/echarts/echarts.min.js"></script>
  <script src="{{ asset('') }}assets/vendor/quill/quill.min.js"></script>
  <script src="{{ asset('') }}assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="{{ asset('') }}assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="{{ asset('') }}assets/vendor/php-email-form/validate.js"></script>
  <script src="{{ asset('') }}assets/js/main.js"></script>
  <script src="{{ asset('assets/js/func.js') }}"></script>

  @stack('script')

</body>

</html>