@extends('layouts.app')

@section('title')
    <title>Student Reset Password - Online Pastpapers</title>
@endsection

@section('content')
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h1>Reset Password</h1>
      </div>
      <div class="email-box">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif        
        <form class="forget-form" method="POST" action="{{ route('password.email') }}">
          {{ csrf_field() }}
          <h3 class="login-head">
            <i class="fa fa-lg fa-fw fa-lock"></i><br>
            Student
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
          <div class="form-group btn-container">
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>RESET</button>
          </div>
          <div class="form-group mt-3">
            <p class="semibold-text mb-0"><a href="{{ route('login') }}" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Back to Login</a></p>
          </div>
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
