<?php

namespace App\Traits;

use App\Models\User;
use App\Observers\RecordOwnerObserver;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\View\View;

trait isViewModule {
    protected $module = "";

    public function module_view($lastPath, $dependencies) : View
    {
        if($lastPath[0] == '/'){
            $lastPath = substr($lastPath, 1);
        }
        return \view($this->module.'/'.$lastPath, $dependencies);
    }
}