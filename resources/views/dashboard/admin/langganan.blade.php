@extends('layouts.nowa',[
    'titlePage' => __('Daftar Langganan'),
])

@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Daftar Langganan</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Data Layanan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Daftar Layanan</li>
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
                                <th>Nama Pelanggan</th>
                                <th>Alamat Pemasangan</th>
                                <th>Jenis Langganan</th>
                                <th>Tanggal Expired</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody style="text-align: center">
                            @foreach ($langganans as $no => $langganan)
                                <tr>
                                    <td>{{ $no+1 }}</td>
                                    <td>{{ $langganan->pelanggan->name }}</td>
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
                                                <span class="badge badge-pill bg-warning me-1">{{ $langganan->status->nama_status }}</span>
                                            </h5>
                                        </td>
                                    @elseif($langganan->status_id == 3)
                                        <td>
                                            <h5>
                                                <span class="badge badge-pill bg-success me-1">{{ $langganan->status->nama_status }}</span>
                                            </h5>
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
                        {{ $langganans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
