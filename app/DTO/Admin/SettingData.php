<?php

namespace App\DTO\Admin;

use App\Http\Requests\Admin\Settings\EditRequest;
use App\Http\Requests\Admin\Settings\StoreRequest;

final class SettingData
{
    public function __construct(
        public readonly ?string $keyCd,
        public readonly string  $name,
        public readonly string  $type,
        public readonly ?string $displayValue,
        public readonly ?string $value,
        public readonly int     $published,
    )
    {
    }

    public static function fromRequest(StoreRequest|EditRequest $request, ?string $value = null): self
    {
        return new self(
            keyCd: $request->filled('key_cd') ? (string)$request->string('key_cd') : null,
            name: $request->filled('name') ? (string)$request->string('name') : (string)$request->string('key_cd'),
            type: strtoupper((string)$request->string('type')),
            displayValue: $request->filled('display_value') ? (string)$request->string('display_value') : null,
            value: $value ?? ($request->filled('value') ? (string)$request->string('value') : null),
            published: $request->boolean('published') ? 1 : 0,
        );
    }

    public function toArray(): array
    {
        return [
            'key_cd' => $this->keyCd,
            'name' => $this->name,
            'type' => $this->type,
            'display_value' => $this->displayValue,
            'value' => $this->value,
            'published' => $this->published,
        ];
    }
}
