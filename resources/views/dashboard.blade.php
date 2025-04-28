@extends('layouts.app')

@section('content')
    <style>
        .event {
            background-color: #078fec;
        }

        h5 {
            color: white;
        }
    </style>
    <div class="container">
        <div class="container py-4">

            <div class="row g-4">
                <!-- Gender Card -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-people-fill me-2"></i>
                                Gender Distribution
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <span>Female</span>
                                <span class="fw-bold">{{$genderCount['female']}}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Male</span>
                                <span class="fw-bold">{{$genderCount['male']}}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Non-binary</span>
                                <span class="fw-bold">{{$genderCount['non-binary']}}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Average Age Card -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-calendar-date me-2"></i>
                                Average Age
                            </h5>
                        </div>
                        <div class="card-body d-flex align-items-center justify-content-center">
                            <div class="text-center">
                                <span class="display-5 fw-bold">{{$averageAge}}</span>
                                <p class="text-muted mt-2">years</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Events Card -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-purple event">
                            <h5 class="mb-0">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                Total Events
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <span>Approved</span>
                                <span class="fw-bold">{{$totalEvent['approved']}}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Rejected</span>
                                <span class="fw-bold">{{$totalEvent['rejected']}}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Pending</span>
                                <span class="fw-bold">{{$totalEvent['pending']}}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Users Card -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-warning text-white">
                            <h5 class="mb-0">
                                <i class="bi bi-shield-fill me-2"></i>
                                Total Users
                            </h5>
                        </div>
                        <div class="card-body d-flex align-items-center justify-content-center">
                            <div class="text-center">
                                <span class="display-5 fw-bold">{{$totalUsers}}</span>
                                <p class="text-muted mt-2">registered users</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container mt-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-star-fill me-2"></i>
                        Popular Upcoming Events
                    </h5>
                    <a href="{{route('event.index')}}" class="btn btn-outline-light btn-sm">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>Event</th>
                                <th>Host</th>
                                <th>Date & Time</th>
                                <th>Location</th>
                                <th>Participants</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($popularEvents as $event)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($event->image)
                                                <img src="{{ $event->image }}"
                                                     alt="{{ $event->title }}" class="me-2 rounded"
                                                     style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div
                                                    class="bg-light rounded me-2 d-flex align-items-center justify-content-center"
                                                    style="width: 40px; height: 40px;">
                                                    <i class="bi bi-calendar-event text-secondary"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <p class="fw-bold mb-0">{{ $event->title }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $event->host_name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($event->date_time)->format('M d, Y - g:i A') }}</td>
                                    <td>{{ Str::limit($event->location, 30) }}</td>
                                    <td>
                                                                    <span
                                                                        class="badge bg-primary rounded-pill">{{ $event->participant_count }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="bi bi-calendar-x fs-3 d-block mb-2"></i>
                                        No upcoming events found
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
