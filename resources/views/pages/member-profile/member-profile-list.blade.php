@extends('layouts.app')
@section('content')
    <style>
        #statusFilter {
            min-width: 160px;

        }

        #member_list_length {
            width: 100%;
        }

    </style>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="text-uppercase mb-0"><span class="text-muted">Members</span> <span class="mx-2">/</span> All
                Members</h5>
        </div>
    </div>

    <div class="card">
        <div class="card-datatable table-responsive">
            <table id="member_list" class="table table-striped" style="width:100%">
                <thead>
                <tr>

                    <th>UserName</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($members as $member)
                    <tr>
                        <td>{{ucfirst($member['username'])}}</td>
                        <td>{{$member['email']}}</td>
                        <td>{{ucfirst($member['gender'])}}</td>
                        <td>
                            @if($member['status'] == 'active')
                                <span class="badge rounded-pill bg-label-success">Active</span>
                            @elseif($member['status'] == 'approved')
                                <span class="badge rounded-pill bg-label-primary">Approved</span>
                            @elseif($member['status'] == 'blocked')
                                <span class="badge rounded-pill bg-label-danger">Blocked</span>
                            @else
                                <span class="badge rounded-pill bg-label-warning">Deleted</span>
                            @endif

                        </td>

                        <td>
                            <a href="{{route('member-profile.view',$member['id'])}}"
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
            var table = $('#member_list').DataTable({
                dom: '<"d-flex justify-content-end align-items-center me-2"lf<"ml-2 status-filter-container">>rtip',
                columns: [
                    {width: '20%'},
                    {width: '20%'},
                    {width: '20%'},
                    {width: '20%'},
                    {width: '20%'},
                ]
            });

            // Add status filter dropdown after the search box
            $('.status-filter-container').html(`
                    <select id="statusFilter" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="Active">Active</option>
                        <option value="Blocked">Blocked</option>
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
