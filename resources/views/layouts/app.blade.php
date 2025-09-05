<!DOCTYPE html>
<html lang="en">
   <head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <title>{{ $title ?? 'App' }}</title>
   <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}">

   {{-- Your CSS assets --}}
   <link href="{{ asset('assets/css/line-awesome.css') }}" rel="stylesheet" type="text/css">
   <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">
   <link href="{{ asset('assets/css/dashboard-style.css') }}" rel="stylesheet" type="text/css">

   @livewireStyles
   </head>
   <body id="top" class="section-body on-padding">
      
   @include('layouts.sidebar')
   <div class="logo-mobile"><img src="{{ asset('assets/img/logo.svg') }}" alt=""></div>
   @include('layouts.header')
   {{ $slot ?? '' }}
   @yield('content')

   @include('layouts.toaster')

   @livewireScripts

   {{-- Your JS assets --}}
   <script src="{{ asset('assets/js/custom-new.js') }}"></script>
   </body>
</html>
