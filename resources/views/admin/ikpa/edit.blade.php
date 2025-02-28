@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Data</h3>

            </div>
            <form method="POST" action="/superadmin/ikpa/edit/{{$data->id}}">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">SKPD</label>
                        <select class="form-control" required name="skpd_id">
                            <option value="">-skpd-</option>
                            @foreach (skpd() as $item)
                            <option value="{{$item->id}}" {{$data->skpd_id == $item->id ?
                                'selected':''}}>{{$item->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">TAHUN</label>
                        <select class="form-control" required name="tahun">
                            <option value="">-tahun-</option>
                            <option value="2025" {{$data->tahun == '2025' ? 'selected':''}}>2025</option>
                            <option value="2024" {{$data->tahun == '2024' ? 'selected':''}}>2024</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">SEMESTER</label>
                        <select class="form-control" required name="semester" id="semester">
                            <option value="">-semester-</option>
                            <option value="1" {{$data->semester == '1' ? 'selected':''}}>1</option>
                            <option value="2" {{$data->semester == '2' ? 'selected':''}}>2</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">TRIWULAN</label>
                        <select class="form-control" required name="triwulan" id="triwulan">
                            <option value="">-triwulan-</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">BULAN</label>

                        <select class="form-control" required name="bulan" id="bulan">
                            <option value="">-bulan-</option>
                            @foreach (bulan() as $item)
                            <option value="{{$item}}" {{$data->bulan == $item ? 'selected':''}}>{{$item}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">NAMA</label>
                        <input type="text" name="nama" class="form-control" required value="{{$data->nama}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">JABATAN</label>
                        <input type="text" name="jabatan" class="form-control" required value="{{$data->nama}}">
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            <!-- /.card-body -->
        </div>
    </div>
</div>

@endsection
@push('js')

<script>
    $(document).ready(function () {
        const triwulanOptions = {
            "1": ["1", "2"], 
            "2": ["3", "4"]
        };

        const bulanOptions = {
            "1": ["Januari", "Februari", "Maret"],
            "2": ["April", "Mei", "Juni"],
            "3": ["Juli", "Agustus", "September"],
            "4": ["Oktober", "November", "Desember"]
        };

        function updateTriwulan(selectedTriwulan = null) {
            let semesterVal = $("#semester").val();
            $("#triwulan").html('<option value="">-triwulan-</option>');

            if (semesterVal) {
                triwulanOptions[semesterVal].forEach(function (triwulan) {
                    let selected = triwulan === selectedTriwulan ? 'selected' : '';
                    $("#triwulan").append(`<option value="${triwulan}" ${selected}>${triwulan}</option>`);
                });
            }
        }

        function updateBulan(selectedBulan = null) {
            let triwulanVal = $("#triwulan").val();
            $("#bulan").html('<option value="">-bulan-</option>');

            if (triwulanVal) {
                bulanOptions[triwulanVal].forEach(function (bulan) {
                    let selected = bulan === selectedBulan ? 'selected' : '';
                    $("#bulan").append(`<option value="${bulan}" ${selected}>${bulan}</option>`);
                });
            }
        }

        // Saat halaman dimuat, set nilai yang sudah ada
        updateTriwulan("{{$data->triwulan}}");
        updateBulan("{{$data->bulan}}");

        // Event listener untuk perubahan nilai
        $("#semester").change(function () {
            updateTriwulan();
            $("#bulan").html('<option value="">-bulan-</option>'); // Reset bulan saat semester berubah
        });

        $("#triwulan").change(function () {
            updateBulan();
        });
    });
</script>
@endpush