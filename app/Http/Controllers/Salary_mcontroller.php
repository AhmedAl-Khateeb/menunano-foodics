<?php

namespace App\Http\Controllers;

use App\Models\salary_m;
use App\Traits\UploadImg;
use Illuminate\Http\Request;




class Salary_mcontroller extends Controller
{
    use UploadImg;   //  use Traits

    public function index(Request $request)
    {
        $staff_id = $request->staff_id;

        $salary = salary_m::with('staff')->where('user_id', auth()->id())

        ->where('staff_id', $staff_id)->orderByDesc('created_at')
        ->get();

        //dd ($salary);

        return view('dashboard.staff.salary.index', compact('salary'));
    }

    public function create()
    {
        return view('dashboard.salary_m.create');
    }

    public function store(Request $request)
    {
        $penalties = $request->penalties;

        $Salary_advance = $request->Salary_advance;

        $Rewards = $request->Rewards;

        $staff_id = $request->staff_id;

        $user_id = auth()->id();

        salary_m::create([
            'staff_id' => $staff_id,

            'penalties' => $penalties,

            'Salary_advance' => $Salary_advance,

            'Rewards' => $Rewards,

            'user_id' => $user_id,
        ]);

        $href = "staff_id= $staff_id";

        return redirect()->route('salary_m.index', [$href])->with('success', 'تم الاضافة بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Http\UploadImg;
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, salary_m $salary_m)
    {
        if ($salary_m->user_id !== auth()->id()) {
            abort(403);
        }

        $salary = salary_m::with('staff')->where('user_id', auth()->id())->orderByDesc('created_at')
        ->get();

        return view('dashboard.staff.salary.index', compact('salary'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\UploadImg;
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, salary_m $salary_m)
    {
    }

    public function update(Request $request, salary_m $salary_m)
    {
        $penalties = $request->penalties;

        $Salary_advance = $request->Salary_advance;

        $Rewards = $request->Rewards;

        $staff_id = $request->staff_id;

        $Salary = $request->Salary;

        $user_id = auth()->id();

        $salary_m->update([
            'penalties' => $penalties,
            'Salary_advance' => $Salary_advance,
            'Rewards' => $Rewards,
            'staff_id' => $staff_id,
            'Salary' => $Salary,
            'user_id' => $user_id,
        ]);

        return redirect()->route('salary_m.index')->with('success', 'update  sent  succefuly');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(salary_m $salary_m)
    {
        // dd($salary_m->user_id);

        if ($salary_m->user_id !== auth()->id()) {
            abort(403);
        }
        $salary_m->delete();

        return redirect()->route('salary_m.index')->with('success', 'تم الحذف بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Http\UploadImg;
     *
     * @return \Illuminate\Http\Response
     */
    public function Del_Bulk(Request $request, salary_m $salary_m)
    {
        // for($i=0;$i<=$counter;$i++){
        // dd($request->checkbox);

        @$MainM_ID = $request->MainM_ID;

        @$page_id = $request->page_id;

        @$_SET = $request->checkbox;

        // @$DEL_ID=implode(",",$_SET);

        box::whereIn('ID', $_SET)->Delete();

        @$href = "MainM_ID=$MainM_ID&DELCATITEM=DELCATITEM&page_id=$page_id";

        // $DELETE="delete from box where ID IN ($DEL_ID)";

        //     #print_r($request->checkbox);
        // #	 }

        return redirect()->route('salary_m.index.index', [$href])->with('success', 'update  sent  succefuly');
    }
}
