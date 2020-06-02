<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Category;
use App\Attractive;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $attractives = Attractive::count();
        $activities =  Activity::count();
        $categories = Category::count();

        return [
            'attractives' => $attractives,
            'activities' => $activities,
            'categories' => $categories
        ];
    }

}
