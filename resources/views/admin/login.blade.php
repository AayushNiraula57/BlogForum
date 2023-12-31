@extends('admin.layouts.layout')
@section('title','Admin Login')

@section('content')
    <main class="login-form">
        <div class="cotainer">
            <div class="row justify-content-center mt-4">
                <div class="col-md-4">
                    <div class="card">
                        <h3 class="card-header text-center">Admin Login</h3>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.login_custom') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Email" id="email" class="form-control" name="email">
                                    @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <input type="password" placeholder="Password" id="password" class="form-control" name="password">
                                    @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                                <div class="d-grid mx-auto">
                                    <button type="submit" class="btn btn-dark btn-block">Signin</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

