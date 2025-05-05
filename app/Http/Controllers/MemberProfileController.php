<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MemberProfileController extends Controller
{
    public function index()
    {
        $members = User::select(['id', 'username', 'email', 'gender', 'status'])->get();

        return view('pages.member-profile.member-profile-list', compact('members'));
    }

    public function view($id)
    {
        $member = User::find($id);

        return view('pages.member-profile.view-members', compact('member'));
    }

    public function updateStatus($id, Request $request)
    {
        $type = $request->type;
        $member = User::find($id);
        $member->update([
            'status' => $type,
        ]);

        return response()->json(['success' => true]);
    }
}
