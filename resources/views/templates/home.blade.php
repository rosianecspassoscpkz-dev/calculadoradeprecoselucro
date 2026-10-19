<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') </title>
    @vite(['resources/css/app.scss', 'resources/js/style.js'])
  </head>
  <body>
    <div class="container-fluid">
      <div class = "container mt-4"> 
    @include('layouts.header')
</div> 
<div class="container-fluid">
@yield('content')
</div>
</div> 
<div class="container mt-5">
    @include('layouts.footer')
</div>
  </body>
</html>