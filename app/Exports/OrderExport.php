<?php

namespace App\Exports;

use App\Models\Order;
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
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;

class OrderExport implements FromQuery, WithHeadings, 
WithMapping, ShouldAutoSize, WithColumnFormatting,WithStyles,WithBackgroundColor

{
    public $i = 2;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Order::where('user_id',auth()->id());
    }

    public function headings(): array
    {
        // return [
        //     ['id','invoices'],
        //     ['otro encabezado']
        // ];

        return ['id','invoices','subtotal','descuentos','impuesto','total','data',''];
    }

    public function map($row): array
    {
        $i = $this->i;
        $cadena = "=sum(C$i:F$i)";
        $this->i++;
        return [
            $row->id,
            $row->invoice,
            $row->subtotal,
            $row->discounts,
            $row->tax,
            $row->total,
            $cadena,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_CURRENCY_USD_SIMPLE,
            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('G1:H1');
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

    public function backgroundColor()
    {
        // Return RGB color code.
        // return '000000';
    
        // Return a Color instance. The fill type will automatically be set to "solid"
        // return new Color(ColoR::COLOR_BLUE);
    
        // Or return the styles array
        // return [
        //      'fillType'   => Fill::FILL_GRADIENT_LINEAR,
        //      'startColor' => ['argb' => Color::COLOR_RED],
        // ];
    }
}
