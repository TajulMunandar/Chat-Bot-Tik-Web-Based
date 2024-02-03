@extends('layout.main')

@section('content')
    <div class="container">
        {{--  ALERT  --}}
        <div class="row mt-3">
            <div class="col">
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session()->has('failed'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('failed') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>
        {{--  ALERT  --}}
        {{--  CONTENT  --}}
        <div class="row mt-3 mb-5">
            <div class="col">
                <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class=""><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                        </svg></i>
                    Tambah
                </button>

                <div class="card mt-3 col-sm-6 col-md-12 mb-3">
                    <div class="card-body">
                        {{-- tables --}}
                        <table id="myTable" class="table responsive nowrap table-bordered table-striped align-middle"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>NIM</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->nim }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>
                                            @if ($user->isAdmin == 1)
                                                Admin
                                            @else
                                                User
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-dark" data-bs-toggle="modal"
                                                data-bs-target="#pswdModal{{ $loop->iteration }}">
                                                <i class="fa-solid fa-lock"></i>
                                            </button>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $loop->iteration }}">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <button id="delete-button" class="btn btn-danger" id="delete-button"
                                                data-bs-toggle="modal" data-bs-target="#hapusModal{{ $loop->iteration }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    {{--  MODAL Delete  --}}
                                    <div class="modal fade" id="hapusModal{{ $loop->iteration }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data User</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('user.destroy', $user->id) }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @method('delete')
                                                    @csrf
                                                    <div class="modal-body">
                                                        <p>Apakah Anda Yakin Ingin Menghapus Data
                                                            <b>{{ $user->name }}</b>
                                                            ini?
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-danger">hapus
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    {{--  MODAL Delete  --}}

                                    {{-- Modal Edit --}}
                                    <div class="modal fade" id="editModal{{ $loop->iteration }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Data User</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('user.update', $user->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @method('put')
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="mb-3">
                                                                <label for="name" class="form-label">Nama</label>
                                                                <input type="text"
                                                                    class="form-control @error('name') is-invalid @enderror"
                                                                    name="name" id="name" placeholder="Anton"
                                                                    value="{{ old('name', $user->name) }}" autofocus
                                                                    required>
                                                                @error('name')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nim" class="form-label">NIM</label>
                                                                <input type="text" class="form-control @error('nim') is-invalid @enderror"
                                                                    name="nim" id="nim"
                                                                    value="{{ old('nim', $user->nim) }}"
                                                                    placeholder="anton" autofocus required>
                                                                @error('nim')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="username" class="form-label">Username</label>
                                                                <input type="text"
                                                                    class="form-control @error('username') is-invalid @enderror"
                                                                    name="username" id="username" placeholder="anton"
                                                                    value="{{ old('username', $user->username) }}"
                                                                    autofocus required>
                                                                @error('username')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="isAdmin" class="form-label">Role</label>
                                                                <select
                                                                    class="form-select @error('isAdmin') is-invalid @enderror"
                                                                    aria-label="Default select example" name="isAdmin">
                                                                    <option value="1"
                                                                        @if (old('isAdmin', $user->isAdmin) == 1) selected @endif>
                                                                        Admin</option>
                                                                    <option value="0"
                                                                        @if (old('isAdmin', $user->isAdmin) == 0) selected @endif>
                                                                        User</option>
                                                                </select>
                                                                @error('isAdmin')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-warning">Perbarui</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Modal Edit --}}

                                    {{-- Modal Edit Password --}}
                                    <div class="modal fade" id="pswdModal{{ $loop->iteration }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Ubah Password User</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('user.password') }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="mb-3">
                                                                <input type="hidden" name="id" id="">
                                                                <label for="password" class="form-label">Password
                                                                    Baru</label>
                                                                <input type="text"
                                                                    class="form-control @error('password') is-invalid @enderror"
                                                                    name="password" id="password" autofocus required>
                                                                @error('password')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="password2" class="form-label">Konfirmasi
                                                                    Password</label>
                                                                <input type="text"
                                                                    class="form-control @error('password2') is-invalid @enderror"
                                                                    name="password2" id="password2" autofocus required>
                                                                @error('password2')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-dark">Perbarui</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Modal Edit Password --}}
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{--  CONTENT  --}}

        {{--  MODAL ADD  --}}
        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Data User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" id="name" placeholder="Anton" autofocus required>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nim" class="form-label">NIM</label>
                                    <input type="text" class="form-control @error('nim') is-invalid @enderror"
                                        name="nim" id="nim" placeholder="anton" autofocus required>
                                    @error('nim')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div>
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror"
                                        name="username" id="username" placeholder="anton" autofocus required>
                                    @error('username')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        name="password" id="password" placeholder="anton" autofocus required>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{-- {{ $message }} --}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="isAdmin" class="form-label">Role</label>
                                    <select class="form-select @error('name') is-invalid @enderror"
                                        aria-label="Default select example" name="isAdmin">
                                        <option selected>Pilih Role</option>
                                        <option value="1">Admin</option>
                                        <option value="0">User</option>
                                    </select>
                                    @error('isAdmin')
                                        <div class="invalid-feedback">
                                            {{-- {{ $message }} --}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{--  MODAL ADD  --}}

    </div>

@section('scripts')
    <script>
        $(document).ready(function() {
            // Simpan ikon di dalam tag HTML
            var prevIcon = '<i class="fa-solid fa-chevron-left"></i>';
            var nextIcon = '<i class="fa-solid fa-chevron-right"></i>';

            // Ganti teks "Previous" dengan ikon saat dokumen pertama kali dimuat
            $('.page-link:contains("Previous")').html(prevIcon);

            // Ganti teks "Next" dengan ikon saat dokumen pertama kali dimuat
            $('.page-link:contains("Next")').html(nextIcon);

            // Tambahkan event handler untuk setiap kali tabel di-redraw
            $('#myTable').on('draw.dt', function() {
                // Ganti teks "Previous" dengan ikon setiap kali tabel di-redraw
                $('.page-link:contains("Previous")').html(prevIcon);

                // Ganti teks "Next" dengan ikon setiap kali tabel di-redraw
                $('.page-link:contains("Next")').html(nextIcon);
            });
        });
    </script>
@endsection
@endsection
