<?php

use Database\Seeders\ArticleSeeder;
use Database\Seeders\ProjectSeeder;
use Database\Seeders\TagSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UserTableSeeder::class);
        $this->call(ActionTableSeeder::class);
        $this->call(ProposalsTableSeeder::class);
        $this->call(WorkTableSeeder::class);
        //$this->call(ProjectSeeder::class);
        \App\Project::factory(10)->create();
        \App\Article::factory(50)->create();
        \App\Tag::factory(5)->create();
        // $this->call(ArticleSeeder::class);
        // $this->call(TagSeeder::class);

        Model::reguard();
    }
}
