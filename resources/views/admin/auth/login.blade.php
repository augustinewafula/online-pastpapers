@extends('layouts.app')

@section('title')
  <title>Admin Login - Online Pastpapers</title>
@endsection

@section('content')
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h1>Login</h1>
      </div>
      <div class="login-box">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif 
        <form class="login-form" method="POST" action="{{ route('admin_login') }}">
           @csrf
          <h3 class="login-head">
            <i class="fa fa-lg fa-fw fa-user"></i><br>
              Admin
          </h3>
          <div class="form-group">
            <label class="control-label {{ $errors->has('question') ? ' text-danger' : '' }}">Email</label>
            <input v-validate class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" type="email" value="{{ old('email') }}" placeholder="Input your email address" required>
            <span v-show="errors_field" style="display: none" class="text-danger"><strong>@{{ errors.first('email') }}</strong></span>
            @if ($errors->has('email'))
                <span class="text-danger">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif  
          </div>
          <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label class="control-label">Password</label>
            <input v-validate class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" name="password" placeholder="Input password" required>
            <span v-show="errors_field" style="display: none" class="text-danger"><strong>@{{ errors.first('password') }}</strong></span>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group">
            <div class="utility">
              <div class="animated-checkbox">
                <label>
                  <input type="checkbox"><span class="label-text" name="remember" {{ old('remember') ? 'checked' : ''}}>Remember me</span>
                </label>
              </div>
              <p class="semibold-text mb-2"><a href="{{ route('admin_password.request') }}">Forgot Password ?</a></p>
            </div>
          </div>
          <div class="form-group btn-container">
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN</button>
          </div><br>
        </form>
      </div>
    </section>
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
@endsection