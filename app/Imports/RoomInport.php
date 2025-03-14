<?php

namespace App\Imports;

use App\Models\Room;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;

class RoomInport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $i = 0;
        foreach ($rows as $item) {
            $i++;
            if ($i != 1) {
                Room::firstOrCreate([
                    'name' => $item[0],
                    'created_by'  => Auth::user()->id,
                ]);
            }
        }
    }
}
