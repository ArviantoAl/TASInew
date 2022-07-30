@extends('layouts.nowa',[
    'titlePage' => __('Dashboard Admin'),
])

@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Dashboard Admin</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Dashboard Admin</li>
            </ol>
        </div>
    </div>
    <!-- /breadcrumb -->

    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Anda adalah Admin</strong>
        <button aria-label="Close" class="btn-close" data-bs-dismiss="alert" type="button"><span aria-hidden="true">&times;</span></button>
    </div>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <form>
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
            </div>
        </form>
        <!-- <div class="container"> -->
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-12 col-xs-12">
                <div class="card sales-card circle-image1">
                    <div class="row">
                        <div class="col-9">
                            <div class="ps-4 pt-4 pe-3 pb-4">
                                <div class="">
                                    <h6 class="mb-2 tx-12 ">Jumlah Invoice</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <h4 id="ainv" class="tx-20 font-weight-semibold mb-2"></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="circle-icon bg-info-transparent text-center align-self-center overflow-hidden">
                                <i class="fa fa-file-invoice tx-16 text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 col-xs-12">
                <div class="card sales-card circle-image2">
                    <div class="row">
                        <div class="col-9">
                            <div class="ps-4 pt-4 pe-3 pb-4">
                                <div class="">
                                    <h6 class="mb-2 tx-12">Invoice Terbayar</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <h4 id="binv" class="tx-20 font-weight-semibold mb-2"></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="circle-icon bg-primary-transparent text-center align-self-center overflow-hidden">
                                <i class="fa fa-file-invoice tx-16 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 col-xs-12">
                <div class="card sales-card circle-image2">
                    <div class="row">
                        <div class="col-9">
                            <div class="ps-4 pt-4 pe-3 pb-4">
                                <div class="">
                                    <h6 class="mb-2 tx-12">Invoice Belum Dibayar</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <h4 id="cinv" class="tx-20 font-weight-semibold mb-2"></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="circle-icon bg-secondary-transparent text-center align-self-center overflow-hidden">
                                <i class="fa fa-file-invoice tx-16 text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 col-xs-12">
                <div class="card sales-card circle-image2">
                    <div class="row">
                        <div class="col-9">
                            <div class="ps-4 pt-4 pe-3 pb-4">
                                <div class="">
                                    <h6 class="mb-2 tx-12">Invoice Tidak Dibayar</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <h4 id="dinv" class="tx-20 font-weight-semibold mb-2"></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="circle-icon bg-secondary-transparent text-center align-self-center overflow-hidden">
                                <i class="fa fa-file-invoice tx-16 text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-3 col-md-12 col-xs-12">
                <div class="card sales-card circle-image1">
                    <div class="row">
                        <div class="col-9">
                            <div class="ps-4 pt-4 pe-3 pb-4">
                                <div class="">
                                    <h6 class="mb-2 tx-12 ">Total Invoice</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <h4 id="totalinv" class="tx-20 font-weight-semibold mb-2"></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="circle-icon bg-info-transparent text-center align-self-center overflow-hidden">
                                <i class="fa fa-dollar-sign tx-16 text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 col-xs-12">
                <div class="card sales-card circle-image2">
                    <div class="row">
                        <div class="col-9">
                            <div class="ps-4 pt-4 pe-3 pb-4">
                                <div class="">
                                    <h6 class="mb-2 tx-12">Invoice Terbayar</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <h4 id="terbinv" class="tx-20 font-weight-semibold mb-2"></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="circle-icon bg-primary-transparent text-center align-self-center overflow-hidden">
                                <i class="fa fa-dollar-sign tx-16 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 col-xs-12">
                <div class="card sales-card circle-image2">
                    <div class="row">
                        <div class="col-9">
                            <div class="ps-4 pt-4 pe-3 pb-4">
                                <div class="">
                                    <h6 class="mb-2 tx-12">Invoice Belum Dibayar</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <h4 id="belinv" class="tx-20 font-weight-semibold mb-2"></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="circle-icon bg-secondary-transparent text-center align-self-center overflow-hidden">
                                <i class="fa fa-dollar-sign tx-16 text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 col-xs-12">
                <div class="card sales-card circle-image2">
                    <div class="row">
                        <div class="col-9">
                            <div class="ps-4 pt-4 pe-3 pb-4">
                                <div class="">
                                    <h6 class="mb-2 tx-12">Invoice Tidak Dibayar</h6>
                                </div>
                                <div class="pb-0 mt-0">
                                    <div class="d-flex">
                                        <h4 id="batinv" class="tx-20 font-weight-semibold mb-2"></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="circle-icon bg-secondary-transparent text-center align-self-center overflow-hidden">
                                <i class="fa fa-dollar-sign tx-16 text-secondary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const formatRupiah = (money) => {
            return new Intl.NumberFormat('id-ID',
                { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }
            ).format(money);
        }

        $(function(){
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });

            $(function () {
// pelanggan baru
                var ainv = JSON.parse('{!! json_encode($h_invoice) !!}');
                $('#ainv').html(ainv);
                var binv = JSON.parse('{!! json_encode($h_terbayar) !!}');
                $('#binv').html(binv);
                var cinv = JSON.parse('{!! json_encode($h_belumbayar) !!}');
                $('#cinv').html(cinv);
                var dinv = JSON.parse('{!! json_encode($h_tidakbayar) !!}');
                $('#dinv').html(dinv);

                let totalinv = JSON.parse('{!! json_encode($total) !!}');
                let belinv = JSON.parse('{!! json_encode($bel) !!}');
                let terbinv = JSON.parse('{!! json_encode($ter) !!}');
                let batinv = JSON.parse('{!! json_encode($bat) !!}');
                $('#totalinv').html(formatRupiah(totalinv));
                $('#belinv').html(formatRupiah(belinv));
                $('#terbinv').html(formatRupiah(terbinv));
                $('#batinv').html(formatRupiah(batinv));

                $('#bulan').on('change',function (){
                    var bulan = $('#bulan').val();
                    var tahun = $('#tahun').val();
                    $.ajax({
                        type : "POST",
                        url : "{{route('ainv')}}",
                        data : {
                            bulan:bulan,
                            tahun:tahun
                        },
                        cache : false,
                        success: function (msg){
                            $('#ainv').html(msg['h_invoice']);
                            $('#binv').html(msg['h_terbayar']);
                            $('#cinv').html(msg['h_belumbayar']);
                            $('#dinv').html(msg['h_tidakbayar']);
                            $('#totalinv').html(formatRupiah(msg['total']));
                            $('#terbinv').html(formatRupiah(msg['ter']));
                            $('#belinv').html(formatRupiah(msg['bel']));
                            $('#batinv').html(formatRupiah(msg['bat']));
                            // console.log(msg['h_invoice']);
                        },
                        error: function (data){
                            console.log('error:',data);
                        }
                    })
                })
                $('#tahun').on('change',function (){
                    var bulan = $('#bulan').val();
                    var tahun = $('#tahun').val();
                    $.ajax({
                        type : "POST",
                        url : "{{route('binv')}}",
                        data : {
                            bulan:bulan,
                            tahun:tahun
                        },
                        cache : false,
                        success: function (msg){
                            $('#ainv').html(msg['h_invoice']);
                            $('#binv').html(msg['h_terbayar']);
                            $('#cinv').html(msg['h_belumbayar']);
                            $('#dinv').html(msg['h_tidakbayar']);
                            $('#totalinv').html(formatRupiah(msg['total']));
                            $('#terbinv').html(formatRupiah(msg['ter']));
                            $('#belinv').html(formatRupiah(msg['bel']));
                            $('#batinv').html(formatRupiah(msg['bat']));
                            // console.log(msg['h_invoice']);
                        },
                        error: function (data){
                            console.log('error:',data);
                        }
                    })
                })
            })
        });
    </script>
@endsection
