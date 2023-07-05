<?php
namespace App\Traits;
use Illuminate\Database\Eloquent\Builder;

trait OnlyActive
{
    protected static function boot()
    {
        parent::boot();
        $table = ((new static)->getTable());
        static::addGlobalScope('active', function (Builder $builder) use($table) {
            $builder->where($table.'.is_active', true);
        });
    }
    
}
