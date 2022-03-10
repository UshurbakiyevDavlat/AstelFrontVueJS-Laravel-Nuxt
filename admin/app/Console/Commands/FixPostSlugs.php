<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use File;

class FixPostSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fixslug:post';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
		$values1 = File::get("database/jsons/posts.json");
		$values1 = json_decode($values1);
		$values2 = File::get("database/jsons/posts2.json");
		$values2 = json_decode($values2);
		$values = array_merge($values1, $values2);

		foreach($values as $value) {
			$post = Post::where('slug', $value->title)->orWhere('name->ru', $value->title)->update([
				'slug' => $value->id
			]);
		}

		$ids = array_map(function($post) {
			return $post->id;
		}, $values);

		$posts = Post::whereNotIn('slug', $ids)->get();
		foreach($posts as $post) {
			$post->update([
				'slug' => $post->id
			]);
		}
        return 0;
    }
}
