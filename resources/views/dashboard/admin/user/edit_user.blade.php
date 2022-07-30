@extends('layouts.nowa',[
    'titlePage' => __('Edit User'),
])

@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Edit User</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Data User</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit User</li>
            </ol>
        </div>
    </div>
    <!-- /breadcrumb -->

    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card  box-shadow-0 ">
            <div class="card-header">
                <h4 class="card-title mb-1">Form Edit User</h4>
                <p class="mb-2">Ubah data baru untuk data user tersebut.</p>
            </div>
            <div class="card-body pt-0">
                <form method="POST" action="{{ route('admin.postedituser', $user->id_user) }}">
                    @csrf
                    @method('PUT')
                    {{--                    <div class="">--}}
                    <div class="form-group">
                        <label for="name" class="form-label">Nama</label>
                        <input class="form-control" id="name" name="name" value="{{ $user->name }}" placeholder="Masukkan Nama Lengkap" type="text" required autocomplete="name" autofocus>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="email" class="form-label">Email</label>
                            <input class="form-control" id="email" name="email" value="{{ $user->email }}" placeholder="Masukkan Email" type="email" required autocomplete="email" autofocus>
                        </div>
                        <div class="form-group col-6">
                            <label for="username" class="form-label">No Hp</label>
                            <input class="form-control" id="username" name="username" value="{{ $user->username }}" placeholder="Masukkan No Hp" type="number" required autocomplete="username" autofocus>
                        </div>
                    </div>
                    {{--                    </div>--}}
                    <button type="submit" class="btn btn-primary mt-3 mb-0">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
