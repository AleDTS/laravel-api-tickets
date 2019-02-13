<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filter;

class TicketController extends Controller
{
    public function index(Request $request, Ticket $ticket)
    {
        
        // return TicketResource::collection($ticket->with('interactions'));
        // return Ticket::filter($request)->get();
        return QueryBuilder::for(Ticket::class)
        	->allowedSorts('DateCreate','DateUpdate', 'PriorityScore')
        	->allowedIncludes('interactions')
            ->allowedFilters([
            	'TicketID', 'PriorityScore',
            	Filter::scope('starts_between')
            ])->get();
    }

    public function sortby(Request $request, $param, Ticket $ticket){
        return Ticket::orderBy($param)->get();
    }

    public function range(Request $request, $since, $until, Ticket $ticket){
        
    }
}
