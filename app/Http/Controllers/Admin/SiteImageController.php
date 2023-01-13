<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\SiteImage\StoreRequest;
use App\Http\Requests\Admin\SiteImage\UpdateRequest;
use App\Models\SiteImage;
use App\Services\SiteImageService;
use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteImageController extends AdminBaseController
{
    private SiteImageService $siteImageService;

    public function __construct(SiteImageService $siteImageService)
    {
        $this->siteImageService = $siteImageService;
    }

    public function index(): JsonResponse
    {
        $siteImages = SiteImage::all();

        return self::success($siteImages);
    }

    public function show(SiteImage $siteImage): JsonResponse
    {
        return self::success($siteImage);
    }

    public function store(StoreRequest $request): JsonResponse
    {
        $siteImage = $this->siteImageService->store($request->validated());

        return self::success($siteImage);
    }

    public function update(UpdateRequest $request, SiteImage $siteImage): JsonResponse
    {
        try {
            $siteImage = $this->siteImageService->update($request->validated(), $siteImage);

            return self::success($siteImage);
        } catch(Exception $exception) {
            return self::error($exception->getMessage());
        }
    }

    public function destroy(SiteImage $siteImage): JsonResponse
    {
        try {
            if ($siteImage->id < 7 || $siteImage->type === 'banner') throw new Exception('Only slide images can be deleted.');
            if (SiteImage::where('type', 'slide')->count() === 1) throw new Exception('You can\'t delete last slide image.');
            Storage::delete(str_replace('storage/', '', $siteImage->path));
            $siteImage->delete();

            return self::success();
        } catch(Exception $exception) {
            return self::error($exception->getMessage());
        }
    }
}
