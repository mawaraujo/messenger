<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController as Controller;
use Illuminate\Http\Request;

use App\Models\Message;
use App\Http\Resources\Models\Message as MessageResource;
use App\Http\Resources\Collections\MessageCollection;
use Validator;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        MessageCollection::withoutWrapping();
        
        $messages = Message::where(function($query) use ($request) {
                $query->where('from_id', $request->user()->id)->where('to_id', $request->to_id);
            })
            ->orWhere(function($query) use ($request) {
                $query->where('from_id', $request->to_id)->where('to_id', $request->user()->id);
        })->get();

        return $this->sendCollectionResource(new MessageCollection($messages), 'Mensajes encontrados');
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
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
            'to_id' => 'required|integer'
        ]);

        if($validator->fails()) {
            return $this->sendError($validator->errors()->all(), 422);
        }

        $message = new Message();
        $message->from_id = $request->user()->id;
        $message->to_id = $request->to_id;
        $message->content = $request->content;
        $message->save();

        return $this->sendResponse(new MessageResource($message), 'Mensaje enviado con éxito', 200);
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
