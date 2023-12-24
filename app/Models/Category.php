<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, UuidTrait;

    protected $guarded = ['id'];

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
