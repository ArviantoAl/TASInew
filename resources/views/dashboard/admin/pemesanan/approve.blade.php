@extends('layouts.nowa',[
    'titlePage' => __('Form Approval Langganan'),
])

@section('content')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">Form Approval Langganan</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Data Langganan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Form Approval Langganan</li>
            </ol>
        </div>
    </div>
    <!-- /breadcrumb -->

    <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
        <div class="card  box-shadow-0 ">
            <div class="card-header">
                <h4 class="card-title mb-1">Form Approval Langganan</h4>
                <p class="mb-2">Isi data untuk melengkapi data langganan.</p>
            </div>
            <div class="card-body pt-0">
                <form method="POST" id="form" action="{{ route('admin.postapprove', $get_lang->id_langganan) }}">
                    @csrf
                    @method('PUT')
                    {{--                    <div class="">--}}
                    <input type="hidden" id="id_lang" value="{{$get_lang->id_langganan}}">
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input class="form-control" id="email" name="email" placeholder="Masukkan Email" type="email" required autocomplete="email" autofocus>
                    </div>
                    <div class="form-group">
                        <label for="ppn" class="form-label">PPN</label>
                        <input id="ppn" class="checkbox" type="checkbox" checked>
                    </div>
                    <div class="form-group">
                        <label for="layanan" class="form-label">Layanan</label>
                        <select name="layanan" id="layanan" class="form-control form-select select2" data-bs-placeholder="Pilih Layanan" disabled>
                            <option value="{{$get_lang->layanan_id}}">{{$get_lang->layanan->nama_layanan}}</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="bts" class="form-label">BTS</label>
                            <select name="bts" id="bts" class="form-control form-select select2" data-bs-placeholder="Pilih BTS" required>
                                <option value="0">Pilih BTS</option>
                                @foreach ($bts as $b)
                                    <option value="{{ $b->id_bts }}">{{ $b->nama_bts }}</option>
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
                            <input class="form-control" id="ip" name="ip" placeholder="Masukkan IP pelanggan" type="text" required autocomplete="ip" autofocus>
                        </div>
                        <div class="form-group col-6">
                            <label for="ip_radio" class="form-label">IP Radio</label>
                            <input class="form-control" id="ip_radio" name="ip_radio" placeholder="Masukkan IP Radio" type="text" required autocomplete="ip_radio" autofocus>
                        </div>
                    </div>
                    <div class="form-group col-6">
                        <label for="lokasi" class="form-label">Koordinat Lokasi</label>
                        <input class="form-control" id="lokasi" name="lokasi" placeholder="ex. -7.551311,110.854192" type="text" autocomplete="lokasi" autofocus>
                    </div>
                    {{--                    </div>--}}
                    <button type="submit" class="btn btn-primary mt-3 mb-0">Submit</button>
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
                // var id = $('#id_lang').val();
                // console.log(id);
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
                $("#form").submit(function (e) {
                    e.preventDefault();
                    var id = $('#id_lang').val();
                    var url = "{{ route('admin.postapprove', ":id") }}";
                    url = url.replace(':id', id);

                    var ppn = $('#ppn').prop('checked') === true ? 1 : 0;
                    var id_bts = $('#bts').val();
                    var id_turunan = $('#turunan').val();
                    var ip = $('#ip').val();
                    var ip_radio = $('#ip_radio').val();
                    var email = $('#email').val();
                    var lokasi = $('#lokasi').val();
                    console.log(email);
                    $.ajax({
                        type: "PUT",
                        url: url,
                        data: {
                            id_bts: id_bts,
                            id_turunan: id_turunan,
                            ip: ip,
                            ip_radio: ip_radio,
                            email: email,
                            ppn: ppn,
                            lokasi: lokasi,
                        },
                        cache: false,
                        success: function (data) {
                            if(data.cek === 1){
                                alert(data.msg);
                            }else if(data.cek === 2){
                                alert(data.msg);
                            }else {
                                console.log('success: ' + data);
                                window.location.href = "{{route('admin.pelangganaktif')}}";
                            }
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
