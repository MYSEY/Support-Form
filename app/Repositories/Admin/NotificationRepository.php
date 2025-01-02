<?php

namespace App\Repositories\Admin;

use App\Models\notification;
use App\Repositories\BaseRepository;

class NotificationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [];
    protected $department_ids = [];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    public function model()
    {
        return notification::class;
    }

    public function createNotification($request){
        $item = notification::create($request);
        return $item;
    }
    public function updateNotification($request){
        $dataUpdate["is_send"] = 1;
        return notification::where('id',$request->id)->update($dataUpdate);
    }
}