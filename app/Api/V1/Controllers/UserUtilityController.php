<?php

namespace App\Api\V1\Controllers;

use App\UserUtility;
use Illuminate\Http\Request;
use Auth;
class UserUtilityController extends Controller
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
        $userUtilityCheck = UserUtility::where('user_id',Auth::user()->id)->get();
        if(count($userUtilityCheck)<=0){

            $userUtility = new UserUtility();
            $userUtility->user_id = Auth::user()->id;
            $userUtility->about = $request->about;
            $userUtility->job_title = $request->job_title;
            $userUtility->company = $request->company;
            $userUtility->school = $request->school;
            if($userUtility->save()){
                return response()->json(['status'=>true,'message'=>'User data is updated successfully']);
            }else{
                return response()->json(['status'=>false,'message'=>'User data is not updated']);
    
            }

        }else{

            $userUtilities = UserUtility::find($userUtilityCheck[0]['id']);
            $userUtilities->user_id = Auth::user()->id;
            $userUtilities->about = $request->about;
            $userUtilities->job_title = $request->job_title;
            $userUtilities->company = $request->company;
            $userUtilities->school = $request->school;
            if($userUtilities->save()){
                return response()->json(['status'=>true,'message'=>'User data is updated successfully']);
            }else{
                return response()->json(['status'=>false,'message'=>'User data is not updated']);
    
            }
            
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserUtility  $userUtility
     * @return \Illuminate\Http\Response
     */
    public function show(UserUtility $userUtility)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserUtility  $userUtility
     * @return \Illuminate\Http\Response
     */
    public function edit(UserUtility $userUtility)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserUtility  $userUtility
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserUtility $userUtility)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserUtility  $userUtility
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserUtility $userUtility)
    {
        //
    }
}
