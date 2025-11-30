<?php

namespace App\Support;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SigapMaterial
{
    public static function downloads(): Collection
    {
        $pdfDirectory = public_path('pdf');

        if (!File::exists($pdfDirectory)) {
            return collect();
        }

        return collect(File::files($pdfDirectory))
            ->filter(fn($file) => strtolower($file->getExtension()) === 'pdf')
            ->sortByDesc(fn($file) => $file->getMTime())
            ->values()
            ->map(fn($file) => [
                'name' => Str::headline(str_replace(['_', '-'], ' ', pathinfo($file->getFilename(), PATHINFO_FILENAME))),
                'filename' => $file->getFilename(),
                'url' => asset('pdf/' . $file->getFilename()),
                'updated_at' => Carbon::createFromTimestamp($file->getMTime()),
                'size' => max(1, round($file->getSize() / 1024)),
            ]);
    }
}
