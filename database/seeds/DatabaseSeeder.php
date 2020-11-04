<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(\App\User::class, 5)->create()->each(function($user){
            $user->document()->save(factory(\App\Document::class)->make());
        });
    }
}
