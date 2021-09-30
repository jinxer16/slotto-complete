<?php

namespace App\Http\Controllers\Frontend;

use App\Casino;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CasinoController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request, $id, $slug = null)
    {
        $casino = Casino::findOrFail($id);
        return view('frontend.casino', compact('casino'));
    }
}
