@extends('layout')

@section('meta')

<!-- Description -->
<meta name="description" content="Bienvenidos a la plataforma web de participación ciudadana de la Ciudad de Santa Fe" />

<!-- Schema.org markup for Google+ -->
<meta itemprop="description" content="Bienvenidos a la plataforma web de participación ciudadana de la Ciudad de Santa Fe">
<meta itemprop="image" content="http://pfc.local/images/action.jpg">

<!-- Twitter Card data -->
<meta name="twitter:description" content="Bienvenidos a la plataforma web de participación ciudadana de la Ciudad de Santa Fe">
<!-- Twitter summary card with large image must be at least 280x150px -->
<meta name="twitter:image:src" content="http://pfc.local//images/action.jpg">

<!-- Open Graph data -->
<meta property="og:image" content="http://pfc.local//images/action.jpg" />
<meta property="og:description" content="Bienvenidos a la plataforma web de participación ciudadana de la Ciudad de Santa Fe" />

@endsection

@section('content')

<div class="ssk-sticky ssk-left ssk-center ssk-lg">
    <a href="" class="ssk ssk-facebook"></a>
    <a href="" class="ssk ssk-twitter"></a>
    <a href="" class="ssk ssk-google-plus"></a>
    <a href="" class="ssk ssk-pinterest"></a>
    <a href="" class="ssk ssk-tumblr"></a>
</div>

<div class="jumbotron">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-10 col-md-offset-1" align="center">
          <h1 class="home-title">Participación ciudadana</h1>
          <p>Bienvenidos a la plataforma web de participación ciudadana de la Ciudad de Santa Fe</p>
          
      </div>
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
        @include('partials/actions_list')
    </div>
  </div>
</div>



@endsection