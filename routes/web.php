<?php

use App\Enums\UserRole;
use App\Http\Controllers\ProfileController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Pemda\ProfileController as PemdaProfileController;

Route::redirect('/', '/login')->name('home');

Route::middleware('auth')->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/pemda/verifikasi', function (Request $request) {
        abort_if(auth()->user()->role !== UserRole::Pemda, 403);

        $pendingUsers = User::query()
            ->with('detail')
            ->where('role', '!=', UserRole::Pemda->value)
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = '%'.$request->input('q').'%';
                $query->where(function ($sub) use ($term) {
                    $sub->where('name', 'like', $term)
                        ->orWhere('phone', 'like', $term)
                        ->orWhereHas('detail', function ($detail) use ($term) {
                            $detail->where('organization', 'like', $term)
                                ->orWhere('address', 'like', $term);
                        });
                });
            })
            ->latest()
            ->get();

        return view('pemda.verification', [
            'records' => $pendingUsers,
            'search' => $request->input('q', ''),
        ]);
    })->name('pemda.verification');

    Route::post('/pemda/verifikasi/{user}/status', function (Request $request, User $user) {
        abort_if(auth()->user()->role !== UserRole::Pemda, 403);

        $validated = $request->validate([
            'status' => ['required', 'in:active,inactive'],
        ]);

        $user->is_active = $validated['status'] === 'active';
        $user->save();

        return back()->with('status', 'Status pengguna berhasil diperbarui.');
    })->name('pemda.verification.status');

    Route::post('/pemda/verifikasi/bulk/status', function (Request $request) {
        abort_if(auth()->user()->role !== UserRole::Pemda, 403);

        $validated = $request->validate([
            'status' => ['required', 'in:active,inactive'],
        ]);

        User::where('role', '!=', UserRole::Pemda->value)
            ->update(['is_active' => $validated['status'] === 'active']);

        return back()->with('status', 'Semua status pengguna berhasil diperbarui.');
    })->name('pemda.verification.bulk-status');

    Route::get('/pemda/profil', [PemdaProfileController::class, 'edit'])
        ->name('pemda.profile.edit');
    Route::put('/pemda/profil', [PemdaProfileController::class, 'update'])
        ->name('pemda.profile.update');
});

require __DIR__.'/auth.php';
