<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SourceForgeEditions extends Model
{   
    protected $fillable = [
        'id',
        'name',
        'code_name',
        'version',
        'release_date',
    ];

    public function downloads()
    {
        return $this->hasMany(SourceForgeDownloads::class);
    }
}
