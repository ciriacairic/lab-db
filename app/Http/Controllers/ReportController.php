<?php

namespace App\Http\Controllers;

use App\Models\Mongo\Comment;
use App\Models\Mongo\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->all();

        try {
            $report = Report::create($data);
        } catch (\Throwable $th) {
            return response()->json(['error' => 'Invalid request'], 400);
        }

        return response()->json(['success' => true, 'review_id' => $report->id], 201);
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
