<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\Match;
use Auth;
use App\Http\Resources\LikeResource;
class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $like = Match::where('liker',Auth::user()->id)
        ->orWhere('liked',Auth::user()->id)->where('status',1)->get();

        return LikeResource::collection($like);
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
        $preveData = Match::where('liked',Auth::user()->id)
                        ->where('liker',$request->user_id)->where('status',0)->get();
        if(count($preveData)>0){
            $matches = Match::find($preveData[0]['id']);
            $matches->status=1;
            $matches->save();
            return response()->json(['status'=>true,'message'=>'Your like is sent successfully']);

        }else{

            $prevMatches = Match::where('liked',Auth::user()->id)
            ->where('liker',$request->user_id)->where('status',1)->get();
            if(count($prevMatches)<=0){
            $match = new Match();
            $match->liked = $request->user_id;
            $match->liker = Auth::user()->id;
            $match->save();
            return response()->json(['status'=>true,'message'=>'Your like is sent successfully']);
            }else{
                return response()->json(['status'=>true,'message'=>'Your like is sent successfully']);
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
