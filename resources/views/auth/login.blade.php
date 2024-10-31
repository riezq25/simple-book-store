@extends('layouts.auth')

@section('content')
    <h4 class="mb-1">Welcome to AMD Store! 👋</h4>
    <p class="mb-6">Please sign-in to your account and start the adventure</p>

    @include('layouts.partials.error-message')

    <form id="formAuthentication" class="mb-6" method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-6">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}"
                placeholder="Enter your email" autofocus />
        </div>
        <div class="mb-6 form-password-toggle">
            <label class="form-label" for="password">Password</label>
            <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control" name="password" aria-describedby="password" />
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div>
        </div>
        <div class="mb-8">
            <div class="d-flex justify-content-between mt-8">
                <div class="form-check mb-0 ms-2">
                    <input class="form-check-input" type="checkbox" id="remember" />
                    <label class="form-check-label" for="remember"> Remember Me </label>
                </div>
            </div>
        </div>
        <div class="mb-6">
            <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
        </div>
    </form>

    <p class="text-center">
        <span>New on our platform?</span>
        <a href="{{ route('register') }}">
            <span>Create an account</span>
        </a>
    </p>
@endsection
