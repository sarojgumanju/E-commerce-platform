<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Saroj Hub • Vendor Registration</title>
  <!-- Vite assets (Tailwind + JS) -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- Font Awesome 7 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  {{-- <link rel="stylesheet" href="/frontend/style.css"> --}}
  <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
  
  
</head>
<body>
  @include('sweetalert::alert')

  <!-- ========== HEADER SECTION ========== -->
  <x-frontend-header/>

  <!-- ========== MAIN SECTION ========== -->
  {{ $slot }}

  <!-- ========== FOOTER SECTION ========== -->
  <x-frontend-footer/>

  
</body>
</html>