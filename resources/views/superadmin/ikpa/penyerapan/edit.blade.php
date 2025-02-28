@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Edit Data</h3>

            </div>
            <form method="POST" action="/superadmin/ikpa/deviasi/edit/{{$data->id}}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">SKPD</label>
                        <select class="form-control" required name="skpd_id" readonly>
                            <option value="">-skpd-</option>
                            @foreach (skpd() as $item)
                            <option value="{{$item->id}}" {{$data->skpd_id == $item->id ?
                                'selected':''}}>{{$item->nama}}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">TAHUN</label>
                        <select class="form-control" required name="tahun" readonly>
                            <option value="">-tahun-</option>
                            <option value="2025" {{$data->tahun =="2025" ? 'selected':''}}>2025</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Upload Excel</label>
                        <input type="file" name="file" class="form-control">
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

    $("#semester").change(function () {
    let semesterVal = $(this).val();
    $("#triwulan").html('<option value="">-triwulan-</option>');
    $("#bulan").html('<option value="">-bulan-</option>');

    if (semesterVal) {
    triwulanOptions[semesterVal].forEach(function (triwulan) {
    $("#triwulan").append('<option value="' + triwulan + '">' + triwulan + '</option>');
    });
    }
    });

    $("#triwulan").change(function () {
    let triwulanVal = $(this).val();
    $("#bulan").html('<option value="">-bulan-</option>');

    if (triwulanVal) {
    bulanOptions[triwulanVal].forEach(function (bulan) {
    $("#bulan").append('<option value="' + bulan + '">' + bulan + '</option>');
    });
    }
    });
    });
</script>
@endpush