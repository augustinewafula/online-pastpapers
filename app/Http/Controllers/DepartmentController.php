<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    protected $redirectPath = 'admin/departments';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::all();
        return view('admin.departments')->with('departments',$departments);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.add_department');
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
            'name'=>'required|string|unique:departments|max:191'
        ]);

        $department = new Department();
        $department->name = $request->name;
        $department->save();

        $request->session()->flash('status', 'Department added successfully');
        return redirect($this->redirectPath);
        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $department = Department::where('slug',$slug)->first();
        return view('admin.edit_department')->with('department',$department);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $this->validate($request, [
            'name'=>'required|string|max:191'
        ]);

        $department = Department::where('slug',$slug)->first();
        $department->name = $request->name;
        $department->save();

        $request->session()->flash('status', 'Department updated successfully');
        return redirect($this->redirectPath);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $slug)
    {
        $department = Department::where('slug',$slug)->first();
        $department->delete();

        $request->session()->flash('status', 'Department deleted successfully');
        return redirect($this->redirectPath);
    }
}
