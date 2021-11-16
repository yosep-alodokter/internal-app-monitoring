@extends('layouts.skote.master-without-nav')
@section('title')
Login
@endsection
@section('body')
<body>
   @endsection
   @section('content')
   <div class="account-pages my-5 pt-sm-5">
      <div class="container">
         <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
               <div class="card overflow-hidden">
                  <div class="bg-primary bg-soft">
                     <div class="row">
                        <div class="col-7">
                           <div class="text-primary p-4">
                              <h5 class="text-primary">Welcome Back !</h5>
                              <p>Sign in to App.</p>
                           </div>
                        </div>
                        <div class="col-5 align-self-end">
                           <img src="{{ URL::asset('/assets/images/profile-img.png') }}" alt=""
                              class="img-fluid">
                        </div>
                     </div>
                  </div>
                  <div class="card-body pt-0">
                     <div class="auth-logo">
                        <a href="{{ route('login') }}" class="auth-logo-light">
                           <div class="avatar-md profile-user-wid mb-4">
                              <span class="avatar-title rounded-circle bg-light">
                              <img src="{{ URL::asset('/assets/images/logo-light.svg') }}" alt=""
                                 class="rounded-circle" height="34">
                              </span>
                           </div>
                        </a>
                        <a href="{{ route('login') }}" class="auth-logo-dark">
                           <div class="avatar-md profile-user-wid mb-4">
                              <span class="avatar-title rounded-circle bg-light">
                              <img src="{{ app('file.helper')->getFileUrl('alodokter_logo.jpeg', 'main_image') }}" alt=""
                                 class="rounded-circle" height="60">
                              </span>
                           </div>
                        </a>
                     </div>
                     <div class="p-2">
                        <form class="form-horizontal" method="POST" action="{{ route('process-login') }}">
                           @csrf
                           <div class="mb-3">
                              <label class="form-label">Email</label>
                              <input name="email" type="input"
                                 class="form-control" value="" placeholder="Enter email" autofocus>

                           </div>
                           <div class="mb-3">
                              <label class="form-label">Password</label>
                              <div
                                 class="input-group auth-pass-inputgroup">
                                 <input type="password" name="password"
                                    class="form-control" placeholder="Enter password"
                                    aria-label="Password" aria-describedby="password-addon">
                                 <button class="btn btn-light " type="button" id="password-addon"><i
                                    class="mdi mdi-eye-outline"></i></button>
                              </div>
                           </div>

                           <div class="mt-3 d-grid">
                                <button class="btn btn-primary waves-effect waves-light" type="submit">Log
                                    In</button>
                            </div>
                        </form>
                        <br/>
                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> {{ $error }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endforeach
                        @endif
                     </div>
                  </div>
               </div>
               <div class="mt-5 text-center">
                  <div>
                     <p>
                        © <script>
                           document.write(new Date().getFullYear())
                           
                        </script> | Alodokter
                     </p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- end account-pages -->
   @endsection