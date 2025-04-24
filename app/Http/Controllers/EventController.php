<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('created_at', 'desc')->get();

        return view('pages.event.event-list', compact('events'));
    }

    public function eventDetails($id)
    {
        $event = Event::with(['user'])->find($id);

        return view('pages.event.view-event', compact('event'));
    }

    public function updateStatus($id, Request $request)
    {
        $type = $request->type;
        $event = Event::find($id);
        $event->update([
            'status' => $type,
        ]);

        return response()->json(['success' => true]);
    }
}
