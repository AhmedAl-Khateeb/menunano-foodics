<?php

namespace App\Http\Controllers;

use App\Http\Traits\UploadImg;
use App\Models\staff;

use Illuminate\Http\Request;

class stuffcontroller extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $staffs =staff::where('user_id', auth()->id())
        ->orderByDesc('created_at')
        ->get();

    return view('dashboard.staff.index', compact('staffs'));

    }

   /**
 * Remove the specified resource from storage.
 * @param \App\Models\staff $staff
 * @return \Illuminate\Http\Response
 */                                              //update cat
    public function create()
    {


        return view('dashboard.staff.create');


    }

    /**
      * Store a newly created resource in storage.
      * @param  App\Http\UploadImg;
      * @param \App\Models\staff $staff
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
     */

    USE UploadImg;   //  use Traits

    public function store(Request $request)
    {

        $Name=$request ->Name;


        $BirthDay=$request ->BirthDay;



        $Academic_qualification=$request ->Academic_qualification ;




        $Start_date=$request ->Start_date ;


        $End_date=$request ->End_date ;


        $Salary=$request ->Salary;


@$FILENAME= $this -> saveImage($request -> upload ,'Attachfile/staff');


    $user_id=auth()->id();

staff::create([




      'Name'=>$Name


    , 'BirthDay'=>$BirthDay



    , 'Academic_qualification'=>$Academic_qualification


    , 'Start_date'=>$Start_date


    , 'End_date'=>$End_date


    , 'attach_File'=>$FILENAME


    , 'Salary'=>$Salary

    ,'user_id'=>$user_id

      ] );



        return redirect()->route('staff.index')->with('success', 'تم الاضافة بنجاح');


   }

    /**
     * Display the specified resource.
     * @param  App\Http\UploadImg;
     * @param  int  $id
      * @param \App\Models\staff $staff
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,staff $staff)
    {


        if ($staff->user_id !== auth()->id()) abort(403);


        $staffs=$staff::where( 'id' ,$staff->id)->get();


        return view('dashboard.staff.update',compact('staffs'));


    }

    /**
     * Store a newly created resource in storage.
     * @param  App\Http\UploadImg;
      * @param \App\Models\staff $staff
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function edit(Request $request,staff $staff)
    {



    }

    /**
     * Update the specified resource in storage.
     * @param  App\Http\UploadImg;
     * @param  \Illuminate\Http\Request  $request
     * @param \App\Models\staff $staff
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    USE UploadImg;   //  use Traits

    public function update(Request $request,staff $staff)
    {



        $Name=$request ->Name;


        $BirthDay=$request ->BirthDay;



        $Academic_qualification=$request ->Academic_qualification ;


        $Start_date=$request ->Start_date ;


        $End_date=$request ->End_date   ;


        $Salary=$request ->Salary;

        $user_id=auth()->id();


@$FILENAME= $this -> saveImage($request -> upload ,'Attachfile/staff');


$staff->update([


     'Name'=>$Name


    , 'BirthDay'=>$BirthDay



    , 'Academic_qualification'=>$Academic_qualification


    , 'Start_date'=>$Start_date


    , 'End_date'=>$End_date


    , 'attach_File'=>$FILENAME



    , 'Salary'=>$Salary


     ,'user_id'=>$user_id


       ]);



return redirect()->route('staff.index')->with('success','update  sent  succefuly');

        }

    /**
 * Remove the specified resource from storage.
 * @param \App\Models\staff $staff
 * @return \Illuminate\Http\Response
 */
public function destroy(staff $staff)
{
   // dd($staff->user_id);

    if ($staff->user_id !== auth()->id()) abort(403);
     $staff->delete();
    return redirect()->route('staff.index')->with('success', 'تم الحذف بنجاح');
}





 /**
     * Remove the specified resource from storage.
     * @param  App\Http\UploadImg;
      * @param \App\Models\staff $staff
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function  Del_Bulk(Request $request,staff $staff)
    {

#for($i=0;$i<=$counter;$i++){
 //dd($request->checkbox);

    @$MainM_ID =$request->MainM_ID ;

    @$page_id=$request->page_id;

	@$_SET=$request->checkbox;

	 #@$DEL_ID=implode(",",$_SET);

box::whereIn('ID' ,$_SET)->Delete();

    @$href="MainM_ID=$MainM_ID&DELCATITEM=DELCATITEM&page_id=$page_id";

    #$DELETE="delete from box where ID IN ($DEL_ID)";

       //     #print_r($request->checkbox);
       // #	 }

     return redirect()->route('staff.index.index',[$href])->with('success','update  sent  succefuly');


    }


}


