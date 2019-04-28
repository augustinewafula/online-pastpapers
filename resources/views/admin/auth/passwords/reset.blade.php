@extends('layouts.app')

@section('title')
    <title>Reset Password - Online Pastpapers</title>
@endsection

@section('content')
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h1>Reset Password</h1>
      </div>
      <div class="reset-box">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif 
        <form class="login-form" method="POST" action="{{ route('admin_password.update') }}">
           {{ csrf_field() }}

            <input type="hidden" name="token" value="{{ $token }}">
            <h3 class="login-head">
                <i class="fa fa-lg fa-fw fa-user"></i><br>
                Student
            </h3>
            <div class="form-group">
                <label class="control-label {{ $errors->has('question') ? ' text-danger' : '' }}">Email</label>
                <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" type="email" value="{{ old('email') }}" placeholder="Input your email address" required>
                @if ($errors->has('email'))
                    <span class="text-danger">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif  
            </div>
            <div class="form-group">
                <label class="control-label {{ $errors->has('password') ? ' text-danger' : '' }}">Password</label>
                <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" type="password" placeholder="Input password" required>
                @if ($errors->has('password'))
                    <span class="text-danger">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif  
            </div>
            <div class="form-group">
                <label class="control-label {{ $errors->has('password_confirmation') ? ' text-danger' : '' }}">Confirm Password</label>
                <input class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" type="password" placeholder="Confirm password" required>
                @if ($errors->has('password_confirmation'))
                    <span class="text-danger">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif  
            </div>
            <div class="form-group btn-container">
                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>SUBMIT</button>
            </div>
        </form>
      </div>
    </section>
@endsection
