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

{{-- <div class="card-deck" style="padding-left:30%;"> --}}
  <div class="card-group">
    <div class="col-md-6" style="padding: 0px">
      <div class="col-md-8 col-md-offset-2">
        <div class="card-block jumbotron toolSelection">
          <div class="container">
            <h3 style="color: black; text-align:center;">Co-Construccion de leyes</h3>
            <p style="color: black; ">El Portal de Leyes Abiertas es una plataforma de elaboración colaborativa
              de normas donde los diputados ponen a disposición de la ciudadanía sus propuestas y proyectos de ley 
              para incorporar nuevos puntos de vista a sus iniciativas. El objetivo de la plataforma es enriquecer
              las propuestas de ley y generar un nuevo espacio de comunicación con los ciudadanos, que permita 
              enriquecer el debate parlamentario.</p>
            <p><a class="btn btn-primary btn-lg" href="{{ route('projects') }}" role="button">Entrar</a></p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6" style="padding: 0px">
      <div class="col-md-8 col-md-offset-2">
        <div class="card-block jumbotron toolSelection">
          <div class="container">
            <h3 style="color: black; text-align:center;">Acciones Participativas</h3>
            <p style="color: black;">El Portal de Acciones Participativas es una plataforma de elaboración colaborativa
              de propuestas donde los ciudadanos ponen a disposición de la ciudadanía sus propuestas y proyectos 
              para incorporar nuevos puntos de vista a sus iniciativas. El objetivo de la plataforma es enriquecer
              las propuestas de participacion ciudadana y generar un nuevo espacio de comunicación con los ciudadanos, que permita 
              enriquecer el debate de las necesidades de los ciudadanos.</p>
              <a class="btn btn-primary btn-lg" href="{{ route('actions') }}" role="button">Entrar</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
          
          {{-- <div class="card">
            <a href="{{ route('projects') }}">
                <div class="card-block" style="background-image: url('images/leyes-.jpg'); height: 400px; background-position: center;">
                  
                  <br>
                  <p style="color: black; ">El Portal de Leyes Abiertas es una plataforma de elaboración colaborativa
                  de normas donde los diputados ponen a disposición de la ciudadanía sus propuestas y proyectos de ley 
                  para incorporar nuevos puntos de vista a sus iniciativas. El objetivo de la plataforma es enriquecer
                  las propuestas de ley y generar un nuevo espacio de comunicación con los ciudadanos, que permita 
                  enriquecer el debate parlamentario.</p>
                </div>
            </a>    
          </div> --}}
          {{-- <div class="card">
            <a href="{{ route('actions') }}">
                <div class="card-block" style="background-image: url('images/hands.jpg');height: 400px; background-position: center;">
                  <h3 class="card-title" style="color: black;text-align:center;">Acciones Participativas</h3>
                  <br>
                  <p style="color: black;">El Portal de Acciones Participativas es una plataforma de elaboración colaborativa
                    de propuestas donde los ciudadanos ponen a disposición de la ciudadanía sus propuestas y proyectos 
                    para incorporar nuevos puntos de vista a sus iniciativas. El objetivo de la plataforma es enriquecer
                    las propuestas de participacion ciudadana y generar un nuevo espacio de comunicación con los ciudadanos, que permita 
                    enriquecer el debate de las necesidades de los ciudadanos.</p>
                </div>
              </a>    
          </div> --}}
{{-- </div> --}}



@endsection