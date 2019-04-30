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
          <div class="form-group">
              <label class="control-label {{ $errors->has('name') ? ' text-danger' : '' }}">Name</label>
              <input v-validate @click="validate()" class="form-control" type="text" name="name" placeholder="Your fullname" value="{{ old('name') }}" required autofocus>
              <span v-show="errors_field" style="display: none" class="text-danger"><strong>@{{ errors.first('name') }}</strong></span>
              @if ($errors->has('name'))
                  <span class="text-danger">
                      <strong>{{ $errors->first('name') }}</strong>
                  </span>
              @endif
          </div>
          <div class="form-group">
              <label class="control-label {{ $errors->has('email') ? ' text-danger' : '' }}">Student Email</label>
              <input v-model="student_email" @click="validate()" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" type="email" value="{{ old('email') }}" placeholder="Input your email address" required>
              <span v-show="errors_field" style="display: none" class="text-danger"><strong>@{{ student_email_validation_message }}</strong></span>
              @if ($errors->has('email'))
                    <span class="text-danger">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
              @endif   
          </div>           
          <div class="form-group">
              <label  class="control-label {{ $errors->has('password') ? ' text-danger' : '' }}">Password</label>
              <input v-validate="'required'" @click="validate()" class="form-control" type="password" name="password" placeholder="Input password" ref="password" required>
              <span v-show="errors_field" style="display: none" class="text-danger"><strong>@{{ errors.first('password') }}</strong></span>
              @if ($errors->has('password'))
                  <span class="text-danger">
                      <strong>{{ $errors->first('password') }}</strong>
                  </span>
              @endif
          </div>
          <div class="form-group">
              <label  class="control-label {{ $errors->has('password_confirmation') ? ' text-danger' : '' }}">Confirm Password</label>
              <input v-validate="'required|confirmed:password'" data-vv-as="password" @click="validate()" class="form-control" type="password" name="password_confirmation" placeholder="Confirm password" required>
              <span v-show="errors_field" style="display: none" class="text-danger"><strong>@{{ errors.first('password_confirmation') }}</strong></span>
              @if ($errors->has('password_confirmation'))
                  <span class="text-danger">
                      <strong>{{ $errors->first('password_confirmation') }}</strong>
                  </span>
              @endif
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

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/vee-validate/2.2.4/vee-validate.min.js"></script>
<script>
  Vue.use(VeeValidate)
  var app = new Vue({ 
      el: '#app',
      data: {
        errors_field: false,
        student_email: ''
      },
      methods: {
        validate(){
          this.errors_field = true
        }
      },
      computed: {
        // a computed getter
        student_email_validation_message: function () {
          var re = /^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/;
          if(this.student_email){
            if (re.test(this.student_email)) {
              allowed = ['students.','.edu'];
              if(this.student_email.includes(allowed[0] || allowed[1])){
                return ''
              }else{
                return 'Not a valid student e-mail address'
              }
            } else {
                return 'Not a valid e-mail address.';
            }
          }else{
            return 'Student email is required.';
          }
        }
      }
  });
</script>
@endsection
