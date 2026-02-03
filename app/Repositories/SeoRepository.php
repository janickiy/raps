<?php

namespace App\Repositories;

use App\Models\Seo;
use Illuminate\Support\Facades\Cache;

class SeoRepository extends BaseRepository
{
    public function __construct(Seo $model)
    {
        parent::__construct($model);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Seo|null
     */
    public function update(int $id, array $data): ?Seo
    {
        $model = $this->model->find($id);

        if ($model) {
            $model->h1 = $data['h1'];
            $model->title = $data['title'];
            $model->keyword = $data['keyword'];
            $model->description = $data['description'];
            $model->url_canonical = $data['url_canonical'];
            $model->save();

            return $model;
        }
        return null;
    }

    /**
     * @param string $type
     * @param string $title
     * @return array
     */
    public function getSeo(string $type, string $title): array
    {
        $key = md5($type);

        if (Cache::has($key)) {
            return Cache::get($key);
        }  else {
            $seo = Seo::where('type', $type)->first();
            $title = $seo->h1 ?? $title;

            $value = [
                'meta_description' => $seo->description ?? '',
                'meta_keywords' => $seo->keyword ?? '',
                'meta_title' =>  $seo->title ?? '',
                'seo_url_canonical' => $seo->url_canonical ?? '',
                'h1' => $seo->h1 ?? $title,
                'title' => $title,
            ];

            Cache::put($key, $value);

            return $value;
        }
    }
}
