<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;

class GradeController extends Controller
{
    
    public function index()
    {
        $grades = Grade::all();
        $totalCreditHours = $grades->sum('credit_hours');
        $gpa = $grades->sum(fn($g) => $g->grade * $g->credit_hours) / max($totalCreditHours, 1);

        return view('grades.index', compact('grades', 'totalCreditHours', 'gpa'));
    }

   
    public function create()
    {
        return view('grades.create');
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'course_name' => 'required|string|max:255',
            'course_code' => 'required|string|max:255|unique:grades',
            'credit_hours' => 'required|integer|min:1',
            'grade' => 'required|numeric|min:0|max:4',
            'term' => 'required|integer|min:1',
        ]);

        Grade::create($request->all());

        return redirect()->route('grades.index')->with('success', 'Grade added successfully!');
    }

    
    public function show($id)
    {
        $grade = Grade::findOrFail($id);
        return view('grades.show', compact('grade'));
    }

    
    public function edit($id)
    {
        $grade = Grade::findOrFail($id);
        return view('grades.edit', compact('grade'));
    }

   
    public function update(Request $request, $id)
    {
        $request->validate([
            'course_name' => 'required|string|max:255',
            'course_code' => 'required|string|max:255',
            'credit_hours' => 'required|integer|min:1',
            'grade' => 'required|numeric|min:0|max:4',
            'term' => 'required|integer|min:1',
        ]);

        $grade = Grade::findOrFail($id);
        $grade->update($request->all());

        return redirect()->route('grades.index')->with('success', 'Grade updated successfully!');
    }


    public function destroy($id)
    {
        $grade = Grade::findOrFail($id);
        $grade->delete();

        return redirect()->route('grades.index')->with('success', 'Grade deleted successfully!');
    }
}
