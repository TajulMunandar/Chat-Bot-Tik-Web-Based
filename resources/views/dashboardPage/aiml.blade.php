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
                                    <th>Patern</th>
                                    <th>Template</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($aimls as $key => $aiml)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @php
                                                $pattern = $aiml['pattern'];
                                                $words = explode(' ', $pattern);
                                                if (count($words) > 5) {
                                                    $pattern = implode(' ', array_slice($words, 0, 5)) . '...';
                                                }
                                            @endphp
                                            {{ $pattern }}
                                        </td>
                                        <td>
                                            @if (is_array($aiml['template']))
                                                @if (isset($aiml['template']['randomOptions']))
                                                    @php
                                                        $randomOptions = array_slice(
                                                            $aiml['template']['randomOptions'],
                                                            0,
                                                            2,
                                                        );
                                                    @endphp
                                                    {{ implode(', ', $randomOptions) }}
                                                    @if (count($aiml['template']['randomOptions']) > 2)
                                                        ...
                                                    @endif
                                                @else
                                                    @php
                                                        $slicedArray = array_slice($aiml['template'], 0, 3);
                                                    @endphp
                                                    {{ implode(', ', $slicedArray) }}
                                                    @if (count($aiml['template']) > 3)
                                                        ...
                                                    @endif
                                                @endif
                                            @else
                                                {{ mb_substr($aiml['template'], 0, 50) }}
                                                @if (mb_strlen($aiml['template']) > 50)
                                                    ...
                                                @endif
                                            @endif


                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $key }}">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <button id="delete-button" class="btn btn-danger" id="delete-button"
                                                data-bs-toggle="modal" data-bs-target="#hapusModal{{ $key }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    {{--  MODAL Delete  --}}
                                    <div class="modal fade" id="hapusModal{{ $key }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data Aiml</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('aiml.destroy', $key) }}" method="post"
                                                    enctype="multipart/form-data">
                                                    @method('delete')
                                                    @csrf
                                                    <div class="modal-body">
                                                        <p>Apakah Anda Yakin Ingin Menghapus Data
                                                            <b>"{{ $aiml['pattern'] }}"</b>
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
                                    <div class="modal fade" id="editModal{{ $key }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Aiml</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('aiml.update', $key) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @method('put')
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="mb-3">
                                                                <label for="patern" class="form-label">Patern</label>
                                                                <input type="text"
                                                                    class="form-control @error('patern') is-invalid @enderror"
                                                                    name="patern" id="patern"
                                                                    placeholder="Siapa nama kamu?"
                                                                    value="{{ $aiml['pattern'] }}" autofocus required>
                                                                @error('patern')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="template" class="form-label">Template</label>
                                                                @if (isset($aiml['template']['randomOptions']) && is_array($aiml['template']['randomOptions']))
                                                                    {{-- Jika ada struktur random, tampilkan randomOptions --}}
                                                                    <textarea class="form-control @error('template') is-invalid @enderror" name="template" id="randomOptions"
                                                                        placeholder="Pilihan acak dipisahkan dengan koma (,)">{{ implode(', ', $aiml['template']['randomOptions']) }}</textarea>
                                                                @else
                                                                    {{-- Jika tidak ada struktur random, tampilkan template --}}
                                                                    <textarea class="form-control @error('template') is-invalid @enderror" name="template" id="template"
                                                                        placeholder="Nama saya ChatBot." autofocus required>{{ is_array($aiml['template']) ? implode(', ', $aiml['template']) : $aiml['template'] }}</textarea>
                                                                @endif
                                                                @error('template')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                                <small class="form-text text-muted">
                                                                    Jika template memiliki struktur random, akhiri setiap
                                                                    kalimat dengan tanda koma (,).
                                                                </small>
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
                                    <label for="patern" class="form-label">Patern</label>
                                    <input type="text" class="form-control @error('patern') is-invalid @enderror"
                                        name="patern" id="patern" placeholder="Siapa nama kamu?"
                                        value="{{ old('patern') }}" autofocus required>
                                    @error('patern')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="template" class="form-label">Template</label>
                                    <textarea class="form-control @error('template') is-invalid @enderror" name="template" id="template"
                                        placeholder="Nama saya ChatBot." autofocus required>{{ old('template') }}</textarea>
                                    @error('template')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Jika template memiliki struktur random, akhiri setiap kalimat dengan tanda koma
                                        (,).</small>
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
            if ($.fn.DataTable.isDataTable('#myTable')) {
                // Dapatkan objek DataTable
                var table = $('#myTable').DataTable();

                // Set ulang opsi pageLength menjadi 100
                table.page.len(100).draw();

                $('.page-link:contains("Previous")').html(prevIcon);

                // Ganti teks "Next" dengan ikon saat dokumen pertama kali dimuat
                $('.page-link:contains("Next")').html(nextIcon);
            }
        });
    </script>
@endsection
@endsection
