<?php

namespace App\Facades\FacadesLogic;

use Illuminate\Support\Facades\Storage;

class FileHandlerLogic
{
    /**
     * @param $file
     * @return string
     */
   public function storeFile($file, $path = 'images', $extension = null, $name = null)
    {
        try {
            $newName = ($name ?? time()) . "." . ($extension ?? $file->getClientOriginalExtension());

            // نخزن الملف داخل disk = public
            $storedPath = $file->storeAs("public/$path", $newName);

            // نخزن في الداتابيز بشكل نظيف (storage/...)
            return str_replace("public/", "storage/", $storedPath);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }


    /**
     * @param $file
     * @param string $oldname
     * @return string
     */
    public function updateFile($file, string $oldname, $path = 'images', $extension = null, $name = null)
    {
        try {
            $this->deleteFile($oldname);
            return $this->storeFile($file, $path, $extension, $name);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @param string $name
     * @return bool
     */
     public function deleteFile(string $name)
    {
        try {
            // نتأكد نحول storage/ إلى public/ قبل الحذف
            $realPath = str_replace("storage/", "public/", $name);
            return Storage::delete($realPath);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }


}
