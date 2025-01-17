<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AddressController extends Controller
{
    public function store(Request $request) : JsonResponse
    {

        //$emailValidator = $this->validateEmail();
        $addressValidator = $this->validateAddress();
        if( $addressValidator->fails()){//$emailValidator->fails() ||
            return response()->json(['message'=>'Failed',
                //'email'=>$emailValidator->messages(),
                'address'=>$addressValidator->messages()],400);
        }

        try{
            $user = User::where( 'id', $request->get('user_id'))->firstOrFail();
        }catch (\Exception $exception){
            return response()->json(['message'=>$request,'data'=> $exception->getMessage()],400);
        }

        //return response()->json(['message'=>$user,'data'=> $request->get('email')],400);
        if($user->address){
            return response()->json(['message'=>'User has Address Already','data'=>null],400);
        }

        try {
            $address = new Address($addressValidator->validate());
        } catch (ValidationException $e) {
            return response()->json(['message'=>'Errod de validación','data'=>$e->getMessage()],400);
        }

        if($user->address()->save($address)){
            return response()->json(['message'=>'Address Saved','data'=>$address],200);
        }
        return response()->json(['message'=>'Failed','data'=>null],400);

    }

    public function show(Address $address = null): JsonResponse
    {
        if($address){
            return response()->json(['message'=>'Address','data'=>$address],200);
        }
        return response()->json(['message'=>'Address','data'=>null],400);
    }

    public function show_user(Address $address = null): JsonResponse
    {
        if ($address){
            return response()->json(['message'=>'','data'=>$address->user],200);
        }
        return response()->json(['message'=>'Address','data'=>null],400);
    }

    public function validateAddress(): \Illuminate\Validation\Validator
    {
        return Validator::make(request()->all(), [
            'country' => 'required|string|min:1|max:4',
            'zipcode' => 'required|string|min:5|max:6',
        ]);
    }

    private function validateEmail(){
        return Validator::make(request()->all(), [
            'email' => 'required|string|email|max:255',
        ]);
    }
}
