<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class InteractionResource extends ResourceCollection
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
            'Subject' => $this->Subject;
            'Message' => $this->Message;
            'DateCreate' => $this->DateCreate;
            'Sender' => $this->Sender;
            
        ];
    }
}
