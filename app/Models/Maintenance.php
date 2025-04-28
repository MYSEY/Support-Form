<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use App\Models\MaintenanceDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Maintenance extends Model
{
    use HasFactory;

    protected $table = 'maintenances';
    protected $guarded = ['id'];
    
    protected $fillable = [
        'asset_id',
        'category_id',
        'maintenance_date',
        'maintenace_by',
        'end_user',
        'description',
        'created_by',
        'updated_by',
        'deleted_at',
    ];

    public function maintenanceDetail()
    {
        return $this->hasMany(MaintenanceDetail::class, 'maintenance_id');
    }

    public function asset() {
        return $this->belongsTo(Asset::class);
    }

    public function getLifecycleMonthDiffAttribute()
    {
        $data = 0;
        $defaultMonth = 60;
        // Define the fixed date (start date)
        $startDate = Carbon::parse($this->date);
        // Get the current date
        $currentDate = Carbon::now();
        $currentMonth = $startDate->diffInMonths($currentDate);
        // Calculate the number of months between the start date and the current date
        if ($currentMonth >= 60) {
            $data = - ($currentMonth - $defaultMonth);
        }else{
            $data = $currentMonth;
        }
        return $data;
    }
}
