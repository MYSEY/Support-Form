<?php

namespace App\Http\Controllers\Admins;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FixedAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('asset.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cateagory = Category::all();
        return view('asset.create',compact('cateagory'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
