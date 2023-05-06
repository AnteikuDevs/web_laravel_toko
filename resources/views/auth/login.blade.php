@extends('layouts.auth')
@section('content')
<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                <div class="d-flex justify-content-center py-4">
                    <a href="" class="logo d-flex align-items-center w-auto">
                        <span class="d-none d-lg-block">{{ env('APP_NAME') }}</span>
                    </a>
                </div><!-- End Logo -->

                <div class="card mb-3">

                    <div class="card-body">

                        <div class="pt-4 pb-2">
                            <h5 class="card-title text-center pb-0 fs-4">Masuk</h5>
                        </div>

                        <div id="alert-message"></div>

                        <form class="row g-3" id="login-form">

                            <div class="col-12">
                                <label for="input-email" class="form-label">Email</label>
                                <input type="text" name="email" class="form-control" id="input-email">
                                <div data-error="email"></div>
                            </div>

                            <div class="col-12">
                                <label for="input-password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" id="input-password">
                                <div data-error="password"></div>
                            </div>

                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" value="true"
                                        id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">Remember me</label>
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <button class="btn btn-primary w-100" type="submit">Login</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

</section>
@endsection
@push('script')
<script src="{{ asset('js/login.js') }}"></script>
@endpush