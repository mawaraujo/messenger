<?php

namespace App\Observers;

use App\Models\Message;
use App\Models\Conversation;
use App\Events\MessageSend;

class MessageObserver
{
    /**
     * Handle the message "created" event.
     *
     * Escuchamos cuando se crea un mensaje
     * @param  \App\Message  $message
     * @return void
     */
    public function created(Message $message)
    {
        // Actualizamos ambas conversaciones
        $conversation = Conversation::where('user_id', $message->from_id)
                                ->where('contact_id', $message->to_id)->first();
        
        // Verificamos que la conversación exista
        if($conversation) {
            $conversation->last_message = 'Tú: ' . $message->content;
            $conversation->last_time = $message->created_at;
            $conversation->save();
        }

        $conversation = Conversation::where('contact_id', $message->from_id)
                                ->where('user_id', $message->to_id)->first();
        
        if($conversation) {
            $conversation->last_message = ucfirst($conversation->contact->name) . ': ' . $message->content;
            $conversation->last_time = $message->created_at;
            $conversation->save();
        }

        return event(new MessageSend($message));
    }

    /**
     * Handle the message "updated" event.
     *
     * @param  \App\Message  $message
     * @return void
     */
    public function updated(Message $message)
    {
        //
    }

    /**
     * Handle the message "deleted" event.
     *
     * @param  \App\Message  $message
     * @return void
     */
    public function deleted(Message $message)
    {
        //
    }

    /**
     * Handle the message "restored" event.
     *
     * @param  \App\Message  $message
     * @return void
     */
    public function restored(Message $message)
    {
        //
    }

    /**
     * Handle the message "force deleted" event.
     *
     * @param  \App\Message  $message
     * @return void
     */
    public function forceDeleted(Message $message)
    {
        //
    }
}
