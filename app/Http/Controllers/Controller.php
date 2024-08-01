<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $fileName = time() . '_' . $file->getClientOriginalName();
        $res = $file->storeAs('images', $fileName);
        if ($res) return "storage/$res";
        return false;
    }
}
