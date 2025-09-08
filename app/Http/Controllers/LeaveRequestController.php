<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    public function index()
    {
        $requests = LeaveRequest::where('user_id', auth()->id())->get();
        return view('leave_requests.index', compact('requests'));
    }

    public function create()
    {
        return view('leave_requests.create');
    }

    public function store(Request $request)
    {
        $request->validate([
           'type' => 'required|in:1,2', // 1 = Izin, 2 = Cuti
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:255',
        ]);

        LeaveRequest::create([
            'user_id' => auth()->id(),
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
        ]);

        return redirect()->route('leave_requests.index')->with('success', 'Permohonan berhasil dikirim.');
    }
}
