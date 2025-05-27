<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudi;
use Illuminate\Http\Request;

class ProgramStudiController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(ProgramStudi::query())
                ->make(true);
        }

        return view('program_studi.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_program_studi' => 'required|string',
        ]);

        ProgramStudi::create($request->all());

        return response()->json(['success' => 'Program Studi Created Successfully']);
    }

    public function edit($id)
    {
        $programStudi = ProgramStudi::find($id);
        return response()->json($programStudi);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_program_studi' => 'required|string',
        ]);

        $programStudi = ProgramStudi::find($id);
        $programStudi->update($request->all());

        return response()->json(['success' => 'Program Studi Updated Successfully']);
    }

    public function destroy($id)
    {
        ProgramStudi::find($id)->delete();

        return response()->json(['success' => 'Program Studi Deleted Successfully']);
    }
}
