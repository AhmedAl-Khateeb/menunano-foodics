<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Traits\UploadImg;
use Illuminate\Http\Request;

class stuffcontroller extends Controller
{
    use UploadImg;   //  use Traits

    public function index(Request $request)
    {
        $staffs = staff::where('user_id', auth()->id())
        ->orderByDesc('created_at')
        ->paginate(10);

        return view('dashboard.staff.index', compact('staffs'));
    }

    public function create()
    {
        return redirect()->route('staff.index');
    }

    public function store(Request $request)
    {
        $FILENAME = null;

        if ($request->hasFile('upload')) {
            $FILENAME = $this->saveImage($request->file('upload'), 'Attachfile/staff');
        }

        Staff::create([
            'Name' => $request->Name,
            'Number_of_days' => $request->Number_of_days,
            'Number_of_hours' => $request->Number_of_hours,
            'mobile' => $request->mobile,
            'Start_date' => $request->Start_date,
            'End_date' => $request->End_date,
            'attach_File' => $FILENAME,
            'Salary' => $request->Salary,
            'user_id' => auth()->id(),
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

    public function edit($id)
    {
        return redirect()->route('staff.index');
    }

    public function update(Request $request, staff $staff)
    {
        $user_id = auth()->id();

        $FILENAME = $staff->attach_File;

        if ($request->hasFile('upload')) {
            $FILENAME = $this->saveImage($request->file('upload'), 'Attachfile/staff');
        }

        $staff->update([
            'Name' => $request->Name,
            'Number_of_days' => $request->Number_of_days,
            'Number_of_hours' => $request->Number_of_hours,
            'mobile' => $request->mobile,
            'Start_date' => $request->Start_date,
            'End_date' => $request->End_date,
            'attach_File' => $FILENAME,
            'Salary' => $request->Salary,
            'user_id' => $user_id,
        ]);

        return redirect()->route('staff.index')->with('success', 'updated successfully');
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
