@extends('layouts.soft')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header d-flex flex-wrap gap-3 justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Monitoring Skrining Pasien</h5>
                        <p class="text-sm text-muted mb-0">Pantau status skrining pasien binaan kader mitra puskesmas.</p>
                    </div>
                    <form method="GET" action="{{ route('puskesmas.screenings') }}" class="d-flex flex-wrap gap-2 align-items-center">
                        <div class="input-group input-group-sm" style="min-width: 260px;">
                            <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" name="q" class="form-control" placeholder="Cari nama / nomor HP / alamat" value="{{ $search ?? '' }}">
                        </div>
                        <button type="submit" class="btn btn-sm btn-outline-success">Cari</button>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pasien</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kader</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status Skrining</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Terakhir Skrining</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Kontak</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($patients as $patient)
                                    @php
                                        $latestScreening = $patient->screenings->first();
                                        $answers = collect($latestScreening->answers ?? []);
                                        $positiveCount = $answers->filter(fn ($answer) => $answer === 'ya')->count();

                                        if (! $latestScreening) {
                                            $statusBadge = ['label' => 'Belum skrining', 'class' => 'bg-gradient-secondary'];
                                        } elseif ($positiveCount >= 2) {
                                            $statusBadge = ['label' => 'Suspek TBC', 'class' => 'bg-gradient-danger'];
                                        } elseif ($positiveCount === 1) {
                                            $statusBadge = ['label' => 'Perlu observasi', 'class' => 'bg-gradient-warning text-dark'];
                                        } else {
                                            $statusBadge = ['label' => 'Aman', 'class' => 'bg-gradient-success'];
                                        }

                                        $waNumber = preg_replace('/[^0-9]/', '', $patient->phone ?? '');
                                        if (Str::startsWith($waNumber, '0')) {
                                            $waNumber = '62'.substr($waNumber, 1);
                                        }

                                        $waMessage = rawurlencode('Halo '.$patient->name.'. Kami dari puskesmas ingin menindaklanjuti skrining TBC Anda. Silakan datang untuk pemeriksaan lanjutan.');
                                        $waLink = $waNumber ? 'https://wa.me/'.$waNumber.'?text='.$waMessage : null;
                                    @endphp
                                    <tr>
                                        <td>
                                            <h6 class="mb-0 text-sm">{{ $patient->name }}</h6>
                                            <p class="text-xs text-muted mb-0">{{ $patient->detail->address ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-sm fw-semibold mb-0">{{ $patient->detail->supervisor->name ?? '-' }}</p>
                                            <p class="text-xs text-muted mb-0">{{ $patient->detail->supervisor->phone ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <span class="badge {{ $statusBadge['class'] }}">{{ $statusBadge['label'] }}</span>
                                            @if ($latestScreening)
                                                <p class="text-xs text-muted mb-0">{{ $positiveCount }} indikasi positif</p>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($latestScreening)
                                                <span class="text-xs text-muted">{{ $latestScreening->created_at->format('d M Y H:i') }}</span>
                                            @else
                                                <span class="text-xs text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column gap-2">
                                                <span class="text-xs text-muted">{{ $patient->phone }}</span>
                                                @if ($waLink)
                                                    <a href="{{ $waLink }}" target="_blank" class="btn btn-sm btn-success">
                                                        <i class="fa-brands fa-whatsapp me-1"></i> Chat Puskesmas
                                                    </a>
                                                @else
                                                    <span class="badge bg-light text-muted">Nomor tidak valid</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">Belum ada pasien binaan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
