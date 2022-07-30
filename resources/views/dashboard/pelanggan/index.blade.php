@extends('layouts.nowa',[
    'titlePage' => __('Dashboard Pelanggan'),
])

@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Dasboard</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Dashboard Pelanggan</li>
            </ol>
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- row -->
    <div class="row">
        <div class="col-md-12 col-xl-12 col-xs-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div>
                        <h6>Hai {{Auth::user()->name}}, selamat datang kembali.</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
@endsection
