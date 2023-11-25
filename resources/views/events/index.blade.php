@extends('layouts.app')

@section('content')

    <body>
        <div class="container mt-5">

            <div class="row">
                @if (session()->has('success'))
                    <div class="alert alert-success" role="alert"> {{ session('success') }} </div>
                @endif
                @if (session()->has('delete'))
                    <div class="alert alert-danger" role="alert"> {{ session('delete') }} </div>
                @endif
                @if (session()->has('update'))
                    <div class="alert alert-success" role="alert"> {{ session('update') }} </div>
                @endif
                <div class="col-md-3">
                    <h2>Create New Event</h2>
                    <form action="{{ route('events.store') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required
                                value="{{ old('name') }}">
                        </div>
                        <div class="mb-3">
                            <label for="summary" class="form-label">Summary</label>
                            <input type="text" class="form-control" id="summary" name="summary" required
                                value="{{ old('summary') }}">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="startDateTime" class="form-label">Start Time</label>
                            <input type="datetime-local" class="form-control" id="startDateTime" name="startDateTime"
                                required value="{{ old('startDateTime') }}">
                            @error('startDateTime')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="endDateTime" class="form-label">End Time</label>
                            <input type="datetime-local" class="form-control" id="endDateTime" name="endDateTime" required
                                value="{{ old('endDateTime') }}">
                            @error('endDateTime')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location" name="location"
                                value="{{ old('location') }}">
                        </div>
                        <div class="mb-3">
                            <label for="organizer_email" class="form-label">Organizer Email</label>
                            <input type="email" class="form-control" id="organizer_email" name="organizer_email"
                                value="{{ old('organizer_email') }}">
                        </div>
                        <div class="mb-3">
                            <label for="attendees" class="form-label">Attendees</label>
                            <input type="text" class="form-control" id="attendees" name="attendees"
                                value="{{ old('attendees') }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Create Event</button>
                    </form>
                </div>
                <div class="col-md-9">
                    <h2>Events</h2>
                    @if ($events->isEmpty())
                        <p>No events found.</p>
                    @else
                        <ul class="list-group">
                            @foreach ($events as $event)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h4>{{ $event->title }}</h4>
                                            <p>{{ $event->description }}</p>
                                        </div>
                                        <div>
                                            <a href="{{ route('events.edit', $event->id) }}"
                                                class="btn btn-primary">Edit</a>
                                            <form action="{{ route('events.destroy', $event->id) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                            {{ $events->links() }}
                        </ul>
                    @endif
                </div>
            </div>
    </body>

@endsection
