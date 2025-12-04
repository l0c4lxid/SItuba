<?php

namespace App\Http\Controllers\Puskesmas;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class KelurahanController extends Controller
{
    public function index(Request $request)
    {
        abort_if($request->user()->role !== UserRole::Puskesmas, 403);

        $puskesmas = $request->user();
        $perPage = 10;
        $search = $request->input('q', '');

        $baseQuery = User::query()
            ->with('detail')
            ->where('role', UserRole::Kelurahan->value)
            ->whereHas('detail', fn($detail) => $detail->where('supervisor_id', $puskesmas->id))
            ->when($search !== '', function ($query) use ($search) {
                $term = '%' . $search . '%';
                $query->where(function ($sub) use ($term) {
                    $sub->where('name', 'like', $term)
                        ->orWhereHas('detail', fn($detail) => $detail->where('address', 'like', $term)->orWhere('organization', 'like', $term));
                });
            })
            ->latest();

        $kelurahan = (clone $baseQuery)->paginate($perPage)->withQueryString();

        $stats = [
            'total' => (clone $baseQuery)->count(),
            'active' => (clone $baseQuery)->where('is_active', true)->count(),
            'inactive' => (clone $baseQuery)->where('is_active', false)->count(),
        ];

        return view('puskesmas.kelurahan', [
            'kelurahan' => $kelurahan,
            'search' => $search,
            'stats' => $stats,
        ]);
    }
}
