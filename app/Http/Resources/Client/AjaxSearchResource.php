<?php

namespace App\Http\Resources\Client;

use App\Http\Resources\BaseAPIResource;
use Illuminate\Http\Request;

class AjaxSearchResource extends BaseAPIResource
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        $data = json_decode($this->name, true);
        $name = $this->name;
        if(!empty($data)){
            $locale = request()->header('language') ?? (app()->getLocale()??'en') ;
            $name = $data[$locale];
        }
        return [
            'id' => (int)$this->id,
            'name' => $name,
        ];
    }
}
