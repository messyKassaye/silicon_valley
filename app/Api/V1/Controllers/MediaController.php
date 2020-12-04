<?php

namespace App\Api\V1\Controllers;

use App\Media;
use Illuminate\Http\Request;
use Auth;
class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $medias = Media::where('user_id',Auth::user()->id)->select(['id','media_path'])->get();
        return $medias;
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
        $file = $request->file('file');
        $file_mime = $file->getClientMimeType();
        $mediaPath = public_path();
        $file_type = explode('/',$file_mime);

        $destinationPath = $mediaPath.'/uploads/'; // upload path
        $profilefile = "spark_photo_".date('YmdHis') . "." . $file->getClientOriginalExtension();
        $result= $file->move($destinationPath, $profilefile);
        if($result){
            $media = new Media();
            $media->user_id = Auth::user()->id;
            $media->media_path = env('HOST_NAME').'/uploads/'.$profilefile;
            $media->save();
            return response()->json(['status'=>true,'message'=>'Media is added successfully',
            'path'=>env('HOST_NAME').'/uploads/'.$profilefile]);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function show(Media $media)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function edit(Media $media)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Media $media)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy(Media $media)
    {
        //
    }
}
