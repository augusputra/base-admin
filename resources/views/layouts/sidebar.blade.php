<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li>
                    <a href="{{route('dashboard')}}" class="waves-effect font-size-15">
                        <i class="ti-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                @canany(['view-user-list', 'view-role-list'])

                    <li class="menu-title">User Management</li>
                
                @endcan

                @canany(['view-user-list', 'create-user', 'update-user', 'delete-user'])

                    <li>
                        <a href="{{route('users')}}" class="waves-effect font-size-15">
                            <i class="ti-user"></i>
                            <span>Users</span>
                        </a>
                    </li>

                @endcan

                @canany(['view-role-list', 'create-role', 'update-role', 'delete-role'])

                    <li>
                        <a href="{{route('users')}}" class="waves-effect font-size-15">
                            <i class="ti-user"></i>
                            <span>Roles</span>
                        </a>
                    </li>

                @endcan

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
