<?php

namespace App\Http\Controllers;

use App\Unit;
use App\Department;
use App\Pastpaper;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    protected $redirectPath = 'admin/units';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $units = Unit::all();
        return view('admin.units')->with('units',$units);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::all();
        return view('admin.add_unit')->with('departments',$departments);
    }

    public function search($keyword)
    {
        $unit = Unit::select('id','name','code')
                    ->where('name', 'like', '%'.$keyword.'%')
                    ->orWhere('code', 'like', '%'.$keyword.'%')
                    ->get();
        return $unit;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=>'required|string|unique:units|max:191',
            'code'=>'required|string|unique:units|max:191',
            'department'=>'required|string|max:191'
        ]);

        $department = Department::where('slug',$request->department)->first();

        $unit = new Unit();
        $unit->department_id = $department->id;
        $unit->name = $request->name;
        $unit->code = $request->code;
        $unit->save();

        $request->session()->flash('status', 'Unit added successfully');
        return redirect($this->redirectPath);        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $departments = Department::all();
        $unit = Unit::where('slug',$slug)->first();
        $data=array(
            'unit'=>$unit,
            'departments'=>$departments
         );
        return view('admin.edit_unit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $this->validate($request, [
            'name'=>'required|string|max:191',
            'code'=>'required|string|max:191',
            'department'=>'required|string|max:191'
        ]);

        $department = Department::where('slug',$request->department)->first();

        $unit = Unit::where('slug',$slug)->first();
        $unit->department_id = $department->id;
        $unit->name = $request->name;
        $unit->code = $request->code;
        $unit->save();

        $request->session()->flash('status', 'Unit updated successfully');
        return redirect($this->redirectPath);     
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $slug)
    {
        $unit = Unit::where('slug',$slug)->first();
        $unit->delete();

        $request->session()->flash('status', 'Unit deleted successfully');
        return redirect($this->redirectPath);
    }
}
