@extends('layouts.app')

@section('title', 'Anak')
@section('header-title', 'Anak')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Tambah Data
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div id="loading" style="display: none;">
                    <p>Loading data...</p>
                </div>

                <div id="data-table">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>NISN</th>
                                <th>Nama Orang Tua</th>
                                <th>No Telfon</th>
                                <th>Sekolah</th>
                                <th>Email</th>
                                <th>Alamat Sekolah</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <div id="table-loading" class="text-center d-none">
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only"></span>
                        </div>
                    </div>
                    <!-- Pagination -->
                </div>
            </div>
        </div>
        @include('components.modal.modal-Anak')
    </div>
@endsection
