<?php

namespace App\Models;

use App\Models\Room;
use PhpOption\Option;
use App\Models\Category;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asset extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'assets';
    protected $guarded = ['id'];
    
    protected $fillable = [
        'category_id',
        'office',
        'location',
        'end_user',
        'serial',
        'device_name',
        'date',
        'created_by',
        'updated_by',
        'deleted_at',
    ];

    
    // relationship
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function room()
    {
        return $this->belongsTo(Room::class, 'location');
    }
    
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'office');
    }



    // accessor
    public function getCategoryNameAttribute(){
        return $this->category ? $this->category->name : null;
    }
    public function getRoomNameAttribute(){
        return $this->room ? $this->room->name : null;
    }
    public function getOfficeNameAttribute(){
        return $this->branch ? $this->branch->branch_name_en : null;
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
