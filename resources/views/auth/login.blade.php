@extends('layouts.nowa',[
    'titlePage' => __('Login Page')
])

@section('content')
    <div class="page-single">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6 col-md-8 col-sm-8 col-xs-10 card-sigin-main mx-auto my-auto py-4 justify-content-center">
                    <div class="card-sigin">
                        <!-- Demo content-->
                        <div class="main-card-signin d-md-flex">
                            <div class="wd-100p"><div class="d-flex mb-4"><a href="index.html"><img src="{{ asset('nowa_assets') }}/img/brand/favicon.png" class="sign-favicon ht-40" alt="logo"></a></div>
                                <div class="">
                                    <div class="main-signup-header">
                                        <h2>Welcome back!</h2>
                                        <h6 class="font-weight-semibold mb-4">Please sign in to continue.</h6>
                                        <div class="panel panel-primary">

                                            <div class="panel-body tabs-menu-body border-0 p-3">
                                                <div class="tab-content">
                                                    <div class="tab-pane active">
                                                        <form method="POST" action="{{ route('login') }}">
                                                            @csrf
                                                            <div class="form-group">
                                                                <label for="username">{{ __('Username or Email') }}</label>
                                                                <input id="username" placeholder="Username atau Email" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                                            </div>
                                                            <div class="form-group">
                                                                <label for="password">{{ __('Password') }}</label>
                                                                <input id="password" placeholder="Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                                            </div>
                                                            <button type="submit" id="swal-login" class="btn btn-primary btn-block">Login</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="main-signin-footer text-center mt-3">
                                            <p><a href="{{ route('password.request') }}" class="mb-3">Forgot password?</a></p>
{{--                                            <p>Don't have an account? <a href="{{ route('form_register') }}">Create an Account</a></p>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
