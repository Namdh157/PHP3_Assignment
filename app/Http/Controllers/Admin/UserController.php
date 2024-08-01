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

    public function index()
    {
        $curPage = $_GET['page'] ?? 1;
        if ($curPage < 1)  $curPage = 1;
        $users = $this->model->query()
            ->latest('id')
            ->paginate($this->model->getPerPage(), '*', 'users', $_GET['page'] ?? 1);

        // Pagination
        $totalPage = $users->lastPage();
        $curPath = $users->path();
        $pageArray = range(1, $totalPage);

        return view(self::PATH_VIEW . __FUNCTION__, [
            'title' => 'All User',
            'sidebar' => self::SIDE_BAR,
            'curPage' => $curPage,
            'users' => $users,
            'totalPage' => $totalPage,
            'curPath' => $curPath,
            'pageArray' => $pageArray,
            'breadcrumb' => [
                ['title' => 'User', 'route' => 'admin.user.index']
            ]
        ]);
    }

    public function edit(string $id)
    {
        return view(self::PATH_VIEW . 'user', [
            'title' => 'Edit User',
            'sidebar' => self::SIDE_BAR,
            'breadcrumb' => [
                ['title' => 'User', 'route' => 'admin.user.index']
            ],
            'httpReferer' => route('admin.user.index'),
            'routePostTo' => route('admin.user.update', $id),
            'user' => $this->model->find($id),
            'method' => 'PUT',
        ]);
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
