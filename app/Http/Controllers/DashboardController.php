<?php

namespace App\Http\Controllers;

use App\Enum\EventStatus;
use App\Enum\UserGender;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $genderCount = [
            'male' => User::where('gender', UserGender::MALE->value)->count(),
            'female' => User::where('gender', UserGender::FEMALE->value)->count(),
            'non-binary' => User::where('gender', UserGender::NON_BINARY->value)->count(),
        ];

        $averageAge = intval(User::whereNotNull('age')->avg('age'));
        $totalUsers = User::count();

        $totalEvent = [
            'approved' => Event::where('status', EventStatus::APPROVED->value)->count(),
            'rejected' => Event::where('status', EventStatus::REJECTED->value)->count(),
            'pending' => Event::where('status', EventStatus::PENDING->value)->count(),
        ];
        $popularEvents = Event::select('events.*', 'users.username as host_name', DB::raw('COUNT(DISTINCT event_participants.id) as participant_count'))
            ->join('users', 'events.host_id', '=', 'users.id')
            ->join('event_participants', 'events.id', '=', 'event_participants.event_id')
            ->where('events.date_time', '>=', now())
            ->groupBy('events.id', 'users.username')
            ->orderByDesc('participant_count')
            ->orderBy('events.date_time')
            ->limit(5)
            ->get();

        return view('dashboard', compact('averageAge', 'popularEvents', 'totalEvent', 'totalUsers', 'genderCount'));

    }
}
