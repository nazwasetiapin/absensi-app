<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    public function index()
    {
        $requests = LeaveRequest::with('user')->orderBy('created_at', 'desc')->get();
        return view('admin.leave_requests.index', compact('requests'));
    }

    public function updateStatus(Request $request, LeaveRequest $leaveRequest)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $leaveRequest->status = $request->status;
        $leaveRequest->save();

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }
}
