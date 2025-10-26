 <div class="az-header">
     <div class="container">
         <div class="az-header-left">
             <a href="index.html" class="az-logo"><span></span> azia</a>
             <a href="" id="azMenuShow" class="az-header-menu-icon d-lg-none"><span></span></a>
         </div><!-- az-header-left -->
         <div class="az-header-menu">
             <div class="az-header-menu-header">
                 <a href="index.html" class="az-logo"><span></span> azia</a>
                 <a href="" class="close">&times;</a>
             </div><!-- az-header-menu-header -->
             <ul class="nav">
                 <li class="nav-item {{ request()->is('/') ? 'active' : '' }} show">
                     <a href="/" class="nav-link"><i class="typcn typcn-chart-area-outline"></i>
                         Dashboard</a>
                 </li>
                 <li class="nav-item {{ request()->is('employee*') ? 'active' : '' }}">
                     <a href="" class="nav-link with-sub"><i class="typcn typcn-group-outline"></i> Employees</a>
                     <nav class="az-menu-sub">
                         <a href="{{ route('employee.employee.index') }}"
                             class="nav-link {{ Route::is('employee.employee.index') ? 'active' : '' }}">Employee
                             Directory</a>
                         <a href="{{ route('employee.department') }}"
                             class="nav-link {{ Route::is('employee.department') ? 'active' : '' }}">Departement</a>
                         <a href="{{ route('employee.position') }}"
                             class="nav-link 
                             {{ Route::is('employee.position') ? 'active' : '' }}">Position</a>
                     </nav>
                 </li>
                 <li class="nav-item {{ request()->is('attendance*') ? 'active' : '' }}">
                     <a href="" class="nav-link with-sub"><i class="typcn typcn-time"></i> Attendance</a>
                     <nav class="az-menu-sub">
                         <a href="{{ route('attendance.daily_attendance') }}"
                             class="nav-link {{ Route::is('attendance.daily_attendance') ? 'active' : '' }}">Daily
                             Attendace </a>
                         <a href="{{ route('attendance.attendance_log') }}"
                             class="nav-link {{ Route::is('attendance.attendance_log') ? 'active' : '' }}">Attendance
                             Logs </a>
                         <a href="{{ route('attendance.overtime_request') }}"
                             class="nav-link {{ Route::is('attendance.overtime_request') ? 'active' : '' }}">Overtime
                             Request</a>
                     </nav>
                 </li>
                 <li class="nav-item">
                     <a href="" class="nav-link with-sub"><i class="typcn typcn-credit-card"></i> Payrolls</a>
                     <nav class="az-menu-sub">
                         <a href="/" class="nav-link">Deduction & Allowance</a>
                         <a href="/" class="nav-link">Payroll Reports</a>
                     </nav>
                 </li>
                 <li class="nav-item {{ request()->is('leave*') ? 'active' : '' }}">
                     <a href="" class="nav-link with-sub"><i class="typcn typcn-calendar-outline"></i> Leave</a>
                     <nav class="az-menu-sub">
                         <a href="{{ route('leave.leave.create') }}"
                             class="nav-link {{ Route::is('leave.leave.create') ? 'active' : '' }}">Request Leave</a>
                         <a href="{{ route('leave.approval_page') }}"
                             class="nav-link {{ Route::is('leave.approval_page') ? 'active' : '' }}">Leave Approval</a>
                         <a href="{{ route('leave.leave.index') }}"
                             class="nav-link {{ Route::is('leave.leave.index') ? 'active' : '' }}">Leave History</a>
                     </nav>
                 </li>

                 <li class="nav-item {{ request()->is('report*') ? 'active' : '' }}">
                     <a href="" class="nav-link with-sub"><i class="typcn typcn-document-text"></i> Reports</a>
                     <nav class="az-menu-sub">
                         <a href="/" class="nav-link">Attendance Reports</a>
                         <a href="/" class="nav-link">Payrolls Reports</a>
                         <a href="{{ route('report.leave_report') }}"
                             class="nav-link {{ Route::is('report.leave_report') ? 'active' : '' }}">Leave Reports</a>
                         <a href="{{ route('report.overtime_report') }}"
                             class="nav-link {{ Route::is('report.overtime_report') ? 'active' : '' }}">Overtime
                             Reports</a>
                     </nav>
                 </li>
                 <li class="nav-item {{ request()->is('setting*') ? 'active' : '' }}">
                     <a href="" class="nav-link with-sub"><i class="typcn typcn-cog-outline"></i> Setting</a>
                     <nav class="az-menu-sub">
                         <a href="{{ route('setting.users.index') }}"
                             class="nav-link {{ Route::is('setting.users.index') ? 'active' : '' }}">Users</a>
                         <a href="{{ route('setting.role') }}"
                             class="nav-link {{ Route::is('setting.role') ? 'active' : '' }}">Role</a>
                         <a href="{{ route('setting.permission') }}"
                             class="nav-link {{ Route::is('setting.permission') ? 'active' : '' }}">Permission</a>
                     </nav>
                 </li>

             </ul>
         </div><!-- az-header-menu -->
         <div class="az-header-right">
             <div class="dropdown az-header-notification">
                 <a href="" class="new"><i class="typcn typcn-bell"></i></a>
                 <div class="dropdown-menu">
                     <div class="az-dropdown-header mg-b-20 d-sm-none">
                         <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                     </div>
                     <h6 class="az-notification-title">Notifications</h6>
                     <p class="az-notification-text">You have 2 unread notification</p>
                     <div class="az-notification-list">
                         <div class="media new">
                             <div class="az-img-user"><img src="/assets/img/faces/face2.jpg" alt=""></div>
                             <div class="media-body">
                                 <p>Congratulate <strong>Socrates Itumay</strong> for work anniversaries</p>
                                 <span>Mar 15 12:32pm</span>
                             </div><!-- media-body -->
                         </div><!-- media -->
                     </div><!-- az-notification-list -->
                     <div class="dropdown-footer"><a href="">View All Notifications</a></div>
                 </div><!-- dropdown-menu -->
             </div><!-- az-header-notification -->
             <div class="dropdown az-profile-menu">
                 <a href="" class="az-img-user"><img src="/assets/img/faces/face1.jpg" alt=""></a>
                 <div class="dropdown-menu">
                     <div class="az-dropdown-header d-sm-none">
                         <a href="" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                     </div>
                     <div class="az-header-profile">
                         <div class="az-img-user">
                             <img src="/assets/img/faces/face1.jpg" alt="">
                         </div><!-- az-img-user -->
                         <h6>{{ Auth::user()->name }}</h6>
                         <span>{{ Auth::user()->getRoleNames()->first() }}</span>
                     </div><!-- az-header-profile -->

                     <a href="" class="dropdown-item"><i class="typcn typcn-user-outline"></i> My
                         Profile</a>
                     <a href="" class="dropdown-item"><i class="typcn typcn-cog-outline"></i> Account
                         Settings</a>
                     <a href="{{ route('logout') }}" class="dropdown-item"><i class="typcn typcn-power-outline"></i>
                         Sign Out</a>
                 </div><!-- dropdown-menu -->
             </div>
         </div><!-- az-header-right -->
     </div><!-- container -->
 </div><!-- az-header -->
