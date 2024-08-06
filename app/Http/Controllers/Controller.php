<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Summary of uploadImage
     * @param mixed $file
     * @return bool|string
     * Return path of file if success
     */
    protected function uploadImage($file)
    {
        $fileName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
        $res = $file->storeAs('images', $fileName);
        if ($res) return "storage/$res";
        return false;
    }
}
