<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;

class ExportProductImages extends Command
{
    protected $signature = 'export:product-images';
    protected $description = 'Exporta imágenes de productos del almacén 2039, redimensionadas a 300x300 y renombradas por código';

    public function handle()
    {
        $rutaDestino = public_path('react-images');

        // Crear carpeta si no existe
        if (!File::exists($rutaDestino)) {
            File::makeDirectory($rutaDestino, 0755, true);
        }

        $productos = Product::with('media')->where('almcnt', 2039)->get();
        $exportados = 0;

        foreach ($productos as $producto) {
            if ($producto->hasMedia('images')) {
                $media = $producto->getFirstMedia('images');
                $rutaOriginal = $media->getPath();

                if (File::exists($rutaOriginal)) {
                    $extension = pathinfo($rutaOriginal, PATHINFO_EXTENSION);
                    $nombreFinal = $producto->artcve . '.' . $extension;
                    $rutaDestinoCompleta = $rutaDestino . '/' . $nombreFinal;

                    // Redimensionar la imagen a 300x300 px
                    $imagen = Image::make($rutaOriginal)->fit(600, 600);
                    $imagen->save($rutaDestinoCompleta);

                    $this->info("Imagen exportada y redimensionada: {$nombreFinal}");
                    $exportados++;
                }
            }
        }

        $this->info("Proceso finalizado. Total de imágenes exportadas: {$exportados}");
    }
}
