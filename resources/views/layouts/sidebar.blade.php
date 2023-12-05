{{-- Sidebar --}}
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      {{-- <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="Benjas Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
      <img src="{{ asset('dist/img/benjas_logo_white.png') }}" alt="Benjas Logo" class="brand-image img-rounded elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">SMS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          {{-- <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image"> --}}
          @if (!empty(Auth::user()->profile_picture))
              <img src="{{ asset('upload/profile') }}/{{ Auth::user()->profile_picture }}" class="img-circle elevation-2" alt="User Image">
          @else
              <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
          @endif
          
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->



               {{-- SIDEBAR FOR ADMIN --}}
               @if (Auth::user()->user_type == 1)
                {
                  {{-- <li class="nav-header">Dashboard</li> --}}
                    <li class="nav-item">
                      <a href="{{ url('admin/dashboard') }}"  class="nav-link @if(Request::segment(2) == 'dashboard') active @endif">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                          Dashboard 
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="{{ url('admin/admin/list') }}" class="nav-link @if(Request::segment(2) == 'admin') active @endif">
                        <i class="nav-icon far fa-user"></i>
                        <p>
                          Admin
                        </p>
                      </a>
                    </li>


                    <li class="nav-item">
                      <a href="{{ url('admin/teacher/list') }}" class="nav-link @if(Request::segment(2) == 'teacher') active @endif">
                        <i class="nav-icon far fa-user"></i>
                        <p>
                          Teacher
                        </p>
                      </a>
                    </li>


                    <li class="nav-item">
                      <a href="{{ url('admin/student/list') }}" class="nav-link @if(Request::segment(2) == 'student') active @endif">
                        <i class="nav-icon far fa-user"></i>
                        <p>
                          Student
                        </p>
                      </a>
                    </li>


                    <li class="nav-item">
                      <a href="{{ url('admin/parent/list') }}" class="nav-link @if(Request::segment(2) == 'parent') active @endif">
                        <i class="nav-icon far fa-user"></i>
                        <p>
                          Parent
                        </p>
                      </a>
                    </li>


                    <li class="nav-item @if(Request::segment(2) == 'class' || Request::segment(2) == 'subject' || Request::segment(2) == 'assign_subject' || Request::segment(2) == 'assign_class_teacher' || Request::segment(2) == 'class_timetable') menu-is-opening menu-open @endif">
                      <a href="#" class="nav-link @if(Request::segment(2) == 'class' || Request::segment(2) == 'subject' || Request::segment(2) == 'assign_subject' || Request::segment(2) == 'assign_class_teacher' || Request::segment(2) == 'class_timetable') active @endif">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                          Academics
                          <i class="fas fa-angle-left right"></i>
                        </p>
                      </a>
                      <ul class="nav nav-treeview">

                        <li class="nav-item">
                          <a href="{{ url('admin/class/list') }}" class="nav-link @if(Request::segment(2) == 'class') active @endif">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Class</p>
                          </a>
                        </li>

                        <li class="nav-item">
                          <a href="{{ url('admin/subject/list') }}" class="nav-link @if(Request::segment(2) == 'subject') active @endif">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Subject</p>
                          </a>
                        </li>

                        <li class="nav-item">
                          <a href="{{ url('admin/assign_subject/list') }}" class="nav-link @if(Request::segment(2) == 'assign_subject') active @endif">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Assign Subject</p>
                          </a>
                        </li>

                        <li class="nav-item">
                          <a href="{{ url('admin/class_timetable/list') }}" class="nav-link @if(Request::segment(2) == 'class_timetable') active @endif">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Class Timetable</p>
                          </a>
                        </li>

                        <li class="nav-item">
                          <a href="{{ url('admin/assign_class_teacher/list') }}" class="nav-link @if(Request::segment(2) == 'assign_class_teacher') active @endif">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Assign Class Teacher</p>
                          </a>
                        </li>

                      </ul>
                    </li>



                    <li class="nav-item @if(Request::segment(2) == 'examinations') menu-is-opening menu-open @endif">
                      <a href="#" class="nav-link @if(Request::segment(2) == 'examinations') active @endif">
                        <i class="nav-icon fas fa-table"></i>
                        <p>
                          Examinations
                          <i class="fas fa-angle-left right"></i>
                        </p>
                      </a>
                      <ul class="nav nav-treeview">

                        <li class="nav-item">
                          <a href="{{ url('admin/examinations/exam/list') }}" class="nav-link @if(Request::segment(3) == 'exam') active @endif">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Exam</p>
                          </a>
                        </li>


                        <li class="nav-item">
                          <a href="{{ url('admin/examinations/exam_schedule') }}" class="nav-link @if(Request::segment(3) == 'exam_schedule') active @endif">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Exam Schedule</p>
                          </a>
                        </li>

                        

                      </ul>
                    </li>
                    


                    <li class="nav-item">
                      <a href="{{ url('admin/account') }}" class="nav-link @if(Request::segment(2) == 'account') active @endif">
                        <i class="nav-icon far fa-user"></i>
                        <p>
                          My Account
                        </p>
                      </a>
                    </li>


                    <li class="nav-item">
                      <a href="{{ url('admin/change_password') }}" class="nav-link @if(Request::segment(2) == 'change_password') active @endif">
                        <i class="nav-icon far fa-user"></i>
                        <p>
                          Change Password
                        </p>
                      </a>
                    </li>

                }

               
                {{-- SIDEBAR FOR TEACHER --}}
               @elseif (Auth::user()->user_type == 2)
               {
                  <li class="nav-item">
                    <a href="{{ url('teacher/dashboard') }}" class="nav-link @if(Request::segment(2) == 'dashboard') active @endif">
                      <i class="nav-icon fas fa-tachometer-alt"></i>
                      <p>
                        Dashboard
                      </p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="{{ url('teacher/my_student') }}" class="nav-link @if(Request::segment(2) == 'my_student') active @endif">
                      <i class="nav-icon far fa-user"></i>
                      <p>
                        My Students
                      </p>
                    </a>
                  </li>


                  <li class="nav-item">
                    <a href="{{ url('teacher/my_class_subject') }}" class="nav-link @if(Request::segment(2) == 'my_class_subject') active @endif">
                      <i class="nav-icon far fa-user"></i>
                      <p>
                        My Class & Subjects
                      </p>
                    </a>
                  </li>


                  <li class="nav-item">
                    <a href="{{ url('teacher/my_exam_timetable') }}" class="nav-link @if(Request::segment(2) == 'my_exam_timetable') active @endif">
                      <i class="nav-icon far fa-user"></i>
                      <p>
                        My Exam Timetable
                      </p>
                    </a>
                  </li>


                  <li class="nav-item">
                    <a href="{{ url('teacher/account') }}" class="nav-link @if(Request::segment(2) == 'account') active @endif">
                      <i class="nav-icon far fa-user"></i>
                      <p>
                        My Account
                      </p>
                    </a>
                  </li>


                  <li class="nav-item">
                    <a href="{{ url('teacher/change_password') }}" class="nav-link @if(Request::segment(2) == 'change_password') active @endif">
                      <i class="nav-icon far fa-user"></i>
                      <p>
                        Change Password
                      </p>
                    </a>
                  </li>


               }


               {{-- SIDEBAR FOR STUDENT --}}
               @elseif (Auth::user()->user_type == 3)
               {
                <li class="nav-item">
                  <a href="{{ url('student/dashboard') }}" class="nav-link @if(Request::segment(2) == 'dashboard') active @endif">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                      Dashboard
                    </p>
                  </a>
                </li>


                <li class="nav-item">
                  <a href="{{ url('student/my_subject') }}" class="nav-link @if(Request::segment(2) == 'my_subject') active @endif">
                    <i class="nav-icon far fa-user"></i>
                    <p>
                      My Subjects
                    </p>
                  </a>
                </li>


                <li class="nav-item">
                  <a href="{{ url('student/my_timetable') }}" class="nav-link @if(Request::segment(2) == 'my_timetable') active @endif">
                    <i class="nav-icon far fa-user"></i>
                    <p>
                      My Timetable
                    </p>
                  </a>
                </li>


                <li class="nav-item">
                  <a href="{{ url('student/my_exam_timetable') }}" class="nav-link @if(Request::segment(2) == 'my_exam_timetable') active @endif">
                    <i class="nav-icon far fa-user"></i>
                    <p>
                      My Exam Timetable
                    </p>
                  </a>
                </li>


                <li class="nav-item">
                  <a href="{{ url('student/account') }}" class="nav-link @if(Request::segment(2) == 'account') active @endif">
                    <i class="nav-icon far fa-user"></i>
                    <p>
                      My Account
                    </p>
                  </a>
                </li>



                <li class="nav-item">
                  <a href="{{ url('student/change_password') }}" class="nav-link @if(Request::segment(2) == 'change_password') active @endif">
                    <i class="nav-icon far fa-user"></i>
                    <p>
                      Change Password
                    </p>
                  </a>
                </li>


               }



               {{-- SIDEBAR FOR PARENT --}}
               @elseif (Auth::user()->user_type == 4)
               {
                <li class="nav-item">
                  <a href="{{ url('parent/dashboard') }}" class="nav-link @if(Request::segment(2) == 'dashboard') active @endif">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                      Dashboard
                    </p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ url('parent/my_student') }}" class="nav-link @if(Request::segment(2) == 'my_student') active @endif">
                    <i class="nav-icon far fa-user"></i>
                    <p>
                      My Student
                    </p>
                  </a>
                </li>


                <li class="nav-item">
                  <a href="{{ url('parent/account') }}" class="nav-link @if(Request::segment(2) == 'account') active @endif">
                    <i class="nav-icon far fa-user"></i>
                    <p>
                      My Account
                    </p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ url('parent/change_password') }}" class="nav-link @if(Request::segment(2) == 'change_password') active @endif">
                    <i class="nav-icon far fa-user"></i>
                    <p>
                      Change Password
                    </p>
                  </a>
                </li>


               }


               @endif
          
          

          <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link">
              <i class="nav-icon far fa-user"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>