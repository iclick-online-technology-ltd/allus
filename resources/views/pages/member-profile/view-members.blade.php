@extends('layouts.app')
@section('content')
    <style>
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
            <h5 class="text-uppercase mb-0"><span class="text-muted">Member</span> <span class="mx-2">/</span> View
                Member
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
                                        onclick="changeStatus('{{$member->id}}','{{App\Enum\MemberStatus::ACTIVE->value}}')" {{$member->status === App\Enum\MemberStatus::ACTIVE->value ? 'disabled' : ''}}>{{ucfirst(App\Enum\MemberStatus::ACTIVE->value)}}

                                </button>
                                <button class="btn btn-danger flex-grow-1"
                                        onclick="changeStatus('{{$member->id}}', '{{App\Enum\MemberStatus::BLOCKED->value}}')" {{$member->status === App\Enum\MemberStatus::BLOCKED->value ? 'disabled' : ''}}>
                                    {{ucfirst(App\Enum\MemberStatus::BLOCKED->value )}}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="p-4 festival-card">
                        {{--                        <img src="{{$member->profile_photo}}" alt="img" class="card-img-top rounded mb-4">--}}

                        <h1 class="card-title mb-2">{{ucfirst($member->username)}}</h1>
                        <p class="card-text mb-4">{{$member->about_me}}</p>

                        <div class="info-row mb-4">
                            <div class="info-label">Looking For</div>
                            <div class="info-value">{{ucfirst($member->looking_for)}}</div>
                        </div>
                        @if(!empty($member->education_level))
                            <div class="info-row mb-4">
                                <div class="info-label">Education Level</div>
                                <div class="info-value">{{$member->education_level}}</div>
                            </div>
                        @endif
                        @if(!empty($member->age))
                            <div class="info-row mb-4">
                                <div class="info-label">Age</div>
                                <div class="info-value">{{$member->age}}</div>
                            </div>
                        @endif
                        @if(!empty($member->gender))
                            <div class="info-row mb-4">
                                <div class="info-label">Gender</div>
                                <div class="info-value">{{$member->gender}}</div>
                            </div>
                        @endif
                        @if(!empty($member['interests']))
                            <div class="info-row mb-4">
                                <div class="info-label">Interests</div>
                                <div class="d-flex align-items-center gap-2">
                                    @foreach($member->interests as  $interest)
                                        <span
                                            class="badge fw-normal text-bg-light rounded">{{ucfirst(str_replace('_', ' ', $interest['name'])) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <div class="info-row mb-4">
                            <div class="info-label">Status</div>
                            <div class="info-value">
                                <span
                                    class="badge {{ $member->status === App\Enum\MemberStatus::ACTIVE->value ? 'bg-label-success' : 'bg-label-danger' }}">{{ucfirst($member->status)}}
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
            console.log(id, type)
            // Customize the confirmation message based on the action type
            let title = type === 'active' ? "Confirm Activation" : "Confirm Blocking";
            let text = type === 'active'
                ? "Are you sure you want to active this user?"
                : "Are you sure you want to block this user?";
            let confirmBtnText = type === 'active'
                ? "Yes, active it!"
                : "Yes, block it!";

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
                        url: '/member-profile/status/' + id,
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
