<?php

namespace App\Http\Controllers\Designation;

use App\Http\Controllers\Controller;
use App\Http\Requests\Designation\StoreDesignationRequest;
use App\Http\Requests\Designation\UpdateDesignationRequest;
use App\Models\Designation;
use App\Services\DesignationService;

class DesignationController extends Controller
{
    public function __construct(private DesignationService $designationService) {}

    public function index()
    {
        $designations = Designation::all();

        return view('designations.index', compact('designations'));
    }

    public function create()
    {
        return view('designations.create');
    }

    public function store(StoreDesignationRequest $request)
    {
        $designation = $this->designationService->store($request->validated());

        return redirect()->route('designations.index')->with('status', __('messages.designations.create_success', ['name' => $designation->name]));
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Designation $designation)
    {
        return view('designations.edit', compact('designation'));
    }

    public function update(Designation $designation, UpdateDesignationRequest $request)
    {
        $designation = $this->designationService->update($designation, $request->validated());

        return redirect()->route('designations.index')->with('status', __('messages.designations.update_sucess', ['name' => $designation->name]));
    }

    public function destroy(string $id)
    {
        //
    }
}
