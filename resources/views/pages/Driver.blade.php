@extends('layouts.app')

@section('title', 'Driver')
@section('header-title', 'Driver')
@section('content')
    <div class="card shadow mb-4">
        <!-- Button trigger modal -->
        <div class="card-header py-3">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Tambah Data
            </button>
        </div>
        <div class="card-body">
            {{-- <form method="GET" action="" class="mb-3">
          <div class="input-group">
              <input type="text" class="form-control" name="search" placeholder="Cari berdasarkan nama"
                  value="{{ request()->input('search') }}">
              <div class="input-group-append">
                  <button class="btn btn-primary" type="submit">
                      <i class="fas fa-search fa-sm"></i>
                  </button>
              </div>
          </div>
      </form> --}}

            <div class="table-responsive">
                <div id="loading" style="display: none;">
                    <p>Loading data...</p>
                </div>

                <div id="data-table">
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
        @include('components.modal.modal-driver')
    </div>
@endsection
