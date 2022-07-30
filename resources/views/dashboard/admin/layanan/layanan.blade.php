@extends('layouts.nowa',[
    'titlePage' => __('Daftar Layanan'),
])

@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Daftar Layanan</span>
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
            <div class="btn-group ms-2 mt-2 mb-2">
                <a class="btn btn-success" href="{{route('admin.tambahlayanan')}}">
                    Tambah Layanan
                </a>
            </div>
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
                                <th>Jenis Layanan</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <th colspan="2">Action</th>
                            </tr>
                            </thead>
                            <tbody style="text-align: center">
                            @foreach ($layanans as $no => $layanan)
                                <tr>
                                    <td>{{ $no+1 }}</td>
                                    <td>{{ $layanan->nama_layanan }}</td>
                                    <td>{{ rupiah($layanan->harga) }}</td>
                                    @if($layanan->status_id == 3)
                                        <td>
                                            <h5>
                                                <span class="badge badge-pill bg-success me-1">{{ $layanan->status->nama_status }}</span>
                                            </h5>
                                        </td>
                                        <td>
                                            <a class="btn btn-warning" href="{{ route('admin.editlayanan', $layanan->id_layanan) }}" data-toggle="tooltip" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn btn-danger" href="{{ route('admin.nonaktiflayanan', $layanan->id_layanan) }}" data-toggle="tooltip" title="Nonaktif">
                                                <i class="fa fa-ban"></i>
                                            </a>
                                        </td>
                                    @elseif($layanan->status_id == 4)
                                        <td>
                                            <h5>
                                                <span class="badge badge-pill bg-danger me-1">{{ $layanan->status->nama_status }}</span>
                                            </h5>
                                        </td>
                                        <td>
                                            <a class="btn btn-success" href="{{ route('admin.aktiflayanan', $layanan->id_layanan) }}" data-toggle="tooltip" title="Aktifkan">
                                                <i class="fa fa-check"></i>
                                            </a>
                                        </td>
{{--                                        <td>--}}
{{--                                            <form action="{{ route('admin.deletelayanan', $layanan->id_layanan) }}" method="POST">--}}
{{--                                                @csrf--}}
{{--                                                <input type="hidden" name="_method" value="DELETE">--}}
{{--                                                <button type="submit" class="btn btn-danger" data-toggle="tooltip" title="Hapus">--}}
{{--                                                    <i style="color: white" class="fa fa-trash"></i>--}}
{{--                                                </button>--}}
{{--                                            </form>--}}
{{--                                        </td>--}}
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $layanans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
