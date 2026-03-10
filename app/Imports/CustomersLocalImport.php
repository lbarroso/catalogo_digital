<?php

namespace App\Imports;

use App\Models\CustomerLocal;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class CustomersLocalImport implements ToCollection, WithStartRow, WithChunkReading, SkipsEmptyRows
{
    public function __construct(private int $almcnt) {}

    /**
     * En tu Excel heredado: encabezados en fila 6 y datos desde fila 7.
     */
    public function startRow(): int
    {
        return 7;
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function collection(Collection $rows)
    {
        $now = now();
        $payload = [];

        foreach ($rows as $row) {
            // Mapeo por índice (Excel heredado estable)
            // 0 Ruta Sup, 1 Nombre Sup, 2 Canal, 3 Cliente, 4 Encargado, 5 Localidad, 6 Fecha Nac, ...
            $ctecveRaw = $row[3] ?? null;
            $ctecve = is_numeric($ctecveRaw) ? (int) $ctecveRaw : null;

            if (!$ctecve) {
                continue; // fila inválida o vacía
            }

            $payload[] = [
                'almcnt'          => $this->almcnt,
                'ruta_sup'        => $this->toInt($row[0] ?? null),
                'nombre_sup'      => $this->toString($row[1] ?? null),
                'canal'           => $this->toInt($row[2] ?? null),
                'ctecve'          => $ctecve,
                'encargado'       => $this->toString($row[4] ?? null),
                'localidad'       => $this->toString($row[5] ?? null),
                'fecha_nac'       => $this->parseDate($row[6] ?? null),
                'rfc'             => $this->toString($row[7] ?? null),
                'curp'            => $this->toString($row[8] ?? null),
                'rpu'             => $this->toInt($row[9] ?? null),
                'sexo'            => $this->toString($row[10] ?? null),
                'telefono'        => $this->toString($row[11] ?? null),
                'codigo_postal'   => $this->toString($row[12] ?? null),
                'fecha_pos'       => $this->parseDate($row[13] ?? null),
                'rit'             => $this->toString($row[14] ?? null),
                'capital_diconsa' => $this->toDecimal($row[15] ?? null),
                'capital_comunit' => $this->toDecimal($row[16] ?? null),
                'longitud'        => $this->toDecimal($row[17] ?? null),
                'latitud'         => $this->toDecimal($row[18] ?? null),
                'fecha_apertura'  => $this->parseDate($row[19] ?? null),
                'created_at'      => $now,
                'updated_at'      => $now,
            ];
        }

        if (empty($payload)) {
            return;
        }

        // UPSERT local (requiere unique(almcnt, ctecve) ya creado en la migración)
        CustomerLocal::upsert(
            $payload,
            ['almcnt', 'ctecve'],
            [
                'ruta_sup','nombre_sup','canal','encargado','localidad','fecha_nac','rfc','curp','rpu',
                'sexo','telefono','codigo_postal','fecha_pos','rit','capital_diconsa','capital_comunit',
                'longitud','latitud','fecha_apertura','updated_at'
            ]
        );
    }



    private function toString($v): ?string
    {
        if ($v === null) return null;

        // PhpSpreadsheet a veces regresa RichText
        if (is_object($v) && method_exists($v, '__toString')) {
            $v = (string) $v;
        }

        $s = trim((string) $v);
        if ($s === '') return null;

        // 1) Elimina caracteres de control invisibles (excepto \n \r \t si los quisieras)
        $s = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $s) ?? $s;

        // 2) Asegura UTF-8 (si viniera en otro encoding, lo convertimos)
        //    - Si ya es UTF-8 válido, se queda igual.
        if (!mb_check_encoding($s, 'UTF-8')) {
            $s = mb_convert_encoding($s, 'UTF-8', 'Windows-1252');
        }

        // 3) Repara mojibake común (doble interpretación)
        //    Ejemplos: "CAÃ‘ADA" -> "CAÑADA", "NIÃ‘O" -> "NIÑO"
        $replacements = [
            'Ã‘' => 'Ñ',
            'Ã?' => 'Ñ',
            'Ã±' => 'ñ',
            'Â'  => '',   // a veces aparece como "Â " antes de símbolos
        ];
        $s = strtr($s, $replacements);

        // 4) Normaliza espacios
        $s = preg_replace('/\s+/u', ' ', $s) ?? $s;

        return $s;
    }    

    private function toInt($v): ?int
    {
        return is_numeric($v) ? (int)$v : null;
    }

    private function toDecimal($v): ?float
    {
        return is_numeric($v) ? (float)$v : null;
    }

    private function parseDate($v): ?string
    {
        if (empty($v)) return null;

        // Si viene como número Excel (serial date)
        if (is_numeric($v)) {
            try {
                return ExcelDate::excelToDateTimeObject($v)->format('Y-m-d');
            } catch (\Throwable $e) {
                return null;
            }
        }

        // Si viene como texto (ej: 12/02/2026)
        $s = trim((string)$v);
        try {
            return Carbon::createFromFormat('d/m/Y', $s)->format('Y-m-d');
        } catch (\Throwable $e) {
            // fallback: Carbon parse
            try {
                return Carbon::parse($s)->format('Y-m-d');
            } catch (\Throwable $e2) {
                return null;
            }
        }
    }
}