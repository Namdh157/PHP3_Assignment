<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogue extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'is_active'
    ];


    public function products() {
        return $this->hasMany(Product::class);
    }
}
