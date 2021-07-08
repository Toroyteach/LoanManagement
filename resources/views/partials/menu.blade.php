<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="{{ route('admin.dashboard') }}">
            {{ config('app.name') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        @can('user_management_access')  
            <li class="c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('status_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.statuses.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/statuses') || request()->is('admin/statuses/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-check c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.status.title') }}
                </a>
            </li>
        @endcan
        @can('upload_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.files.create") }}" class="c-sidebar-nav-link {{ request()->is('admin/statuses') || request()->is('admin/statuses/*') ? 'active' : '' }}">
                    <i class="fas fa-upload c-sidebar-nav-icon">

                    </i>
                    Upload File
                </a>
            </li>
        @endcan

        @can('loan_application_access')  
            <li class="c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    Loan Management
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.loan-applications.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/loan-applications') || request()->is('admin/loan-applications/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-file-alt c-sidebar-nav-icon">

                            </i>
                            {{ trans('cruds.loanApplication.title') }}
                        </a>
                    </li>
                    @can('view_loan_status')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.active.loans') }}" class="c-sidebar-nav-link {{ request()->is('admin/active/loans') || request()->is('admin/active/loans/*') ? 'active' : '' }}">
                            <i class="fas fa-money-check c-sidebar-nav-icon"></i>

                                </i>
                                Active Loans
                            </a>
                        </li>
                    @endcan
                    @can('view_loan_status')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.cleared.loans') }}" class="c-sidebar-nav-link {{ request()->is('admin/cleared/loans') || request()->is('admin/cleared/loans/*') ? 'active' : '' }}">
                            <i class="fas fa-money-check-alt c-sidebar-nav-icon"></i>

                                </i>
                                Cleared Loans
                            </a>
                        </li>
                    @endcan
                    @can('view_loan_status')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.defaultors') }}" class="c-sidebar-nav-link {{ request()->is('admin/defaultors') || request()->is('admin/defaultors/*') ? 'active' : '' }}">
                            <i class="fas fa-exclamation-circle c-sidebar-nav-icon"></i>

                                </i>
                                Defaulters
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan

        @can('comment_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.comments.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/comments') || request()->is('admin/comments/*') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-comment c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.comment.title') }}
                </a>
            </li>
        @endcan
        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}" href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                        </i>
                        {{ trans('global.change_password') }}
                    </a>
                </li>
            @endcan
        @endif
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>

</div>
