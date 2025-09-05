<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advisor;
use App\Models\Field;
use App\Models\Program;
use App\Models\Trainee;
use App\Models\TrainingProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProgramController extends Controller
{

    function __construct(){
        $this->middleware('permission:admin-program-list', ['only' => ['index']]);
        $this->middleware('permission:admin-program-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:admin-program-delete', ['only' => ['destroy']]);
        $this->middleware('permission:admin-program-create')->only(['create', 'store']);
    }
    /**
     * Display a listing of the resource.
     */

    //Program Management -  display View contain all Program with its field or disciplines
    public function index(){
        $fields = Field::all();
        $programs = Program::all();
        return view('Admin.ProgramsManagement.index', compact('programs','fields'));
    }

    //Program Management - display View contain (store new program form) all input required to add new program
    public function create(){
        $fields = Field::all();
        return view('Admin.ProgramsManagement.create', compact('fields'));

    }

    //Program Management - Validate & Store Program
    public function store(Request $request){
        $validator = Validator($request->all(), [
            'image' => 'nullable',
            'name' => 'required|string',
            'hours' => 'required|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'type' => 'required|in:free,paid',
            'price' => 'nullable|integer',
            'number' => 'required|integer',
            'duration' => 'required|in:days,weeks,months,years',
            'level' => 'required|in:beginner,intermediate,advanced',
            'language' => 'required|in:English,Arabic,French',
            'field_id' => 'required|exists:fields,id',
            'description' => 'nullable|string',
        ]);

        if (!$validator->fails()) {

            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(public_path('images'), $imageName);
                $requestData = $request->except('image');
                $requestData['image'] = $imageName;
                Program::create($requestData);
            } else {
                Program::create($request->all());
            }
            return response()->json(['message' =>  'Program Created Successfully!']);

        } else {
            return response()->json(['message' =>  $validator->getMessageBag()->first()]);
        }
    }

    //Program Management - display View contain (edit exist program form) all input required to edit new program
    public function edit($id){
        $program = Program::findOrFail($id);
        $fields = Field::all();
        $advisor = Advisor::findOrFail($program->advisor_id);
        return view('Admin.ProgramsManagement.edit', compact('program','fields','advisor'));
    }

    //Program Management - Validate & Update Program
    public function update(Request $request, $id){
        $program = Program::findOrFail($id);
        if ($request->start_date === $program->start_date && $request->end_date === $program->end_date) {
            // Start date and end date values haven't changed, no need to validate
            $validator = Validator::make($request->all(), [
                'image' => 'nullable',
                'name' => 'required|string',
                'hours' => 'required|string',
                'type' => 'required|in:free,paid',
                'price' => 'nullable|integer',
                'number' => 'required|integer',
                'duration' => 'required|in:days,weeks,months,years',
                'level' => 'required|in:beginner,intermediate,advanced',
                'language' => 'required|in:English,Arabic,French',
                'field_id' => 'required|exists:fields,id',
                'description' => 'nullable|string',
            ]);
        } else {
            // Start date or end date values have changed, perform full validation
            $validator = Validator::make($request->all(), [
                'image' => 'nullable',
                'name' => 'required|string',
                'hours' => 'required|string',
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => 'required|date|after_or_equal:start_date',
                'type' => 'required|in:free,paid',
                'price' => 'nullable|integer',
                'number' => 'required|integer',
                'duration' => 'required|in:days,weeks,months,years',
                'level' => 'required|in:beginner,intermediate,advanced',
                'language' => 'required|in:English,Arabic,French',
                'field_id' => 'required|exists:fields,id',
                'description' => 'nullable|string',
            ]);
        }


        if (!$validator->fails()) {
            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(public_path('images'), $imageName);
                $requestData = $request->except('image');
                $requestData['image'] = $imageName;
                $program->update($requestData);
            } else {
                $program->updated($request->all());
            }
            toastr()->success('Program Updated Successfully!');
        } else {
            toastr()->error($validator->getMessageBag()->first());
        }

        return redirect()->route('programs.index');
    }

    public function getAvailablePrograms(Request $request, $fieldId){
        // Fetch the available programs based on the selected field
        $programs = Program::where('field_id', $fieldId)->get();

        // Return the programs as a JSON response
        return response()->json($programs);
    }

    //Program Management - Delete Program
    public function destroy($id)
    {
        Program::findOrFail($id)->delete();
        return response()->json(['message' => 'Advisor deleted.']);
    }

    //Program Management - display advisor Program
    public function displayPrograms()
    {
        $advisorId = Advisor::where('email', Auth()->user()->email)->value('id');
        $programs = Program::where('advisor_id', $advisorId)->get();

        return view('Advisor.ProgramsManagement.index', compact('programs'));
    }



}
