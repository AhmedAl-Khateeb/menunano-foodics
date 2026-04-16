<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageManager
{
    public function uploadImage($path, $image, $disk = 'public')
    {
        $file_name = $this->generateImageName($image);
        $this->storeImageInLocale($image, $path, $file_name, $disk);
        return $path . '/' . $file_name;
    }

    public function deleteImage($image, $disk = 'public'): void
    {
        if ($image && Storage::disk($disk)->exists($image)) {
            Storage::disk($disk)->delete($image);
        }
    }

    public function generateImageName($image)
    {
        return time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
    }

    public function storeImageInLocale($image, $path, $file_name, $disk)
    {
        $image->storePubliclyAs($path, $file_name, $disk);
    }

    public function uploadMultiImage($path, $images, $disk = 'public')
    {
        $imagePaths = [];
        foreach ($images as $image) {
            $imageName = $this->generateImageName($image);
            $this->storeImageInLocale($image, $path, $imageName, $disk);
            $imagePaths[] = $path . '/' . $imageName;
        }
        return $imagePaths;
    }

    public function uploadPdf($path, $file, $disk = 'public')
    {
        if ($file->getClientOriginalExtension() !== 'pdf') {
            throw new \Exception('الملف المرفوع يجب أن يكون PDF فقط');
        }

        $fileName = time() . '_' . uniqid() . '.pdf';
        $file->storePubliclyAs($path, $fileName, $disk);

        return $path . '/' . $fileName;
    }
}
