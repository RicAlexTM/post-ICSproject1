<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request, DashboardService $dashboardService)
    {
        $user = $request->user();

        if (is_null($user->chama_id)) {
            return redirect()->back()->with('error', 'You are not assigned to any Chama.');
        }

        if ($user->role === 'treasurer') {
            $data = $dashboardService->getTreasurerData($user->chama_id);
            return view('dashboard.treasurer', $data);
        }

        // Member
        $data = $dashboardService->getMemberData($user->id, $user->chama_id);
        return view('dashboard.member', $data);
    }
}