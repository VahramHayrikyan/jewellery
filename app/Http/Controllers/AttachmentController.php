<?php

namespace App\Http\Controllers;

use App\Http\Requests\Attachment\SaveRequest;
use App\Models\Attachment;
use App\Models\Product;
use App\Services\AttachmentService;
use App\Services\ProductService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends BaseController
{
    /**
     * @var AttachmentService
     */
    private AttachmentService $attachmentService;

    public function __construct(AttachmentService $attachmentService)
    {
        $this->attachmentService = $attachmentService;
    }

    public function store(SaveRequest $request, Product $product): JsonResponse
    {
        try {
            $this->attachmentService->store($request, $product);

            return $this->success($product->attachments);
        } catch (Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }

    public function destroy(Attachment $attachment): JsonResponse
    {
        Storage::delete(str_replace('storage/', '', $attachment->path));
        $attachment->delete();

        return $this->success();
    }
}
