<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventType;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller as BaseController;
class EventTypeController extends Controller
{
    //use AuthorizesRequests;
    public function listTypes(): JsonResponse
    {
        $events = EventType::all();
        return response()->json(['message'=>null,'data'=>$events],200);
    }
    public function store(Request $request): JsonResponse
    {
        if(!auth()->check() || auth()->user()->cannot('create', EventType::class)){
            return response()->json(['message'=>'Not Authorized'],403);
        }
        $validator = $this->validateEventType();
        if($validator->fails()){
            return response()->json($validator->messages(), 422);
        }

        $event = EventType::create($validator->validate());
        return response()->json(['message'=>'Event Created','data'=>$event],201);
    }

    private function validateEventType(){
        return Validator::make(request()->all(), [
            'description' => 'required|string|max:50',
        ]);
    }
}
