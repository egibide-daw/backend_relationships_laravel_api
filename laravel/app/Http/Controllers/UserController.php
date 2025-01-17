<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller as BaseController;


class UserController extends Controller
{

    public function register(Request $request): JsonResponse
    {
        //Debug::enable();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'c_password' => 'required|same:password',
        ]);

        if($validator->fails()){
            return response()->json($validator->messages(), 400);
        }
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);
        return response()->json(['message'=>'User Created','data'=>$user],200);
    }

    public function show(User $user= null): JsonResponse
    {
        if($user!=null){
            return response()->json(['message'=>'','data'=>$user],200);
        }
        return response()->json(['message'=>'User not Found'],404);
    }

    public function show_address(User $user=null): JsonResponse
    {
        if($user){
            return response()->json(['message'=>'','data'=>$user->address],200);
        }
        return response()->json(['message'=>'User not Found'],404);
    }
    public function bookEvent(Request $request): JsonResponse
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|int',
            'event_id' => 'required|int',
        ]);
        if( $validator->fails()){
            return response()->json($validator->messages(), 400);
        }
        $note = '';
        if($request->note){
            $note = $request->note;
        }
        try{
            $user= User::where( 'id', $request->get('user_id'))->firstOrFail();
            $event= Event::where( 'id', $request->get('event_id'))->firstOrFail();
            if($user->events()->save($event, array('note' => $note))){
                return response()->json(['message'=>'User Event Created','data'=>$event],200);
            }
        }catch (\Exception $exception){
            return response()->json($exception->getMessage(), 400);
        }
    }
    public function listEvents(User $user= null): JsonResponse
    {
        if($user){
            $events = $user->events;
            return response()->json(['message'=>null,'data'=>$events],200);
        }
        return response()->json(['message'=>'User not Found'],404);
    }

    private function validateEmail(){
        return Validator::make(request()->all(), [
            'email' => 'required|string|email|max:255',
        ]);
    }


}
