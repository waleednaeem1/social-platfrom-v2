{{-- <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}"/> --}}
{{-- <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}"/> --}}
{{-- <link rel="shortcut icon" href="{{ asset('images/Vtfreinds-favicon.png') }}"/> --}}
{{-- <link rel="shortcut icon" href="{{ asset('images/Vtfreinds-favicon2-01.png') }}"/> --}}
<link rel="shortcut icon" href="{{ asset('images/icon/logo.png') }}"/>
@if(activeRoute(route('ui.iconfontawsome')) === 'active')
<link rel="stylesheet" href="{{ asset('vendor/@fortawesome/fontawesome-free/css/all.min.css')}}">
@elseif(activeRoute(route('ui.iconlineawsome')) === 'active')
<link rel="stylesheet" href="{{ asset('vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css')}}">
@elseif(activeRoute(route('ui.iconremixon')) === 'active')
<link rel="stylesheet" href="{{ asset('vendor/remixicon/fonts/remixicon.css')}}">
@endif
<link rel='stylesheet' href="{{ asset('vendor/fullcalendar/core/main.css' ) }}"/>
<link rel='stylesheet' href="{{ asset('vendor/fullcalendar/daygrid/main.css') }}"/>
<link rel='stylesheet' href="{{ asset('vendor/fullcalendar/timegrid/main.css') }}" />
<link rel='stylesheet' href="{{ asset('vendor/fullcalendar/list/main.css') }}" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<link rel="stylesheet" href="{{ asset('css/libs.min.css')}}">
<link rel="stylesheet" href="{{ asset('css/all.css?version=0.31')}}">
<link rel="stylesheet" href="{{ asset('css/socialv.css?version=0.89')}}">
<link rel="stylesheet" href="{{ asset('css/customizer.css?version=0.08')}}">
<link rel="stylesheet" href="{{asset('vendor/Leaflet/leaflet.css')}}">
<link rel="stylesheet" href="{{asset('vendor/vanillajs-datepicker/dist/css/datepicker.min.css')}}"/>
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous" /> --}}
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous" />

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

