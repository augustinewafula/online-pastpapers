@extends('layouts.app')

@section('title')
    <title>Profile - Online Pastpapers</title>
@endsection

@section('content')
@include('admin.includes.header')
@include('admin.includes.side_menu')
<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-home"></i> Profile</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.profile') }}">Profile</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-6">
          <div class="tile">   
                <h6>Update Name</h6>            
            <div class="tile-body">
              <form id="form" method="POST" autocomplete="off" action="{{ route('admin.update_name') }}">
                @csrf
                 <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" value="{{Auth('admin')->user()->name}}" placeholder="Your name" name="name" required/>  
                    @if ($errors->has('name'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                    </div>
                   </div>  
                  </div>        
                  <div class="tile-footer">
                    <button class="btn btn-primary" type="submit">Update</button>
                  </div>
              </form>              
            </div>
          </div>
        </div>
        <div class="col-md-6">
            <div class="tile">   
                <h6>Update Email</h6>            
                <div class="tile-body">
                <form id="form" method="POST" autocomplete="off" action="{{ route('admin.update_email') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                        <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" value="{{Auth('admin')->user()->email}}" placeholder="Your email address" name="email" required/>  
                        @if ($errors->has('email'))
                            <span class="text-danger">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                        </div>
                        </div> 
                    </div>        
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit">Update</button>
                    </div>
                </form>              
                </div>
            </div>
        </div>        
      </div>
      <div class="row">
        <div class="col-md-6">
            <div class="tile">    
                <h6>Update Password</h6>          
            <div class="tile-body">
                <form id="form" method="POST" autocomplete="off" action="{{ route('admin.update_password') }}">
                @csrf
                <div class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
                    <label>Current Password</label>
                    <input type="password" class="form-control" placeholder="Your current password" name="current_password" required/>  
                    @if ($errors->has('current_password'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('current_password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label  class="control-label {{ $errors->has('new_password') ? ' text-danger' : '' }}">New Password</label>
                    <input v-validate="'required|min:6'" class="form-control" type="password" name="new_password" placeholder="Input new password" ref="password" required>
                    <span v-show="errors_field" style="display: none" class="text-danger"><strong>@{{ errors.first('password') }}</strong></span>
                    @if ($errors->has('new_password'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('new_password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label  class="control-label {{ $errors->has('new_password_confirmation') ? ' text-danger' : '' }}">Confirm Password</label>
                    <input v-validate="'required|confirmed:password'" data-vv-as="password" class="form-control" type="password" name="new_password_confirmation" placeholder="Confirm password" required>
                    <span v-show="errors_field" style="display: none" class="text-danger"><strong>@{{ errors.first('new_password_confirmation') }}</strong></span>
                    @if ($errors->has('new_password_confirmation'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('new_password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>                         
                <div class="tile-footer">
                <button class="btn btn-primary" type="submit">Update</button>
                </div>
                </form>              
            </div>
            </div>
        </div>
        </div>
    
</main>
@endsection
@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/vee-validate/2.2.4/vee-validate.min.js"></script>
<script>
  Vue.use(VeeValidate)
  var app = new Vue({ 
      el: '#app',
      data: {
        errors_field: true
      }
  });
</script>
@if (session('status'))
    <script type="text/javascript" src="{{ asset('js/plugins/bootstrap-notify.min.js') }}"></script>
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