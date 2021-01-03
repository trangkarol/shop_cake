<?php

namespace App\Traits;

trait HandleImage
{
    public function uploadImage($file)
    {
        $fileName = null;

        if (!is_null($file)) {
			$fileExtension = $file->getClientOriginalExtension();
            $fileName = time() . "_" . rand(0,9999999) . "_" . md5(rand(0,9999999)) . "." . $fileExtension;
            //folder upload image
			$uploadPath = public_path('/upload');
            $file->move($uploadPath, $fileName);
        }

        return $fileName;
    }
}
