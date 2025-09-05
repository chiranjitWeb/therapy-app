<div class="main-menu-nav open-nav">
    <div class="nav-wrapper">

       <div class="nav-logo">
          <a href="{{ route('dashboard') }}"><img src="{{ asset('assets/img/logo.svg') }}" alt=""></a>
       </div>

       <div class="header-nav">
          <ul class="nav-primary">
             <li><a href="{{ route('dashboard') }}" class="active">
                   <div class="navigation-icon"><i class="las la-columns"></i></div> <span>Dashboard</span>
                </a></li>
             <li><a href="{{ route('calendar') }}">
                   <div class="navigation-icon"><i class="las la-calendar"></i></div> <span>Kalendarz</span>
                </a></li>
             <li><a href="#">
                   <div class="navigation-icon"><i class="las la-user-circle"></i></div> <span>Pacjenci</span>
                </a></li>
             <li><a href="#">
                   <div class="navigation-icon"><i class="las la-comment"></i></div> <span>Chat</span>
                </a></li>
             <li><a href="#">
                   <div class="navigation-icon"><i class="las la-cog"></i></div> <span>Ustawienia</span>
                </a></li>
          </ul>
       </div>
    </div>
 </div>