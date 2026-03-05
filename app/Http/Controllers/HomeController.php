<?php

namespace App\Http\Controllers;
use App\Familia;
use App\Models\Product;
use App\Models\Empresa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user =  Auth::user();
        // Obtener el registro de la empresa
        $numRegistros = Product::where('almcnt', $user->almcnt)->count();
        // obtener el registro de la empresa
        $empresa = Empresa::where('id', $user->almcnt)->first();
        return view('home', compact('numRegistros', 'empresa'));
    }

    public function adminlte()
    {

        /**
         * 
         */
        
    }

}
