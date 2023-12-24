@extends('layout.main')

@section('content')
    <div class="justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <div class="row">
            <div class="col-6">
                <img src="{{ asset('assets/img/jamilur.jpg') }}" alt="" class="rounded" width="100">
                <h4>Jamilur Rusydi Al Miichtari</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <label for="NamaKandidat" class="form-label">Nama Kandidat</label>
                <input type="text" class="form-control" id="NamaKandidat" value="Jamilur Rusydi Al Miichtari">
            </div>
            <div class="col-md-4    ">
                <label for="PosisiKandidat" class="form-label">Posisi Kandidat</label>
                <input type="text" class="form-control" id="PosisiKandidat" value="Web Programmer">
            </div>
        </div>
    </div>
@endsection
