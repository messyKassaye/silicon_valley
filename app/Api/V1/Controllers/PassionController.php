<?php

namespace App\Api\V1\Controllers;

use App\Passion;
use Illuminate\Http\Request;
use Auth;
class PassionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Passion::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        Auth::user()->passion()->sync(json_decode($request->passions));
        return response()->json(['status'=>true,'message'=>'Your passions added successfully']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Passion  $passion
     * @return \Illuminate\Http\Response
     */
    public function show(Passion $passion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Passion  $passion
     * @return \Illuminate\Http\Response
     */
    public function edit(Passion $passion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Passion  $passion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Passion $passion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Passion  $passion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Passion $passion)
    {
        //
    }
}
