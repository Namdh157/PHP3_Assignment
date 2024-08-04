<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerApiController extends Controller
{
    private $model;
    public function __construct(){
        $this->model = new Banner();
    }
    public function setActiveOn($id){
        $result = $this->model->setActiveOn($id);
        if(!$result){
            return response()->json([
                'error' => 'Failed to set banner active'
            ]);
        }
        return response()->json([
            'success' => 'Banner active has been change',
            'data' => $id
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
