<?php

namespace App\Http\Controllers\Admin;

use App\DTO\Admin\UserData;
use App\Http\Requests\Admin\Users\DeleteRequest;
use App\Http\Requests\Admin\Users\EditRequest;
use App\Http\Requests\Admin\Users\StoreRequest;
use App\Repositories\UsersRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UsersController extends Controller
{
    public function __construct(private UsersRepository $usersRepository)
    {
        parent::__construct();
    }

    public function index(): View
    {
        return view('cp.users.index')->with('title', 'Пользователи');
    }

    public function create(): View
    {
        $options = [
            'admin' => 'Админ',
            'moderator' => 'Модератор',
            'editor' => 'Редактор',
        ];

        return view('cp.users.create_edit', compact('options'))->with('title', 'Добавление пользователя');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $this->usersRepository->createFromDto(UserData::fromRequest($request));

        return redirect()->route('cp.users.index')->with('success', 'Информация успешно добавлена');
    }

    public function edit(int $id): View
    {
        $row = $this->usersRepository->find($id);

        if (!$row) {
            abort(404);
        }

        $options = [
            'admin' => 'Админ',
            'moderator' => 'Модератор',
            'editor' => 'Редактор',
        ];

        return view('cp.users.create_edit', compact('row', 'options'))->with('title', 'Редактирование пользователя');
    }

    public function update(EditRequest $request): RedirectResponse
    {
        $row = $this->usersRepository->updateFromDto($request->integer('id'), UserData::fromRequest($request));

        if (!$row) {
            abort(404);
        }

        return redirect()->route('cp.users.index')->with('success', 'Информация успешно обновлена');
    }

    public function destroy(DeleteRequest $request): void
    {
        $this->usersRepository->deleteIfNotCurrentUser($request->integer('id'), (int) Auth::id());
    }
}
