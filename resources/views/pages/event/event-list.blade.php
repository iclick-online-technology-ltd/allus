@extends('layouts.app')
@section('content')
    <style>
        #statusFilter {
            min-width: 160px;

        }

        #event_list_length {
            width: 100%;
        }

    </style>
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
                            @if($event['status'] == App\Enum\EventStatus::PENDING->value)
                                <span class="badge rounded-pill bg-label-warning">Pending</span>
                            @elseif($event['status'] == App\Enum\EventStatus::APPROVED->value)
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
            // Initialize DataTable
            var table = $('#event_list').DataTable({
                dom: '<"d-flex justify-content-end align-items-center me-2"lf<"ml-2 status-filter-container">>rtip',
                buttons: []
            });

            // Add status filter dropdown after the search box
            $('.status-filter-container').html(`
                <select id="statusFilter" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="Pending">Pending</option>
                    <option value="Approved">Approved</option>
                    <option value="Rejected">Rejected</option>
                </select>
            `);

            // Custom filtering function for status
            $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
                var selectedStatus = $('#statusFilter').val();
                var status = data[3]; // Status is in the 4th column (index 3)

                // If no status is selected or the status matches, return true
                if (selectedStatus === "" || status.includes(selectedStatus)) {
                    return true;
                }
                return false;
            });

            // Trigger search when status filter changes
            $('#statusFilter').on('change', function () {
                table.draw();
            });
        });
    </script>

@endpush
