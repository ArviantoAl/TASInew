@extends('layouts.nowa',[
    'titlePage' => __('Daftar Invoice'),
])

@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Daftar Invoice</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Data Invoice</a></li>
                <li class="breadcrumb-item active" aria-current="page">Daftar Invoice</li>
            </ol>
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <form action="{{ route('admin.invoice') }}" method="GET">
                <div class="row row-xs">
                    <div class="form-group col-md-1">
                        <select name="bulan" id="bulan" class="form-control form-select select2" data-placeholder="Filter Bulan">
                            @foreach ($bulan as $key => $b)
                                <option value="{{ $vabulan[$key] }}" {{ $vabulan[$key] == $selected ? 'selected' : '' }}>{{$b}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-1">
                        <select name="tahun" id="tahun" class="form-control form-select select2" data-placeholder="Filter Bulan">
                            @foreach ($tahun as $key => $t)
                                <option value="{{ $t }}" {{ $t == $selected2 ? 'selected' : '' }}>{{$t}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-1">
                        <button type="submit" id="search" class="btn btn-primary btn-block">Search</button>
                    </div>
                    <div class="form-group col-md-1">
                        <button type="button" id="export" class="btn btn-primary btn-block">Export</button>
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
                                <th>Id Invoice</th>
                                <th>Nama Pelanggan</th>
                                <th>Tanggal Terbit</th>
                                <th>Tanggal Tempo</th>
                                <th>Total Tagihan</th>
                                <th>Status Terakhir</th>
                                <th colspan="3">Action</th>
                            </tr>
                            </thead>
                            <tbody style="text-align: center">
                            @foreach ($invoices as $no => $invoice)
                                <tr>
                                    <td>{{ $invoice->id_invoice }}</td>
                                    <td>{{ $invoice->pelanggan->name }}</td>
                                    <td>{{ $invoice->tgl_terbit }}</td>
                                    <td>{{ $invoice->tgl_tempo }}</td>
                                    <td>{{ rupiah($invoice->tagihan) }}</td>

                                    @if($invoice->status_id == 6)
                                        <td>
                                            <h5><span class="badge badge-pill bg-warning me-1">{{ $invoice->status->nama_status }}</span></h5>
                                        </td>
                                        <td>
                                            <a class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#manual{{$invoice->id_invoice}}" data-toggle="tooltip" title="Setujui Manual">
                                                <i class="fa fa-check"></i>
                                            </a>
                                        </td>
                                    @elseif($invoice->status_id == 7)
                                        <td>
                                            <h5><span class="badge badge-pill bg-warning me-1">{{ $invoice->status->nama_status }}</span></h5>
                                        </td>
                                        <td>
                                            <a class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#myModal{{$invoice->id_invoice}}" data-toggle="tooltip" title="Lihat Bukti Bayar">
                                                <i style="color: white" class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a class="btn btn-success" href="{{ route('admin.approvepembayaran', $invoice->id_invoice) }}" data-toggle="tooltip" title="Setujui">
                                                <i class="fa fa-check"></i>
                                            </a>
                                            <a class="btn btn-danger" href="{{ route('admin.tolakpembayaran', $invoice->id_invoice) }}" data-toggle="tooltip" title="Tolak">
                                                <i class="fa fa-ban"></i>
                                            </a>
                                        </td>
                                    @elseif($invoice->status_id == 8)
                                        <td>
                                            <h5><span class="badge badge-pill bg-success me-1">{{ $invoice->status->nama_status }}</span></h5>
                                        </td>
                                    @elseif($invoice->status_id == 9)
                                        <td>
                                            <h5><span class="badge badge-pill bg-danger me-1">{{ $invoice->status->nama_status }}</span></h5>
                                        </td>
                                    @endif
                                    <td>
                                        <a class="btn btn-success" href="{{ route('admin.printinv', $invoice->id_invoice) }}" data-toggle="tooltip" title="Cetak">
                                            <i class="fa fa-print"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $invoices->links() }}
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
        $(function(){
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });

            $(function () {
// pelanggan baru
                $('#export').click(function () {
                    let bulan = $('#bulan').val();
                    let tahun = $('#tahun').val();
                    $.ajax({
                        type: "POST",
                        url: "{{route('admin.export2')}}",
                        data: {
                            bulan: bulan,
                            tahun: tahun,
                        },
                        xhrFields:{
                            responseType: 'blob'
                        },
                        success: function(data)
                        {
                            var link = document.createElement('a');
                            link.href = window.URL.createObjectURL(data);
                            link.download = `invoice.xlsx`;
                            link.click();
                        },
                        error: function (data) {
                            console.log('error:', data);
                        }
                    })
                })
            })
        });
    </script>
@endsection
@section('modal')
    @foreach($invoices as $no => $invoice)
        <div class="modal" id="manual{{$invoice->id_invoice}}">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Setujui Pembayaran {{$invoice->id_invoice}}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <form action="{{ route('admin.setujuimanual', $invoice->id_invoice) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="metode" class="form-label">Metode Pembayaran</label>
                                <input type="text" name="metode_pembayaran" id="metode" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </form>
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal" id="myModal{{$invoice->id_invoice}}">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Bukti pembayaran {{$invoice->id_invoice}}</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        @if($invoice->bukti_bayar != null)
                        <img src="{{ asset('bukti_bayar') }}/{{ $invoice->bukti_bayar }}" alt="Responsive image" class="wd-200p wd-sm-400">
                        @endif
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
