@extends('layouts.app')

@section('content')
<div class="container m-5">
    <h2>Edit Event</h2>
    <form action="{{ route('events.update', $event->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $event->name }}" required>
        </div>
        <div class="mb-3">
            <label for="summary" class="form-label">Summary</label>
            <input type="text" class="form-control" id="summary" name="summary" value="{{ $event->summary }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ $event->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="startDateTime" class="form-label">Start Time</label>
            <input type="datetime-local" class="form-control" id="startDateTime" name="startDateTime" value="{{ $event->startDateTime }}" required>
        </div>
        <div class="mb-3">
            <label for="endDateTime" class="form-label">End Time</label>
            <input type="datetime-local" class="form-control" id="endDateTime" name="endDateTime" value="{{ $event->endDateTime }}" required>
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" value="{{ $event->location }}">
        </div>
        <div class="mb-3">
            <label for="organizer_email" class="form-label">Organizer Email</label>
            <input type="email" class="form-control" id="organizer_email" name="organizer_email" value="{{ $event->organizer_email }}">
        </div>
        <div class="mb-3">
            <label for="attendees" class="form-label">Attendees</label>
            <input type="text" class="form-control" id="attendees" name="attendees" value="{{ $event->attendees }}">
        </div>
        <button type="submit" class="btn btn-primary">Update Event</button>
    </form>
</div>
@endsection
