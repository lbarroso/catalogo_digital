<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



class ReportController extends Controller
{
    
    function reportsDiarios()
    {
        return view('reports.diarios');
    }

} // class
