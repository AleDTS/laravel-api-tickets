<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TicketResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return[
            'TicketID' => $this->TicketID;
            'CategoryID' => $this->CategoryID;
            'CustomerID' => $this->CustomerID;
            'CustomerName' => $this->CustomerName;
            'CustomerEmail' => $this->CustomerEmail;
            'DateCreate' => $this->DateCreate;
            'DateUpdate' => $this->DateUpdate;
            'PriorityScore' => $this->PriorityScore;
            'Interactions' => Ticket::collection($this->whenLoaded('Interactions'));

        ];
    }
}
