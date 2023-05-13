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
        $paths = [];
        $includedImages = !empty($input['banners']) ? explode(',', $input['banners']) : [];
        if ($request->hasFile('banners')) {
            if ($request->has('images')) {
                foreach ($request->file('images') as $file) {
                    if (in_array($file->getClientOriginalName(), $includedImages)) {
                        if (($key = array_search($file->getClientOriginalName(), $includedImages)) !== false) {
                            unset($includedImages[$key]);
                        }
                        $paths[] = $file->store('public/patient_testimony');
                    }
                }
            }
        }
        $processedInput[] = ['name' => 'banners', 'value' => impolde(',', $paths)];
        Settings::upsert($processedInput, ['name'], ['value']);
        return back()->with('success', "Settings updated");
    }
}
