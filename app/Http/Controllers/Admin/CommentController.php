<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    const PATH_VIEW = 'pages.admin.comment.';
    const SIDE_BAR = 'comment';
    private $model;
    public function __construct()
    {
        $this->model = new Comment();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get Data
        $sort = request('sort');
        $curPage = request('page') ?? 1;
        if ($curPage < 1)  $curPage = 1;

        $paramsOrderBy = match ($sort) {
            'product' => ['products.name', 'asc'],
            'user' => ['users.name', 'asc'],
            'created_down' => ['created_at', 'desc'],
            'created_up' => ['created_at', 'asc'],
            default => ['id', 'desc'],
        };
        $comments = $this->model->getCommentAndOrderBy($paramsOrderBy, $curPage);
        // Pagination
        $totalPage = $comments->lastPage();
        $curPath = $comments->path() . '?' . ($sort ? "sort=$sort" : '');
        $pageArray = range(1, $totalPage);

        return view(self::PATH_VIEW . 'index', [
            'title' => 'Comment',
            'sidebar' => self::SIDE_BAR,
            'comments' => $comments,
            'totalPage' => $totalPage,
            'curPage' => $curPage,
            'curPath' => $curPath,
            'pageArray' => $pageArray,
            'sort' => $sort,
            'breadcrumb' => [
                ['title' => 'Comment', 'route' => 'comment.index']
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
        $destroy = $this->model->destroy($id);
        if ($destroy) {
            return redirect()->back()->with('success', 'Comment has been deleted');
        }
        return redirect()->back()->with('error', 'Comment failed to delete');
    }
}
