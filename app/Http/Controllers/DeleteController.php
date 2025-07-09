<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeleteController extends Controller
{
    
    public function index(Request $request)
    {

        $user =  Auth::user();
        $almcnt = 2017;

        // Obtener lod IDs de los medias que deben eliminar
        $medias = DB::select("SELECT media.id FROM products INNER JOIN media ON products.id = media.model_id WHERE products.almcnt=".$almcnt);
        //$medias = DB::select("");
        

        // 
        foreach ($medias as $media) {
            
            // eliminar directorio
            $sourcePath = public_path('storage/'.$media->id);

            $this->deleteDirectory($sourcePath);
        
        } // 
        
        // $medias = Media::join('products','products.id', '=', 'media.model_id')
        // ->where('products.almcnt',$almcnt)
        // ->pluck('media.id');        

        // Eliminar los registros de la tabla
        // Media::destroy($medias);
        
        // products        
        return response()->json(['message' => 'proceso completo eliminado exitosamente 2014']);

    } // function

    public function deleteDirectory($sourcePath){

        // Verificar si la carpeta de origen existe
        if (File::exists($sourcePath)) {

            // Copiar la carpeta y su contenido al destino
            File::deleteDirectory($sourcePath);

            return response()->json(['message' => 'Carpeta eliminado exitosamente']);

        }   
        
        return response()->json(['error' => 'El archivo o carpeta de origen no existe'], 404);
        
    }

    /***
        DELETE FROM media
        WHERE id IN(
            SELECT media.id
            FROM products
            INNER JOIN media ON products.id = media.model_id
            WHERE products.almcnt = 2017
        );
     */

} // class
