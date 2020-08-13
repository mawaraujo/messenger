<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController as Controller;
use Illuminate\Http\Request;

use App\Models\Conversation;
use App\Http\Resources\Models\Conversation as ConversationResource;
use App\Http\Resources\Collections\ConversationCollection;

class ConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Conversation $conversation, Request $request)
    {
        $conversations = $conversation->where('user_id', $request->user()->id)->with('contact');
        return $this->sendCollectionResource(new ConversationCollection($conversations->get()), 'Conversaciones encontradas');
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Conversation $conversation)
    {
        //  Falta añadir contacto
        return $this->sendResponse(new ConversationResource($conversation), 'Conversacion encontrada');
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
