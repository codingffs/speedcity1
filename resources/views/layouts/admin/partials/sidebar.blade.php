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

                    {{-- dropdown master--}}
                    {{-- <li class="dropdown"><a class="nav-link menu-title" href="javascript:void(0)"><i
                        data-feather="menu"></i><span>Master</span><div class="according-menu"></div></a>
                        <ul class="nav-submenu menu-content"> --}}

                    {{-- @can('services-list')
                        <li class="dropdown"><a
                            class="nav-link menu-title link-nav {{ routeActive('services.index') }}{{ routeActive('services.create') }}"{{ routeActive('services.edit') }}
                            href="{{ route('services.index') }}"><i
                            data-feather="server"></i><span>Services</span></a></li>
                    @endcan --}}

                    {{-- @can('role-list')
                        <li class="dropdown"><a
                            class="nav-link menu-title link-nav {{ routeActive('roles.index') }}{{ routeActive('roles.create') }}{{ routeActive('roles.edit') }}"
                            href="{{ route('roles.index') }}"><i data-feather="aperture"></i><span>Roles</span></a>
                        </li>
                    @endcan --}}

                    {{-- @can('permission-list')
                        <li class="dropdown"><a
                                class="nav-link menu-title link-nav {{ routeActive('permission.index') }}{{ routeActive('permission.create') }}{{ routeActive('permission.edit') }}"
                                href="{{ route('permission.index') }}"><i
                                    data-feather="airplay"></i><span>Permission</span></a></li>
                    @endcan --}}
                    {{-- 
                    @can('user-list')
                        <li class="dropdown"><a
                                class="nav-link menu-title link-nav {{ routeActive('user.index') }}"
                                href="{{ route('user.index') }}"><i data-feather="airplay"></i><span>User</span></a>
                        </li>
                    @endcan --}}
                    {{-- @can('staff-list')
                        <li class="dropdown"><a
                            class="nav-link menu-title link-nav {{ routeActive('staff.index') }}{{ routeActive('staff.create') }}{{ routeActive('staff.edit') }}"
                            href="{{ route('staff.index') }}"><i data-feather="user"></i><span>Staff</span></a>
                        </li>
                    @endcan --}}
                    {{-- @can('doctor-list')
                        <li class="dropdown"><a
                            class="nav-link menu-title link-nav {{ routeActive('doctor.index') }}{{ routeActive('doctor.create') }}{{ routeActive('doctor.edit') }}"
                            href="{{ route('doctor.index') }}"><i data-feather="user"></i><span>Doctor</span></a>
                        </li>
                    @endcan --}}
                    {{-- @can('disease-list')
                        <li class="dropdown"><a
                            class="nav-link menu-title link-nav {{ routeActive('disease.index') }}{{ routeActive('disease.create') }}{{ routeActive('disease.edit') }}"
                            href="{{ route('disease.index') }}"><i data-feather="thermometer"></i><span>Disease</span></a>
                        </li>
                    @endcan --}}
                    {{-- @can('degree-list')
                        <li class="dropdown"><a
                            class="nav-link menu-title link-nav {{ routeActive('degree.index') }}{{ routeActive('degree.create') }}{{ routeActive('degree.edit') }}"
                            href="{{ route('degree.index') }}"><i data-feather="credit-card"></i><span>Degree</span></a>
                        </li>
                    @endcan --}}
                    {{-- @can('faq-list')
                        <li class="dropdown"><a
                            class="nav-link menu-title link-nav {{ routeActive('faq.index') }}{{ routeActive('faq.create') }}{{ routeActive('faq.edit') }}"
                            href="{{ route('faq.index') }}"><i data-feather="help-circle"></i><span>FAQ</span></a>
                        </li>
                    @endcan --}}
                    {{-- @can('subfaq-list')
                        <li class="dropdown"><a
                            class="nav-link menu-title link-nav {{ routeActive('subfaq.index') }}{{ routeActive('subfaq.create') }}{{ routeActive('subfaq.edit') }}"
                            href="{{ route('subfaq.index') }}"><i data-feather="trello"></i><span>SubFAQ</span></a>
                        </li>
                    @endcan --}}
                    {{-- @can('cms-list')
                        <li class="dropdown"><a
                            class="nav-link menu-title link-nav {{ routeActive('cms.index') }}{{ routeActive('cms.create') }}{{ routeActive('cms.edit') }}"
                            href="{{ route('cms.index') }}"><i data-feather="command"></i><span>CMS</span></a>
                        </li>
                    @endcan --}}
                    {{-- @can('additionalservice-list')
                        <li class="dropdown"><a
                            class="nav-link menu-title link-nav {{ routeActive('additionalservice.index') }}{{ routeActive('additionalservice.create') }}{{ routeActive('additionalservice.edit') }}"
                            href="{{ route('additionalservice.index') }}"><i data-feather="folder"></i><span>Additional Service</span></a>
                        </li>
                    @endcan --}}
                    {{-- @can('carepackage-list')
                        <li class="dropdown"><a
                            class="nav-link menu-title link-nav"
                            href="{{ route('carepackage.index') }}"><i data-feather="archive"></i><span>Care Pakege Plan</span></a>
                        </li>
                    @endcan --}}
                    {{-- @can('category-list')
                        <li class="dropdown"><a
                            class="nav-link menu-title link-nav {{ routeActive('categories.index') }}{{ routeActive('categories.create') }}{{ routeActive('categories.edit') }}"
                            href="{{ route('categories.index') }}"><i
                            data-feather="layers"></i><span>Medical Category</span></a></li>
                    @endcan --}}
                    {{-- @can('medicalappliance-list')
                        <li class="dropdown"><a
                            class="nav-link menu-title link-nav {{ routeActive('medicalappliance.index') }}{{ routeActive('medicalappliance.create') }}{{ routeActive('medicalappliance.edit') }}"
                            href="{{ route('medicalappliance.index') }}"><i data-feather="plus-circle"></i><span>Medical Appliance</span></a>
                        </li>
                    @endcan
                     --}}
                    {{-- @can('setting-list')
                        <li class="dropdown"><a
                                class="nav-link menu-title link-nav {{ routeActive('settings.index') }}"
                                href="{{ route('settings.index') }}"><i
                                    data-feather="airplay"></i><span>Settings</span></a></li>
                    @endcan --}}
                {{-- </ul>
            </li> --}}
           
                    {{-- dropdown location--}}
                    {{-- <li class="dropdown"><a class="nav-link menu-title" href="javascript:void(0)"><i data-feather="map-pin"></i><span>Location</span><div class="according-menu"></div></a>
                        <ul class="nav-submenu menu-content">
                            @can('country-list')
                            <li class="dropdown"><a
                                class="nav-link menu-title link-nav {{ routeActive('country.index') }}{{ routeActive('country.create') }}{{ routeActive('country.edit') }}"
                                href="{{ route('country.index') }}"><i data-feather="database"></i><span>Country</span></a>
                            </li>
                        @endcan
                        @can('state-list')
                            <li class="dropdown"><a
                                class="nav-link menu-title link-nav {{ routeActive('state.index') }}{{ routeActive('state.create') }}{{ routeActive('state.edit') }}"
                                href="{{ route('state.index') }}"><i data-feather="codepen"></i><span>State</span></a>
                            </li>
                        @endcan
                        @can('city-list')
                            <li class="dropdown"><a
                                class="nav-link menu-title link-nav {{ routeActive('city.index') }}{{ routeActive('city.create') }}{{ routeActive('city.edit') }}"
                                href="{{ route('city.index') }}"><i data-feather="map"></i><span>City</span></a>
                            </li>
                        @endcan
                        </ul>
                      </li> --}}
                 {{-- end --}}
                    {{-- dd --}}
                    <li class="dropdown"><a
                        class="nav-link menu-title link-nav"
                        href="{{ route('offices.index') }}"><i
                            data-feather="package"></i><span>Offices</span></a></li>
                             
                    <li class="dropdown"><a
                        class="nav-link menu-title link-nav"
                        href="{{ route('localPackage.index') }}"><i
                            data-feather="package"></i><span>Local Package</span></a></li>
                             
                    {{-- dd --}}
                    <li class="dropdown"><a class="nav-link menu-title link-nav"
                            href="{{ route('logout') }}"><i data-feather="lock"></i><span>Log Out</span></a></li>

                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </div>
    </nav>
</header>
