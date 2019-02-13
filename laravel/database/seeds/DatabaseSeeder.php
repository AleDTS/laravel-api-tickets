<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('interactions')->delete();
        DB::table('tickets')->delete();

        $json = File::get("database/data/tickets.json");
        $data = json_decode($json);


        foreach ($data as $tick) {
            $ticket = App\Ticket::create(array(
                'TicketID' => $tick->TicketID,
                'CategoryID' => $tick->CategoryID,
                'CustomerID' => $tick->CustomerID,
                'CustomerName' => $tick->CustomerName,
                'CustomerEmail' => $tick->CustomerEmail,
                'DateCreate' => $tick->DateCreate,
                'DateUpdate' => $tick->DateUpdate,
                'PriorityScore' => $tick->PriorityScore
            ));
            foreach ($tick->Interactions as $inte) {
                $interaction = App\Interaction::create(array(
                    'Subject' => $inte->Subject,
                    'Message' => $inte->Message,
                    'DateCreate' => $inte->DateCreate,
                    'Sender' => $inte->Sender,
                ));

                $ticket->interactions()->save($interaction);
                $interaction->ticket()->associate($ticket)->save();
            }
        }
    }
}
