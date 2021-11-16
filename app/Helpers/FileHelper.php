<?php

namespace App\Helpers;

use Modules\Hrd\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class FileHelper
{
    public function getFileUrl($fileName, $stringFileSystem)
    {        
        if (!is_null($fileName) && !empty($fileName)) {
            
            return Storage::disk($stringFileSystem)->url($fileName);
        }

        return null;
    }
}