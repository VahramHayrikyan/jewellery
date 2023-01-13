<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Group\SaveRequest;
use App\Models\Group;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GroupController extends AdminBaseController
{
    public function index(): JsonResponse
    {
        $groups = Group::all();

        return $this->success($groups);
    }

    public function store(SaveRequest $request): JsonResponse
    {
        $group = Group::create($request->validated());

        return $this->success($group);
    }

    public function show(Group $group): JsonResponse
    {
        return $this->success($group);
    }

    public function update(SaveRequest $request, Group $group): JsonResponse
    {
        $group->update($request->validated());

        return $this->success($group);
    }

    public function destroy(Group $group): JsonResponse
    {
        $group->delete();

        return $this->success();
    }
}
