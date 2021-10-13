<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index">
                            <i class="ti-home mr-2"></i>@lang('translation.Dashboard')
                        </a>
                    </li>

                    <li class="nav-item dropdown mega-dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-uielement" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ti-package mr-2"></i>@lang('translation.UI_Elements')
                        </a>

                        <div class="dropdown-menu mega-dropdown-menu dropdown-menu-left dropdown-mega-menu-xl"
                            aria-labelledby="topnav-uielement">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div>
                                        <a href="ui-alerts" class="dropdown-item">@lang('translation.Alerts')</a>
                                        <a href="ui-buttons" class="dropdown-item">@lang('translation.Buttons')</a>
                                        <a href="ui-cards" class="dropdown-item">@lang('translation.Cards')</a>
                                        <a href="ui-carousel" class="dropdown-item">@lang('translation.Carousel')</a>
                                        <a href="ui-dropdowns" class="dropdown-item">@lang('translation.Dropdowns')</a>
                                        <a href="ui-grid" class="dropdown-item">@lang('translation.Grid')</a>
                                        <a href="ui-images" class="dropdown-item">@lang('translation.Images')</a>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div>
                                        <a href="ui-lightbox" class="dropdown-item">@lang('translation.Lightbox')</a>
                                        <a href="ui-modals" class="dropdown-item">@lang('translation.Modals')</a>
                                        <a href="ui-rangeslider" class="dropdown-item">@lang('translation.Range_Slider')</a>
                                        <a href="ui-session-timeout" class="dropdown-item">@lang('translation.Session_Timeout')</a>
                                        <a href="ui-progressbars" class="dropdown-item">@lang('translation.Progress_Bars')</a>
                                        <a href="ui-sweet-alert" class="dropdown-item">@lang('translation.Sweet_Alert')</a>
                                        <a href="ui-tabs-accordions" class="dropdown-item">@lang('translation.Tabs_&_Accordions')</a>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div>
                                        <a href="ui-typography" class="dropdown-item">@lang('translation.Typography')</a>
                                        <a href="ui-video" class="dropdown-item">@lang('translation.Video')</a>
                                        <a href="ui-general" class="dropdown-item">@lang('translation.General')</a>
                                        <a href="ui-colors" class="dropdown-item">@lang('translation.Colors')</a>
                                        <a href="ui-rating" class="dropdown-item">@lang('translation.Rating')</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-components" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ti-harddrives mr-2"></i>@lang('translation.Components')
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-components">

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-email"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @lang('translation.Email') <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-email">
                                    <a href="email-inbox" class="dropdown-item">@lang('translation.Inbox')</a>
                                    <a href="email-read" class="dropdown-item">@lang('translation.Email_Read')</a>
                                    <a href="email-compose" class="dropdown-item">@lang('translation.Email_Compose')</a>
                                </div>
                            </div>

                            <a href="calendar" class="dropdown-item">@lang('translation.Calendar')</a>

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @lang('translation.Forms') <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-form">
                                    <a href="form-elements" class="dropdown-item">@lang('translation.Form_Elements')</a>
                                    <a href="form-validation" class="dropdown-item">@lang('translation.Form_Validation')</a>
                                    <a href="form-advanced" class="dropdown-item">@lang('translation.Form_Advanced')</a>
                                    <a href="form-editors" class="dropdown-item">@lang('translation.Form_Editors')</a>
                                    <a href="form-uploads" class="dropdown-item">@lang('translation.Form_File_Upload')</a>
                                    <a href="form-xeditable" class="dropdown-item">@lang('translation.Form_Xeditable')</a>
                                    <a href="form-repeater" class="dropdown-item">@lang('translation.Form_Repeater')</a>
                                    <a href="form-wizard" class="dropdown-item">@lang('translation.Form_Wizard')</a>
                                    <a href="form-mask" class="dropdown-item">@lang('translation.Form_Mask')</a>
                                </div>
                            </div>

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-chart"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @lang('translation.Charts') <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-chart">
                                    <a href="charts-morris" class="dropdown-item">@lang('translation.Morris_Chart')</a>
                                    <a href="charts-chartist" class="dropdown-item">@lang('translation.Chartist_Chart')</a>
                                    <a href="charts-chartjs" class="dropdown-item">@lang('translation.Chartjs_Chart')</a>
                                    <a href="charts-flot" class="dropdown-item">@lang('translation.Flot_Chart')</a>
                                    <a href="charts-knob" class="dropdown-item">@lang('translation.Jquery_Knob_Chart')</a>
                                    <a href="charts-sparkline" class="dropdown-item">@lang('translation.Sparkline_Chart')</a>
                                </div>
                            </div>

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-table"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @lang('translation.Tables') <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-table">
                                    <a href="tables-basic" class="dropdown-item">@lang('translation.Basic_Tables')</a>
                                    <a href="tables-datatable" class="dropdown-item">@lang('translation.Data_Table')</a>
                                    <a href="tables-responsive" class="dropdown-item">@lang('translation.Responsive_Table')</a>
                                    <a href="tables-editable" class="dropdown-item">@lang('translation.Editable_Table')</a>
                                </div>
                            </div>

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-icons"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @lang('translation.Icons') <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-icons">
                                    <a href="icons-material" class="dropdown-item">@lang('translation.Material_Design')</a>
                                    <a href="icons-fontawesome" class="dropdown-item">@lang('translation.Font_Awesome')</a>
                                    <a href="icons-ion" class="dropdown-item">@lang('translation.Ion_Icons')</a>
                                    <a href="icons-themify" class="dropdown-item">@lang('translation.Themify_Icons')</a>
                                    <a href="icons-dripicons" class="dropdown-item">@lang('translation.Dripicons')</a>
                                    <a href="icons-typicons" class="dropdown-item">@lang('translation.Typicons_Icons')</a>
                                </div>
                            </div>

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-map"
                                    role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @lang('translation.Maps') <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-map">
                                    <a href="maps-google" class="dropdown-item"> @lang('translation.Google_Map')</a>
                                    <a href="maps-vector" class="dropdown-item"> @lang('translation.Vector_Map')</a>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown mega-dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-auth" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ti-archive mr-2"></i> @lang('translation.Authentication')
                        </a>

                        <div class="dropdown-menu mega-dropdown-menu dropdown-mega-menu-lg"
                            aria-labelledby="topnav-auth">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div>
                                        <a href="pages-login" class="dropdown-item">@lang('translation.Login_1')</a>
                                        <a href="pages-register" class="dropdown-item">@lang('translation.Register_1')</a>
                                        <a href="pages-recoverpw" class="dropdown-item">@lang('translation.Recover_Password_1')
                                            1</a>
                                        <a href="pages-lock-screen" class="dropdown-item">@lang('translation.Lock_Screen_1')</a>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div>
                                        <a href="pages-login-2" class="dropdown-item">@lang('translation.Login_2')</a>
                                        <a href="pages-register-2" class="dropdown-item">@lang('translation.Register_2')</a>
                                        <a href="pages-recoverpw-2" class="dropdown-item">@lang('translation.Recover_Password_2')</a>
                                        <a href="pages-lock-screen-2" class="dropdown-item">@lang('translation.Lock_Screen_2')</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown mega-dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-extrapages" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ti-support mr-2"></i> @lang('translation.Extra_Pages')
                        </a>

                        <div class="dropdown-menu mega-dropdown-menu dropdown-mega-menu-lg"
                            aria-labelledby="topnav-extrapages">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div>
                                        <a href="pages-timeline" class="dropdown-item">@lang('translation.Timeline')</a>
                                        <a href="pages-invoice" class="dropdown-item">@lang('translation.Invoice')</a>
                                        <a href="pages-directory" class="dropdown-item">@lang('translation.Directory')</a>
                                        <a href="pages-blank" class="dropdown-item">@lang('translation.Blank_Page')</a>
                                        <a href="pages-404" class="dropdown-item">@lang('translation.Error_404')</a>
                                        <a href="pages-500" class="dropdown-item">@lang('translation.Error_500')</a>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div>
                                        <a href="pages-pricing" class="dropdown-item">@lang('translation.Pricing')</a>
                                        <a href="pages-gallery" class="dropdown-item">@lang('translation.Gallery')</a>
                                        <a href="pages-maintenance" class="dropdown-item">@lang('translation.Maintenance')</a>
                                        <a href="pages-comingsoon" class="dropdown-item">@lang('translation.Coming_Soon')</a>
                                        <a href="pages-faq" class="dropdown-item">@lang('translation.FAQs')</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-emailtemplates" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ti-bookmark-alt mr-2"></i>@lang('translation.Email_Templates')
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-emailtemplates">
                            <a href="email-template-basic" class="dropdown-item">@lang('translation.Basic_Action_Email')</a>
                            <a href="email-template-Alert" class="dropdown-item">@lang('translation.Alert_Email')</a>
                            <a href="email-template-Billing" class="dropdown-item">@lang('translation.Billing_Email')</a>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ti-layout mr-2"></i> @lang('translation.Layouts')
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-layout">
                            <a href="index" class="dropdown-item">@lang('translation.Vertical')</a>
                            <a href="layouts-topbar-light" class="dropdown-item">@lang('translation.Topbar_Light')</a>
                            <a href="layouts-boxed-hor" class="dropdown-item">@lang('translation.Boxed_Layout')</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
