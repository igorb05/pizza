<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Inertia\Response;

class IndexController extends Controller
{
    /**
     * Рендер главной страницы
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Home/Index');
    }
}
