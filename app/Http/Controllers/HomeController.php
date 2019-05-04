<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Pastpaper;
use App\Unit;
use App\Department;
use App\Admin;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function admin_index()
    {
        $users[] = Auth::user();
        $users[] = Auth::guard()->user();
        $users[] = Auth::guard('admin')->user();

        $pastpapersCount = Pastpaper::count();
        $adminsCount = Admin::count();
        $departmentsCount = Department::count();
        $unitsCount = Unit::count();

        $data = [
            'pastpapersCount' => $pastpapersCount,
            'adminsCount' => $adminsCount,
            'departmentsCount' => $departmentsCount,
            'unitsCount' => $unitsCount
        ];

        return view('admin.home')->with($data);
    }
}
