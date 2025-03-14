<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\CategoryTask;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;

class CategoryImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        $user_id = Auth::id(); // Store the Auth ID once
        foreach ($rows as $index => $row) {
            if ($index == 0) continue; // Skip the header row
            $category = Category::firstOrCreate([
                'name'  => $row[0],
                'created_by'  => $user_id,
            ]);

            CategoryTask::create([
                'category_id' => $category->id,
                'task_id' => $row[1],
                'created_by' => $user_id,
            ]);
        }
    }
}
