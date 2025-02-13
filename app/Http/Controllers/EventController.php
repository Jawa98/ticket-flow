<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Http\Requests\PurchaseTicketsRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Services\EventService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    protected $eventService;

    public function __construct(Request $request, EventService $eventService)
    {
        $this->setConstruct($request, EventResource::class);
        $this->eventService = $eventService;
    }

    public function index()
    {
        $events = $this->eventService->listEvents($this->perPage, $this->page);
        return $this->collection($events);
    }

    public function show(Event $event)
    {
        $event = $this->eventService->getEventById($event);
        return $this->resource($event);
    }

    public function store(EventRequest $request)
    {
        $event = $this->eventService->createEvent($request->validated());
        return $this->resource($event);
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $event = $this->eventService->updateEvent($request->validated(), $event);
        return $this->resource($event);
    }

    public function destroy(Event $event)
    {
        $this->eventService->deleteEvent($event);
        return $this->success([], 'Deleted successfully!');
    }

    public function purchaseTickets(PurchaseTicketsRequest $request, Event $event)
    {
        try {
            $this->eventService->purchaseTickets($request->validated(), $event);
            return $this->success([], 'Tickets purchased successfully!');
        } catch (\Exception $e) {
            return $this->error(400, $e->getMessage());
        }
    }
}
