<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ URL::asset('/assets/images/logo.svg') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ URL::asset('/assets/images/logo-dark.png') }}" alt="" height="17">
                    </span>
                </a>

                <a href="index" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ URL::asset('/assets/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ URL::asset('/assets/images/logo-light.png') }}" alt="" height="18">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm mr-2 font-size-24 d-lg-none header-item waves-effect waves-light"
                data-toggle="collapse" data-target="#topnav-menu-content">
                <i class="mdi mdi-menu"></i>
            </button>

        </div>

        <div class="d-flex">
            <!-- App Search-->
            <form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="@lang('translation.Search')">
                    <span class="fa fa-search"></span>
                </div>
            </form>

            <div class="dropdown d-inline-block d-lg-none ml-2">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="mdi mdi-magnify"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                    aria-labelledby="page-header-search-dropdown">

                    <form class="p-3">
                        <div class="form-group m-0">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="@lang('translation.Search')"
                                    aria-label="Recipient's username">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i
                                            class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="dropdown d-none d-md-block ml-2 language-switch">
                <button type="button" class="btn header-item waves-effect" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    @switch(Session::get('lang'))
                        @case('ru')
                        <img class="mr-2" src="{{ URL::asset('assets/images/flags/spain_flag.jpg') }}" alt="Header Language"
                            height="16"> Spanish <span class="mdi mdi-chevron-down"></span>
                        @break
                        @case('it')
                        <img class="mr-2" src="{{ URL::asset('assets/images/flags/italy_flag.jpg') }}" alt="Header Language"
                            height="16"> Italian <span class="mdi mdi-chevron-down"></span>
                        @break
                        @case('de')
                        <img class="mr-2" src="{{ URL::asset('assets/images/flags/germany_flag.jpg') }}"
                            alt="Header Language" height="16"> German <span class="mdi mdi-chevron-down"></span>
                        @break
                        @case('es')
                        <img class="mr-2" src="{{ URL::asset('assets/images/flags/russia_flag.jpg') }}"
                            alt="Header Language" height="16"> Russian <span class="mdi mdi-chevron-down"></span>
                        @break
                        @case('fr')
                        <img class="mr-2" src="{{ URL::asset('assets/images/flags/french_flag.jpg') }}"
                            alt="Header Language" height="16"> French <span class="mdi mdi-chevron-down"></span>
                        @break
                        @default
                        <img class="mr-2" src="{{ URL::asset('assets/images/flags/us_flag.jpg') }}" alt="Header Language"
                            height="16"> English <span class="mdi mdi-chevron-down"></span>
                    @endswitch
                </button>
                <div class="dropdown-menu dropdown-menu-right">

                    <!-- item-->
                    <a href="{{ url('index/en') }}" class="dropdown-item notify-item">
                        <img src="{{ URL::asset('assets/images/flags/us_flag.jpg') }}" alt="user-image" class="mr-1"
                            height="12"> <span class="align-middle">English</span>
                    </a>

                    <!-- item-->
                    <a href="{{ url('index/de') }}" class="dropdown-item notify-item">
                        <img src="{{ URL::asset('assets/images/flags/germany_flag.jpg') }}" alt="user-image"
                            class="mr-1" height="12"> <span class="align-middle">German</span>
                    </a>

                    <!-- item-->
                    <a href="{{ url('index/it') }}" class="dropdown-item notify-item">
                        <img src="{{ URL::asset('assets/images/flags/italy_flag.jpg') }}" alt="user-image" class="mr-1"
                            height="12"> <span class="align-middle">Italian</span>
                    </a>

                    <!-- item-->
                    <a href="{{ url('index/fr') }}" class="dropdown-item notify-item">
                        <img src="{{ URL::asset('assets/images/flags/french_flag.jpg') }}" alt="user-image" class="mr-1"
                            height="12"> <span class="align-middle">French</span>
                    </a>

                    <!-- item-->
                    <a href="{{ url('index/es') }}" class="dropdown-item notify-item">
                        <img src="{{ URL::asset('assets/images/flags/spain_flag.jpg') }}" alt="user-image" class="mr-1"
                            height="12"> <span class="align-middle">Spanish</span>
                    </a>

                    <!-- item-->
                    <a href="{{ url('index/ru') }}" class="dropdown-item notify-item">
                        <img src="{{ URL::asset('assets/images/flags/russia_flag.jpg') }}" alt="user-image" class="mr-1"
                            height="12"> <span class="align-middle">Russian</span>
                    </a>
                </div>
            </div>

            <div class="dropdown d-none d-lg-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="mdi mdi-fullscreen"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect"
                    id="page-header-notifications-dropdown" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="mdi mdi-bell-outline"></i>
                    <span class="badge badge-danger badge-pill">3</span>
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="m-0 font-size-16">@lang('translation.Notifications_(258)') </h5>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;">
                        <a href="" class="text-reset notification-item">
                            <div class="media">
                                <div class="avatar-xs mr-3">
                                    <span class="avatar-title bg-success rounded-circle font-size-16">
                                        <i class="mdi mdi-cart-outline"></i>
                                    </span>
                                </div>
                                <div class="media-body">
                                    <h6 class="mt-0 mb-1">@lang('translation.Your_order_is_placed')</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">@lang('translation.printing_typesetting')</p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="" class="text-reset notification-item">
                            <div class="media">
                                <div class="avatar-xs mr-3">
                                    <span class="avatar-title bg-warning rounded-circle font-size-16">
                                        <i class="mdi mdi-message-text-outline"></i>
                                    </span>
                                </div>
                                <div class="media-body">
                                    <h6 class="mt-0 mb-1">@lang('translation.New_Message_received')</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">@lang('translation.unread_messages')</p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="" class="text-reset notification-item">
                            <div class="media">
                                <div class="avatar-xs mr-3">
                                    <span class="avatar-title bg-info rounded-circle font-size-16">
                                        <i class="mdi mdi-glass-cocktail"></i>
                                    </span>
                                </div>
                                <div class="media-body">
                                    <h6 class="mt-0 mb-1">@lang('translation.Your_item_is_shipped')</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">@lang('translation.established_fact')</p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="" class="text-reset notification-item">
                            <div class="media">
                                <div class="avatar-xs mr-3">
                                    <span class="avatar-title bg-primary rounded-circle font-size-16">
                                        <i class="mdi mdi-cart-outline"></i>
                                    </span>
                                </div>
                                <div class="media-body">
                                    <h6 class="mt-0 mb-1">@lang('translation.Your_order_is_placed')</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">@lang('translation.printing_typesetting')</p>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <a href="" class="text-reset notification-item">
                            <div class="media">
                                <div class="avatar-xs mr-3">
                                    <span class="avatar-title bg-danger rounded-circle font-size-16">
                                        <i class="mdi mdi-message-text-outline"></i>
                                    </span>
                                </div>
                                <div class="media-body">
                                    <h6 class="mt-0 mb-1">@lang('translation.New_Message_received')</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">@lang('translation.unread_messages')</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="p-2 border-top">
                        <a class="btn btn-sm btn-link font-size-14 btn-block text-center" href="javascript:void(0)">
                            @lang('translation.View_all')
                        </a>
                    </div>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user"
                        src="{{ URL::asset('/assets/images/users/user-4.jpg') }}" alt="Header Avatar">
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <!-- item-->
                    <a class="dropdown-item" href="#"><i
                            class="mdi mdi-account-circle font-size-17 align-middle mr-1"></i>
                        @lang('translation.Profile')</a>
                    <a class="dropdown-item" href="#"><i class="mdi mdi-wallet font-size-17 align-middle mr-1"></i>
                        @lang('translation.My_Wallet')</a>
                    <a class="dropdown-item d-block" href="#"><span class="badge badge-success float-right">11</span><i
                            class="mdi mdi-settings font-size-17 align-middle mr-1"></i>
                        @lang('translation.Settings')</a>
                    <a class="dropdown-item" href="#"><i
                            class="mdi mdi-lock-open-outline font-size-17 align-middle mr-1"></i>
                        @lang('translation.Lock_screen')</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="javascript:void();"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bx bx-power-off font-size-17 align-middle mr-1 text-danger"></i>
                        @lang('translation.Logout')
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                    <i class="mdi mdi-settings-outline"></i>
                </button>
            </div>

        </div>
    </div>
</header>
