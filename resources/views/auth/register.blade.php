@extends('layouts.app')

@section('title')
    <title>Student Register - Online Pastpapers</title>
@endsection

@section('content')
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h1>Register</h1>
      </div>
      <div class="register-box">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif   
        <form class="register-form" method="POST" action="{{ route('register') }}">
           @csrf
          <h3 class="register-head">
              <i class="fa fa-lg fa-fw fa-user"></i><br>
              Student
          </h3>
          <div class="row">
            <div class="col-md-6">
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label class="control-label">Name</label>
                    <input class="form-control" type="text" name="name" placeholder="Your fullname" value="{{ old('name') }}" required autofocus>
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label class="control-label">Student Email</label>
                    <input class="form-control" type="text" name="email" placeholder="Your student email address" value="{{ old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
           </div>
           
          <div class="row">
              <div class="col-md-6">
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="control-label">Password</label>
                    <input class="form-control" type="password" name="password" placeholder="Input password" required>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <label class="control-label">Confirm Password</label>
                    <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm password" required>
                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>
              </div>
          </div><br>
          <div class="form-group btn-container">
            <center>
                <button type="submit" class="btn btn-primary btn-block col-md-6"><i class="fa fa-sign-in fa-lg fa-fw"></i>SUBMIT</button>
            </center>
          </div><br>
          <div class="form-group">
            <div class="utility">
              <p class="semibold-text mb-2"><a href="{{ route('login_form') }}">Already have an account?</a></p>
            </div>
          </div>
          
        </form>
      </div>
    </section>
@endsection
