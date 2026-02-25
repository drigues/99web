<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminActivityController extends Controller
{
    public function index(Request $request): View
    {
        $query = ActivityLog::with('admin')->latest();

        if ($action = $request->input('action')) {
            $query->where('action', $action);
        }

        if ($model = $request->input('model')) {
            $query->where('model_type', $model);
        }

        $logs = $query->limit(200)->get();

        return view('admin.atividade.index', compact('logs'));
    }
}
