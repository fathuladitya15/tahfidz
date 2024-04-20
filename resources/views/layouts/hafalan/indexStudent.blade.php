@extends('layouts.Master')
@section('title') {{ 'Data Hafalan' }} @endsection


@section('content')
<div class="row">
    <div class="col-md-6 col-lg-6 col-xl-12 order-0 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between pb-0">
                <div class="card-title mb-0">
                    <h5 class="m-0 me-2">Hafalan Statistik</h5>
                </div>
            </div>
          <div class="card-body">
            <br>
            <ul class="p-0 m-0">
                <li class="d-flex mb-4 pb-1">
                    <div class="avatar flex-shrink-0 me-3">
                        <span class="avatar-initial rounded bg-label-success"><i class="bx bx-bar-chart-square"></i></span>
                    </div>
                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <h6 class="mb-0">Ayat</h6>
                            <small class="text-muted">Ayat yang disetorkan</small>
                        </div>
                        <div class="user-progress">
                            <div class="progress" style="width: 900px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: {{ $percentAyat }}%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                    {{ $percentAyat }} %
                                </div>
                            </div>
                            <small class="fw-semibold" style="float: right;">{{ $totalAyat }} / 6.666 Ayat </small>
                        </div>
                    </div>
                </li>
                <!-- Juz -->

                <li class="d-flex mb-4 pb-1">
                    <div class="avatar flex-shrink-0 me-3">
                        <span class="avatar-initial rounded bg-label-info"><i class="bx bx-bar-chart-square"></i></span>
                    </div>
                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                        <div class="me-2">
                            <h6 class="mb-0">Juz</h6>
                            <small class="text-muted">Juz yang disetorkan</small>
                        </div>
                        <div class="user-progress">
                            <div class="progress" style="width: 900px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width: {{ $percentJuz }}%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                    {{ $percentJuz }} %
                                </div>
                            </div>
                            <small class="fw-semibold" style="float: right;">{{ $totalJuz }} / 30 Juz </small>
                        </div>
                    </div>
                </li>
            </ul>
          </div>
        </div>
    </div>
</div>
@endsection
@push('js')



@endpush
