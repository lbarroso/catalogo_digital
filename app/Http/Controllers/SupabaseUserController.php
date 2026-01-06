<?php

namespace App\Http\Controllers;

use App\Services\SupabaseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SupabaseUserController extends Controller
{
    protected SupabaseService $supabase;

    public function __construct(SupabaseService $supabase)
    {
        $this->supabase = $supabase;
    }

    /**
     * Muestra el formulario para crear usuarios de Supabase
     */
    public function create()
    {
        return view('supabase.users.create');
    }

    /**
     * Procesa el formulario y crea:
     * 1. Usuario en AUTH (auth.users)
     * 2. Usuario en public.users
     */
    public function store(Request $request)
    {
        $request->validate([
            'almcnt'     => 'required|integer',
            'name'       => 'required|string|max:255',
            'email'      => 'required|email',
            'role'       => 'required|integer',
            'password'   => 'required|string|min:8|confirmed',
        ]);

        $almcnt   = $request->almcnt;
        $name     = $request->name;
        $email    = $request->email;
        $role     = $request->role;
        $password = $request->password;

        try {
            // 1️⃣ Crear usuario en AUTH
            $authUser = $this->supabase->createAuthUser($email, $password);
            $authUserId = $authUser['id']; // uuid

            // 2️⃣ Insertar usuario en public.users (base de datos)
            $publicUser = $this->supabase->insertPublicUser([
                'almcnt' => $almcnt,
                'name'   => $name,
                'email'  => $email,
                'role'   => $role,
                'user_id'=> $authUserId, // FK a auth.users.id
            ]);

            return redirect()
                ->route('supabase.users.create')
                ->with('success', "Usuario creado correctamente.");

        } catch (\Throwable $e) {

            // Rollback: si AUTH ya se creó, lo eliminamos
            if (!empty($authUserId)) {
                try {
                    $this->supabase->deleteAuthUser($authUserId);
                } catch (\Throwable $e2) {
                    Log::error("Rollback falló al borrar usuario AUTH: ".$e2->getMessage());
                }
            }

            Log::error("Error creando usuario Supabase: ".$e->getMessage());

            return back()
                ->withErrors("Error: ".$e->getMessage())
                ->withInput();
        }
    }


    public function index()
    {
        $authUsers   = $this->supabase->listAuthUsers();   // usuarios de AUTH
        $publicUsers = $this->supabase->listPublicUsers(); // tabla public.users
    
        // Convertir a mapa por user_id (uuid) para unir rápido:
        $publicMap = collect($publicUsers)->keyBy('user_id');
    
        // Construir listado unido
        $combined = collect($authUsers)->map(function ($auth) use ($publicMap) {
    
            $public = $publicMap->get($auth['id']); // El FK user_id en public.users = id en auth.users
    
            return [
                'auth_id'     => $auth['id'],
                'email'       => $auth['email'],
                'created_at'  => $auth['created_at'],
                'last_signin' => '',
                'public'      => $public, // Datos del public.users
            ];
        });
    
        return view('supabase.users.index', [
            'users' => $combined
        ]);
    }
    

} // class
