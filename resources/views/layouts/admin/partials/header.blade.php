<div class="page-main-header">
    <div class="main-header-right row m-0">
        <div class="main-header-left">
            <div class="logo-wrapper"><a href="{{ route('index') }}"><img class="img-fluid"
                        src="{{ url('setting/'.logoimage('logo')) }}" height="50px" width="44px" alt=""></a></div>
            <div class="dark-logo-wrapper"><a href="{{ route('index') }}"><img class="img-fluid"
                        src="{{ url('setting/'.logoimage('logo')) }}" alt=""></a></div>
            <div class="toggle-sidebar"><i class="status_toggle middle" data-feather="align-center" id="sidebar-toggle">
                </i></div>
        </div>

        {{-- <div class="left-menu-header col">
            <ul>
                <li>
                    <form class="form-inline search-form">
                        <div class="search-bg"><i class="fa fa-search"></i>
                            <input class="form-control-plaintext" placeholder="Search here.....">
                        </div>
                    </form>
                    <span class="d-sm-none mobile-search search-bg"><i class="fa fa-search"></i></span>
                </li>
            </ul>
        </div> --}}

        <div class="nav-right col pull-right right-menu p-0">
            <ul class="nav-menus">
                {{-- <li class="onhover-dropdown p-0">
                    <a href="{{ route('logout') }}" class="btn btn-primary-light" type="submit"><i
                            data-feather="log-out"></i>Log out</a> --}}
                {{-- </li> --}}
                <li class="onhover-dropdown">
                    <a href="javascript:void(0)" class="btn btn-primary-light" type="submit">My Account</a>
                    <div class="bookmark-dropdown onhover-show-div">
                        <ul class="m-t-5">
                            
                            <a href="{{ route('edit_profile') }}">
                                <li class="add-to-bookmark"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-inbox bookmark-icon">
                                    <polyline points="22 12 16 12 14 15 10 15 8 12 2 12"></polyline>
                                    <path
                                        d="M5.45 5.11L2 12v6a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-6l-3.45-6.89A2 2 0 0 0 16.76 4H7.24a2 2 0 0 0-1.79 1.11z">
                                    </path>
                                </svg>Profile</li></a>
                            
                            <a href="{{ route('change_password') }}">
                                <li class="add-to-bookmark"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-message-square bookmark-icon">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>Change Password</li></a>
                                
                            <a href="{{ route('logout') }}">
                                <li class="add-to-bookmark"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-message-square bookmark-icon">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg>Log Out </li></a>
                            
                        </ul>
                    </div>
                </li>
                
            </ul>
        </div>
        <div class="d-lg-none mobile-toggle pull-right w-auto"><i data-feather="more-horizontal"></i></div>
    </div>
</div>
