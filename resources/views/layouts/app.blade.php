<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
   <title>{{ $title ?? 'App' }}</title>
   <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico') }}">
   <!-- CSS -->
   <link href="{{ asset('assets/css/line-awesome.css') }}" rel="stylesheet" type="text/css">
   <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">
   <link href="{{ asset('assets/css/dashboard-style.css') }}" rel="stylesheet" type="text/css">
   <!-- /CSS -->
   @livewireStyles
</head>

<body id="top" class="section-body on-padding">

  
   @extends('layouts.sidebar')

   <div class="logo-mobile"><img src="{{ asset('assets/img/logo.svg') }}" alt=""></div>

   @extends('layouts.header')

   {{ $slot }}
   
   @include('layouts.toaster')
   @livewireScripts
   
   <script src="{{ asset('assets/js/custom-new.js') }}"></script>
  
  
  </body>

  </html>
