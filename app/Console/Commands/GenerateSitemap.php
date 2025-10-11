<?php

namespace App\Console\Commands;

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemap extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'sitemap:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the sitemap.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $posts = Post::where('published', true)->get();
        $sitemap = Sitemap::create()->add('/');

        foreach ($posts as $post) {
            $sitemap->add(Url::create('/posts/' . $post->slug)
                ->setLastModificationDate($post->updated_at));
        }

        $sitemap->writeToFile(public_path('sitemap.xml'));
    }
}
