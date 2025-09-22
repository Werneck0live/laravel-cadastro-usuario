<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class PainelController extends Controller
{
    public function index(){
    	route('usuarios.index');
    }
}
