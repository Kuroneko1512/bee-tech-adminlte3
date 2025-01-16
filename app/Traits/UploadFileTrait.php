<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UploadFileTrait
{
    protected function handleUploadFile($request, $fieldName, $folderName, $oldFile = null)
    {
        try {
            if ($request->hasFile($fieldName)) {
                $file = $request->file($fieldName);
                $ext = $file->getClientOriginalExtension();
                $fileName = time() . '_' . Str::random(10) . '.' . $ext;

                // Lưu file vào storage/app/public/$folderName
                // $folderName đã bao gồm cả đường dẫn tùy chỉnh, ví dụ: 'upload/user'
                $filePath = $file->storeAs($folderName, $fileName, 'public');

                // Xóa file cũ nếu tồn tại
                if ($oldFile && Storage::exists($oldFile)) {
                    Storage::delete($oldFile);
                }

                // Trả về đường dẫn tương đối để lưu vào DB
                return $filePath; // Đã là đường dẫn tương đối, ví dụ: upload/user/1234567890_abcde.jpg
            }

            return $oldFile;
        } catch (\Throwable $e) {
            // Xử lý lỗi: Xóa file nếu có lỗi
            if (isset($filePath) && Storage::exists($filePath)) {
                Storage::delete($filePath);
            }
            throw $e;
        }
    }
}
