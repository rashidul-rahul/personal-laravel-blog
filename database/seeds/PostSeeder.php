<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('posts')->insert([
            ['user_id'=>1, 'title'=> 'First title', 'content'=>'First postcontent'],
            ['user_id'=>1, 'title'=> 'Second title', 'content'=>'Second postcontent'],
            ['user_id'=>1, 'title'=> 'Third title', 'content'=>'Third postcontent']
        ]);
    }
}
