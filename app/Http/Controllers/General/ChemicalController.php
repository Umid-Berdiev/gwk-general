<?php

namespace App\Http\Controllers\General;

use App\Models\General\Chemicals;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChemicalController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $chemicals = Chemicals::where('isDelete', false)->orderby('id', 'ASC')->paginate(10);
    return view('general.pages.directories.chemicals', [
      'directories' => $chemicals
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $request->validate([
      'name' => 'required|unique:chemicals',
    ]);
    $chemical = new Chemicals();
    $chemical->name = $request->name;
    $chemical->save();
    return redirect(route('directories.chemicals'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function edit(Request $request)
  {
    $chemical = Chemicals::find($request->id);
    return $chemical;
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request)
  {
    $request->validate([
      'name' => 'required|unique:chemicals',
    ]);

    $chemical = Chemicals::find($request->id);
    $chemical->name = $request->name;
    $chemical->save();

    return redirect(route('directories.chemicals'));
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $chemical = Chemicals::find($id);
    $chemical->isDelete = true;
    $chemical->save();

    return redirect(route('directories.chemicals'));
  }
}
