<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filter;

class InteractionController extends Controller
{
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'Subject' => $this->Subject,
            'Message' => $this->Message,
            'Sender' => $this->Sender
        ];
    }

    public function index(Request $request, Interaction $interaction)
    {
        
        // return TicketResource::collection($ticket->with('interactions'));
        // return Ticket::filter($request)->get();
        return QueryBuilder::for(Ticket::class)->get();

    }
}
