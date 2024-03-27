<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocdetasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // Inserta 10 registros en la tabla 'docdetas'
        for ($i = 1; $i <= 10; $i++) {
            DB::table('docdetas')->insert([
                'docmes' => 'valor_docmes_'.$i,
                'docord' => 'valor_docord_'.$i,
                'artcve' => 'valor_artcve_'.$i,
                'codbarras' => 'valor_codbarras_'.$i,
                'artdesc' => 'valor_artdesc_'.$i,
                'artprcosto' => 'valor_artprcosto_'.$i,
                'artdescto' => 'valor_artdescto_'.$i,
                'artprventa' => 'valor_artprventa_'.$i,
                'artpesogrm' => 'valor_artpesogrm_'.$i,
                'artpesoum' => 'valor_artpesoum_'.$i,
                'artganancia' => 'valor_artganancia_'.$i,
                'doccant' => 'valor_doccant_'.$i,
                'docstatus' => 'valor_docstatus_'.$i,
                'docsession' => 'valor_docsession_'.$i,
                'numberid' => 'valor_numberid_'.$i,
                'user_id' => 'valor_user_id_'.$i,
                'uuid' => 'valor_uuid_'.$i,
            ]);
        }
    }

} // seeder
