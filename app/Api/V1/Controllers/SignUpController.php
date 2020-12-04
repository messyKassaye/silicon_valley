<?php

namespace App\Api\V1\Controllers;

use App\Finance;
use App\FinanceBalance;
use Carbon\Carbon;
use Config;
use App\User;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\SignUpRequest;
use App\Role;
use App\Gender;
use App\Interest;
use Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SignUpController extends Controller
{
    public function signUp(SignUpRequest $request, JWTAuth $JWTAuth)
    {
       
           $userCheck = User::where('email', $request->email)->get();
           $phoneChecker = User::where('phone', $request->phone)->get();
           
           if (count($userCheck) <= 0 && count($phoneChecker) <= 0) {

               $user = new User();
               $user->name = $request->name;
               $user->user_name = '';
               $user->birth_date = $request->birth_date;
               $user->email = $request->email;
               $user->phone = $request->phone;
               $user->profile_pic_path = $request->profile_pic_path;
               $user->password = $request->password;
               if($user->save()){
                   $gender = Gender::find($request->gender_id);
                   $user->gender()->sync($gender);
                   $interest = new Interest();
                   $interest->gender_id = $this->findIterest($request->gender_id);
                   $user->interest()->save($interest);

                   //login after sign up
                   $credentials = $request->only(['email', 'password']);
                   $token = Auth::guard()->attempt($credentials);
                   return response()->json([
                       'status' => true,
                       'token' => $token
                   ], 201);
               }

           } else {
               if (count($userCheck) > 0) {
                   //throw new HttpException(409);
                   return response()->json(['status' => false, 'message' => 'Some one already registered by this email address'], 409);
               } else if (count($phoneChecker) > 0) {
                   return response()->json(['status' => false, 'message' => 'Some one already registered by this Phone number'], 409);
               } else {
                   return response()->json(['status' => false, 'message' => 'these email address and phone number are used by some one'], 409);
               }
           }
    }

    public function findIterest($id){
        if($id==1){
            return 2;
        }else{
            return 1;
        }
    }

}
