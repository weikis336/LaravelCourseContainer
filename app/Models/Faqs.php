<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faqs extends Model
{
    protected $fillable = [
        'title',
        'description',
        'lang',
    ];
    protected function casts(): array
    {
        return [
            'description' => 'string',
            'lang' => 'string',
        ];
    }
}
