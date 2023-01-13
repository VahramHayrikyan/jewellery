<?php

namespace App\Services;

use App\Models\SiteImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;

Class SiteImageService extends BaseService
{
    public function store(array $request)
    {
        $image = $request['image'];
        $fileName = $image->getClientOriginalName();
        $filePath = $image->storeAs('/attachments/slides', Str::random(10) . $fileName);
        return SiteImage::create([
            'type' => 'slide',
            'name' => $fileName,
            'path' => 'storage/' . $filePath,
        ]);
    }

    public function update(array $request, $siteImage)
    {
        $image = $request['image'];
        if ($siteImage->id < 7 && $siteImage->type === 'banner') {
            $fileName = $image->getClientOriginalName();
            $filePath = $image->storeAs('/attachments/banners', Str::random(10) . $fileName);
            Storage::delete(str_replace('storage/', '', $siteImage->path));//delete old image from storage
            $siteImage->update([
                'name' => $fileName,
                'path' => 'storage/' . $filePath,
            ]);

            return $siteImage;
        } else {
            throw new Exception('Only banners can be updated.');
        }



    }
}
