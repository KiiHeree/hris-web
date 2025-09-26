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
                 <li class="nav-item active show">
                     <a href="/" class="nav-link"><i class="typcn typcn-chart-area-outline"></i>
                         Dashboard</a>
                 </li>
                 <li class="nav-item">
                     <a href="" class="nav-link with-sub"><i class="typcn typcn-group-outline"></i> Employees</a>
                     <nav class="az-menu-sub">
                         <a href="{{ route('employee.employee') }}" class="nav-link">Employee Directory</a>
                         <a href="{{ route('employee.department') }}" class="nav-link">Departement</a>
                         <a href="{{ route('employee.position') }}" class="nav-link">Position</a>
                     </nav>
                 </li>
                 <li class="nav-item">
                     <a href="" class="nav-link with-sub"><i class="typcn typcn-time"></i> Attendance</a>
                     <nav class="az-menu-sub">
                         <a href="/" class="nav-link">Daily Attendace </a>
                         <a href="/" class="nav-link">Attendance Logs </a>
                         <a href="/" class="nav-link">Overtime Request</a>
                     </nav>
                 </li>
                 <li class="nav-item">
                     <a href="" class="nav-link with-sub"><i class="typcn typcn-credit-card"></i> Payrolls</a>
                     <nav class="az-menu-sub">
                         <a href="/" class="nav-link">Deduction & Allowance</a>
                         <a href="/" class="nav-link">Payroll Reports</a>
                     </nav>
                 </li>
                 <li class="nav-item">
                     <a href="" class="nav-link with-sub"><i class="typcn typcn-calendar-outline"></i> Leave</a>
                     <nav class="az-menu-sub">
                         <a href="/" class="nav-link">Request Leave</a>
                         <a href="/" class="nav-link">Leave Approval</a>
                         <a href="/" class="nav-link">Leave History</a>
                     </nav>
                 </li>

                 <li class="nav-item">
                     <a href="" class="nav-link with-sub"><i class="typcn typcn-document-text"></i> Reports</a>
                     <nav class="az-menu-sub">
                         <a href="/" class="nav-link">Attendance Reports</a>
                         <a href="/" class="nav-link">Payrolls Reports</a>
                         <a href="/" class="nav-link">Leave Reports</a>
                         <a href="/" class="nav-link">Overtime Reports</a>
                     </nav>
                 </li>
                 <li class="nav-item">
                     <a href="" class="nav-link with-sub"><i class="typcn typcn-cog-outline"></i> Setting</a>
                     <nav class="az-menu-sub">
                         <a href="/" class="nav-link">Users</a>
                         <a href="{{ route('setting.role') }}" class="nav-link">Role</a>
                         <a href="{{ route('setting.permission') }}" class="nav-link">Permission</a>
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
