<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    const PATH_VIEW = 'pages.admin.user.';
    const SIDE_BAR = 'user';
    private $model;
    public function __construct()
    {
        $this->model = new User();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view(self::PATH_VIEW . 'index', [
            'title' => 'Voucher',
            'sidebar' => self::SIDE_BAR,
            'breadcrumb' => [
                ['title' => 'User', 'route' => 'user.index']
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
