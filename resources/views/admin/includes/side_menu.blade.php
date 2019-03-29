<!-- Sidebar menu-->
  <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
  <aside class="app-sidebar">
    <div class="app-sidebar__user">
      <div>
        <p class="app-sidebar__user-name">Admin</p>
        {{--<p class="app-sidebar__user-designation"></p>TODO:: show the user role here..--}}
      </div>
    </div>
    <ul class="app-menu">
      <li><a class="app-menu__item {{ Route::currentRouteNamed('home') ? 'active' : '' }}" href="{{ route('home') }}"><i class="app-menu__icon fa fa-home"></i><span class="app-menu__label">Home</span></a></li>
      <li><a class="app-menu__item {{ Route::currentRouteNamed('pastpapers.index') ? 'active' : '' || Route::currentRouteNamed('pastpapers.create') ? 'active' : ''}}" href="{{ route('pastpapers.index') }}"><i class="app-menu__icon 	fa fa-clipboard"></i><span class="app-menu__label">Pastpapers</span></a></li>
    </ul>
  </aside>