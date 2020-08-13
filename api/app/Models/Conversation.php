<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    /* 
    Campo calculado, accessors
    
    protected $appends = ['contact_name'];

    public function getContactNameAttribute() {
        return $this->contact->name;
    } 
    */

    /*
        Definimos la relación para obtener información del contacto
        Un mismo usuario puede asociarse a multiples conversaciones (belongsTo)
    */
    public function contact() {
        return $this->belongsTo(User::class);
    }
}
