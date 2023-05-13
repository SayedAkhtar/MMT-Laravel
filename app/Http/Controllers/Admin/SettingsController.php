<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function update(Request $request)
    {
        $input = $request->all();
        unset($input['_token']);
        $processedInput = [];
        foreach ($input as $key => $val) {
            if (!empty($val)) {
                $processedInput[] = ['name' => $key, 'value' => $val];
            }
        }
        Settings::upsert($processedInput, ['name'], ['value']);
        return back()->with('success', "Settings updated");
    }
}
