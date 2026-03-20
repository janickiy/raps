<?php

namespace App\DTO\Admin;

use App\Http\Requests\Admin\Users\EditRequest;
use App\Http\Requests\Admin\Users\StoreRequest;

final class UserData
{
    public function __construct(
        public readonly string $name,
        public readonly string $login,
        public readonly string $role,
        public readonly ?string $password,
    ) {
    }

    public static function fromRequest(StoreRequest|EditRequest $request): self
    {
        return new self(
            name: (string) $request->string('name'),
            login: (string) $request->string('login'),
            role: (string) $request->input('role', 'editor'),
            password: $request->filled('password') ? (string) $request->string('password') : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'login' => $this->login,
            'role' => $this->role,
            'password' => $this->password,
        ], static fn (mixed $value): bool => $value !== null);
    }
}
