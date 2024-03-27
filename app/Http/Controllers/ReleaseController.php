<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Product;
use App\Models\Release;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
/**
 * Class ReleaseController
 * @package App\Http\Controllers
 */
class ReleaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $releases = Release::paginate();
        $user =  Auth::user();

        $releases = Product::with('category')
        ->join('releases', function ($join) use ($user) {
            $join->on('products.artcve', '=', 'releases.artcve')
                ->where('releases.almcnt', $user->almcnt);
        })
        ->where('products.almcnt', $user->almcnt)
        ->where('products.stock', '>', 0)
        ->paginate();     

        return view('release.index', compact('releases'))
            ->with('i', (request()->input('page', 1) - 1) * $releases->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $release = new Release();
        return view('release.create', compact('release'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Release::$rules);

        $release = Release::create($request->all());

        return redirect()->route('releases.index')
            ->with('success', 'Release created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $release = Release::find($id);

        return view('release.show', compact('release'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $release = Release::find($id);

        return view('release.edit', compact('release'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Release $release
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Release $release)
    {
        request()->validate(Release::$rules);

        $release->update($request->all());

        return redirect()->route('releases.index')
            ->with('success', 'Release updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $release = Release::find($id)->delete();

        return redirect()->route('releases.index')
            ->with('success', 'Release deleted successfully');
    }
}
