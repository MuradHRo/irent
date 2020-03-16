<?php

namespace App\Http\Controllers\Dashboard;

use App\Advertisement;
use App\Category;
use App\Http\Controllers\Controller;
use App\Subcategory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PragmaRX\Countries\Package\Countries;


class dashboardController extends Controller
{
    public function index()
    {
        $count['users']=User::whereRoleIs('user')->count();
        $count['advertisements']=Advertisement::all()->count();
        $count['subcategories']=Subcategory::all()->count();
        $count['categories']=Category::all()->count();

        $ads_data= Advertisement::select(
            DB::raw('Year(created_at) as year'),
            DB::raw('Month(created_at) as month'),
            DB::raw('COUNT(id) as count')
        )->groupBy('month')->get();
//        $countries= new Countries();
//
//        dd($countries->where('name.common', 'Egypt')->first()->hydrateStates()->states->pluck('name', 'postal'));
        return view('dashboard.index',compact('count','ads_data'));
    }
}
