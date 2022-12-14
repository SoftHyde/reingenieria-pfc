<!DOCTYPE html>
<html lang="es">
  <head>

    
    <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-252055928-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-252055928-1');
  </script>


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
              <li class="dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown">
                  Notificaciones <span class="caret"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" style="width: 20vw; height:auto; max-height: 300px; overflow-x:hidden">
                  <div class="col-md-12">
                    <hr style="margin-top: 5px; margin-bottom:5px">
                    @forelse (Auth::user()->notifications as $notification)
                      @switch($notification->data['type'])
                        @case("commentProject")
                          <a href="{{ route('project', ['id' => $notification->data['project_id']]) }}" class="dropdown-item">El usuario {{$notification->data['name']}} ha comentado el proyecto {{$notification->data['project']}} </a>
                          <hr style="margin-top: 5px; margin-bottom:5px">
                        @break
                        @case("commentArticle") 
                          <a href="{{ route('article', [$notification->data['article_id'],$notification->data['numero']]) }}" class="dropdown-item">El usuario {{$notification->data['name']}} ha comentado en su articulo </a>
                          <hr style="margin-top: 5px; margin-bottom:5px">
                        @break
                        @case("supportArticle")  
                          <a href="{{ route('article', [$notification->data['article_id'],$notification->data['numero']]) }}" class="dropdown-item">El usuario {{$notification->data['name']}} Ha apoyado su articulo </a>
                          <hr style="margin-top: 5px; margin-bottom:5px">
                        @break
                        @case("supportCommentArticle")
                        <a href="{{ route('article', [$notification->data['article_id'],$notification->data['numero']]) }}" class="dropdown-item">El usuario {{$notification->data['name']}} Ha apoyado su comentario </a>
                        <hr style="margin-top: 5px; margin-bottom:5px">
                        @break
                        @case("supportCommentProject")
                        <a href="{{ route('project', ['id' => $notification->data['project_id']]) }}" class="dropdown-item">El usuario {{$notification->data['name']}} ha apoyado su comentario en el proyecto {{$notification->data['project']}} </a>
                        <hr style="margin-top: 5px; margin-bottom:5px">
                        @break
                        @case("newModeratorProject")
                        <a href="{{ route('project', ['id' => $notification->data['project_id']]) }}" class="dropdown-item">Has sido seleccionado como moderador del proyecto {{$notification->data['project']}} </a>
                        <hr style="margin-top: 5px; margin-bottom:5px">
                        @break
                        @case("supportProposal")
                        <a href="{{ route('proposal', ['id' => $notification->data['proposal_id']]) }}" class="dropdown-item">El usuario {{$notification->data['name']}} ha apoyado su propuesta </a>
                        <hr style="margin-top: 5px; margin-bottom:5px">
                        @break
                        @case("commentProposal")
                        <a href="{{ route('proposal', ['id' => $notification->data['proposal_id']]) }}" class="dropdown-item">El usuario {{$notification->data['name']}} ha comentado su propuesta</a>
                        <hr style="margin-top: 5px; margin-bottom:5px">
                        @break
                        @case("supportCommentProposal")
                        <a href="{{ route('proposal', ['id' => $notification->data['proposal_id']]) }}" class="dropdown-item">El usuario {{$notification->data['name']}} ha apoyado su comentario</a>
                        <hr style="margin-top: 5px; margin-bottom:5px">
                        @break
                        @case("reportCommentProposal")
                        <a href="{{ route('comment.edit', ['id' => $notification->data['comment_id']]) }}" class="dropdown-item">El usuario {{$notification->data['name']}} ha recibido demasiados reportes en su comentario</a>
                        <hr style="margin-top: 5px; margin-bottom:5px">
                        @break
                        @case("reportCommentProject")
                        <a href="{{ route('commentproject.edit', ['id' => $notification->data['comment_id']]) }}" class="dropdown-item">El usuario {{$notification->data['name']}} ha recibido demasiados reportes en su comentario</a>
                        <hr style="margin-top: 5px; margin-bottom:5px">
                        @break
                        @case("reportCommentArticle")
                        <a href="{{ route('commentarticle.edit', ['id' => $notification->data['article_id'],$notification->data['numero']]) }}" class="dropdown-item">El usuario {{$notification->data['name']}} ha recibido demasiados reportes en su comentario</a>
                        <hr style="margin-top: 5px; margin-bottom:5px">
                        @break
                        @case("deleteCommentArticle")
                        <a href="{{ route('article', [$notification->data['article_id'],$notification->data['numero']]) }}" class="dropdown-item">Su comentario en un articulo ha sido eliminado por un administrador</a>
                        <hr style="margin-top: 5px; margin-bottom:5px">
                        @break
                        @case("deleteCommentProject")
                        <a href="{{ route('project', [$notification->data['project_id']]) }}" class="dropdown-item">Su comentario en un proyecto ha sido eliminado por un administrador</a>
                        <hr style="margin-top: 5px; margin-bottom:5px">
                        @break
                        @case("deleteCommentProposal")
                        <a href="{{ route('proposal', [$notification->data['proposal_id']]) }}" class="dropdown-item">Su comentario en una propuesta ha sido eliminado por un administrador</a>
                        <hr style="margin-top: 5px; margin-bottom:5px">
                        @break
                        @case("commentCommentProposal")
                        <a href="{{ route('proposal', ['id' => $notification->data['proposal_id']]) }}" class="dropdown-item">El usuario {{$notification->data['name']}} ha respondido a su comentario en una propuesta</a>
                        <hr style="margin-top: 5px; margin-bottom:5px">
                      @endswitch
                    @empty
                      <a class="dropdown-item">No hay notificaciones para mostrar</a>     
                    @endforelse
                  </div>
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

    <a href="#" class="flotanteVisible scroll-top back-to-top"><span class="glyphicon glyphicon-menu-up" aria-hidden="true"></span></a>

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

    <script src="/js/scroll.js"></script>

    @yield('scripts')

</html>