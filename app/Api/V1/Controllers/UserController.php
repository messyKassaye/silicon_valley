<?php

namespace App\Api\V1\Controllers;

use App\Http\Resources\MobileResource;
use App\User;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Controllers\Controller;
use App\Api\V1\Requests\LoginRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Auth;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.auth', []);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return  new UserResource(User::find(Auth::guard()->user()->id));
    }


    public function index()
    {
        $user = User::all();

        return UserResource::collection($user)->response()->setStatusCode(200);
    }

    public function create(Request $request)
    { }

    public function store(Request $request)
    { }

    public function show($id)
    {
        $user = User::find($id);
        if ($user !== null) {
            return new UserResource($user);
        }
        return response()->json(['status' => false, 'message' => 'No one is registered by this id']);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->avator = $request->avator;
        if ($user->update()) {
            return new UserResource($user);
        }
        return response()->json(['status' => false, 'message' => 'Something is not wright']);
    }

    public function changeProfile(Request $request){
        $user = Auth::user();
        $user->profile_pic_path = $request->path;
        $user->save();
        return response()->json(['status'=>true,'message'=>'Profile picture changed successfully']);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if($user !== null){
            $user->delete();
            return response()->json(['status'=>true,'message'=>'User is deleted successfully']);
        } else {
            return response()->json(['status' => false, 'message' => 'No one is registered by this id']);
        }
    }
}
