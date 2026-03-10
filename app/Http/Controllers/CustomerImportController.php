<?php

namespace App\Http\Controllers;

use App\Imports\CustomersLocalImport;
use App\Models\CustomerLocal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class CustomerImportController extends Controller
{
    /**
     * Lista paginada de clientes locales (customers_local)
     * con búsqueda simple.
     */
    public function index(Request $request)
    {
        $almcnt = (int) Auth::user()->almcnt;

        // Buscador global simple
        $q = trim((string) $request->get('q', ''));

        $customers = CustomerLocal::query()
            ->where('almcnt', $almcnt)
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('ctecve', 'like', "%{$q}%")
                        ->orWhere('localidad', 'like', "%{$q}%")
                        ->orWhere('encargado', 'like', "%{$q}%")
                        ->orWhere('telefono', 'like', "%{$q}%")
                        ->orWhere('rfc', 'like', "%{$q}%")
                        ->orWhere('curp', 'like', "%{$q}%")
                        ->orWhere('canal', 'like', "%{$q}%");
                });
            })
            ->orderBy('localidad', 'asc')
            ->paginate(25)
            ->appends($request->query()); // conserva ?q=... en paginación

        return view('admin.customers.index', compact('customers', 'almcnt', 'q'));
    }

    /**
     * Vista de importación Excel.
     */
    public function create()
    {
        return view('admin.customers.import');
    }

    /**
     * Importar Excel a customers_local (upsert local).
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls'],
        ]);

        $almcnt = (int) Auth::user()->almcnt;

        Excel::import(new CustomersLocalImport($almcnt), $request->file('file'));
        
        return redirect()->route('customers.index')->with('success', "Clientes importados correctamente para almcnt={$almcnt}.");
    }

    /**
     * Actualiza únicamente la localidad de un cliente local.
     */
    public function updateLocalidad(Request $request, int $id)
    {
        $request->validate([
            'localidad' => ['required', 'string', 'max:120'],
        ]);

        $almcnt = (int) Auth::user()->almcnt;

        $customer = CustomerLocal::where('id', $id)
            ->where('almcnt', $almcnt)
            ->firstOrFail();

        $customer->update([
            'localidad' => $request->input('localidad'),
        ]);

        return redirect()
            ->route('customers.index', $request->query())
            ->with('success', 'Localidad actualizada.');
    }
}