<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Excel;
use Illuminate\Contracts\Support\Responsable;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithBackgroundColor;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CatalogoExport implements FromCollection, Responsable, WithHeadings,
WithColumnFormatting
{
    use Exportable;
    
    /**
    * It's required to define the fileName within
    * the export class when making use of Responsable.
    */
    private $fileName = 'catalogo.xlsx';
    
    /**
    * Optional Writer Type
    */
    private $writerType = Excel::XLSX;
    
    /**
    * Optional headers
    */
    private $headers = [
        'Content-Type' => 'text/csv',
    ];

    public function collection()
    {
        $products = Product::select('id', 'codbarras', 'artdesc', 'artprcosto', 'artprventa', 'stock')
        ->where('stock', '>', 0)
        ->orderBy('artdesc', 'asc')
        ->get();
    
        // return Product::all();
        return $products;
    }
    
    public function headings(): array
    {
        // return [
        //     ['id','invoices'],
        //     ['otro encabezado']
        // ];

        return ['Id','Codigo','Descripcion','Costo','Venta','Existencia','valorcosto','valorventa'];
    }
    
    public function columnFormats(): array
    {
        return [ 
            'A' => NumberFormat::FORMAT_NUMBER,
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'F' => NumberFormat::FORMAT_NUMBER_00,
        ];
    }    
    
    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('D1:E1');
        // $sheet->setMergeColumn([
        //     'columns' => array('G','H');

        // ]);
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],

            // Styling a specific cell by coordinate.
            'B2' => ['font' => ['italic' => true]],

            // Styling an entire column.
            'C'  => ['font' => ['size' => 16]],
        ];
    }    
    
  
}