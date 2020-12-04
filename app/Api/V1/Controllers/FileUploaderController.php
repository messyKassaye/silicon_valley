<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;

class FileUploaderController extends Controller
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
        $file = $request->file('file');
        $file_mime = $file->getClientMimeType();
        $mediaPath = public_path();
        $file_type = explode('/',$file_mime);

        //if user upload audio or video
        if($file_type[0]=='mp4'||$file_type[0]=='avi'||$file_type[0]=='mp3'){

            return response()->json([
                'status'=>false,
                'message'=>'This type file format is not allowed. Please upload only images.'
            ]);

        }else{

            $destinationPath = $mediaPath.'/uploads/'; // upload path
            $profilefile = "spark_photo_".date('YmdHis') . "." . $file->getClientOriginalExtension();
            $result= $file->move($destinationPath, $profilefile);
            if($result){
                return response()->json([
                    'status'=>true,
                    'message'=>'Media uploaded successfully',
                    'path'=>env('HOST_NAME').'/uploads/'.$profilefile
                ]);
            }


        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
