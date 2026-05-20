<?php

namespace App\Http\Controllers;

use App\Traits\UploadImg;
use App\Models\staff;
use Illuminate\Http\Request;

class stuffcontroller extends Controller
{
    use UploadImg;   //  use Traits

    public function index(Request $request)
    {
        $staffs = staff::where('user_id', auth()->id())
        ->orderByDesc('created_at')
        ->get();

        return view('dashboard.staff.index', compact('staffs'));
    }

    public function create()
    {
        return view('dashboard.staff.create');
    }

    public function store(Request $request)
    {
        $Name = $request->Name;


        $mobile=$request->mobile;


        $Number_of_days = $request->Number_of_days;

        $Number_of_hours = $request->Number_of_hours;

        $Start_date = $request->Start_date;

        $End_date = $request->End_date;

        $Salary = $request->Salary;

        @$FILENAME = $this->saveImage($request->upload, 'Attachfile/staff');

        $user_id = auth()->id();

        staff::create([
            'Name' => $Name,
            'Number_of_days' => $Number_of_days,
            'Number_of_hours' => $Number_of_hours,
            'mobile' => $mobile,
            'Start_date' => $Start_date,
            'End_date' => $End_date,
            'attach_File' => $FILENAME,
            'Salary' => $Salary,
            'user_id' => $user_id,
        ]);

        return redirect()->route('staff.index')->with('success', 'تم الاضافة بنجاح');
    }

    public function show(Request $request, staff $staff)
    {
        if ($staff->user_id !== auth()->id()) {
            abort(403);
        }

        $staffs = $staff::where('id', $staff->id)->get();

        return view('dashboard.staff.update', compact('staffs'));
    }

    public function edit(Request $request, staff $staff)
    {
    }

    public function update(Request $request, staff $staff)
    {
        $Name = $request->Name;

        $mobile=$request->mobile;

        $Number_of_days = $request->Number_of_days;

        $Number_of_hours = $request->Number_of_hours;

        $Start_date = $request->Start_date;

        $End_date = $request->End_date;

        $Salary = $request->Salary;

        $user_id = auth()->id();

        @$FILENAME = $this->saveImage($request->upload, 'Attachfile/staff');

        $staff->update([
            'Name' => $Name, 
            'Number_of_days' => $Number_of_days,
            'Number_of_hours' => $Number_of_hours,
            'mobile' => $mobile,
            'Start_date' => $Start_date, 
            'End_date' => $End_date, 
            'attach_File' => $FILENAME, 
            'Salary' => $Salary, 
            'user_id' => $user_id,
        ]);

        return redirect()->route('staff.index')->with('success', 'update  sent  succefuly');
    }

    public function destroy(staff $staff)
    {
        if ($staff->user_id !== auth()->id()) {
            abort(403);
        }
        $staff->delete();

        return redirect()->route('staff.index')->with('success', 'تم الحذف بنجاح');
    }

    public function Del_Bulk(Request $request, staff $staff)
    {
        @$MainM_ID = $request->MainM_ID;
        @$page_id = $request->page_id;
        @$_SET = $request->checkbox;

        // @$DEL_ID=implode(",",$_SET);

        box::whereIn('ID', $_SET)->Delete();

        @$href = "MainM_ID=$MainM_ID&DELCATITEM=DELCATITEM&page_id=$page_id";

        // $DELETE="delete from box where ID IN ($DEL_ID)";

        //     #print_r($request->checkbox);
        // #	 }

        return redirect()->route('staff.index.index', [$href])->with('success', 'update  sent  succefuly');
    }
}
