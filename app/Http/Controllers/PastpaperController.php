<?php

namespace App\Http\Controllers;

use App\Pastpaper;
use App\Unit;
use Illuminate\Http\Request;
use App\Jobs\ExtractTextFromFile;

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
        return view('admin.pastpapers')->with('pastpapers',$pastpapers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = Unit::all();
        return view('admin.add_pastpaper')->with('units',$units);
    }

    public function search($keyword)
    {
        // check if user selected unit from dropdown, if so we can easily obtain unit code
        if (strpos($keyword, '-')) {
            $unti_code = trim(explode("-", $keyword, 2)[0]);
        }else{
            $unit = Unit::select('id','name','code')
                        ->where('name', 'like', '%'.$keyword.'%')
                        ->orWhere('code', 'like', '%'.$keyword.'%')
                        ->first();
            $unti_code = $unit->code;
        }

        $pastpapers = Pastpaper::select('units.code','units.name','pastpapers.question')
                                ->join('units','units.id','pastpapers.unit_id')
                                ->where('code',$unti_code)
                                ->get();
        return $pastpapers;
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
            'programme'=>'required|string',
            'unit'=>'required|string',
            'from'=>'required|string',
            'to'=>'required|string',
            'question'=>'required|mimes:pdf,docx|max:150000',
            'answer'=>'required_if:answer_checkbox,on|mimes:pdf,docx|max:150000'
        ]);

        $unit = Unit::where('slug',$request->unit)->first();
        
        $pastpaper = new Pastpaper();
        $pastpaper->programme = $request->programme;
        $pastpaper->unit_id = $unit->id;
        $pastpaper->question = $this->uploadFile($request->question,'question',$unit->name.'-'.$unit->code);
        if ($request->answer_checkbox) {
            $pastpaper->answer = $this->uploadFile($request->answer,'answer',$unit->name.'-'.$unit->code);
        }
        $pastpaper->to = $request->to;
        $pastpaper->from = $request->from;
        $pastpaper->save();

        $pastpaper_name = explode(".", $pastpaper->question, 2)[0];
        $pastpaper_extension = substr($pastpaper->question, strpos($pastpaper->question, ".") + 1);

        ExtractTextFromFile::dispatch($pastpaper_name,$pastpaper_extension,$pastpaper->id)
                    ->delay(now()->addSeconds(1)); 

        $request->session()->flash('status', 'Pastpaper added successfully');
        return redirect($this->redirectPath);

    }

    public function uploadFile($file,$type,$unit_name){
        // Handle file upload
        $filenameWithExt = $file->getClientOriginalName();
        //get just file name
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //get just ext
        $extension = $file->getClientOriginalExtension();
        //file name to store
        $fileNameToStore = str_replace(' ', '-', $unit_name).'-'.$type.'.'.$extension;
        //upload file
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
