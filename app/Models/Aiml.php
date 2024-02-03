<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aiml extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];

    public function Category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }


}
