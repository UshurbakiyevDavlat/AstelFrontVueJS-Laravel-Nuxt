<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Project;
use File;

class FixProjectSlug extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fixslug:project';

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
		$values = File::get("database/jsons/projects.json");
		$values = json_decode($values);

		foreach($values as $value) {
			$project = Project::where('slug', $value->title)->orWhere('name->ru', $value->title)->update([
				'slug' => $value->id
			]);
		}

		$ids = array_map(function($project) {
			return $project->id;
		}, $values);

		$projects = Project::whereNotIn('slug', $ids)->get();
		foreach($projects as $project) {
			$project->update([
				'slug' => $project->id
			]);
		}

        return 0;
    }
}
