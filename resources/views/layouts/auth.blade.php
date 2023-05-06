
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

</head>

<body>

  <main>
    <div class="container">

      @yield('content')

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('') }}assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="{{ asset('') }}assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('assets/js/func.js') }}"></script>

  @stack('script')

</body>

</html>