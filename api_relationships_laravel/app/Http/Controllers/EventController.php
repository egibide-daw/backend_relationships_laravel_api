<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function __construct(){
        //$this->middleware(, ['except' => ['index', 'show']]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {

        $validator = $this->validateEvent();
        if($validator->fails()){
            return response()->json($validator->messages(), 422);
        }

        $event = Event::create($validator->validate());
        return response()->json(['message'=>'Event Created','data'=>$event],201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event = null): JsonResponse
    {
        if($event){
            return response()->json(['message'=>null,'data'=>$event],200);
        }
        return response()->json(['message'=>'Event Not Found'],404);
    }


    private function validateEvent(){
        return Validator::make(request()->all(), [
            'event_name' => 'required|string|max:25',
            'event_detail' => 'required|string|max:255',
            'event_type_id' => 'required|int',
        ]);
    }


    public function listUsers(Event $event = null): JsonResponse
    {
        if($event){
            $users = $event->users;
            return response()->json(['message'=>null,'data'=>$users],200);
        }
        return response()->json(['message'=>'Event Not Found'],404);
    }
    public function index(Request $request): JsonResponse
    {
        $events= Event::all();
        return response()->json($events,200);
    }
}
