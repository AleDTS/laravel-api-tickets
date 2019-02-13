<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interaction extends Model
{
    protected $fillable = [
        'id',
    	'Ticket_id',
    	'Subject',
        'Message',
        'DateCreate',
        'Sender'
    ];

    public function ticket(){
		return $this->belongsTo(Ticket::class);
	}
}
