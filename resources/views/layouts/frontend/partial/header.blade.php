<!-- BEGIN: Header -->
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('frontend/images/logo.png') }}">  
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ \Request::is('forum') ? 'active' : '' }}" href="{{ route('threads.index') }}">Forum</a>
                </li>
               {{--  <li class="nav-item">
                    <a class="nav-link {{ \Request::is('courses') ? 'active' : '' }}" href="{{ route('courses') }}">Courses</a>
                </li> --}}
                @foreach($menuItems as $item)
                    @if ($item->children->count())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="{{ $item->redirection_url }}" id="navbarDropdown{{ $item->id }}" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ $item->title }}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown{{ $item->id }}">
                            @foreach($item->children as $child)
                                <li><a class="dropdown-item" href="{{ $child->redirection_url }}">{{ $child->title }}</a></li>
                            @endforeach
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ $item->redirection_url }}">{{ $item->title }}</a>
                        </li>
                    @endif
                @endforeach
            </ul>
            <div class="d-flex">
                @auth
                    <a href="" class="loginBtn" data-bs-toggle="modal" data-bs-target="#notificationModal"><i class="fas fa-bell"></i></a>
                    <div class="login-head mont dropdown" id="loginDropdown">
                        <div class="dropdown-toggle" data-bs-toggle="dropdown" role="button" id="navbarDropdown">
                            <span>My Account</span>
                        </div>
                        <div class="dropdown-menu" id="loginDropMenu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('dashboard') }}">
                                <i data-feather="power"></i>
                                <span class="">Dashboard</span>
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="mr-50" data-feather="power"></i> Logout</a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                        </div>
                    </div>
                @else
                    <a href="" class="loginBtn" data-bs-toggle="modal" data-bs-target="#loginModal"><i class="far fa-user-circle"></i> Login / Register</a>
                @endauth
                
            </div>
        </div>
    </div>
</nav>

<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="padding: 25px;text-align: left;">
      <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
        <p class="text-center mt-2"><span>Already have an account?</span><a data-bs-toggle="modal" data-bs-target="#loginModal" id="signInBtn"><span class="blueText">&nbsp;Sign in instead</span></a></p>
      </div>
    </div>
  </div>
</div>
<!-- END: Header-->

