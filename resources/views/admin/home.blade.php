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
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 home-widget">
          <a href="{{ route('home') }}" >
            <div class="widget-small danger coloured-icon"><i class="icon fa fa-university fa-3x"></i>
              <div class="info">
                <h4>Properties</h4>
                <p><b>4</b></p>
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