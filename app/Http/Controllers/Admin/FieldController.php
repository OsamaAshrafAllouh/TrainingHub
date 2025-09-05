<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Field;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function __construct(){
        $this->middleware('permission:admin-field-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:admin-field-accept', ['only' => ['accept']]);
        $this->middleware('permission:admin-field-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:admin-field-delete', ['only' => ['destroy']]);
    }

    //Fields Management - display View contain all Fields or disciplines
    public function index(){
        $fields = Field::all();
        return view('Admin.FieldsManagement.index', compact('fields'));
    }

    //Fields Management - Validate & Store Field
    public function store(Request $request){
        $validator = Validator($request->all(), [
            'name' => 'required|min:3|max:50',
        ]);
        if (!$validator->fails()) {
            Field::create($request->all());
            toastr()->success('Field Created Successfully!');
        } else {
            toastr()->error($validator->getMessageBag()->first());
        }
        return redirect()->route('fields.index');
    }

    //Fields Management - Validate & Update Field
    public function update(Request $request, $id){
        $validator = Validator($request->all(), [
            'name' => 'required|min:3|max:50',
        ]);


        if (!$validator->fails()) {
            Field::query()->find($id)->update($request->all());
            toastr()->success('Field Updated Successfully!');
        } else {
            toastr()->error($validator->getMessageBag()->first());
        }
        return redirect()->route('fields.index');
    }

    //Fields Management - delete specific Field
    public function destroy($id){
        Field::findOrFail($id)->delete();
        return response()->json(['message' => 'Tier deleted.']);
    }
}
