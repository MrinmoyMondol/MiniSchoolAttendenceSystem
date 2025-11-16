<?php

namespace App\Services;
use App\Models\Attendence;
use App\Models\Student;
use App\Events\AttendanceRecorded;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class AttendanceService
{
    // $records: array of ['student_id' => id, 'status' => 'present', 'note' => '', 'date' => 'YYYY-MM-DD']
    public function bulkRecord(array $records, $recordedBy = null)
    {
        // minimize DB hits using transaction + upsert
        $insertData = [];
        foreach ($records as $r) {
            $insertData[] = [
                'student_id' => $r['student_id'],
                'date' => $r['date'],
                'status' => $r['status'],
                'note' => $r['note'] ?? null,
                'recorded_by' => $recordedBy,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::transaction(function() use ($insertData) {
            // Upsert to handle update/insert duplicates
            Attendence::upsert($insertData, ['student_id','date'], ['status','note','recorded_by','updated_at']);
        });

        // emit event for summary / notifications
        event(new AttendanceRecorded($insertData));

        // Clear or update cached stats
        Cache::forget('attendance:stats:'. now()->toDateString());

        return true;
    }

    // Eager loaded monthly report
    public function monthlyReport(string $month, string $class = null)
    {
        // $month format: YYYY-MM (e.g. 2025-11)
        $start = \Carbon\Carbon::createFromFormat('Y-m', $month)->startOfMonth();
        $end = $start->copy()->endOfMonth();

        $query = Student::with(['attendances' => function($q) use ($start, $end) {
            $q->whereBetween('date', [$start->toDateString(), $end->toDateString()]);
        }]);

        if ($class) $query->where('class', $class);

        $students = $query->get();

        // compute percent present per student
        $report = $students->map(function($s) use ($start, $end) {
            $totalDays = $start->diffInDays($end) + 1;
            $present = $s->attendances->where('status','present')->count();
            $absent = $s->attendances->where('status','absent')->count();
            $late = $s->attendances->where('status','late')->count();

            return [
                'student_id' => $s->student_id,
                'name' => $s->name,
                'class' => $s->class,
                'section' => $s->section,
                'present' => $present,
                'absent' => $absent,
                'late' => $late,
                'attendance_percentage' => $totalDays ? round(($present / $totalDays) * 100, 2) : 0,
            ];
        });

        return $report;
    }

    // get today's attendance stats (cache)
    public function todaysStats()
    {
        $key = 'attendance:stats:'. now()->toDateString();
        return Cache::remember($key, 60, function() {
            $date = now()->toDateString();
            $total = Attendence::where('date',$date)->count();
            $present = Attendence::where('date',$date)->where('status','present')->count();
            $absent = Attendence::where('date',$date)->where('status','absent')->count();
            $late = Attendence::where('date',$date)->where('status','late')->count();
            return compact('total','present','absent','late');
        });
    }
}
