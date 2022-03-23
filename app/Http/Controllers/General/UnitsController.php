<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use App\Models\General\Unit;
use Illuminate\Http\Request;

class UnitsController extends Controller
{

    public function index()
    {
        $units = Unit::orderby('id', 'ASC')->paginate(10);
        return view('general.pages.units.index', compact('units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $unit = new Unit();
        $unit->name = request('name');
        $unit->save();

        return redirect()->route('units-index');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        $unit = Unit::where('id', $request->id)->first();
        $unit->name = request('name');
        $unit->save();

        return redirect()->route('units-index');
    }

    public function destroy($id)
    {
        $unit = Unit::where('id', $id)->first();
        $unit->delete();
        return redirect()->route('units-index');
    }
}
