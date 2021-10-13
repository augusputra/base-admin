<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class DashboardController extends Controller
{
    public function index(Request $request){
        $page_title = 'Dashboard';
        $page_description = 'Summary for all activity';
        $sess = Session::get('auth');

        return view('admin.pages.dashboard.index', compact('page_title', 'page_description'));
    }
}
