@extends('layouts.soft')

@section('content')
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Skrining</p>
                                <h5 class="font-weight-bolder">1.250</h5>
                                <p class="mb-0">
                                    <span class="text-success text-sm font-weight-bolder">+15%</span>
                                    dari bulan lalu
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="fa-solid fa-stethoscope text-white text-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Sedang Berobat</p>
                                <h5 class="font-weight-bolder">320</h5>
                                <p class="mb-0">
                                    <span class="text-danger text-sm font-weight-bolder">-4%</span>
                                    dari minggu lalu
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-danger shadow text-center border-radius-md">
                                <i class="fa-solid fa-syringe text-white text-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Selesai Berobat</p>
                                <h5 class="font-weight-bolder">910</h5>
                                <p class="mb-0">
                                    <span class="text-success text-sm font-weight-bolder">+8%</span>
                                    pasien sembuh
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                <i class="fa-solid fa-heart-circle-check text-white text-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Pengguna Aktif</p>
                                <h5 class="font-weight-bolder">150</h5>
                                <p class="mb-0">
                                    <span class="text-success text-sm font-weight-bolder">+3</span>
                                    pengguna baru
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                <i class="fa-solid fa-users text-white text-lg"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-7 mb-lg-0 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Aktivitas Terkini</h6>
                    <p class="text-sm">
                        <i class="fa fa-arrow-up text-success" aria-hidden="true"></i>
                        <span class="font-weight-bold">24 laporan</span> masuk hari ini
                    </p>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <img src="{{ asset('assets/img/curved-images/white-curved.jpeg') }}" alt="chart placeholder" class="w-100 rounded">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <h6>Ringkasan Tugas</h6>
                    <p class="text-sm">Pantau progres skrining, pengobatan, hingga pasien sembuh.</p>
                </div>
                <div class="card-body p-3">
                    <ul class="list-group">
                        <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                            <div class="avatar me-3">
                                <i class="fa-solid fa-magnifying-glass-chart text-primary"></i>
                            </div>
                            <div class="d-flex align-items-start flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">Skrining terbaru</h6>
                                <p class="mb-0 text-xs">12 warga sedang diproses</p>
                            </div>
                            <span class="badge bg-gradient-primary ms-auto">Review</span>
                        </li>
                        <li class="list-group-item border-0 d-flex align-items-center px-0 mb-2">
                            <div class="avatar me-3">
                                <i class="fa-solid fa-heart-pulse text-danger"></i>
                            </div>
                            <div class="d-flex align-items-start flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">Pasien berobat</h6>
                                <p class="mb-0 text-xs">6 jadwal kontrol hari ini</p>
                            </div>
                            <span class="badge bg-gradient-danger ms-auto">Follow up</span>
                        </li>
                        <li class="list-group-item border-0 d-flex align-items-center px-0">
                            <div class="avatar me-3">
                                <i class="fa-solid fa-check-double text-success"></i>
                            </div>
                            <div class="d-flex align-items-start flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">Pasien sembuh</h6>
                                <p class="mb-0 text-xs">3 pasien siap konsultasi akhir</p>
                            </div>
                            <span class="badge bg-gradient-success ms-auto">Selesai</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
