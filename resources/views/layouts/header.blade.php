<header class="page-header">
   <div class="container-fluid">
      <div class="header-wrapper reverse-item">
         <div class="header-left">
            <button class="btn-toggle-nav"><i class="las la-bars"></i></button>
            <h4>{{ $title }}</h4>
         </div>
         <div class="header-right">
            <div class="user-menu-wrapper">
               <div class="account" id="userIcon"><i class="las la-user"></i></div>
               <ul class="dropdown-menu" id="dropdownMenu">
                  <li>
                     <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="">
                            Wyloguj się
                        </button>
                    </form>
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</header>