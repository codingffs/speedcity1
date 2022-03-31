<header class="main-nav">

    <nav>
        <div class="main-navbar">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="mainnav">
                <ul class="nav-menu custom-scrollbar">
                    <li class="back-btn">
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                aria-hidden="true"></i></div>
                    </li>

                    <li class="dropdown"><a class="nav-link menu-title link-nav {{ routeActive('index') }}"
                            href="{{ route('index') }}"><i data-feather="home"></i><span>Dashboard</span></a>
                    </li>

                    <li class="dropdown"><a class="nav-link menu-title link-nav {{ routeActive('Courierlist.index') }}"
                        href="{{ route('Courierlist.index') }}"><i data-feather="archive"></i></i><span>Courier Items</span></a>
                     </li>
                     <li class="dropdown"><a class="nav-link menu-title link-nav"
                        href="{{ route('offices.index') }}"><i data-feather="package"></i><span>Offices</span></a></li>
                             
                    <li class="dropdown"><a class="nav-link menu-title link-nav"
                        href="{{ route('localPackage.index') }}"><i data-feather="package"></i><span>Local Package</span></a></li>
                    
                     <li class="dropdown"><a class="nav-link menu-title link-nav {{ routeActive('species.index') }}"
                        href="{{ route('species.index') }}"><i data-feather="archive"></i></i><span>Parcel Management</span></a>
                     </li>

                     <li class="dropdown"><a class="nav-link menu-title link-nav {{ routeActive('domesticpackage.index') }}"
                        href="{{ route('domesticpackage.index') }}"><i data-feather="archive"></i></i><span>Domestic Package</span></a>
                     </li>
                     <li class="dropdown"><a class="nav-link menu-title link-nav {{ routeActive('branchuser.index') }}"
                        href="{{ route('branchuser.index') }}"><i data-feather="archive"></i></i><span>Branch User</span></a>
                     </li>

                     <li class="dropdown"><a class="nav-link menu-title link-nav {{ routeActive('user.index') }}"
                        href="{{ route('user.index') }}"><i data-feather="archive"></i></i><span>Customer</span></a>
                     </li>

                    <li class="dropdown"><a class="nav-link menu-title link-nav"
                            href="{{ route('logout') }}"><i data-feather="lock"></i><span>Log Out</span></a></li>

                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </div>
    </nav>
</header>
