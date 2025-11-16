<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Http\Resources\StudentResource;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();

        if ($request->filled('class')) {
            $query->where('class', $request->class);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('name','like',"%{$s}%")
                  ->orWhere('student_id','like',"%{$s}%");
            });
        }
        $students = $query->orderBy('name')->paginate(15);
        return StudentResource::collection($students);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'student_id' => 'required|string|max:50|unique:students,student_id',
            'class' => 'required|string|max:50',
            'section' => 'nullable|string|max:10',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('students', 'public');
        }

        $student = Student::create($data);
        return new StudentResource($student);
    }

    public function show(Student $student)
    {
        return new StudentResource($student);
    }

    public function update(Request $request, Student $student)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'student_id' => ['sometimes','required','string','max:50', Rule::unique('students')->ignore($student->id)],
            'class' => 'sometimes|required|string|max:50',
            'section' => 'nullable|string|max:10',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('students', 'public');
        }
        $student->update($data);
        return new StudentResource($student);
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return response()->noContent();
    }
}
