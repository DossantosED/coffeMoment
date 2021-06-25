<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ __('Coffee Moment') }}</title>
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('/img/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!-- CSS Files -->
  <link href="{{ asset('/css/material-dashboard.css') }}" rel="stylesheet" />
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  </head>
  <body class="{{ $class ?? '' }}">
    @auth()
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
         @csrf
      </form>
      @include('layouts.page_templates.auth')
    @endauth
    @guest()
      @include('layouts.page_templates.guest')
    @endguest

    <!--   Core JS Files   -->
    <script src="{{ asset('/js/core/jquery.min.js') }}"></script>
    <script src="{{ asset('/js/main.js') }}"></script>
    <script src="{{ asset('/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/js/core/bootstrap-material-design.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
    <!-- Plugin for the momentJs  -->
    <script src="{{ asset('/js/plugins/moment.min.js') }}"></script>
    <!--  Plugin for Sweet Alert -->
    <script src="{{ asset('js/plugins/sweetalert2.min.js') }}"></script>
    <!-- Forms Validations Plugin -->
    <script src="{{ asset('/js/plugins/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/jquery.bootstrap-wizard.js') }}"></script>
    <script src="{{ asset('/js/plugins/bootstrap-selectpicker.js') }}"></script>
    <script src="{{ asset('/js/plugins/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('/js/plugins/jasny-bootstrap.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/jquery-jvectormap.js') }}"></script>
    <script src="{{ asset('/js/plugins/nouislider.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/arrive.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/chartist.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/bootstrap-notify.js') }}"></script>
    <script src="{{ asset('/js/material-dashboard.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/settings.js') }}"></script>
    @stack('js')
  </body>
</html>