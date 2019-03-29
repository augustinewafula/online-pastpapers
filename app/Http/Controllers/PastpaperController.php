<?php

namespace App\Http\Controllers;

use App\Pastpaper;
use Illuminate\Http\Request;

class PastpaperController extends Controller
{
    protected $redirectPath = 'admin/pastpapers';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pastpapers = Pastpaper::all();
        return view('admin.pastpapers')->with('pastpapers',$pastpapers);;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.add_pastpaper');
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
            'department'=>'required|string',
            'programme'=>'required|string',
            'unit_name'=>'required|string',
            'unit_code'=>'required|string',
            'question'=>'required|mimes:pdf|max:150000',
            'answer'=>'required_if:answer_checkbox,on|mimes:pdf|max:150000',

        ]); 
        
        $pastpaper = new Pastpaper();
        $pastpaper->department = $request->department;
        $pastpaper->programme = $request->programme;
        $pastpaper->unit_name = $request->unit_name;
        $pastpaper->unit_code = $request->unit_code;
        $pastpaper->question = $this->uploadFile($request->question,'question',$request->unit_name.'-'.$request->unit_code);
        if ($request->answer_checkbox) {
            $pastpaper->answer = $this->uploadFile($request->answer,'answer',$request->unit_name.'-'.$request->unit_code);
        }
        $pastpaper->save();
        $request->session()->flash('status', 'Pastpaper added successfully');
        return redirect($this->redirectPath);

    }

    public function uploadFile($file,$type,$unit_name){
        // Handle newsletter upload
        $filenameWithExt = $file->getClientOriginalName();
        //get just file name
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //get just ext
        $extension = $file->getClientOriginalExtension();
        //file name to store
        $fileNameToStore = str_replace(' ', '-', $unit_name).'-.'.$type.$extension;
        //upload newsletter
        $path = $file->storeAs('storage/pastpapers',$fileNameToStore);
        return $fileNameToStore;

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pastpaper  $pastpaper
     * @return \Illuminate\Http\Response
     */
    public function show(Pastpaper $pastpaper)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pastpaper  $pastpaper
     * @return \Illuminate\Http\Response
     */
    public function edit(Pastpaper $pastpaper)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pastpaper  $pastpaper
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pastpaper $pastpaper)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pastpaper  $pastpaper
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pastpaper $pastpaper)
    {
        //
    }
}
