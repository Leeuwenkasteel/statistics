<?php

namespace Leeuwenkasteel\Statistics\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Leeuwenkasteel\Templates\Models\Apps;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;

class AppController extends Controller implements HasMiddleware
{  
    public static function middleware(): array
    {
        return [
            //new Middleware('permission:stock.index', only: ['index']),
			//new Middleware('app.auth:stock', except: ['index', 'login']),
        ];
    }
    public function index(){
		$page = 'statistics';
		$app = Apps::whereSlug($page)->get()->first();
        return view('templates::pages.install', compact('app'));
    }
	
	public function login(){
		return view('statistics::login');
	}
	
	public function home(){
		return view('statistics::home');
	}
	
	
	public function logout()
	{
		setcookie('login_statistics', '', time() - 3600, '/statistics/app');
		setcookie('login_statistics_user', '', time() - 3600, '/statistics/app');

		return redirect()->route('statistics.login');
	}
	
}