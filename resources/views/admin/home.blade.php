@extends('layouts.app')

@section('title')
    <title>Home - Online Pastpapers</title>
@endsection

@section('content')
@include('admin.includes.header')
@include('admin.includes.side_menu')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-home"></i> Home</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 home-widget">
          <a href="{{ route('pastpapers.index') }}" >
            <div class="widget-small primary coloured-icon"><i class="icon fa fa-book fa-3x"></i>
              <div class="info">
                <h4>Total Pastpapers</h4>
                <p><b>{{$pastpapersCount}}</b></p>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-6 col-lg-3 home-widget">
          <a href="{{ route('units.index') }}" >
            <div class="widget-small primary coloured-icon"><i class="icon fa fa-clone fa-3x"></i>
              <div class="info">
                <h4>Total Units</h4>
                <p><b>{{$unitsCount}}</b></p>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-6 col-lg-3 home-widget">
          <a href="{{ route('departments.index') }}" >
            <div class="widget-small primary coloured-icon"><i class="icon fa fa-clipboard fa-3x"></i>
              <div class="info">
                <h4>Total Departments</h4>
                <p><b>{{$departmentsCount}}</b></p>
              </div>
            </div>
          </a>
        </div>
        <div class="col-md-6 col-lg-3 home-widget">
          <a href="{{ route('admins.index') }}" >
            <div class="widget-small primary coloured-icon"><i class="icon fa fa-users fa-3x"></i>
              <div class="info">
                <h4>Total Admins</h4>
                <p><b>{{$adminsCount}}</b></p>
              </div>
            </div>
          </a>
        </div>
    </div>
</main>
@endsection
@section('scripts')
@if (session('status'))
    <script type="text/javascript">
      $.notify({
            title: "Success : ",
            message: "{{ session('status') }}",
            icon: 'fa fa-check' 
          },{
            type: "info"
      });
    </script>        
@endif   
@endsection