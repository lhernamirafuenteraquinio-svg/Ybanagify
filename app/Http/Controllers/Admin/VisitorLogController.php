<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisitorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;


class VisitorLogController extends Controller
{
    public function index(Request $request)
    {
        $query = VisitorLog::query();

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('ip')) {
            $query->where('ip_address', 'like', '%' . $request->ip . '%');
        }

        // Group by IP so only one row per IP
        $logs = $query->select(
                'ip_address',
                \DB::raw('MAX(created_at) as last_visit'),
                \DB::raw('GROUP_CONCAT(DISTINCT action) as actions'),
                \DB::raw('GROUP_CONCAT(DISTINCT user_agent) as user_agents')
            )
            ->groupBy('ip_address')
            ->orderByDesc('last_visit')
            ->paginate(20);

        return view('admin.visitor_logs.index', compact('logs'));
    }
}
