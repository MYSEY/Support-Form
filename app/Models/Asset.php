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
    protected $appends = ['lifecycle_month_diff'];
    protected $fillable = [
        'category_id',
        'office',
        'location',
        'end_user',
        'serial',
        'device_name',
        'date',
        'department_id',
        'created_by',
        'updated_by',
        'deleted_at',
    ];

    // relationship
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function rooms()
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
        return $this->rooms->name;
    }
    public function getOfficeNameAttribute(){
        return $this->branch ? $this->branch->branch_name_en : null;
    }
    public function getLifecycleMonthDiffAttribute()
    {
        $defaultMonth = 60;
        if (!$this->date) {
            return null;
        }
        $startDate = Carbon::parse($this->date);
        $currentMonth = $startDate->diffInMonths();
        return $currentMonth >= $defaultMonth ? -($currentMonth - $defaultMonth) : $currentMonth;
    }
}
