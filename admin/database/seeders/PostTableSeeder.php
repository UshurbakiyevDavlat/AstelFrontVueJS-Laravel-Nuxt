<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use File;



class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {

        // $values = File::get("database/jsons/posts.json");
        // $data = json_decode($values);

        //     foreach ($data as $d)
        //     {

        //         DB::table('posts')->updateOrInsert(
        //             array(
        //             'published_at' => $d->date,
        //             'slug' => $d->title,
        //             'name' => '{"ru":"'.$d->title . '"}',
        //             'description' => '{"ru":"'  .$d->descr. '"}',
        //             'content'=> '{"ru":"'.   $d->full_story    . '"}'

        //         ));

        //     }

        // $values2 = File::get("database/jsons/projects.json");
        // $data2 = json_decode($values2);

        //     foreach ($data2 as $d2)
        //     {

        //         DB::table('projects')->updateOrInsert(
        //             array(
        //             'published_at' => $d2->date,
        //             'slug' => $d2->title,
        //             'name' => '{"ru":"'.$d2->title . '"}',
        //             'description' => '{"ru":"'  .$d2->descr. '"}',
        //             'content'=> '{"ru":"'.   $d2->full_story    . '"}'

        //         ));

        //     }

            $values3 = File::get("database/jsons/posts2.json");
            $data3 = json_decode($values3);

                foreach ($data3 as $d3)
                {
                    /*
                        Post::updateOrCreate([
                            'published_at' => $d3->date,
                            'name' => $d3->title,
                            'description' => $d3->descr,
                            'content'=> $d3->full_story
                        ]);

                        DB::table желательно вообще не используй
                    */
                    DB::table('posts')->updateOrInsert(
                        array(
                        'published_at' => $d3->date,
                        'slug' => $d3->title,
                        'name' => '{"ru":"'.$d3->title . '"}',
                        'description' => '{"ru":"'  .$d3->descr. '"}',
                        'content'=> '{"ru":"'.   $d3->full_story    . '"}'

                    ));

                }

    }
}
