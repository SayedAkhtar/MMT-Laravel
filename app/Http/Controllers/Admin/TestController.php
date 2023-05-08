<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Device\UpdateTestAPIRequest;
use App\Models\Test;
use App\Repositories\TestRepository;
use App\Traits\IsViewModule;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class TestController extends AppBaseController
{
    use IsViewModule;

    /**
     * @var TestRepository
     */
    private TestRepository $testRepository;
    protected $module;

    /**
     * @param TestRepository $testRepository
     */
    public function __construct(TestRepository $testRepository)
    {
        $this->testRepository = $testRepository;
        $this->module = "module/tests";
    }

    /**
     * Test's Listing API.
     * Limit Param: limit
     * Skip Param: skip.
     *
     * @param Request $request
     *
     * @return View
     */
    public function index(Request $request)
    {
        $tests = $this->testRepository->fetch($request);

        return $this->module_view('list', compact('tests'));
    }

    public function create()
    {
        return $this->module_view('add');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required | string | unique:tests,name'
        ]);
        try {
            $test = Test::create($data);
            return redirect(route('tests.index'))->with('success', "Test added successfully");
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(int $id)
    {
        $test = $this->testRepository->findOrFail($id);
        return $this->module_view('edit', compact('test'));
    }

    public function update(UpdateTestAPIRequest $request, int $id)
    {
        $input = $request->all();
        $test = $this->testRepository->update($input, $id);
        return back()->with('success', 'Updated successfully');
    }

    public function destroy(int $id): JsonResponse
    {
        $this->testRepository->delete($id);

        return back()->with('success', 'Test deleted successfully.');
    }
}
