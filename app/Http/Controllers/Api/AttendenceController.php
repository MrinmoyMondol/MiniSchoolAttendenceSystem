<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AttendanceService;
use App\Http\Resources\AttendanceResource;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    protected $service;
    public function __construct(AttendanceService $service)
    {
        $this->service = $service;
    }

    public function storeBulk(Request $request)
    {
        $payload = $request->validate([
            'date' => 'required|date',
            'records' => 'required|array|min:1',
            'records.*.student_id' => 'required|integer|exists:students,id',
            'records.*.status' => 'required|in:present,absent,late',
            'records.*.note' => 'nullable|string',
        ]);
        $date = Carbon::parse($payload['date'])->toDateString();

        $records = array_map(function($r) use ($date) {
            return array_merge($r, ['date' => $date]);
        }, $payload['records']);

        $this->service->bulkRecord($records, $request->user()?->id ?? null);

        return response()->json(['message' => 'Attendance recorded successfully.']);
    }

    // optimized attendance report for a given month/class
    public function monthlyReport(Request $request)
    {
        $data = $request->validate([
            'month' => 'required|date_format:Y-m',
            'class' => 'nullable|string',
        ]);
        $report = $this->service->monthlyReport($data['month'], $data['class'] ?? null);
        return response()->json($report);
    }

    // get today's attendance with eager loading
    public function todaysAttendance()
    {
        $today = now()->toDateString();
        $attendances = Attendance::with('student')->where('date',$today)->get();
        return AttendanceResource::collection($attendances);
    }
}
