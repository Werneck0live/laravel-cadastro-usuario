<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiteController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }


    public function index()
    {
        return view('site.painel.users.index');
    }

    public function contato()
    {
        return 'Contato do Site';
    }

    public function categoria()
    {
        return 'Categoria do Site';
    }
    
}
