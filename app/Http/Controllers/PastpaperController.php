<?php

namespace App\Http\Controllers;

use App\Pastpaper;
use App\Unit;
use App\Question;
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

        $pastpapers = Pastpaper::select('units.code','units.name as unit_name','pastpapers.name as pastpaper_name','pastpapers.from','pastpapers.to')
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
        $pastpaper_period = Date('M',strtotime($request->from)).'-to-'.Date('M-Y',strtotime($request->to));
        
        $pastpaper = new Pastpaper();
        $pastpaper->programme = $request->programme;
        $pastpaper->unit_id = $unit->id;
        $pastpaper->name = $this->uploadFile($request->question,$pastpaper_period,$unit->code.'-'.$unit->name);
        // if ($request->answer_checkbox) {
        //     $pastpaper->answer = $this->uploadFile($request->answer,'answer',$unit->name.'-'.$unit->code);
        // }
        $pastpaper->to = $request->to;
        $pastpaper->from = $request->from;
        $pastpaper->save();

        $pastpaper_name = explode(".", $pastpaper->name, 2)[0];
        $pastpaper_extension = substr($pastpaper->name, strpos($pastpaper->name, ".") + 1);

        ExtractTextFromFile::dispatch($pastpaper_name,$pastpaper_extension,$pastpaper->id)
                    ->delay(now()->addSeconds(1)); 

        $request->session()->flash('status', 'Pastpaper added successfully');
        return redirect($this->redirectPath);

    }

    public function uploadFile($file,$period,$unit_name){
        // Handle file upload
        $filenameWithExt = $file->getClientOriginalName();
        //get just file name
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //get just ext
        $extension = $file->getClientOriginalExtension();
        //file name to store
        $fileNameToStore = str_replace(' ', '-', $unit_name).'-'.$period.'.'.$extension;
        //upload file
        $path = $file->storeAs('public/pastpapers',$fileNameToStore);
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
    public function edit($id)
    {
        $units = Unit::all();
        $pastpaper = Pastpaper::find($id);

        $data = [
            'units'=>$units,
            'pastpaper'=>$pastpaper
        ];
        return view('admin.edit_pastpaper')->with($data);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pastpaper  $pastpaper
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'programme'=>'required|string',
            'unit'=>'required|string',
            'from'=>'required|string',
            'to'=>'required|string',
            'question'=>'required_if:question_checkbox,on|mimes:pdf,docx|max:150000',
            'answer'=>'required_if:answer_checkbox,on|mimes:pdf,docx|max:150000'
        ]);

        $unit = Unit::where('slug',$request->unit)->first();
        $pastpaper_period = Date('M',strtotime($request->from)).'-to-'.Date('M-Y',strtotime($request->to));
        
        $pastpaper = Pastpaper::find($id);
        
        if ($request->question_checkbox) {
            $previous_pastpaper_name = $pastpaper->name;
            $previous_pastpaper_extension = substr($previous_pastpaper_name, strpos($previous_pastpaper_name, ".") + 1);
            if ($previous_pastpaper_extension=="docx") {
                // also delete pdf file
                $previous_pastpaper_name_without_extension = explode(".", $previous_pastpaper_name, 2)[0];
                unlink(public_path('storage/pastpapers/'.$previous_pastpaper_name_without_extension.'.pdf'));
            }        
            unlink(public_path('storage/pastpapers/'.$previous_pastpaper_name));

            $pastpaper_name = explode(".", $pastpaper->name, 2)[0];
            $pastpaper_extension = substr($pastpaper->name, strpos($pastpaper->name, ".") + 1);

            ExtractTextFromFile::dispatch($pastpaper_name,$pastpaper_extension,$pastpaper->id)
                        ->delay(now()->addSeconds(1)); 
        }
        $pastpaper->programme = $request->programme;
        $pastpaper->unit_id = $unit->id;
        if ($request->question_checkbox) {
            $pastpaper->name = $this->uploadFile($request->question,$pastpaper_period,$unit->code.'-'.$unit->name);
        }
        // if ($request->answer_checkbox) {
        //     $pastpaper->answer = $this->uploadFile($request->answer,'answer',$unit->name.'-'.$unit->code);
        // }
        $pastpaper->to = $request->to;
        $pastpaper->from = $request->from;
        $pastpaper->save();

        $request->session()->flash('status', 'Pastpaper updated successfully');
        return redirect($this->redirectPath);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pastpaper  $pastpaper
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        Question::where('pastpaper_id',$id)->delete();
        $pastpaper = Pastpaper::find($id);
        $pastpaper_name = $pastpaper->name;
        $pastpaper_extension = substr($pastpaper_name, strpos($pastpaper_name, ".") + 1);

        if ($pastpaper_extension=="docx") {
            // also delete pdf file
            $pastpaper_name_without_extension = explode(".", $pastpaper_name, 2)[0];
            unlink(public_path('storage/pastpapers/'.$pastpaper_name_without_extension.'.pdf'));
        }        
        echo 'Ext: '.$pastpaper_extension;
        unlink(public_path('storage/pastpapers/'.$pastpaper_name));
        $pastpaper->delete();

        $request->session()->flash('status', 'Unit deleted successfully');
        return redirect($this->redirectPath);

    }
}
