<?php

namespace App\Api\V1\Controllers;

use App\Location;
use Illuminate\Http\Request;
use Auth;
class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $location = Location::where('user_id',Auth::user()->id)->get();

        if(count($location)<=0){

            $locations = new Location();
            $locations->user_id = Auth::user()->id;
            $locations->country = $request->country;
            $locations->city = $request->city;
            $locations->save();
            return response()->json(['status'=>true,'message'=>'Your location is saved successfully']);

        }else{
            $locations = Location::find($location[0]['id']);
            $locations->country = $request->country;
            $locations->city = $request->city;
            $locations->save();
            return response()->json(['status'=>true,'message'=>'Your location is saved successfully']);

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        //
    }
}
