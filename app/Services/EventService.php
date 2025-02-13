<?php

namespace App\Services;

use App\Models\Event;
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
}
