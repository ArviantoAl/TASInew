@extends('layouts.nowa',[
    'titlePage' => __('Daftar Pelanggan Aktif'),
])

@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Daftar Pelanggan {{ $nama_status }}</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a>Data Pelanggan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Daftar Pelanggan {{ $nama_status }}</li>
            </ol>
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            @if($terakhir == $bulan)
                <form action="{{ route('admin.kirimsemua') }}" method="POST">
                    @csrf
                    <div class="row row-xs">
                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="input-group-text">
                                    Jatuh Tempo:
                                </div>
                                <input class="form-control" type="datetime-local" name="tempo" required>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <button type="submit" class="btn btn-primary btn-block">Kirim Invoice Bulan {{$namabulan}}</button>
                        </div>
                    </div>
                </form>
            @endif

            <form action="{{ route('admin.pelangganaktif') }}" method="GET">
                <div class="row row-xs">
                    <div class="form-group col-md-2">
                        <select name="status" id="status" class="form-control form-select select2" data-placeholder="Filter status">
                            <option value="all" {{ $nama_status == 'Semua' ? 'selected' : '' }}>Semua</option>
                            <option value="3" {{ $nama_status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="1" {{ $nama_status == 'On Progress' ? 'selected' : '' }}>On Progress</option>
                            <option value="2" {{ $nama_status == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="4" {{ $nama_status == 'Non Aktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <input type="search" name="search" class="form-control" placeholder="Search...">
                    </div>
                    <div class="form-group col-md-1">
                        <button type="submit" id="search" class="btn btn-primary btn-block">search</button>
                    </div>
                </div>
            </form>
            <div class="card custom-card overflow-hidden">
                <div class="card-body">
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session()->get('success') }}</strong>
                            <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mg-b-0 text-md-nowrap">
                            <thead style="text-align: center">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Username/No Hp</th>
                                <th>Role</th>
                                <th>PPN</th>
                                <th>Status</th>
                                <th colspan="4">Action</th>
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
                                    <td>
                                        <input id="ppn" class="checkbox" data-id="{{ $user->id_user }}" type="checkbox" {{ $user->ppn != 0 ? 'checked' : '' }}>
                                    </td>
                                    @if($user->status_id == 1)
                                        <td>
                                            <h5>
                                                <span class="badge badge-pill bg-primary me-1">{{ $user->status->nama_status }}</span>
                                            </h5>
                                        </td>
                                    @elseif($user->status_id == 2)
                                        <td>
                                            <h5>
                                                <span class="badge badge-pill bg-warning me-1">{{ $user->status->nama_status }}</span>
                                            </h5>
                                        </td>
                                        <td>
                                            <a class="btn btn-warning" href="{{ route('admin.form_lama', $user->id_user) }}" data-toggle="tooltip" title="Tambah Langganan">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn btn-warning" href="{{ route('admin.edituser', $user->id_user) }}" data-toggle="tooltip" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </td>
                                    @elseif($user->status_id == 3)
                                        <td>
                                            <h5>
                                                <span class="badge badge-pill bg-success me-1">{{ $user->status->nama_status }}</span>
                                            </h5>
                                        </td>
                                        <td>
                                            <a class="btn btn-warning" href="{{ route('admin.form_lama', $user->id_user) }}" data-toggle="tooltip" title="Tambah Langganan">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn btn-warning" href="{{ route('admin.edituser', $user->id_user) }}" data-toggle="tooltip" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn btn-danger" href="{{ route('admin.nonaktif_pelanggan', $user->id_user) }}" data-toggle="tooltip" title="Nonaktif Pelanggan">
                                                <i class="fa fa-ban"></i>
                                            </a>
                                        </td>
                                    @elseif($user->status_id == 4)
                                        <td>
                                            <h5>
                                                <span class="badge badge-pill bg-danger me-1">{{ $user->status->nama_status }}</span>
                                            </h5>
                                        </td>)
                                    @endif
                                    <td>
                                        <a class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#myModal{{$user->id_user}}" data-toggle="tooltip" title="Lihat Langganan Pelanggan">
                                            <i style="color: white" class="fa fa-eye"></i>
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
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $('.checkbox').on('click', function () {
            var ppn_id = $(this).prop('checked') === true ? 1 : 0;
            // alert(status);
            var user_id = $(this).data('id');
            // console.log(user_id);
            $.ajax({
                type: "GET",
                url: "{{route('admin.changeppn')}}",
                data: {
                    id_user: user_id,
                    ppn_id: ppn_id,
                },
                cache: false,
                success: function (data) {
                    if(data.cek == 1){
                        alert(data.msg);
                    }else {
                        console.log('success: ' + data);
                    }
                },
                error: function (data) {
                    console.log('error:', data);
                }
            })
        })
    </script>
@endsection
@section('modal')
    @foreach($langganan as $no => $lang)
        <div class="modal" id="myModal{{$lang['id']}}">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Daftar Langganan {{$lang['name']}}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mg-b-0 text-md-nowrap">
                                <thead style="text-align: center">
                                <tr>
                                    <th>No</th>
                                    <th>Alamat Pemasangan</th>
                                    <th>Jenis Langganan</th>
                                    <th>Tanggal Expired</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody style="text-align: center">
                                @foreach ($lang['langganan'] as $no => $langganan)
                                    <tr>
                                        <td>{{ $no+1 }}</td>
                                        <td>{{ $langganan->alamat_pasang }}</td>
                                        <td>{{ $langganan->layanan->nama_layanan }}</td>
                                        <td>{{ $langganan->tgl_lanjut }}</td>
                                        @if($langganan->status_id == 1)
                                            <td>
                                                <h5>
                                                    <span class="badge badge-pill bg-primary me-1">{{ $langganan->status->nama_status }}</span>
                                                </h5>
                                            </td>
                                            <td>
                                                <a class="btn btn-success" href="{{ route('admin.approvelangganan', $langganan->id_langganan) }}" data-toggle="tooltip" title="Approve">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                                <a class="btn btn-danger" href="{{ route('admin.rejectlangganan', $langganan->id_langganan) }}" data-toggle="tooltip" title="Batal">
                                                    <i class="fa fa-ban"></i>
                                                </a>
                                            </td>
                                        @elseif($langganan->status_id == 2 || $langganan->status_id == 10)
                                            <td>
                                                <h5>
                                                    <span class="badge badge-pill bg-success me-1">Aktif(proses pembayaran)</span>
                                                </h5>
                                            </td>
                                        @elseif($langganan->status_id == 3)
                                            <td>
                                                <h5>
                                                    <span class="badge badge-pill bg-success me-1">{{ $langganan->status->nama_status }}</span>
                                                </h5>
                                            </td>
                                            <td>
                                                <a class="btn btn-warning" href="{{ route('admin.edit_langganan', $langganan->id_langganan) }}" data-toggle="tooltip" title="Edit Langganan">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <a class="btn btn-danger" href="{{ route('admin.nonaktif_langganan', $langganan->id_langganan) }}" data-toggle="tooltip" title="Nonaktif Langganan">
                                                    <i class="fa fa-ban"></i>
                                                </a>
                                            </td>
                                        @elseif($langganan->status_id == 4 || $langganan->status_id == 5)
                                            <td>
                                                <h5>
                                                    <span class="badge badge-pill bg-danger me-1">{{ $langganan->status->nama_status }}</span>
                                                </h5>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
    @endforeach
@endsection
