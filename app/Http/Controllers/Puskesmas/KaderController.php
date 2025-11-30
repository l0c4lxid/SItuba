<?php

namespace App\Http\Controllers\Puskesmas;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class KaderController extends Controller
{
    public function index(Request $request)
    {
        abort_if($request->user()->role !== UserRole::Puskesmas, 403);

        $perPage = 10;

        $kaders = User::query()
            ->with('detail')
            ->where('role', UserRole::Kader->value)
            ->whereHas('detail', fn($detail) => $detail->where('supervisor_id', $request->user()->id))
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = '%' . $request->input('q') . '%';
                $query->where(function ($sub) use ($term) {
                    $sub->where('name', 'like', $term)
                        ->orWhere('phone', 'like', $term)
                        ->orWhereHas('detail', fn($detail) => $detail->where('notes', 'like', $term));
                });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('puskesmas.kaders', [
            'kaders' => $kaders,
            'search' => $request->input('q', ''),
        ]);
    }
}
