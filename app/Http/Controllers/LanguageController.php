<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Additional\Language;

class LanguageController extends Controller
{
  public function index()
  {
    return view('admin.languages.index');
  }

  public function create()
  {
    return view('admin.languages.create');
  }

  public function store(Request $request)
  {
    $data = array(
      'language_name' => $request->language_name,
      'language_prefix' => $request->language_prefix
    );

    Language::create($data);

    return back()->with("success", "Язык успешно добавлено!");
  }

  public function edit($id)
  {
    $lang = Language::findOrFail($id);

    return view('admin.languages.edit', compact('lang'));
  }

  public function update(Request $request, $id)
  {
    $model = Language::findOrFail($id);
    $model->language_name = $request->language_name;
    $model->language_prefix = $request->language_prefix;
    $model->update();

    return back();
  }

  public function destroy($id)
  {
    Language::findOrFail($id)->delete();

    return back();
  }

  public function setLang(Request $request)
  {
    if (Language::where('language_prefix', $request->lang)->first()) {
      request()->session()->put('locale', $request->lang);
    }
    return back();
  }
}
