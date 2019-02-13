<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;


class Ticket extends Model
{
    protected $fillable = [
    	'id',
    	'TicketID',
	    'CategoryID',
	    'CustomerID',
	    'CustomerName',
	    'CustomerEmail',
	    'DateCreate',
	    'DateUpdate',
	    'PriorityScore'
	];

	public function interactions(){
		return $this->hasMany(Interaction::class);
	}

	public function scopeStartsBetween(Builder $query, $date_low, $date_high): Builder{
		return $query
			->where('DateCreate', '>=', Carbon::parse($date_low))
			->where('DateCreate', '<=', Carbon::parse($date_high));
	}
}
