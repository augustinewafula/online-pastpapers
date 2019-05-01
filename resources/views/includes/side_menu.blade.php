<!-- Sidebar menu-->
  <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
  <aside class="app-sidebar">
    <a href="{{ route('profile') }}" style="text-decoration: none">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="{{ asset('img/avatar.png') }}" width="48" alt="User Image">
        <div style="overflow: hidden; text-overflow: ellipsis; ">
          <p class="app-sidebar__user-name">{{Auth()->user()->name}}</p>
          <p class="app-sidebar__user-designation">{{Auth()->user()->email}}</p>
        </div>
      </div>
    </a>
    <ul class="app-menu">
      <li><a class="app-menu__item {{ Route::currentRouteNamed('home') ? 'active' : '' }}" href="{{ route('home') }}"><i class="app-menu__icon fa fa-home"></i><span class="app-menu__label">Home</span></a></li>
      <li><a class="app-menu__item {{ Route::currentRouteNamed('sampleExam.index') ? 'active' : '' }}" href="{{ route('sampleExam.index') }}"><i class="app-menu__icon fa fa-home"></i><span class="app-menu__label">Sample Exam </span></a></li>
    </ul>
  </aside>