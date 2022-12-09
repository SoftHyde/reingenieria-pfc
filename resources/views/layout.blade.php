<!DOCTYPE html>
<html lang="es">
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Participación ciudadana</title>
    <meta name="title" content="Participación ciudadana">

    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="Participación ciudadana">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Participación ciudadana">

    <!-- Open Graph data -->

    <meta property="og:title" content="Participación ciudadana" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="{{Request::url()}}" />
    <meta property="og:site_name" content="PFC.local" />
    
    @yield('meta')
    
    <link rel="stylesheet" href="/home/chueko/Desktop/reingenieria-pfc/public/css/app.css">
    <!-- favIcon -->
    <link rel="icon" href="/images/PC.png">
    <!-- bootstrap -->
    <link rel="stylesheet" type="text/css" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- summernote -->
    {{-- <link rel="stylesheet" type="text/css" href="/bower_components/summernote/dist/summernote.css"> --}}
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

    <!-- Social Share Kit CSS -->
    <link rel="stylesheet" href="/bower_components/social-share-kit/dist/css/social-share-kit.css" type="text/css">
    <!-- Bootstrap social -->
    <link rel="stylesheet" href="/bower_components/bootstrap-social/bootstrap-social.css" type="text/css">
    <!-- Font awesome -->
    <link rel="stylesheet" href="/bower_components/font-awesome/css/font-awesome.css" type="text/css">
    <!-- css local -->
    <link rel="stylesheet" type="text/css" href="/css/app.css?v=<?=time();?>"/> 

    

    @yield('styles')

  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container col-md-10 col-md-offset-1">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">@lang('layout.home')</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          
          <ul class="nav navbar-nav">
            @if (Auth::check() and Auth::user()->role == 'admin')
              <li><a href="{{ route('settings') }}">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                Administración
              </a></li>
            @endif
          </ul>

          @if (Auth::guest())
            <div class="navbar-right">
              <ul class="nav navbar-nav">
                <li>
                  <a class="" href="{{ route('login') }}">
                    <span class="glyphicon glyphicon-log-in"></span> @lang('auth.login')
                  </a>
                </li>
                <li>
                  <a class="" href="{{ route('register') }}">
                    <span class="glyphicon glyphicon-user"></span> @lang('auth.register')
                  </a>
                </li>
              </ul>
            </div>
          @else
            <ul class="nav navbar-nav navbar-right">
              <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown">
                  Notification <span class="caret"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                  @forelse (Auth::user()->notifications as $notification)
                  @if($notification->data['type']=="commentProject")
                    <a href="{{ route('project', ['id' => $notification->data['project_id']]) }}" class="dropdown-item">El usuario {{$notification->data['name']}} ha comentado el proyecto {{$notification->data['project']}} </a>
                    <br> 
                  @else
                  @if($notification->data['type']=="commentArticle")
                  <a href="{{ route('article', [$notification->data['article_id'],$notification->data['numero']]) }}" class="dropdown-item">El usuario {{$notification->data['name']}} ha comentado en su articulo </a>
                  <br>   
                  @endif 
                  @if($notification->data['type']=="supportArticle")
                  <a href="{{ route('article', [$notification->data['article_id'],$notification->data['numero']]) }}" class="dropdown-item">El usuario {{$notification->data['name']}} Ha apoyado su articulo </a>
                  <br>   
                  @endif   
                  @endif
                  @empty
                  <a class="dropdown-item">No record found</a>     
                  @endforelse
                </div>
                
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"  aria-expanded="false" style="position: relative; padding-left: 50px">
                  <img class="navbar-avatar" src="{{Auth::user()->avatar}}">
                  {{ Auth::user()->name }} <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li>
                    <a href="{{route('user', Auth::user()->id)}}">
                      <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Perfil
                    </a>
                  </li>
                  <li role="separator" class="divider"></li>
                  <li>
                    <a href="{{ route('logout') }}">
                      <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> @lang('auth.logout')
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          @endif
        </div><!--/.navbar-collapse -->
      </div>
    </nav>

    @yield('content')

    <footer class="footer" style="background-color: #f0f0f0;">
      &copy; 2022 Lucas Rios | Eric Priemer
    </footer>

  </body>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="/bootstrap/js/bootstrap.js"></script>
    <script src="/bootstrap/js/bootstrap-confirmation.min.js"></script>
    
    <script src="/js/activate_confirmation.js"></script>

    
    <!-- include summernote js-->
    {{-- <script src="/bower_components/summernote/dist/summernote.min.js"></script> --}}
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote.js" defer></script>

    <!-- Social Share Kit JS -->
    <script type="text/javascript" src="/bower_components/social-share-kit/dist/js/social-share-kit.js"></script>
    
    <script type="text/javascript">
        $(document).ready(function() {
            
            // $('#summernote').summernote({
            //   height:200,
            // });
            $('#summernote').summernote();


            SocialShareKit.init();
        });
    </script>
    

    @yield('scripts')

</html>