@extends('layouts.app')

@section('title', 'Dashboard')
@section('header-title', 'Dashboard')
@section('content')
    <div class="row" id="dasboard-container">
        <div class="col-lg-8 col-md-12 col-12 d-flex align-items-strech mb-3">
            <div class="card w-100">
                <div class="card-body p-0">
                    <img src="{{ asset('template/img/bg.png') }}" alt="bg-dashboard" class="img-fluid w-100">
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="mb-3">
                <x-card title="Driver" subTitle="Driver New" jumlah="20"></x-card>
            </div>
            <div class="mb-3">
                <x-card title="Orang Tua" subTitle="Orang Tua New" jumlah="20"></x-card>
            </div>
            <div class="mb-3">
                <x-card title="Anak" subTitle="Anak New" jumlah="20"></x-card>
            </div>
        </div>
    </div>
@endsection
