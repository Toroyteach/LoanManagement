<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="{{ route('index') }}">
            {{ config('app.name') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
            <li class="c-sidebar-nav-item">
                <a href="{{ route('admin.dashboard') }}" class="c-sidebar-nav-link {{ request()->is('admin/dashboard') || request()->is('admin/dashboard') ? 'active' : '' }}">
                    <i class="fa-fw fas fa-chart-line c-sidebar-nav-icon"></i>
                    {{ trans('cruds.status.dashboard') }}
                </a>
            </li>
        @can('user_management_access')  
            <li class="c-sidebar-nav-dropdown">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    @if(Auth::user()->getIsMemberAttribute())
                        {{ trans('cruds.userManagement.profile') }}
                    @else
                        {{ trans('cruds.userManagement.title') }}
                    @endif

                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('view_self_user')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.user.show") }}" class="c-sidebar-nav-link {{ request()->is('admin/user/show') || request()->is('admin/user/show/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-id-card c-sidebar-nav-icon">

                                </i>
                                Profile
                            </a>
                        </li>
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.user.statements") }}" class="c-sidebar-nav-link {{ request()->is('admin/user/statements') || request()->is('admin/user/statements/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-file-pdf c-sidebar-nav-icon"></i>
                                Statements
                            </a>
                        </li>
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.user.forms") }}" class="c-sidebar-nav-link {{ request()->is('admin/user/forms') || request()->is('admin/user/forms/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-align-left c-sidebar-nav-icon">

                                </i>
                                Forms
                            </a>
                        </li>
                    @endcan
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
                                Members
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
                    <i class="fa-fw fas fa-money c-sidebar-nav-icon">

                    </i>
                    Loan Hub
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    <li class="c-sidebar-nav-item">
                        <a href="{{ route("admin.loan-applications.index") }}" class="c-sidebar-nav-link {{ request()->is('admin/loan-applications') || request()->is('admin/loan-applications/*') ? 'active' : '' }}">
                            <i class="fa-fw fas fa-file-alt c-sidebar-nav-icon">

                            </i>
                            @if(Auth::user()->getIsMemberAttribute())
                                Apply Loan
                            @else
                                {{ trans('cruds.loanApplication.title') }}
                            @endif
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
                            <a href="{{ route('admin.rejected.loans') }}" class="c-sidebar-nav-link {{ request()->is('admin/rejected/loans') || request()->is('admin/rejected/loans/*') ? 'active' : '' }}">
                            <i class="fas fa-money-check-alt c-sidebar-nav-icon"></i>

                                </i>
                                Rejected Loans
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
                    @can('bulk_update')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route('admin.bulkView') }}" class="c-sidebar-nav-link {{ request()->is('admin/bulkView') || request()->is('admin/bulkView/*') ? 'active' : '' }}">
                            <i class="fas fa-exclamation-circle c-sidebar-nav-icon"></i>

                                </i>
                                Bulk Update
                            </a>
                        </li>
                    @endcan
                    @can('view_self_user')
                    <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.user.loans") }}" class="c-sidebar-nav-link {{ request()->is('admin/user/loans') || request()->is('admin/user/loans/*') ? 'active' : '' }}">
                                <i class="fa-fw fas fa-wallet c-sidebar-nav-icon">

                                </i>
                                My Loans
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
