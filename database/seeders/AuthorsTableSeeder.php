<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $authors = [
            ['name' => 'ادهم شرقاوي','image' => ''],
            ['name' => 'حنان لاشين','image' => ''],
            ['name' => 'اسلام جمال','image' => '']
        ];

        foreach ($authors as $author) {

            Author::create($author);

        }//end of for each


    }//end of run

}//end of seeder
