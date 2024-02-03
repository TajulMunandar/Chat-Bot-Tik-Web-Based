@extends('auth.main')

@section('content')
    <main class="main-content mt-0">
        <section>
            <div class="page-header min-vh-75">
                <div class="container">
                    <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                        <div class="card mt-8 bg-transparent">
                            <div class="card-header pb-0 text-left bg-transparent">
                                <h3 class="font-weight-bolder text-info text-gradient">Register User</h3>
                            </div>
                            <div class="card-body">
                                <form role="form" method="POST" action="{{ route('register.store') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label style="color: white">name</label>
                                        <input type="name" class="form-control text-dark" name="name"
                                            id="name" placeholder="name" value="" aria-label="name"
                                            aria-describedby="name-addon" style="color: white">
                                        @error('name')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label style="color: white">username</label>
                                        <input type="username" class="form-control text-dark" name="username"
                                            id="username" placeholder="username" value="" aria-label="username"
                                            aria-describedby="username-addon" style="color: white">
                                        @error('username')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label style="color: white">Password</label>
                                        <input type="password" class="form-control text-dark" name="password"
                                            id="password" placeholder="Password" value="" aria-label="Password"
                                            aria-describedby="password-addon" style="color: white">
                                        @error('password')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="float-end ">
                                        <a href="/login" class="text-white">Sudah Punya Akun?</a>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign up</button>
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
