<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UploadService
{
    // Giới hạn loại file
    protected $allowedImageExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    protected $allowedDocumentExtensions = ['pdf', 'xlsx', 'csv'];

    // Giới hạn dung lượng (bytes)
    protected $maxImageSize = 3 * 1024 * 1024; // 3MB 
    protected $maxDocumentSize = 10 * 1024 * 1024; // 10MB

    // Giới hạn kích thước ảnh
    protected $maxImageWidth = 1920;
    protected $maxImageHeight = 1080;

    public function handelUpload($file, $folderName, $oldFile = null)
    {
        try {
            $ext = $file->getClientOriginalExtension();
            $fileName = time() . '_' . Str::random(10) . '.' . $ext;
            
            $filePath = $file->storeAs($folderName, $fileName, 'public');

            if ($oldFile && Storage::exists($oldFile)) {
                Storage::delete($oldFile);
            }

            return $filePath;

        } catch (\Throwable $e) {
            if (isset($filePath) && Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
            throw $e;
        }
    }

    public function UploadImage($file, $folderName, $oldFile = null)
    {
        if (!$this->isImage($file)) {
            throw new \Exception('Sai định dạng ảnh');
        }

        if (!$this->checkImageSize($file)) {
            throw new \Exception('Ảnh phải có dung lượng nhỏ hơn 3MB');
        }

        // if (!$this->checkImageDimensions($file)) {
        //     throw new \Exception('Ảnh phải có kích thước không quá 1920x1080');
        // }

        return $this->handelUpload($file, $folderName, $oldFile);
    }

    public function UploadDocument($file, $folderName, $oldFile = null)
    {
        if (!$this->isDocument($file)) {
            throw new \Exception('Invalid document file');
        }

        return $this->handelUpload($file, $folderName, $oldFile);
    }

    protected function isImage($file)
    {
        return in_array(
            strtolower($file->getClientOriginalExtension()),
            $this->allowedImageExtensions
        );
    }

    protected function isDocument($file)
    {
        return in_array(
            strtolower($file->getClientOriginalExtension()),
            $this->allowedDocumentExtensions
        );
    }

    protected function checkImageSize($file)
    {
        return $file->getSize() <= $this->maxImageSize;
    }

    protected function checkImageDimensions($file)
    {
        list($width, $height) = getimagesize($file->getPathname());
        return $width <= $this->maxImageWidth && $height <= $this->maxImageHeight;
    }

    protected function checkDocumentSize($file)
    {
        return $file->getSize() <= $this->maxDocumentSize;
    }
}