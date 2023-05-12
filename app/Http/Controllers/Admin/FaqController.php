<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Faq;
use App\Models\Hospital;
use App\Traits\IsViewModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FaqController extends Controller
{
    use IsViewModule;

    protected $module;

    public function __construct()
    {
        $this->module = "module/faq";
    }

    public function index()
    {
        $faq = Faq::all();
        return $this->module_view('list', compact('faq'));
    }

    public function create()
    {
        $doctors = Doctor::with('user')->where('is_active', true)->get();
        $hospitals = Hospital::all();
        return $this->module_view('add', compact('doctors', 'hospitals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);
        $validated['is_active'] = (bool)$request->input('is_active', 0);
        DB::beginTransaction();
        try {
            $faq = Faq::create($validated);
            if ($request->has('doctor')) {
                $insert = [];
                foreach ($request->input('doctor') as $id) {
                    $insert[] = [
                        'faq_id' => $faq->id,
                        'model' => Doctor::class,
                        'model_id' => $id
                    ];
                }
                DB::table('faq_entity')->insert($insert);
            }
            if ($request->has('hospital')) {
                $insert = [];
                foreach ($request->input('doctor') as $id) {
                    $insert[] = [
                        'faq_id' => $faq->id,
                        'model' => Doctor::class,
                        'model_id' => $id
                    ];
                }
                DB::table('faq_entity')->insert($insert);
            }
            DB::commit();
            return redirect(route('faq.index'))->with('success', "FAQ added successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage());
        }

    }

    public function show(Faq $faq)
    {
        $doctors = Doctor::with('user')->where('is_active', true)->get();
        $hospitals = Hospital::all();
        $selected_doctors = DB::table('faq_entity')
            ->where('faq_id', $faq->id)
            ->where('model', Doctor::class)
            ->get()->pluck('model_id')->toArray();
        $selected_hospitals = DB::table('faq_entity')
            ->where('faq_id', $faq->id)
            ->where('model', Hospital::class)
            ->get()->pluck('model_id')->toArray();
        return $this->module_view('edit', compact('faq', 'doctors', 'hospitals', 'selected_hospitals', 'selected_doctors'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $faq = Faq::findOrFail($id);
            $faq->question = $validated['question'];
            $faq->answer = $validated['answer'];
            $faq->save();
            if ($request->has('doctor')) {
                $insert = [];
                foreach ($request->input('doctor') as $id) {
                    $insert[] = [
                        'faq_id' => $faq->id,
                        'model' => Doctor::class,
                        'model_id' => $id
                    ];
                }
                DB::table('faq_entity')->upsert($insert, ['faq_id', 'model', 'model_id'], ['model_id']);
            }
            if ($request->has('hospital')) {
                $insert = [];
                foreach ($request->input('hospital') as $hospital_id) {
                    $insert[] = [
                        'faq_id' => $faq->id,
                        'model' => Hospital::class,
                        'model_id' => $hospital_id
                    ];
                }
                DB::table('faq_entity')->upsert($insert, ['faq_id', 'model', 'model_id'], ['model_id']);
            }
            DB::commit();
            return redirect(route('faq.index'))->with('success', "FAQ added successfully");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage());
        }
    }

    public function destroy($id)
    {
        //
    }
}
