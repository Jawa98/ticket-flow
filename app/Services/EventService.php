<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

class EventService
{
    public function listEvents($perPage, $page)
    { 
        $events = QueryBuilder::for(Event::class)
                    ->allowedFilters(['id', 'name'])
                    ->defaultSort('-id')
                    ->paginate($perPage, ['*'], 'page', $page);

        return $events;
    }

    public function getEventById(Event $event)
    {
        return $event;
    }

    public function createEvent(array $data)
    {
        $event = Event::create($data); 
        return $event; 
    }

    public function updateEvent(array $data, Event $event)
    {
        $event->update($data);
        return $event;
    }

    public function deleteEvent(Event $event)
    {
        $event->delete();
        return;
    }

    public function purchaseTickets(array $data, Event $event)
    {
        $ticketsRequested = $data['tickets_requested'];
        
        // Begin a database transaction to ensure data integrity
        DB::transaction(function () use ($event, $ticketsRequested) 
        {
            $event = Event::where('id', $event->id)->lockForUpdate()->first();
            
            if ($event->ticket_count < $ticketsRequested) {
                throw new \Exception('Sorry, the number of tickets you requested is not available.');
            }

            // Reduce the required number of tickets from the available number
            $event->ticket_count -= $ticketsRequested;
            $event->save();
        });

        return;
    }

    public function calculateDiscount(array $cart): float
    {
        // Check if the cart is empty
        if (empty($cart)) {
            throw new \Exception('The cart cannot be empty.');
        }

        $total = 0;

        // Calculate the total price
        foreach ($cart as $item) {
            $this->validateCartItem($item);
            $total += $item['price'] * $item['quantity'];
        }

        // Determine the discount rate based on the total price
        $discountRate = $total > 100 ? 0.1 : 0.05;
        $discount = $total * $discountRate;

        return $total - $discount;
    }

    private function validateCartItem(array $item): void
    {
        if (empty($item['price']) || empty($item['quantity']) || $item['price'] <= 0 || $item['quantity'] <= 0) {
            throw new \Exception('Each cart item must have a positive price and quantity.');
        }
    }
}
