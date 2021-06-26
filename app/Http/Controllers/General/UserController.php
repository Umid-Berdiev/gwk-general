<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Additional\Division;
use App\Models\Additional\Level;
use App\Models\Additional\Position;
use App\Models\Additional\Role;
use App\Models\Additional\UserAttr;
use App\Models\Additional\UzRegion;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    if (Auth::check()) {
      $users = User::where('isDeleted', false)
        ->with('level', 'user_attrs', 'role')
        ->where('user_type', 'general')
        ->latest()
        ->paginate(10);

      $positions = Position::all();
      $divisions = Division::all();
      $levels = Level::all();
      $rolls = Role::get();
      //dd($rolls);
      return view('admin.users.index')
        ->with('positions', $positions)
        ->with('divisions', $divisions)
        ->with('levels', $levels)
        ->with('users', $users)
        ->with('rolls', $rolls);
    }
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $errorMsgs = array(
      'email.unique' => 'Такой логин пользователя существует',
      'user_email.unique' => 'Такой адрес эл.почты уже существует'
    );

    $validator = Validator::make($request->all(), [
      'email' => Rule::unique('users')->where(function ($query) {
        return $query->where('isDeleted', false);
      }),
      'user_email' => Rule::unique('users')->where(function ($query) {
        return $query->where('isDeleted', false);
      })
    ], $errorMsgs);

    if ($validator->fails()) {
      return redirect(route('users.index'))->withErrors($validator);
    }

    $user = new User;

    $user = new User();
    $user->email = $request->email;
    $user->lastname = $request->lastname;
    $user->firstname = $request->firstname;
    $user->middlename = $request->middlename;
    $user->level_id = $request->level_id;
    $user->region_id = $request->regions;
    $user->user_email = $request->user_email;
    $user->password = Hash::make($request->password);
    $user->user_type = "general";
    $user->save();

    $user->assignRole($request->roll_id);


    foreach ($request->division_id as $key => $division) {
      $user_attr = new UserAttr();
      $user_attr->user_id = $user->id;
      $user_attr->minvodxoz_division_id = $division;
      $user_attr->save();
    }

    return redirect(route('users.index'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function editByAxios(Request $request)
  {
    // dd($request->all());
    $user = User::where('id', $request->get('id'))->with('level', 'user_attrs', 'roles')->first();
    $divisions = UserAttr::select('minvodxoz_division_id')->whereNotNull('minvodxoz_division_id')->where('user_id', $request->id)->pluck('minvodxoz_division_id');
    $roles = Role::all();

    return response()->json([
      "user" => $user,
      "roles" => $roles,
      "divisions" => $divisions
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request)
  {
    $user = User::findOrFail($request->get('id'));

    $user->email = $request->email;
    $user->lastname = $request->lastname;
    $user->firstname = $request->firstname;
    $user->middlename = $request->middlename;
    $user->level_id = $request->level_id;
    $user->region_id = $request->regions;
    $user->user_email = $request->user_email;
    $user->org_name = $request->get('org_name');
    $user->password = Hash::make($request->password);

    $user->save();

    $user->syncRoles($request->roll_id);

    UserAttr::where('user_id', $user->id)->delete();
    foreach ($request->division_id as $key => $division) {
      $user_attr = new UserAttr();
      $user_attr->user_id = $user->id;
      $user_attr->minvodxoz_division_id = $division;
      $user_attr->save();
    }

    return back();
  }

  public function SelectPosition(Request $request)
  {
    $positions = UserAttr::select('minvodxoz_division_id')->where('user_id', $request->id)->get();
    return $positions;
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */

  public function destroy($id)
  {
    User::where('id', $id)->update(['isDeleted' => true]);
    return redirect(route('admin'));
  }

  public function messages()
  {
    return [
      'exists' => 'Эл.почта нет в базе данных, проверте правильность ввода',
      'email' => 'Формат эл.почты, проверте правильность ввода',
      'required' => 'Обязательное поля',
    ];
  }
}
