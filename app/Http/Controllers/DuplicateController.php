<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Product;
use App\Models\ViewImage;
use App\Models\Media;
use App\Models\Empresa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DuplicateController extends Controller
{
    public function index()
    {
        $user =  Auth::user();

        // Obtener el registro de la empresa
        $empresa = Empresa::where('id', $user->almcnt)->first();

        // Verificar si el campo regleyenda tiene datos
        if ($empresa && strlen($empresa->regleyenda) > 0) {
            // El campo regleyenda tiene datos
            return redirect()->route('products.index')->with('success', 'No fue posible cargar el Banco de imagenes, este proceso No puede aplicarse mas de una vez');
        } else {
            // El campo regleyenda está vacío o no existe
            // cargar banco de imagenes
            $products = DB::select("SELECT products.id, viewimages.media_id,
            viewimages.model_type, viewimages.model_id, viewimages.uuid, viewimages.collection_name, viewimages.name, viewimages.file_name, viewimages.mime_type, viewimages.disk, viewimages.conversions_disk, 
            viewimages.size, viewimages.manipulations, viewimages.custom_properties, viewimages.generated_conversions, viewimages.responsive_images, viewimages.order_column
            FROM products
            INNER JOIN viewimages ON products.artcve = viewimages.artcve
            WHERE products.almcnt=".$user->almcnt);

            // crear nuevo registro
            foreach ($products as $product) {
                // Crear un nuevo registro de media y asignar los valores necesarios
                $media = new Media();
                $media->model_type = 'App\Models\Product'; // Opcional: ajusta el modelo según sea necesario
                $media->model_id = $product->id; // O ajusta el campo según corresponda
                // duplicar
                $media->uuid = $product->uuid; 
                $media->collection_name = $product->collection_name;
                $media->name = $product->name;
                $media->file_name = $product->file_name;
                $media->mime_type = $product->mime_type;
                $media->disk = $product->disk;
                $media->conversions_disk = $product->conversions_disk;
                $media->size = $product->size;
                $media->manipulations = $product->manipulations;
                $media->custom_properties = $product->custom_properties;
                $media->generated_conversions = $product->generated_conversions;
                $media->responsive_images = $product->responsive_images;
                $media->order_column = $product->order_column;
                // guardar
                $media->save();
                // last id
                $new_media_id = Media::max('id');
                // duplicar archivo
                $sourcePath = public_path('storage/'.$product->media_id);        
                $destinationPath = public_path('storage/'.$new_media_id);
                $this->duplicateFolderOrFile($sourcePath, $destinationPath);            
            } // 
            
            // Realizar la actualización
            Empresa::where('id', $user->almcnt)->update(['regleyenda' => 'importimages']);        

            // products        
            return redirect()->route('products.index')->with('success', 'Banco de imagenes cargadas correctamente');            
            
        }        

        

    } // function

    public function duplicateFolderOrFile($sourcePath, $destinationPath)
    {
        // Verificar si la carpeta de origen existe
        if (File::exists($sourcePath)) {
            // Copiar la carpeta y su contenido al destino
            File::copyDirectory($sourcePath, $destinationPath);

            return response()->json(['message' => 'Carpeta duplicada exitosamente']);
        } elseif (File::exists($sourcePath)) {
            // Copiar el archivo al destino
            File::copy($sourcePath, $destinationPath);

            return response()->json(['message' => 'Archivo duplicado exitosamente']);
        } else {
            return response()->json(['error' => 'El archivo o carpeta de origen no existe'], 404);
        }
    }    

} // class
