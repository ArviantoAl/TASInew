@extends('layouts.nowa',[
    'titlePage' => __('Form Edit Langganan'),
])

@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Form Edit Langganan</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Data Langganan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Form Edit Langganan</li>
            </ol>
        </div>
    </div>
    <!-- /breadcrumb -->

    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card  box-shadow-0 ">
            <div class="card-header">
                <h4 class="card-title mb-1">Form Edit Langganan</h4>
                <p class="mb-2">Isi data untuk mengganti data langganan.</p>
            </div>
            <div class="card-body pt-0">
                <form method="POST" id="form" action="{{ route('admin.edit_langganan', $get_lang->id_langganan) }}">
                    @csrf
                    @method('PUT')
                    {{--                    <div class="">--}}
                    <input type="hidden" id="id_lang" value="{{$get_lang->id_langganan}}">
                    <div class="form-group">
                        <label for="layanan" class="form-label">Layanan</label>
                        <select name="layanan" id="layanan" class="form-control form-select select2" data-bs-placeholder="Pilih Layanan">
{{--                            <option value="{{ $get_lang->layanan_id }}">{{ $get_lang->layanan->nama_layanan }}</option>--}}
                            @foreach ($layanan as $l)
                                <option value="{{ $l->id_layanan }}" {{ $get_lang->layanan_id == $l->id_layanan ? 'selected' : '' }}>
                                    {{ $l->nama_layanan }} - {{rupiah($l->harga)}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="form-group col-6">
                            <label for="bts" class="form-label">BTS</label>
                            <select name="bts" id="bts" class="form-control form-select select2" data-bs-placeholder="Pilih BTS">
{{--                                <option value="{{ $get_lang->bts_id }}">{{$get_lang->bts->nama_bts}}</option>--}}
                                @foreach ($bts as $b)
                                    <option value="{{ $b->id_bts }}" {{ $get_lang->bts_id == $b->id_bts ? 'selected' : '' }}>{{ $b->nama_bts }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-6">
                            <label for="turunan" class="form-label">Sambungkan ke Pelanggan</label>
                            <select name="turunan" id="turunan" class="form-control form-select select2"></select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-6">
                            <label for="ip" class="form-label">IP Address</label>
                            <input class="form-control" id="ip" name="ip" value="{{ $get_lang->ip }}" placeholder="Masukkan IP pelanggan" type="text" required autocomplete="ip" autofocus>
                        </div>
                        <div class="form-group col-6">
                            <label for="ip_radio" class="form-label">IP Radio</label>
                            <input class="form-control" id="ip_radio" name="ip_radio" value="{{ $get_lang->ip_radio }}" placeholder="Masukkan IP Radio" type="text" required autocomplete="ip_radio" autofocus>
                        </div>
                    </div>

                    <div class="form-divider">
                        {{ __('Alamat Pemasangan') }}
                    </div>

                    <div class="row">
                        <div class="form-group col-6">
                            <label for="provinsi" class="form-label">Provinsi</label>
                            <select name="provinsi" id="provinsi" class="form-control form-select select2" data-bs-placeholder="Pilih Provinsi">
{{--                                <option value="{{ $get_lang->provinsi_id }}">{{ $get_lang->provinsi->name }}</option>--}}
                                @foreach ($provinsi as $p)
                                    <option value="{{ $p->id }}" {{ $get_lang->provinsi_id == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-6">
                            <label for="kabupaten" class="form-label">Kabupaten/Kota</label>
                            <select name="kabupaten" id="kabupaten" class="form-control form-select select2"></select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-6">
                            <label for="kecamatan" class="form-label">Kecamatan</label>
                            <select name="kecamatan" id="kecamatan" class="form-control form-select select2"></select>
                        </div>

                        <div class="form-group col-6">
                            <label for="desa" class="form-label">Desa/Kelurahan</label>
                            <select name="desa" id="desa" class="form-control form-select select2"></select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-6">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" placeholder="Masukkan Alamat Lengkap Pelanggan" required>{{ $get_lang->detail_alamat }}</textarea>
                        </div>
                        <div class="form-group col-6">
                            <label for="lokasi" class="form-label">Koordinat Lokasi</label>
                            <input class="form-control" id="lokasi" name="lokasi" value="{{ $get_lang->latitude }},{{ $get_lang->longitude }}" placeholder="Masukkan koordinat lokasi" type="text" required autocomplete="lokasi" autofocus>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary pd-x-30 mg-r-5 mg-t-5">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(function(){
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });

            $(function () {
                let idlang = $('#id_lang').val();
                let id_bts = $('#bts').val();
                var urltur = "{{ route('getTurunanedit', ":id") }}";
                urltur = urltur.replace(':id', idlang);
                $.ajax({
                    type: "POST",
                    url: urltur,
                    data: {id_bts: id_bts},
                    cache: false,
                    success: function (msg) {
                        $('#turunan').html(msg);
                    },
                    error: function (data) {
                        console.log('error:', data);
                    }
                })
                console.log(id_bts);
                let id_provinsi = $('#provinsi').val();
                var urlkab = "{{ route('getKabupatenedit', ":id") }}";
                urlkab = urlkab.replace(':id', idlang);
                var urlkec = "{{ route('getKecamatanedit', ":id") }}";
                urlkec = urlkec.replace(':id', idlang);
                var urldes = "{{ route('getDesaedit', ":id") }}";
                urldes = urldes.replace(':id', idlang);
                $.ajax({
                    type : "POST",
                    url : urlkab,
                    data : {id_provinsi:id_provinsi},
                    cache : false,
                    success: function (msg){
                        $('#kabupaten').html(msg);
                        $('#kecamatan').html('');
                        $('#desa').html('');
                        let id_kabupaten = $('#kabupaten').val();
                        $.ajax({
                            type : "POST",
                            url : urlkec,
                            data : {id_kabupaten:id_kabupaten},
                            cache : false,
                            success: function (msg){
                                $('#kecamatan').html(msg);
                                $('#desa').html('');
                                let id_kecamatan = $('#kecamatan').val();
                                $.ajax({
                                    type : "POST",
                                    url : urldes,
                                    data : {id_kecamatan:id_kecamatan},
                                    cache : false,
                                    success: function (msg){
                                        $('#desa').html(msg);
                                    },
                                    error: function (data){
                                        console.log('error:',data);
                                    }
                                })
                            },
                            error: function (data){
                                console.log('error:',data);
                            }
                        })
                    },
                    error: function (data){
                        console.log('error:',data);
                    },
                })

                $('#bts').on('change', function () {
                    var id_bts = $('#bts').val();
                    console.log(id_bts);
                    $.ajax({
                        type: "POST",
                        url: "{{route('getTurunan')}}",
                        data: {id_bts: id_bts},
                        cache: false,
                        success: function (msg) {
                            $('#turunan').html(msg);
                        },
                        error: function (data) {
                            console.log('error:', data);
                        }
                    })
                })
                $('#turunan').on('change',function (){
                    var id_turunan = $('#turunan').val();
                    console.log(id_turunan);
                })
                $('#provinsi').on('change',function (){
                    var id_provinsi = $('#provinsi').val();
                    console.log(id_provinsi)
                    $.ajax({
                        type : "POST",
                        url : "{{route('getKabupaten')}}",
                        data : {id_provinsi:id_provinsi},
                        cache : false,
                        success: function (msg){
                            $('#kabupaten').html(msg);
                            $('#kecamatan').html('');
                            $('#desa').html('');
                        },
                        error: function (data){
                            console.log('error:',data);
                        }
                    })
                })
                $('#kabupaten').on('change',function (){
                    var id_kabupaten = $('#kabupaten').val();
                    console.log(id_kabupaten);
                    $.ajax({
                        type : "POST",
                        url : "{{route('getKecamatan')}}",
                        data : {id_kabupaten:id_kabupaten},
                        cache : false,
                        success: function (msg){
                            $('#kecamatan').html(msg);
                            $('#desa').html('');
                        },
                        error: function (data){
                            console.log('error:',data);
                        }
                    })
                })
                $('#kecamatan').on('change',function (){
                    var id_kecamatan = $('#kecamatan').val();
                    console.log(id_kecamatan);
                    $.ajax({
                        type : "POST",
                        url : "{{route('getDesa')}}",
                        data : {id_kecamatan:id_kecamatan},
                        cache : false,
                        success: function (msg){
                            $('#desa').html(msg);
                        },
                        error: function (data){
                            console.log('error:',data);
                        }
                    })
                })
                $('#desa').on('change',function (){
                    var id_desa = $('#desa').val();
                    console.log(id_desa);
                })
                $("#form").submit(function (e) {
                    e.preventDefault();
                    var id = $('#id_lang').val();
                    var url = "{{ route('admin.postedit_langganan', ":id") }}";
                    url = url.replace(':id', id);

                    var id_layanan = $('#layanan').val();
                    var id_bts = $('#bts').val();
                    var id_turunan = $('#turunan').val();
                    var ip = $('#ip').val();
                    var ip_radio = $('#ip_radio').val();
                    var id_provinsi = $('#provinsi').val();
                    var id_kabupaten = $('#kabupaten').val();
                    var id_kecamatan = $('#kecamatan').val();
                    var id_desa = $('#desa').val();
                    var id_alamat = $('#alamat').val();
                    var lokasi = $('#lokasi').val();
                    // console.log(email);
                    $.ajax({
                        type: "PUT",
                        url: url,
                        data: {
                            id_layanan: id_layanan,
                            id_bts: id_bts,
                            id_turunan: id_turunan,
                            ip: ip,
                            ip_radio: ip_radio,
                            id_provinsi: id_provinsi,
                            id_kabupaten: id_kabupaten,
                            id_kecamatan: id_kecamatan,
                            id_desa: id_desa,
                            id_alamat: id_alamat,
                            lokasi: lokasi,
                        },
                        cache: false,
                        success: function (data) {
                            console.log('success: ' + data);
                            window.location.href = "{{route('admin.pelangganaktif')}}";
                        },
                        error: function (data) {
                            var errors = data.responseJSON;
                            console.log(errors);
                        }
                    })
                })
            })
        });
    </script>
@endsection
