<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'product_id',
        'content'
    ];

    // Relationship
    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    // Method
    function getCommentAndOrderBy($paramsOrder, $curPage) {
        return $this->query()
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->join('products', 'comments.product_id', '=', 'products.id')
            ->select('comments.*', 'users.name as user_name', 'products.name as product_name')
            ->orderBy(...$paramsOrder)
            ->paginate($this->getPerPage(), ['*'], 'comments', $curPage);
    }
}
