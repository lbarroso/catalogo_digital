<?php

namespace App\Http\Controllers;
use App\Familia;
use App\Models\Product;
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
        
        return view('home', compact('numRegistros'));
    }

    public function adminlte()
    {

        $familias = Familia::paginate();

        return view('test.adminlte', compact('familias'))
            ->with('i', (request()->input('page', 1) - 1) * $familias->perPage());

        // return view('test.adminlte');
        
    }

}
