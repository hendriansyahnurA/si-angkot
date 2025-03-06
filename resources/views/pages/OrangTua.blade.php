@extends('layouts.app')

@section('title', 'OrangTua')
@section('header-title', 'Orang Tua')
@section('content')
    <div class="card shadow mb-4">
        <!-- Button trigger modal -->
        <div class="card-header py-3">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Tambah Data
            </button>
        </div>
        <div class="card-body">
            <form method="GET" action="" class="mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Cari berdasarkan nama"
                        value="{{ request()->input('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <div id="loading" style="display: none;">
                    <p>Loading data...</p>
                </div>

                <div id="data-table">
                    {{-- @if ($aspek->isNotEmpty()) --}}
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>No Telfon</th>
                                <th>email</th>
                                <th style="width: 25%">Alamat</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($aspek as $p)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $p->aspek_penilaian }}</td>
                                        <td>{{ $p->presentase }}</td>
                                        <td>{{ $p->core_faktor }}</td>
                                        <td>{{ $p->secondary_faktor }}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-warning btn-circle" data-toggle="modal"
                                                data-target="#exampleEdit{{ $p->id }}">
                                                <i class="fa-solid fa-pen"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-circle" data-toggle="modal"
                                                data-target="#exampleDelete{{ $p->id }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach --}}
                        </tbody>
                    </table>
                    <!-- Pagination -->
                    {{-- <div class="d-flex justify-content-center">
                            {{ $aspek->links('vendor.pagination.bootstrap-4') }}
                        </div> --}}
                    {{-- @else --}}
                    {{-- <p id="no-data">Tidak Ada Data Evaluator</p> --}}
                    {{-- @endif --}}
                </div>
            </div>
        </div>

        {{-- @include('components.modal-aspek.createAspek')
        @include('components.modal-aspek.editAspek')
        @include('components.modal-aspek.deleteAspek')
        @push('scripts')
            @include('components.Sweetalert-loader.exampleModal')
            @include('components.Sweetalert-loader.loaderTable')
        @endpush --}}
    </div>
@endsection
