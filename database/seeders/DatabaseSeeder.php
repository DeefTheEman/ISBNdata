<?php

namespace Database\Seeders;

use App\Models\Edit;
use App\Models\User;
use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // $this->call(BookSeeder::class);
        DB::table('edits')->insert([
            [
                'book_id' => 9789000306244,
                'version' => 1,
                'field' => 'maintitle',
                'value' => 'test 1',
                'archived' => 0,
            ],
            [
                'book_id' => 9789000306244,
                'version' => 2,
                'field' => 'maintitle',
                'value' => 'test 2',
                'archived' => 0,
            ],
            [
                'book_id' => 9789000306244,
                'version' => 1,
                'field' => 'pagecount',
                'value' => '2',
                'archived' => 0,
            ],
            [
                'book_id' => 9789000306244,
                'version' => 3,
                'field' => 'pagecount',
                'value' => '500',
                'archived' => 0,
            ]
        //     $table->id();
        //     $table->bigInteger('book_id');
        //     $table->integer('version');
        //     $table->string('field');
        //     $table->text('value');
        //     $table->boolean('archived');
        //     $table->timestamps();
        ]);
    }
}