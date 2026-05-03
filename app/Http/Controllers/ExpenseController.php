<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Traits\UploadImg;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\UploadImg;
     * @param Expense $expense
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    use UploadImg;   //  use Traits

   
    public function index(Request $request)
    {
        $expenses = Expense::where('user_id', auth()->id())
        ->orderByDesc('created_at')
        ->get();

        return view('dashboard.Expenses.index', compact('expenses'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */ // update cat
    public function create()
    {
        return view('dashboard.Expenses.create');
    }

    public function store(Request $request)
    {
        $expanse_name = $request->expanse_name;

        $Amount = $request->Amount;

        $Notes = $request->notes;

        @$FILENAME = $this->saveImage($request->upload, 'Attachfile/Expenses');

        $user_id = auth()->id();

        Expense::create([
            'TITLE' => $expanse_name,

            'Amount' => $Amount,

            'Notes' => $Notes,

            'attach_File' => $FILENAME,

            'user_id' => $user_id,
        ]);

        return redirect()->route('expenses.index')->with('success', 'تم الاضافة بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Http\UploadImg;
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Expense $expense)
    {
        if ($expense->user_id !== auth()->id()) {
            abort(403);
        }

        $expenses = $expense::where('id', $expense->id)->get();

        return view('dashboard.Expenses.update', compact('expenses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\UploadImg;
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Expense $expense)
    {
    }

    public function update(Request $request, Expense $expense)
    {
        $expanse_name = $request->expanse_name;

        $Amount = $request->Amount;

        $Notes = $request->notes;

        @$FILENAME = $this->saveImage($request->upload, 'Attachfile/Expenses');

        $expense->update([
            'TITLE' => $expanse_name,

            'Amount' => $Amount,

            'Notes' => $Notes,

            'attach_File' => $FILENAME,

            'user_id' => $user_id,
        ]);

        return redirect()->route('expenses.index')->with('success', 'update  sent  succefuly');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Expense $expense)
    {
        // dd($expense->user_id);

        if ($expense->user_id !== auth()->id()) {
            abort(403);
        }
        $expense->delete();

        return redirect()->route('expenses.index')->with('success', 'تم الحذف بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Http\UploadImg;
     *
     * @return \Illuminate\Http\Response
     */
    public function Del_Bulk(Request $request, Expense $expense)
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

        return redirect()->route('box.index', [$href])->with('success', 'update  sent  succefuly');
    }
}
