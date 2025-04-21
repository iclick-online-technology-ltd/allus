@extends('layouts.app')
@section('content')
    <style>
        /*.festival-card {*/
        /*    max-width: 600px;*/
        /*    margin: 2rem auto;*/
        /*    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);*/
        /*    border-radius: 12px;*/
        /*    overflow: hidden;*/
        /*}*/

        .festival-card .card-img-top {
            height: 200px;
            object-fit: cover;
            width: 500px;
        }

        .festival-card .card-title {
            font-weight: 700;
            font-size: 2rem;
        }

        .festival-card .info-row {
            display: flex;
        }

        .festival-card .info-row .badge {
            font-size: 16px;
        }

        .festival-card .info-label {
            width: 170px;
            font-weight: 600;
        }

        .festival-card .info-value {
            flex: 1;
        }

        .festival-card .btn-action {
            padding: 0.75rem;
            font-weight: 600;
        }
    </style>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="text-uppercase mb-0"><span class="text-muted">Event</span> <span class="mx-2">/</span> View
                Event
            </h5>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-4 mb-md-0">
            <div class="card">
                <div class="card-header bg-light-grey">
                    <div class="row align-items-center">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <div class="d-flex align-items-center gap-3">
                                <button class="btn btn-primary flex-grow-1"
                                        onclick="changeStatus('{{$event->id}}','approved')">Approve
                                </button>
                                <button class="btn btn-danger flex-grow-1"
                                        onclick="changeStatus('{{$event->id}}','rejected')">Reject
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="p-4 festival-card">
                        {{--                        <img src="{{$event->image}}" alt="img" class="card-img-top rounded mb-4">--}}

                        <h1 class="card-title mb-2">{{$event->title}}</h1>
                        <p class="card-text mb-4">{{$event->description}}</p>

                        <div class="info-row mb-4">
                            <div class="info-label">Date</div>
                            <div class="info-value">{{date('d M Y h:i A', strtotime($event->created_at))}}</div>
                        </div>

                        <div class="info-row mb-4">
                            <div class="info-label">Location</div>
                            <div class="info-value">{{$event->location}}</div>
                        </div>

                        <div class="info-row mb-4">
                            <div class="info-label">Host</div>
                            <div class="info-value">{{$event->eventUser->username}}</div>
                        </div>

                        <div class="info-row mb-4">
                            <div class="info-label">Filters</div>
                            <div class="d-flex align-items-center gap-2">
                                @foreach($event->filters as $key => $filter)
                                    @if($key === 'tags')
                                        @continue
                                    @endif
                                    @if($filter !== '')

                                        <span
                                            class="badge fw-normal text-bg-light rounded">{{ucfirst(str_replace('_', ' ', $key)). ' : '.ucfirst(str_replace('_', ' ', $filter)) }}</span>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function changeStatus(id, type) {
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Customize the confirmation message based on the action type
            let title = type === 'approved' ? "Confirm Approval" : "Confirm Rejection";
            let text = type === 'approved'
                ? "Are you sure you want to approve this event?"
                : "Are you sure you want to reject this event?";
            let confirmBtnText = type === 'approved'
                ? "Yes, approve it!"
                : "Yes, reject it!";

            Swal.fire({
                title: title,
                text: text,
                icon: "success",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: confirmBtnText,
                closeOnConfirm: false
            }).then((result) => {
                if (result.isConfirmed) {
                    let formData = new FormData();
                    formData.append('type', type);

                    // If user confirms, proceed with the AJAX call
                    $.ajax({
                        url: '/event/status/' + id,
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            // Set success message based on the action type
                            let successText = type === 'approved'
                                ? "The event has been successfully approved."
                                : "The event has been successfully rejected.";

                            Swal.fire({
                                title: "Success",
                                text: successText,
                                icon: "success"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    console.log(result);
                                    window.location.reload();
                                }
                            });
                        },
                        error: function (xhr, status, error) {
                            console.error('Error fetching data.');
                            console.log('XHR Status: ' + status);
                            console.log('Error: ' + error);
                            console.log(xhr.responseText);

                            Swal.fire({
                                title: "Error",
                                text: "There was a problem processing your request.",
                                icon: "error"
                            });
                        }
                    });
                }
            });
        }

    </script>

@endpush
