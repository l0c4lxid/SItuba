<?php

namespace App\Http\Controllers\Kader;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PuskesmasController extends Controller
{
    public function show(Request $request)
    {
        abort_if($request->user()->role !== UserRole::Kader, 403);

        $request->user()->loadMissing('detail');
        $puskesmasId = optional($request->user()->detail)->supervisor_id;

        $puskesmas = null;
        if ($puskesmasId) {
            $puskesmas = User::query()
                ->with('detail')
                ->where('role', UserRole::Puskesmas->value)
                ->where('id', $puskesmasId)
                ->first();
        }

        return view('kader.puskesmas', [
            'puskesmas' => $puskesmas,
        ]);
    }
}
