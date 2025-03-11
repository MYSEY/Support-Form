<?php

namespace App\Imports;

use App\Models\Task;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;

class TaskImport implements ToCollection
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
                Task::firstOrCreate([
                    'name' => $item[0],
                    'description'  => $item[1],
                    'created_by'  => Auth::user()->id,
                ]);
            }
        }
    }
}
