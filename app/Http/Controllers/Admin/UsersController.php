<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use URL;

class UsersController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('cp.users.index')->with('title', 'Пользователи');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $options = [
            'admin' => 'Админ',
            'moderator' => 'Модератор',
            'editor' => 'Редактор',
        ];

        return view('cp.users.create_edit', compact('options'))->with('title', 'Добавление пользователя');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $rules = [
            'login' => 'required|unique:users|max:255',
            'name' => 'required',
            'password' => 'required|min:6',
            'password_again' => 'required|min:6|same:password',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        User::create($request->all());

        return redirect(URL::route('cp.users.index'))->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $id)
    {
        $row = User::find($id);

        if (!$row) abort(404);

        $options = [
            'admin' => 'Админ',
            'moderator' => 'Модератор',
            'editor' => 'Редактор',
        ];

        return view('cp.users.create_edit', compact('row', 'options'))->with('title', 'Редактирование пользователя');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $rules = [
            'login' => 'required|max:255|unique:users,login,' . $request->id,
            'name' => 'required',
            'password' => 'min:6|nullable',
            'password_again' => 'min:6|same:password|nullable',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $row = User::find($request->id);

        if (!$row) abort(404);

        $row->name = $request->input('name');
        $row->login = $request->input('login');

        if (!empty($request->role)) $row->role = $request->input('role');

        if (!empty($request->password)) $row->password = $request->password;

        $row->save();

        return redirect(URL::route('cp.users.index'))->with('success', 'Информация успешно обновлена');
    }

    /**
     * @param Request $request
     */
    public function destroy(Request $request)
    {
        if ($request->id != \Auth::id()) User::where('id', $request->id)->delete();
    }
}
