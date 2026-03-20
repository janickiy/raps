<?php

namespace App\DTO\Admin;

use App\Http\Requests\Admin\Faq\EditRequest;
use App\Http\Requests\Admin\Faq\StoreRequest;

final class FaqData
{
    public function __construct(
        public readonly string $question,
        public readonly string $answer,
    ) {
    }

    public static function fromRequest(StoreRequest|EditRequest $request): self
    {
        return new self(
            question: (string) $request->string('question'),
            answer: (string) $request->string('answer'),
        );
    }

    public function toArray(): array
    {
        return [
            'question' => $this->question,
            'answer' => $this->answer,
        ];
    }
}
