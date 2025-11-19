@extends('layouts.soft')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body d-flex flex-column gap-4">
                    <div class="flip-embed mx-auto">
                        <iframe src="https://online.fliphtml5.com/knjzd/lkag/" title="Flipbook Materi Kader" frameborder="0"
                            allowfullscreen loading="lazy"></iframe>
                    </div>
                    @if ($downloads->count())
                        <div class="downloads card shadow-sm border-0">
                            <div class="card-header">
                                <h6 class="mb-0">Unduhan PDF</h6>
                                <p class="text-sm text-muted mb-0">Salin versi PDF untuk dibaca offline atau dibagikan ke kader
                                    lain.</p>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    @foreach ($downloads as $item)
                                        <div class="col-12 col-md-6 col-lg-4">
                                            <div class="download-item">
                                                <div>
                                                    <h6 class="mb-1 text-truncate">{{ $item['name'] }}</h6>
                                                    <p class="text-xs text-muted mb-1">
                                                        {{ $item['updated_at']->translatedFormat('d M Y') }} ·
                                                        {{ $item['size'] }} KB
                                                    </p>
                                                </div>
                                                <a href="{{ $item['url'] }}" class="btn btn-sm btn-outline-primary w-100"
                                                    download>
                                                    <i class="ri-download-cloud-2-line me-1"></i> Unduh PDF
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .flip-embed {
            position: relative;
            width: min(100%, 1100px);
            min-height: 75vh;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 30px 70px rgba(15, 23, 42, 0.18);
            background: #000;
        }

        .flip-embed iframe {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        .flip-embed::after {
            content: "";
            position: absolute;
            inset: auto 0 0;
            height: 80px;
            background: linear-gradient(180deg, rgba(15, 23, 42, 0) 0%, rgba(15, 23, 42, 0.65) 100%);
            pointer-events: none;
        }

        @media (max-width: 768px) {
            .flip-embed {
                min-height: calc(100vh - 10rem);
                border-radius: 0;
                margin: 0 -1.25rem;
            }
        }

        .downloads .download-item {
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 16px;
            padding: 1rem;
            background: rgba(248, 250, 252, 0.7);
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            height: 100%;
        }
    </style>
@endpush
