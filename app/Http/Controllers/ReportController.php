<?php

namespace App\Http\Controllers;

use App\Models\Mongo\Comment;
use App\Models\Mongo\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $reported_type = $request->input('reported_type', null);
        $target_id     = $request->input('target_id', null);
        $user_id       = $request->input('user_id', null);
        $reason        = $request->input('reason', null);
        $status        = $request->input('status', null);

        try {
            $report = Report::create([
                'reported_type' => $reported_type,
                'target_id'     => $target_id,
                'user_id'       => $user_id,
                'reason'        => $reason,
                'status'        => $status,
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Invalid request'], 400);
        }

        return response()->json(['success' => true, 'report_id' => $report->id], 201);
    }

    public function handle(Request $request, $report_id)
    {
        $decision = $request->input('decision');

        $report = Report::find($report_id);

        if ($report->status != 'open'){
            return response()->json(['error' => 'Invalid request'], 400);
        }

        $report->status = $decision;
        $report->save();

        return response()->json(['success' => true, 'decision' => $decision], 200);
    }

    public function destroy($report_id)
    {
        $report = Report::find($report_id);
        $report->delete();
        return response()->json(['success' => true], 200);
    }

    public function index()
    {
        $report = Report::all();
        return response()->json($report, 200);
    }
}
