<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Request\Admin\Users\StoreRequest;
use App\Http\Request\Admin\Users\EditRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use URL;

class UsersController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('cp.users.index')->with('title', 'Пользователи');
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $options = [
            'admin' => 'Админ',
            'moderator' => 'Модератор',
            'editor' => 'Редактор',
        ];

        return view('cp.users.create_edit', compact('options'))->with('title', 'Добавление пользователя');
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        User::create($request->all());

        return redirect(URL::route('cp.users.index'))->with('success', 'Информация успешно добавлена');
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
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
     * @param EditRequest $request
     * @return RedirectResponse
     */
    public function update(EditRequest $request): RedirectResponse
    {
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
    public function destroy(Request $request): void
    {
        if ($request->id != \Auth::id()) User::where('id', $request->id)->delete();
    }
}
