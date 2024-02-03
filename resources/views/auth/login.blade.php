@extends('auth.main')

@section('content')
    <main class="main-content mt-0">
        <section>
            <div class="page-header min-vh-75">
                <div class="container">
                    <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                        <div class="card mt-8 bg-transparent shadow-lg">
                            <div class="card-header pb-0 text-left bg-transparent">
                                <h3 class="font-weight-bolder text-info text-gradient">Welcome back</h3>
                            </div>
                            {{--  ALERT  --}}
                            <div class="row mt-3 px-3">
                                <div class="col">
                                    @if (session()->has('success'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('success') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif

                                    @if (session()->has('failed'))
                                        <div class="alert alert-danger alert-dismissible shadow text-white" role="alert" style="border: none">
                                            {{ session('failed') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            {{--  ALERT  --}}
                            <div class="card-body">
                                <form role="form" method="POST" action="/login">
                                    @csrf
                                    <div class="mb-3">
                                        <label style="color: white">NIM</label>
                                        <input type="text" class="form-control bg-transparent" name="nim"
                                            id="nim" placeholder="nim" value="" aria-label="Email"
                                            aria-describedby="email-addon" style="color: white">
                                        @error('nim')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label style="color: white">Password</label>
                                        <input type="password" class="form-control bg-transparent" name="password"
                                            id="password" placeholder="Password" value="" aria-label="Password"
                                            aria-describedby="password-addon" style="color: white">
                                        @error('password')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="float-end ">
                                        <a href="/register" class="text-white">Belum Punya Akun?</a>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign in</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
        </section>
    </main>
@endsection
