<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\alumnidatabases;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.admin.dashboard',[
            'banyakdata' => alumnidatabases::count(),
            'dataterbit' => alumnidatabases::whereNotNull('tanggal_terbit')->count(),
            'databelum' => alumnidatabases::whereNull('tanggal_pengambilan')->count(),
        ]);
    }
}
