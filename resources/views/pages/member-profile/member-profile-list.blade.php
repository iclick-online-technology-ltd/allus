@extends('layouts.app')
@section('content')
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="text-uppercase mb-0"><span class="text-muted">Members</span> <span class="mx-2">/</span> All
                Members</h5>
        </div>
    </div>

    <div class="card">
        <div class="card-datatable table-responsive">
            <table id="event_list" class="table table-striped" style="width:100%">
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
            $('#event_list').DataTable(
                {
                    dom: '<"d-flex justify-content-between"lf>rtip',
                    columns: [
                        {width: '20%'},
                        {width: '20%'},
                        {width: '20%'},
                        {width: '20%'},
                        {width: '20%'},
                    ]
                }
            );
            $('#event_list th, #event_list td').css({
                'vertical-align': 'middle',
                'text-align': 'center'
            });

        });

    </script>

@endpush
