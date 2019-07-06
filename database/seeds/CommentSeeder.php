<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->insert([
            ['user_id'=>1, 'post_id'=>1, 'content'=>'First Commnet'],
            ['user_id'=>1, 'post_id'=>2, 'content'=>'Second Commnet'],
            ['user_id'=>1, 'post_id'=>3, 'content'=>'Third Commnet'],
        ]);
    }
}
