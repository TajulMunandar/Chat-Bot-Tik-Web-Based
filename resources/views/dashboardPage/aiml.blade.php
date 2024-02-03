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
                                    <th>Category</th>
                                    <th>Patern</th>
                                    <th>Template</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($aimls as $aiml)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $aiml->category }}</td>
                                        <td>{{ $aiml->patern }}</td>
                                        <td>{{ $aiml->template }}</td>
                                        <td>
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
                                                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data Aiml</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('aiml.destroy', $aiml->id) }}"
                                                    method="post" enctype="multipart/form-data">
                                                    @method('delete')
                                                    @csrf
                                                    <div class="modal-body">
                                                        <p>Apakah Anda Yakin Ingin Menghapus Data
                                                            <b>{{ $aiml->category }}</b>
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
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Aiml</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('aiml.update', $aiml->id) }}"
                                                    method="POST" enctype="multipart/form-data">
                                                    @method('put')
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="mb-3">
                                                                <label for="category" class="form-label">Category</label>
                                                                <input type="text"
                                                                    class="form-control @error('category') is-invalid @enderror"
                                                                    name="category" id="category" placeholder="Informasi Umum"
                                                                    value="{{ old('category', $aiml->category) }}" autofocus
                                                                    required>
                                                                @error('category')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="patern" class="form-label">Patern</label>
                                                                <input type="text"
                                                                    class="form-control @error('patern') is-invalid @enderror"
                                                                    name="patern" id="patern" placeholder="Siapa nama kamu?"
                                                                    value="{{ old('patern', $aiml->patern) }}"
                                                                    autofocus required>
                                                                @error('patern')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="template" class="form-label">Template</label>
                                                                <input type="text"
                                                                    class="form-control @error('template') is-invalid @enderror"
                                                                    name="template" id="template" placeholder="Nama saya ChatBot."
                                                                    value="{{ old('template', $aiml->template) }}"
                                                                    autofocus required>
                                                                @error('template')
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
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Aiml</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('aiml.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <input type="text"
                                        class="form-control @error('category') is-invalid @enderror"
                                        name="category" id="category" placeholder="Informasi Umum"
                                        value="{{ old('category') }}" autofocus
                                        required>
                                    @error('category')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="patern" class="form-label">Patern</label>
                                    <input type="text"
                                        class="form-control @error('patern') is-invalid @enderror"
                                        name="patern" id="patern" placeholder="Siapa nama kamu?"
                                        value="{{ old('patern') }}"
                                        autofocus required>
                                    @error('patern')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="template" class="form-label">Template</label>
                                    <input type="text"
                                        class="form-control @error('template') is-invalid @enderror"
                                        name="template" id="template" placeholder="Nama saya ChatBot."
                                        value="{{ old('template') }}"
                                        autofocus required>
                                    @error('template')
                                        <div class="invalid-feedback">
                                            {{ $message }}
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
