@extends('layouts.nowa',[
    'titlePage' => __('Daftar Semua User'),
])

@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Daftar User</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Data User</a></li>
                <li class="breadcrumb-item active" aria-current="page">Daftar User</li>
            </ol>
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mg-b-0 text-md-nowrap">
                            <thead style="text-align: center">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>No Hp</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th colspan="3">Action</th>
                            </tr>
                            </thead>
                            <tbody style="text-align: center">
                            @foreach ($users as $no => $user)
                                <tr>
                                    <td>{{ $no+1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->role->nama_role }}</td>
                                    @if($user->status_id == 1)
                                        <td>
                                            <h5>
                                                <span class="badge badge-pill bg-warning me-1">{{ $user->status->nama_status }}</span>
                                            </h5>
                                        </td>
                                    @elseif($user->status_id == 2)
                                        <td>
                                            <h5>
                                                <span class="badge badge-pill bg-primary me-1">{{ $user->status->nama_status }}</span>
                                            </h5>
                                        </td>
                                    @elseif($user->status_id == 3)
                                        <td>
                                            <h5>
                                                <span class="badge badge-pill bg-success me-1">{{ $user->status->nama_status }}</span>
                                            </h5>
                                        </td>
                                    @endif
                                    <td>
                                        <a class="btn btn-warning" href="{{ route('admin.edituser', $user->id_user) }}" data-toggle="tooltip" title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
