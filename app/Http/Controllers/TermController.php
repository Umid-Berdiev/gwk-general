<?php

namespace App\Http\Controllers;

use App\Models\Additional\Language;
use App\Models\Additional\Term;
use Illuminate\Http\Request;

class TermController extends Controller
{
  public function index()
  {
    $terms = [];

    if (request()->search) {
      // dd(request()->search);
      $terms = $this->search(request()->search);
      if (count($terms) == 0) return back()->with('warning', 'Данные не найдены!');
    } else {
      $terms = Term::where("metkis.language_id", 1)
        ->select(['metkis.*', 'languages.language_prefix'])
        ->leftJoin("languages", "languages.id", "metkis.language_id")
        ->latest()
        ->paginate(20);
    }

    return view('admin.terms.index', [
      'table' => $terms,
    ]);
  }

  public function store(Request $request)
  {
    $langs = Language::all();
    $time =  time();

    foreach ($langs as $lang) {
      $term = new Term();
      $term->group_id = $time;
      $term->id_column = $request->name;
      $term->language_id = $lang->id;
      $term->save();
    }

    makeLangFiles();
    return back()->with('success', 'Термин успешно создан!');
  }

  public function update(Request $request, $term)
  {
    $term = Term::findOrFail($term);

    foreach ($request->lang_ids as $key => $lang) {
      $model = $this->getElement($term->group_id, $lang);
      $model->mark_name = $request->mark_names[$key];
      $model->update();
    }

    makeLangFiles();
    return back()->with('success', 'Термин успешно обновлен!');
  }

  public function destroy($term)
  {
    Term::where('group_id', $term)->delete();

    makeLangFiles();
    return back()->with('success', 'Термин успешно удален!');
  }

  public function search($value)
  {
    $table = [];
    $search_query = $value;

    if ($search_query) {
      $table = Term::where(function ($query) use ($search_query) {
        $query->where('id_column', 'ilike', '%' . $search_query . '%')
          ->orWhere('mark_name', 'ilike', '%' . $search_query . '%');
      })
        // ->where("metkis.language_id", 1)
        ->select(['metkis.*', 'languages.language_prefix'])
        ->leftJoin("languages", "languages.id", "metkis.language_id")
        ->latest()
        ->paginate(20);
    }

    return $table;
  }

  public static function getElement($group_id, $language_id)
  {
    $model = Term::where("group_id", $group_id)->where("language_id", $language_id)->first();
    return $model;
  }
}
