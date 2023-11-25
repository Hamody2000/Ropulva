<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Event;
use Spatie\GoogleCalendar\Event as GoogleCalendarEvent;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index()
    {
        try {
            $events = Cache::remember('events_index', 60, function () {
                return Event::latest()->paginate(5);
            });
        } catch (\Exception $e) {
            Log::error('Failed to retrieve events. ' . $e->getMessage());
            abort(500, 'Failed to retrieve events. Please try again later.');
        }

        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required',
                'summary' => 'required',
                'description' => 'nullable',
                'location' => 'nullable',
                'startDateTime' => 'nullable|date|after:now',
                'endDateTime' => 'nullable|date|after:start_time',
                'organizer_email' => 'nullable|email',
                'attendees' => 'nullable',
            ]);

            $validatedData['startDateTime'] = Carbon::parse($validatedData['startDateTime']);
            $validatedData['endDateTime'] = Carbon::parse($validatedData['endDateTime']);

            $cachedKey = 'validated_data_' . md5(serialize($validatedData));
            $cachedData = Cache::remember($cachedKey, 60, function () use ($validatedData) {
                return $validatedData;
            });

            DB::transaction(function () use ($cachedData) {
                $event = GoogleCalendarEvent::create($cachedData);
                Event::create($cachedData);
            });

            Cache::forget('events_index');
            return redirect()->route('events.index')->withSuccess('Event created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create event. Please try again later.');
        }
    }

    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required',
                'summary' => 'required',
                'description' => 'nullable',
                'location' => 'nullable',
                'startDateTime' => 'nullable|date|after:now',
                'endDateTime' => 'nullable|date|after:start_time',
                'organizer_email' => 'nullable|email',
                'attendees' => 'nullable',
            ]);

            $event->update($validatedData);
            Cache::forget('events_index');
            return redirect()->route('events.index')->withSuccess('Event updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update event. Please try again later.');
        }
    }

    public function destroy(Event $event)
    {
        try {
            $event->delete();
            Cache::forget('events_index');
            return redirect()->route('events.index')->withSuccess('Event deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete event. Please try again later.');
        }
    }
}
