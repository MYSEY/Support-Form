<?php

namespace Database\Seeders;

use App\Models\ClassificationIssue;
use Illuminate\Database\Seeder;

class ClassificationIssueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=ClassificationIssueSeeder
     *
     * @return void
     */
    public function run()
    {
        ClassificationIssue::firstOrCreate([
            'name' => 'Communitaction and Collaboration',
        ]);
        ClassificationIssue::firstOrCreate([
            'name' => 'Data',
        ]);
        ClassificationIssue::firstOrCreate([
            'name' => 'Hardware',
        ]);
        ClassificationIssue::firstOrCreate([
            'name' => 'Network and connectivity',
        ]);
        ClassificationIssue::firstOrCreate([
            'name' => 'Performance',
        ]);
        ClassificationIssue::firstOrCreate([
            'name' => 'Security',
        ]);
        ClassificationIssue::firstOrCreate([
            'name' => 'Software',
        ]);
        ClassificationIssue::firstOrCreate([
            'name' => 'User Access',
        ]);
    }
}
