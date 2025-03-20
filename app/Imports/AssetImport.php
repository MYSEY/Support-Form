<?php

namespace App\Imports;

use App\Models\Asset;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;

class AssetImport implements ToCollection
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
                // Check if value is numeric (Excel serial date)
                if (is_numeric($item[6])) {
                    // Convert Excel date number to a proper date format
                    $date = Carbon::createFromTimestamp((($item[6] - 25569) * 86400))->format('Y-m-d');
                } else {
                    // Otherwise, parse normally
                    $date = Carbon::parse($item[6])->format('Y-m-d');
                }
                Asset::firstOrCreate([
                    'serial' => $item[0],
                    'category_id'  => $item[1] ?? "",
                    'device_name'  => $item[2],
                    'office'  => $item[3],
                    'location'  => $item[4],
                    'end_user'  => $item[5],
                    'date'  => $date,
                    'created_by'  => Auth::user()->id,
                ]);
            }
        }
    }
}
