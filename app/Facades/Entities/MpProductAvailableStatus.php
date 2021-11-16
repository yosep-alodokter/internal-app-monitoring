<?php

namespace App\Facades\Entities;

use Modules\Master\Models\MpProductAvailableStatus as MpProductAvailableStatusModel;

class MpProductAvailableStatus
{
    /**
     * get id product available status empty 
     *
     * @return int
     *
     * @throws \QueryException
     */

    public function getIdProductAvailableStatusEmpty()
    {
        return MpProductAvailableStatusModel::where('name', 'empty')->first()->id;
    }
}