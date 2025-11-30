<?php

namespace App\Http\Controllers\Puskesmas;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ScreeningController extends Controller
{
    public function index(Request $request)
    {
        abort_if($request->user()->role !== UserRole::Puskesmas, 403);

        $perPage = 10;
        $kaderIds = User::query()
            ->where('role', UserRole::Kader->value)
            ->whereHas('detail', fn($detail) => $detail->where('supervisor_id', $request->user()->id))
            ->pluck('id');

        $patients = $kaderIds->isEmpty()
            ? new LengthAwarePaginator([], 0, $perPage, 1, [
                'path' => $request->url(),
                'query' => $request->query(),
            ])
            : User::query()
                ->with([
                    'detail',
                    'detail.supervisor',
                    'screenings' => fn($query) => $query->latest()->limit(1),
                ])
                ->where('role', UserRole::Pasien->value)
                ->whereHas('detail', fn($detail) => $detail->whereIn('supervisor_id', $kaderIds))
                ->when($request->filled('q'), function ($query) use ($request) {
                    $term = '%' . $request->input('q') . '%';
                    $query->where(function ($sub) use ($term) {
                        $sub->where('name', 'like', $term)
                            ->orWhere('phone', 'like', $term)
                            ->orWhereHas('detail', function ($detail) use ($term) {
                                $detail->where('address', 'like', $term)
                                    ->orWhere('nik', 'like', $term);
                            });
                    });
                })
                ->latest()
                ->paginate($perPage)
                ->withQueryString();

        return view('puskesmas.screenings', [
            'patients' => $patients,
            'search' => $request->input('q', ''),
        ]);
    }
}
