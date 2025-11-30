<?php

namespace App\Http\Controllers\Kader;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Support\SigapMaterial;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index(Request $request)
    {
        abort_if($request->user()->role !== UserRole::Kader, 403);

        return view('kader.materi', [
            'downloads' => SigapMaterial::downloads(),
        ]);
    }
}
