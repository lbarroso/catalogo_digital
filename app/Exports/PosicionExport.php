<?php



namespace App\Exports;



use App\Models\Product;

use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\FromView;

use Illuminate\Contracts\View\View;

use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

use Maatwebsite\Excel\Concerns\WithColumnFormatting;

use PhpOffice\PhpSpreadsheet\Cell;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;




class PosicionExport implements FromView, WithColumnFormatting

{

    /**

    * @return \Illuminate\Support\Collection

    */

    public function view():View

    {
        $user =  Auth::user();

        $products = DB::select("SELECT 
        products.category_id, 
        products.artcve, 
        products.artdesc, 
        products.artseccion, 
        products.artpesoum,
        products.artpesogrm, 
        products.artprventa, 
        products.stock 
        FROM products WHERE products.almcnt =".$user->almcnt." AND products.stock > 0 GROUP BY products.artcve, products.artdesc, products.artseccion, products.artpesoum, products.artprventa, products.stock        
        ORDER BY products.category_id, products.artcve, products.artseccion");

        return view('exports.posicion',['products' => $products ]);

    }

    

    public function columnFormats(): array

    {

        return [

            'A' => NumberFormat::FORMAT_NUMBER,

            'B' => NumberFormat::FORMAT_TEXT,

            'C' => NumberFormat::FORMAT_TEXT,

            'D' => NumberFormat::FORMAT_NUMBER,

            'E' => NumberFormat::FORMAT_NUMBER,

            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,

            'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,

            'H' => NumberFormat::FORMAT_NUMBER,

        ];

    }

    

    

}