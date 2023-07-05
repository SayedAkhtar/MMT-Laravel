<?php

namespace App\Traits;

use App\Models\User;
use App\Observers\RecordOwnerObserver;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\View\View;
use Illuminate\Support\Str;

trait IsViewModule {
    protected $module;

    public function module_view($lastPath, $dependencies = []) : View
    {
        if($lastPath[0] == '/'){
            $lastPath = substr($lastPath, 1);
        }
        $path = explode('/',$this->module);
        unset($path[0]);
        $dependencies['module'] = ucfirst((implode(' ',$path)));
        return \view($this->module.'/'.$lastPath, $dependencies);
    }
}
