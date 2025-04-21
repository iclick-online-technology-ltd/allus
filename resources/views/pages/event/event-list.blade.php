@extends('layouts.app')
@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="text-uppercase mb-0"><span class="text-muted">Event</span> <span class="mx-2">/</span> All
                Event</h5>
        </div>
    </div>

    <div class="card">
        <div class="card-datatable table-responsive">
            <table id="event_list" class="table table-striped" style="width:100%">
                <thead>
                <tr>

                    <th>Event Title</th>
                    <th>Event Date</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($events as $event)
                    <tr>
                        <td>{{$event['title']}}</td>
                        <td>{{date('d M Y h:i A', strtotime($event['date_time']))}}</td>
                        <td>{{$event['location']}}</td>
                        <td>
                            @if($event['status'] == 'pending')
                                <span class="badge rounded-pill bg-label-warning">Pending</span>
                            @elseif($event['status'] == 'approved')
                                <span class="badge rounded-pill bg-label-success">Approved</span>
                            @else
                                <span class="badge rounded-pill bg-label-danger">Rejected</span>
                            @endif

                        </td>

                        <td>
                            <a href="{{route('event.view',  $event['id'])}}"
                               title="View"
                               class="btn btn-sm btn-text-secondary rounded-pill btn-icon">
                                <i class="mdi mdi-eye-arrow-right-outline" style="color: #0a14ad;"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('#event_list').DataTable(
                {
                    dom: '<"d-flex justify-content-between"lf>rtip',
                    buttons: []
                }
            );

        });

    </script>

@endpush
