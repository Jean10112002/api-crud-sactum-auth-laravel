<?php

namespace App\Models;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Blog extends Model
{
    use HasFactory, HasApiTokens;
    protected $table = "blogs";

    protected $fillable = [
        'userId',
        'title',
        'content',
    ];

    public $timestamps = false;
}
