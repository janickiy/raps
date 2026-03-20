<?php

namespace App\Repositories;

use App\DTO\Admin\FaqData;
use App\Models\Faq;

class FaqRepository extends BaseRepository
{
    public function __construct(Faq $model)
    {
        parent::__construct($model);
    }

    public function createFromDto(FaqData $data): Faq
    {
        /** @var Faq $faq */
        $faq = $this->model->create($data->toArray());

        return $faq;
    }

    public function updateFromDto(int $id, FaqData $data): ?Faq
    {
        $faq = $this->model->find($id);

        if (!$faq) {
            return null;
        }

        $faq->fill($data->toArray());
        $faq->save();

        return $faq;
    }

    public function remove(int $id): void
    {
        $faq = $this->model->find($id);

        if ($faq && method_exists($faq, 'remove')) {
            $faq->remove();
            return;
        }

        $faq?->delete();
    }
}
