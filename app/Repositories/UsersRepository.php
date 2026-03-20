<?php

namespace App\Repositories;

use App\DTO\Admin\UserData;
use App\Models\User;

class UsersRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function createFromDto(UserData $data): User
    {
        /** @var User $user */
        $user = $this->model->create($data->toArray());

        return $user;
    }

    public function updateFromDto(int $id, UserData $data): ?User
    {
        $user = $this->model->find($id);

        if (!$user) {
            return null;
        }

        $payload = $data->toArray();
        $user->name = $payload['name'];
        $user->login = $payload['login'];
        $user->role = $payload['role'];

        if (array_key_exists('password', $payload)) {
            $user->password = $payload['password'];
        }

        $user->save();

        return $user;
    }

    public function deleteIfNotCurrentUser(int $id, int $currentUserId): bool
    {
        if ($id === $currentUserId) {
            return false;
        }

        return $this->delete($id);
    }
}
