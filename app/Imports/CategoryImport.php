<?php

namespace App\Imports;

use App\Models\Category;
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
        $i = 0;
        foreach ($rows as $item) {
            $i++;
            if ($i != 1) {
                Category::firstOrCreate([
                    'task_id' => $item[0],
                    'name'  => $item[1],
                    'created_by'  => Auth::user()->id,
                ]);
            }
        }
    }
}
