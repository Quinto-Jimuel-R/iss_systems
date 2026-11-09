<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemOneHrisEmployeeInfo;

class EmployeeController extends Controller
{
    public function get_employee_details(Request $request)
    {
        $validated = $request->validate([
            'employee_no' => ['required', 'string'],
        ]);

        $employee = SystemOneHrisEmployeeInfo::with([
            'department_info',
            'section_info',
            'position_info',
        ])->where('EmpNo', $validated['employee_no'])->first();

        if (!$employee) {
            return response()->json(['message' => 'Employee not found.'], 404);
        }

        $employeeName = trim(implode(' ', array_filter([
            $employee->FirstName,
            $employee->MiddleName,
            $employee->LastName,
            $employee->Suffix,
        ])));

        return response()->json([
            'employee_name' => $employeeName,
            'department' => optional($employee->department_info)->Department,
            'section' => optional($employee->section_info)->Section,
            'position' => optional($employee->position_info)->Position,
        ]);
    }
}